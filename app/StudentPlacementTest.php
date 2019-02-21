<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudentPlacementTest extends Model
{
    protected $table = "student_placement_test";

    public function level()
    {


        return $this->hasMany("\App\EducationLevel", "id", 'level_id');

    }
}
