@extends('layouts.app')

@section('custom-content')





    {!! Form::open(['action' => ['StretchArtical@update', $content_id], 'files' => 'true','method' => 'PUT']) !!}

    <section class="content">
        <div class="container">
            <div class="container main-container">
                @include('inc.bar')

                <div class="panel panel-green">
                    @include('inc.errorMessages')
                    @if (Session::has('message'))
                        <div class="alert alert-info">{{ Session::get('message') }}</div>
                    @endif
             <div class="panel-heading"><h3 class="text-center"><i class="fa fa-edit"></i> تعديل المقال الموسع</h3></div>
             <div class="panel-body"> 
                <div class="row form-group">
                    <div class="col-md-2">
                        {{ Form::label('article', 'المقال', array('class' => 'col-form-label')) }}
                        <input name="image" type="file" id="upload" class="hidden" onchange="">
                    </div>
                    <div class="col-md-10">
                        <?php  if (isset($content->article))
                            $content_article = $content->article;
                        else
                            $content_article = "";
                        ?>
                        {{ Form::textarea('article',$content_article, array('class' => 'form-control editor')) }}
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-md-2">
                        {{ Form::label('sound', 'الملف الصوتي', array('class' => 'col-form-label')) }}
                    </div>
                    <div class="col-md-10">
                        {{ Form::file('sound', array('id' => 'file','accept="audio/*"','required')) }}
                        <audio id="audio"></audio>
                        <input type="hidden" value="" id="durationtest" name="duration"></input>

                        @if(isset($content->sound->path))
                            <br><audio controls>
                                <source src="{{ url($content->sound->path) }}" type="audio/{{$content->sound->type}}">
                            </audio>
                        @endif
                    </div>

                </div>

          
            <div class="empty"></div>


            <br>
            {{ Form::button('التالى <i class="fa fa-share"></i>', ['type' => 'submit', 'class' => 'btn btn-success pull-left'] )  }}
  </div>
           </div></div>
        </div>
        </div>
    </section>
    <!-- if there are creation errors, they will show here -->







    {{ Form::close() }}


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
    <script>
        var objectUrl;

        $("#audio").on("canplaythrough", function (e) {
            var seconds = e.currentTarget.duration;
            $("#durationtest").val(seconds);
            URL.revokeObjectURL(objectUrl);
        });

        $("#file").change(function (e) {
            var file = e.currentTarget.files[0];

            $("#filename").text(file.name);
            $("#filetype").text(file.type);
            $("#filesize").text(file.size);

            objectUrl = URL.createObjectURL(file);
            $("#audio").prop("src", objectUrl);
        });

        $(document).ready(function () {
            $('#1').removeClass('circle2 active').addClass('circle2 done');
            $('#2').removeClass('circle2 active').addClass('circle2 done');
            $('#3').removeClass('circle2 active').addClass('circle2 done');
            $('#4').removeClass('circle2').addClass('circle2 active');
        });
    </script>
@endsection
