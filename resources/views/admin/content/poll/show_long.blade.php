<?php
//print_r($vocabs);die();
?>
@extends('layouts.app')

@include("voice_sentences.partials.CSSaudioPlugin")
<?php
$pollTrueBefore = \App\PollResults::where('poll_ans', 1)->where('type', 'before')->where('content_id', $content->id)->get()->count();
$pollFalseBefore = \App\PollResults::where('poll_ans', 0)->where('type', 'before')->where('content_id', $content->id)->get()->count();
$pollTrueAfter = \App\PollResults::where('poll_ans', 1)->where('type', 'after')->where('content_id', $content->id)->get()->count();
$pollFalseAfter = \App\PollResults::where('poll_ans', 0)->where('type', 'after')->where('content_id', $content->id)->get()->count();

$hasNoResults = false; //a variable to indicate that there are results for that poll or not , to control visibility of the alert message
if ($pollTrueAfter + $pollFalseAfter == 0 ||$pollTrueBefore+$pollFalseBefore==0) {
    $hasNoResults = true;
}
?>


@section('custom-content')







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


                    <section id="content4" style="padding-top: 20px;">

                        <br> <span class="h4"> {{$content->poll}}</span>


                        <br><br>
                        <hr>
                        <div id="canvas-holder" style="width:100%">
                            @if($hasNoResults)
                                <div class="alert alert-danger">لا يوجد اجابات لهذا السؤال البعدى</div>
                            @else

                                <div class="row">
                                    <div class="col-md-6">
                                        <h3>نتيجة السؤال البعدي</h3>
                                        الاجابة بنعم
                                        <div class="progress3">

                                            <div class="progress-bar-success" role="progressbar" aria-valuenow="70"
                                                 aria-valuemin="0" aria-valuemax="100"
                                                 style="width:{{($pollTrueAfter/($pollTrueAfter+$pollFalseAfter))*100}}%">
                                                {{($pollTrueAfter/($pollTrueAfter+$pollFalseAfter))*100}}%
                                            </div>

                                        </div>
                                        الاجابة بلا
                                        <div class="progress3">
                                            <div class="progress-bar-danger" role="progressbar" aria-valuenow="70"
                                                 aria-valuemin="0" aria-valuemax="100"
                                                 style="width:{{($pollFalseAfter/($pollTrueAfter+$pollFalseAfter))*100}}%">
                                                {{($pollFalseAfter/($pollTrueAfter+$pollFalseAfter))*100}}%
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <h3>نتيجة السؤال القبلي</h3>
                                        الاجابة بنعم
                                        <div class="progress3">

                                            <div class="progress-bar-success" role="progressbar" aria-valuenow="70"
                                                 aria-valuemin="0" aria-valuemax="100"
                                                 style="width:{{($pollTrueBefore/($pollTrueBefore+$pollFalseBefore))*100}}%">
                                                {{($pollTrueBefore/($pollTrueBefore+$pollFalseBefore))*100}}%
                                            </div>

                                        </div>
                                        الاجابة بلا
                                        <div class="progress3">
                                            <div class="progress-bar-danger" role="progressbar" aria-valuenow="70"
                                                 aria-valuemin="0" aria-valuemax="100"
                                                 style="width:{{($pollFalseBefore/($pollTrueBefore+$pollFalseBefore))*100}}%">
                                                {{($pollFalseBefore/($pollTrueBefore+$pollFalseBefore))*100}}%
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{--<div class="row">--}}
                                {{--<div class="alert" style="padding: 20px;--}}
                                {{--/* border: 1px solid #000; */--}}
                                {{--background-color: #f6f6f6;--}}
                                {{--box-shadow: 1px 2px #00000030;">--}}
                                {{--<span style="font-weight: bold;font-size: 20px;color:green;">10%</span>--}}
                                {{--تغيير في الرأي --}}
                                {{--</div>--}}
                                {{--</div>--}}



                                <hr>

                                <?php

                                //                                $percentageTrueChange =  abs($pollTrueBefore->count()-$pollTrueAfter->count())/($pollTrueBefore->count()+$pollFalseBefore->count())*100;
                                //                                $percentageFalseChange = abs($pollFalseBefore->count()-$pollFalseAfter->count())/($pollFalseBefore->count()+ $pollFalseBefore->count())*100;

                                ?>
                                {{--<canvas id="chart-area2"></canvas>--}}
                                {{--<center> <div style="padding-top: 20px" ><p class="label label-lg label-danger" style="padding: 7px !important;font-size: 85%;">%{{$percentageTrueChange}} قاموا بتغير الأراء من لا إلي نعم</p>--}}
                                {{--<p class="label label-lg label-success" style="padding: 7px !important;font-size: 85%;">{{$percentageFalseChange}}%  قاموا بتغير الأراء من نعم إلي لا</p></div></center>--}}
                            @endif
                        </div>
                        <br>
                        <br>
                        <br>
                        @include('inc.issues',['tab_num'=>App\Http\OwnClasses\STUDENT_ASSIGNED_LESSON_PLANS_ENUMS::GET_LONG_SURVEY_TAB_ENUM])
                    </section>
                </div>
            </div>


        </div>
        @include('inc.admin_content_side_bar')
    </div>

@endsection


