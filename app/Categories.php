<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    public  function catg(){
        return $this->hasMany('App\Content');

    }

    //each category might have one parent
    public function parent() {
        return $this->belongsToOne(static::class, 'parent_id');
    }

    //each category might have multiple children
    public function children() {
        return $this->hasMany(static::class, 'parent_id')->orderBy('name', 'asc');
    }
    public static function boot()
    {
        parent::boot();
        Categories::observe(new \App\Observers\UserActionsObserver);
    }
}
