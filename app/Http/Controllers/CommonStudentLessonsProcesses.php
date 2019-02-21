<?php

namespace App\Http\Controllers;

use App\Http\OwnClasses\LESSON_PLANS_ENUMS;
use App\LessonPlan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Categories;
use App\Content;
use App\Country;
use App\Http\OwnClasses\STUDENT_ASSIGNED_LESSON_PLANS_ENUMS;
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

use \App\Http\OwnClasses\STUDENT_LESSON_PLAN_CONTENT_TABS_ENUMS;

use App\Http\Controllers\CommonStudentTabsProcesses;

USE App\Http\OwnClasses\STUDENT_GRADES_LESSON_PLAN_HISTORIES_ENUMS;


class CommonStudentLessonsProcesses extends Controller
{
    //Students functions


    /**
     * @param user id
     * @return bool
     * @todo : assign new lesson plan for a newly registered student , and create new row in student history , revise the documentation for the events
     */
    static public function assignLessonPlan($user_id)
    {

        $userRow = User::find($user_id);

        $student_country_id = $userRow->student_country_id;
        $student_grade_id = $userRow->student_grade_id;
        $suitable_lesson_plan_for_user = LessonPlan::where(['country_id' => $student_country_id, 'grade_id' => $student_grade_id, 'active' => LESSON_PLANS_ENUMS::GET_ACTIVE_STATUS_ENUM])->orderBy("priority", "ASC")->first();


        if ($suitable_lesson_plan_for_user == null) { //if no found for the country or the grade or not active

            abort("500", "No suitable lesson plans were found for the lesson plan");
            return false;
        }

        $first_lesson_id_in_selected_lesson_plan = Sortinglesson::get_first_lesson_in_specific_lesson_plan($suitable_lesson_plan_for_user->id);//get first lesson for the selected leson plan


        if ($first_lesson_id_in_selected_lesson_plan == null) { //if there are no lessons on the lesson plan

            abort("500", "No lessons were found for the lesson plan");
            return false;
        }

        DB::transaction(function () use ($suitable_lesson_plan_for_user, $userRow, $first_lesson_id_in_selected_lesson_plan) {

            $new_student_assigned_lesson = new StudentAssignedLessonPlan;

            $new_student_assigned_lesson->lesson_plan_id = $suitable_lesson_plan_for_user->id;
            $new_student_assigned_lesson->user_id = $userRow->id;
            $new_student_assigned_lesson->currentTabEnum = STUDENT_ASSIGNED_LESSON_PLANS_ENUMS::GET_SHORT_SURVEY_TAB_ENUM;
            $new_student_assigned_lesson->currentLessonID = $first_lesson_id_in_selected_lesson_plan;
            $new_student_assigned_lesson->education_level = $userRow->student_grade_id;
            $new_student_assigned_lesson->save();


            $histroy_row = new StudentGradesLessonPlansHistory;

            $histroy_row->lesson_plan_id = $suitable_lesson_plan_for_user->id;
            $histroy_row->education_level = $userRow->student_grade_id;
            $histroy_row->user_id = $userRow->id;
            $histroy_row->status = STUDENT_GRADES_LESSON_PLAN_HISTORIES_ENUMS::GET_NOT_FINISHED_STATUS_ENUM;
            $histroy_row->save();

        });


        return true;
    }


