@extends('studentLayout.app') @section('content')
    <?php
    $pollTrueBefore = \App\PollResults::where('poll_ans', 1)->where('type', 'before')->where('content_id', $content->id)->get()->count();
    $pollFalseBefore = \App\PollResults::where('poll_ans', 0)->where('type', 'before')->where('content_id', $content->id)->get()->count();
    $pollTrueAfter = \App\PollResults::where('poll_ans', 1)->where('type', 'after')->where('content_id', $content->id)->get()->count();
    $pollFalseAfter = \App\PollResults::where('poll_ans', 0)->where('type', 'after')->where('content_id', $content->id)->get()->count();

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
            </div>
        </div>
        {{-- ////////////////////// Bottom ////////////////////////////// --}}
        <div class="row bottom">
            {{-- ////////////////////// Bottom --- Right ////////////////////////////// --}}
            <div class="col-md-8 right">
                <div class="container">
                    @include('studentLayout.studentTabs')





                    <section id="content_tab_4">

                        <?php $poll = \App\PollResults::where('user_id', auth()->user()->id)->where('type', 'after')->where('content_id', $content->id)->first(); ?>
                        @if($poll !=null)

                            <span class="quest_h">
                                <i class="fa fa-caret-left" aria-hidden="true"></i>
                                {{$content->poll}}
                            </span>

                            <div id="canvas-holder">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h3>نتيجة السؤال البعدي</h3>
                                        <div class="quest">
                                            <div>
                                                <div class="first">
                                                    <span>الاجابة بنعم</span>
                                                    <div id="myProgress">
                                                        <div id="myBar" style="width: {{($pollTrueAfter/($pollTrueAfter+$pollFalseAfter))*100}}%">
                                                            <div class="in">{{($pollTrueAfter/($pollTrueAfter+$pollFalseAfter))*100}}%</div>
                                                        </div>
                                                    </div>
                                                    <span>الاجابة بلا</span>
                                                    <div id="myProgress">
                                                        <div id="myBar" class="no" style="width: {{($pollFalseAfter/($pollTrueAfter+$pollFalseAfter))*100}}%">
                                                            <div class="in">{{($pollFalseAfter/($pollTrueAfter+$pollFalseAfter))*100}}%</div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <h3>نتيجة السؤال القبلي</h3>
                                        <div class="quest">
                                            <div>
                                                <div class="first">
                                                    <span>الاجابة بنعم</span>
                                                    <div id="myProgress">
                                                        <div id="myBar" style="width: {{($pollTrueBefore/($pollTrueBefore+$pollFalseBefore))*100}}%">
                                                            <div class="in">{{($pollTrueBefore/($pollTrueBefore+$pollFalseBefore))*100}}%</div>
                                                        </div>
                                                    </div>
                                                    <span>الاجابة بلا</span>
                                                    <div id="myProgress">
                                                        <div id="myBar" class="no" style="width: {{($pollFalseBefore/($pollTrueBefore+$pollFalseBefore))*100}}%">
                                                            <div class="in">{{($pollFalseBefore/($pollTrueBefore+$pollFalseBefore))*100}}%</div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                                <div class="move_nxt">
                                    <a href="{{url('student_next_tab_button'.'/'.$content->id.'/'.\App\Http\OwnClasses\STUDENT_ASSIGNED_LESSON_PLANS_ENUMS::GET_LONG_SURVEY_TAB_ENUM)}}"
                                       class="btn next-tab">

                                        <i class="fa fa-reply"></i>
                                    </a>
                                </div>


                            <br> <br>

                                <div class="retest">
                                    <a class="btn btn-info" href="{{route("exception_mark_tab_as_completed_and_navigate_to_next_lesson",["content_id"=>$content->id,"tab_enum"=>\App\Http\OwnClasses\STUDENT_ASSIGNED_LESSON_PLANS_ENUMS::GET_LONG_SURVEY_TAB_ENUM])}}">
                                    <i class="fa fa-reply"></i>
                                      الدرس التالى
                                    </a>
                                </div>


                        @else
                            <p><b> <i class="fa fa-exclamation-circle" style="color:green;"></i>&nbsp;الان بعد قرائتك للمقال حدد إذا كنت توافق أو لا توافق على هذه العبارة: </b></p>
                            <label class="t-lable">
                                <i class="fas fa-caret-left quiz-color"></i>
                                <span class="h4 quiz-color">
                                    {{$content->poll}}
                                    </span>
                            </label>
                            <div class="selections">
                                <div class="field">

                                    <form action="{{route('answerpoll')}}" method="post">
                                        {{csrf_field()}}

                                        <input type="radio" name="poll_ans" value="1"/>
                                        <label>نعم</label>

                                </div>
                                <input name="content_id" value="{{$content_id}}" type="hidden"/>
                                <input name="type" value="after" type="hidden"/>
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
                            <button type="submit" class="btn btn-success">
                                <i class="fa fa-paper-plane"></i> ارسال
                            </button>
                            </form>

                        @endif

                    </section>


                </div>
                {{-- ////////////////////// Bottom --- Right --- Links ////////////////////////////// --}}
                @include('studentLayout.sidebar')
            </div>
        </div>
@endsection
