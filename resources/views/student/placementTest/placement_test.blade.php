<style>
    #header ul#menu {
        margin: 1rem 0 !important;
        display: inline-block !important;
        text-align: left;
        position: absolute;
        left: 23rem;
    }

    .test_level {
        display: block;
        margin: 6rem auto;
        width: 50%;
        font-family: Cairo-Bold, WinSoftPro-Medium, AdobeInvisFont;
    }

    .test_level .title {
        display: block;
        margin-bottom: 1rem;
        padding: 1rem 0.5rem;
        direction: rtl;
        font-family: Cairo-Bold, WinSoftPro-Medium, AdobeInvisFont;
    }

    .test_level .title h3 {
        display: inline-block;
        font-family: Cairo-Bold, WinSoftPro-Medium, AdobeInvisFont;

    }

    .test_level .title h3:last-child {
        text-align: left;
        float: left;
    }

    .test_level div.num {
        display: block;
        margin-bottom: 1rem;
        text-align: right;
        direction: rtl;
        float: none;
    }

    .test_level div.num h5 {
        background: #7fbb50;
        padding: 1rem;
        color: #fff;
        text-align: center;
        display: block;
        width: 5%;
    }

    .test_level .content {
        background-color: #e9ecef;
        padding: 1rem 1rem;
    }

    .test_level .content .p {
        margin: 1rem 0;
        line-height: 2rem;
        font-family: 'Amiri', serif;
        FONT-SIZE: 13PT;
    }

    #return-to-top {
        display: none !important;
    }

    button.lesson {
        color: rgba(255, 255, 255, 255);
        background: #7fbb50;
        border: 1px solid #7fbb50;
        padding: 0.2rem 4rem;
        margin-left: 1rem;
        float: left;
        text-align: left;
        margin: auto;
        width: 100%;
        display: block;
    }

    .test_level [type="radio"]:checked + label,
    .test_level [type="radio"]:not(:checked) + label {
        position: relative;
        padding-right: 28px;
        cursor: pointer;
        line-height: 20px;
        display: inline-block;
        color: #1b617f;
        margin: 1rem 0;
        font-family: 'Amiri', serif;
        font-size: 14pt;
    }

    .test_level [type="radio"]:checked,
    .test_level [type="radio"]:not(:checked) {
        position: absolute;
        right: -9999px;
    }

    .selections div {
        display: block;
    }

    .test_level [type="radio"]:checked + label:before,
    .test_level [type="radio"]:not(:checked) + label:before {
        content: '';
        position: absolute;
        right: 0;
        top: 0;
        width: 18px;
        height: 18px;
        border: 2px solid #80ba4c;
        border-radius: 0;
        background: #fff;
    }

    .test_level [type="radio"]:checked + label:after,
    .test_level [type="radio"]:not(:checked) + label:after {
        content: '';
        width: 10px;
        height: 10px;
        background: #80ba4c;
        position: absolute;
        top: 4px;
        right: 4px;
        border-radius: 100%;
        -webkit-transition: all 0.2s ease;
        transition: all 0.2s ease;
    }

    .test_level [type="radio"]:not(:checked) + label:after {
        opacity: 0;
        -webkit-transform: scale(0);
        transform: scale(0);
    }

    div.btn {
        display: block;
        text-align: left;
    }
    div.btn a,
    div.btn button {
        display: inline-block;
        color: #fff !important;
        background: #7fbb50;
        border: 1px solid #7fbb50;
        padding: 1rem;
        border-radius: 0;
    }

    div.btn a:hover {
        color: #fff;
        background: #7fbb50;
        border: 1px solid #7fbb50;
    }
    form{
        height: 1000px;
    }
</style>
@extends('studentLayout.app')
<link href="https://fonts.googleapis.com/css?family=Mirza" rel="stylesheet">

<?php $totalQuestions = \App\PlacementTestQuestions::where('exam_id', $exam_id)->get() ?>
<?php $totalUserAnswers = \App\StudentPlacementTestAnswers::where(['exam_id' => $exam_id, 'user_id' => auth()->id()])->get() ?>
@section('content')

    <div class="test_level">
        @foreach($placement_test as $placement)
            <?php $index = 1 ?>
            <?php $i = 1 ?>
        <form action="{{url('Student/AnswerPlacementTest/'.$placement->exam_id).'/'.$placement->id}}"
              method="post">
            @csrf
            <div class="title">
                <h3>اختبار قياس مستوى</h3>
                <h3> الأسئلة {{ $totalQuestions->count() }}/{{$totalUserAnswers->count()+1}}</h3>
            </div>


            <div class="content">
                @if(session('message'))
                    <div class="alert-info">{{session('message')}} </div>
                @endif


                    <div class="num">
                        <h5>{{$totalUserAnswers->count()+1}}</h5>
                    </div>
                    <div class="p">
                        {!!$placement->question!!} </div>
            </div>
            <div class="selections">
                @foreach($placement->placementQuestionAnswers as $placementQuestionAnswers)

                    <div class="field">


                            <input  type="radio" id="{{$placementQuestionAnswers->id}}" name="ans" value="{{$placementQuestionAnswers->id}}">
                            <label for="{{$placementQuestionAnswers->id}}">{{$placementQuestionAnswers->answer}}</label>

                    </div>
                    <input name="content_id" value="254" type="hidden">
                    <input name="type" value="before" type="hidden">
                @endforeach
            </div>

            @endforeach
            <div class="btn">
                <a class="btn" href="{{url('logout')}}" >
                    تسجيل الخروج
                </a>
                <button class="btn" type="submit">
                    <i class="fa fa-arrow-left"></i>
                    التالي
                </button>
            </div>

        </form>
    </div>
@endsection


