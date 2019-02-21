<?php
/**
 * Created by PhpStorm.
 * User: badr.abed
 * Date: 8/9/2018
 * Time: 4:02 PM
 */

namespace App\Http\OwnClasses;


class STUDENT_PLACEMENT_TEST_RESULT_ENUMS
{
    const GRADE = ["0" => "أدنى", "1" => "متوسط", "2" => "متقدم"];
    const GET_BLOW_LEVEL = SELF::GRADE[0];
    const GET_AVERAGE_LEVEL = SELF::GRADE[1];
    const GET_ABOVE_LEVEL = SELF::GRADE[2];

    public static function getGrade($grade_percent)
    {

        if ($grade_percent < 65) {
            return self::GET_BLOW_LEVEL;
        }
        if ($grade_percent > 65 && $grade_percent < 80 ) {
        return self::GET_AVERAGE_LEVEL;
    }
        if ($grade_percent > 80) {
            return self::GET_ABOVE_LEVEL;
        }
    }
}