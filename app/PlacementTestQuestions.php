<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlacementTestQuestions extends Model
{
    protected $table = "placement_test_questions";


    public function placementQuestionAnswers()
    {
        return $this->hasMany('App\PlacementTestQuestionAnswers', "question_id");

    }

    public function grade()
    {

        return $this->belongsTo('App\EducationLevel', 'education_level_id', 'id');
    }
    public static function boot()
    {
        parent::boot();
        PlacementTestQuestions::observe(new \App\Observers\UserActionsObserver);
    }
}
