<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\CommonStudentLessonsProcesses;
use App\Http\Controllers\StudentAssignedLessonPlanController;
use App\Http\Controllers\StudentPlacementTest;
use App\Http\OwnClasses\Permissions;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use \App\EducationLevel;
use \App\Country;


class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
   // protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {


        $countriesList = Country::orderBy("id", "desc")->select("id", "name")->get()->pluck("id")->toArray();//get list of countries and convert to array with the ids only to validate the selected country


        // a work around that solve a problem of the register controller with the manual validators
        //its about to check if the grade has children or not
        //if has , then its not valid , and send to the validator an empty array , so he will fire automatic error and vice versa


        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            "countriesList" => "required|integer|in:" . implode(",", $countriesList),//array of countries ids
            "grade" => "required|integer", //array of countries levels
        ]);


    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return \App\User
     */
    protected function create(array $data)
    {

        $createUser = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            "is_permission" => Permissions::STUDENT_PERMISSION_ENUM, //because there is no registration for admins , it just for students ,,, admins are set via admin dashboard
            "student_country_id" => $data['countriesList'],
            "student_grade_id" => $data['grade']
        ]);
        //StudentPlacementTest::viewPlacementTestToStudent($createUser->student_grade_id);
        //CommonStudentLessonsProcesses::assignLessonPlan($createUser->id); //assign the suitable lesson plan , its a temporary solution until developing the exam section

       return $createUser;

    }
}
