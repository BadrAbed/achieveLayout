<?php

namespace App\Http\Controllers;

use App\Country;
use App\EducationLevel;
use App\Exports\EmptyCSVFile;
use App\Exports\levelsOfSchool;
use App\Exports\StudentsOfSchool;
use App\Http\OwnClasses\Permissions;
use App\Imports\UsersImport;
use App\School;
use App\SchoolLinkedGrads;
use App\Sortinglesson;
use App\StudentAssignedLessonPlan;
use App\StudentLessonPlanProgress;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use DateTime;
use League\Csv\Reader;
use Maatwebsite\Excel;

class SchoolDashboardController extends Controller
{

    public function SchoolDashboard()
    {
        $users = User::with('grade')->where('school_id', Auth::guard('school')->user()->id)->paginate(20);
        return view('schools.schoolDashboard', compact('users'));
    }

    public function SchoolAllStudent()
    {
        $users = User::where('school_id', Auth::guard('school')->user()->id)->paginate(20);
        return view('schools.students.allStudents', compact('users'));
    }

    public function viewSchool($School_id)
    {
        $school = School::find($School_id);
        $users = User::where('school_id', $School_id)->paginate(20);
        $LinkededucationLevels = SchoolLinkedGrads::where('school_id', $School_id)->get();
        if ($LinkededucationLevels->count() > 0) {
            $grades_id = $LinkededucationLevels->pluck('grade_id')->toArray();
            $educationLevels = EducationLevel::whereIn('id', $grades_id)->get();
        } else {
            $educationLevels = EducationLevel::where('parent_id', null)->get();
        }
        return view('schools.view', compact('educationLevels', 'school', 'users'));

    }

    public function editSchool($school_id)
    {
        $school = School::find($school_id);

        $countriesList = Country::all();
        $LinkededucationLevels = SchoolLinkedGrads::where('school_id', $school_id)->get();

        $grades_id = $LinkededucationLevels->pluck('grade_id')->toArray();


        $educationLevels = EducationLevel::where('parent_id', null)->get();

        return view('schools.edit', compact('educationLevels', 'school', 'countriesList', 'grades_id'));

    }

