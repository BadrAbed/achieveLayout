<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlacementTestQuestionAnswers extends Model
{
    protected $table = "placement_test_question_answers";


    public function placementQuestion()
    {
        return $this->belongsTo('App\PlacementTestQuestions', 'question_id', 'id');

    }
}
