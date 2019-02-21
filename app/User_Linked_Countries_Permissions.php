<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User_Linked_Countries_Permissions extends Model
{
    protected $primaryKey = "id";
    protected $table = "user_linked_countries_permissions";

    protected $fillable = ["id","user_id","country_id","guid1","guid2"];

    public function getRelatedCountry()
    {
        return $this->belongsTo('App\Country',"country_id");
    }

}
