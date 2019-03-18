@extends('studentLayout.app') @section('content')
                                  {{--<style>--}}
                                      {{--.s_viewLesson .bottom .right .container ul.tabs li{--}}
                                          {{--max-width: 16%!important;--}}
                                          {{--min-width: 16%!important;--}}
                                      {{--}--}}
                                  {{--</style>--}}
    <?php

    $pollTrue = \App\PollResults::where('poll_ans', 1)->where('type', 'before')->where('content_id', $content->id)->get()->count();
    $pollFalse = \App\PollResults::where('poll_ans', 0)->where('type', 'before')->where('content_id', $content->id)->get()->count();

    $hasNoResults = false; //a variable to indicate that there are results for that poll or not , to control visibility of the alert message
    ?>
    {{-- ////////////////////// breadcrumb ////////////////////////////// --}}
    <div class="breadcrumb">
        <div class="row">
            <ul>
                <li>
                    <a href="{{url('studentDashboard')}}">
                        <i class="fa fa-home" aria-hidden="true"></i>
                        <span>الرئيسة</span>
                    </a>
                </li>
                <li>
                    <a href="{{url('studentLessons')}}">الدروس</a>
                </li>
                <li>
                    <a style="">{{$content->content_name}}</a>
                </li>

            </ul>
        </div>
    </div>
    {{-- ////////////////////// #breadcrumb ////////////////////////////// --}}
    <div class="s_viewLesson">
        <div class="bg"></div>
        {{-- ////////////////////// Top ////////////////////////////// --}}
        <div class="row top">
            {{-- ////////////////////// Top --- Right ////////////////////////////// --}}
            <div class="col-md-12 col-sm-12  right">
                <i class="fa fa-caret-left" aria-hidden="true"></i>
                <span>{{$content->content_name}}</span>
                <div class="" style="float:left;">
                    {!! $content->content_location !!}
                </div>
            </div>
            {{-- ////////////////////// Top --- Left ////////////////////////////// --}}
        </div>
        {{-- ////////////////////// Bottom ////////////////////////////// --}}
        <div class="row bottom">
            {{-- ////////////////////// Bottom --- Right ////////////////////////////// --}}
            <div class="col-xl-8 col-lg-12 col-md-12 right">
                <div class="container">
                    @include('studentLayout.studentTabs')
                    <section id="content_tab_1">
                        <h4 class="quest_h">
                            <i class="fa fa-caret-left" aria-hidden="true"></i>
                            {{ str_replace ("","ﷺ" , str_replace("","ﷺ" ,$content->hint)) }}

                        </h4>
                        <h5 class="quest_title">    {{ str_replace ("","ﷺ" , str_replace("","ﷺ" ,$content->poll)) }}</h5>
                        <?php $poll = \App\PollResults::where('user_id', auth()->user()->id)->where('type', 'before')->where('content_id', $content->id)->first(); ?>

                        @if($poll !=null)
                            {{----}}
                            <div  class="quest row">
                                <div class="col-md-12" style="margin-top: 1rem;">
                                    <section id="content_tab_1" style=" margin: 0; padding: 0;">

                                        <h5 class="quest_title">    </h5>

                                        <div class="selections">
                                            <div class="field">
                                                <form action="http://localhost/achieve/public/answerpoll" method="post">
                                                    <input type="hidden" name="_token" value="BYuicUzSmnacXHPkbyUPdbFrohvqlOWeLJfGJ8Pl">
                                                    <input id="input1" type="radio" name="poll_ans" value="1" @if($poll->poll_ans==1) checked @else disabled @endif >
                                                    <label for="input1">نعم</label>
                                                </form></div>
                                            <input name="content_id" value="53" type="hidden">
                                            <input name="type" value="before" type="hidden">
                                            <div class="field">
                                                <input id="input2" type="radio" name="poll_ans" value="0" @if($poll->poll_ans==0) checked @else disabled @endif >
                                                <label for="input2">لا</label>
                                            </div>
                                        </div>





                                    </section>

                                </div>
                                <div class="row" style="width: 100%;">
                                    <div class="col-md-6" style="margin-top: 2rem;">
                                        <h5 class="quest_title">
                                            <i class="fa fa-caret-left" aria-hidden="true"></i>
                                            إجابات باقي الطلاب</h5>
                                        <div>
                                            <div style="margin: 1rem 0;">
                                                <span style="display: inline-block; width: 2%; font-size: 12pt;"> نعم</span>
                                                <div id="myProgress">
                                                    <div id="myBar" style="width: {{($pollTrue/($pollTrue+$pollFalse))*100}}%">
                                                        <div class="in" style="visibility: hidden;" >{{($pollTrue/($pollTrue+$pollFalse))*100}}%</div>
                                                    </div>
                                                </div>
                                                <div class="in" style="display: inline-block; font-size: 12pt;  width: 40%; text-align: center;">{{round(($pollTrue/($pollTrue+$pollFalse))*100)}}%</div>
                                            </div>

                                            <div>
                                                <span style="display: inline-block; width: 2%; font-size: 12pt;"> لا</span>
                                                <div id="myProgress">
                                                    <div id="myBar" class="no" style="width: {{($pollFalse/($pollTrue+$pollFalse))*100}}%">
                                                        <div class="in" style="visibility: hidden;" >{{($pollFalse/($pollTrue+$pollFalse))*100}}%</div>
                                                    </div>
                                                </div>
                                                <div class="in" style="display: inline-block; font-size: 12pt; width: 40%; text-align: center;">{{round(($pollFalse/($pollTrue+$pollFalse))*100)}}%</div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="move_nxt">
                                <a href="{{url('student_next_tab_button'.'/'.$content->id.'/'.\App\Http\OwnClasses\STUDENT_ASSIGNED_LESSON_PLANS_ENUMS::GET_SHORT_SURVEY_TAB_ENUM)}}"
                                   class="btn next-tab">

                                    إلى المقال     <i class="fa fa-arrow-left"></i>
                                </a>
                            </div>
                            {{----}}
                        @else
                            <div class="selections">
                                <div class="field">
                                    <form action="{{route('answerpoll')}}" method="post">
                                        {{csrf_field()}}
                                        <input id="input1" type="radio" name="poll_ans" value="1">
                                        <label for="input1">نعم</label>
                                </div>
                                <input name="content_id" value="{{$content_id}}" type="hidden"/>
                                <input name="type" value="before" type="hidden"/>
                                <div class="field">
                                    <input id="input2" type="radio" name="poll_ans" value="0">
                                    <label for="input2">لا</label>
                                </div>
                            </div>
                            <p>لماذا قمت باختيار هذه الإجابة؟</p>
                            <div class="ui form form-group">
                                <div class="field">
                                    <textarea rows="2" name="explain" style="width: 100% !important;"></textarea>
                                </div>
                            </div>
                            <button type="submit" class="btn submit">
                                إرسال
                            </button>
                            </form>

                        @endif
                    </section>

                    {{--<a href="javascript:" id="nxt_tab" style="display: inline;">--}}
                        {{--<i class="fa fa-angle-left" aria-hidden="true"></i>--}}
                    {{--</a>--}}
                </div>
                {{-- ////////////////////// Bottom --- Right --- Links ////////////////////////////// --}}
                @include('studentLayout.sidebar')
            </div>
        </div>
@endsection