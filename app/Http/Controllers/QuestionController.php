<?php

namespace App\Http\Controllers;

use App\AssignLessonsToReviewers;
use App\Http\OwnClasses\CONTENT_FOLLOW_STATUS_ENUMS;
use App\Http\OwnClasses\TYPE_OF_USERS_ENUMS;
use App\StudentAssignedLessonPlan;
use App\StudentGradesLessonPlansHistory;
use App\StudentLessonPlanProgress;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\DB;
use App\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Input;
use Session;
use Illuminate\Pagination\Paginator;
use App\Content;
use \App\Answer_Questions;
use App\Http\OwnClasses\Permissions;
use Illuminate\Validation\Rule;

class QuestionController extends Controller
{
//    public function __construct()
//    {
//        $this->middleware("Permissions:content");//permissions middleware
//    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $lesson_plan_id = StudentAssignedLessonPlan::where('user_id', auth()->id())->first()->lesson_plan_id;

        $answer = new Answer_Questions;
        $answer->user_id = auth()->id();
        $answer->answer = $request->ans;
        $answer->content_id = $request->content_id;
        $answer->status = 1;
        $answer->degree = $request->degree;
        $answer->reattempt_questions = $request->number_of_attempt;
        $answer->question_id = $request->quest_id;
        $answer->lesson_plan_id = $lesson_plan_id;

        $answer->save();
        return response($answer);
//return response( $request->all);
//        $data = [];
//        $questions = $request->input('questions');
//        $lesson_plan_id = StudentAssignedLessonPlan::where('user_id', auth()->id())->first()->lesson_plan_id;
//        if (is_array($questions) || is_object($questions)) {
//            foreach ($questions as $question) {
//
////
//                $answer = new Answer_Questions;
//                $answer->user_id = auth()->id();
//                $answer->answer = $question['ans'];
//                $answer->content_id = request('content_id');
//                $answer->question_id = $question['question'];
//                $answer->lesson_plan_id = $lesson_plan_id;
//
//                $answer->save();
//
//
////                DB::table('answers_questions')->insert([
////                    ['user_id' => 1, 'answer' => $question['ans'], 'content_id' => request('content_id'), 'question_id' => $question['question']]
////                ]);
//            }
//
//            if (request('typeofquest') == "activity") {
//                return Redirect()->back();
//            }
//            if (request('typeofquest') == "addationquest") {
//                return Redirect()->back()->with('addationdata', ['answertab']);
//            }
//
//            /* foreach ($quest as $ques) {
//
//                   DB::table('answers_questions')->insert([
//                       ['user_id' => 1, 'answer' => , 'content_id' => 1, 'question_id' => $ques]
//
//                   ]);
//
//
//           }*/
//            //
//        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, $type, $content_id)
    {


        return view('admin.questions.create')->with('content_id', $content_id)->with(compact('type'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $content_id)
    {


        $rules_array = [];
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

//            if ($request->questions[$arrIndex]["ans3"]) {
//                $rules_array ["questions.$arrIndex.ans3"] = ["required", Rule::notIn([$request->questions[$arrIndex]["ans1"], $request->questions[$arrIndex]["ans2"], $request->questions[$arrIndex]["ans4"]]), "max:191"];
//
//            }
//            if ($request->questions[$arrIndex]["ans4"]) {
//                $rules_array ["questions.$arrIndex.ans4"] = ["required", Rule::notIn([$request->questions[$arrIndex]["ans3"], $request->questions[$arrIndex]["ans1"], $request->questions[$arrIndex]["ans2"]]), "max:191"];
//
//            }
        }


        //  foreach ($request->all->questions)


        request()->validate($rules_array,
            $messages_array);

        $data = [];
        //return $request;
        $questions = $request->input('questions');
        foreach ($questions as $question) {
            if ($question['true_answer'] == "ans1") {
                $true = $question['ans1'];

            } elseif ($question['true_answer'] == "ans2") {
                $true = $question['ans2'];

            } elseif ($question['true_answer'] == "ans3") {
                $true = $question['ans3'];

            } elseif ($question['true_answer'] == "ans4") {
                $true = $question['ans4'];
            }
        }
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
                    'type' => request('typeofquest'),
                    'content_id' => $content_id
                );
                array_push($data, $array);
            }

