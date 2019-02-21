<?php
/**
 * Created by PhpStorm.
 * User: badr.abed
 * Date: 8/30/2018
 * Time: 2:23 PM
 */

namespace App\Http\OwnClasses;


class CONTENT_FOLLOW_STATUS_ENUMS
{
    const UNDER_CREATE = 1;
    const UNDER_REVIEW = 2;
    const REFUSED_FROM_Editor = 3;
    const REFUSED_FROM_LANG_CORRECT = 4;
    const UNDER_LANG_CORRECT = 5;
    const UNDER_PUBLISH = 6;
    const PUBLISH = 7;
    const RESEND_TO_REVIEWER = 8;
    const RESEND_TO_LangREVIEWER = 9;
    const REFUSED_FROM_PUBLISHER = 10;
    const RESEND_TO_PUBLISHER = 11;
    const CREATE_QUESTIONS = 12;
    const REVIEW_QUESTIONS = 13;
    const REFUSE_QUESTIONS = 14;
    const RESEND_QUESTIONS = 15;

    static function GET_STATUS_OF_CONTENT($status)
    {
        if ($status == self::UNDER_CREATE) {
            return "تحت الانشاء";
        }
        if ($status == self::UNDER_REVIEW) {
            return "تحت المراجعه";
        }
        if ($status == self::REFUSED_FROM_Editor) {
            return "تم رفضها من مرحله المراجعه ";
        }
        if ($status == self::REFUSED_FROM_LANG_CORRECT) {
            return "تحت رفضه من المراجعه اللغويه";
        }
        if ($status == self::UNDER_LANG_CORRECT) {
            return "تحت المراجعه الللغويه";
        }
        if ($status == self::UNDER_PUBLISH) {
            return "تحت النشر";
        }
        if ($status == self::PUBLISH) {
            return "تم النشر ";
        }
        if ($status == self::RESEND_TO_REVIEWER) {
            return "تحت المراجعه ";
        }
        if ($status == self::RESEND_TO_LangREVIEWER) {
            return " معاد ارساله الى المراجع اللغوى ";
        }
        if ($status == self::REFUSED_FROM_PUBLISHER) {
            return " تم رفضه من مرحله النشر ";
        }
        if ($status == self::RESEND_TO_PUBLISHER) {
            return " معاد ارساله الى الناشر ";
        }
        if ($status == self::CREATE_QUESTIONS) {
            return " تحت انشاء الاسئلة ";
        }
        if ($status == self::REVIEW_QUESTIONS) {
            return " تحت مراجعه الاسئلة ";
        }
        if ($status == self::RESEND_QUESTIONS) {
            return " معاد ارسال السؤال  الى مراجع الاسئلة  ";
        }
        if ($status == self::REFUSE_QUESTIONS) {
            return " تم رفض الاسئلة ";
        }

    }
}