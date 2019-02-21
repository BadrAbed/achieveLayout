<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContentLearningGoal extends Model
{
    public static function boot()
    {

        parent::boot();
        ContentLearningGoal::observe(new \App\Observers\UserActionsObserver());
    }
}
