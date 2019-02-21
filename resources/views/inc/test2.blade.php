<section id="content3">
    <div id="feedback"></div>
    {{--{{dd($quest)}}--}}
    @if(isset($result))
        <h2 class="alert alert-danger"> نتيجه الاختبار: </h2>
        <h3 class="alert alert-warning"> {{$result['bonus']}} من {{$result['maxBouns']}}</h3>
        <a class="btn btn-info" href="{{url('reattemptQuestions/'.$content->id).'/'.'addationquest'}}"> اعاده
            الاختبار</a>
        <a href="{{route("exception_mark_tab_as_completed_and_navigate_to_next_lesson",["content_id"=>$content->id,"tab_enum"=>\App\Http\OwnClasses\STUDENT_ASSIGNED_LESSON_PLANS_ENUMS::GET_LONG_QUESTIONS_TAB_ENUM])}}"
           class="btn btn-success">الدرس التالي  <i class="fa fa-reply"></i></a>
    @else

        <input type="hidden" name="questions[{{$addationquests[0]->id}}][question]" value="{{$addationquests[0]->id}}"
               required>  </input>
        <input type="hidden" name="typeofquest" value="activity" required>
        <input value="{{$content_id}}" type="hidden" name="content_id">

        <label>
                        <span class="h4">
                        قم باختيار الاجابة الصحيحة فيما ياتي.
                        </span>
        </label>
        <br></br>
        <label class="t-lable">
            <i class="fas fa-caret-left quiz-color"></i>
            <span class="h4 quiz-color">
                        {{$addationquests[0]->question}}
                        </span>
        </label>
        <div class="selections">

            <div class="activity-option ans" id="ans1">
                <span class="ac-option01 text-center">أ</span>
                <div class="a-option">
                    <span class="mc-option"> {{$addationquests[0]->ans1}}</span>
                </div>
            </div>
            <div class="activity-option ans" id="ans2">
                <span class="ac-option01 text-center">ب</span>
                <div class="a-option">
                    <span class="mc-option">  {{$addationquests[0]->ans2}}</span>
                </div>
            </div>
            <div class="activity-option ans" id="ans3">
                <span class="ac-option01 text-center">ج</span>
                <div class="a-option">
                    <span class="mc-option">  {{$addationquests[0]->ans3}}</span>
                </div>
            </div>
            {{ csrf_field() }}

            <br>

            <meta name="csrf-token" content="{{ csrf_token() }}">
</section>

@section('OldJqueryVersion')

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
                var quest_id = "<?= $addationquests[0]->id ?>";
                var form_data = new FormData();
                form_data.append('_token', _token);

                form_data.append('ans', ans_name);
                form_data.append('content_id', "<?= $content->id ?>");
                form_data.append('quest_id', quest_id);
                form_data.append('number_of_attempt', x);
                if (ans == "<?= $addationquests[0]->true_answer ?>") {
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
@endsection