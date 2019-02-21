<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer_Questions extends Model
{
    protected $table = "answers_questions";
    protected $primaryKey = "id";
    protected $guarded = [];
    public function type()
    {
        return $this->belongsTo('App\Question', 'question_id', 'id');

    }

}
