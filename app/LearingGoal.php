<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LearingGoal extends Model
{
    public  function goal(){
        return $this->hasMany('App\Content');


    }
    public static function boot()
    {
        parent::boot();
        LearingGoal::observe(new \App\Observers\UserActionsObserver);
    }
}
