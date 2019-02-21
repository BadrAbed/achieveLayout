@extends('layouts.app')

@section('custom-content')


   <!-- {{ Html::ul($errors->all()) }}-->

    {{ Form::open(array('url' => 'country')) }}

    <section class="content">
        <div class="container">
            <div class="container main-container">

                <div class="row form-group text-center">
                @include('inc.errorMessages')
                    <div class="con">
                        <div class="t-con">
                            <div class="h4 h-center">
                                اضافة بلد
                            </div>

                        </div>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-md-2 ">
                        {{ Form::label('name', 'البلد', array('class' => 'col-form-label')) }}
                    </div>
                    <div class="col-md-4 {{ $errors->has('name') ? 'has-error' : ''}}">
                        {{ Form::text('name', '', array('class' => 'form-control','required','minlength'=>'"4"')) }}

                    </div>
                    <div class="col-md-2 text-left">
                        {{ Form::label('value', 'القيمه', array('class' => 'col-form-label')) }}
                    </div>
                    <div class="col-md-4 {{ $errors->has('value') ? 'has-error' : ''}}">
                        {{ Form::text('value', '', array('class' => 'form-control','required')) }}

                    </div>
                </div>
                <div class="empty"></div>
                {{ Form::button('التالى <i class="fas fa-caret-left"></i>', ['type' => 'submit', 'class' => 'btn btn-primary pull-left'] )  }}
            </div>
        </div>
    </section>
    <!-- if there are creation errors, they will show here -->







    {{ Form::close() }}


@endsection