    public function updateSchool($school_id)
    {

        $school = School::find($school_id);
        $rules = null;
        $rules_end_on = null;
        $PasswordRules = null;
        if (\request('starts_on') != date('Y-m-d', strtotime($school->start_on))) {
            $rules = 'greater_than_now';
        }
        if (\request('end_in') != date('Y-m-d', strtotime($school->end_on))) {
            $rules_end_on = 'greater_than_now';
        }
        if (\request('password')) {
            $PasswordRules = 'min:6|max:30';
        }

        request()->validate([
            'email' => 'required|unique:schools,email,' . $school_id . '|email',
            "name" => "required|min:6|max:30|alpha_num",
            "password" => "" . $PasswordRules,
            "address" => "required",
            "end_in" => "required|greater_than_field:starts_on|" . $rules_end_on,
            "starts_on" => "required|" . $rules,

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
        DB::transaction(function () use ($school) {

            $school->name = \request('name');
            $school->email = \request('email');
            $school->address = \request('address');
            $school->numberOfStudents = \request('numberOfStudents');
            $school->start_on = \request('starts_on');
            $school->end_on = \request('end_in');
            if (\request('password')) {
                $school->password = bcrypt(\request('password'));
            }
            $school->countries = \request('countries');
            $school->save();
            if (\request('educationLevelList')) {
                $SchoolLinkedGrads = SchoolLinkedGrads::where('school_id', $school->id)->get();
                foreach ($SchoolLinkedGrads as $SchoolLinkedGrade) {
                    $SchoolLinkedGrade->delete();
                }
                foreach (\request('educationLevelList') as $grade) {
                    $newSchoolGrade = new SchoolLinkedGrads();
                    $newSchoolGrade->school_id = $school->id;
                    $newSchoolGrade->grade_id = $grade;
                    $newSchoolGrade->save();

                }
            }


        });
        Session::flash('message', 'لقد تم تعديل المدرسة بنجاح');
        return Redirect::back();
    }

    public function SchoolEditStudent($student_id)
    {
        $student = User::find($student_id);


        $userAllowedGrades = SchoolLinkedGrads::where('school_id', Auth::guard('school')->user()->id)->get()->pluck('grade_id')->toArray();
        $educationLevels = EducationLevel::whereIn("id", $userAllowedGrades)->get();

        if ($educationLevels->count() == 0) {
            $educationLevels = EducationLevel::where('parent_id', null)->get();
        }
        if ($student) {
            $Parent_grade = EducationLevel::find($student->student_grade_id)->parent_id;
            if ($Parent_grade) {
                return \redirect()->back()->withErrors(['لا يمكنك تعديل الطالب,الطالب لدية خطة دروس تعلم ']);
            }
            return view('schools.students.edit', compact('student', 'educationLevels'));
        }
    }

    public function SchoolUpdateStudent($student_id)
    {
        $users = User::find($student_id);
        $PasswordRules = null;
        if (\request('password')) {
            $PasswordRules = 'min:6|max:30';
        }
        request()->validate([
            'email' => 'required|unique:users,email,' . $student_id . '|email',
            "name" => "required|min:6|max:30",
            "password" => "" . $PasswordRules,
            "educationLevel" => "required",


        ],
            [
                'email.required' => 'من فضلك ادخل البريد الالكترونى',
                'email.unique' => 'هذا البريد موجود بالفعل',
                'name.required' => 'من فضلك ادخل اسم الطالب',
                'name.min' => 'اسم الطالب يجب الا يقل عن 6 احرف',
                'name.max' => 'اسم الطالب يجب الا يزيد عن 30 احر',
                'password.required' => 'من فضلك ادخل كلمه السر',
                'educationLevel.required' => 'من فضلك ادخل المرحلة الدراسية',


            ]);


        $users->name = Input::get('name', false); //insert from name
        $users->email = Input::get('email', false); //insert email
        $users->password = bcrypt(Input::get('password', false)); //insert password
        $users->is_permission = Permissions::STUDENT_PERMISSION_ENUM; //because there is no registration for admins , it just for students ,,, admins are set via admin dashboard
        $users->student_country_id = Auth::guard('school')->user()->countries;
        $users->school_id = Auth::guard('school')->user()->id;
        $users->student_grade_id = \request('educationLevel');
        $users->save();//insert
        Session::flash('message', 'لقد تم تعديل المستخدم بنجاح');
        return Redirect::back();
    }

    public function SchoolAddStudent()
    {

        $userAllowedGrades = SchoolLinkedGrads::where('school_id', Auth::guard('school')->user()->id)->get()->pluck('grade_id')->toArray();
        $educationLevels = EducationLevel::whereIn("id", $userAllowedGrades)->get();

        if ($educationLevels->count() == 0) {
            $educationLevels = EducationLevel::where('parent_id', null)->get();
        }
        return view('schools.students.create', compact('educationLevels'));
    }

    public function SchoolStoreStudent()
    {
        request()->validate([
            'email' => 'required|unique:users|email',
            "name" => "required|min:6|max:30",
            "password" => "required|min:6|max:30",
            "educationLevel" => "required",


        ],
            [
                'email.required' => 'من فضلك ادخل البريد الالكترونى',
                'email.unique' => 'هذا البريد موجود بالفعل',
                'name.required' => 'من فضلك ادخل اسم الطالب',
                'name.min' => 'اسم الطالب يجب الا يقل عن 6 احرف',
                'name.max' => 'اسم الطالب يجب الا يزيد عن 30 احر',
                'password.required' => 'من فضلك ادخل كلمه السر',
                'educationLevel.required' => 'من فضلك ادخل المرحلة الدراسية',


            ]);

        $numberOFStudentInSchool = User::where('school_id', Auth::guard('school')->user()->id)->orderBy('student_grade_id')->get()->count();

        if ($numberOFStudentInSchool >= Auth::guard('school')->user()->numberOfStudents) {
            return \redirect()->back()->withErrors(['عدد الطلاب اكبر من العدد المسموح لك به ']);
        }
        $users = new User;//create new User model
        $users->name = Input::get('name', false); //insert from name
        $users->email = Input::get('email', false); //insert email
        $users->password = bcrypt(Input::get('password', false)); //insert password
        $users->is_permission = Permissions::STUDENT_PERMISSION_ENUM; //because there is no registration for admins , it just for students ,,, admins are set via admin dashboard
        $users->student_country_id = Auth::guard('school')->user()->countries;
        $users->school_id = Auth::guard('school')->user()->id;
        $users->student_grade_id = \request('educationLevel');
        $users->save();//insert
        Session::flash('message', 'لقد تم انشاء المستخدم بنجاح');
        return Redirect::to('SchoolDashboard');
    }

    public function getCSVFileForStudent()
    {


        $userAllowedGrades = SchoolLinkedGrads::where('school_id', Auth::guard('school')->user()->id)->get()->pluck('grade_id')->toArray();
        $educationLevels = EducationLevel::whereIn("id", $userAllowedGrades)->first();
        if ($educationLevels == null) {
            $educationLevels = EducationLevel::where('parent_id', null)->first();
        }
        $child_id = EducationLevel::where('parent_id', $educationLevels->id)->get()->pluck('id')->toArray();


        return Excel\Facades\Excel::download(new StudentsOfSchool($child_id, $educationLevels->name), 'students.xlsx');

//        $users = User::where('school_id', Auth::guard('school')->user()->id)->orderBy('student_grade_id')->get();
//
//        $csvExporter = new \Laracsv\Export();
//        $csvExporter->beforeEach(function ($user) {
//            // Now notes field will have this value
//            $user->level = $user->grade;
//            $user->FullName = 'bb'.$user->name;
//            $user->Joined = "from " . $user->created_at;
//
//        });
//
//        $csvExporter->build($users, ['email', 'name', 'level', 'Joined']);
//
//        $csvExporter->download('active_student.csv');
    }

    public function uploadCSVFileFormSchool()
    {


//
        request()->validate([
            'filename' => 'required',


        ],
            [
                'filename.required' => 'من فضلك ادخل الملف المطلوب',


            ]);
        Excel\Facades\Excel::import(new UsersImport, request()->file('filename'));
//
//        $filename2 = request()->file('filename');
//        $filename2->move(storage_path() . '/' . 'files', $filename2->getClientOriginalName());
//
//        $filename = storage_path() . '/' . 'files' . '/' . $filename2->getClientOriginalName();
//        // $content = File::get($filename);
//        $fopen = fopen($filename, 'r');
//
//        $fread = fread($fopen, filesize($filename));
//
//        fclose($fopen);
//
//        $remove = "\n";
//
//        $split = explode($remove, $fread);
//
//        $array[] = null;
//        $tab = "\t";
//
//        foreach ($split as $string) {
//            $row = explode($tab, $string);
//            array_push($array, $row);
//        }
//        echo "<pre>";
//        $numberOFStudentInSchool = User::where('school_id', Auth::guard('school')->user()->id)->orderBy('student_grade_id')->get()->count();
//        $totalStudents = $numberOFStudentInSchool + (count($array) - 2);
//        if ($totalStudents >= Auth::guard('school')->user()->numberOfStudents) {
//            return \redirect()->back()->withErrors(['عدد الطلاب اكبر من العدد المسموح لك به ']);
//        }
//        $test = $array[1][0];
//        $header_array = explode(',', $array[1][0]);
//        if (count($header_array) > 4 || count($header_array) < 4) {
//            unlink($filename);
//            return \redirect()->back()->withErrors(['بعض القيم فارغه او بعض القيم زائدة من فضلك اكمل الملف اولا']);
//        }
//
//        for ($i = 2; $i <= count($array) - 2; $i++) {
//
//            $studentArray = explode(',', $array[$i][0]);
//
//            $email = $studentArray[0];
//            $name = $studentArray[1];
//            $level = $studentArray[2];
//            $password = str_replace('/r', '', $studentArray[3]);
//            if (!$name || !$email || !$level || !$password) {
//                unlink($filename);
//                return \redirect()->back()->withErrors(['بعض القيم فارغه من فضلك اكمل الملف اولا']);
//            }
//            $checkIFEmailInsertBeforeOrnot = User::where('email', $email)->first();
//            if ($checkIFEmailInsertBeforeOrnot) {
//
//                unlink($filename);
//
//
//                return \redirect()->back()->withErrors([$email . 'هذا الاميل موجود بالفعل ']);
//            }
//            if (!is_numeric($level)) {
//                unlink($filename);
//                return \redirect()->back()->withErrors(['الصف لابد ان يكون رقم']);
//            }
//
//
//        }
//
//        for ($i = 2; $i <= count($array) - 2; $i++) {
//
//            $studentArray = explode(',', $array[$i][0]);
//            $email = $studentArray[0];
//            $name = $studentArray[1];
//            $level = $studentArray[2];
//            $password = $studentArray[3];
//            $passwordCount = strlen($password) - 1;
//            $password2 = substr($password, 0, $passwordCount);
//            //$FF=  htmlspecialchars($password,ENT_QUOTES);
//
//            $newStudent = new User();
//            $newStudent->email = $email;
//            $newStudent->password = bcrypt($password2);
//
//            $newStudent->name = $name;
//            $newStudent->student_grade_id = $level;
//            $newStudent->school_id = Auth::guard('school')->user()->id;
//            $newStudent->student_country_id = Auth::guard('school')->user()->countries;
//            $newStudent->save();
//        }
//        unlink($filename);
        if(Session::has('errors')){

            return \redirect()->back()->withErrors(Session::get('errors'));

        }
        Session::flash('message', 'لقد تم انشاء الطلاب بنجاح');
        return Redirect::to('SchoolDashboard');
    }

    public function downloadEmptyCSVFile()
    {
//        $users = User::where('id', null)->orderBy('student_grade_id')->orderBy('student_grade_id')->get();
//        $csvExporter = new \Laracsv\Export();
//
//        $csvExporter->build($users, ['email', 'FullName', 'level', 'password']);
//        $csvExporter->download('emptyFile.csv');
        return Excel\Facades\Excel::download(new EmptyCSVFile(), 'EmptyFile.xlsx');
    }

    public function downloadLevelsCSVFile()
    {
//        $userAllowedGrades = SchoolLinkedGrads::where('school_id', Auth::guard('school')->user()->id)->get()->pluck('grade_id')->toArray();
//        $educationLevels = EducationLevel::whereIn("id", $userAllowedGrades)->get();
//
//        if ($educationLevels->count() == 0) {
//            $educationLevels = EducationLevel::where('parent_id', null)->get();
//        }
//        $csvExporter = new \Laracsv\Export();
//
//        $csvExporter->build($educationLevels, ['id' => 'number', 'name']);
//        $csvExporter->download('levels.csv');
        return Excel\Facades\Excel::download(new levelsOfSchool(), 'levels.xlsx');
    }

    public function FollowStudentInSchool($student_id)
    {
        $StudentLessonPlanID = StudentAssignedLessonPlan::where('user_id', $student_id)->first();
        if (!$StudentLessonPlanID) {
            return \redirect()->back()->withErrors(['الطالب لا توجد له خطه تعلم بعد راجع الطالب من اجل اختبار تحديد المستوى شكرا']);
        }

        $contents = Sortinglesson::get_all_lessons_for_specific_lesson_orderd_by_sorting_obligatory($StudentLessonPlanID->lesson_plan_id);
        $lesson_plan_id = $StudentLessonPlanID->lesson_plan_id;
        return view('schools.students.viewProgress', compact("contents", 'lesson_plan_id', 'student_id'));


    }

    public function SoftDeleteSchool($school_id)
    {
        $school = School::find($school_id);
        $school->delete();
        return \redirect()->back();
    }

    public function ForceDeleteSchool($school_id)
    {

        DB::transaction(function () use ($school_id) {
            $school = School::where('id', $school_id)->forceDelete();
            $students = User::where('school_id', $school_id)->get();
            if ($students->count() > 1) {
                foreach ($students as $student) {
                    $student->delete();
                }
            }
        });
        return \redirect()->back();
    }

    public function RestoreDeleteSchool($school_id)
    {
        $school = School::where('id', $school_id)->restore();

        return \redirect()->back();
    }

    public function SuspendedSchools()
    {
        $schools = School::onlyTrashed()->paginate(20);

        return view('schools.suspendedSchools', compact('schools'));
    }

    static function CheckIfSchoolAccountActiveOrNot($school_id)
    {
        $school = School::find($school_id);

        if ($school) {
            $AcountEndDate = new DateTime($school->end_on);
            $Todaydate = new DateTime(date("Y-m-d h:i:sa"));
            if ($AcountEndDate < $Todaydate) {
                return false;
            }
            return true;
        }
        return false;
    }

    public function deleteStudent($student_id)
    {
        $user = User::find($student_id);

        if ($user && $user->school_id == Auth::guard('school')->user()->id) {
            $user->delete();
            return \redirect()->back();
        }
        return \redirect()->back()->withErrors(['الطالب غير موجود ']);
    }
}
