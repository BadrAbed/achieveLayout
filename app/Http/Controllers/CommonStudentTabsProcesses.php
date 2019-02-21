<?php

namespace App\Http\Controllers;

use App\Http\OwnClasses\STUDENT_ASSIGNED_LESSON_PLANS_ENUMS;
use App\Http\OwnClasses\STUDENT_LESSON_PLAN_CONTENT_TABS_ENUMS;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Categories;
use App\Content;
use App\Country;

use App\Http\OwnClasses\STUDENT_LESSON_PLAN_PROGRESSES_ENUMS;
use App\Links;
use App\LogTime;
use App\NormalArtical;
//use App\Notifications\NewData;
use App\Sortinglesson;
use App\Sound;
use App\StretchArtical;
use App\StudentGradesLessonPlansHistory;
use App\StudentLessonPlanContentTabs;
use App\StudentLessonPlanProgress;
use App\User;
use App\VoiceReaderModel;
use App\Question;
use App\EducationLevel;
use App\Vocabulary;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use App\LearingGoal;
use Input;
use Session;
use DB;
use File;

use App\Http\OwnClasses\Enums;

use App\Http\OwnClasses\Permissions;

use \App\StudentAssignedLessonPlan;

use App\Http\OwnClasses\LESSON_PLANS_ENUMS;

class CommonStudentTabsProcesses extends Controller
{
    /**
     * @param $content_id
     * @param $tab_enum
     * @param  $lesson_plan_id
     * @todo : record the current tab as has been finished and mark the current content id as has been finished if the tab is the last one
     */
    public static function markTabAsCompleted($content_id, $tab_enum, $lesson_plan_id)
    {


        $student_lesson_plan_content_tabs = StudentLessonPlanContentTabs::where(["user_id" => auth()->id(), "content_id" => $content_id, "lesson_plan_id" => $lesson_plan_id, "tab_enum" => $tab_enum])->first();

        if ($student_lesson_plan_content_tabs == null) { //if not exist , create

            $new_student_lesson_plan_content_tabs = new StudentLessonPlanContentTabs();
            $new_student_lesson_plan_content_tabs->user_id = auth()->id();
            $new_student_lesson_plan_content_tabs->content_id = $content_id;
            $new_student_lesson_plan_content_tabs->lesson_plan_id = $lesson_plan_id;
            $new_student_lesson_plan_content_tabs->tab_enum = $tab_enum;
            $new_student_lesson_plan_content_tabs->status = STUDENT_LESSON_PLAN_CONTENT_TABS_ENUMS::GET_FINISHED;
            $new_student_lesson_plan_content_tabs->save();

        }

        if (STUDENT_ASSIGNED_LESSON_PLANS_ENUMS::isLastRequiredTabEnumToOpenNewLesson($tab_enum)) { //if last tab , call the function which will mark the current content id as has been finished
            self::applyLastContentTabProcesses($content_id, $lesson_plan_id);
        }

    }


    /**
     * @param $content_id
     * @param $lesson_plan_id
     * @return void
     * @todo : mark the current content as has been finished
     */

    public static function applyLastContentTabProcesses($content_id, $lesson_plan_id)
    {

        $student_leeson_plan_progress = StudentLessonPlanProgress::where("user_id", auth()->id())->where("content_id", $content_id)->where("lesson_plan_id", $lesson_plan_id)->first();


        $student_leeson_plan_progress->status = STUDENT_LESSON_PLAN_PROGRESSES_ENUMS::GET_FINISHED;

        $student_leeson_plan_progress->save();

    }


    /**
     * @param $tab_enum
     * @param $content_id
     * @todo : some processes on each tab access , what ? assign the current user content in table of StudentAssignedLessonPlan as the current
     *
     * @Warning :  you must use this function only at points where you already checked if the user allowed to access this lesson and tab or not , because it might save last enum of tap which is already closed , so he will alwyas be navigated to error handler view
     */
    public static function EachTabAccessProcesses($tab_enum, $content_id)
    {


        $studentAssignedLessonPlanObject = StudentAssignedLessonPlan::where("user_id", auth()->id())->first();

        $studentAssignedLessonPlanObject->currentTabEnum = $tab_enum;

        $studentAssignedLessonPlanObject->save();


    }


    /**
     * @param $tab_enum
     * @param $content_id
     * @return bool
     * @todo : return true if user has allowed to access this tab link , How ? by checking if the user has finished all of the previous tabs of the content
     */
    public static function isStudentAllowedToAccessThisTab($content_id, $tab_enum)
    {

        $lesson_plan_id = StudentAssignedLessonPlan::where("user_id", auth()->id())->first()->lesson_plan_id;
        $list_of_previous_tabs = STUDENT_ASSIGNED_LESSON_PLANS_ENUMS::getPreviousTabsValuesFromSpecificPoint($tab_enum);


        foreach ($list_of_previous_tabs as $eachTabEnum) {

            $student_lesson_plan_content_tab = StudentLessonPlanContentTabs::where(["user_id" => auth()->id(), "content_id" => $content_id, "lesson_plan_id" => $lesson_plan_id, "tab_enum" => $eachTabEnum, "status" => STUDENT_LESSON_PLAN_CONTENT_TABS_ENUMS::GET_FINISHED])->first();

            if ($student_lesson_plan_content_tab == null) {

                return false;
            }
        }

        return true;

    }


