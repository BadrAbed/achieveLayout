<?php
/**
 * Created by PhpStorm.
 * User: badr.abed
 * Date: 8/30/2018
 * Time: 9:15 AM
 */

namespace App\Http\OwnClasses;


class TYPE_OF_USERS_ENUMS
{
    public const EnglishPermissionsList = array("0" => "admin", "1" => "leader", "2" => "editor", "3" => "reviewer", "4" => "student", "5" => "parent", "6" => "audit");
    const SUPER_ADMIN = 0;
    const LEADER = 1;
    const EDITOR = 2;
    const REVIEWER = 3;
    const STUDENT = 4;
    const PARENT = 5;
    const AUDIT = 6;
    const PUBLISHER = 7;
    const QUESTIONEDITOR = 8;
    const QUESTIONREVIEWER = 9;
}