            //   print_r($data);
            // die();
        }

        Question::insert($data);

        // redirect
        if (request('typeofquest') == "activityquest") {
            Session::flash('message', 'لقد تم ادخال السؤال');
            if (auth()->user()->is_permission == \App\Http\OwnClasses\TYPE_OF_USERS_ENUMS::LEADER || auth()->user()->is_permission == \App\Http\OwnClasses\TYPE_OF_USERS_ENUMS::SUPER_ADMIN) {
                return redirect('stretch-artical/create/' . $content_id);
            }


        }
        if (request('typeofquest') == "addationquest") {
            Session::flash('message', 'لقد تم ادخال السؤال');
            Session::forget('messagebar');
            if (auth()->user()->is_permission == \App\Http\OwnClasses\TYPE_OF_USERS_ENUMS::LEADER || auth()->user()->is_permission == \App\Http\OwnClasses\TYPE_OF_USERS_ENUMS::SUPER_ADMIN) {
                return redirect('create/vocabularys/' . $content_id);
            }
            //
            return redirect()->back();
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, $type, $tab_enum)
    {
        $lesson_plan_id = null;
        $answerquest = Question::where('type', 'activityquest')->where('content_id', $id)->get();
        $answeraddationquest = Question::where('type', 'addationquest')->where('content_id', $id)->get();
        $content_id = $id;
        $content = Content::with('Links', 'articalnormal', 'articalstrach', 'vocab')->find($id);
        if (Permissions::STUDENT_PERMISSION_ENUM == auth()->user()->is_permission) {

            $isAllowedStudentLessonAccess = CommonStudentLessonsProcesses::studentEachLessonAccess($content_id); // make some processes and checks before navigate to the view

            $isAllowedStudentTabAccess = CommonStudentTabsProcesses::isStudentAllowedToAccessThisTab($content_id, $tab_enum);


            if ($isAllowedStudentLessonAccess == false || $isAllowedStudentTabAccess == false) { // if it not allowed to access this content or this tab , navigate him to no premissions page
                return Redirect::back()->withErrors(["الرجاء الانتهاء من كل الخطوات السابقه لتتمكن من الدخول للمرحله التاليه"]);

                //   return view("permissions.noPermission");
            }

            CommonStudentTabsProcesses::EachTabAccessProcesses($tab_enum, $content_id);
            $viewFirstName = "student";

        } else {
            $viewFirstName = "admin";
        }

        if ($type == 0) {

            $viewName = $viewFirstName . '.content.question.show_short';

        } elseif ($type == 1) {
            $viewName = $viewFirstName . '.content.question.show_long';

        }
        //$quest=Question::where('id','!=',$answer->question_id)->paginate(1);
        if (Permissions::STUDENT_PERMISSION_ENUM == auth()->user()->is_permission) {
            $lesson_plan_id = StudentAssignedLessonPlan::where('user_id', auth()->id())->first()->lesson_plan_id;

        }

        $quest = DB::table('questions')->where('type', 'activityquest')->where('content_id', $id)
            ->wherenotExists(function ($query) use ($lesson_plan_id) {

                $query->select(DB::raw(1))
                    ->from('answers_questions')
                    ->whereRaw('answers_questions.question_id = questions.id')
                    ->where('user_id', auth()->id())
                    ->where('status', 1)
                    ->where('lesson_plan_id', $lesson_plan_id);
            })->get();
        $allQuest=DB::table('questions')->where('type', 'activityquest')->where('content_id', $id)
            ->whereExists(function ($query) use ($lesson_plan_id) {

                $query->select(DB::raw(1))
                    ->from('answers_questions')
                    ->whereRaw('answers_questions.question_id = questions.id')
                    ->where('user_id', auth()->id())
                    ->where('status', 1)
                    ->where('lesson_plan_id', $lesson_plan_id);
            })->get();

        $addationquests = DB::table('questions')->where('type', 'addationquest')->where('content_id', $id)
            ->wherenotExists(function ($query) use ($lesson_plan_id) {
                $query->select(DB::raw(1))
                    ->from('answers_questions')
                    ->whereRaw('answers_questions.question_id = questions.id')
                    ->where('user_id', auth()->id())
                    ->where('lesson_plan_id', $lesson_plan_id);
            })->get();

        $alladdation=DB::table('questions')->where('type', 'addationquest')->where('content_id', $id)
            ->whereExists(function ($query) use ($lesson_plan_id) {
                $query->select(DB::raw(1))
                    ->from('answers_questions')
                    ->whereRaw('answers_questions.question_id = questions.id')
                    ->where('user_id', auth()->id())
                    ->where('lesson_plan_id', $lesson_plan_id);
            })->get();

        if ($quest->count() == 0 && $type == 0) {
            if (Permissions::STUDENT_PERMISSION_ENUM == auth()->user()->is_permission) {
                $result = static::getResultOFQuestionForSpecificContent($id, $lesson_plan_id);
            }
            return view($viewName)->with(compact('quest'))->with(compact('addationquests'))->with(compact('content'))->with(compact('content_id'))->with(compact('answerquest'))
                ->with(compact('answeraddationquest'))->with(compact('result'))->with(compact('allQuest'))->with(compact('alladdation'));
        }
        if ($addationquests->count() == 0 && $type == 1) {

            if (Permissions::STUDENT_PERMISSION_ENUM == auth()->user()->is_permission) {
                $result = static::getResultOFQuestionForSpecificContent($id, $lesson_plan_id);
            }
            return view($viewName)->with(compact('quest'))->with(compact('addationquests'))->with(compact('content'))->with(compact('content_id'))->with(compact('answerquest'))
                ->with(compact('answeraddationquest'))->with(compact('result'))->with(compact('alladdation'))->with(compact('allQuest'));
        }

        return view($viewName)->with(compact('quest'))->with(compact('addationquests'))->with(compact('content'))->with(compact('content_id'))->with(compact('answerquest'))
            ->with(compact('answeraddationquest'))->with(compact('result'))->with(compact('allQuest'))->with(compact('alladdation'));


    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {//|| auth()->user()->is_permission == TYPE_OF_USERS_ENUMS::QUESTIONEDITOR) {

        $question = Question::find($id);
        if ($question && auth()->user()->is_permission == TYPE_OF_USERS_ENUMS::QUESTIONEDITOR) {

            if (self::checkIfUserALLowToEditQuestions($question->content_id) == false) {
                Session::flash('message', 'لا يمكنك تعديل السؤال ');
                return \redirect()->back();
            }
        }
        if ($question && auth()->user()->is_permission == TYPE_OF_USERS_ENUMS:: QUESTIONREVIEWER) {
            if (self::checkIfUserALLowToEditQuestions($question->content_id) == false) {
                Session::flash('message', 'لا يمكنك تعديل السؤال ');
                return \redirect()->back();
            }
        }
        if ($question && auth()->user()->is_permission != TYPE_OF_USERS_ENUMS::SUPER_ADMIN) {
            $content = Content::find($question->content_id);
            if ($content->flowStatus == CONTENT_FOLLOW_STATUS_ENUMS::PUBLISH) {
                Session::flash('message', 'لا يمكنك تعديل السؤال ');
                return \redirect()->back();
            }
        }
        $content_id = $question->content_id;
        return view('admin.questions.edit', compact('question', 'content_id'));
    }

    public function allQuestions($content_id)
    {


        if (self::checkIfUserALLowToEditQuestions($content_id)) {
            if (auth()->user()->is_permission == \App\Http\OwnClasses\TYPE_OF_USERS_ENUMS::STUDENT) {
                return redirect('notAllowed');
            }
            $questions = Question::where('content_id', $content_id)->orderBy('type')->get();
            return view('admin.questions.index', compact('questions', 'content_id'));
        }
        Session::flash('message', 'لا يمكنك الدخول الى صفحه تعديل الاسئلة ');
        return \redirect('QuestionsReviewer/MyLessonsView');
    }

    public function createAddation($content_id)
    {

        return view('admin.questions.addationQuestion')->with('content_id', $content_id);
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

        $rowCheck = Answer_Questions::where('question_id', $id)->first();
        $row = Question::find($id);
        if (!$row) {
            return \redirect()->back()->withErrors('لا يوجد سؤال بهذا الرقم ');
        }
        $content = Content::find($row->content_id);
//        if ($content->flowStatus == CONTENT_FOLLOW_STATUS_ENUMS::PUBLISH) {
//            return \redirect()->back()->withErrors('لا يمكنك تعديل السؤال المحتوى تم نشره');
//        }
//        if ($rowCheck) {
//            return \redirect()->back()->withErrors('لا يمكنك تعديل السؤال السؤال تمت الاجابة عليه');
//        }
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

//            if ($request->questions[$arrIndex]["ans3"]) {
//                $rules_array ["questions.$arrIndex.ans3"] = ["required", Rule::notIn([$request->questions[$arrIndex]["ans1"], $request->questions[$arrIndex]["ans2"], $request->questions[$arrIndex]["ans4"]]), "max:191"];
//
//            }
//            if ($request->questions[$arrIndex]["ans4"]) {
//                $rules_array ["questions.$arrIndex.ans4"] = ["required", Rule::notIn([$request->questions[$arrIndex]["ans3"], $request->questions[$arrIndex]["ans1"], $request->questions[$arrIndex]["ans2"]]), "max:191"];
//
//            }
        }


        //  foreach ($request->all->questions)


        request()->validate($rules_array,
            $messages_array);

        $data = [];
        //return $request;
        $questions = $request->input('questions');

        if (is_array($questions) || is_object($questions)) {
            foreach ($questions as $question) {


                $row->question = $question['question'];
                $row->ans1 = $question['ans1'];
                $row->ans2 = $question['ans2'];
                $row->ans3 = $question['ans3'];
                $row->ans4 = $question['ans4'];

                $row->true_answer = $question['true_answer'];

                $row->save();
            }
            Session::flash('message', 'تم تعديل السؤال بنجاح ');
            return \redirect()->back();
            //   print_r($data);
            // die();
        }


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $question = Question::find($id);
        if ($question && auth()->user()->is_permission != TYPE_OF_USERS_ENUMS::SUPER_ADMIN) {
            $content = Content::find($question->content_id);
            if ($content->flowStatus == CONTENT_FOLLOW_STATUS_ENUMS::PUBLISH) {
                Session::flash('alert', 'لا يمكنك مسح  السؤال ');
                return \redirect()->back();
            }
        }
        $question->delete();
        Session::flash('message', 'تم مسح السؤال  السؤال ');
        return \redirect()->back();
    }

    static function getResultOFQuestionForSpecificContent($content_id, $lesson_plan_id)
    {
        $degree = 0;
        $maxDegree = 0;
        $maxBouns = 0;
        $bonus = 0;
        $all_user_answers = Answer_Questions::where(['content_id' => $content_id, 'lesson_plan_id' => $lesson_plan_id, 'user_id' => auth()->id()])->get();
        $typeofQuestion = Question::where('content_id', $content_id)->first()->type;
        foreach ($all_user_answers as $user_answer) {
            $typeofQuestion = Question::where(['content_id' => $content_id, 'id' => $user_answer->question_id])->first()->type;
            //$result=$user_answer->degree;

            if ($typeofQuestion == "activityquest") {
                $degree += $user_answer->degree;
                $maxDegree += 3;
            }
            if ($typeofQuestion == "addationquest") {
                $bonus += $user_answer->degree;
                $maxBouns += 3;
            }


        }


        $arr = array('degree' => $degree, 'maxDegree' => $maxDegree, 'maxBouns' => $maxBouns, 'bonus' => $bonus);
        $content_row = StudentLessonPlanProgress::where(['content_id' => $content_id, 'lesson_plan_id' => $lesson_plan_id, 'user_id' => auth()->id()])->first();
        if ($content_row->degree < $degree || $content_row->bonus < $bonus) {
            static::updateDegreeInStudentLessonPlanProgresses($content_id, $lesson_plan_id, $degree, $bonus);
        }


        return $arr;
    }

    static function updateDegreeInStudentLessonPlanProgresses($content_id, $lesson_plan_id, $degree, $bonus)
    {
        $content_row = StudentLessonPlanProgress::where(['content_id' => $content_id, 'lesson_plan_id' => $lesson_plan_id, 'user_id' => auth()->id()])->first();
        if ($content_row->degree < $degree) {
            $content_row->degree = $degree;
        }
        if ($content_row->bonus < $bonus) {
            $content_row->bonus = $bonus;
        }

        $content_row->save();

    }

    public function reattemptQuestionForUserInSpecificContent($content_id, $type)
    {

        $lesson_plan_id = StudentAssignedLessonPlan::where('user_id', auth()->id())->first()->lesson_plan_id;
        $question_ids = Question::where(['content_id' => $content_id, 'type' => $type])->get()->pluck('id')->toArray();
        $all_user_answers = Answer_Questions::where(['content_id' => $content_id, 'lesson_plan_id' => $lesson_plan_id, 'user_id' => auth()->id()])->whereIn('question_id', $question_ids)->get();
        foreach ($all_user_answers as $user_answer) {


            if ($type == "activityquest") {
                $user_answer->delete();
            }
            if ($type == "addationquest") {
                $user_answer->delete();
            }


        }
        return \redirect()->back();
    }

    static function getAllDegreesForStudent()
    {
        $result = 0;
        $lesson_plan = StudentAssignedLessonPlan::where('user_id', auth()->id())->first();

        if ($lesson_plan) {

            $content_rows = StudentLessonPlanProgress::where(['lesson_plan_id' => $lesson_plan->lesson_plan_id, 'user_id' => auth()->id()])->get();

            foreach ($content_rows as $content_row) {
                //$result=$user_answer->degree;
                $result += $content_row->degree + $content_row->bonus;

            }
        }


        return $result;
    }

    static function checkIfUserALLowToEditQuestions($content_id)
    {
        $row = AssignLessonsToReviewers::where(['content_id' => $content_id, 'user_id' => auth()->id()])->first();

        $content = Content::find($content_id);

        if (auth()->user()->is_permission == TYPE_OF_USERS_ENUMS::SUPER_ADMIN || auth()->user()->is_permission == TYPE_OF_USERS_ENUMS::LEADER) {
            return true;
        }
        if (auth()->user()->is_permission != TYPE_OF_USERS_ENUMS::QUESTIONEDITOR && auth()->user()->is_permission != TYPE_OF_USERS_ENUMS::QUESTIONREVIEWER && auth()->user()->is_permission != TYPE_OF_USERS_ENUMS::LEADER && auth()->user()->is_permission != TYPE_OF_USERS_ENUMS::SUPER_ADMIN) {
            return false;
        }

        if (auth()->user()->is_permission == TYPE_OF_USERS_ENUMS::QUESTIONREVIEWER && $content->flowStatus != CONTENT_FOLLOW_STATUS_ENUMS::RESEND_QUESTIONS && $content->flowStatus != CONTENT_FOLLOW_STATUS_ENUMS::REVIEW_QUESTIONS) {
            return false;
        }
        if (auth()->user()->is_permission == TYPE_OF_USERS_ENUMS::QUESTIONEDITOR && $content->flowStatus != CONTENT_FOLLOW_STATUS_ENUMS::CREATE_QUESTIONS && $content->flowStatus != CONTENT_FOLLOW_STATUS_ENUMS::REFUSE_QUESTIONS) {
            return false;
        }
        if (!$content) {

            Session::flash('message', 'لا يوجد محتوى بهذا الرقم ');
            return false;


        }

        return true;
    }

}

