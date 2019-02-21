<?php
//print_r($vocabs);die();
?>
@extends('layouts.app')

@include("voice_sentences.partials.CSSaudioPlugin")

@section('custom-content')
    <style>
        .modal-body a:hover{
            color:#fefefe !important;
        }
    </style>


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
                    </br>
                    <section id="content3">


                        <?php

                        $answer = DB::table('questions')->where('type', 'activityquest')->where('questions.content_id', $content_id)->
                        join('answers_questions', function ($join) {
                            $join->on('questions.true_answer', '=', 'answers_questions.answer');
                            $join->on('answers_questions.question_id', '=', 'questions.id');
                        })
                            ->get()->count();
                        $questrestult = DB::table('questions')->where('content_id', $content_id)->where('type', 'activityquest')->count();

                        ?>
                        @if($questrestult==0)
                            لاتوجد اسئله
                        @endif


                        <table class="vocabulary-table">
                            <thead>
                            <tr>
                                <td>
                                    السوال
                                </td>
                                <td> الاجابه الصحيحه</td>
                            </tr>
                            </thead>
                            @foreach($answerquest as $answer)
                                <tr>
                                    <td>
                                        {{$answer->question}}</td>
                                    <td> @if($answer->true_answer=='ans1')
                                            {{$answer->ans1}}
                                        @endif
                                        @if($answer->true_answer=='ans2')
                                            {{$answer->ans2}}
                                        @endif

                                        @if($answer->true_answer=='ans3')
                                            {{$answer->ans3}}
                                        @endif

                                        @if($answer->true_answer=='ans4')
                                            {{$answer->ans4}}
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </table>

                            <br></br>
                            <button type="button" class="btn btn-info btn-block" data-toggle="modal"
                                    data-target=".bd-example-modal-lg"><i class="fa fa-desktop"></i> عرض الاسئلة
                            </button>

                            <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog"
                                 aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">

                                        @foreach($answerquest as $key => $value)
                                            <div class="modal-body">

                                                <div class="panel-group">
                                                    <div class="panel panel-success ">
                                                        <div class="panel-heading">

                                                            <h4 class="panel-title">
                                                                <a data-toggle="collapse" style="font-weight: normal !important;font-size: 14px !important;"
                                                                   href="#collapse{{$value->id}}">{{$value->question}}</a>
                                                            </h4>
                                                        </div>
                                                        <div id="collapse{{$value->id}}" class="panel-collapse collapse">
                                                            <ul class="list-group">
                                                                <li class="list-group-item">{{$value->ans1}}</li>
                                                                <li class="list-group-item">{{$value->ans2}}</li>
                                                                <li class="list-group-item">{{$value->ans3}}</li>
                                                                <li class="list-group-item">{{$value->ans4}}</li>
                                                            </ul>
                                                            @php $true_answer = "";
                                                        if ($value->true_answer == 'ans1') {
                                                            $true_answer = $value->ans1;
                                                        }

                                                        if ($value->true_answer == 'ans2')
                                                            $true_answer = $value->ans2;
                                                        if ($value->true_answer == 'ans3')
                                                            $true_answer = $value->ans3;
                                                        if ($value->true_answer == 'ans4')
                                                            $true_answer = $value->ans4;
                                                            @endphp
                                                            <p class="alert alert-info"> الإجابة الصحيحة
                                                                :{{$true_answer}} </p>

                                                        </div>
                                                    </div>
                                                </div>


                                                {{--<div class="col-md-2">--}}
                                                {{--{{ Form::label('question', 'السؤال', array('class' => 'col-form-label')) }}--}}
                                                {{--</div>--}}
                                                {{--<div class="col-md-10">--}}
                                                {{--<br></br>--}}
                                                {{--</div>--}}


                                                {{--<div class="col-md-2">--}}
                                                {{--{{ Form::label('ans1', 'الاختيار الاول', array('class' => 'col-form-label')) }}--}}
                                                {{--</div>--}}
                                                {{--<div class="col-md-10">--}}
                                                {{--{{ Form::text('questions[0][ans1]', '', array('class' => 'form-control','required' => 'required','oninvalid'=>"this.setCustomValidity('من فضلك ادخل الاجابه الاولى  ')",'oninput'=>"setCustomValidity('')")) }}--}}
                                                {{--<br></br>--}}
                                                {{--</div>--}}
                                                {{--<div class="col-md-2 ">--}}
                                                {{--{{ Form::label('ans2', 'الاختيار الثانى', array('class' => 'col-form-label')) }}--}}
                                                {{--</div>--}}
                                                {{--<div class="col-md-10">--}}
                                                {{--{{ Form::text('questions[0][ans2]', $value->ans2, array('class' => 'form-control','required' => 'required','oninvalid'=>"this.setCustomValidity('من فضلك ادخل الاجابه الثانيه  ')",'oninput'=>"setCustomValidity('')")) }}--}}
                                                {{--<br></br>--}}
                                                {{--</div>--}}


                                                {{--<div class="col-md-2">--}}
                                                {{--{{ Form::label('ans3', 'الاختيار الثالث', array('class' => 'col-form-label')) }}--}}
                                                {{--</div>--}}
                                                {{--<div class="col-md-10">--}}
                                                {{--{{ Form::text('questions[0][ans3]', $value->ans3, array('class' => 'form-control')) }}--}}
                                                {{--<br></br>--}}
                                                {{--</div>--}}
                                                {{--<div class="col-md-2">--}}

                                                {{--{{ Form::label('ans4', 'الاختيار الرابع', array('class' => 'col-form-label')) }}--}}

                                                {{--</div>--}}
                                                {{--<div class="col-md-10">--}}
                                                {{--{{ Form::text('questions[0][ans4]', $value->ans4, array('class' => 'form-control')) }}--}}
                                                {{--<br></br>--}}
                                                {{--</div>--}}

                                                {{--<div class="row form-group">--}}
                                                {{--<div class="col-md-2">--}}
                                                {{--{{ Form::label('true_answer', 'الاجابه الصحيحه', array('class' => 'col-form-label')) }}--}}
                                                {{--</div>--}}
                                                {{--<div class="col-md-4">--}}
                                                {{--{{ Form::select('questions[0][true_answer]', [--}}
                                                {{--'الاجابات' => ['ans1' => 'الاجابه الاولى','ans2' => 'الاجابه التانيه','ans3' => 'الاجابه الثالثه','ans4' => 'الاجابه الرابعه'],--}}

                                                {{--],$value->true_answer)}}--}}

                                                {{--</div>--}}

                                                {{--</div>--}}
                                            </div>



                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <br>
                        <br>
                        <br>
                        <br>
                        @include('inc.issues',['tab_num'=>App\Http\OwnClasses\STUDENT_ASSIGNED_LESSON_PLANS_ENUMS::GET_SHORT_QUESTIONS_TAB_ENUM])

                    </section>
                </div>

            </div>

        </div>
        @include('inc.admin_content_side_bar')
    </div>

@endsection




