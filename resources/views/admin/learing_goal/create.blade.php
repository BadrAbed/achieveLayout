@extends('layouts.app')

@section('custom-content')



    {{ Form::open(array('url' => 'creategoal')) }}
    <section class="content">
        <div class="container">
            <div class="container main-container">
                <div class="row form-group text-center">
                    <div class="con">
                        @include('inc.errorMessages')
                        <div class="t-con">
                            <div class="h4 h-center">
                                اضافة ناتج تعلم
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mainDiv">
                    <div class="row form-group">
                        <div class="col-md-2">
                            {{ Form::label('word', 'ناتج تعلم ', array('class' => 'col-form-label')) }}
                        </div>
                        <div class="col-md-10">
                            <div class="ui input  fluid ">
                                {{ Form::text('name', Input::old('name'), array('class' => 'form-control','minlength'=>'"4"','required' => 'required','oninvalid'=>"this.setCustomValidity('من فضلك ادخل اسم  ناتج التعلم ')",'oninput'=>"setCustomValidity('')")) }}
                            </div>
                        </div>

                    </div>
                    <hr>
                </div>



                <div class="empty"></div>

                {{ Form::button('التالى <i class="fas fa-caret-left"></i>', ['type' => 'submit', 'class' => 'btn btn-primary pull-left'] )  }}
            </div>

        </div>
    </section>
    <!-- if there are creation errors, they will show here -->

    {{ Form::close() }}


@endsection
