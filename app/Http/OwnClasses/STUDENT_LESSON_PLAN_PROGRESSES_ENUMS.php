<?php
/**
 * Created by PhpStorm.
 * User: badr.abed
 * Date: 6/7/2018
 * Time: 1:12 PM
 */

namespace App\Http\OwnClasses;


class STUDENT_LESSON_PLAN_PROGRESSES_ENUMS
{

    /**
     *  A big not on not started constant , it will only be used on contents that will not be found on progress table , so this not means that each lesson not started , you will have to make a new row for him and set to not started , it just to be used in static places
     */
    CONST STATUS = ["0" => "Started", 1=> "finished" ,-1 =>"not started"];

    static public function getStatusEnum(): array
    {
        return self::STATUS;
    }

    CONST GET_STARTED = 0;
    CONST GET_FINISHED = 1;
    CONST GET_NOT_STARTED_YET = -1 ; //not for database usages , see the current class note above

}