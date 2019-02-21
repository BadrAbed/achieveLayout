<?php

namespace App\Http\Controllers;

use App\Http\OwnClasses\CONTENT_FOLLOW_STATUS_ENUMS;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\AssignLessonsToReviewers;
use App\EducationLevel;
use Illuminate\Support\Facades\Session;
use App\Content;
use App\Question;

use Illuminate\Validation\Rule;

class QuestionsEditorController extends Controller
{
    public function home()
    {
        return view('questionsEditor.home');
    }

    public function index()
    {
        return view('questionsEditor.viewAllContent');
    }

    public function MyLessonsView()
    {
        return view('questionsEditor.myLessons');

    }

    public function MyLessons()
    {
        $condition = 'whereIn';
        return response()->json(self::getAllLessonsAndGetMyLessonsWithAjax($condition));
    }

    public function AjaxAllLessons()
    {
        $condition = 'whereNotIn';
        return response()->json(self::getAllLessonsAndGetMyLessonsWithAjax($condition));

    }

    public function AssignLessonsToQuestionsEditor($content_id)
    {
        $row = AssignLessonsToReviewers::where(['content_id' => $content_id, 'status' => CONTENT_FOLLOW_STATUS_ENUMS::CREATE_QUESTIONS])->first();
        if ($row) {
            Session::flash('message', 'المحتوى مع مراجع بالفعل');
            return redirect()->back();
        }
        $newContent = new AssignLessonsToReviewers();
        $newContent->user_id = auth()->id();
        $newContent->content_id = $content_id;
        $newContent->status = CONTENT_FOLLOW_STATUS_ENUMS::CREATE_QUESTIONS;
        $newContent->save();
        Session::flash('message', 'تم اضافه الدروس الى قائمة دروسك');
        return redirect('allQuestions/' . $content_id);
    }

    static function getAllLessonsAndGetMyLessonsWithAjax($condition, $status = CONTENT_FOLLOW_STATUS_ENUMS::CREATE_QUESTIONS)
    {

        $ckeckRow = AssignLessonsToReviewers::where(['user_id' => auth()->id(), 'status' => $status])->get()->pluck('content_id')->toArray();
        $data = Content::with('Country', 'grade', 'Categories', 'user')->orderBy("id", "desc")->where(["complete" => 1, 'flowStatus' => $status])->$condition('id', $ckeckRow)->get();

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

                if (strstr((string)$row->country->name, (string)$_GET["country"]) == false) {
                    continue;
                }
            }

