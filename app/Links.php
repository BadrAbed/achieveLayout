<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Links extends Model
{
    public  function links(){

        return $this->belongsTo('App\Content', 'content_id', 'id');
    }
    public static function boot()
    {
        parent::boot();
        Links::observe(new \App\Observers\UserActionsObserver);
    }
}
