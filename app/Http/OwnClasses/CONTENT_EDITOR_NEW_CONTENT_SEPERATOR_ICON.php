<?php
/**
 * Created by PhpStorm.
 * User: badr.abed
 * Date: 7/10/2018
 * Time: 12:21 PM
 */

namespace App\Http\OwnClasses;


final  class CONTENT_EDITOR_NEW_CONTENT_SEPERATOR_ICON
{
    const CONTENT_EDITOR_SEPERATOR = "</br>----------------------------------صفحه جديد----------------------------------------</br>";//this is the string which will be used to insert new line beside a specific string to be used
    const CONTENT_EDITOR_SEPERATOR_SEARCH = "----------------------------------صفحه جديد----------------------------------------";//this is the pattern we should search because the editor Tiny Mce remove the break line and generate that

    static public function getArrayOfContentsByStringConcatenatedString($content)
    {
        $content = (string)$content;//convert to string

        if (strstr($content, self::CONTENT_EDITOR_SEPERATOR_SEARCH) == false) {

            return [$content];
        }

        $contentArr = explode(self::CONTENT_EDITOR_SEPERATOR_SEARCH, $content);


        return $contentArr;

    }
}


