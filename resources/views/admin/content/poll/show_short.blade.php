<?php

$pollTrue = \App\PollResults::where('poll_ans', 1)->where('type', 'before')->where('content_id', $content->id)->get()->count();
$pollFalse = \App\PollResults::where('poll_ans', 0)->where('type', 'before')->where('content_id', $content->id)->get()->count();

$hasNoResults = false; //a variable to indicate that there are results for that poll or not , to control visibility of the alert message
if ($pollTrue+$pollFalse==0){
    $hasNoResults=true;
}
?>


@extends('layouts.app')

@include("voice_sentences.partials.CSSaudioPlugin")

@section('custom-content')


    <link rel="stylesheet" href="{{asset("/css/components/mark_as_completed.css")}}">




    <div class="container">
        <br>
        <!--paneeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeel-->
        <div class="panel panel-green">
            <div class="panel-heading">

                <div class="">

                    <p class="h3">
                        {{$content->content_name}}
                    </p>
                </div>
            </div>
        </div>
        <!--paneeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeel-->


    </div>
    <div class="container">
        <div class="col-sm-8">
            <div class="row">
                <div class="tab-container">
                    <div class="main-taps">

                        @include('inc.content_navbar')
                    </div>


                    <section id="content1" style="padding-top: 40px;">


                        {{--                                <p class="tabcontent">{{$content->poll}}</p>--}}
                        <small>{{$content->hint}}</small>
                        </br>
                        <span class="h4">{{$content->poll}}</span>


                        <br><br>

                        <div id="canvas-holder" style="width:100%">
                            @if($hasNoResults)
                                <div class="alert alert-danger">لا يوجد اجابات لهذا السؤال قبلى</div>
                                @else
                                <div class="row">
                                    <div class="col-md-6">
                                        الاجابة بنعم
                                        <div class="progress3">

                                            <div class="progress-bar-success" role="progressbar" aria-valuenow="70"
                                                 aria-valuemin="0" aria-valuemax="100" style="width:{{($pollTrue/($pollTrue+$pollFalse))*100}}%">
                                                {{($pollTrue/($pollTrue+$pollFalse))*100}}%
                                            </div>
                                        </div>
                                        الاجابة بلا
                                        <div class="progress3">
                                            <div class="progress-bar-danger" role="progressbar" aria-valuenow="70"
                                                 aria-valuemin="0" aria-valuemax="100" style="width:{{($pollFalse/($pollTrue+$pollFalse))*100}}%">
                                                {{($pollFalse/($pollTrue+$pollFalse))*100}}%
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            @endif


                        </div>

                        @include('inc.issues',['tab_num'=>App\Http\OwnClasses\STUDENT_ASSIGNED_LESSON_PLANS_ENUMS::GET_SHORT_SURVEY_TAB_ENUM])
                    </section>
                </div>

            </div>

        </div>
        @include('inc.admin_content_side_bar')
    </div>

@endsection

