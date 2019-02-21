<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EducationLevel extends Model
{
    public $table = "education_levels";
    protected $fillable = [
        'name'
    ];


    public function Content()
    {
        return $this->hasMany('App\Content');
        
    }

    public function lessonplan()
    {
        return $this->hasMany('App\LessonPlan');

    }

    public function parent()
    {
        return $this->belongsToOne(static::class, 'parent_id');
    }

    //each category might have multiple children
    public function children()
    {
        return $this->hasMany(static::class, 'parent_id')->orderBy('name', 'asc');
    }
    public static function boot()
    {
        parent::boot();
        EducationLevel::observe(new \App\Observers\UserActionsObserver);
    }
}
