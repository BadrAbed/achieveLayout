<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LessonPlan extends Model
{
    protected $grade_id;

    public function getGuid1Attribute()
    {

        $parent = EducationLevel::find($this->grade_id)->parent_id;
        if ($parent!=null) {
            return EducationLevel::find($parent)->name . '-' . EducationLevel::find($this->grade_id)->name;
        }

        return null;
    }

    public function getGradeIdAttribute($value)
    {

        $this->grade_id = $value;
        return $value;
    }

    public function Country()
    {

        return $this->belongsTo('App\Country', 'country_id', 'id');
    }

    public function grade()
    {

        return $this->belongsTo('App\EducationLevel', 'grade_id', 'id');
    }

    public function user()
    {

        return $this->belongsTo('App\User', 'user_id', 'id');
    }
    public static function boot()
    {
        parent::boot();
        LessonPlan::observe(new \App\Observers\UserActionsObserver);
    }
}
