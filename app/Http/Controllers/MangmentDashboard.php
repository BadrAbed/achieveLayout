<?php

namespace App\Http\Controllers;

use App\Categories;
use App\Country;
use App\EducationLevel;
use App\LearingGoal;
use App\LogTime;
use App\User;
use Illuminate\Http\Request;
use App\Content;
use DateTime;
class MangmentDashboard extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $timecontenthours=0;
        $timecontentmint=0;
        $timeuserhours=0;
        $timeusermint=0;
        $timelogmint=0;
        $timeloghours=0;
        $grade=EducationLevel::all();
        $catgerory=Categories::all();
        $goal=LearingGoal::all();
        $contents=Content::all();
        $publishcontents=Content::where('flowStatus',1)->get();
        $reviewcontents=Content::where('flowStatus',0)->where('complete',1)->get();
        $users=User::all();
        $countries=Country::all();
        $newcontents=Content::where('created_at','like',date("Y-m-d").'%')->orderBY('created_at','asc')->get();
        $newusers=User::where('created_at','like',date("Y-m-d").'%')->orderBY('created_at','asc')->get();
        $logtimes=LogTime::where('created_at','like','%'.date("Y-m-d").'%')->orderBY('created_at','asc')->get();

        if(count($newcontents)>0){
            foreach ($newcontents as $newcontent){}
            $datetime1 = new DateTime($newcontent->created_at);
            $datetime2 = new DateTime(date("Y-m-d h:i:sa"));
            $interval = $datetime1->diff($datetime2);
            if($interval->format('%H')>0) {
                $timecontenthours = $interval->format('%H');
            }
            else{
                $timecontentmint = $interval->format('%I');
            }
        }

        if(count($newusers)>0) {
            foreach ($newusers as $newuser) {
            }


            $datetime1 = new DateTime($newuser->created_at);
            $datetime2 = new DateTime(date("Y-m-d h:i:sa"));
            $interval = $datetime1->diff($datetime2);
            $timeuser = $interval->format('%I');
            if($interval->format('%H')>0) {
                $timeuserhours = $interval->format('%H');
            }
            else{
                $timeusermint = $interval->format('%I');
            }
        }
        if(count($logtimes)>0) {
            foreach ($logtimes as $logtime) {
            }


            $datetime1 = new DateTime($logtime->created_at);
            $datetime2 = new DateTime(date("Y-m-d h:i:sa"));
            $interval = $datetime1->diff($datetime2);
            $timelog = $interval->format('%I');
            if($interval->format('%H')>0) {
                $timeloghours  = $interval->format('%H');
            }
            else{
                $timelogmint   = $interval->format('%I');
            }
        }
 return view('admin.dashboards.admin')
     ->with(compact('newcontents'))
     ->with(compact('timecontenthours'))
     ->with(compact('timecontentmint'))
     ->with(compact('timeuserhours'))
     ->with(compact('timeusermint'))
     ->with(compact('newusers'))
     ->with(compact('timeuser'))
     ->with(compact('grade'))
     ->with(compact('catgerory'))
     ->with(compact('goal'))
     ->with(compact('contents'))
     ->with(compact('users'))
     ->with(compact('publishcontents'))
     ->with(compact('reviewcontents'))
     ->with(compact('timelogmint'))
     ->with(compact('timeloghours'))
     ->with(compact('logtimes'))
     ->with(compact('countries'));

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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