    /**
     * @param $tab_enum
     * @param  $content_id
     * @return View OR response
     * @todo : provide a redirect to  next tab url or view to handle error if the current tab is the last and has no next link.
     */

    static function navigateStudentToSpecificTabOfSpecificLesson($content_id, $tab_enum)
    {
        $vocabs = Vocabulary::where('content_id', $content_id)->get();
        Session::put('vocab', $vocabs);


        switch ($tab_enum) {

            case STUDENT_ASSIGNED_LESSON_PLANS_ENUMS::GET_SHORT_SURVEY_TAB_ENUM:
                return redirect()->to("/student/content/poll/$content_id/0/$tab_enum");
                break;


            case STUDENT_ASSIGNED_LESSON_PLANS_ENUMS::GET_NORMAL_ARTICLE_TAB_ENUM:
                return redirect()->route("student_short_article", ["content_id" => $content_id, "tab_enum" => $tab_enum]);
                break;

            case STUDENT_ASSIGNED_LESSON_PLANS_ENUMS::GET_SHORT_QUESTIONS_TAB_ENUM:

                return redirect()->route("student_both_short_and_long_question", ["content_id" => $content_id, "type" => "0", "tab_enum" => $tab_enum]);
                break;

            case STUDENT_ASSIGNED_LESSON_PLANS_ENUMS::GET_LONG_SURVEY_TAB_ENUM:


                return redirect()->to("/student/content/poll/$content_id/1/$tab_enum");
                break;

            case STUDENT_ASSIGNED_LESSON_PLANS_ENUMS::GET_STRETCH_ARTICLE_TAB_ENUM:
                return redirect()->route("student_long_article", ["content_id" => $content_id, "tab_enum" => $tab_enum]);
                break;

            case STUDENT_ASSIGNED_LESSON_PLANS_ENUMS::GET_LONG_QUESTIONS_TAB_ENUM:
                return redirect()->route("student_both_short_and_long_question", ["content_id" => $content_id, "type" => "1", "tab_enum" => $tab_enum]);
                break;

            default://if isn't valid enum provided
                return view("errors.404");
                break;
        }


    }


    /**
     * @param $content_id
     * @param $tab_enum
     * @param  $navigateOrNot => optional to either return redirection to the next tab or not
     * @return view or redirect
     * @todo :
     *  1-check if the provided enum is the last enum or not , if last then return view of handling error that there is no next view in this lesson
     *  2-if not the last , get the next tab enum
     *  3-check if user allowed to access this lesson and tab or not
     *  4-call the function to get a redirect to the next tab
     */
    public static function nextTabButtonProcess($content_id, $tab_enum, $navigateOrNot = true)
    {

        if ($tab_enum == STUDENT_ASSIGNED_LESSON_PLANS_ENUMS::GET_LAST_TAB_ENUM) { // if the provided enum is the last ,then there is no next tab in this lesson
            return view("inc.handleFinishedLesson");
        }

        $next_tab_enum = STUDENT_ASSIGNED_LESSON_PLANS_ENUMS::getNextTabEnum($tab_enum);


        $lesson_plan_id = StudentAssignedLessonPlan::where("user_id", auth()->id())->first()->lesson_plan_id;


        if (!self::isStudentAllowedToAccessThisTab($content_id, $tab_enum) || !CommonStudentLessonsProcesses::checkIfUserAllowedToAccessThisLesson($content_id, $lesson_plan_id)) {

            return view("permissions.noPermission");
        }

        self::markTabAsCompleted($content_id, $tab_enum, $lesson_plan_id);

        if ($navigateOrNot == true) {
            return self::navigateStudentToSpecificTabOfSpecificLesson($content_id, $next_tab_enum);
        }


    }


    public static function get_lesson_all_tabs_statuses($content_id)
    {

        $lesson_plan_id = StudentAssignedLessonPlan::where("user_id", auth()->id())->first()->lesson_plan_id;
        $tabs_rows_details = StudentLessonPlanContentTabs::where(["user_id" => auth()->id(), "content_id" => $content_id, "status" => STUDENT_LESSON_PLAN_CONTENT_TABS_ENUMS::GET_FINISHED, "lesson_plan_id" => $lesson_plan_id])->get();

        return $tabs_rows_details;

    }


    /**
     * @param $content_id
     * @param $tab_enum
     * @return bool
     * @todo : get tab status of specific sutdent content lesson plan
     */
    public static function get_specific_tab_status_of_specific_content_of_specific_lesson_plan_of_student($content_id, $tab_enum)
    {

        $lesson_plan_id = StudentAssignedLessonPlan::where("user_id", auth()->id())->first()->lesson_plan_id;

        $tabs_rows_details = StudentLessonPlanContentTabs::where(["user_id" => auth()->id(), "content_id" => $content_id, "lesson_plan_id" => $lesson_plan_id, "tab_enum" => $tab_enum])->first();

        if ($tabs_rows_details == null) {
            return false;
        }

        if ($tabs_rows_details->status == STUDENT_LESSON_PLAN_CONTENT_TABS_ENUMS::GET_FINISHED) {
            return true;
        } else {
            return false;
        }

    }


}
