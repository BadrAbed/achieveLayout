<?php

namespace App;

use App\Http\OwnClasses\LESSON_PLANS_ENUMS;
use Illuminate\Database\Eloquent\Model;

use \App\User;
use \App\LessonPlan;
use \App\Sortinglesson;


class StudentAssignedLessonPlan extends Model
{
    protected $table = "student_assigned_lesson_plans";



}
