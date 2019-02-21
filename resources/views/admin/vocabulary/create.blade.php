@extends('layouts.app')

@section('custom-content')
    @if(Session::get('messagebar') ==null)
        @include('inc.progress_bar')
    @endif



    {{ Form::open(array('url' => url("store/vocabularys/$content_id"))) }}
    <section class="content">
        <div class="container">
            <div class="container main-container">
                <div class="row form-group text-center">
                    <div class="con">
                        @include("inc.errorMessages")
                        <div class="t-con">
                            <div class="h4 h-center">
                                اضافة مصطلح
                            </div>
                        </div>
                    </div>
                </div>

                @if(old('vocab')>0)
                    <?php $i = 0 ?>
                    @foreach(old('vocab') as $vocab)
                        <div class="mainDiv">
                            <div class="row form-group">
                                <div class="col-md-2">
                                    {{ Form::label('word', 'مصطلح', array('class' => 'col-form-label')) }}
                                </div>
                                <div class="col-md-10">
                                    <div class="ui input  fluid ">
                                        {{ Form::text("vocab[$i][word]",$vocab['word'] , array('class' => 'form-control','required' => 'required','oninvalid'=>"this.setCustomValidity('من فضلك ادخل اسم  المصطلح ')",'oninput'=>"setCustomValidity('')")) }}
                                    </div>
                                </div>

                            </div>
                            <div class="row form-group">
                                <div class="col-md-2">

                                    {{ Form::label('meaning', 'معني مصطلح', array('class' => 'col-form-label')) }}
                                </div>
                                <div class="col-md-10">


                                    <div class="ui input  fluid ">
                                        {{ Form::text("vocab[$i][meaning]", $vocab['meaning'], array('class' => 'form-control','required' => 'required','oninvalid'=>"this.setCustomValidity('من فضلك ادخل معنى  المصطلح ')",'oninput'=>"setCustomValidity('')")) }}
                                    </div>
                                </div>
                            </div>
                            <hr>
                        </div>
                        <?php $i++?>
                    @endforeach
                @else
                    <div class="mainDiv">
                        <div class="row form-group">
                            <div class="col-md-2">
                                {{ Form::label('word', 'مصطلح', array('class' => 'col-form-label')) }}
                            </div>
                            <div class="col-md-10">
                                <div class="ui input  fluid ">
                                    {{ Form::text('vocab[0][word]', Input::old('word'), array('class' => 'form-control','required' => 'required','oninvalid'=>"this.setCustomValidity('من فضلك ادخل اسم  المصطلح ')",'oninput'=>"setCustomValidity('')")) }}
                                </div>
                            </div>

                        </div>
                        <div class="row form-group">
                            <div class="col-md-2">

                                {{ Form::label('meaning', 'معني مصطلح', array('class' => 'col-form-label')) }}
                            </div>
                            <div class="col-md-10">


                                <div class="ui input  fluid ">
                                    {{ Form::text('vocab[0][meaning]', Input::old('meaning'), array('class' => 'form-control','required' => 'required','oninvalid'=>"this.setCustomValidity('من فضلك ادخل معنى  المصطلح ')",'oninput'=>"setCustomValidity('')")) }}
                                </div>
                            </div>
                        </div>
                        <hr>
                    </div>

                @endif
                <button class="btn btn-success" type="button" id="addVocab">add</button>

                <div class="empty"></div>
                <input name="content_id" value="{{$content_id}}" type="hidden"/>
                {{ Form::button('التالى <i class="fas fa-caret-left"></i>', ['type' => 'submit', 'class' => 'btn btn-primary pull-left'] )  }}

                <br>
                <br>
                <br>
                <br>


            </div>
        </div>
    </section>
    <!-- if there are creation errors, they will show here -->

    {{ Form::close() }}
@section('OldJqueryVersion')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
    <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
    <script>


        $(document).ready(function () {
            $('#1').removeClass('circle2 active').addClass('circle2 done');
            $('#2').removeClass('circle2 active').addClass('circle2 done');
            $('#3').removeClass('circle2 active').addClass('circle2 done');
            $('#4').removeClass('circle2 active').addClass('circle2 done');
            $('#5').removeClass('circle2 active').addClass('circle2 done');
            $('#6').removeClass('circle2').addClass('circle2 active');
        });
    </script>
@endsection
@endsection
