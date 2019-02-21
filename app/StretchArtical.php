<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StretchArtical extends Model
{
    public  function sound(){

        return $this->belongsTo('App\Sound', 'sound_id', 'id');
    }
    public  function content(){

        return $this->belongsTo('App\Content', 'content_id', 'id');
    }
    public function strachvoicereader()
    {
        return $this->hasMany('App\VoiceReaderModel');

    }
    public static function boot()
    {
        parent::boot();
        StretchArtical::observe(new \App\Observers\UserActionsObserver);
    }
}
