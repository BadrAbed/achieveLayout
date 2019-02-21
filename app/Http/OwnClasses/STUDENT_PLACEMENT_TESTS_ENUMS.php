<?php
/**
 * Created by PhpStorm.
 * User: badr.abed
 * Date: 7/5/2018
 * Time: 11:23 AM
 */

namespace App\Http\OwnClasses;


class STUDENT_PLACEMENT_TESTS_ENUMS
{

    CONST STATUS = ["0" => "غير مفعل", 1 => "مفعل"];

    CONST GET_NOT_ACTIVE = self::STATUS[0];
    CONST GET_ACTIVE = self::STATUS[1];

    CONST COMPLETED_STATUS = ["NOT_COMPLETED" => 0, "COMPLETED" => 1];
    const GET_COMPLETED = self::COMPLETED_STATUS[1];
    const GET_NOT_COMPLETED = self::COMPLETED_STATUS[0];

    /**
     * @param $status_enum
     * @return mixed|string
     * @return word which indicate the provided enum
     */
    public static function getStatusByEnum($status_enum)
    {
        if (array_key_exists($status_enum, self::STATUS) == false) {
            return "غير معرف";
        }

        return self::STATUS[$status_enum];
    }


}