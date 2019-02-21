<?php
/**
 * Created by PhpStorm.
 * User: badr.abed
 * Date: 6/7/2018
 * Time: 1:12 PM
 */

namespace App\Http\OwnClasses;


class STUDENT_ASSIGNED_LESSON_PLANS_ENUMS
{

    CONST CURRENT_TABS_ENUMS = [0, 1, 2, 3, 4, 5];//

    CONST GET_FIRST_TAB_ENUM = self::CURRENT_TABS_ENUMS[0];//return first , and if 0 wasn't the first , please modify it to be the first array value

    CONST GET_LAST_TAB_ENUM = self::CURRENT_TABS_ENUMS[5];//return last , and if 5 wasn't the last , please modify it to be the last array value


    CONST GET_SHORT_SURVEY_TAB_ENUM = self::CURRENT_TABS_ENUMS[0];
    CONST GET_NORMAL_ARTICLE_TAB_ENUM = self::CURRENT_TABS_ENUMS[1];
    CONST GET_SHORT_QUESTIONS_TAB_ENUM = self::CURRENT_TABS_ENUMS[2];
    CONST GET_LONG_SURVEY_TAB_ENUM = self::CURRENT_TABS_ENUMS[3];
    CONST GET_STRETCH_ARTICLE_TAB_ENUM = self::CURRENT_TABS_ENUMS[4];
    CONST GET_LONG_QUESTIONS_TAB_ENUM = self::CURRENT_TABS_ENUMS[5];


    static public function getCurrentTabEnum(): array
    {
        return self::CURRENT_TABS_ENUMS;
    }


    /**
     * @todo : get list of enums required to process to the next lesson
     * @return array
     */
    static public function getRequiredTabsListOfEnums(): array
    {
        return [0, 1, 2, 3];
    }

    /**
     * @param $currentTabEnum
     * @return int or null
     * @todo : get next tab enum or null in case the current provided one is the last
     */
    static public function getNextTabEnum($currentTabEnum): int
    {


        if ($currentTabEnum == self::GET_LAST_TAB_ENUM) { //if current tab is the last , then the next is the first tab enum
            return NULL;
        }


        return self::CURRENT_TABS_ENUMS[$currentTabEnum + 1];

    }

    /**
     * @param $currentTabEnum
     * @todo get list of tabs enums values that stands before the provided one.
     * @return array
     */

    public static function getPreviousTabsValuesFromSpecificPoint($currentTabEnum): array
    {

        $currentTabKey = array_search($currentTabEnum, self::CURRENT_TABS_ENUMS);


        return array_slice(self::CURRENT_TABS_ENUMS, 0, $currentTabKey);

    }


    /**
     * @param : $tab_enum
     * @todo : return tab enum which allowed by application rules that if the user finished, he can access the next lesson
     * but why returnung the element number 4 ? becasuse the last two enums of long activity and long survery are optional , so the last tab that
     * the user can be upgrated to the next lesson is to finish GET_LONG_SURVEY_TAB_ENUM
     *
     * @return  : boolean
     */
    public static function isLastRequiredTabEnumToOpenNewLesson($tab_enum)
    {

        return $tab_enum == self::GET_LONG_SURVEY_TAB_ENUM;

    }


}