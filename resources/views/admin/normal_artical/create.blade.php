@extends('layouts.app')

@section('custom-content')
    @include('inc.progress_bar')



    {{ Form::open(array('url' => url("normal-artical/store/$content_id"), 'files'=>'true')) }}
    <section class="content">
        <div class="container">
            <div class="container main-container">
                @include('inc.errorMessages')
                <div class="row form-group text-center">
                    <div class="con">
                        <div class="t-con">
                            <div class="h4 h-center">
                                اضافة المقال المختصر
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-md-2">
                        {{ Form::label('article', 'المقال', array('class' => 'col-form-label')) }}
                        <input name="image" type="file" id="upload" class="hidden" onchange="">
                    </div>
                    <div class="col-md-10">
                        {{ Form::textarea('article', '', array('class' => 'form-control editor')) }}
                    </div>
                </div>
                <div class="row form-group ">

                    <div class="col-md-2">
                        <label for="image" class="col-form-label">ملف الصوت</label>
                    </div>
                    <div class="col-md-10 ">
                        <div class="input-group mb-3">
                            <div class="input-group-append">
                                <div class="upload-btn-wrapper ">
                                    <button class="{{ $errors->has('sound') ? 'btnme-error' : 'btnme'}}"><span
                                                class="fa fa-plus-circle"></span>&nbsp;تحميل الملف
                                    </button>
                                    <input type="file" name="sound" required accept='audio/*' id="file"/>
                                    <audio id="audio"/>
                                </div>
                            </div>
                        </div>

                    </div>
                    <input type="hidden" value="" id="durationtest" name="duration"></input>
                </div>

            </div>
            <div class="empty"></div>
            {{ Form::button('التالى <i class="fas fa-caret-left"></i>', ['type' => 'submit', 'class' => 'btn btn-primary pull-left'] )  }}
        </div>
        </div>

    </section>
    <!-- if there are creation errors, they will show here -->







    {{ Form::close() }}
@section('OldJqueryVersion')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
    <script src="http://code.jquery.com/jquery-1.9.1.js"></script>

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
            $('#2').removeClass('circle2').addClass('circle2 active');

        });
    </script>
@endsection

@endsection
