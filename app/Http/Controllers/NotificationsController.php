<?php

namespace App\Http\Controllers;

use App\Notifications;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NotificationsController extends Controller
{
    const read = 1;
    const notRead = 0;

    static function createNotification($user_id, $content_id)
    {
        $row = new Notifications;
        $row->user_id = $user_id;
        $row->content_id = $content_id;
        $row->is_read = self::notRead;
        $row->save();
    }

    static function markAsRead()
    {
        $rows = Notifications::where('user_id', auth()->id())->get();
        foreach ($rows as $row) {
            $row->is_read = self::read;
            $row->save();
        }
    }

    public function numberOfNotification()
    {
        $numberOFUnReadNotifications = \App\Notifications::where(['user_id' => auth()->id(), 'is_read' => \App\Http\Controllers\NotificationsController::notRead])->get()->count();

        return response()->json($numberOFUnReadNotifications);

    }
}
