<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VoiceReaderModel extends Model
{
    protected $primaryKey = "id";
    protected $table = "voice_read_along";

    protected $fillable = ["content_id","sound_id","startSeconds","sentence","duration","endSeconds"];


    public function getRowsOrders($audioId){
        return VoiceReaderModel::where("sound_id",$audioId)->orderBy("startSeconds","ASC")->get();
    }
    public function contentvoicestretch(){
        return $this->belongsTo('App\StretchArtical','sound_id','sound_id');
    }

    public function contentvoicenormal(){
        return $this->belongsTo('App\NormalArtical','sound_id','sound_id');
    }

}
