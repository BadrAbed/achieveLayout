<?php

namespace App\Http\Controllers;

use App\ContentLearningGoal;
use App\LearingGoal;
use Session;
use Illuminate\Http\Request;
use App\Content;
use App\LogTime;

class LearingGoalController extends Controller
{
//    public function __construct()
//    {
//        $this->middleware("Permissions:learning_goals");//permissions middleware
//    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $learinggoal = LearingGoal::all();


        return view('admin.learing_goal.show')->with(compact('learinggoal'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.learing_goal.create');
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


        ],
            [
                'name.required' => 'من فضلك ادخل   اسم ناتج التعلم  ',
                'name.max' => 'من فضلك  اسم ناتج التعلم يجب الا يزيد عن 191',
            ]);


            $newgoal = new LearingGoal;
            $newgoal->learing_goals_name =$request->name;
            $newgoal->save();
//            $newlog = array(
//                'name' => $newgoal->learing_goals_name,
//                'type' => 'add',
//                'user_id' => auth()->user()->id,
//                'table_name' => 'learing_goal',
//                'created_at' => date("Y-m-d H:i:s"),
//
//            );
//            LogTime::insert($newlog);


        $learinggoal = LearingGoal::all();

        Session::flash('message', 'لقد تم ادخال نواتج التعلم  بنجاح');
        return view('admin.learing_goal.show')->with(compact('learinggoal'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\LearingGoal $learingGoal
     * @return \Illuminate\Http\Response
     */
    public function show(LearingGoal $learingGoal)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\LearingGoal $learingGoal
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $editGoal = LearingGoal::find($id);
        return view('admin.learing_goal.edit')->with(compact('editGoal'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\LearingGoal $learingGoal
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        request()->validate([
            'name' => 'required|max:191',


        ],
            [
                'name.required' => 'من فضلك ادخل   اسم ناتج التعلم  ',
                'name.max' => 'من فضلك  اسم ناتج التعلم يجب الا يزيد عن 191',
            ]);
        $id = $request->id;
        $updategoal = LearingGoal::find($id);
        $updategoal->learing_goals_name = $request->name;
        $updategoal->save();
        $learinggoal = LearingGoal::all();
//        $newlog = array(
//            'name' => $updategoal->learing_goals_name,
//            'type' => 'edit',
//            'user_id' => auth()->user()->id,
//            'table_name' => 'learing_goal',
//            'created_at' => date("Y-m-d H:i:s"),
//
//        );
//        LogTime::insert($newlog);
        Session::flash('message', 'لقد تم التعديل   بنجاح');

        return redirect('/showgoal');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\LearingGoal $learingGoal
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $deletegoal = LearingGoal::find($id);
        $contents = ContentLearningGoal::where('goal_id', $id)->first();
        $learinggoal = LearingGoal::all();
        if ($contents == null) {
            $newlog = array(
                'name' => $deletegoal->learing_goals_name,
                'type' => 'delete',
                'user_id' => auth()->user()->id,
                'table_name' => 'learing_goal',
                'created_at' => date("Y-m-d H:i:s"),

            );

            $deletegoal->delete();
//            LogTime::insert($newlog);
            Session::flash('message', 'لقد تم حذف الناتج بنجاح');
            return redirect('/showgoal');
        } else {
            Session::flash('alert', 'لايمكنك المسح ');


            return redirect('/showgoal');
        }
    }
}