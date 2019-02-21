<?php

namespace App\Http\Controllers;

use App\AssignLessonsToReviewers;
use App\Content;
use App\Http\OwnClasses\CONTENT_FOLLOW_STATUS_ENUMS;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class QuestionsReviewerController extends Controller
{
    public function index()
    {
        return view('questionsReviewer.viewAllContent');
    }

    public function AjaxAllLessons()
    {
        $condition = 'whereNotIn';
        return response()->json(QuestionsEditorController::getAllLessonsAndGetMyLessonsWithAjax($condition, CONTENT_FOLLOW_STATUS_ENUMS::REVIEW_QUESTIONS));

    }

    public function home()
    {
        return view('questionsReviewer.home');
    }

    public function AssignLessonsToQuestionsReviewer($content_id)
    {
        $row = AssignLessonsToReviewers::where(['content_id' => $content_id, 'user_id' => auth()->id()])->first();
        if ($row) {
            Session::flash('message', 'هذا الدرس مع مراجع بالفعل');
            return redirect()->back();
        }
        $newContent = new AssignLessonsToReviewers();
        $newContent->user_id = auth()->id();
        $newContent->content_id = $content_id;
        $newContent->status = CONTENT_FOLLOW_STATUS_ENUMS::REVIEW_QUESTIONS;
        $newContent->save();
        Session::flash('message', 'تم اضافه الدروس الى قائمة دروسك');
        return redirect('allQuestions/' . $content_id);
    }

    public function MyLessonsView()
    {
        return view('questionsReviewer.myLessons');
    }

    public function MyLessons()
    {
        $condition = 'whereIn';
        return response()->json(QuestionsEditorController::getAllLessonsAndGetMyLessonsWithAjax($condition, CONTENT_FOLLOW_STATUS_ENUMS::REVIEW_QUESTIONS));

    }

    public function ResendingQuestions()
    {

        $contents_idsUser = AssignLessonsToReviewers::where(['user_id' => auth()->id()])->get()->pluck('content_id')->toArray();
        $contents = Content::with('Country', 'grade', 'Categories', 'user')->orderBy("id", "desc")->where(["complete" => 1])->where('flowStatus', CONTENT_FOLLOW_STATUS_ENUMS::RESEND_QUESTIONS)->whereIn('id', $contents_idsUser)->get();
        NotificationsController::markAsRead();
        return view('questionsReviewer.resendingQuestions', compact('contents'));
    }

}
