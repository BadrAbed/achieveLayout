<?php

namespace App\Http\Controllers;

use App\Http\OwnClasses\STUDENT_ASSIGNED_LESSON_PLANS_ENUMS;
use App\PollResults;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Content;
use App\Http\OwnClasses\Permissions;


use \App\Http\Controllers\CommonStudentTabsProcesses;
use \App\Http\Controllers\CommonStudentLessonsProcesses;

use Illuminate\Support\Facades\Redirect;

class PollResultsController extends Controller
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
    public function index()
    {
        //
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
//        return redirect('student/content/poll/'.$request->content_id.'/'.'0'.'/'.'0');
$poll = \App\PollResults::where('user_id', auth()->user()->id)->where('type', $request->type)->where('content_id', $request->content_id)->first();
if($poll){
    return redirect()->back()->withErrors('تمت الاجابه من قبل على هذا الاستبيان');
}
        $newPoll = new  PollResults;
        $newPoll->content_id = $request->content_id;
        $newPoll->poll_ans = $request->poll_ans;
        $newPoll->poll_explain = $request->explain;
        $newPoll->type = $request->type;
        $newPoll->user_id = auth()->user()->id;

        $newPoll->save();
        Session::put('poll', 'true');
        $truePollAns = PollResults::where('poll_ans', 1)->get();
        $falsePollAns = PollResults::where('poll_ans', 0)->get();
        if ($request->type == "after") {
            Session::put('pollType', 'after');
        }
        if ($request->type == "before") {
            Session::put('pollType', 'before');
        }

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\PollResults $pollResults
     * @return \Illuminate\Http\Response
     */
    public function show($content_id, $type, $tab_enum)
    {


        $content = Content::with('Links', 'articalnormal', 'articalstrach', 'vocab')->find($content_id);
        $content_id = $content_id;


        if ($type == 0) {
            $viewFirstPartName = "show_short";
        } else {
            $viewFirstPartName = "show_long";

        }

        if (Permissions::STUDENT_PERMISSION_ENUM == auth()->user()->is_permission) {//if student

            $isAllowedStudentLessonAccess = CommonStudentLessonsProcesses::studentEachLessonAccess($content_id); // make some processes and checks before navigate to the view

            $isAllowedStudentTabAccess = CommonStudentTabsProcesses::isStudentAllowedToAccessThisTab($content_id, $tab_enum);


            if ($isAllowedStudentLessonAccess == false || $isAllowedStudentTabAccess == false) { // if it not allowed to access this content or this tab , navigate him to no premissions page

                return Redirect::back()->withErrors(["الرجاء الانتهاء من كل الخطوات السابقه لتتمكن من الدخول للمرحله التاليه"]);

            }

            CommonStudentTabsProcesses::EachTabAccessProcesses($tab_enum, $content_id);


            return view('student.content.poll.' . $viewFirstPartName)->with(compact('content'))->with(compact('content_id'));
        } else {
            return view('admin.content.poll.' . $viewFirstPartName)->with(compact('content'))->with(compact('content_id'));
        }


    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PollResults $pollResults
     * @return \Illuminate\Http\Response
     */
    public function edit(PollResults $pollResults)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\PollResults $pollResults
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PollResults $pollResults)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PollResults $pollResults
     * @return \Illuminate\Http\Response
     */
    public function destroy(PollResults $pollResults)
    {
        //
    }
}
