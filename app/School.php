<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class School extends Authenticatable
{

    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $guard = 'school';
    protected $fillable = [
        'name', 'email', 'password', "student_grade_id", "student_country_id"
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function Country()
    {

        return $this->belongsTo('App\Country', 'countries', 'id');
    }

    public static function boot()
    {

        parent::boot();
        School::observe(new \App\Observers\UserActionsObserver);
    }
}
