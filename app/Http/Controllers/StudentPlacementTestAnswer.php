<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\StudentPlacementTestAnswers;

class StudentPlacementTestAnswer extends Controller
{
    static public function checkIfQuestionHasBeenAnsweredOrNotByStudent($question_id){

        $question_answeres =   StudentPlacementTestAnswers::where("question_id",$question_id)->get();

        if($question_answeres->count() == 0){
            return false;
        }
        else{
            return true;
        }

    }
}
