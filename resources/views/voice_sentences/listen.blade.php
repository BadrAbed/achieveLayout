@extends("layouts.app")





@section("custom-content")
    @if($type =="create")
        @include('inc.progress_bar')
    @endif
    @include("voice_sentences.partials.CSSaudioPlugin")
    <section class="content">
        <div class="container">
            <div class="container main-container">
                <div class="row form-group text-center">
                    <div class="con">
                        <div class="t-con">
                            <div class="h4 h-center" style="left: 78%; padding: 0 px">
                                اختبار الجمله الصوتيه
                            </div>
                        </div>
                    </div>
                </div>
                <article>


                    <p class="passage-audio" hidden>
                        <audio id="passage-audio" class="passage" controls>

                            <source src="{{$audioPath}}" type="{{$audioType}}">
                            <em class="error"><strong>Error:</strong> Your browser doesn't appear to support HTML5
                                Audio.</em>
                        </audio>
                    </p>

                    <p class="passage-audio-unavailable" hidden>
                        <em class="error"><strong>Error:</strong> You will not be able to do the read-along audio
                            because your browser is not able to play MP3, Ogg, or WAV audio formats.</em>
                    </p>

                    <div class="row">
                        <div class="col-md-12">
                            <p class="playback-rate" hidden
                               title="Note that increaseing the reading rate will decrease accuracy of word highlights">
                                <label for="playback-rate">Reading rate:</label>
                                <input id="playback-rate" style="width: 10% !important;" type="range" min="0.5"
                                       max="2.0" value="1.0" step="0.1" disabled
                                       onchange='this.nextElementSibling.textContent = String(Math.round(this.valueAsNumber * 10) / 10) + "\u00D7";'>
                                <output>1&times;</output>
                            </p>
                        </div>

                    </div>

                    <p class="playback-rate-unavailable" hidden>
                        <em>(It seems your browser does not support <code>HTMLMediaElement.playbackRate</code>, so you
                            will not be able to change the speech rate.)</em>
                    </p>

                    <p class="autofocus-current-word" hidden>
                        <input type="checkbox" id="autofocus-current-word" checked>
                        <label for="autofocus-current-word">Auto-focus/auto-scroll</label>
                    </p>

                    <noscript>
                        <p class="error"><em><strong>Notice:</strong> You must have JavaScript enabled/available to try
                                this HTML5 Audio read along.</em></p>
                    </noscript>


                    <div id="passage-text" class="passage">
                        <?php
                        foreach($sentencesRows as $index => $eachArr){
                        ?>
                        <span data-dur="<?=$eachArr["duration"]?>" data-begin="<?=$eachArr["startSeconds"]?>"
                              tabindex="0" data-index="<?=$index?>"><?=$eachArr["sentence"]?></span>

                        <?php } ?>

                    </div>


                </article>

                <div class="empty"></div>

                @if($type =="create")
                    @if($tn =="NA")
                        <a href="{{url("createquestion")}}" class="btn btn-primary pull-left" role="button"> التالي <i
                                    class="fas fa-caret-left"></i></a>
                    @else
                        <a href="{{url("addationQuestion")}}" class="btn btn-primary pull-left" role="button"> التالي <i
                                    class="fas fa-caret-left"></i></a>
                    @endif
                @else
                    <a href="{{url("content/$contentId/edit")}}" class="btn btn-primary pull-left" role="button"> التالي
                        <i
                                class="fas fa-caret-left"></i></a>

                @endif
                @include("voice_sentences.partials.JSaudioPlugins")

            </div>
        </div>
    </section>
    @if(Session::get('normal')!=null)
        <script>
            var element1=document.getElementById("1");
            element1.classList.remove("active");
            element1.classList.add("done");
            var element2=document.getElementById("2");
            element2.classList.add("active");
        </script>
    @else
        <script>
            var element1=document.getElementById("1");
            element1.classList.remove("active");
            element1.classList.add("done");
            var element2=document.getElementById("2");
            element2.classList.remove("active");
            element2.classList.add("done");
            var element3=document.getElementById("3");
            element3.classList.remove("active");
            element3.classList.add("done");
            var element4=document.getElementById("4");
            element4.classList.add("active");

        </script>
    @endif
@endsection