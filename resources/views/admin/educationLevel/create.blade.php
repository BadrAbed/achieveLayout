@extends('layouts.app')

@section('custom-content')

    


    {{ Form::open(array('url' => 'education-level')) }}
    <section class="content">
        <div class="container">
            <div class="container main-container">
                <div class="row form-group text-center">
                    <div class="con">
                        <div class="t-con">
                            <div class="h4 h-center">
                                اضافة الفئة العمرية
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-md-2">

                        {{ Form::label('name', 'الفئة العمرية', array('class' => 'col-form-label')) }}
                    </div>
                    <div class="col-md-4  ">
                        <div class="ui input  fluid {{ $errors->has('name') ? 'has-error' : ''}}">

                            {{ Form::text('name', Input::old('name'), array('class' => 'form-control')) }}



                    </div>

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
