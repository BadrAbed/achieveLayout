<?php

namespace App\Http\Controllers;

use App\Content;
use App\ContentFollowStatus;
use App\Http\OwnClasses\CONTENT_FOLLOW_STATUS_ENUMS;
use App\Http\OwnClasses\ISSUES_STATUS_ENUMS;
use App\Issues;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EditorController extends Controller
{
    public function index()
    {
        $underCreate = $contents = Content::with('Country', 'grade', 'Categories', 'user')->orderBy("id", "desc")->where(["complete" => 1, 'user_id' => auth()->id(), 'flowStatus' => CONTENT_FOLLOW_STATUS_ENUMS::UNDER_CREATE])->get()->count();

        $refused = $contents = Content::with('Country', 'grade', 'Categories', 'user')->orderBy("id", "desc")->where(["complete" => 1, 'user_id' => auth()->id(), 'flowStatus' => CONTENT_FOLLOW_STATUS_ENUMS::REFUSED_FROM_Editor])->get()->count();

        $published = $contents = Content::with('Country', 'grade', 'Categories', 'user')->orderBy("id", "desc")->where(["complete" => 1, 'user_id' => auth()->id(), 'flowStatus' => CONTENT_FOLLOW_STATUS_ENUMS::PUBLISH])->get()->count();

        $underReview = $contents = Content::with('Country', 'grade', 'Categories', 'user')->orderBy("id", "desc")->where(["complete" => 1, 'user_id' => auth()->id(),])->where('flowStatus', '!=', CONTENT_FOLLOW_STATUS_ENUMS::PUBLISH)->get()->count();
        return view('editor.home', compact('published', 'refused', 'underCreate', 'underReview'));
    }

    public function viewUnderReview()
    {

        $contents = Content::with('Country', 'grade', 'Categories', 'user')->orderBy("id", "desc")->where(["complete" => 1, 'user_id' => auth()->id()])->whereNotIn('flowStatus', [CONTENT_FOLLOW_STATUS_ENUMS::PUBLISH, CONTENT_FOLLOW_STATUS_ENUMS::UNDER_CREATE])->get();

        return view('editor.underReview')->with(compact('contents'));

    }

    public function publishedLessons()
    {

        $contents = Content::with('Country', 'grade', 'Categories', 'user')->orderBy("id", "desc")->where(["complete" => 1, 'user_id' => auth()->id(), 'flowStatus' => CONTENT_FOLLOW_STATUS_ENUMS::PUBLISH])->get();
        return view('editor.published_lessons')->with(compact('contents'));

    }

    public function refusedLessons()
    {

        $contents = Content::with('Country', 'grade', 'Categories', 'user')->orderBy("id", "desc")->where(["complete" => 1, 'user_id' => auth()->id()])->whereIn('flowStatus' ,[ CONTENT_FOLLOW_STATUS_ENUMS::REFUSED_FROM_Editor, CONTENT_FOLLOW_STATUS_ENUMS::REFUSED_FROM_LANG_CORRECT,CONTENT_FOLLOW_STATUS_ENUMS::REFUSED_FROM_PUBLISHER])->get();
        NotificationsController::markAsRead();
        return view('editor.refused_lessons')->with(compact('contents'));

    }

    public function feedback($id)
    {

        $content = ContentFollowStatus::where(['content_id' => $id, 'status' => CONTENT_FOLLOW_STATUS_ENUMS::REFUSED_FROM_Editor])->first();
        return view('editor.feedback')->with(compact('content'));

    }

    public function WorkOnIssues($id)
    {

        $row = Issues::find($id);
        $row->status = ISSUES_STATUS_ENUMS::WAITING;
        $row->save();
        return redirect()->back();
    }

    public function CloseTheIssues($id)
    {

        $row = Issues::find($id);
        $row->status = ISSUES_STATUS_ENUMS::CLOSED;
        $row->save();
        return redirect()->back();
    }

}
