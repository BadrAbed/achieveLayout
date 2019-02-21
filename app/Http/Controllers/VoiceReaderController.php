<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use \App\Sound;

use \App\NormalArtical;

use \App\StretchArtical;

use \App\VoiceReaderModel;


class VoiceReaderController extends Controller
{

//    public function __construct()
//    {
//        $this->middleware("Permissions:content");//permissions middleware
//    }


    function startProcessingSentencesWithAudio($type, $tn, $articleID)
    {

        //type is to know create or edit , to only prepare quick links
        if ($type != "create" && $type != "edit") {//if normal article
            abort(404);
        }

        //tn is table name because we have two articles for each content
        if ($tn == "NA") {//if normal article
            $articleInstance = NormalArtical::find($articleID);
        } elseif ($tn == "SA") {//if stretched article
            $articleInstance = StretchArtical::find($articleID);
        } else {
            abort(404);
        }

        $audioPath = $articleInstance->sound->path;//get upload sound path
        $audioType = $articleInstance->sound->type; //get uploaded sound mime type
        $contentId = $articleInstance->content_id; //get main content id
        $articleText = trim(preg_replace('/ +/', ' ', urldecode(html_entity_decode(strip_tags($articleInstance->article)))));//extract content from html tags
        $audioID = $articleInstance->sound->id;


        /*if($audioDetails->isEmpty() || ($tn !=='NA' && $tn !=="SA")){//if not realsitic id or table name is not normal articles or streteched articles , return 404
            abort(404);
        }
        foreach ($audioDetails as $audio){

        }*/

        //$article = NormalArtical::find();

        //getting audio path by id


        return view("voice_sentences.audioGrid", ["audio" => \URL::asset($audioPath), "type" => $type, "tn" => $tn, "audioID" => $audioID, "audioType" => "audio/" . $audioType, "contentID" => $contentId, "articleText" => $articleText,'content_id'=>$contentId]);
    }


    function addNewSoundSentenceRow($audioId, $contentId)
    {

        $start = request()->start;
        $sentence = request()->sentence;


        VoiceReaderModel::create([
            "sound_id" => $audioId,
            "content_id" => $contentId,
            "startSeconds" => request()->start,
            "sentence" => request()->sentence
        ]);
    }


    function getAllSentencesOfSpecificAudio($audioId)
    {

        $voiceReaderModelInstance = new VoiceReaderModel();
        $data = $voiceReaderModelInstance->getRowsOrders($audioId);
        foreach ($data as $row) {

            $arr[] = array("ID" => htmlspecialchars($row->id, ENT_QUOTES), "start" => htmlspecialchars($row->startSeconds, ENT_QUOTES), "sentence" => htmlspecialchars($row->sentence, ENT_QUOTES));
        }

        return response()->json($arr);

    }


    function editSoundSentenceRow($audioId, $contentId)
    {
        $start = request()->start;
        $sentence = request()->sentence;


        VoiceReaderModel::where("sound_id", $audioId)->where("content_id", $contentId)->where("id", request()->ID)->update([
            "startSeconds" => request()->start,
            "sentence" => request()->sentence
        ]);
    }


    function deleteSoundSentenceRow($audioId, $contentId)
    {
        VoiceReaderModel::where("sound_id", $audioId)->where("content_id", $contentId)->where("id", request()->ID)->delete();
    }


    function finalizeProcessingSentencesWithAudio($type, $audioId, $tn)
    {
        //type is to know create or edit , to only prepare quick links
        if ($type != "create" && $type != "edit") {//if normal article
            abort(404);
        }

        if ($tn != "NA" && $tn != "SA") {//if not Normal article or Strech article , abort 404
            abort(404);
        }

        $audioInstance = Sound::find($audioId);
        $soundSentencesRows = $audioInstance->voiceReader;
        $audioLength = $audioInstance->length;


        foreach ($soundSentencesRows as $index => $value) {


            unset($currentID, $start, $nextStart, $end, $dur, $x);


            $currentID = $soundSentencesRows[$index]["id"];


            $start = $soundSentencesRows[$index]["startSeconds"];

            $nextStart = @$soundSentencesRows[$index + 1]["startSeconds"];


            if (is_null($nextStart)) {//if the current item is the last , then the next start is the duration of the sound file

                $nextStart = $audioLength;
            }


            $end = $nextStart;

            $dur = $end - $start;


            VoiceReaderModel::where("id", $currentID)->where("sound_id", $audioId)->update(["endSeconds" => $end, "duration" => $dur, "status" => 1]);//update duration and end for each eloquent model instance match the conditoons


        }

        return redirect("voiceSentences/listen/$type/$audioId/$tn");


    }


    function listen($type, $audioId, $tn)
    {
        //type is to know create or edit , to only prepare quick links
        if ($type != "create" && $type != "edit") {//if normal article
            abort(404);
        }
        $audioDetails = Sound::find($audioId);
        $audioPath = $audioDetails->path;
        $audioType = $audioDetails->type;
        $voiceReaderModelInstance = new VoiceReaderModel();
        $soundRecordedSentencesWithVoices = $voiceReaderModelInstance->getRowsOrders($audioId)->toArray();//get rows of specific audio by specifc order and convert to array
        $contentId = $audioDetails->content_id;


        return view("voice_sentences.listen", ["type" => $type, "audioPath" => \URL::asset($audioPath), "audioType" => "audio/" . $audioType, "sentencesRows" => $soundRecordedSentencesWithVoices, "tn" => $tn, "contentId" => $contentId]);
    }
}
