<?php

namespace App\Http\Controllers;

use App\Content;
use App\Http\OwnClasses\STUDENT_GRADES_LESSON_PLAN_HISTORIES_ENUMS;
use App\Http\OwnClasses\STUDENT_LESSON_PLAN_PROGRESSES_ENUMS;
use App\Sortinglesson;
use App\StudentAssignedLessonPlan;
use App\StudentGradesLessonPlansHistory;
use App\StudentLessonPlanProgress;

class StudentDashboard extends Controller
{

    public function index()
    {

        $current_student_lesson_plan = StudentAssignedLessonPlan::where("user_id", auth()->id())->first();
        if ($current_student_lesson_plan) {
//        $finishedLessons = CommonStudentLessonsProcesses::get_list_of_student_lesson_plan_finised_and_opened_lessons_orderd_by_sorting_desc();
            $max_id = StudentLessonPlanProgress::where(['user_id' => auth()->id(), 'lesson_plan_id' => $current_student_lesson_plan->lesson_plan_id])->max('id');

            if (!$max_id) {
                $min_sorting = Sortinglesson::where(['lesson_id' => $current_student_lesson_plan->lesson_plan_id])->min('sorting');
                $content_id = Sortinglesson::where(['lesson_id' => $current_student_lesson_plan->lesson_plan_id, 'sorting' => $min_sorting])->first()->content_id;
            }
            $content = StudentLessonPlanProgress::find($max_id);

            if ($content) {
                $content_id = $content->content_id;
            }
            $Sorting_id = Sortinglesson::where('content_id', $content_id)->first();

            $pre_contents_id = Sortinglesson::where(['lesson_id' => $current_student_lesson_plan->lesson_plan_id])->where('sorting', '<', $Sorting_id->sorting)->limit(5)->get()->pluck('content_id')->toArray();
            $next_contents_id = Sortinglesson::where(['lesson_id' => $current_student_lesson_plan->lesson_plan_id])->where('sorting', '>=', $Sorting_id->sorting)->limit(10 - count($pre_contents_id))->get()->pluck('content_id')->toArray();
            $allContentsIds = array_merge($pre_contents_id, $next_contents_id);
            for ($i = 0; $i < count($allContentsIds); $i++) {
                $currentLesson = Content::where('id', $allContentsIds[$i])->select("id", 'content_name')->first();
                $getStatus = StudentLessonPlanProgress::where(['user_id' => auth()->id(), 'lesson_plan_id' => $current_student_lesson_plan->lesson_plan_id, 'content_id' => $allContentsIds[$i]])->first();
                $status = -1;
                if ($getStatus) {
                    $status = $getStatus->status;
                }
                $allContentArr[] = ["content_id" => $currentLesson->id, "content_name" => $currentLesson->content_name, "status" => $status];
            }
            $contents = Sortinglesson::get_all_lessons_for_specific_lesson_orderd_by_sorting_obligatory($current_student_lesson_plan->lesson_plan_id);
            $current_lesson_detail = Content::find($content_id);
            $allLessonsOnThePlan = Sortinglesson::where('lesson_id', $current_student_lesson_plan->lesson_plan_id)->get();
            $allFinshedLessonsByUser = StudentLessonPlanProgress::where(['user_id' => auth()->id(), 'lesson_plan_id' => $current_student_lesson_plan->lesson_plan_id, 'status' => STUDENT_LESSON_PLAN_PROGRESSES_ENUMS::GET_FINISHED])->get();
            $PogressPrecentge = round(($allFinshedLessonsByUser->count() / $allLessonsOnThePlan->count()) * 100);
            $lesson_plan_id = $current_student_lesson_plan->lesson_plan_id;
            return view('student.dashboard.dashboard')->with(compact('current_lesson_detail','contents'))->with(compact('allContentArr'))->with(compact('PogressPrecentge'))->with(compact('lesson_plan_id'))->with('finshedLessson',$allFinshedLessonsByUser->count())->with('allLessons',$allLessonsOnThePlan->count());
        }
        abort("500", "No lessons were found for the lesson plan");
    }

    public function list_of_lessons()
    {


        $current_student_lesson_plan = StudentAssignedLessonPlan::where("user_id", auth()->id())->first();

        $completedLesson = StudentLessonPlanProgress::where(['user_id' => auth()->id(), 'content_id' => $current_student_lesson_plan->currentLessonID])->first();

        $object = new CommonStudentLessonsProcesses;
        if ($completedLesson) {
            if ($object->navigateStudentToTheNextLesson($current_student_lesson_plan->currentLessonID) && $completedLesson->status == STUDENT_GRADES_LESSON_PLAN_HISTORIES_ENUMS::GET_FINISHED_STATUS_ENUM) {
                $url_feedback_for_lessonplan = 'placement_test/feedback/LessonPlan';
            }
        }
        $contents = Sortinglesson::get_all_lessons_for_specific_lesson_orderd_by_sorting_obligatory($current_student_lesson_plan->lesson_plan_id);

        return view('student.lessons')->with(compact("contents", "url_feedback_for_lessonplan"))->with("lesson_plan_id", $current_student_lesson_plan->lesson_plan_id);
    }


    public function feedbackForLessonPlan()
    {

        $lastLessonPlan = StudentGradesLessonPlansHistory::where('user_id', auth()->id())->orderBy('id', 'desc')->first()->lesson_plan_id;
        $allLessonPlanContents = StudentLessonPlanProgress::with('content')->where(['user_id' => auth()->id(), 'lesson_plan_id' => $lastLessonPlan])->get();
        return view('student.placementTest.feedback_for_lessonplan', compact('allLessonPlanContents'));

    }

    public
    function noLessonPlanYat()
    {
        return view('student.noLessonPlanYat');

    }

    static function getPointsForStudent($date, $lesson_plan_id)
    {
        $result = 0;
        $allContentFinshedToDay = \App\StudentLessonPlanProgress::where(['user_id' => auth()->id(), 'lesson_plan_id' => $lesson_plan_id])->where('updated_at', 'like', $date . '%')->get();
        foreach ($allContentFinshedToDay as $finshedContent) {

            $result += $finshedContent->degree + $finshedContent->bonus;
        }
        return $result;
    }

}
