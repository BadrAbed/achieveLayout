<?php
/**
 * Created by PhpStorm.
 * User: badr.abed
 * Date: 8/30/2018
 * Time: 2:23 PM
 */

namespace App\Http\OwnClasses;

class TABLES_NAMES_IN_ARABIC
{


    const categories = 'التصنيفات';
    const content = 'المحتوي';
    const country = 'الدولة';
    const education_levels = 'المراحل الدراسيه';
    const issues = 'الملاحظات';
    const learing_goals = 'اهداف التعلم';
    const lesson_plans = 'خطط التعلم';
    const links = 'اللينكات';
    const normal_articals = 'المقال المختصر';
    const placement_tests = 'امتحانات تحديد المستوي';
    const questions = 'الانشطه';
    const schools = 'المدارس';
    const sounds = 'ملفات الصوت';
    const stretch_articals = 'المقال الموسع';
    const users = 'المستخدمين';
    const vocabulary = 'المصطلحات';
    const images = 'الصور';

    static function getTableNameInArabic($table)
    {
        $array = array(

            'التصنيف' => 'categories',
            'المحتوي' => 'الدروس',
            'الدولة' => 'country',
            'المراحلة الدراسيه' => 'education_levels',
            'ملاحظه' => 'issues',
            'هدف تعلم' => 'learing_goals',
            'خطة التعلم' => 'lesson_plans',
            'اللينك' => 'links',
            'المقال المختصر' => 'normal_articals',
            'امتحان تحديد المستوي' => 'placement_tests',
            ' سؤال امتحان تحديد المستوي' => 'placement_test_questions',
            'السؤال' => 'questions',
            'المدارسة' => 'schools',
            'ملف الصوت' => 'sounds',
            'المقال الموسع' => 'stretch_articals',
            'المستخدم' => 'users',
            'المصطلح' => 'vocabulary',
            'الصورة' => 'images',
            'ناتج التعلم' => 'content_learning_goals',
            'ترتب دروس' => 'sortinglessons',
        );
        $key = array_search($table, $array);
        return $key;
    }
}
