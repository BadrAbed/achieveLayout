<?php

namespace App\Http\Controllers;

use App\Country;
use App\EducationLevel;
use App\StudentPlacementTest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\OwnClasses\PLACMENT_TEST_QUESTIONS_ENUMS;
use Illuminate\Support\Facades\App;
use Illuminate\Validation\Rule;

class PlacementTest extends Controller
{

//    public function __construct()
//    {
//        $this->middleware("Permissions:lesson_plans");//permissions middleware
//    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {


//        $eduction_levels = EducationLevel::where('parent_id',null)->get();
//        $placement_test_details = \App\PlacementTest::all();
        return view("admin.placement_test.index");

    }

    public function ajaxAllPlacementTests()
    {


        $data = \App\PlacementTest::with('Country', 'grade', 'user')->orderBy("id", "desc")->get();


        $arr = [];
        foreach ($data as $row) {
            $placement_test_questions = \App\PlacementTestQuestions::where('exam_id', $row->id)->get()->count();

            if (@$_GET["exam_name"]) {
                if (strstr($row->exam_name, $_GET["exam_name"]) == false) {
                    continue;
                }
            }
            if (@$_GET["grade"]) {

                if (strstr($row->grade->name, $_GET["grade"]) == false) {

                    continue;
                }
            }
            if (@$_GET["country"]) {

                if (strstr((string)$row->Country->name, $_GET["country"]) == false) {
                    continue;
                }
            }

            $status = 'مفعل';
            if ($row->status == 0) {
                $status = "غير مفعل";
            }


            $arr[] = array("ID" => htmlspecialchars($row->id, ENT_QUOTES), "status" => htmlspecialchars($status, ENT_QUOTES), "Created_at" => htmlspecialchars($row->created_at, ENT_QUOTES), "Updated_at" => htmlspecialchars($row->updated_at, ENT_QUOTES), "NumberOfQuestions" => htmlspecialchars($placement_test_questions, ENT_QUOTES), "exam_name" => htmlspecialchars($row->exam_name, ENT_QUOTES), "grade" => htmlspecialchars($row->grade->name, ENT_QUOTES), "country" => htmlspecialchars(($row->Country) ? $row->Country->name : "عام", ENT_QUOTES), "user" => htmlspecialchars($row->user->name, ENT_QUOTES));

          // $arr[] = array("ID" => htmlspecialchars($row->id, ENT_QUOTES), "Created_at" => htmlspecialchars($row->created_at, ENT_QUOTES), "Updated_at" => htmlspecialchars($row->updated_at, ENT_QUOTES), "NumberOfQuestions" => htmlspecialchars($placement_test_questions, ENT_QUOTES), "exam_name" => htmlspecialchars($row->exam_name, ENT_QUOTES), "grade" => htmlspecialchars($row->grade->name, ENT_QUOTES), "country" => htmlspecialchars(($row->Country) ? $row->Country->name : "عام", ENT_QUOTES), "user" => htmlspecialchars($row->user->name, ENT_QUOTES));
            unset($row);
        }

        // $arr["arrCount"]=htmlspecialchars(count($arr),ENT_QUOTES);
        return response()->json($arr);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $education_levels = EducationLevel::where('parent_id', null)->get();
        $countries = Country::all();
        return view("admin.placement_test.create")->with(compact('education_levels'))->with(compact('countries'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $education_levels = EducationLevel::where('parent_id', null)->get()->pluck("id")->toArray();


        request()->validate([
            'name' => 'required|unique:placement_tests,exam_name|max:191',
            'country' => 'required',
            'parent_education_level' => 'required|in:' . implode(",", $education_levels),//validate that the choice has been selected within the allowed values

        ],
            [
                'name.required' => 'من فضلك ادخل اسم الامتحان',
                'name.unique' => 'اسم الامتحان مكرر',
                'country.required' => 'من فضلك اخنر دلوله ',
                'name.max' => 'اسم الامتحان يجب الا يزيد عن 191',

                'parent_education_level.required' => 'من فضلك ادخل المرحله الدارسيه',
                'parent_education_level.in' => 'المرحله الدراسيه غير صالحه',
            ]);

        $newPlacementTest = new \App\PlacementTest;
        $newPlacementTest->exam_name = $request->name;
        $newPlacementTest->country = $request->country;
        $newPlacementTest->instructions = $request->instructions;
        $newPlacementTest->parent_education_level = $request->parent_education_level;
        $newPlacementTest->status = $request->active_status;
        $newPlacementTest->user_id = auth()->id();
        $newPlacementTest->save();

        return redirect()->to('admin/placement_test');//redirect admin to the first education level tab of adding questions

    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $placement_test = \App\PlacementTest::find($id);

        $placement_test_questions = \App\PlacementTestQuestions::where('exam_id', $id)->get();


        // $children_education_of_parent_level = EducationLevel::where("parent_id", $placement_test->parent_education_level)->get();
        return view("admin.placement_test.show", compact("placement_test", "children_education_of_parent_level", "placement_test_questions"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $education_levels = EducationLevel::where('parent_id', null)->get();
        $exam = \App\PlacementTest::find($id);
        $countries = Country::all();
        return view("admin.placement_test.edit")->with(compact('education_levels', "exam", "countries"));
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

        $education_levels = EducationLevel::where('parent_id', null)->get()->pluck("id")->toArray();
        $row = \App\PlacementTest::find($id);


        request()->validate([
            'name' => 'required|unique:placement_tests,exam_name,' . $id . '|max:191',
            'parent_education_level' => 'required|in:' . implode(",", $education_levels),//validate that the choice has been selected within the allowed values

        ],
            [
                'name.required' => 'من فضلك ادخل اسم الامتحان',
                'name.unique' => 'اسم الامتحان مكرر',
                'name.max' => 'اسم الامتحان يجب الا يزيد عن 191',
                'parent_education_level.required' => 'من فضلك ادخل المرحله الدارسيه',
                'parent_education_level.in' => 'المرحله الدراسيه غير صالحه',
            ]);


        $newPlacementTest = \App\PlacementTest::find($id);
        $newPlacementTest->exam_name = $request->name;
        $newPlacementTest->instructions = $request->instructions;
        $newPlacementTest->country = $request->country;
        $newPlacementTest->parent_education_level = $request->parent_education_level;
        $newPlacementTest->status = $request->active_status;
        $newPlacementTest->user_id = auth()->id();
        $newPlacementTest->save();

        return redirect("admin/placement_test");//redirect admin to the first education level tab of adding questions

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $exam_question = \App\PlacementTestQuestions::where("exam_id", $id)->get();//get exam questions

        if ($exam_question->count() > 0) { //if exam has questions , then you can not delete it
            return redirect()->back()->withErrors("الامتحان له اسئله . لذلك لا يمكن مسحه");
        }

        \App\PlacementTest::find($id)->delete();

        return redirect()->back()->withErrors(["تم مسح الامتحان بنجاح"]);
    }


}
