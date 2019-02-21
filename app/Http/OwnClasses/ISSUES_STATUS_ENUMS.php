<?php
/**
 * Created by PhpStorm.
 * User: badr.abed
 * Date: 9/4/2018
 * Time: 2:49 PM
 */

namespace App\Http\OwnClasses;


class ISSUES_STATUS_ENUMS
{
    const OPEN = 0;
    const WAITING = 1;
    const CLOSED = 2;

    static function STATUS($status)
    {
        if ($status == self::OPEN) {
            return 'لم يتم العمل عليها';
        }
        if ($status == self::WAITING) {
            return 'جارى العمل عليها';
        }
        if ($status == self::CLOSED) {
            return 'تم الانتهاء منها';
        }
    }

}