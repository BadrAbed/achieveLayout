<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


use Doctrine\DBAL\Query\QueryBuilder;
use Illuminate\Support\Collection;

class Sortinglesson extends Model
{


    /**
     * @param $lesson_plan_id
     * @param $current_content_id
     * @todo get next lesson plan by the current lesson plan id
     * @return integer|bool|null
     * @integer in case content id
     * @false in case there is no next lesson for any reason
     * @null for failed to get current lesson order
     */
    static public function getNextLessonOfTheLessonPlan($lesson_plan_id, $current_content_id)
    {
        $currentLessonOrderDetial = self::where("lesson_id", $lesson_plan_id)->where("content_id", $current_content_id)->first();
if($currentLessonOrderDetial) {
    $currentLessonOrder=$currentLessonOrderDetial->sorting;
    if (!is_numeric($currentLessonOrder)) {
        return null;
    }


    $nextContent = self::where("lesson_id", $lesson_plan_id)->where("sorting", ">", $currentLessonOrder)->orderBy("sorting", "asc")->first();

    if ($nextContent == null) {
        return false;
    }
    $nextContentID = $nextContent->content_id;

    return $nextContentID;
}
        return false;
    }


    /**
     * @param $lesson_plan
     * @param $content_id
     * @return collection of previous lessons of the current lesson on the lesson plan.
     * @note : it may return empty collection if the current lesson is the first one in the lesson plan sorting rows.
     */
    static public function getListOfPreviousLessonsOfLessonPlanBySpecificLesson($lesson_plan, $content_id)
    {

        $currentLessonOrder = self::where("lesson_id", $lesson_plan)->where("content_id", $content_id)->first()->sorting;

        if (!is_numeric($currentLessonOrder)) {
            return false;
        }

        $previous_lessons = Sortinglesson::where('lesson_id', $lesson_plan)->where("sorting", "<", $currentLessonOrder)->orderBy("sorting", "asc")->get();

        return $previous_lessons;

    }


    /**
     * @param $lesson_plan_id
     * @return collection
     * @todo : get collection for all lessons for specific lesson plan orderd by sorting because we are using it in showing lessons for student , so we must show it in ordering
     */
    static public function get_all_lessons_for_specific_lesson_orderd_by_sorting_obligatory($lesson_plan_id)
    {
        $content_ids = Sortinglesson::where('lesson_id', $lesson_plan_id)->orderBy('sorting', 'asc')->get();

        foreach ($content_ids as $eachLesson) {
            $contents_rows [] = Content::with('grade', 'country', 'Categories')->where('id', $eachLesson->content_id)->first(); //dump each content row in the array
        }

        return $contents_rows;

    }


    /**
     * @param $lesson_plan_id
     * @return null or content id as integer
     * @todo :  get first lesson in specific lesson plan or return null if not exists
     */
    static public function get_first_lesson_in_specific_lesson_plan($lesson_plan_id)
    {
        $content_id = Sortinglesson::where('lesson_id', $lesson_plan_id)->limit(1)->orderBy("sorting", "asc")->first();

        if ($content_id == null) {

            return null;
        } else {

            return $content_id->content_id;
        }

    }

    public static function boot()
    {
        parent::boot();
        Sortinglesson::observe(new \App\Observers\UserActionsObserver);
    }
}
