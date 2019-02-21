<?php

namespace App\Http\Controllers;

use App\Http\OwnClasses\PLACEMENT_TEST_QUESTION_ANSWERS_ENUMS;
use App\Http\Controllers\PlacementTestQuestionAnswer;

use App\PlacementTestQuestionAnswers;
use App\StudentPlacementTest;

use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\EducationLevel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;
use Validator;


class PlacementTestQuestions extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {

        $eduction_level_id = \App\PlacementTest::find($id)->parent_education_level;
        $eduction_level = EducationLevel::find($eduction_level_id);
        $exam_id = $id;
        // $placement_test_details = StudentPlacementTest::with("placmentTest")->find($placement_test_id);
        // $children_education_of_parent_level = EducationLevel::where("parent_id", $placement_test_details->parent_education_level)->get();
        return view("admin.placement_test.questions.create", compact("placement_test_details", "eduction_level", "exam_id"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $placement_test_id)

    {
        //dd($request);
        $rulesArr = [
            // 'name' => 'required',
            'ans1' => ["required", Rule::notIn([$request->ans3, $request->ans2, $request->ans4]), "max:191"],
            'ans2' => ["required", Rule::notIn([$request->ans1, $request->ans3, $request->ans4]), "max:191"],
            'ans3' => ["required", Rule::notIn([$request->ans1, $request->ans2, $request->ans4]), "max:191"],
            'ans4' => ["required", Rule::notIn([$request->ans1, $request->ans2, $request->ans3]), "max:191"],
            "true_answer" => "required|in:ans1,ans2,ans3,ans4",
            "desc" => "required"
        ];


        $validator = Validator::make(\request()->all(), $rulesArr,
            [
                'name.required' => 'من فضلك ادخل اسم الامتحان',
                'desc.required' => 'من فضلك ادخل وصف السؤال',
                'name.max' => 'اسم الامتحان لا يجيب ان يزيد ان عن 191',
                'child_education_level.required' => 'من فضلك ادخل المرحله الدارسيه',
                'child_education_level.in' => 'المرحله الدراسيه غير صالحه',
                'ans1.required' => 'من فضلك ادخل اسم الاجابه الاولى ',

                'ans1.max' => 'الاجابه الاولي لا يجيب ان تزيد عن 191 حرف ',
                'ans2.max' => 'الاجابه الثانيه لا يجيب ان تزيد عن 191 حرف ',
                'ans3.max' => 'الاجابه الثالثه لا يجيب ان تزيد عن 191 حرف ',
                'ans4.max' => 'الاجابه الرابعه لا يجيب ان تزيد عن 191 حرف ',

                'ans2.required' => 'من فضلك ادخل اسم الاجابه الثانيه',
                "ans1.not_in" => "الاجابه الاول لابد ان تكون مختلفه",
                "ans2.not_in" => "الاجابه الثانيه لابد ان تكون مختلفه",
                'ans3.required' => 'من فضلك ادخل اسم الاجابه الثالثه',
                'ans4.required' => 'من فضلك ادخل اسم الاجابه الرابعه',
                "ans3.not_in" => "الاجابه الثالثه لابد ان تكون مختلفه",
                "ans4.not_in" => "الاجابه الرابعه لابد ان تكون مختلفه",
                "true_answer.in" => "خانة الاجابه الصحيحه غير صالحه",
                "true_answer.required" => "خانة الاجابه الصحيحه مطلوبه",

            ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }


        DB::transaction(function () use ($request, $placement_test_id) { //insert questions and answers within a transaction


            $new_question_row = new \App\PlacementTestQuestions();

            //insert  question
            $new_question_row->exam_id = $placement_test_id;

            $new_question_row->question = $request->name;
            $new_question_row->desc = $request->desc;
            $new_question_row->user_id = auth()->id();
            $new_question_row->save();
            $placement_test = \App\PlacementTest::find($placement_test_id);
            $placement_test->updated_at = $new_question_row->updated_at;
            $placement_test->save();

            //insert first question
            $placement_answers_row_1 = new PlacementTestQuestionAnswers();
            $placement_answers_row_1->question_id = $new_question_row->id;
            $placement_answers_row_1->answer = $request->ans1;
            if ($request->true_answer == "ans1") {//if the marked as true , then record it as true
                $placement_answers_row_1->is_true = PLACEMENT_TEST_QUESTION_ANSWERS_ENUMS::GET_IS_TRUE;
            }
            $placement_answers_row_1->save();

            //insert second answer
            $placement_answers_row_2 = new PlacementTestQuestionAnswers();
            $placement_answers_row_2->question_id = $new_question_row->id;
            $placement_answers_row_2->answer = $request->ans2;
            if ($request->true_answer == "ans2") {//if the marked as true , then record it as true
                $placement_answers_row_2->is_true = PLACEMENT_TEST_QUESTION_ANSWERS_ENUMS::GET_IS_TRUE;
            }
            $placement_answers_row_2->save();

            //insert third question if entered by the user
            if ($request->ans3) {
                $placement_answers_row_3 = new PlacementTestQuestionAnswers();
                $placement_answers_row_3->question_id = $new_question_row->id;
                $placement_answers_row_3->answer = $request->ans3;
                if ($request->true_answer == "ans3") {//if the marked as true , then record it as true
                    $placement_answers_row_3->is_true = PLACEMENT_TEST_QUESTION_ANSWERS_ENUMS::GET_IS_TRUE;
                }
                $placement_answers_row_3->save();
            }
            //insert fourth question if entered by the user
            if ($request->ans4) {
                $placement_answers_row_4 = new PlacementTestQuestionAnswers();
                $placement_answers_row_4->question_id = $new_question_row->id;
                $placement_answers_row_4->answer = $request->ans4;
                if ($request->true_answer == "ans4") { //if the marked as true , then record it as true
                    $placement_answers_row_4->is_true = PLACEMENT_TEST_QUESTION_ANSWERS_ENUMS::GET_IS_TRUE;
                }
                $placement_answers_row_4->save();
            }


        });

        return redirect("admin/placement_test/" . $placement_test_id);


    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $placement_test_question = \App\PlacementTestQuestions::with(["placementQuestionAnswers" => function ($q) {
            $q->orderBy('id', 'asc');
        }])->find($id);
        $placement_test = \App\PlacementTest::find($placement_test_question->exam_id);

        //$parent_id = EducationLevel::find($placement_test_question->child_education_level)->parent_id;

        // $children_education_of_parent_level = EducationLevel::where("parent_id", $parent_id)->get();

        $eduction_level = EducationLevel::find($placement_test->parent_education_level);

        return view("admin.placement_test.questions.show", compact("placement_test_question", "eduction_level"));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $placement_test_question = \App\PlacementTestQuestions::with("placementQuestionAnswers")->find($id);
        $placement_test = \App\PlacementTest::find($placement_test_question->exam_id);


        $eduction_level = EducationLevel::find($placement_test->parent_education_level);

        return view("admin.placement_test.questions.edit", compact("placement_test_question", "eduction_level", "placement_test_details"));
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

        $question_row = \App\PlacementTestQuestions::find($id);

        //  $placement_test_details = StudentPlacementTest::with("placmentTest")->find($question_row->exam_id);
        //  $children_education_of_parent_levels = EducationLevel::where("parent_id", $placement_test_details->parent_education_level)->get()->pluck("id")->toArray();


        $rulesArr = [
            'name' => 'required',
            'ans1' => ["required", Rule::notIn([$request->ans3, $request->ans2, $request->ans4]), "max:191"],
            'ans2' => ["required", Rule::notIn([$request->ans1, $request->ans3, $request->ans4]), "max:191"],
            'ans3' => ["required", Rule::notIn([$request->ans1, $request->ans2, $request->ans4]), "max:191"],
            'ans4' => ["required", Rule::notIn([$request->ans1, $request->ans2, $request->ans3]), "max:191"],
            "true_answer" => "required|in:ans1,ans2,ans3,ans4",
            "desc" => "required",
        ];


        $validator = Validator::make(\request()->all(), $rulesArr,
            [
                'name.required' => 'من فضلك ادخل اسم الامتحان',
                'desc.required' => 'من فضلك ادخل وصف السؤال',
                'name.max' => 'اسم الامتحان لا يجيب ان يزيد ان عن 191',
                'ans1.required' => 'من فضلك ادخل اسم الاجابه الاولى ',

                'ans1.max' => 'الاجابه الاولي لا يجيب ان تزيد عن 191 حرف ',
                'ans2.max' => 'الاجابه الثانيه لا يجيب ان تزيد عن 191 حرف ',
                'ans3.max' => 'الاجابه الثالثه لا يجيب ان تزيد عن 191 حرف ',
                'ans4.max' => 'الاجابه الرابعه لا يجيب ان تزيد عن 191 حرف ',
                'ans3.required' => 'من فضلك ادخل اسم الاجابه الثالثه',
                'ans4.required' => 'من فضلك ادخل اسم الاجابه الرابعه',
                'ans2.required' => 'من فضلك ادخل اسم الاجابه الثانيه',
                "ans1.not_in" => "الاجابه الاول لابد ان تكون مختلفه",
                "ans2.not_in" => "الاجابه الثانيه لابد ان تكون مختلفه",
                "ans3.not_in" => "الاجابه الثالثه لابد ان تكون مختلفه",
                "ans4.not_in" => "الاجابه الرابعه لابد ان تكون مختلفه",
                "true_answer.in" => "خانة الاجابه الصحيحه غير صالحه",
                "true_answer.required" => "خانة الاجابه الصحيحه مطلوبه",

            ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }


        $placement_test_id = $question_row->exam_id;


        if ($this->checkIfQuestionOrItsAnsweresCanBeDeletedOrUpdatedOrNot($id) == true) {//check if question or its anwsers could be updated or not
            return \redirect()->back()->withErrors(["هذا السؤال تمت الاجابه عليه . لذا لايمكنك تعديله"]);
        }


        DB::transaction(function () use ($request, $placement_test_id, $question_row) { //insert questions and answers within a transaction


            //insert  question
            $question_row->question = $request->name;
            $question_row->desc = $request->desc;
            $question_row->user_id = auth()->id();
            $question_row->save();
            $placement_test = \App\PlacementTest::find($placement_test_id);
            $placement_test->updated_at = $question_row->updated_at;
            $placement_test->save();

            PlacementTestQuestionAnswers::where("question_id", $question_row->id)->delete();//delete all question answers


            //insert first question
            $placement_answers_row_1 = new PlacementTestQuestionAnswers();
            $placement_answers_row_1->question_id = $question_row->id;
            $placement_answers_row_1->answer = $request->ans1;
            if ($request->true_answer == "ans1") {//if the marked as true , then record it as true
                $placement_answers_row_1->is_true = PLACEMENT_TEST_QUESTION_ANSWERS_ENUMS::GET_IS_TRUE;
            }
            $placement_answers_row_1->save();

            //insert second answer
            $placement_answers_row_2 = new PlacementTestQuestionAnswers();
            $placement_answers_row_2->question_id = $question_row->id;
            $placement_answers_row_2->answer = $request->ans2;
            if ($request->true_answer == "ans2") {//if the marked as true , then record it as true
                $placement_answers_row_2->is_true = PLACEMENT_TEST_QUESTION_ANSWERS_ENUMS::GET_IS_TRUE;
            }
            $placement_answers_row_2->save();

            //insert third question if entered by the user
            if ($request->ans3) {
                $placement_answers_row_3 = new PlacementTestQuestionAnswers();
                $placement_answers_row_3->question_id = $question_row->id;
                $placement_answers_row_3->answer = $request->ans3;
                if ($request->true_answer == "ans3") {//if the marked as true , then record it as true
                    $placement_answers_row_3->is_true = PLACEMENT_TEST_QUESTION_ANSWERS_ENUMS::GET_IS_TRUE;
                }
                $placement_answers_row_3->save();
            }
            //insert fourth question if entered by the user
            if ($request->ans4) {
                $placement_answers_row_4 = new PlacementTestQuestionAnswers();
                $placement_answers_row_4->question_id = $question_row->id;
                $placement_answers_row_4->answer = $request->ans4;
                if ($request->true_answer == "ans4") { //if the marked as true , then record it as true
                    $placement_answers_row_4->is_true = PLACEMENT_TEST_QUESTION_ANSWERS_ENUMS::GET_IS_TRUE;
                }
                $placement_answers_row_4->save();
            }


        });

        return redirect("admin/placement_test/" . $placement_test_id);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        if ($this->checkIfQuestionOrItsAnsweresCanBeDeletedOrUpdatedOrNot($id) == true) {
            return \redirect()->back()->withErrors(["هذا السؤال تمت الاجابه عليه . لذا لايمكنك مسحه"]);
        }

        DB::transaction(function () use ($id) {
            $question_row = \App\PlacementTestQuestions::find($id);

            PlacementTestQuestionAnswers::where("question_id", $id)->delete();//delete all question answers

            $question_row->delete(); //delete quewstion

            \session()->flash('تم المسح بنجاح');

        });

        return Redirect::back();


    }


    private function checkIfQuestionOrItsAnsweresCanBeDeletedOrUpdatedOrNot($question_id)
    {
        $canBeDeleted = StudentPlacementTestAnswer::checkIfQuestionHasBeenAnsweredOrNotByStudent($question_id);//check if question can be deleted or not

        return $canBeDeleted;

    }


}
