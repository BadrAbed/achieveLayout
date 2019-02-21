<?php

namespace App;

use App\Observers\UserActionsObserver;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    public $table = "country";
    protected $fillable = [
        'name', 'value'
    ];

    public function Content()
    {
        return $this->hasMany('App\Content');

    }

    public function Lesson()
    {
        return $this->hasMany('App\LessonPlan');


    }

    public static function boot()
    {
        parent::boot();

        Country::observe(UserActionsObserver::class);
    }
}
