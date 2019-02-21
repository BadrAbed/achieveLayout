<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Issues extends Model
{
    public function user()
    {

        return $this->belongsTo('App\User', 'user_id', 'id');
    }

    public function content()
    {

        return $this->belongsTo('App\Content', 'content_id', 'id');
    }
    public static function boot()
    {
        parent::boot();
        Issues::observe(new \App\Observers\UserActionsObserver);
    }
}
