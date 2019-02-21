<?php

namespace App\Http\Controllers;

use App\EducationLevel;
use App\PlacementTestQuestionAnswers;
use App\StudentAssignedLessonPlan;
use App\StudentPlacementTestAnswers;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\PlacementTestQuestions;
use DB;
use App\Http\OwnClasses\STUDENT_PLACEMENT_TEST_RESULT_ENUMS;

class StudentPlacementTest extends Controller
{

    public function instruction($placement_id)
    {

        return view('student.placementTest.instruction', compact(with('placement_id')));
    }

    static function DeleteAllUserAnswersInAllPlacementTestSInSpecificLevel()
    {
        $AllPlacementTest = \App\PlacementTest::where(['country' => auth()->user()->student_country_id, 'parent_education_level' => auth()->user()->student_grade_id, 'status' => 1])->get()->pluck('id')->toArray();
        foreach ($AllPlacementTest as $exam_id) {
            $rows = StudentPlacementTestAnswers::where(['user_id' => auth()->id(), 'exam_id' => $exam_id])->get();

            if ($rows->count() > 0) {
                foreach ($rows as $row)
                    $row->delete();

            }
        }
    }

    public function feedback()
    {

        $parent_level_id = EducationLevel::find(auth()->user()->student_grade_id)->parent_id;
        $feedback = \App\StudentPlacementTest::with('level:id,name')->where(['user_id' => auth()->id(), 'level_id' => $parent_level_id])->first();

        return view('student.placementTest.feedback', compact('feedback'));
    }

    public static function checkIfPlacementTestHasbeenCompleteOrNotByUser($grade_id)
    {
        $parent_id = EducationLevel::find($grade_id)->parent_id;


        if ($parent_id) {
            return true;
        }
        $row = \App\StudentPlacementTest::where(['user_id' => auth()->id(), 'level_id' => $parent_id])->first();


        if ($row) {

            return true;
        }


        return false;

        // return $placement_test;
    }

    public static function viewPlacementTestToStudent($exam_id)
    {
        $parent_id = EducationLevel::find(auth()->user()->student_grade_id)->parent_id;
        $row = \App\StudentPlacementTest::where(['user_id' => auth()->id(), 'level_id' => $parent_id])->first();


        if ($row) {

            return redirect('Student/placement_test/feedback/');
        }
        $PlacementTest = \App\PlacementTest::where('id', $exam_id)->inRandomOrder()->first();
        if (!$PlacementTest) {
            dd('no placement tests');
        }
        $placement_test = PlacementTestQuestions::with('placementQuestionAnswers')->inRandomOrder()->where('exam_id', $PlacementTest->id)->wherenotExists(function ($query) {
            $query->select(DB::raw(1))
                ->from('student_placement_test_answers')
                ->whereRaw('student_placement_test_answers.question_id = placement_test_questions.id')
                ->where('user_id', auth()->id());
        })->paginate(1);
        //abort("500", "No suitable lesson plans were found for the lesson plan");
        $exam_id = $PlacementTest->id;
        if ($placement_test->count() > 0) {
            return view('student.placementTest.placement_test', compact('placement_test', 'exam_id'));
        }
        $user = User::find(auth()->id());
        $parent_id = EducationLevel::find($user->student_grade_id)->parent_id;

        if (!$parent_id) {
            self::doActionOfUpdateLevelAndAssignLessonPlanForUser($exam_id);
        }


        return redirect('Student/placement_test/feedback/');
        //return redirect('/studentDashboard');

        // return $placement_test;
    }

    public function store(Request $request, $exam_id, $question_id)
    {

        if (self::checkIfQuestionHasAnswerByUser($question_id)) {
            session()->flash('message', 'تمت الاجابه على هذا السؤال من قبل ');
            return redirect()->back();
        }
        $ans = $request->ans;
        if (!$request->ans) {
            $ans = PlacementTestQuestionAnswers::where(['question_id' => $question_id, 'is_true' => 0])->first()->id;
        }
        $row = new StudentPlacementTestAnswers();
        $row->user_id = auth()->id();
        $row->exam_id = $exam_id;
        $row->question_id = $question_id;
        $row->student_answer_id = $ans;
        $row->save();

        return redirect()->back();


    }

