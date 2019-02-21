<?php
//print_r($vocabs);die();
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
                </div>
            </div>

        </div>
        <div class="col-sm-4">
            <div class="row">
                <div class="vocabulary-col">
                    <div class="vocabulary-title">
                        <header class="vocabulary-t">
                            <p>مترادفات</p>
                            <h3>معاني المفردات</h3>
                        </header>
                    </div>
                    <div class="vocabulary">
                        <table class="vocabulary-table">
                            @foreach($vocabs as $vocab)
                                <tr>
                                    <td class="v-txt-style">{{$vocab->word}}</td>
                                    <td>{{$vocab->meaning}}</td>
                                </tr>
                            @endforeach
                        </table>
                    </div>

                    <!--<div class="vocabulary-end"></div>-->
                </div>

                <div class="vocabulary-col">
                    <div class="vocabulary-title">
                        <header class="vocabulary-t">
                            <p>الوابط الاثرائيه</p>
                            <h3></h3>
                        </header>
                    </div>
                    <div class="vocabulary">

                        @if(count($content->links)>0)

                            @foreach($content->links as $links)


                                <a target="_blank" href="{{$links->href}}"> {{$links->link}}</a>
                                <br></br>
                            @endforeach
                        @endif
                    </div>
                </div>

                <div class="vocabulary-col">
                    <div class="vocabulary-title">
                        <header class="vocabulary-t">
                            <p>نتائج الاختبارات </p>

                        </header>
                    </div>


                    <div class="vocabulary">
                        <table class="vocabulary-table">

                            <tr>

                                <?php

                                $answer = DB::table('questions')->where('type', 'activityquest')->where('questions.content_id', $content_id)->
                                join('answers_questions', function ($join) {
                                    $join->on('questions.true_answer', '=', 'answers_questions.answer');
                                    $join->on('answers_questions.question_id', '=', 'questions.id');
                                })
                                    ->get()->count();
                                $questrestult = DB::table('questions')->where('content_id', $content_id)->where('type', 'activityquest')->count();
                                $answeraddation = DB::table('questions')->where('type', 'addationquest')->where('questions.content_id', $content_id)->
                                join('answers_questions', function ($join) {
                                    $join->on('questions.true_answer', '=', 'answers_questions.answer');
                                    $join->on('answers_questions.question_id', '=', 'questions.id');
                                })
                                    ->get()->count();
                                $questrestultaddation = DB::table('questions')->where('content_id', $content_id)->where('type', 'addationquest')->count();
                                ?>

                                <?php if (empty($quests)): ?>
                                <td class="v-txt-style"> الانشطه</td>
                                @if($questrestult==0)
                                    <td> لاتوجد اسئله</td>
                                @endif
                                @if($questrestult!=0)
                                    <td> لقد احرزت {{$answer}} من {{$questrestult}}</td>
                                @endif
                            </tr>
                            <?php endif; ?>
                            <?php if (empty($addationquest)): ?>
                            <tr>
                                <td class="v-txt-style"> الاضافيه</td>
                                @if($questrestultaddation==0)
                                    <td> لاتوجد اسئله</td>
                                @endif
                                @if($questrestultaddation!=0)

                                    <td> لقد احرزت {{$answeraddation}} من {{$questrestultaddation}}  </td>
                                @endif
                            </tr>
                            <?php endif; ?>
                        </table>
                    </div>

                    <!--<div class="vocabulary-end"></div>-->
                </div>
            </div>
        </div>
    </div>

    @endsection