            $parent = EducationLevel::where('id', $row->grade->parent_id)->first();
            $arr[] = array("ID" => htmlspecialchars($row->id, ENT_QUOTES), "Created_at" => htmlspecialchars($row->created_at, ENT_QUOTES), "content_name" => htmlspecialchars($row->content_name, ENT_QUOTES), "grade" => htmlspecialchars($row->grade->name . "-" . $parent->name, ENT_QUOTES), "country" => htmlspecialchars(($row->Country) ? $row->Country->name : "عام", ENT_QUOTES), "user" => htmlspecialchars($row->user->name, ENT_QUOTES), "category" => htmlspecialchars($row->Categories->name, ENT_QUOTES));
            unset($row);
        }

        // $arr["arrCount"]=htmlspecialchars(count($arr),ENT_QUOTES);
        return $arr;
    }

    public function createQuestions($type, $content_id)
    {

        return view('questionsEditor.createQuestions', compact('content_id', 'type'));
    }

    Public function storeQuestions($type, $content_id, Request $request)
    {
        $button_type = $request->submitType;

        if ($type == \App\Http\OwnClasses\STUDENT_ASSIGNED_LESSON_PLANS_ENUMS::GET_LONG_QUESTIONS_TAB_ENUM) {
            $type = 'addationquest';
        } else {
            $type = 'activityquest';
        }
        $rules_array = [

            'questions.*.question' => 'required|max:191',
            'questions.*.true_answer' => 'required',
        ];

        $messages_array = [
            'questions.*.question.required' => 'من فضلك ادخل اسم السؤال',
            'questions.*.question.max' => 'اسم السوال يجب الا يزيد عن 191 حرف',

            'questions.*.ans1.required' => 'من فضلك الاجابه الاولى',
            'questions.*.ans2.required' => 'من فضلك الاجابه الثانيه',
            'questions.*.ans3.required' => 'من فضلك الاجابه الثالثه',
            'questions.*.ans4.required' => 'من فضلك الاجابه الرابعه',
            'questions.*.ans1.max' => 'الاجابه الاولى يجب الا تزيد عن 191 حرف',
            'questions.*.ans2.max' => 'الاجابه الثانيه يجب الا تزيد عن 191 حرف',
            'questions.*.ans3.max' => 'الاجابه الثالثه يجب الا تزيد عن 191 حرف',
            'questions.*.ans4.max' => 'الاجابه الرابعه يجب الا تزيد عن 191 حرف',

            'questions.*.true_answer.required' => 'من فضلك اختر الاجابه الصحيح من حقل الاختيارات',
        ];

        foreach ($request->questions as $arrIndex => $arrValue) { //add unqiue constraint of answers to each question answers
            $messages_array["questions.$arrIndex.ans1.not_in"] = "لابد ان تكون الاجابه الاولي مختلفه";
            $messages_array["questions.$arrIndex.ans2.not_in"] = "لابد ان تكون الاجابه الثانيه مختلفه";
            $messages_array["questions.$arrIndex.ans3.not_in"] = "لابد ان تكون الاجابه الثالثه مختلفه";
            $messages_array["questions.$arrIndex.ans4.not_in"] = "لابد ان تكون الاجابه الرابعه مختلفه";

            $rules_array ["questions.$arrIndex.ans1"] = ["required", Rule::notIn([$request->questions[$arrIndex]["ans3"], $request->questions[$arrIndex]["ans2"], $request->questions[$arrIndex]["ans4"]]), "max:191"];

            $rules_array ["questions.$arrIndex.ans2"] = ["required", Rule::notIn([$request->questions[$arrIndex]["ans3"], $request->questions[$arrIndex]["ans1"], $request->questions[$arrIndex]["ans4"]]), "max:191"];
            $rules_array ["questions.$arrIndex.ans3"] = ["required", Rule::notIn([$request->questions[$arrIndex]["ans1"], $request->questions[$arrIndex]["ans2"], $request->questions[$arrIndex]["ans4"]]), "max:191"];
            $rules_array ["questions.$arrIndex.ans4"] = ["required", Rule::notIn([$request->questions[$arrIndex]["ans3"], $request->questions[$arrIndex]["ans1"], $request->questions[$arrIndex]["ans2"]]), "max:191"];

        }
        $questions = $request->input('questions');
//        foreach ($questions as $question) {
//            if ($question['true_answer'] == "ans1") {
//                $true = $question['ans1'];
//
//            } elseif ($question['true_answer'] == "ans2") {
//                $true = $question['ans2'];
//
//            } elseif ($question['true_answer'] == "ans3") {
//                $true = $question['ans3'];
//
//            } elseif ($question['true_answer'] == "ans4") {
//                $true = $question['ans4'];
//            }
//        }
        $data = [];
        if (is_array($questions) || is_object($questions)) {

            foreach ($questions as $question) {


                $array = array(
                    'question' => $question['question'],
                    'ans1' => $question['ans1'],
                    'ans2' => $question['ans2'],
                    'ans3' => $question['ans3'],
                    'ans4' => $question['ans4'],

                    'true_answer' => $question['true_answer'],
                    'user_id' => auth()->id(),
                    'type' => $type,
                    'content_id' => $content_id
                );
                array_push($data, $array);

            }

        }
// if($button_type=='skip'){
// 	return redirect("QuestionsEditor/create/Questions/" . \App\Http\OwnClasses\STUDENT_ASSIGNED_LESSON_PLANS_ENUMS::GET_LONG_QUESTIONS_TAB_ENUM . "/$content_id");
// }
        Question::insert($data);
        if ($button_type == 'saveAndStay') {
            return redirect()->back();
        }
        if ($button_type == 'saveAndNext') {
            if ($type == 'activityquest') {
                return redirect("QuestionsEditor/create/Questions/" . \App\Http\OwnClasses\STUDENT_ASSIGNED_LESSON_PLANS_ENUMS::GET_LONG_QUESTIONS_TAB_ENUM . "/$content_id");
            } else {
                Session::flash('message', 'تمت اضاقة الاسئلة بنجاح ');
                return redirect('allQuestions/' . $content_id);
            }
        }
    }

    public function ResendingQuestions()
    {
        $contents_idsUser = AssignLessonsToReviewers::where(['user_id' => auth()->id()])->get()->pluck('content_id')->toArray();
        $contents = Content::with('Country', 'grade', 'Categories', 'user')->orderBy("id", "desc")->where(["complete" => 1])->where('flowStatus', CONTENT_FOLLOW_STATUS_ENUMS::REFUSE_QUESTIONS)->whereIn('id', $contents_idsUser)->get();
        NotificationsController::markAsRead();
        return view('questionsEditor.resendingQuestions', compact('contents'));
    }

}


