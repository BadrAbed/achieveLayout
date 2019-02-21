<?php

namespace App;

use GuzzleHttp\Psr7\Request;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

use \App\User_Linked_Countries_Permissions;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'name', 'email', 'password', "student_grade_id", "student_country_id","school_id"
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getGradeAttribute()
    {
        if ($this->student_grade_id) {
            $parent = EducationLevel::find($this->student_grade_id)->parent_id;

            if ($parent != null) {


                return EducationLevel::find($parent)->name . '-' . EducationLevel::find($this->student_grade_id)->name;
            }

            return EducationLevel::find($this->student_grade_id)->name;
        }
        return null;
    }

    public function getUserLinkedCountries()
    {
        return $this->hasMany("\App\User_Linked_Countries_Permissions", "user_id");
    }

    public function Lesson()
    {
        return $this->hasMany('App\LessonPlan');


    }

    public function content()
    {

        return $this->hasMany('App\Content');
    }

    public function logtime()
    {

        return $this->hasMany('App\LogTime');
    }

    public function grade()
    {

        return $this->belongsTo('App\EducationLevel', 'student_grade_id', 'id');
    }

    public function Country()
    {

        return $this->belongsTo('App\Country', 'student_country_id', 'id');
    }

    public static function boot()
    {


            parent::boot();
            User::observe(new \App\Observers\UserActionsObserver);

    }
}
