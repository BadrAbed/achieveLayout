<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sound extends Model
{
    public  function soundonrmal(){
        return $this->hasMany('App\NormalArtical');



    }
    public  function soundstrach(){
        return $this->hasMany('App\StretchArtical');
    }

    public  function voiceReader(){
        return $this->hasMany('App\VoiceReaderModel')->orderBy('startSeconds',"ASC");
    }

    public static function boot()
    {
        parent::boot();
        Sound::observe(new \App\Observers\UserActionsObserver);
    }


}