    /**
     * @param $content_id
     * @todo :  check if user allowed to access this lesson or not then update its row in StudentAssignedLessonPlan to update the lesson id and tab enum
     * and check if this user on this lesson plan on this contnent has row in student_lesson_plan_progresses , if not , create new one and give status as not finished
     * @return  true
     */
    public static function studentEachLessonAccess($lesson_id)
    {


        $student_assigned_lesson_plans = \App\StudentAssignedLessonPlan::where("user_id", auth()->id())->first();

        $current_student_lesson_plan = $student_assigned_lesson_plans->lesson_plan_id;

        $isAllowed = self::checkIfUserAllowedToAccessThisLesson($lesson_id, $current_student_lesson_plan); // checks if user allowed to access this lesson or not

        if ($isAllowed == false) {
            return false;
        }


        $student_assigned_lesson_plans->currentTabEnum = STUDENT_ASSIGNED_LESSON_PLANS_ENUMS::GET_FIRST_TAB_ENUM;
        $student_assigned_lesson_plans->currentLessonID = $lesson_id;
        $student_assigned_lesson_plans->save();


        $student_lesson_plan_progresses_check = \App\StudentLessonPlanProgress::where("user_id", auth()->id())->where("lesson_plan_id", $current_student_lesson_plan)->where("content_id", $lesson_id)->first();//check if this user has this lesson plan on this content , if not create , because it has unique constraint , look its migration

        if ($student_lesson_plan_progresses_check == null) {
            $student_lesson_plan_progresses = new StudentLessonPlanProgress;
            $student_lesson_plan_progresses->lesson_plan_id = $current_student_lesson_plan;
            $student_lesson_plan_progresses->user_id = auth()->id();
            $student_lesson_plan_progresses->content_id = $lesson_id;
            $student_lesson_plan_progresses->status = STUDENT_LESSON_PLAN_PROGRESSES_ENUMS::GET_STARTED;
            $student_lesson_plan_progresses->save();
        }

        return true;

    }

    /**
     * @param $current_lesson_id
     * @param $current_user_lesson_plan
     * @return bool indicate if the student allowed to access the provided lesson or not
     * @todo  : checks if the student allowed to access the provided lesson or not by check the StudentLessonPlanProgress table
     */
    public static function checkIfUserAllowedToAccessThisLesson($current_lesson_id, $current_user_lesson_plan)
    {

        $get_previous_lessons_of_current_lesson_plan = \App\Sortinglesson::getListOfPreviousLessonsOfLessonPlanBySpecificLesson($current_user_lesson_plan, $current_lesson_id); // get list of the lessons in the lesosn plan that stands before the current lesson

        $previou_lessons_serials = $get_previous_lessons_of_current_lesson_plan->pluck("content_id"); // fetch content ids from the collection

        if ($previou_lessons_serials->count() == 0) {
            return true;
        }


        foreach ($previou_lessons_serials as $EachContentID) {

            unset($student_lesson_plan_progress);

            $student_lesson_plan_progress = StudentLessonPlanProgress::where("user_id", auth()->id())->where("lesson_plan_id", $current_user_lesson_plan)->where("content_id", $EachContentID)->where("status", STUDENT_LESSON_PLAN_PROGRESSES_ENUMS::GET_FINISHED)->first();

            if (@$student_lesson_plan_progress == null) {
                return false;
            }

        }
        return true;


    }

    /**
     * @param $lesson_plan_id
     * @param $current_content_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse | \Illuminate\View\View
     * @todo : return redirect to the next lesson , or return view to handle if the current lesson is the last , or handle any other error by 404 view
     */

    public function navigateStudentToTheNextLesson($current_content_id)
    {


        $lesson_plan_id = StudentAssignedLessonPlan::where("user_id", auth()->id())->first()->lesson_plan_id;

        $next_lesson_id = Sortinglesson::getNextLessonOfTheLessonPlan($lesson_plan_id, $current_content_id);


        if ($next_lesson_id == null) { // null mean error
            //   self::DeleteCurrentLessonPlanAndUpdateStatusOfLessonPlanInHistoryTableForUser();
//            return view("errors.404");
        } elseif ($next_lesson_id == false) { //false mean there is no next lesson

            return view("inc.handleFinishedLessonPlan");

        } else {

            return Redirect::to("content/" . $next_lesson_id);

        }

    }

    /**
     * This function is an exception because we already have function for mark as complete and function for navigation
     * so this not a duplication , but its a difference behaviour because at long survery , we have one button for both of mark as complete and navigation
     */
    public function exception_mark_tab_as_completed_and_navigate_to_next_lesson($current_content_id, $tab_enum)
    {


        if (in_array($tab_enum, STUDENT_ASSIGNED_LESSON_PLANS_ENUMS::CURRENT_TABS_ENUMS) == false) { // if the provided enum is the last ,then there is no next tab in this lesson
            return view("errors.404");
        }

        CommonStudentTabsProcesses::nextTabButtonProcess($current_content_id, $tab_enum, false);

        return $this->navigateStudentToTheNextLesson($current_content_id);

    }


