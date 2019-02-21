<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    public static function boot()
    {
        parent::boot();
        Question::observe(new \App\Observers\UserActionsObserver);
    }
}
