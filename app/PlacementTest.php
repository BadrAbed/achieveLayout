<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlacementTest extends Model
{
    protected $table='placement_tests';


    public function Country()
    {

        return $this->belongsTo('App\Country', 'country', 'id');
    }

    public function grade()
    {

        return $this->belongsTo('App\EducationLevel', 'parent_education_level', 'id');
    }

    public function user()
    {

        return $this->belongsTo('App\User', 'user_id', 'id');
    }
    public static function boot()
    {
        parent::boot();
        PlacementTest::observe(new \App\Observers\UserActionsObserver);
    }
}
