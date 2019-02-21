<?php
/**
 * Created by PhpStorm.
 * User: badr.abed
 * Date: 6/12/2018
 * Time: 9:51 AM
 */

namespace App\Http\OwnClasses;


class STUDENT_LESSON_PLAN_CONTENT_TABS_ENUMS
{
    /**
     * Enums related to tab_enum column existing in STUDENT_ASSIGNED_LESSON_PLANS_ENUMS Class
     */

    CONST STATUS = ["0" => "Not finished", 1=> "finished"];

    static public function getStatusEnum(): array
    {
        return self::STATUS;
    }

    CONST GET_NOT_FINISHED = 0;
    CONST GET_FINISHED = 1;

}