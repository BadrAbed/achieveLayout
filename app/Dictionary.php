<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dictionary extends Model
{
    public function grade()
    {

        return $this->belongsTo('App\EducationLevel', 'education_level_id', 'id');
    }
    public function getEducationAttribute()
    {


        $education_level_cildeName=EducationLevel::find($this->education_level_id);
        $education_level_parentName=EducationLevel::find($education_level_cildeName->parent_id);

        return $education_level_parentName->name." - ".$education_level_cildeName->name;
    }


}
