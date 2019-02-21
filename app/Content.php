<?php

namespace App;

use App\Http\Controllers\LogTimeController;
use App\Http\OwnClasses\STUDENT_LESSON_PLAN_PROGRESSES_ENUMS;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use \App\Http\OwnClasses\Permissions;

use Carbon\Carbon;

class Content extends Model
{
    public $table = "content";

    protected $fillable = [
        'content_name', 'education_level', 'country', 'poll', 'short_article', 'stretch_article', 'though_question', 'user_id'
    ];


    /**
     * to return status of each content for each client and lesson plan for each returnd content on usage
     * @return int
     */
    public function getContentStatusAttribute()
    {

        $current_lesson_plan = StudentAssignedLessonPlan::where("user_id", auth()->id())->first();

        if ($current_lesson_plan) {
            $row = StudentLessonPlanProgress::where(["content_id" => $this->id, "user_id" => auth()->id(), "lesson_plan_id" => $current_lesson_plan->lesson_plan_id])->first();

            if ($row == null) {
                return STUDENT_LESSON_PLAN_PROGRESSES_ENUMS::GET_NOT_STARTED_YET;
            }

            return $row->status;
        }
    }

    public function getAchievedContentDateAttribute()
    {
        $current_lesson_plan = StudentAssignedLessonPlan::where("user_id", auth()->id())->first();

        $row = StudentLessonPlanProgress::where(["content_id" => $this->id, "user_id" => auth()->id(), "lesson_plan_id" => $current_lesson_plan->lesson_plan_id])->first();

        $carbon = new Carbon($row->updated_at);

        return $carbon->year . "-" . $carbon->month . "-" . $carbon->day;

    }



    ///// add global scope to add fixed condition to any query that selects from content , (countries and grades permissions)
    //commented at the current version
    /*  protected static function boot()
     {
         $permissions = new Permissions("content");
         $userAllowedCountriesList = collect($permissions->getAllowedCounteries())->pluck("id");//get ids to restriect all add , edit , delete , view requests for only the allowed
         $userAllowedGrades = collect($permissions->getAllowedGrades())->pluck("id");//get ids to restriect all add , edit , delete , view requests for only the allowed



         parent::boot();

         static::addGlobalScope('age', function (Builder $builder) use ($userAllowedCountriesList, $userAllowedGrades) {

             $builder->whereIn('countries', $userAllowedCountriesList)->whereIn("education_level_id", $userAllowedGrades);//add global scope to add fixed condition to any query that selects from content , (countries and grades permissions)
         });
     }*/


    public function Country()
    {

        return $this->belongsTo('App\Country', 'countries', 'id');
    }

    public function grade()
    {

        return $this->belongsTo('App\EducationLevel', 'education_level_id', 'id');
    }

    public function user()
    {

        return $this->belongsTo('App\User', 'user_id', 'id');
    }

    public function Categories()
    {

        return $this->belongsTo('App\Categories', 'category_id', 'id');
    }

    public function LearingGoal()
    {

        return $this->belongsTo('App\LearingGoal', 'goal_id', 'id');
    }

    public function links()
    {
        return $this->hasMany('App\Links');


    }

    public function articalnormal()
    {
        return $this->hasOne('App\NormalArtical');
    }

    public function articalstrach()
    {
        return $this->hasOne('App\StretchArtical');

    }

    public function vocab()
    {
        return $this->hasMany('App\Vocabulary');

    }
//    public static function boot()
//    {
//
//        parent::boot();
//        Content::observe(new \App\Observers\UserActionsObserve);
//    }

}