    /**
     * @return View | redirect to last lesson the user was working on last time
     */
    public function navigateToCurrentLesson()
    {

        $currentLessonDetails = StudentAssignedLessonPlan::where("user_id", auth()->id())->first();
        $currentLessonId = $currentLessonDetails->currentLessonID;
        $currentLessonTapEnum = $currentLessonDetails->currentTabEnum;


        return CommonStudentTabsProcesses::navigateStudentToSpecificTabOfSpecificLesson($currentLessonId, $currentLessonTapEnum);

    }


    /**
     * @todo : get ordered collection of id and content name of the contents for the current lesson plan to be used in the dasboard
     * how we get the order correctly ? because we are getting the lessons from progress order by id which inserted when the student access each lesson , and when the user access it
     * and by adding the last opened lesson to the end of the list , we have now an ordered list
     * @return \Illuminate\Support\Collection
     */

    static public function get_list_of_student_lesson_plan_finised_and_opened_lessons_orderd_by_sorting_desc()
    {
        $currentLessonPlanRow = StudentAssignedLessonPlan::where("user_id", auth()->id())->first();
        if (!$currentLessonPlanRow) {
            abort("500", "No lessons were found for the lesson plan");
            return false;
        }
        $currentLessonPlanId = $currentLessonPlanRow->lesson_plan_id;
        // $currentLessonContentId = $currentLessonPlanRow->currentLessonID;

        $all_finished_or_in_progress_lessons = StudentLessonPlanProgress::where(['user_id' => auth()->id(), 'lesson_plan_id' => $currentLessonPlanId])->orderBy('id', 'desc')->get();
        $contentArr = [];

        foreach ($all_finished_or_in_progress_lessons as $contentDetails) {

            $currentLesson = Content::where('id', $contentDetails->content_id)->select("id", 'content_name')->first();

            $contentArr [] = ["content_id" => $currentLesson->id, "content_name" => $currentLesson->content_name, "status" => $contentDetails->status];
        }


        return collect($contentArr);

    }


    static function DeleteCurrentLessonPlanAndUpdateStatusOfLessonPlanInHistoryTableForUser()
    {
        $currentLessonPlan = StudentAssignedLessonPlan::where('user_id', auth()->id())->first();
        if ($currentLessonPlan) {
            self::updateStatusOfCurrentLessonPlanToCompleteAfterFinishCurrentLessonPlan();
            self::DeleteCurrentAssignedLessonPlanForUserAfterFinishCurrentLessonPlan();
            $nextGrade = self::updateLevelIdForUserAfterFinishCurrentLessonPlan();

            return \redirect('Student/placement_test/' . $nextGrade);
        }
        return \redirect('Student/placement_test/' . auth()->user()->student_grade_id);

    }


    static function updateLevelIdForUserAfterFinishCurrentLessonPlan()
    {


        $userLevel = User::find(auth()->id());
        $parentId = EducationLevel::find(auth()->user()->student_grade_id)->parent_id;
        $nextGrade = EducationLevel::where('id', '>', $parentId)->min('id');

        $userLevel->student_grade_id = $nextGrade;

        $userLevel->save();
        return $nextGrade;
    }

    static function DeleteCurrentAssignedLessonPlanForUserAfterFinishCurrentLessonPlan()
    {
        $currentLessonPlan = StudentAssignedLessonPlan::where('user_id', auth()->id())->first();
        $currentLessonPlan->delete();
    }

    static function updateStatusOfCurrentLessonPlanToCompleteAfterFinishCurrentLessonPlan()
    {
        $historyLessonPlan = StudentGradesLessonPlansHistory::where(['user_id' => auth()->id(), 'education_level' => auth()->user()->student_grade_id])->first();

        $historyLessonPlan->status = STUDENT_GRADES_LESSON_PLAN_HISTORIES_ENUMS::GET_FINISHED_STATUS_ENUM;
        $historyLessonPlan->save();

    }


}
