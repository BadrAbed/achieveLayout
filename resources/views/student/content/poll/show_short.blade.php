@extends('studentLayout.app') @section('content')
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
                        <span>الرئيسية</span>
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
            <div class="col-md-6 right">
                <i class="fa fa-caret-left" aria-hidden="true"></i>
                <span>{{$content->content_name}}</span>
            </div>
            {{-- ////////////////////// Top --- Left ////////////////////////////// --}}
            <div class="col-md-6 left">
                <div class="desc">
                    <span>اللغة العربية :</span>
                    <span>الصف الثالث الابتداىي</span>
                </div>
                <div class="desc">
                    <span >الوحدة الثالثه :</span>
                    <span>المسلم الصغير</span>
                </div>
            </div>
        </div>
        {{-- ////////////////////// Bottom ////////////////////////////// --}}
        <div class="row bottom">
            {{-- ////////////////////// Bottom --- Right ////////////////////////////// --}}
            <div class="col-md-8 right">
                <div class="container">
                    @include('studentLayout.studentTabs')
                    <section id="content_tab_1">
                        <h4 class="quest_h">
                            <i class="fa fa-caret-left" aria-hidden="true"></i>
                            {{$content->hint}}
                        </h4>
                        <span class="quest_title">{{$content->poll}}</span>
                        <?php $poll = \App\PollResults::where('user_id', auth()->user()->id)->where('type', 'before')->where('content_id', $content->id)->first(); ?>

                        @if($poll !=null)
                            {{----}}
                            <div  class="quest">
                                <div class="col-md-6">
                                    <div>
                                        <span>الاجابة بنعم</span>
                                        <div id="myProgress">
                                            <div id="myBar" style="width: {{($pollTrue/($pollTrue+$pollFalse))*100}}%">
                                                <div class="in" >{{($pollTrue/($pollTrue+$pollFalse))*100}}%</div>
                                            </div>
                                        </div>
                                        <span>الاجابة بلا</span>
                                        <div id="myProgress">
                                            <div id="myBar" class="no" style="width: {{($pollFalse/($pollTrue+$pollFalse))*100}}%">
                                                <div class="in">{{($pollFalse/($pollTrue+$pollFalse))*100}}%</div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="move_nxt">
                                <a href="{{url('student_next_tab_button'.'/'.$content->id.'/'.\App\Http\OwnClasses\STUDENT_ASSIGNED_LESSON_PLANS_ENUMS::GET_SHORT_SURVEY_TAB_ENUM)}}"
                                   class="btn next-tab">

                                    <i class="fa fa-reply"></i>
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
                            <p>لماذا قمت باختيار هذه الاجابة؟</p>
                            <div class="ui form form-group">
                                <div class="field">
                                    <textarea rows="2" name="explain"></textarea>
                                </div>
                            </div>
                            <button type="submit" class="btn submit">
                                ارسال
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
