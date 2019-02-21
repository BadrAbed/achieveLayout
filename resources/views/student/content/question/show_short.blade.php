@extends('studentLayout.app') @section('content')

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


                    <section id="content_tab_3">
                        <div id="feedback"></div>
                        {{--{{dd($quest)}}--}}
                        @if(isset($result))
                            @php
                                $questions_ids=$allQuest->pluck('id')->toArray();

                                $answers=App\Answer_Questions::whereIn('question_id',$questions_ids)->where('user_id',auth()->id())->get();

                            @endphp

                            <h3>اجابات الاسئله</h3>
                            <table class="table table-striped table-bordered">
                                <thead>
                                <td>السؤال</td>
                                <td>المحاوله الاولي</td>
                                <td>المحاوله الثانيه</td>
                                <td>المحاوله الثالثه</td>
                                </thead>

                                    <tbody>
                                    @foreach($answers as $answer)
                                    <tr>
                                        <td>{!!$answer->type->question!!}</td>
                                        <td>{!!($answer->reattempt_questions==1)?'<span><i class="fa fa-check-circle"></i></span>':'</span><i class="fa fa-times-circle"></i></span>'!!} </td>
                                        <td>@if($answer->reattempt_questions!=1 ){!!($answer->reattempt_questions==2)?'<span><i class="fa fa-check-circle"></i></span>':'</span><i class="fa fa-times-circle"></i></span>'!!} @else -- @endif</td>
                                        <td>@if($answer->reattempt_questions!=1 && $answer->reattempt_questions!=2){!!($answer->reattempt_questions==3)?'<span><i class="fa fa-check-circle"></i></span>':'<span><i class="fa fa-times-circle"></i></span>'!!} @else -- @endif</td>
                                    </tr>
                                    @endforeach
                                    </tbody>

                            </table>
                            <h2 class="alert"> نتيجه الاختبار </h2>
                            <h3 class="alert "> {{$result['degree']}} من {{$result['maxDegree']}}</h3>



                            <div class="move_nxt">
                                <a href="{{url('student_next_tab_button'.'/'.$content->id.'/'.\App\Http\OwnClasses\STUDENT_ASSIGNED_LESSON_PLANS_ENUMS::GET_SHORT_QUESTIONS_TAB_ENUM)}}"
                                   class="btn next-tab">

                                    <i class="fa fa-reply"></i>
                                </a>
                            </div>

                            <div class="retest">
                                <a class="btn btn-info" href="{{url('reattemptQuestions/'.$content->id).'/'.'activityquest'}}">
                                    <i class="fa fa-retweet" aria-hidden="true"></i>
                                    اعاده الاختبار
                                </a>
                            </div>
                        @else

                            <input type="hidden" name="questions[{{$quest[0]->id}}][question]" value="{{$quest[0]->id}}"
                                   required>  </input>
                            <input type="hidden" name="typeofquest" value="activity" required>
                            <input value="{{$content_id}}" type="hidden" name="content_id">

                            <label>
                        <span class="quest_h">
                            <i class="fa fa-caret-left" aria-hidden="true"></i>
                            قم باختيار الاجابة الصحيحة فيما ياتي.
                        </span>
                            </label>
                            <br></br>
                            <label class="t-lable">
                                <span class="quest_title">
                        {{$quest[0]->question}}
                        </span>
                            </label>
                            <div class="selections">
                                <div>
                                    <input id="ans1" type="radio" name="studentAns" class="ans">
                                    <label for="ans1">{{$quest[0]->ans1}}</label>
                                </div>
                                <div>
                                    <input id="ans2" type="radio" name="studentAns" class="ans">
                                    <label for="ans2">{{$quest[0]->ans2}}</label>
                                </div>
                                @if($quest[0]->ans3 !=null)
                                <div>
                                     <input id="ans3" type="radio" name="studentAns" class="ans">
                                    <label for="ans3">{{$quest[0]->ans3}}</label>
                                </div>
                                @endif
                                @if($quest[0]->ans4 !=null)
                                <div>
                                    <input id="ans4" type="radio" name="studentAns" class="ans">
                                    <label for="ans4">{{$quest[0]->ans4}}</label>
                                </div>
                                @endif

                                {{-- //////////////////////////////////////////////////////////////////////////////////////////////// --}}


                                {{--<input class="ans" type="radio" id="ans1" name="studentAns">--}}
                                {{--{{$quest[0]->ans1}}--}}
                                {{--<br>--}}
                                {{--<input class="ans" type="radio" id="ans2" name="studentAns"> {{$quest[0]->ans2}}--}}
                                {{--<br>--}}
                                {{--<input class="ans" type="radio" id="ans3" name="studentAns"> {{$quest[0]->ans3}}--}}
                                {{--<br>--}}
                                {{--<input class="ans" type="radio" id="ans4" name="studentAns"> {{$quest[0]->ans4}}--}}
                                {{--<br>--}}

                                {{-- //////////////////////////////////////////////////////////////////////////////////////////////// --}}


                                {{--<div class="activity-option ans" id="ans1">--}}
                                {{--<span class="ac-option01 text-center">أ</span>--}}
                                {{--<div class="a-option">--}}
                                {{--<span class="mc-option"> {{$quest[0]->ans1}}</span>--}}
                                {{--</div>--}}
                                {{--</div>--}}
                                {{--<div class="activity-option ans" id="ans2">--}}
                                {{--<span class="ac-option01 text-center">ب</span>--}}
                                {{--<div class="a-option">--}}
                                {{--<span class="mc-option">  {{$quest[0]->ans2}}</span>--}}
                                {{--</div>--}}
                                {{--</div>--}}
                                {{--<div class="activity-option ans" id="ans3">--}}
                                {{--<span class="ac-option01 text-center">ج</span>--}}
                                {{--<div class="a-option">--}}
                                {{--<span class="mc-option">  {{$quest[0]->ans3}}</span>--}}
                                {{--</div>--}}
                                {{--</div>--}}
                                {{ csrf_field() }}

                                <br>

                                <meta name="csrf-token" content="{{ csrf_token() }}">
                    </section>


                    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

                    <script>
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        })
                        var x = 1;
                        var degree = 3;
                        $(document).ready(function () {


                            $('.ans').click(function () {
                                $("#feedback").empty();
                                console.log(this.id);
                                ans = this.id;
                                var _token = $('input[name=_token]').val();
                                var ans_name = ans;
                                var quest_id = "<?= $quest[0]->id ?>";
                                var form_data = new FormData();
                                form_data.append('_token', _token);
                                form_data.append('content_id', "<?= $content->id ?>");
                                form_data.append('ans', ans_name);
                                form_data.append('quest_id', quest_id);
                                form_data.append('number_of_attempt', x);
                                if (ans == "<?= $quest[0]->true_answer ?>") {
                                    form_data.append('degree', degree);
                                    $("#feedback").append("<div class='alert alert-info'>الاجابه صحيحه</div>");
                                    $.ajax({
                                        type: 'post',
                                        url: '{{url('addanswer')}}',

                                        data: form_data,
                                        contentType: false, // The content type used when sending data to the server.
                                        cache: false, // To unable request pages to be cached
                                        processData: false,

                                        success: function ($data) {
                                            window.location.reload();
                                        }
                                    });

                                }

                                else {
                                    x++;
                                    --degree;
                                    if (x == 4) {
                                        form_data.append('degree', 0);
                                        $.ajax({
                                            type: 'post',
                                            url: '{{url('addanswer')}}',

                                            data: form_data,
                                            contentType: false, // The content type used when sending data to the server.
                                            cache: false, // To unable request pages to be cached
                                            processData: false,

                                            success: function ($data) {
                                                window.location.reload();
                                            }
                                        });
                                    }
                                    $("#feedback").append("<div class='alert alert-info' id='quest_feedback'>الاجابه خطا حاول مجددا</div>");
                                    setTimeout(function () {
                                        $("#quest_feedback").fadeOut();
                                    }, 2000);

                                }


                            });

                        });
                    </script>

                    @endif

                </div>
                {{-- ////////////////////// Bottom --- Right --- Links ////////////////////////////// --}}
                @include('studentLayout.sidebar')
            </div>
        </div>
@endsection
