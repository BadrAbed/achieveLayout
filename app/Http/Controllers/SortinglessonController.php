<?php

namespace App\Http\Controllers;

use App\Content;
use App\Country;
use App\EducationLevel;
use App\Http\OwnClasses\CONTENT_FOLLOW_STATUS_ENUMS;
use App\LessonPlan;
use App\Sortinglesson;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;
use Illuminate\Support\Facades\Redirect;

class SortinglessonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $plan_id = Session::get('plan_id');
        $plan = LessonPlan::where('id', $plan_id)->first();



        $content_of_paln = Content::where('education_level_id', $plan->grade_id)->where('complete', 1)->where('flowStatus', CONTENT_FOLLOW_STATUS_ENUMS::PUBLISH)
            ->where(function ($query) use ($plan) {

                $query->where('countries', $plan->country_id)
                    ->orWhereNull('countries');
            })->get();


        return view('admin.sortingplan.index')->with('planContent', $content_of_paln);
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $planID = $request->planID;

        $arr = $request->ordering;
        $arr2 = explode(',', $arr);
        $lenth = $request->length;
        $sorting = 1;
        for ($i = 0; $i < count($arr2); $i++) {
            $newplan = new Sortinglesson;
            $newplan->content_id = $arr2[$i];
            $newplan->lesson_id = $planID;
            $newplan->sorting = $sorting;
            $newplan->save();
            $sorting++;
        }
        // return Redirect::to('viewplan');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Sortinglesson $sortinglesson
     * @return \Illuminate\Http\Response
     */
    public function show(Sortinglesson $sortinglesson)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Sortinglesson $sortinglesson
     * @return \Illuminate\Http\Response
     */
    public function edit(Sortinglesson $sortinglesson)
    {
        $plan_id = request('plan_id');
        $plan = LessonPlan::where('id', $plan_id)->first();
        // $country=Country::where('id',$plan->country_id)->first();
        $content_of_paln = Sortinglesson::where('lesson_id', $plan_id)->get();
        $arr = [];
        $data = [];
        $id = [];
        foreach ($content_of_paln as $content_of_paln) {
            $arr[] = Content::where('id', $content_of_paln->content_id)->get();


        }
        for ($i = 0; $i < count($arr); $i++) {
            foreach ($arr[$i] as $alldata) {
                $id[] = $alldata->id;
            }


        }



        $data[] = Content::where('education_level_id',$plan->grade_id)->where('complete', 1)->where('flowStatus', CONTENT_FOLLOW_STATUS_ENUMS::PUBLISH)->where(function ($query) use ($plan) {

            $query->where('countries', $plan->country_id)
                ->orWhereNull('countries');
        })->whereNotIn('id', $id)->get();      //$content_of_paln=Content::where('education_level_id',$plan->grade_id)->where('countries',$country->value)->get();


        return view('admin.sortingplan.edit')->with('AllContent', $data)->with('planID', $plan_id)->with('planContent', $arr);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Sortinglesson $sortinglesson
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sortinglesson $sortinglesson)
    {


        $planID = $request->planID;

        $arr = $request->ordering;
        $arr2 = explode(',', $arr);
        $lenth = $request->length;
        $sorting = 1;
        $oldPlan = Sortinglesson::where('lesson_id', $planID)->get();

        foreach ($oldPlan as $oldPlan) {
            $oldPlan->delete();
        }

        for ($i = 0; $i < count($arr2); $i++) {
            $newplan = new Sortinglesson;
            $newplan->content_id = $arr2[$i];
            $newplan->lesson_id = $planID;
            $newplan->sorting = $sorting;
            $newplan->save();
            $sorting++;
        }
        // return Redirect::to('viewplans');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Sortinglesson $sortinglesson
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sortinglesson $sortinglesson)
    {
        $content = Sortinglesson::where('content_id', request('content_id'))->where('lesson_id', request('plan_id'))->first();

        $content->delete();

        // redirect
        Session::flash('message', 'لقد تم حذف المحتوى  بنجاح');
        return redirect()->back();
    }
}
