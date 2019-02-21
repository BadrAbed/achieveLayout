<?php

namespace App\Http\Middleware;

use App\Http\Controllers\SchoolDashboardController;
use App\Http\Controllers\StudentPlacementTest;
use App\Http\OwnClasses\Permissions;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @param  string|null $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {


        if (Auth::guard($guard)->check() && $guard != 'school') {
            if (Permissions::STUDENT_PERMISSION_ENUM == auth()->user()->is_permission) {

                if (StudentPlacementTest::checkIfPlacementTestHasbeenCompleteOrNotByUser(auth()->user()->student_grade_id)) {

                    return redirect('/studentDashboard');
                }
                if (StudentPlacementTest::checkIfUserHavePlacementTestsBefore()) {
                    return redirect('Student/placement_test/feedback/LessonPlan');
                }
//                if (!SchoolDashboardController::CheckIfSchoolAccountActiveOrNot(auth()->user()->school_id)) {
//                    return redirect()->back()->withErrors(['حساب المدرسة الخاص بكم تم اياقفة']);
//                }
                $PlacementTest = \App\PlacementTest::where(['country' => auth()->user()->student_country_id, 'parent_education_level' => auth()->user()->student_grade_id, 'status' => 1])->inRandomOrder()->first();
                StudentPlacementTest::DeleteAllUserAnswersInAllPlacementTestSInSpecificLevel();
                // StudentPlacementTest::DeletePlacementTestQuestionAnswersIfNotCompleted($PlacementTest->id);
                return redirect('Student/placement_test/instruction/' . $PlacementTest->id);

            }
            if (\App\Http\OwnClasses\TYPE_OF_USERS_ENUMS::EDITOR == auth()->user()->is_permission) {

                return redirect('Editor/home');
            }
            if (\App\Http\OwnClasses\TYPE_OF_USERS_ENUMS::REVIEWER == auth()->user()->is_permission) {

                return redirect('Reviewer/home');
            }
            if (\App\Http\OwnClasses\TYPE_OF_USERS_ENUMS::AUDIT == auth()->user()->is_permission) {

                return redirect('LangReviewer/AllLessons/view');
            }
            if (\App\Http\OwnClasses\TYPE_OF_USERS_ENUMS::PUBLISHER == auth()->user()->is_permission) {

                return redirect('publisher/AllLessons/view');
            }
            if (\App\Http\OwnClasses\TYPE_OF_USERS_ENUMS::QUESTIONEDITOR == auth()->user()->is_permission) {

                return redirect('QuestionsEditor/home');
            }
            if (\App\Http\OwnClasses\TYPE_OF_USERS_ENUMS::QUESTIONREVIEWER == auth()->user()->is_permission) {

                return redirect('QuestionsReviewer/home');
            }
            return redirect('/');
        }
        switch ($guard) {
            case 'school':
                if (Auth::guard($guard)->check()) {

                    return redirect('SchoolDashboard');
                }
        }

        return $next($request);
    }
}
