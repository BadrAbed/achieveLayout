<?php

namespace App\Http\Controllers;

use App\Country;
use App\LogTime;
use App\EducationLevel;
use App\LessonPlan;
use App\Content;
use App\Sortinglesson;
use App\StudentAssignedLessonPlan;
use App\StudentLessonPlanProgress;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

class LessonPlanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $plans = LessonPlan::with('grade', 'country', 'user')->get();
        $country = Country::all();
        $grade = EducationLevel::with('children')->whereNull('parent_id')->get();

        return view('admin.lessonsPlan.index')->with(compact('plans'))->with(compact('country'))->with(compact('grade'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    public function subgrade()
    {
        request('parent_id');
        $subgrade = EducationLevel::where('parent_id', request('parent_id'))->get();
        return response($subgrade);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        request()->validate([
            'name' => 'required|max:191',
            'country' => 'required',
            'active' => 'required',
            'grade' => 'required',


        ],
            ['name.required' => 'من فضلك ادخل اسم الخطه',
                'name.max' => 'من فضلك  اسم الخطه يجب الا يزيد عن 191',
                'grade.required' => 'من فضلك ادخل المرحله الدارسيه',
                'country.required' => 'من فضلك ادخل اسم البلد',
                'active.required' => 'من فضلك ادخل حاله تفعيل الخطه ',
            ]);
        $plan = new LessonPlan;
        $checkActivation = LessonPlan::where('country_id', $request->country)->where('grade_id', $request->grade)->where('active', 1)->first();
        if ($checkActivation != null && $checkActivation->active == 1 && $request->active == 1) {


            Session::flash('message', 'توجد خطه مفعله لهذه المرحله ');
            return redirect()->back();
        } else {
            $plan->name = $request->name;
            $plan->country_id = $request->country;
            $plan->grade_id = $request->grade;
            $plan->user_id = auth()->id();
            $plan->active = $request->active;
            $plan->save();
//            $newlog = array(
//                'name' => $plan->name,
//                'type' => 'add',
//                'user_id' => auth()->user()->id,
//                'table_name' => 'lessonplan',
//                'created_at' => date("Y-m-d H:i:s"),
//
//            );
//            LogTime::insert($newlog);
            Session::flash('message', 'تم الحفظ بنجاح ');
            Session::put('plan_id', $plan->id);
            return redirect('viewPlanLessons');

        }


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\LessonPlan $lesson
     * @return \Illuminate\Http\Response
     */
    public function show(LessonPlan $lesson)
    {
        $content = [];
        $planid = request('planID');
        //dd(request('planID'));
        $plan = Sortinglesson::where('lesson_id', $planid)->orderBy('sorting', 'asc')->get();
        foreach ($plan as $planContent) {

            $content[] = Content::where('id', $planContent->content_id)->get();
        }

        return view('admin.lessonsPlan.view')->with(compact('content'))->with(compact('planid'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\LessonPlan $lesson
     * @return \Illuminate\Http\Response
     */
    public function edit(LessonPlan $lesson)
    {
        $plans = LessonPlan::with('grade', 'country', 'user')->where('id', request('planID'))->first();
        $country = Country::all();
        $grade = EducationLevel::with('children')->whereNull('parent_id')->get();
        return view('admin.lessonsPlan.edit')->with(compact('plans'))->with(compact('country'))->with(compact('grade'));

    }

    public function filtercountry()
    {
        $grade = request('grade_id');
        $country = request('countryfilter');
        $id = [];
        $arr = [];
        $garde_id = EducationLevel::where('parent_id', $grade)->get();
        foreach ($garde_id as $garde_id) {
            $arr[] = EducationLevel::where('parent_id', $grade)->get();


        }
        for ($i = 0; $i < count($arr); $i++) {
            foreach ($arr[$i] as $alldata) {
                $id[] = $alldata->id;
            }


        }

        if ($country != null && $grade == null) {
            $plans = LessonPlan::with('grade', 'country', 'user')->where('country_id', $country)->get();

        }
        if ($country != null && $grade != null) {
            $plans = LessonPlan::with('grade', 'country', 'user')->where('country_id', $country)->whereIN('grade_id', $id)->orderBy('name', 'asc')->get();

        }
        if ($country == null && $grade != null) {
            $plans = LessonPlan::with('grade', 'country', 'user')->whereIN('grade_id', $id)->orderBy('name', 'asc')->get();

        }
        if ($country == null && $grade == null) {
            $plans = LessonPlan::with('grade', 'country', 'user')->get();

        }
        return response()->json($plans);
    }

    public function filtergrade()
    {

        $grade = request('gradefilter');
        $country = request('country_id');
        $id = [];
        $arr = [];
        $garde_id = EducationLevel::where('parent_id', $grade)->get();
        foreach ($garde_id as $garde_id) {
            $arr[] = EducationLevel::where('parent_id', $grade)->get();


        }
        for ($i = 0; $i < count($arr); $i++) {
            foreach ($arr[$i] as $alldata) {
                $id[] = $alldata->id;
            }


        }
        if ($country != null && $grade == null) {
            $plans = LessonPlan::with('grade', 'country', 'user')->where('country_id', $country)->get();

        }
        if ($country != null && $grade != null) {
            $plans = LessonPlan::with('grade', 'country', 'user')->where('country_id', $country)->whereIN('grade_id', $id)->orderBy('name', 'asc')->get();

        }
        if ($country == null && $grade != null) {
            $plans = LessonPlan::with('grade', 'country', 'user')->whereIN('grade_id', $id)->orderBy('name', 'asc')->get();

        }
        if ($country == null && $grade == null) {
            $plans = LessonPlan::with('grade', 'country', 'user')->get();

        }
        $user = LessonPlan::find(3);

        return response()->json($plans);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\LessonPlan $lesson
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LessonPlan $lesson)
    {
        $checkActivation = LessonPlan::where('country_id', $request->country)->where('grade_id', $request->grade)->where('id', '!=', $request->planID)->where('active', 1)->first();
        if ($checkActivation != null && $checkActivation->active == 1 && $request->active == 1) {


            Session::flash('message', 'توجد خطه مفعله لهذه المرحله ');
            return redirect()->back();
        }
        $plan = LessonPlan::find($request->planID);

        $plan->user_id = auth()->user()->id;
        $plan->active = $request->active;
         request()->validate([
                'name' => 'required|max:191'
                ],
                ['name.required' => 'من فضلك ادخل اسم الخطه',
                    'name.max' => 'من فضلك  اسم الخطه يجب الا يزيد عن 191',
                ]);
        if ($plan->country_id != $request->country || $plan->grade_id != $request->grade) {
            request()->validate([
                'country' => 'required',
                'active' => 'required',
                'grade' => 'required',


            ],
                ['name.required' => 'من فضلك ادخل اسم الخطه',
                    'name.max' => 'من فضلك  اسم الخطه يجب الا يزيد عن 191',
                    'grade.required' => 'من فضلك ادخل المرحله الدارسيه',
                    'country.required' => 'من فضلك ادخل اسم البلد',
                    'active.required' => 'من فضلك ادخل حاله تفعيل الخطه ',
                ]);

            $deleteSorting = Sortinglesson::where('lesson_id', $plan->id)->get();
            foreach ($deleteSorting as $deleteSorting) {
                $deleteSorting->delete();
            }

           
            $plan->country_id = $request->country;
            $plan->grade_id = $request->grade;

            $plan->save();
//            $newlog = array(
//                'name' => $plan->name,
//                'type' => 'edit',
//                'user_id' => auth()->user()->id,
//                'table_name' => 'lessonplan',
//                'created_at' => date("Y-m-d H:i:s"),
//
//            );
//
//            LogTime::insert($newlog);
            Session::flash('message', 'تم الحفظ بنجاح ');
            Session::put('plan_id', $plan->id);

            return redirect('viewPlanLessons');

        }
         $plan->name = $request->name;

        $plan->save();
        Session::flash('message', 'تم الحفظ بنجاح ');
        return redirect()->back();


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\LessonPlan $lesson
     * @return \Illuminate\Http\Response
     */
    public
    function destroy(LessonPlan $lesson)
    {

        //dd( date("Y/m/d"). ' ' .date("h:i:sa"));
        $plan = LessonPlan::where('id', request('planID'))->first();
        if (StudentAssignedLessonPlan::where('lesson_plan_id', request('planID'))->first() || StudentLessonPlanProgress::where('lesson_plan_id', request('planID'))->first()) {

            Session::flash('alert', 'لا يمكنك المسح الخطه تم تفعيلها مع الطلبة بالفعل ');
            return redirect()->back();
        }
        if ($plan->active == 1) {
            Session::flash('alert', 'لا يمكنك المسح الخطه مفعله من فضلك الغ التفيل قيل المسح ');


        } else {
            $newlog = array(
                'name' => $plan->name,
                'type' => 'delete',
                'user_id' => auth()->user()->id,
                'table_name' => 'lessonplan',
                'created_at' => date("Y-m-d H:i:s"),

            );


            $plan->delete();
//            LogTime::insert($newlog);
            // redirect
            Session::flash('deletemessage', 'لقد تم حذف الخطه  بنجاح');

        }


        return redirect()->back();
    }
}
