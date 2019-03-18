@extends('studentLayout.app') @section('content')

    @php
        $normalContentArr = \App\Http\OwnClasses\CONTENT_EDITOR_NEW_CONTENT_SEPERATOR_ICON::getArrayOfContentsByStringConcatenatedString($content->articalnormal->article);//process mutliple tabs for the same content
    @endphp
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
            <div class="col-md-12 col-sm-12  right">
                <i class="fa fa-caret-left" aria-hidden="true"></i>
                <span>{{$content->content_name}}</span>
                <div class="" style="float:left;">
                    {!! $content->content_location !!}
                </div>
            </div>
            {{-- ////////////////////// Top --- Right ////////////////////////////// --}}

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
                    <section id="content_tab_2" >
                        <div class="img">
                            <img src="{{url('/'.$content->lessonImage)}}">
                        </div>
                        <div class="audio">
                            <audio id="passage-audio" class="passage" controls>
                                <source src="{{ url($normal->sound->path) }}" type="audio/{{$normal->sound->type}}">
                                <em class="error">
                                    <strong>Error:</strong>
                                    Your browser doesn't appear to
                                    support HTML5 Audio.
                                </em>
                            </audio>
                        {{--<div class="controls">--}}
                            {{--<div class="action">--}}
                                {{--<a href="" data-tooltip="السابق">--}}
                                    {{--<i class="fa fa-backward" aria-hidden="true"></i>--}}
                                {{--</a>--}}
                                {{--<a href=""data-tooltip="توقف">--}}
                                    {{--<i class="fa fa-pause" aria-hidden="true"></i>--}}
                                {{--</a>--}}
                                {{--<a href="" data-tooltip="التالي">--}}
                                    {{--<i class="fa fa-forward" aria-hidden="true"></i>--}}
                                {{--</a>--}}
                            {{--</div>--}}
                            {{--<div class="left_time">--}}
                                {{--<span>1:20:20</span>--}}
                            {{--</div>--}}
                            {{--<div class="progress-bar-wrap">--}}
                                {{--<audio id="passage-audio" class="passage" controls>--}}
                                {{--<source src="https://www.w3schools.com/html/horse.ogg" type="audio/{{$normal->sound->type}}">--}}
                                {{--<em class="error">--}}
                                {{--<strong>Error:</strong>--}}
                                {{--Your browser doesn't appear to--}}
                                {{--support HTML5 Audio.--}}
                                {{--</em>--}}
                                {{--</audio>--}}
                            {{--</div>--}}
                            {{--<div class="full_time">--}}
                                {{--<span>1:20:20</span>--}}
                            {{--</div>--}}
                            {{--<div class="voice">--}}
                                {{--<a href="" data-tooltip="خفض الصوت">--}}
                                    {{--<i class="fa fa-volume-down" aria-hidden="true"></i>--}}
                                {{--</a>--}}
                                {{--<div class="progress-bar-wrap">--}}
                                    {{--<progress class="p" value="0.3"></progress>--}}
                                    {{--<div class="progress-bar" style="transform: translateX(-70%)"></div>--}}
                                {{--</div>--}}
                                {{--<a href="" data-tooltip="رفع الصوت">--}}
                                    {{--<i class="fa fa-volume-up" aria-hidden="true"></i>--}}
                                {{--</a>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                            <div class="article">
                                {{--  --}}
                                <div class="action">
                                    <button role="button" id="decreasetext" data-tooltip="تصغير الخط">
                                        <i class="fa fa-minus" aria-hidden="true"></i>
                                    </button>
                                    <button role="button" id="increasetext" data-tooltip="تكبير الخط">
                                        <i class="fa fa-plus" aria-hidden="true"></i>
                                    </button>
                                </div>

                            <ul class="tabs">
                                @for($i=0;$i<count($normalContentArr);$i++)
                                    @php $index = $i+1 @endphp
                                    <li class="<?=($i == 0) ? "current" : ""?>" data-tab="tab-{{$i}}" href="#menu{{$i}}">{{$index}}</li>
                                @endfor
                            </ul>

                                @for($i=0;$i<count($normalContentArr);$i++)
                                <div class="tab-content <?=($i == 0) ? "current" : ""?>" id="tab-{{$i}}" >

                                <div id="menu{{$i}}" class="<?=($i == 0) ? "current" : ""?> ">
                                    <div id="content">
                                        {!! str_replace ("","ﷺ" , str_replace("","ﷺ" , $normalContentArr[$i])) !!}
                                    </div>

                                    </div>
                                </div>
                            @endfor
                            <p  class="passage-audio-unavailable" hidden>
                                <em class="error"><strong>Error:</strong> You will not be able to do the
                                read-along audio because your browser is not able to play MP3, Ogg, or WAV
                                audio formats.</em>
                            </p>
                            <!-- <div class="row">
                               <div class="col-md-12">
                                   <p class="playback-rate"
                                      title="Note that increaseing the reading rate will decrease accuracy of word highlights">
                                       <label for="playback-rate">???? ???????:</label>
                                       <input id="playback-rate" style="width: 10% !important;" type="range"
                                              min="0.5" max="2.0" value="1.0" step="0.1"
                                              onchange='this.nextElementSibling.textContent = String(Math.round(this.valueAsNumber * 10) / 10) + "\u00D7";'>
                                       <output>1&times;</output>
                                   </p>
                               </div>

                           </div> -->

                            <!-- <p class="playback-rate-unavailable" hidden>
                                <em>(It seems your browser does not support
                                    <code>HTMLMediaElement.playbackRate</code>, so you will not be able to
                                    change the speech rate.)</em>
                            </p> -->
                            <!--
                                                        <p class="autofocus-current-word" >
                                                            <input type="checkbox" id="autofocus-current-word" checked>
                                                            <label for="autofocus-current-word">????? ???? ?? ????? ??????</label>
                                                        </p> -->

                            {{--<noscript>--}}
                            {{--<p class="error"><em><strong>Notice:</strong> You must have JavaScript--}}
                            {{--enabled/available to try this HTML5 Audio read along.</em></p>--}}
                            {{--</noscript>--}}


                            <div id="passage-text" class="passage">


                                <?php


                                /*

                            foreach($soundRecordedSentencesWithVoicesNormalArticle as $index => $eachArr){
                            ?>
                            <span data-dur="<?=$eachArr["duration"]?>"
                                  data-begin="<?=$eachArr["startSeconds"]?>" tabindex="0"
                                  data-index="<?=$index?>"><?=$eachArr["sentence"]?></span>


                            <?php }*/ ?>
                            </div>


                        </div>

                            <div class="move_nxt">
                                <a href="{{url('student_next_tab_button'.'/'.$content->id.'/'.\App\Http\OwnClasses\STUDENT_ASSIGNED_LESSON_PLANS_ENUMS::GET_NORMAL_ARTICLE_TAB_ENUM)}}"
                                   class="btn next-tab">

                                    الانشطة     <i class="fa fa-arrow-left"></i>
                                </a>
                            </div>
                        <div class="clearfix"></div>

                    </section>



                </div>
                @include('studentLayout.sidebar')
        </div>
    </div>
@endsection
