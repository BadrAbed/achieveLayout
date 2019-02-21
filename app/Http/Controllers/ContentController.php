<?php

namespace App\Http\Controllers;

use App\AssignLessonsToReviewers;
use App\Categories;
use App\Content;
use App\ContentLearningGoal;
use App\Country;
use App\EducationLevel;
use App\Http\OwnClasses\CONTENT_FOLLOW_STATUS_ENUMS;
use App\Http\OwnClasses\Permissions;
use App\Http\OwnClasses\STUDENT_ASSIGNED_LESSON_PLANS_ENUMS;
use App\Http\OwnClasses\TYPE_OF_USERS_ENUMS;
//use App\Notifications\NewData;
use App\LearingGoal;
use App\Links;
use App\LogTime;
use App\Sound;
use App\User;
use App\Vocabulary;
use Carbon\Carbon;
use DB;
use Faker\Provider\DateTime;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;
use Input;
use Session;

class ContentController extends Controller
{

    private $userAllowedCountriesList;
    private $userAllowedGrades;

    public function __construct()
    {
        //create middleware outside the below becasue it will not work
        //create object of permissions inside middleware for 2 reasons : https://laravel-news.com/controller-construct-session-changes-in-laravel-5-3
        // 1-because it will be executed firstly. read the attached article link
        // 2-we are checking sessions inside the object which will not work because we are inside controller  ,read the attached article
        //create middleware as a closure , to be able to use the sessions inside the permissions object and to work in order , i means the auth will work firstly , then object creation

        // $this->middleware("Permissions:content");//permissions middleware

        $this->middleware(function ($request, $next) {
//because the controller will be executed before all middlewares , so we put all the script in middelware to be put in the correct queue , please read  https://laravel-news.com/controller-construct-session-changes-in-laravel-5-3
            $permissions = new Permissions("content"); //create permission object to get the allowed countries and grades of this user and then force these values on selections and validations
            $userAllowedCountriesList = collect($permissions->getAllowedCounteries())->pluck("id"); //get ids to restriect all add , edit , delete , view requests for only the allowed
            $userAllowedGrades = collect($permissions->getAllowedGrades())->pluck("id"); //get ids to restriect all add , edit , delete , view requests for only the allowed
            $this->userAllowedCountriesList = $userAllowedCountriesList;
            $this->userAllowedGrades = $userAllowedGrades;
            return $next($request);
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $contentsall = Content::with('articalnormal', 'articalstrach', 'vocab')->get();
        foreach ($contentsall as $contentsall) {

            $this->checkcomplete($contentsall->id);
        }
        // get all the nerds
        $contents = Content::with('articalnormal', 'articalstrach', 'vocab')->orderByRaw('updated_at DESC ')->where('complete', 1)->paginate(20);

        $country = Country::all();
        $editors = User::where('is_permission', TYPE_OF_USERS_ENUMS::EDITOR)->get();
        $levels = EducationLevel::with('children')->whereNull('parent_id')->get();
        $categories = Categories::with('children')->whereNull('parent_id')->get();

        // load the view and pass the nerds
        return View::make('admin.content.index')->with('contents', $contents)->with(compact('country'))->with(compact('categories'))->with(compact('editors'))->with(compact('levels'));
        //return View::make('content.index');
    }

    public function showbynumber()
    {
        // get all the nerds

        $number = request('pag_number');

        $contents = Content::with('Country', 'grade', 'Categories')->paginate($number);
        $country = Country::all();
        $categories = Categories::all();
        $grade = EducationLevel::all();
//echo $number
        // return Response::json(View::make('index', array('posts' => $contents))->render());
        return view('index')->with('contents', $contents)->with(compact('country'))->with(compact('categories'))->with(compact('grade'))->with(compact('number'));
        // return response($contents);
    }

    public function incomplete()
    {
        if (auth()->user()->is_permission == \App\Http\OwnClasses\TYPE_OF_USERS_ENUMS::EDITOR) {
            $contents = Content::with('articalnormal', 'articalstrach', 'vocab')->where(["complete" => 0, 'user_id' => auth()->id()])->orderByRaw('updated_at DESC ')->paginate(20);
        } else {
            $contents = Content::with('articalnormal', 'articalstrach', 'vocab')->where('complete', 0)->orderByRaw('updated_at DESC ')->paginate(20);
        }
        $country = Country::all();
        $categories = Categories::all();
        /*$voicereader = DB::table('voice_read_along')->select('sound_id')->get();
                    $reader_sound_id = [];
                    foreach ($voicereader as $voicereader) {
                        $reader_sound_id[] = $voicereader->sound_id;

        */
        $contentsall = Content::with('articalnormal', 'articalstrach', 'vocab')->get();
        foreach ($contentsall as $contentsall) {

            $this->checkcomplete($contentsall->id);
        }

        return view('admin.content.incomplete')->with('contents', $contents)->with(compact('country'))->with(compact('categories'));
    }

    public function checkcomplete($id)
    {

        $content = Content::with('articalnormal', 'articalstrach', 'vocab')->find($id);

        if (isset($content->articalnormal->content_id) && isset($content->articalstrach->content_id) && $content->vocab->count() > 0) {

            $content->complete = 1;
            $content->save();
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        // load the create form (app/views/nerds/create.blade.php)
        $countries = Country::whereIn("id", $this->userAllowedCountriesList)->get();
        $learingGoal = LearingGoal::all();
        $levels = EducationLevel::whereIn("id", $this->userAllowedGrades)->get();
        if ($countries->count() == 0) {
            $countries = Country::all();
        }
        if ($levels->count() == 0) {
            $levels = EducationLevel::where('parent_id', null)->get();
        }
        $main_categories_id = DB::table('categories')->where('parent_id', NULL)->get();
        $sub_categories_id = Categories::whereNotNull('parent_id')->get();
        return view('admin.content.create')->with('countries', $countries)->with('levels', $levels)->with('main_categories_id', $main_categories_id)->with('sub_categories_id', $sub_categories_id)->with(compact('learingGoal'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $learningGoals = LearingGoal::all()->pluck("id")->toArray(); //to validate the selecte options with the original

        request()->validate([
            'content_name' => 'required|max:191',
            'education_level_id' => 'required', //|in:' . implode(",", $this->userAllowedGrades->toArray()),//validate that the choice has been selected within the allowed values
            'goal_id_list' => ["bail", "array", "distinct", "required", "in:" . implode(",", $learningGoals)], //array of goals ids
            'main_categories_id' => 'required',
            'poll' => 'required|max:5000',
            'hint' => 'required|max:5000',
            'image' => 'required|mimes:jpeg,jpg,png| max:1000',
            'Lesson_image' => 'required|mimes:jpeg,jpg,png| max:1000',
            'abstract' => 'required|max:5000',
            'links.*.link' => 'required|max:191',
            'links.*.href' => array(
                'required',
                'regex:/^(https:\/\/|http:\/\/)./',
//                'regex:/^(http:\/\/|https:\/\/)?[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}(:[0-9]{1,5})?(\/.*)?$/',
                'max:600',
            ),

        ],
            ['content_name.required' => 'من فضلك ادخل اسم المحتوى',
                'content_name.max' => 'الاسم يجب الايزيد عن 191',
                'education_level_id.required' => 'من فضلك ادخل المرحله الدارسيه',

                'goal_id_list.required' => 'من فضلك ادخل ناتج التعلم ',
                'Lesson_image.required' => 'من فضلك ادخل صورة الدرس ',
                'Lesson_image.mimes' => 'من فضلك اختر صوره من نوع  jpeg او  jpg او png  ',
                'Lesson_image.max' => ' الصوره يجب ان لا تزيد عن 1 ميجا   ',
                'goal_id_list.in' => 'من فضلك ادخل ناتج تعلم صحيح',
                'main_categories_id.required' => 'من فضلك ادخل اسم التصنيف',
                'image.required' => 'من فضلك اختر صوره',
                'image.mimes' => 'من فضلك اختر صوره من نوع  jpeg او  jpg او png  ',
                'image.max' => ' الصوره يجب ان لا تزيد عن 1 ميجا   ',
                'poll.required' => 'من فضلك ادخل اسم السؤال ',
                'poll.max' => 'من فضلك اسم السؤال  يجب الايزيد 600حرف',
                'hint.required' => 'من فضلك ادخل تمهيد مختصر للسؤال القبلى ',
                'hint.max' => 'من فضلك التمهيد مختصر للسؤال القبلى  يجب الايزيد 5000حرف',
                'abstract.required' => 'من فضلك ادخل نبذه مختصره عن الدرس ',
                'abstract.max' => 'من فضلك  نبذه مختصره عن الدرس يجب الا يزيد عن 600 حرف',
                'links.*.link.required' => 'من فضلك ادخل اسم الرابط',
                'links.*.link.max' => ' من فضلك  اسم الرابط يجب الا يزيد عن 191 حرف',
                'links.*.href.required' => 'من فضلك ادخل الرابط',
                'links.*.href.max' => 'من فضلك  الرابط يجب الا يزيد عن 600 حرف',

                'links.*.href.regex' => 'من فضلك ادخل الرابط بشكل صحيح مثل https://laravel.com ']);

        DB::transaction(function () use ($request) {

            $file = $request->file('image');

            //Move Uploaded File
            $destinationPath = 'images/';
            $extension = $file->getClientOriginalExtension();
            $sha1 = sha1($file->getClientOriginalName());
            $filename = time() . "_" . $sha1 . "." . $extension;
            $file->move($destinationPath, $filename);


            $LessonImage = $request->file('Lesson_image');

            //Move Uploaded File
            $extension = $LessonImage->getClientOriginalExtension();
            $sha1 = sha1($LessonImage->getClientOriginalName());
            $LessonImagename = time() . "_" . $sha1 . "." . $extension;
            $LessonImage->move($destinationPath, $LessonImagename);

            // store

            if (Input::get('sub_categories_id') == null) {
                $Catg_id = Input::get('main_categories_id');

            }
            if (Input::get('sub_categories_id') != null && Input::get('sub_sub_categories_id') == null) {
                $Catg_id = Input::get('sub_categories_id');

            }
            if (Input::get('sub_sub_categories_id') != null) {
                $Catg_id = Input::get('sub_sub_categories_id');

            }

            $sorename = 'images/' . $filename;
            $sorename2 = 'images/' . $LessonImagename;

            $contents = new Content;
            $contents->category_id = $Catg_id;
            $contents->education_level_id = Input::get('education_level_id');
            $contents->countries = Input::get('countries');
            $contents->content_name = Input::get('content_name');
            $contents->hint = Input::get('hint');
            $contents->poll = Input::get('poll');
            $contents->cover_image = $sorename;
            $contents->lessonImage = $sorename2;
            $contents->abstract = Input::get('abstract');
//        $contents->links = Input::get('links');
            $contents->user_id = auth()->user()->id;
            $contents->save();
            $GLOBALS["contents"] = $contents;

            foreach ($request->goal_id_list as $eachGoalID) {
                //insert goals in the table of linked content goals
                $goal_linked_content = new ContentLearningGoal();
                $goal_linked_content->content_id = $contents->id;
                $goal_linked_content->goal_id = $eachGoalID;
                $goal_linked_content->save();
            }

            $data = [];
            //return $request;
            $links = $request->input('links');

//        if (is_array($links) || is_object($links)){
            foreach ($links as $link) {

                $array = array(
                    'link' => $link['link'],
                    'href' => $link['href'],
                    'content_id' => $contents->id,
                );
                array_push($data, $array);
            }

//        }
            Links::insert($data);
            $arr['name'] = $contents->content_name;
            $arr['table_name'] = 'الدروس';
            $arr['type'] = 'اضاف';
            $arr['row_id'] = $contents->id;
            LogTimeController::saveLogesTimes($arr);
            Session::put('content_id', $contents->id);
            // redirect
            Session::flash('message', 'لقد تم ادخال المحتوى بنجاح');

            // auth()->user()->notify(new NewData($contents));

        });

        return redirect('normal-artical/create/' . $GLOBALS["contents"]->id);

    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $content_id = $id;
        $content = Content::with('Links', 'articalnormal', 'articalstrach', 'vocab')->find($id);
        $vocabs = Vocabulary::where('content_id', $id)->get();
        Session::put('vocab', $vocabs);

        if (Permissions::STUDENT_PERMISSION_ENUM == auth()->user()->is_permission) {
//if student

            return Redirect::to("/student/content/poll/$content_id/0/" . STUDENT_ASSIGNED_LESSON_PLANS_ENUMS::GET_SHORT_SURVEY_TAB_ENUM);

        } else {

            return Redirect::to("/admin/content/poll/$content_id/0/" . STUDENT_ASSIGNED_LESSON_PLANS_ENUMS::GET_SHORT_SURVEY_TAB_ENUM);
        }

    }

    static function GetContentCreatorAndReviewer($content_id)
    {
        if ($content_id) {
            $content = Content::with('user')->find($content_id);
            $content_creatorAndReviewer = [];
            $content_creatorAndReviewer['editor'] = $content->user->name;
            $content_creatorAndReviewer['reviwer'] = "لايوجد";
            $content_creatorAndReviewer['questionCreator'] = "لايوجد";
            $content_creatorAndReviewer['questionReviwer'] = "لايوجد";
            $content_creatorAndReviewer['langReviewer'] = "لايوجد";
            $content_creatorAndReviewer['publisher'] = "لايوجد";
            $content_reviwer = AssignLessonsToReviewers::with('user')->where('content_id', $content_id)->where('status', \App\Http\OwnClasses\CONTENT_FOLLOW_STATUS_ENUMS::UNDER_REVIEW)->first();

            if ($content_reviwer) {
                $content_creatorAndReviewer['reviwer'] = $content_reviwer->user->name;
            }
            $content_questionCreator = AssignLessonsToReviewers::with('user')->where('content_id', $content_id)->where('status', \App\Http\OwnClasses\CONTENT_FOLLOW_STATUS_ENUMS::CREATE_QUESTIONS)->first();
            if ($content_questionCreator) {
                $content_creatorAndReviewer['questionCreator'] = $content_questionCreator->user->name;
            }
            $content_questionReviwer = AssignLessonsToReviewers::with('user')->where('content_id', $content_id)->where('status', \App\Http\OwnClasses\CONTENT_FOLLOW_STATUS_ENUMS::REVIEW_QUESTIONS)->first();
            if ($content_questionReviwer) {
                $content_creatorAndReviewer['questionReviwer'] = $content_questionReviwer->user->name;
            }
            $content_langReviewer = AssignLessonsToReviewers::with('user')->where('content_id', $content_id)->where('status', \App\Http\OwnClasses\CONTENT_FOLLOW_STATUS_ENUMS::UNDER_LANG_CORRECT)->first();
            if ($content_langReviewer) {
                $content_creatorAndReviewer['langReviewer'] = $content_langReviewer->user->name;
            }
            $content_publisher = AssignLessonsToReviewers::with('user')->where('content_id', $content_id)->where('status', \App\Http\OwnClasses\CONTENT_FOLLOW_STATUS_ENUMS::PUBLISH)->first();
            if ($content_publisher) {
                $content_creatorAndReviewer['publisher'] = $content_publisher->user->name;
            }
            return $content_creatorAndReviewer;
        }
        return 'false';

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $releted_content_goals = ContentLearningGoal::where('content_id', $id)->get()->pluck("goal_id")->toArray();
        // get the nerd
        $content = Content::with('Country', 'Links', 'grade', 'Categories', 'LearingGoal')->find($id);

        if (auth()->user()->is_permission == TYPE_OF_USERS_ENUMS::EDITOR) {
            if ($content->flowStatus != CONTENT_FOLLOW_STATUS_ENUMS::UNDER_CREATE && $content->flowStatus != CONTENT_FOLLOW_STATUS_ENUMS::REFUSED_FROM_Editor) {

                return redirect('notAllowed');
            }
        }
        Session::put('content_id', $content->id);
        $content_id = $id;
        $countries = Country::whereIn("id", $this->userAllowedCountriesList)->get();
        $learingGoal = LearingGoal::all();
        $levels = EducationLevel::whereIn("id", $this->userAllowedGrades)->get();
        $learingGoal = LearingGoal::all();
        $main_categories_id = DB::table('categories')->where('parent_id', NULL)->get();
        $sub_categories_id = Categories::whereNotNull('parent_id')->get();

        return view('admin.content.edit', compact('releted_content_goals'))->with('content', $content)->with('countries', $countries)->with('levels', $levels)->with('main_categories_id', $main_categories_id)->with('sub_categories_id', $sub_categories_id)->with(compact('learingGoal'))->with(compact('content_id'));

        // show the edit form and pass the nerd
        //return view('content.edit')->with('content', $content);
    }

    public function getctag(Request $request)
    {

        $parent_sb_id = Input::get('parent_sb_id');
        $sub_json = Categories::where('parent_id', $parent_sb_id)->get();
        return response($sub_json);

    }

    public function ajaxGetAllContent()
    {
        //$data = [];

        if (auth()->user()->is_permission == \App\Http\OwnClasses\TYPE_OF_USERS_ENUMS::EDITOR) {
            $data = Content::with('Country', 'grade', 'Categories', 'user')->orderBy("id", "desc")->where(["complete" => 1, 'user_id' => auth()->id(), 'flowStatus' => CONTENT_FOLLOW_STATUS_ENUMS::UNDER_CREATE])->get();
        } elseif (@$_GET["advancesearch"]) {
            $ff = Content::with('Country', 'grade', 'Categories', 'user')->orderBy("id", "desc")->where("complete", 1);

            $query = Content::with('Country', 'grade', 'Categories', 'user')->orderBy("id", "desc")->where("complete", 1);
            if (request('level') != null) {
                $childs_id = EducationLevel::where('parent_id', request('level'))->get()->pluck('id')->toArray();
                if (count($childs_id) > 0) {
                    $query->whereIn('education_level_id', $childs_id);
                } else
                    $query->where('education_level_id', request('level'));
            }
            if (request('category') != null) {
                $childs_id1 = Categories::where('parent_id', request('category'))->get()->pluck('id')->toArray();

                if (count($childs_id1) > 0) {

                    $childs_id2 = Categories::whereIn('parent_id', $childs_id1)->get()->pluck('id')->toArray();
                    if (count($childs_id2) > 0) {
                        $query->whereIn('category_id', $childs_id2);
                    } else {
                        $query->whereIn('category_id', $childs_id1);
                    }

                } else
                    $query->where('category_id', request('category'));
            }
            if (request('countries') != null) {

                if (request('countries') == 'general') {

                    $query->whereNull('countries');
                } else {

                    $query->where('countries', request('countries'));
                }
            }
            if (request('editor') != null)
                $query->where('user_id', request('editor'));
            if (request('start_on') != null)
                $query->whereBetween('created_at', array(date('Y-m-d', strtotime(request('start_on') . ' -1 days')) . '%', date('Y-m-d', strtotime(request('end_on') . ' + 1 days')) . '%'));

            $data = $query->get();

        } else {

            $data = Content::with('Country', 'grade', 'Categories', 'user')->orderBy("id", "desc")->where("complete", 1)->get();
        }
        $arr = [];
        foreach ($data as $row) {

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

            $parent = EducationLevel::where('id', $row->grade->parent_id)->first();
            $arr[] = array("ID" => htmlspecialchars($row->id, ENT_QUOTES), "Created_at" => htmlspecialchars($row->created_at, ENT_QUOTES), "content_name" => htmlspecialchars($row->content_name, ENT_QUOTES), "grade" => htmlspecialchars($row->grade->name, ENT_QUOTES), "country" => htmlspecialchars(($row->Country) ? $row->Country->name : "عام", ENT_QUOTES), "user" => htmlspecialchars($row->user->name, ENT_QUOTES), "category" => htmlspecialchars($row->Categories->name, ENT_QUOTES), "level" => htmlspecialchars($parent->name, ENT_QUOTES));
            unset($row);
        }

        // $arr["arrCount"]=htmlspecialchars(count($arr),ENT_QUOTES);
        if (@$_GET["advancesearch"]) {
            Session::put('data', json_encode($arr));
            Session::put('category', request('category'));
            Session::put('level', request('level'));
            Session::put('editor', request('editor'));
            Session::put('country', request('countries'));
            Session::put('start_on', request('start_on'));
            Session::put('end_on', request('end_on'));
            return \redirect()->back();
        }
        return response()->json($arr);

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

        $learningGoals = LearingGoal::all()->pluck("id")->toArray(); //to validate the selecte options with the original

        $custom = array('content_name' => 'required|max:191',
            'education_level_id' => 'required',
            'goal_id_list' => ["bail", "array", "distinct", "required", "in:" . implode(",", $learningGoals)], //array of goals ids
            'main_categories_id' => 'required',

            'poll' => 'required|max:5000',
            'hint' => 'required|max:5000',

            'abstract' => 'required|max:5000',
            'links.*.link' => 'required|max:191',
            'links.*.href' => array(
                'required',
                'regex:/^(https:\/\/|http:\/\/)./',
                'max:600',
            ));
        if ($request->has('image')) {
            $custom['image'] = 'mimes:jpeg,jpg,png|max:1000';
        }
        if ($request->has('image')) {
            $custom['Lesson_image'] = 'mimes:jpeg,jpg,png|max:1000';
        }
        request()->validate($custom,
            ['content_name.required' => 'من فضلك ادخل اسم المحتوى',
                'content_name.max' => 'الاسم يجب الايزيد عن 191',
                'education_level_id.required' => 'من فضلك ادخل المرحله الدارسيه',

                'goal_id_list.required' => 'من فضلك ادخل ناتج التعلم ',
                'goal_id_list.in' => 'من فضلك ادخل ناتج تعلم صحيح',
                'main_categories_id.required' => 'من فضلك ادخل اسم التصنيف',
                'image.required' => 'من فضلك اختر صوره',
                'image.mimes' => 'من فضلك اختر صوره من نوع  jpeg او  jpg او png  ',
                'image.max' => ' الصوره يجب ان لا تزيد عن 1 ميجا   ',
                'Lesson_image.required' => 'من فضلك اختر صوره',
                'Lesson_image.mimes' => 'من فضلك اختر صوره من نوع  jpeg او  jpg او png  ',
                'Lesson_image.max' => ' الصوره يجب ان لا تزيد عن 1 ميجا   ',
                'poll.required' => 'من فضلك ادخل اسم السؤال ',
                'poll.max' => 'من فضلك اسم السؤال  يجب الايزيد 600حرف',
                'hint.required' => 'من فضلك ادخل تمهيد مختصر للسؤال القبلى ',
                'hint.max' => 'من فضلك تمهيد مختصر للسؤال القبلى  يجب الايزيد 5000حرف',
                'abstract.max' => 'من فضلك ادخل نبذه مختصره عن الدرس ',
                'abstract.required' => 'من فضلك  نبذه مختصره عن الدرس يجب الا يزيد عن 600 حرف',
                'links.*.link.required' => 'من فضلك ادخل اسم الرابط',
                'links.*.link.max' => ' من فضلك  اسم الرابط يجب الا يزيد عن 191 حرف',
                'links.*.href.required' => 'من فضلك ادخل الرابط',
                'links.*.href.max' => 'من فضلك  الرابط يجب الا يزيد عن 600 حرف',

                'links.*.href.regex' => 'من فضلك ادخل الرابط بشكل صحيح مثل http://google.com ']);

        DB::transaction(function () use ($id, $request) {
            $contents = Content::find($id);
            $contents->education_level_id = Input::get('education_level_id');
            $contents->countries = Input::get('countries');
            $contents->content_name = Input::get('content_name');
            $contents->poll = Input::get('poll');
            $contents->hint = Input::get('hint');
            if (Input::has('image')) {
                $file = Input::file('image');
                $destinationPath = 'images/';

                $extension = $file->getClientOriginalExtension();
                $sha1 = sha1($file->getClientOriginalName());
                $filename = time() . "_" . $sha1 . "." . $extension;
                $file->move($destinationPath, $filename);
                $storename = 'images/' . $filename;
                $contents->cover_image = $storename;
            }
            if (Input::has('Lesson_image')) {
                $file = Input::file('Lesson_image');
                $destinationPath = 'images/';

                $extension2 = $file->getClientOriginalExtension();
                $sha1 = sha1($file->getClientOriginalName());
                $filename2 = time() . "_" . $sha1 . "." . $extension2;
                $file->move($destinationPath, $filename2);
                $storename2 = 'images/' . $filename2;
                $contents->lessonImage = $storename2;
            }
            $contents->abstract = Input::get('abstract');

            $contents->save();

            //delete all linked content goal ids
            $contentLearningGoals = ContentLearningGoal::where('content_id', $contents->id)->get()->pluck('goal_id')->toArray();
            $result = array_diff($contentLearningGoals, $request->goal_id_list);
            if (count($result) > 0) {

                $linkedContentGoals = ContentLearningGoal::where("content_id", $id)->delete();
                foreach ($request->goal_id_list as $eachGoalID) {
                    //insert goals in the table of linked content goals
                    $goal_linked_content = new ContentLearningGoal();
                    $goal_linked_content->content_id = $contents->id;
                    $goal_linked_content->goal_id = $eachGoalID;
                    $goal_linked_content->save();
                }
            }

            //Session::put('content_id', $contents->id);
            $arr['name'] = $contents->content_name;
            $arr['table_name'] = 'الدروس';
            $arr['type'] = 'عدل';
            $arr['row_id'] = $contents->id;
            LogTimeController::saveLogesTimes($arr);


            // redirect
            Session::flash('message', 'لقد تم التعديل  بنجاح');
        });
        return redirect()->back();
        // redirect
        // Session::flash('message', 'لقد تم تعديل المصطلح بنجاح');
        // return Redirect::to('vocabularys');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // delete
        $contents = Content::find($id);
        $file = $contents->cover_image;
        $sound = Sound::where('content_id', $id)->get();
        foreach ($sound as $sound) {

            unlink($sound->path);

        }
        unlink($contents->cover_image);
        $newlog = array(
            'name' => $contents->content_name,
            'type' => 'مسح',
            'user_id' => auth()->user()->id,
            'table_name' => 'الدروس',
            'row_id' => $id,
            'created_at' => date("Y-m-d H:i:s"),

        );
        $contents->delete();

        LogTime::insert($newlog);
        // redirect
        Session::flash('message', 'لقد تم حذف المحتوى  بنجاح');
        return redirect()->back();
    }

    public function deleteMultipleContents()
    {

        $arr = explode(",", request('Arr'));

        foreach ($arr as $each) {

            $contents = Content::find($each);

            $file = $contents->cover_image;
            $sound = Sound::where('content_id', $each)->get();
            foreach ($sound as $sound) {

                @unlink($sound->path);

            }
            @unlink($contents->cover_image);
            $newlog = array(
                'name' => $contents->content_name,
                'type' => 'delete',
                'user_id' => auth()->user()->id,
                'table_name' => 'content',
                'created_at' => date("Y-m-d H:i:s"),

            );
            $contents->delete();

            LogTime::insert($newlog);
        }

        //return response($contents);
    }

    public function filtercountry(Request $request)
    {
        $country_id = Input::get('country_id');
        $categories_id = Input::get('categories_id');
        $grade_id = Input::get('grade_id');
        if ($categories_id != null && $grade_id == null && $country_id != null) {
            $sub_json = Content::with('Country', 'grade', 'Categories')->where('countries', $country_id)->where('category_id', $categories_id)->get();
            return response($sub_json);
        }
        if ($grade_id != null && $categories_id == null && $country_id != null) {
            $sub_json = Content::with('Country', 'grade', 'Categories')->where('countries', $country_id)->where('education_level_id', $grade_id)->get();
            return response($sub_json);
        } elseif ($grade_id != null && $categories_id != null) {
            $sub_json = Content::with('Country', 'grade', 'Categories')->where('countries', $country_id)->where('education_level_id', $grade_id)->where('category_id', $categories_id)->get();
            return response($sub_json);
        } elseif (empty($categories_id) && empty($grade_id) && $country_id != null) {
            $sub_json = Content::with('Country', 'grade', 'Categories')->where('countries', $country_id)->get();
            return response($sub_json);
        } elseif ($categories_id != null) {
            $sub_json = Content::with('Country', 'grade', 'Categories')->where('category_id', $categories_id)->get();
            return response($sub_json);
        }
        if ($country_id == null && $categories_id == null && $grade_id != null) {
            $sub_json = Content::with('Country', 'grade', 'Categories')->where('education_level_id', $grade_id)->get();
            return response($sub_json);
        } else {
            $sub_json = Content::with('Country', 'grade', 'Categories')->get();
            return response($sub_json);
        }

    }

    public function filtercat(Request $request)
    {

        $categories_id = Input::get('categories_id');
        $country_id = Input::get('country_id');

        $grade_id = Input::get('grade_id');
        if ($country_id != null && $grade_id == null && $categories_id != null) {
            $sub_json = Content::with('Country', 'grade', 'Categories')->where('countries', $country_id)->where('category_id', $categories_id)->get();
            return response($sub_json);
        }
        if ($grade_id != null && $country_id == null && $categories_id != null) {
            $sub_json = Content::with('Country', 'grade', 'Categories')->where('category_id', $categories_id)->where('education_level_id', $grade_id)->get();
            return response($sub_json);
        }

        if ($categories_id != null && $grade_id != null && $country_id == null) {
            $sub_json = Content::with('Country', 'grade', 'Categories')->where('education_level_id', $grade_id)->where('category_id', $categories_id)->get();
            return response($sub_json);
        }
        if ($country_id != null && $grade_id != null && $categories_id == null) {
            $sub_json = Content::with('Country', 'grade', 'Categories')->where('education_level_id', $grade_id)->where('countries', $country_id)->get();
            return response($sub_json);
        }
        if (empty($country_id) && $grade_id != null && $categories_id == null) {
            $sub_json = Content::with('Country', 'grade', 'Categories')->where('education_level_id', $grade_id)->get();
            return response($sub_json);
        }
        if ($categories_id != null) {

            $sub_json = Content::with('Country', 'grade', 'Categories')->where('category_id', $categories_id)->get();

            $contents = Content::with('Country', 'grade', 'Categories')->paginate(20);

            $country = Country::all();
            $grade = EducationLevel::all();

            $categories = Categories::with('children')->whereNull('parent_id')->orderBy('name', 'asc')->get();
            foreach ($sub_json as $test) {
                if ($test->id != null) {
                    foreach ($sub_json as $contentjason) {

                        $arr[] = array("img" => htmlspecialchars($contentjason->cover_image, ENT_QUOTES), "id" => htmlspecialchars($contentjason->id, ENT_QUOTES), "name" => htmlspecialchars($contentjason->content_name, ENT_QUOTES), "last_update" => htmlspecialchars($contentjason->updated_at, ENT_QUOTES), "catg" => htmlspecialchars($contentjason->categories->name, ENT_QUOTES), "grade" => htmlspecialchars($contentjason->grade->name, ENT_QUOTES), "country" => htmlspecialchars($contentjason->country->name, ENT_QUOTES));

                    }
                    $content = json_encode($arr);
                    return view('index')->with('contents', $contents)->with(compact('content'))->with('country', $country)->with('categories', $categories)->with('grade', $grade);

                }

            }
            $content = null;
            return view('index')->with('contents', $contents)->with(compact('content'))->with('country', $country)->with('categories', $categories)->with('grade', $grade);

        }
        if ($categories_id == null && $grade_id == null && $country_id != null) {
            $sub_json = Content::with('Country', 'grade', 'Categories')->where('countries', $country_id)->get();
            return response($sub_json);
        } else {
            $sub_json = Content::with('Country', 'grade', 'Categories')->get();
            return response($sub_json);
        }
    }

    public function filtergrade(Request $request)
    {

        $grade_id = Input::get('grade_id');
        $categories_id = Input::get('categories_id');
        $country_id = Input::get('country_id');
        if ($categories_id != null && empty($country_id) && $grade_id != null) {
            $sub_json = Content::with('Country', 'grade', 'Categories')->where('education_level_id', $grade_id)->where('category_id', $categories_id)->get();
            return response($sub_json);
        }
        if ($country_id != null && empty($categories_id) && $grade_id != null) {
            $sub_json = Content::with('Country', 'grade', 'Categories')->where('education_level_id', $grade_id)->where('countries', $country_id)->get();
            return response($sub_json);
        }
        if ($country_id != null && $categories_id != null) {
            $sub_json = Content::with('Country', 'grade', 'Categories')->where('education_level_id', $grade_id)->where('category_id', $categories_id)->where('countries', $country_id)->get();
            return response($sub_json);
        }
        if ($grade_id != null) {
            $sub_json = Content::with('Country', 'grade', 'Categories')->where('education_level_id', $grade_id)->get();
            return response($sub_json);
        }

        if (empty($country_id) && empty($grade_id) && $categories_id != null) {
            $sub_json = Content::with('Country', 'grade', 'Categories')->where('category_id', $categories_id)->get();
            return response($sub_json);
        }
        if ($categories_id == null && $grade_id == null && $country_id != null) {
            $sub_json = Content::with('Country', 'grade', 'Categories')->where('countries', $country_id)->get();
            return response($sub_json);
        } else {
            $sub_json = Content::with('Country', 'grade', 'Categories')->get();
            return response($sub_json);
        }

    }

    public function default()
    {

        $contents = Content::with('Country', 'grade', 'Categories')->where('complete', 1)->paginate(20);
        $country = Country::all();
        $categories = Categories::with('children')->whereNull('parent_id')->orderBy('name', 'asc')->get();
        $grade = EducationLevel::all();

        $arr = [];
        foreach ($contents as $contentjason) {

            $arr[] = array("abstract" => htmlspecialchars($contentjason->abstract, ENT_QUOTES), "img" => htmlspecialchars($contentjason->cover_image, ENT_QUOTES), "id" => htmlspecialchars($contentjason->id, ENT_QUOTES), "name" => htmlspecialchars($contentjason->content_name, ENT_QUOTES), "last_update" => htmlspecialchars($contentjason->updated_at, ENT_QUOTES), "catg" => htmlspecialchars($contentjason->categories->name, ENT_QUOTES), "grade" => htmlspecialchars($contentjason->grade->name, ENT_QUOTES), "country" => htmlspecialchars($contentjason->country->name, ENT_QUOTES));

        }

        $json_content = json_encode($arr);

        $contentsall = Content::with('articalnormal', 'articalstrach', 'vocab')->get();
        foreach ($contentsall as $contentsall) {

            $this->checkcomplete($contentsall->id);
        }
        return view('index')->with('contents', $contents)->with('content', $json_content)->with('country', $country)->with('categories', $categories)->with('grade', $grade);
    }

    static function toViewContentFromSpecificDateToSpecificDate($user_id = null)
    {

        $startOn = \request('startOn');
        $endsOn = \request('endsOn');
        $contentsIds = AssignLessonsToReviewers::where('user_id', $user_id)->whereBetween('created_at', array(date('Y-m-d', strtotime($startOn . ' - 1 days')) . '%', date('Y-m-d', strtotime($endsOn . ' + 1 days')) . '%'))->get()->pluck('content_id')->toArray();
        if (!$startOn) {
            $contentsIds = AssignLessonsToReviewers::where('user_id', $user_id)->where('created_at', '<=', date('Y-m-d', strtotime($endsOn . ' + 1 days')) . '%')->get()->pluck('content_id')->toArray();

        }

        if ($user_id) {

            $user = User::find($user_id);
            if ($user->is_permission == TYPE_OF_USERS_ENUMS::EDITOR) {

                $contentsIds = Content::with('Country', 'grade', 'Categories', 'user')->orderBy("id", "desc")->where('user_id', $user_id)->whereBetween('created_at', array(date('Y-m-d', strtotime($startOn . ' -1 days')) . '%', date('Y-m-d', strtotime($endsOn . ' + 1 days')) . '%'))->pluck('id')->toArray();
                if (!$startOn) {
                    $contentsIds = Content::with('Country', 'grade', 'Categories', 'user')->orderBy("id", "desc")->where('user_id', $user_id)->where('created_at', '<=', date('Y-m-d', strtotime($endsOn . ' + 1 days')) . '%')->get()->pluck('content_id')->toArray();

                }
            }
        }


        // $content = Content::whereIn('id', $contentsIds)->get();
        return $contentsIds;
    }
}
