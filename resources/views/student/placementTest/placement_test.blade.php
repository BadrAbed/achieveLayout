@extends('layouts.app')
<link href="https://fonts.googleapis.com/css?family=Mirza" rel="stylesheet">
<style>


    /*----------quiz.css---------------*/

    .question {
        background: #f1f1f1;
        padding: 20px;
        color: #000;
        border-bottom-right-radius: 55px;
        border-top-left-radius: 55px;


    }

    #qid {
        margin-right: 0px;
        background-color: #5cb85c;
        color: #ffffff;
    }

    .container ul.quizz {
        list-style: none;
        margin: 0;
        padding: 0;
    }

    ul.quizz li {
        color: #AAAAAA;
        display: block;
        position: relative;
        float: left;
        width: 100%;
        height: 50px;

    }

    ul.quizz li input[type=radio] {
        position: absolute;
        visibility: hidden;
    }

    ul.quizz li label {
        display: block;
        position: relative;
        font-weight: 100;

        padding: 25px 25px 25px 80px;
        margin: 10px auto;
        height: 30px;
        z-index: 9;
        cursor: pointer;
        -webkit-transition: all 0.25s linear;
    }

    ul.quizz li:hover label {
        color: #000

    }

    ul.quizz li .check {
        display: block;
        position: absolute;
        border: 5px solid #AAAAAA;
        border-radius: 100%;
        height: 30px;
        width: 30px;
        top: 30px;
        left: 20px;
        z-index: 5;
        transition: border .25s linear;
        -webkit-transition: border .25s linear;
    }

    ul.quizz li:hover .check {
        border: 5px solid #40BC03;
    }

    ul.quizz li .check::before {
        display: block;
        position: absolute;
        content: '';
        border-radius: 100%;
        height: 14px;
        width: 14px;
        top: 3px;
        left: 3px;
        margin: auto;
        transition: background 0.25s linear;
        -webkit-transition: background 0.25s linear;
    }

    input[type=radio]:checked ~ .check {
        border: 5px solid #40BC03;
    }

    input[type=radio]:checked ~ .check::before {
        background: #40BC03;
    }

    input[type=radio]:checked ~ label {
        color: #000000;
    }

    /*----------riple bubble-----------------*/
    ul.quizz {
        margin: 0 auto;
    }

    /*.ink styles - the elements which will create the ripple effect. The size and position of these elements will be set by the JS code. Initially these elements will be scaled down to 0% and later animated to large fading circles on user click.*/
    .ink {
        display: inline;
        position: absolute;
        background: #75ba48;
        border-radius: 100%;
        transform: scale(0);
    }

    /*animation effect*/
    .ink.animate {
        animation: ripple 0.65s linear;
    }

    @keyframes ripple {
        /*scale the element to 250% to safely cover the entire link and fade it out*/
        100% {
            opacity: 0;
            transform: scale(2.5);
        }
    }


</style>
<?php $totalQuestions = \App\PlacementTestQuestions::where('exam_id', $exam_id)->get() ?>
<?php $totalUserAnswers = \App\StudentPlacementTestAnswers::where(['exam_id' => $exam_id, 'user_id' => auth()->id()])->get() ?>
@section('content')
    <div class="col-md-12">
        <!--paneeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeel-->


        <br>
        <h2>إختبار قياس مستوي</h2>

        <div class="row"><br><br>
            <div class="col-md-12  ">

                @if(session('message'))
                    <div class="alert-info">{{session('message')}} </div>
                @endif
                <div id="quiz">


                    @foreach($placement_test as $placement)
                        <?php $index = 1 ?>
                        <?php $i = 1 ?>
                        <form action="{{url('Student/AnswerPlacementTest/'.$placement->exam_id).'/'.$placement->id}}"
                              method="post">
                            {{csrf_field()}}
                            <div class="question editor_content">
                                <h3><span class="label label-warning" id="qid">{{$totalUserAnswers->count()+1}}</span>
                                </h3>
                                <p>

                            <span id="question">   {!!$placement->question!!}
                                                </span>
                                </p>
                            </div>

                            <ul class="quizz editor_content">

                                @foreach($placement->placementQuestionAnswers as $placementQuestionAnswers)

                                    <li>
                                        <input type="radio" id="{{$placementQuestionAnswers->id}}" name="ans"
                                               value="{{$placementQuestionAnswers->id}}">
                                        <label for="{{$placementQuestionAnswers->id}}"
                                               class="element-animation">{{$i++}} <i
                                                    class="	fa fa-minus"></i> {{$placementQuestionAnswers->answer}}
                                        </label>
                                        <div class="check"></div>
                                    </li>

                                @endforeach
                            </ul>

                </div>


            </div>


        </div>


        <br><br>

        <button type="submit" class="btn btn-lg btn-block btn-success"><i class="	fa fa-share"></i> التالى</button>
        <!-- <a href="#" class="btn btn-lg btn-block btn-primary"><i class="	fa fa-reply"></i> السؤال السابق</a> -->
        <!-- <a href="#" class="btn btn-lg btn-danger"><i class="fa fa-reply"></i> تسجيل الخروج </a> -->

        <!--paneeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeel-->
        </form>
        @endforeach
        @include('inc.errorMessages')
    </div>



    <h3> الاسئلة {{ $totalQuestions->count() }}/{{$totalUserAnswers->count()+1}}</h3>
@endsection


