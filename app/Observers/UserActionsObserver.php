<?php

namespace App\Observers;

use App\Http\OwnClasses\CONTENT_FOLLOW_STATUS_ENUMS;
use Auth;
use App\LogTime;

class UserActionsObserver
{
    private $message;

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param mixed $message
     */
    public function setMessage($message): void
    {
        $this->message = $message;
    }

    public function saved($model)
    {

        if ($model->wasRecentlyCreated == true) {
// Data was just created
            $action = 'اضاف';
        } elseif (\Illuminate\Support\Facades\Request::segment(1) == 'logout') {
            $action = "تسجيل خروج";
        } elseif (\Illuminate\Support\Facades\Request::segment(1) == 'logoutSchool') {
            $action = "تسجيل خروج";
        } else {
// Data was updated
            $action = 'عدل';
        }
        $msg = "null";
//        if ($model->getTable() == 'content') {
//            //CONTENT_FOLLOW_STATUS_ENUMS::
//            $msg = CONTENT_FOLLOW_STATUS_ENUMS::GET_STATUS_OF_CONTENT($model->flowStatus);
//        }
        $this->setMessage($msg);
        if (Auth::check()) {
            LogTime::create([
                'user_id' => Auth::user()->id,
                'type' => $action,
                'table_name' => $model->getTable(),
                'name' => $this->getMessage(),
                'row_id' => $model->id
            ]);
        }
    }

    public function deleting($model)
    {
        if (Auth::check()) {
            LogTime::create([
                'user_id' => Auth::user()->id,
                'type' => 'حذف',
                'table_name' => $model->getTable(),
                'name' => ($this->getMessage()) ? $this->getMessage() : 'null',
                'row_id' => $model->id
            ]);
        }
    }
}