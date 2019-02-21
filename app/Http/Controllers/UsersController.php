<?php

namespace App\Http\Controllers;

use App\AssignLessonsToReviewers;
use App\Content;
use App\Http\OwnClasses\TYPE_OF_USERS_ENUMS;
use App\School;
use App\SchoolLinkedGrads;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Input;
use Mockery\Exception;
use Session;
use Illuminate\Support\Facades\Auth;

use Permissions;
use \App\Country;
use \App\EducationLevel;

use \App\User_Linked_Countries_Permissions;
use \App\User_Linked_Grades_Permissions;
use Illuminate\Support\Facades\DB;


class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function __construct()
    {
        $this->middleware('auth');
        // $this->middleware("Permissions:users");//permissions middleware
    }


    public function homeredirect()
    {

        return redirect('/');
    }

    public function viewSpecificUsers($user_enum)
    {
        $users = null;

        if (auth()->user()->is_permission == \App\Http\OwnClasses\TYPE_OF_USERS_ENUMS::SUPER_ADMIN) {
            $users = User::where('is_permission', $user_enum)->where('school_id', null)->paginate(10);
        }
        if (auth()->user()->is_permission == \App\Http\OwnClasses\TYPE_OF_USERS_ENUMS::LEADER) {
            $users = User::whereNotIn('is_permission', [\App\Http\OwnClasses\TYPE_OF_USERS_ENUMS::SUPER_ADMIN, \App\Http\OwnClasses\TYPE_OF_USERS_ENUMS::LEADER])->where('is_permission', $user_enum)->where('school_id', null)->paginate(10);
        }


        // load the view and pass the nerds
        return View::make('admin.users.viewSpecificUsers')
            ->with('users', $users)->with('user_type', $user_enum);
    }

    public function index()
    {
        // get all the nerds
        $users = null;
        if (auth()->user()->is_permission == \App\Http\OwnClasses\TYPE_OF_USERS_ENUMS::SUPER_ADMIN) {
            $users = User::all();
        }
        if (auth()->user()->is_permission == \App\Http\OwnClasses\TYPE_OF_USERS_ENUMS::LEADER) {
            $users = User::whereNotIn('is_permission', [\App\Http\OwnClasses\TYPE_OF_USERS_ENUMS::SUPER_ADMIN, \App\Http\OwnClasses\TYPE_OF_USERS_ENUMS::LEADER])->get();
        }


        // load the view and pass the nerds
        return View::make('admin.users.index')
            ->with('users', $users);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permissionList = Permissions::PermissionsList;//get permission list to be viewed in list
        $permissionListForleader = Permissions::permissionListForleader;//get permission list to be viewed in list
        $countriesList = Country::orderBy("id", "desc")->select("id", "name")->get();

        $educationLevels = EducationLevel::where('parent_id', null)->orderBy("id", "asc")->select("id", "name")->get();

        // load the create form (app/views/nerds/create.blade.php)
        return View::make('admin.users.create', compact("permissionList", "countriesList", "educationLevels", 'permissionListForleader'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


        // validate
        // read more on validation at http://laravel.com/docs/validation


        $rules = array(
            'email' => 'bail|unique:users|email',
            "name" => "bail|min:4|max:30",
            "password" => "bail|required|min:6|max:40",
            "countriesList" => ["bail", "array", "distinct"],//array of countries ids
            "educationLevelList" => "bail|array|distinct", //array of countries levels
            "is_permission" => "bail|required"
        );


        $this->validate(\request(), $rules, [], ["countriesList[]" => "Country choice", "educationLevelList[]" => "Education choice"]);//assign aliases for the inputs names


        // process the login
        DB::transaction(function () {//start transaction

            $users = new User;//create new User model
            $users->name = Input::get('name', false); //insert from name
            $users->email = Input::get('email', false); //insert email
            $users->password = bcrypt(Input::get('password', false)); //insert password
            $users->is_permission = Input::get('is_permission', false); //insert is_permission
            $users->save();//insert


            //// create new rows for the user and insert the countries that are now related to him.
            $selectedCountries = Input::get('countriesList', false);
            if ($selectedCountries) {
                $country = new User_Linked_Countries_Permissions;

                foreach ($selectedCountries as $countryID) {//loop through each selected country id and insert

                    $country->create([
                        "country_id" => $countryID,
                        "user_id" => $users->id
                    ]);

                }
            }


            //// create new rows for the user and insert the education levels that are now related to him.
            $selectedEducationLevels = Input::get('educationLevelList', false);
            if ($selectedEducationLevels) {
                $educationLevel = new User_Linked_Grades_Permissions;


                foreach ($selectedEducationLevels as $levelID) {//loop through each selected education level id and insert

                    $educationLevel->create([
                        "educationLevel_id" => $levelID,
                        "user_id" => $users->id
                    ]);
                }
            }

        });//close transaction

        // redirect
        Session::flash('message', 'لقد تم انشاء المستخدم بنجاح');
        return Redirect::to('users');


    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {


        // get the nerd
        $users = User::find($id);

        $userRelatedCountries = User_Linked_Countries_Permissions::where("user_id", $id)->get();

        $userRelatedEducationGrades = User_Linked_Grades_Permissions::where("user_id", $id)->get();
        $userPermission = "طالب";
        if ($users->is_permission != \App\Http\OwnClasses\TYPE_OF_USERS_ENUMS::STUDENT) {
            $userPermission = Permissions::getPermissionStringByInt($users->is_permission);
        }


        // show the view and pass the nerd to it
        return View::make('admin.users.show', compact("users", "userRelatedCountries", "userRelatedEducationGrades", "userPermission"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    static function getRelatedContentsForUsers($id)
    {

        $user = User::find($id);
        $userAllRelatedContentIds = AssignLessonsToReviewers::where('user_id', $id)->get()->pluck('content_id')->toArray();


        $starton = \request('startOn');
        $endon = \request('endsOn');

        if ( isset($endon)) {
            if ( \request('endsOn') == "1") {
                return \redirect()->back();
            }
            $userAllRelatedContentIds = ContentController::toViewContentFromSpecificDateToSpecificDate($id);
        }
        $userAllRelatedContentDetails = Content::with('Country', 'grade', 'Categories', 'user')->orderBy("id", "desc")->whereIn('id', $userAllRelatedContentIds)->get();
        if ($user->is_permission == TYPE_OF_USERS_ENUMS::EDITOR) {
            $condition = ['user_id' => $id];
            $whereIn = 'where';
            $userAllRelatedContentDetails = Content::with('Country', 'grade', 'Categories', 'user')->orderBy("id", "desc")->$whereIn($condition)->get();

            if (isset($starton) || isset($endon)) {
                $userAllRelatedContentDetails = Content::with('Country', 'grade', 'Categories', 'user')->orderBy("id", "desc")->whereIn('id', $userAllRelatedContentIds)->get();

            }

        }

        $arr = [];
        foreach ($userAllRelatedContentDetails as $row) {

            if (@$_GET["content_name"]) {
                if (strstr($row->content_name, $_GET["content_name"]) == false) {
                    continue;
                }
            }
            if (@$_GET["grade"]) {

                if (strstr($row->grade->name, $_GET["grade"]) == false) {

                    continue;
                }
            }
            if (@$_GET["country"]) {
                if ($row->countries == null && $_GET["country"] != 'عام') {
                    continue;
                }

                if ($row->country) {

                    if (strstr((string)$row->country->name, (string)$_GET["country"]) == false && $row->countries != null) {
                        continue;
                    }
                }
            }
            $contentInReviewtable = AssignLessonsToReviewers::where(['content_id' => $row->id, 'user_id' => $id])->first();
            $parent = EducationLevel::where('id', $row->grade->parent_id)->first();
            $arr[] = array("ID" => htmlspecialchars($row->id, ENT_QUOTES), "Created_at" => htmlspecialchars(($user->is_permission == TYPE_OF_USERS_ENUMS::EDITOR) ? $row->created_at : $contentInReviewtable->created_at, ENT_QUOTES), "content_name" => htmlspecialchars($row->content_name, ENT_QUOTES), "grade" => htmlspecialchars($row->grade->name, ENT_QUOTES), "country" => htmlspecialchars(($row->Country) ? $row->Country->name : "عام", ENT_QUOTES), "user" => htmlspecialchars($row->user->name, ENT_QUOTES), "category" => htmlspecialchars($row->Categories->name, ENT_QUOTES), "level" => htmlspecialchars($parent->name, ENT_QUOTES));
            unset($row);
        }
        $userAllRelatedContentDetailsJson = json_encode($arr);
        if (\request('startOn') || \request('endsOn')) {

            Session::put('data', json_encode($arr));
            Session::put('startOn', \request('startOn'));
            Session::put('endsOn', \request('endsOn'));


            //session(['data' => $arr]);
            // return response()->json($arr);

            return \redirect()->back();
        }
        if (\request('form')) {
            return \redirect()->back();
        }
        return response()->json($arr);
    }

    public function edit($id)
    {
        $users = User::find($id);
        $permissionListForleader = Permissions::permissionListForleader;//get permission list to be viewed in list
        $permissionList = Permissions::PermissionsList;//get permission list to be viewed in list
        $countriesList = Country::orderBy("id", "desc")->select("id", "name")->get();//get list of countries
        $educationLevels = EducationLevel::where('parent_id', null)->orderBy("id", "asc")->select("id", "name")->get();//get list of education levels
        $userRelatedCountriesIDs = User_Linked_Countries_Permissions::select("country_id")->where("user_id", $id)->get()->pluck("country_id")->toArray();//get list of user attached countries ids
        $userRelatedEducationGradesIDs = User_Linked_Grades_Permissions::select("educationLevel_id")->where("user_id", $id)->get()->pluck("educationLevel_id")->toArray();//get list of user attached grades ids


        // show the edit form and pass the nerd
        return View::make('admin.users.edit', compact("users", "permissionList", "countriesList", "educationLevels", "userRelatedCountriesIDs", "userRelatedEducationGradesIDs", "permissionListForleader"));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $users = User::find($id);
        // validate
        $rule = 'required';
        if ($users->is_permission == \App\Http\OwnClasses\TYPE_OF_USERS_ENUMS::STUDENT) {
            $rule = '';
        }
        $rules = array(

            "name" => "bail | min:4 | max:30 | alpha_num",
            "countriesList" => ["bail", "array", "distinct", "required"],//array of countries ids
            "educationLevelList" => "bail | array|distinct | required", //array of countries levels
            "is_permission" => "bail | " . $rule
        );


        if ($request->modifyPW) {//if modify password checkbox enabled , validate password
            $rules["password"] = "bail | required | min:6 | max:40";
        }
        if ($users->email !== $request->email) {//to avoid block the same email for unique constraint , so this means don't validate if the old email is the same updated one.
            $rules["email"] = 'bail|unique:users|email';
        }

        $this->validate(request(), $rules, [], ["countriesList[]" => "Country choice", "educationLevelList[]" => "Education choice"]);//assign aliases for the inputs names


        DB::transaction(function () use ($id, $users) {//start transaction


            $users->name = Input::get('name', false); //insert from name
            $users->email = Input::get('email', false); //insert email
            if (Input::get('password')) {
                $users->password = bcrypt(Input::get('password', false));
            }
            if ($users->is_permission != \App\Http\OwnClasses\TYPE_OF_USERS_ENUMS::STUDENT) {

                $users->is_permission = Input::get('is_permission', false); //insert is_permission
            } else {
                $Student_country_id = Input::get('countriesList', false);
                $Student_grade_id = Input::get('educationLevelList', false);
                $users->student_country_id = $Student_country_id[0];
                $users->student_grade_id = $Student_grade_id[0];
            }
            $users->save();//insert
            if ($users->is_permission != \App\Http\OwnClasses\TYPE_OF_USERS_ENUMS::STUDENT) {
                User_Linked_Countries_Permissions::where("user_id", $id)->delete();//delete all countries of this user to be added again
                User_Linked_Grades_Permissions::where("user_id", $id)->delete();//delete all grades of this user to be added again

                //// create new rows for the user and insert the countries that are now related to him.
                $selectedCountries = Input::get('countriesList', false);
                $country = new User_Linked_Countries_Permissions;

                foreach ($selectedCountries as $countryID) {//loop through each selected country id and insert

                    $country->create([
                        "country_id" => $countryID,
                        "user_id" => $users->id
                    ]);

                }


                //// create new rows for the user and insert the education levels that are now related to him.
                $selectedEducationLevels = Input::get('educationLevelList', false);
                $educationLevel = new User_Linked_Grades_Permissions;


                foreach ($selectedEducationLevels as $levelID) {//loop through each selected education level id and insert

                    $educationLevel->create([
                        "educationLevel_id" => $levelID,
                        "user_id" => $users->id
                    ]);
                }
            }

        });//close transaction


        // redirect
        Session::flash('message', 'áÞÏ Êã ÊÚÏíá ÇáãÓÊÎÏã ÈäÌÇÍ');
        return Redirect::to('users');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

//    $this->middleware('permission:anuncio-manage');

//        if(Auth::user()->is_permission==0) {
        // delete
        $users = User::find($id);
        $users->delete();

        // redirect
        Session::flash('message', 'لقد تم حذف المستخدم بنجاح');
        return Redirect::to('users');
//        }
    }

    public function addSchoolCreate()
    {
        $countriesList = Country::orderBy("id", "desc")->select("id", "name")->get();
        $educationLevels = EducationLevel::where('parent_id', null)->orderBy("id", "asc")->select("id", "name")->get();//get list of education levels
        return View::make('schools.create', compact("countriesList", "educationLevels"));
    }

    public function indexAllSchools()
    {
        $schools = School::paginate(20);
        return View::make('schools.index', compact("schools"));
    }

    public function addSchoolStore()
    {

        request()->validate([
            'email' => 'required|unique:schools|email',
            "name" => "required | min:6 | max:30 | alpha_num",
            "password" => "required | min:6 | max:30",
            "address" => "required",
            "end_in" => "required | greater_than_field:starts_on | greater_than_now",
            "starts_on" => "required | greater_than_now",

            "numberOfStudents" => "required",
            "countries" => "required"


        ],
            [
                'email.required' => 'من فضلك ادخل البريد الالكترونى',
                'email.unique' => 'هذا البريد موجود بالفعل',
                'name.required' => 'من فضلك ادخل اسم المدرسة',
                'name.min' => 'اسم المدرسة يجب الا يقل عن 6 احرف',
                'name.max' => 'اسم المدرسة يجب الا يزيد عن 30 احر',
                'password.required' => 'من فضلك ادخل كلمه السر',
                'address.required' => 'من فضلك ادخل العنوان',
                'numberOfStudents.required' => 'من فضلك ادخل عدد الطلاب',
                'password.min' => 'كلمة السر يجب الاتقل عن 6 احرف',
                'password.max' => 'كلمة السر يجب الاتقل عن 30 احرف',
                'countries.required' => 'من فضلك ادخل الدولة',
                'end_in.required' => 'من فضلك ادخل تاريخ نهايه التفعيل',
                'end_in.greater_than_field' => 'من فضلك  تاريخ النهايه يحب ان يكون اكبر من تاريخ البدايه',
                'end_in.greater_than_now' => 'من فضلك  تاريخ النهايه يحب ان يكون اكبر من تاريخ اليوم',
                'starts_on.greater_than_now' => 'من فضلك  تاريخ البدايه يحب ان يكون اكبر من تاريخ اليوم',
                'starts_on.required' => 'من فضلك ادخل تاريخ بدايه التفعيل',


            ]);
        DB::transaction(function () {
            $school = new School();
            $school->name = \request('name');
            $school->email = \request('email');
            $school->address = \request('address');
            $school->numberOfStudents = \request('numberOfStudents');
            $school->start_on = \request('starts_on');
            $school->end_on = \request('end_in');
            $school->password = bcrypt(\request('password'));
            $school->countries = \request('countries');
            $school->save();
            if (\request('educationLevelList')) {
                foreach (\request('educationLevelList') as $grade) {
                    $newSchoolGrade = new SchoolLinkedGrads();
                    $newSchoolGrade->school_id = $school->id;
                    $newSchoolGrade->grade_id = $grade;
                    $newSchoolGrade->save();

                }
            }


        });
        Session::flash('message', 'لقد تم اضافة المدرسة بنجاح');
        return Redirect::to('viewAllSchools');
    }

    public function userStudent()
    {
        $countriesList = Country::orderBy("id", "desc")->select("id", "name")->get();
        $educationLevels = EducationLevel::where('parent_id', null)->orderBy("id", "asc")->select("id", "name")->get();
        return View::make('admin.users.addUser', compact('countriesList', 'educationLevels'));
    }

    public function addUserByAdmin(Request $request)
    {
        $data = request()->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|max:30',
        ], [
            'email.required' => 'من فضلك ادخل البريد الالكترونى',
            'email.unique' => 'هذا البريد موجود بالفعل',
            'name.required' => 'من فضلك ادخل اسم الطالب',
            'name.min' => 'اسم الطالب يجب الا يقل عن 6 احرف',
            'name.max' => 'اسم الطالب يجب الا يزيد عن 30 احر',
            'password.required' => 'من فضلك ادخل كلمه السر'
        ]);
        $data['student_country_id'] = \request('countriesList');
        $data['student_grade_id'] = \request('educationLevelList');
        $data['password'] = bcrypt(\request('password'));
        User::create($data);
        Session::flash('message', 'لقد تم اضافة الطالب بنجاح');
        return \redirect()->back();
    }
}
