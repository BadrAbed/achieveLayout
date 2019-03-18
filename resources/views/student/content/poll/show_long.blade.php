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
            <div class="col-md-6 left">
            </div>
        </div>
        {{-- ////////////////////// Bottom ////////////////////////////// --}}
        <div class="row bottom">
            {{-- ////////////////////// Bottom --- Right ////////////////////////////// --}}
            <div class="col-md-8 right">
                <div class="container">
                    @include('studentLayout.studentTabs')





                    <section id="content_tab_1">

                        <?php $poll = \App\PollResults::where('user_id', auth()->user()->id)->where('type', 'after')->where('content_id', $content->id)->first(); ?>
                        @if($poll !=null)
                            <h4 class="quest_h">
                                <i class="fa fa-caret-left" aria-hidden="true">   {{$content->hint}}</i>

                            </h4>
                            <div id="canvas-holder">
                                <div class="quest row">
                                    <div class="col-md-12">
                                        <section id="content_tab_1" style=" margin: 0; padding: 0;">

                                            <h5 class="quest_title">    {{ str_replace ("","ﷺ" , str_replace("","ﷺ" ,$content->poll)) }}<h5>

                                            <div class="selections">
                                                <div class="field">
                                                    <form action="http://localhost/achieve/public/answerpoll" method="post">
                                                        <input type="hidden" name="_token" value="BYuicUzSmnacXHPkbyUPdbFrohvqlOWeLJfGJ8Pl">
                                                        <input id="input1" type="radio" name="poll_ans" value="1" @if($poll->poll_ans==1) checked @else disabled @endif>
                                                        <label for="input1">نعم</label>
                                                    </form></div>
                                                <input name="content_id" value="53" type="hidden">
                                                <input name="type" value="before" type="hidden">
                                                <div class="field">
                                                    <input id="input2" type="radio" name="poll_ans" value="0" @if($poll->poll_ans==0) checked @else disabled @endif>
                                                    <label for="input2">لا</label>
                                                </div>
                                            </div>





                                        </section>

                                    </div>
                                   <div class="row" style="width: 100%; margin-top: 2rem;">
                                       <h5 class="quest_title col-md-12" style="padding-right: 0">
                                           <i class="fa fa-caret-left" aria-hidden="true"></i>
                                           اجابات باقي الطلاب</h5>
                                       <div class="col-md-6">
                                           <h3 style="font-size: 12pt;">نتيجة السؤال البعدي</h3>
                                           <div class="quest">
                                               <div>
                                                   <div class="first">
                                                       <div style="margin: 1rem 0;">
                                                           <span style="display: inline-block; width: 2%; font-size: 12pt;"> نعم</span>
                                                           <div id="myProgress">
                                                               <div id="myBar" style="width: {{($pollTrueAfter/($pollTrueAfter+$pollFalseAfter))*100}}%">
                                                                   <div class="in" style="visibility: hidden;">{{($pollTrueAfter/($pollTrueAfter+$pollFalseAfter))*100}}%</div>
                                                               </div>
                                                           </div>
                                                           <div class="in" style="display: inline-block; font-size: 12pt;  width: 35%; text-align: center;">{{round(($pollTrueAfter/($pollTrueAfter+$pollFalseAfter))*100)}}%</div>
                                                       </div>
                                                   </div>
                                                   <div>
                                                       <span style="display: inline-block; width: 2%; font-size: 12pt;">لا</span>
                                                       <div id="myProgress">
                                                           <div id="myBar" class="no" style="width: {{($pollFalseAfter/($pollTrueAfter+$pollFalseAfter))*100}}%">
                                                               <div class="in" style="visibility: hidden;">{{($pollFalseAfter/($pollTrueAfter+$pollFalseAfter))*100}}%</div>
                                                           </div>
                                                       </div>
                                                       <div class="in" style="display: inline-block; font-size: 12pt;  width: 35%; text-align: center;">{{round(($pollFalseAfter/($pollTrueAfter+$pollFalseAfter))*100)}}%</div>
                                                   </div>

                                               </div>
                                           </div>
                                       </div>
                                       <div class="col-md-6">
                                           <h3 style="font-size: 12pt;">نتيجة السؤال القبلي</h3>
                                           <div class="quest">
                                               <div>
                                                   <div class="first">
                                                       <div style="margin: 1rem 0;">
                                                           <span style="display: inline-block; width: 2%; font-size: 12pt;">نعم</span>
                                                           <div id="myProgress">
                                                               <div id="myBar" style="width: {{($pollTrueBefore/($pollTrueBefore+$pollFalseBefore))*100}}%">
                                                                   <div class="in" style="visibility: hidden;">{{($pollTrueBefore/($pollTrueBefore+$pollFalseBefore))*100}}%</div>
                                                               </div>
                                                           </div>
                                                           <div class="in" style="display: inline-block; font-size: 12pt;  width: 35%; text-align: center;">{{round(($pollTrueBefore/($pollTrueBefore+$pollFalseBefore))*100)}}%</div>
                                                       </div>
                                                       <div>
                                                           <span style="display: inline-block; width: 2%; font-size: 12pt;"> لا</span>
                                                           <div id="myProgress">
                                                               <div id="myBar" class="no" style="width: {{($pollFalseBefore/($pollTrueBefore+$pollFalseBefore))*100}}%">
                                                                   <div class="in" style="visibility: hidden;">{{($pollFalseBefore/($pollTrueBefore+$pollFalseBefore))*100}}%</div>
                                                               </div>
                                                           </div>
                                                           <div class="in" style=" display: inline-block; font-size: 12pt;  width: 35%; text-align: center;">{{round(($pollFalseBefore/($pollTrueBefore+$pollFalseBefore))*100)}}%</div>
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

                                        إلى المقال     <i class="fa fa-arrow-left"></i>
                                    </a>
                                </div>


                            <br> <br>

                                <div class="retest">
                                    <a class="btn btn-info" href="{{route("exception_mark_tab_as_completed_and_navigate_to_next_lesson",["content_id"=>$content->id,"tab_enum"=>\App\Http\OwnClasses\STUDENT_ASSIGNED_LESSON_PLANS_ENUMS::GET_LONG_SURVEY_TAB_ENUM])}}">
                                    <i class="fa fa-reply"></i>
                                      الدرس التالي
                                    </a>
                                </div>


                        @else
                            <p><b> <i class="fa fa-exclamation-circle" style="color:green;"></i>&nbsp;  {{$content->hint}}</b></p>
                            <label class="t-lable">
                                <i class="fa fa-caret-left quiz-color"></i>
                                <span class="h4 quiz-color">
                                    {{$content->poll}}
                                    </span>
                            </label>



                            <div class="selections">
                                <div class="field">

                                    <form action="{{route('answerpoll')}}" method="post">
                                        {{csrf_field()}}

                                        <input id="input1" type="radio" name="poll_ans" value="1">
                                        <label for="input1">نعم</label>

                                </div>
                                <input name="content_id" value="{{$content_id}}" type="hidden"/>
                                <input name="type" value="after" type="hidden"/>
                                <div class="field">

                                    <input id="input2" type="radio" name="poll_ans" value="0">
                                    <label for="input2">لا</label>

                                </div>
                            </div>
                            <p>لماذا قمت باختيار هذه الاجابة؟</p>
                            <div class="ui form form-group">
                                <div class="field">
                                    <textarea rows="4" style="width: 60%" name="explain"></textarea>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-success">
                                <i class="fa fa-paper-plane"></i> إرسال
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
