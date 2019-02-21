<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vocabulary extends Model
{
    public $table = "vocabulary";
    protected $fillable = [
        'word', 'meaning', 'content_id',
    ];

    public function content()
    {

        return $this->belongsTo('App\Content', 'content_id', 'id');
    }

    public static function boot()
    {
        parent::boot();
        Vocabulary::observe(new \App\Observers\UserActionsObserver);
    }
}
