@extends('layouts.app')

@include("voice_sentences.partials.CSSaudioPlugin")

@section('custom-content')


    @php
        $stretchContentArr = \App\Http\OwnClasses\CONTENT_EDITOR_NEW_CONTENT_SEPERATOR_ICON::getArrayOfContentsByStringConcatenatedString($content->articalstrach->article);//process mutliple tabs for the same content

    @endphp



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

                    <section id="content6" style="padding-top: 40px;">


                        <article>
<br>

                            <p class="passage-audio" style="width: 50%;">
                                <audio id="passage-audio" class="passage" controls>

                                    <source src="{{ url($stretch->sound->path) }}"
                                            type="audio/{{$stretch->sound->type}}" >
                                    <em class="error"><strong>Error:</strong> Your browser doesn't appear to
                                        support HTML5 Audio.</em>
                                </audio>
                            </p>
                            <br>

                            <div class="tab-content" id="readtextstretch">

                                {{--<div id="readspeaker_button1" class="rs_skip rsbtn rs_preserve">--}}
                                    {{--<a rel="nofollow" class="rsbtn_play" accesskey="L" title="ReadSpeaker webReader إستمع إلى هذه الصفحةِ مستخدماً" href="//app-eu.readspeaker.com/cgi-bin/rsent?customerid=3&amp;lang=ar_ar&amp;voice=Amir&amp;readid=readtextstretch&amp;url=<?php echo urlencode("http://".$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"]); ?>">--}}
                                        {{--<span class="rsbtn_left rsimg rspart"><span class="rsbtn_text"><span>استمع</span></span></span>--}}
                                        {{--<span class="rsbtn_right rsimg rsplay rspart"></span>--}}
                                    {{--</a>--}}
                                {{--</div>--}}
                                @for($i=0;$i<count($stretchContentArr);$i++)
                                    <div id="menu{{$i}}" class="tab-pane fade <?=($i == 0) ? "in active" : ""?> editor_content">
                                        <p>{!! $stretchContentArr[$i] !!}</p>
                                    </div>
                                @endfor

                            </div>

                            <p class="passage-audio-unavailable2" hidden>
                                <em class="error"><strong>Error:</strong> You will not be able to do the
                                    read-along audio because your browser is not able to play MP3, Ogg, or WAV
                                    audio formats.</em>
                            </p>

                            <!-- <div class="row">
                                <div class="col-md-12">
                                    <p class="playback-rate2"
                                       title="Note that increaseing the reading rate will decrease accuracy of word highlights">
                                        <label for="playback-rate2">Reading rate:</label>
                                        <input id="playback-rate2" style="width: 10% !important;" type="range"
                                               min="0.5" max="2.0" value="1.0" step="0.1"
                                               onchange='this.nextElementSibling.textContent = String(Math.round(this.valueAsNumber * 10) / 10) + "\u00D7";'>
                                        <output>1&times;</output>
                                    </p>
                                </div>

                            </div>

                            <p class="playback-rate-unavailable2" hidden>
                                <em>(It seems your browser does not support
                                    <code>HTMLMediaElement.playbackRate</code>, so you will not be able to
                                    change the speech rate.)</em>
                            </p>

                            <p class="autofocus-current-word2" hidden>
                                <input type="checkbox" id="autofocus-current-word2" checked>
                                <label for="autofocus-current-word2">Auto-focus/auto-scroll</label>
                            </p> -->

                            <noscript>
                                <p class="error"><em><strong>Notice:</strong> You must have JavaScript
                                        enabled/available to try this HTML5 Audio read along.</em></p>
                            </noscript>


                            <div id="passage-text2" class="passage">


                                <?php
                                /*
                                                                foreach($soundRecordedSentencesWithVoicesStretchArticle as $index => $eachArr){
                                                                ?>
                                                                <span data-dur="<?=$eachArr["duration"]?>"
                                                                      data-begin="<?=$eachArr["startSeconds"]?>" tabindex="0"
                                                                      data-index="<?=$index?>"><?=$eachArr["sentence"]?></span>


                                                                <?php }*/ ?>

                            </div>


                        </article>
                        <ul class="nav nav-tabs" style="border: none !important;">

                            @for($i=0;$i<count($stretchContentArr);$i++)
                                @php $index = $i+1@endphp
                                <li class="<?=($i == 0) ? "active" : ""?>"><a data-toggle="tab"
                                                                              href="#menu{{$i}}"> {{$index}}</a>
                                </li>
                            @endfor
                        </ul>
                        <br>
                        <hr>

                        </br>
                        <div class="clearfix"></div>
                        @include('inc.issues',['tab_num'=>App\Http\OwnClasses\STUDENT_ASSIGNED_LESSON_PLANS_ENUMS::GET_STRETCH_ARTICLE_TAB_ENUM])
                    </section>
                </div>
            </div>
        </div>
        @include('inc.admin_content_side_bar')
    </div>

@endsection
