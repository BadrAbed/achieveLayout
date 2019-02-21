@extends('studentLayout.app') @section('content')
    <?php

    $pollTrue = \App\PollResults::where('poll_ans', 1)->where('type', 'before')->where('content_id', $content->id)->get()->count();
    $pollFalse = \App\PollResults::where('poll_ans', 0)->where('type', 'before')->where('content_id', $content->id)->get()->count();

    $hasNoResults = false; //a variable to indicate that there are results for that poll or not , to control visibility of the alert message
    ?>
    <div class="s_viewLesson">
        {{-- ////////////////////// Top ////////////////////////////// --}}
        <div class="row top">
            {{-- ////////////////////// Top --- Right ////////////////////////////// --}}
            <div class="col-md-6 right">
                <i class="fa fa-caret-left" aria-hidden="true"></i>
                <span>البحرين</span>
            </div>
            {{-- ////////////////////// Top --- Left ////////////////////////////// --}}
            <div class="col-md-6 left">
                <a href="" class="lesson"> عرض كل الدروس</a>
                <a href="" class="lesson"> عرض الدرس</a>
            </div>
        </div>
        {{-- ////////////////////// Bottom ////////////////////////////// --}}
        <div class="row bottom">
            {{-- ////////////////////// Bottom --- Right ////////////////////////////// --}}
            <div class="col-md-8 right">
                <div class="container">
                    @include('studentLayout.studentTabs')





                    <section id="content1" style="padding-top: 40px;">
                        <h4 style="font-weight: normal !important;">  <i class="fas fa-caret-left"></i> {{$content->hint}}</h4>
                        <span class="h4">{{$content->poll}}</span>
                        <?php $poll = \App\PollResults::where('user_id', auth()->user()->id)->where('type', 'before')->where('content_id', $content->id)->first(); ?>

                        @if($poll !=null)
                            <br><br>

                            <div id="canvas-holder" style="width:100%">
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
                            </div>


                            <a href="{{url('student_next_tab_button'.'/'.$content->id.'/'.\App\Http\OwnClasses\STUDENT_ASSIGNED_LESSON_PLANS_ENUMS::GET_SHORT_SURVEY_TAB_ENUM)}}"
                               class="btn btn-success">التالي <i class="fa fa-reply"></i> </a>


                        @else






                            <div class="selections">
                                <div class="field">

                                    <form action="{{route('answerpoll')}}" method="post">
                                        {{csrf_field()}}

                                        <input type="radio" name="poll_ans" value="1">
                                        <label>نعم</label>

                                </div>
                                <input name="content_id" value="{{$content_id}}" type="hidden"/>
                                <input name="type" value="before" type="hidden"/>
                                <div class="field">

                                    <input type="radio" name="poll_ans" value="0">
                                    <label>لا</label>

                                </div>
                            </div>
                            <p>لماذا قمت باختيار هذه الاجابة؟</p>
                            <div class="ui form form-group">
                                <div class="field">
                                    <textarea rows="2" name="explain"></textarea>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-dark">
                                ارسال
                            </button>
                            </form>

                        @endif
                    </section>



                    <a href="javascript:" id="nxt_tab" style="display: inline;">
                        <i class="fa fa-angle-left" aria-hidden="true"></i>
                    </a>
                </div>
                {{-- ////////////////////// Bottom --- Right --- Links ////////////////////////////// --}}
                @include('studentLayout.sidebar')
            </div>
        </div>
@endsection
