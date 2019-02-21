<?php

namespace App\Http\Controllers;

use App\AssignLessonsToReviewers;
use App\Content;
use App\ContentFollowStatus;
use App\Http\OwnClasses\CONTENT_FOLLOW_STATUS_ENUMS;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class ContentFollowStatusController extends Controller
{

    public function SendToQuestionReviewer($content_id)
    {
        if (self::CheckIfUserAllowToAccessThisContentOrNot($content_id)) {
            if (self::CheckUserIsAllowToAccessThisFunction(CONTENT_FOLLOW_STATUS_ENUMS::CREATE_QUESTIONS, $content_id)) {
                if (self::changeContentFollowStatus(CONTENT_FOLLOW_STATUS_ENUMS::REVIEW_QUESTIONS, $content_id)) {
                    Session::flash('message', 'تم ارسال المحتوى بنجاح لمراجعة الاسئلة');
                    $arr['name'] = 'تم اراسال المحتوى لمرجعة الاسئلة';
                    $arr['table_name'] = 'الدروس';
                    $arr['type'] = 'مراجعة الاسئلة';
                    $arr['row_id'] = $content_id;
                    LogTimeController::saveLogesTimes($arr);
                    return redirect('QuestionsEditor/MyLessonsView');
                }
            }

            return redirect()->back()->withErrors(['لا يوجد محتوى بهذا الاسم او غير مسموح لك الدخول الى هنا ']);
        }
        return redirect()->back()->withErrors(['اضف الدرس الى قائمة دروسك اولا ']);
    }

    public function sendToCreateQuestions($content_id)
    {
        if (self::CheckIfUserAllowToAccessThisContentOrNot($content_id)) {
            if (self::CheckUserIsAllowToAccessThisFunction(CONTENT_FOLLOW_STATUS_ENUMS::UNDER_REVIEW, $content_id, CONTENT_FOLLOW_STATUS_ENUMS::REFUSED_FROM_Editor)) {
                if (self::changeContentFollowStatus(CONTENT_FOLLOW_STATUS_ENUMS::CREATE_QUESTIONS, $content_id)) {
                    Session::flash('message', 'تم ارسال المحتوى بنجاح لانشاء الاسئلة');
                    $arr['name'] = 'تم اراسال المحتوى لانشاء الاسئلة';
                    $arr['table_name'] = 'الدروس';
                    $arr['type'] = 'لانشاء الاسئلة';
                    $arr['row_id'] = $content_id;
                    LogTimeController::saveLogesTimes($arr);
                    return redirect()->back();
                }
            }
            return redirect()->back()->withErrors(['لا يوجد محتوى بهذا الاسم ']);
        }
        return redirect()->back()->withErrors(['اضف الدرس الى قائمة دروسك اولا  ']);


    }

    public function reviewForEditor($id)
    {
        if (self::CheckUserIsAllowToAccessThisFunction(CONTENT_FOLLOW_STATUS_ENUMS::UNDER_CREATE, $id)) {

            $content = Content::find($id);
            $flowStatus = CONTENT_FOLLOW_STATUS_ENUMS::UNDER_REVIEW;
            if ($content->flowStatus == CONTENT_FOLLOW_STATUS_ENUMS::UNDER_CREATE || $content->flowStatus == CONTENT_FOLLOW_STATUS_ENUMS::REFUSED_FROM_Editor) {
                if ($content->flowStatus == CONTENT_FOLLOW_STATUS_ENUMS::REFUSED_FROM_Editor) {
                    $flowStatus = CONTENT_FOLLOW_STATUS_ENUMS::RESEND_TO_REVIEWER;
                }
                self::changeContentFollowStatus($flowStatus, $id);
                if ($flowStatus == CONTENT_FOLLOW_STATUS_ENUMS::RESEND_TO_REVIEWER) {
                    $rowFollowStatus = AssignLessonsToReviewers::where(['content_id' => $id, 'status' => CONTENT_FOLLOW_STATUS_ENUMS::UNDER_REVIEW])->first();
                    NotificationsController::createNotification($rowFollowStatus->user_id, $id);

                }

                Session::flash('message', 'المحتوى تم ارسالة للمراجعة الفنية');
                $arr['name'] = 'تم اراسال المحتوى لمرجعةالفنية ';
                $arr['table_name'] = 'الدروس';
                $arr['type'] = 'المراجعة الفنية';
                $arr['row_id'] = $id;
                LogTimeController::saveLogesTimes($arr);
                return redirect()->back();
            }
        }
        return redirect()->back()->withErrors(['المحتوى تم ارساله للمراجعه  من قبل ']);

    }

    public function resendLessonFromEditorToReviewer($id)
    {
        if (self::CheckUserIsAllowToAccessThisFunction(CONTENT_FOLLOW_STATUS_ENUMS::REFUSED_FROM_Editor, $id, CONTENT_FOLLOW_STATUS_ENUMS::REFUSED_FROM_LANG_CORRECT, CONTENT_FOLLOW_STATUS_ENUMS::REFUSED_FROM_PUBLISHER)) {

            self::changeContentFollowStatus(CONTENT_FOLLOW_STATUS_ENUMS::RESEND_TO_REVIEWER, $id);
            $rowFollowStatus = AssignLessonsToReviewers::where(['content_id' => $id, 'status' => CONTENT_FOLLOW_STATUS_ENUMS::UNDER_REVIEW])->first();
            NotificationsController::createNotification($rowFollowStatus->user_id, $id);
            Session::flash('message', 'المحتوى تم اعادةارسالة للمراجعة الفنية');
            $arr['name'] = 'تم اراسال المحتوى للمرجعة الفنية';
            $arr['table_name'] = 'الدروس';
            $arr['type'] = 'للمراجعة الفنية';
            $arr['row_id'] = $id;
            LogTimeController::saveLogesTimes($arr);
            return redirect()->back();
        }
        return redirect()->back()->withErrors(['حدث خطا لا يمكنك اعادة ارسال المحتوى']);
    }


    public function sendToLangReviewer($id)
    {
        if (self::CheckUserIsAllowToAccessThisFunction(CONTENT_FOLLOW_STATUS_ENUMS::REVIEW_QUESTIONS, $id, CONTENT_FOLLOW_STATUS_ENUMS::RESEND_TO_REVIEWER, CONTENT_FOLLOW_STATUS_ENUMS::RESEND_QUESTIONS)) {
            $content = Content::find($id);

            $CheckAssignContentToReviewer = AssignLessonsToReviewers::where(['user_id' => auth()->id(), 'content_id' => $id])->first();
            $CheckAssignContentToLangReviewer = AssignLessonsToReviewers::where(['status' => CONTENT_FOLLOW_STATUS_ENUMS::UNDER_LANG_CORRECT, 'content_id' => $id])->first();

//            if ($content->flowStatus != CONTENT_FOLLOW_STATUS_ENUMS::REVIEW_QUESTIONS  ) {
//
//                return redirect()->back()->withErrors('المحتوى تم ارساله للمراجعه اللغويه من قبل ');
//            }
            if (auth()->user()->is_permission != \App\Http\OwnClasses\TYPE_OF_USERS_ENUMS::SUPER_ADMIN && auth()->user()->is_permission != \App\Http\OwnClasses\TYPE_OF_USERS_ENUMS::LEADER) {

                if (!$CheckAssignContentToReviewer) {

                    return redirect()->back()->withErrors('من فضلك اضف المحتوى الى قائمه دروسك اولا ');
                }
            }
            if ($CheckAssignContentToLangReviewer) {
                self::checkIfContentRowHasBeenCreatedBeforeOrNotAndAddNewRowIfNot($id, CONTENT_FOLLOW_STATUS_ENUMS::RESEND_TO_LangREVIEWER);
                self::changeContentFollowStatus(CONTENT_FOLLOW_STATUS_ENUMS::RESEND_TO_LangREVIEWER, $id);
                NotificationsController::createNotification($CheckAssignContentToLangReviewer->user_id, $id);
                Session::flash('message', 'المحتوى تم ارسالة للمراجعة');
                $arr['name'] = 'تم اراسال المحتوى للمرجعة اللغوية';
                $arr['table_name'] = 'الدروس';
                $arr['type'] = 'للمراجعة اللغوية';
                $arr['row_id'] = $id;
                LogTimeController::saveLogesTimes($arr);
                return redirect('LangReviewer/myLessonsView');
            }

            self::changeContentFollowStatus(CONTENT_FOLLOW_STATUS_ENUMS::UNDER_LANG_CORRECT, $id);
            self::checkIfContentRowHasBeenCreatedBeforeOrNotAndAddNewRowIfNot($id, CONTENT_FOLLOW_STATUS_ENUMS::UNDER_LANG_CORRECT);
            Session::flash('message', 'المحتوى تم ارسالة للمراجعة');
            $arr['name'] = 'تم اراسال المحتوى للمرجعة اللغوية';
            $arr['table_name'] = 'الدروس';
            $arr['type'] = 'للمراجعة اللغوية';
            $arr['row_id'] = $id;
            LogTimeController::saveLogesTimes($arr);
            return redirect()->back();
        }
    }

    public function refusedFromEditor($id)
    {
        if (self::CheckUserIsAllowToAccessThisFunction(CONTENT_FOLLOW_STATUS_ENUMS::UNDER_REVIEW, $id, CONTENT_FOLLOW_STATUS_ENUMS::RESEND_TO_REVIEWER)) {
            $content = Content::find($id);
            $CheckAssignContentToReviewer = AssignLessonsToReviewers::where(['user_id' => auth()->id(), 'content_id' => $id])->first();
            if ($content->flowStatus == CONTENT_FOLLOW_STATUS_ENUMS::UNDER_LANG_CORRECT) {
                return redirect()->back()->withErrors(['المحتوى تم ارساله للمراجعه اللغويه من قبل ']);
            }
            if (auth()->user()->is_permission != \App\Http\OwnClasses\TYPE_OF_USERS_ENUMS::SUPER_ADMIN && auth()->user()->is_permission != \App\Http\OwnClasses\TYPE_OF_USERS_ENUMS::LEADER) {
                if (!$CheckAssignContentToReviewer) {
                    return redirect()->back()->withErrors(['من فضلك اضف المحتوى الى قائمه دروسك اولا ']);
                }
            }

            self::changeContentFollowStatus(CONTENT_FOLLOW_STATUS_ENUMS::REFUSED_FROM_Editor, $id);
            NotificationsController::createNotification($content->user_id, $id);
            self::checkIfContentRowHasBeenCreatedBeforeOrNotAndAddNewRowIfNot($id, CONTENT_FOLLOW_STATUS_ENUMS::REFUSED_FROM_Editor);
            Session::flash('message', 'تم رفض المحتوى');
            $arr['name'] = 'تم رفض المحتوى للمرجعة الفنية';
            $arr['table_name'] = 'الدروس';
            $arr['type'] = 'للمراجعة الفنية';
            $arr['row_id'] = $id;
            LogTimeController::saveLogesTimes($arr);
            return redirect()->back();
        }
    }


    public function LangReviewerRefuse($id)
    {
        if (self::CheckUserIsAllowToAccessThisFunction(CONTENT_FOLLOW_STATUS_ENUMS::UNDER_LANG_CORRECT, $id, CONTENT_FOLLOW_STATUS_ENUMS::RESEND_TO_LangREVIEWER)) {
            $content = Content::find($id);
            $CheckAssignContentToReviewer = AssignLessonsToReviewers::where(['user_id' => auth()->id(), 'content_id' => $id])->first();
            if ($content->flowStatus == CONTENT_FOLLOW_STATUS_ENUMS::UNDER_PUBLISH) {
                return redirect()->back()->withErrors(['المحتوى تم ارساله للنشر اللغويه من قبل ']);
            }
            if (auth()->user()->is_permission != \App\Http\OwnClasses\TYPE_OF_USERS_ENUMS::SUPER_ADMIN && auth()->user()->is_permission != \App\Http\OwnClasses\TYPE_OF_USERS_ENUMS::LEADER) {
                if (!$CheckAssignContentToReviewer) {
                    return redirect()->back()->withErrors(['من فضلك اضف المحتوى الى قائمه دروسك اولا ']);
                }
            }
            self::changeContentFollowStatus(CONTENT_FOLLOW_STATUS_ENUMS::REFUSED_FROM_LANG_CORRECT, $id);
            NotificationsController::createNotification($content->user_id, $id);
            self::checkIfContentRowHasBeenCreatedBeforeOrNotAndAddNewRowIfNot($id, CONTENT_FOLLOW_STATUS_ENUMS::REFUSED_FROM_Editor);
            Session::flash('message', 'تم رفض المحتوى');
            $arr['name'] = 'تم رفض المحتوى للمرجعة اللغوية';
            $arr['table_name'] = 'الدروس';
            $arr['type'] = 'للمراجعة اللغوية';
            $arr['row_id'] = $id;
            LogTimeController::saveLogesTimes($arr);
            return redirect()->back();
        }
    }

    public function LangReviewerSendToPublisher($id)
    {
        if (self::CheckUserIsAllowToAccessThisFunction(CONTENT_FOLLOW_STATUS_ENUMS::UNDER_LANG_CORRECT, $id, CONTENT_FOLLOW_STATUS_ENUMS::RESEND_TO_LangREVIEWER)) {
            $content = Content::find($id);
            $CheckAssignContentToReviewer = AssignLessonsToReviewers::where(['user_id' => auth()->id(), 'content_id' => $id])->first();
            $CheckAssignContentToLangReviewer = AssignLessonsToReviewers::where(['status' => CONTENT_FOLLOW_STATUS_ENUMS::UNDER_PUBLISH, 'content_id' => $id])->first();

            if ($content->flowStatus == CONTENT_FOLLOW_STATUS_ENUMS::UNDER_PUBLISH) {
                return redirect()->back()->withErrors(['المحتوى تم ارساله للنشر من قبل او تم رفضه من قبل ']);
            }
            if (auth()->user()->is_permission != \App\Http\OwnClasses\TYPE_OF_USERS_ENUMS::SUPER_ADMIN && auth()->user()->is_permission != \App\Http\OwnClasses\TYPE_OF_USERS_ENUMS::LEADER) {
                if (!$CheckAssignContentToReviewer) {
                    return redirect()->back()->withErrors(['من فضلك اضف المحتوى الى قائمه دروسك اولا ']);
                }
            }
            if ($CheckAssignContentToLangReviewer && $content->flowStatus == CONTENT_FOLLOW_STATUS_ENUMS::RESEND_TO_LangREVIEWER) {
                self::checkIfContentRowHasBeenCreatedBeforeOrNotAndAddNewRowIfNot($id, CONTENT_FOLLOW_STATUS_ENUMS::RESEND_TO_LangREVIEWER);

                self::changeContentFollowStatus(CONTENT_FOLLOW_STATUS_ENUMS::RESEND_TO_PUBLISHER, $id);
                NotificationsController::createNotification($CheckAssignContentToLangReviewer->user_id, $id);
                return redirect()->back();
            }

            $content->flowStatus = CONTENT_FOLLOW_STATUS_ENUMS::UNDER_PUBLISH;
            $content->save();
            //NotificationsController::createNotification($content->user_id, $id);
            self::checkIfContentRowHasBeenCreatedBeforeOrNotAndAddNewRowIfNot($id, CONTENT_FOLLOW_STATUS_ENUMS::UNDER_PUBLISH);
            Session::flash('message', 'المحتوى تم ارسالة للنشر');
            $arr['name'] = 'تم اراسال المحتوى للنشر';
            $arr['table_name'] = 'الدروس';
            $arr['type'] = 'النشر';
            $arr['row_id'] = $id;
            LogTimeController::saveLogesTimes($arr);
            return redirect()->back();
        }
    }

    public function refusedQuestions($content_id)
    {
        if (self::CheckIfUserAllowToAccessThisContentOrNot($content_id)) {
            if (self::CheckUserIsAllowToAccessThisFunction(CONTENT_FOLLOW_STATUS_ENUMS::REVIEW_QUESTIONS, $content_id, CONTENT_FOLLOW_STATUS_ENUMS::RESEND_QUESTIONS)) {
                $CheckAssignContentToQuestionsReviewer = \App\AssignLessonsToReviewers::where(['status' => CONTENT_FOLLOW_STATUS_ENUMS::REVIEW_QUESTIONS, 'content_id' => $content_id])->first();
                $CheckAssignContentToQuestionsEditor = \App\AssignLessonsToReviewers::where(['status' => CONTENT_FOLLOW_STATUS_ENUMS::CREATE_QUESTIONS, 'content_id' => $content_id])->first();

                if ($CheckAssignContentToQuestionsReviewer) {
                    self::changeContentFollowStatus(CONTENT_FOLLOW_STATUS_ENUMS::REFUSE_QUESTIONS, $content_id);
                    NotificationsController::createNotification($CheckAssignContentToQuestionsEditor->user_id, $content_id);
                    Session::flash('message', 'تم رفض الاسئله');
                    $arr['name'] = 'تم رفض الاسئله';
                    $arr['table_name'] = 'الدروس';
                    $arr['type'] = 'مراجعة الاسئله';
                    $arr['row_id'] = $content_id;
                    LogTimeController::saveLogesTimes($arr);
                    return redirect('QuestionsReviewer/MyLessonsView');
                }
                Session::flash('message', 'اضف المحتوي الي قائمه دروسك اولا');
                return redirect()->back();
            }
        }
        return redirect()->back()->withErrors(['من فضلك اضف المحتوى الى قائمه دروسك اولا ']);
    }

    public function resendQuestionsToQuestionsReviewer($content_id)
    {
        if (self::CheckIfUserAllowToAccessThisContentOrNot($content_id)) {
            if (self::CheckUserIsAllowToAccessThisFunction(CONTENT_FOLLOW_STATUS_ENUMS::REFUSE_QUESTIONS, $content_id)) {
                $CheckAssignContentToQuestionsReviewer = \App\AssignLessonsToReviewers::where(['status' => CONTENT_FOLLOW_STATUS_ENUMS::REVIEW_QUESTIONS, 'content_id' => $content_id])->first();
                if ($CheckAssignContentToQuestionsReviewer) {
                    self::changeContentFollowStatus(CONTENT_FOLLOW_STATUS_ENUMS::RESEND_QUESTIONS, $content_id);
                    NotificationsController::createNotification($CheckAssignContentToQuestionsReviewer->user_id, $content_id);
                    Session::flash('message', 'تم اعاده ارسال الاسئله');
                    $arr['name'] = 'تم اعاده ارسال الاسئله';
                    $arr['table_name'] = 'الدروس';
                    $arr['type'] = 'اعاده ارسال الاسئله';
                    $arr['row_id'] = $content_id;
                    LogTimeController::saveLogesTimes($arr);
                    return redirect('QuestionsEditor/MyLessonsView');
                }
                Session::flash('message', 'اضف المحتوي الي قائمه دروسك اولا');
                return redirect()->back();
            }
        }
        return redirect()->back()->withErrors(['من فضلك اضف المحتوى الى قائمه دروسك اولا ']);

    }

    public function publish($id)
    {
        if (self::CheckUserIsAllowToAccessThisFunction(CONTENT_FOLLOW_STATUS_ENUMS::UNDER_PUBLISH, $id, CONTENT_FOLLOW_STATUS_ENUMS::RESEND_TO_PUBLISHER)) {
            $CheckAssignContentToPublisher = AssignLessonsToReviewers::where(['user_id' => auth()->id(), 'content_id' => $id])->first();
            if (auth()->user()->is_permission != \App\Http\OwnClasses\TYPE_OF_USERS_ENUMS::SUPER_ADMIN && auth()->user()->is_permission != \App\Http\OwnClasses\TYPE_OF_USERS_ENUMS::LEADER) {
                if (!$CheckAssignContentToPublisher) {
                    return redirect()->back()->withErrors(['من فضلك اضف المحتوى الى قائمه دروسك اولا ']);
                }
            }
            // $content->flowStatus = CONTENT_FOLLOW_STATUS_ENUMS::PUBLISH;
            self::changeContentFollowStatus(CONTENT_FOLLOW_STATUS_ENUMS::PUBLISH, $id);

            // self::checkIfContentRowHasBeenCreatedBeforeOrNotAndAddNewRowIfNot($id, CONTENT_FOLLOW_STATUS_ENUMS::PUBLISH);
            Session::flash('message', 'المحتوى تم نشره');
            $arr['name'] = 'المحتوى تم نشره';
            $arr['table_name'] = 'الدروس';
            $arr['type'] = 'نشر';
            $arr['row_id'] = $id;
            LogTimeController::saveLogesTimes($arr);
            return redirect()->back();
        }
    }

    public function PublisherRefuse($id)
    {
        if (self::CheckUserIsAllowToAccessThisFunction(CONTENT_FOLLOW_STATUS_ENUMS::UNDER_PUBLISH, $id, CONTENT_FOLLOW_STATUS_ENUMS::RESEND_TO_PUBLISHER)) {

            $content = Content::find($id);
            $CheckAssignContentToReviewer = AssignLessonsToReviewers::where(['user_id' => auth()->id(), 'content_id' => $id])->first();
            if (auth()->user()->is_permission != \App\Http\OwnClasses\TYPE_OF_USERS_ENUMS::SUPER_ADMIN && auth()->user()->is_permission != \App\Http\OwnClasses\TYPE_OF_USERS_ENUMS::LEADER) {
                if (!$CheckAssignContentToReviewer) {
                    return redirect()->back()->withErrors(['من فضلك اضف المحتوى الى قائمه دروسك اولا ']);
                }
            }
            //   $content->flowStatus = CONTENT_FOLLOW_STATUS_ENUMS::REFUSED_FROM_PUBLISHER;
            self::changeContentFollowStatus(CONTENT_FOLLOW_STATUS_ENUMS::REFUSED_FROM_PUBLISHER, $id);
            NotificationsController::createNotification($content->user_id, $id);
            //   self::checkIfContentRowHasBeenCreatedBeforeOrNotAndAddNewRowIfNot($id, CONTENT_FOLLOW_STATUS_ENUMS::REFUSED_FROM_PUBLISHER);
            Session::flash('message', 'المحتوى تم رفضة');
            $arr['name'] = 'المحتوى تم رفضه';
            $arr['table_name'] = 'الدروس';
            $arr['type'] = 'رفض النشر';
            $arr['row_id'] = $id;
            LogTimeController::saveLogesTimes($arr);
            return redirect()->back();
        }
    }

    static function checkIfContentRowHasBeenCreatedBeforeOrNotAndAddNewRowIfNot($id, $status)
    {
        $rowFollowStatus = ContentFollowStatus::where(['content_id' => $id, 'user_id' => auth()->id()])->first();
        if ($rowFollowStatus == null) {
            $row = new ContentFollowStatus;
            $row->user_id = auth()->id();
            $row->content_id = $id;
        } else {
            $row = ContentFollowStatus::where(['content_id' => $id, 'user_id' => auth()->id()])->first();
        }

        $row->status = $status;
        $row->save();


    }

    static function changeContentFollowStatus($followStatus, $content_id)
    {
        $content = Content::find($content_id);
        if ($content) {
            $content->flowStatus = $followStatus;
            $content->save();
            self::checkIfContentRowHasBeenCreatedBeforeOrNotAndAddNewRowIfNot($content_id, $followStatus);

            return true;
        }
        return false;

    }

    static function CheckUserIsAllowToAccessThisFunction($FollowStatus1, $content_id, $FollowStatus2 = null, $FollowStatus3 = null, $FollowStatus4 = null)
    {
        $content = Content::find($content_id);
        if ($content) {
            if ($content->flowStatus == $FollowStatus1) {
                return true;
            }
            if ($content->flowStatus == $FollowStatus1 || $content->flowStatus == $FollowStatus1 || $content->flowStatus == $FollowStatus2 || $content->flowStatus == $FollowStatus3 || $content->flowStatus == $FollowStatus4) {
                return true;
            }
        }
        return true;
    }

    static function CheckIfUserAllowToAccessThisContentOrNot($content_id)
    {
        $content = Content::find($content_id);
        if (auth()->user()->is_permission == \App\Http\OwnClasses\TYPE_OF_USERS_ENUMS::SUPER_ADMIN || auth()->user()->is_permission == \App\Http\OwnClasses\TYPE_OF_USERS_ENUMS::LEADER) {
            return true;
        }
        if ($content->user_id == auth()->id()) {
            return true;
        }
        $checkIfuserAllowToAccessthisContent = AssignLessonsToReviewers::where(['content_id' => $content_id, 'user_id' => auth()->id()])->first();
        if ($checkIfuserAllowToAccessthisContent) {
            return true;

        }
        return false;
    }
}