    public static function checkIfQuestionHasAnswerByUser($question_id)
    {

        $row = StudentPlacementTestAnswers::where(['user_id' => auth()->id(), 'question_id' => $question_id])->first();

        if ($row) {
            return true;
        }
        return false;
    }

    public static function DeletePlacementTestQuestionAnswersIfNotCompleted($PlacementTest_id)
    {
        //$PlacementTest_id = \App\PlacementTest::where(['country' => auth()->user()->student_country_id, 'parent_education_level' => auth()->user()->student_grade_id])->first()->id;

        $rows = StudentPlacementTestAnswers::where(['user_id' => auth()->id(), 'exam_id' => $PlacementTest_id])->get();

        if ($rows->count() > 0) {
            foreach ($rows as $row)
                $row->delete();

        }

    }

    public static function ComputeResultOfPlacementTestWhenFinished($PlacementTest_id)
    {

        // $PlacementTest_id = \App\PlacementTest::where(['country' => auth()->user()->student_country_id, 'parent_education_level' => auth()->user()->student_grade_id])->first()->id;

        $AllUsersAnswers = StudentPlacementTestAnswers::where(['user_id' => auth()->id(), 'exam_id' => $PlacementTest_id])->get();

        $AllQuestion = $AllUsersAnswers->pluck('question_id')->toArray();
        $userAnswers = $AllUsersAnswers->pluck('student_answer_id')->toArray();
        $AllQuestionAnswersTrue = PlacementTestQuestionAnswers::wherein('question_id', $AllQuestion)->where('is_true', 1)->get()->pluck('id')->toArray();

        $result = array_intersect($userAnswers, $AllQuestionAnswersTrue);

        $gradePrcent = round((count($result) / count($AllQuestionAnswersTrue)) * 100);

        $grade = STUDENT_PLACEMENT_TEST_RESULT_ENUMS::getGrade($gradePrcent);


        return $gradePrcent;

//foreach ()
//
//
    }

    public static function getLevelIdForUser($gradePrcent)
    {

        $grade = STUDENT_PLACEMENT_TEST_RESULT_ENUMS::getGrade($gradePrcent);
        $level_id = EducationLevel::where('parent_id', auth()->user()->student_grade_id)->where('name', 'like', $grade)->first();


        return $level_id->id;
    }

    public static function updateGradeIdForUser($grade_id)
    {

        $user = User::find(auth()->id());
        $user->student_grade_id = $grade_id;
        $user->save();
    }

    public static function savePlacementTestForStudent($gradePrcent)
    {

        $placement_test = new \App\StudentPlacementTest();
        $placement_test->user_id = auth()->id();
        $placement_test->level_id = auth()->user()->student_grade_id;
        $placement_test->grade = $gradePrcent;
        $placement_test->save();
    }


    public static function doActionOfUpdateLevelAndAssignLessonPlanForUser($exam_id)
    {


        $gradePrcent = self::ComputeResultOfPlacementTestWhenFinished($exam_id);

        self::savePlacementTestForStudent($gradePrcent);// save placement test after student finish it
        $get_level_id = self::getLevelIdForUser($gradePrcent);
        self::updateGradeIdForUser($get_level_id);//update level_id for user after finish placement test
        \App\Http\Controllers\CommonStudentLessonsProcesses::assignLessonPlan(auth()->id());//assign lesson plan to student after finish placement test

    }

    public static function checkIfUserHavePlacementTestsBefore()
    {

        $placementTest = \App\StudentPlacementTest::where('user_id', auth()->id())->first();

        if ($placementTest) {
            return true;
        }
        return false;

    }


}
