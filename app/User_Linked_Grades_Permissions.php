<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User_Linked_Grades_Permissions extends Model
{
    protected $primaryKey = "id";
    protected $table = "user_linked_grades_permissions";

    protected $fillable = ["id","user_id","educationLevel_id","guid1","guid2"];

    public function getRelatedLevel()
    {
        return $this->belongsTo('App\EducationLevel',"educationLevel_id");
    }
}
