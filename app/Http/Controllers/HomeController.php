<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\OwnClasses\Permissions;

class HomeController extends Controller
{
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

//              if (Auth::guard($guard)->check()!="school") {
//        if (Permissions::STUDENT_PERMISSION_ENUM == auth()->user()->is_permission) {
//            if (!SchoolDashboardController::CheckIfSchoolAccountActiveOrNot(auth()->user()->school_id)) {
//                return redirect()->back()->withErrors(['حساب المدرسة الخاص بكم تم اياقفة']);
//            }
//            if (StudentPlacementTest::checkIfPlacementTestHasbeenCompleteOrNotByUser(auth()->user()->student_grade_id)) {
//
//                return redirect('/studentDashboard');
//            }
//            if (StudentPlacementTest::checkIfUserHavePlacementTestsBefore()) {
//                return redirect('Student/placement_test/feedback/LessonPlan');
//            }
//            StudentPlacementTest::DeletePlacementTestQuestionAnswersIfNotCompleted();
//            return redirect('Student/placement_test/instruction');
//
//        }
//        if (\App\Http\OwnClasses\TYPE_OF_USERS_ENUMS::EDITOR == auth()->user()->is_permission) {
//
//            return redirect('Editor/home');
//        }
//        if (\App\Http\OwnClasses\TYPE_OF_USERS_ENUMS::REVIEWER == auth()->user()->is_permission) {
//
//            return redirect('Reviewer/home');
//        }
//        if (\App\Http\OwnClasses\TYPE_OF_USERS_ENUMS::AUDIT == auth()->user()->is_permission) {
//
//            return redirect('LangReviewer/AllLessons/view');
//        }
//        if (\App\Http\OwnClasses\TYPE_OF_USERS_ENUMS::PUBLISHER == auth()->user()->is_permission) {
//
//            return redirect('publisher/AllLessons/view');
//        }
//        return redirect('/');

    }
}