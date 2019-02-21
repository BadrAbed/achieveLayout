<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudentLessonPlanProgress extends Model
{
    public  function content(){

        return $this->belongsTo('App\Content', 'content_id', 'id');
    }
}
