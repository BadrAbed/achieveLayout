<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\AssignLessonsToReviewers;
use App\Content;
use App\ContentFollowStatus;
use App\EducationLevel;
use App\Http\OwnClasses\CONTENT_FOLLOW_STATUS_ENUMS;

class PublisherController extends Controller
{
    public function AjaxAllLessons()
    {

        {


            //$data = [];
            $ckeckRow = AssignLessonsToReviewers::where('user_id', auth()->id())->get()->pluck('content_id')->toArray();
            $data = Content::with('Country', 'grade', 'Categories', 'user')->orderBy("id", "desc")->where(["complete" => 1, 'flowStatus' => CONTENT_FOLLOW_STATUS_ENUMS::UNDER_PUBLISH])->whereNotIn('id', $ckeckRow)->get();


            $arr = [];
            foreach ($data as $row) {


                if (@$_GET["content_name"]) {
                    if (strstr($row->content_name, $_GET["content_name"]) == false) {
                        continue;
                    }
                }
                if (@$_GET["grade"]) {

                    if (strstr($row->grade->name, $_GET["grade"]) == false) {

                        continue;
                    }
                }
                if (@$_GET["country"]) {

                    if (strstr((string)$row->country->name, (string)$_GET["country"]) == false) {
                        continue;
                    }
                }

                $parent = EducationLevel::where('id', $row->grade->parent_id)->first();
                $arr[] = array("ID" => htmlspecialchars($row->id, ENT_QUOTES), "Created_at" => htmlspecialchars($row->created_at, ENT_QUOTES), "content_name" => htmlspecialchars($row->content_name, ENT_QUOTES), "grade" => htmlspecialchars($row->grade->name . "-" . $parent->name, ENT_QUOTES), "country" => htmlspecialchars(($row->Country) ? $row->Country->name : "عام", ENT_QUOTES), "user" => htmlspecialchars($row->user->name, ENT_QUOTES), "category" => htmlspecialchars($row->Categories->name, ENT_QUOTES));
                unset($row);
            }

            // $arr["arrCount"]=htmlspecialchars(count($arr),ENT_QUOTES);
            return response()->json($arr);

        }

    }

    public function AjaxMyLessons()
    {

        {


            //$data = [];
            $ckeckRow = AssignLessonsToReviewers::where('user_id', auth()->id())->get()->pluck('content_id')->toArray();
            $data = Content::with('Country', 'grade', 'Categories', 'user')->orderBy("id", "desc")->where(["complete" => 1, 'flowStatus' => CONTENT_FOLLOW_STATUS_ENUMS::UNDER_PUBLISH])->whereIn('id', $ckeckRow)->get();


            $arr = [];
            foreach ($data as $row) {


                if (@$_GET["content_name"]) {
                    if (strstr($row->content_name, $_GET["content_name"]) == false) {
                        continue;
                    }
                }
                if (@$_GET["grade"]) {

                    if (strstr($row->grade->name, $_GET["grade"]) == false) {

                        continue;
                    }
                }
                if (@$_GET["country"]) {

                    if (strstr((string)$row->country->name, (string)$_GET["country"]) == false) {
                        continue;
                    }
                }

                $parent = EducationLevel::where('id', $row->grade->parent_id)->first();
                $arr[] = array("ID" => htmlspecialchars($row->id, ENT_QUOTES), "Created_at" => htmlspecialchars($row->created_at, ENT_QUOTES), "content_name" => htmlspecialchars($row->content_name, ENT_QUOTES), "grade" => htmlspecialchars($row->grade->name . "-" . $parent->name, ENT_QUOTES), "country" => htmlspecialchars(($row->Country) ? $row->Country->name : "عام", ENT_QUOTES), "user" => htmlspecialchars($row->user->name, ENT_QUOTES), "category" => htmlspecialchars($row->Categories->name, ENT_QUOTES));
                unset($row);
            }

            // $arr["arrCount"]=htmlspecialchars(count($arr),ENT_QUOTES);
            return response()->json($arr);

        }

    }

    public function AllLessonsView()
    {
        return view('publisher.allLessons');
    }

    public function myLessonsView()
    {
        return view('publisher.myLessons');
    }

    public function assignLessonToPublisher($id)
    {
        $ckeckRow = AssignLessonsToReviewers::where(['user_id' => auth()->id(), 'content_id' => $id])->first();
        if ($ckeckRow) {
            return redirect()->back()->withErrors(['الدرس مع مراجع بالفعل ']);
        }
        $newRow = new AssignLessonsToReviewers;
        $newRow->content_id = $id;
        $newRow->user_id = auth()->id();
        $newRow->status = CONTENT_FOLLOW_STATUS_ENUMS::UNDER_PUBLISH;
        $newRow->save();
        Session::flash('message', 'تم اضافة الدرس الى قائمة الدروس');
        return redirect('content/'.$id);
    }

    public function resendingLessons()
    {
        $content_ids = AssignLessonsToReviewers::where('user_id', auth()->id())->get()->pluck('content_id')->toArray();
        $contents = Content::with('Country', 'grade', 'Categories', 'user')->orderBy("id", "desc")->where(["complete" => 1, 'flowStatus' => CONTENT_FOLLOW_STATUS_ENUMS::RESEND_TO_PUBLISHER])->whereIn('id', $content_ids)->get();
        NotificationsController::markAsRead();
        return view('publisher.resendingLessons')->with(compact('contents'));
    }
}
