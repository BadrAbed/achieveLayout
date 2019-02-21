@extends('layouts.app')



@section('custom-content')


    <!-- Latest compiled and minified CSS -->

    <!-- Latest compiled and minified CSS -->

    <section class="content">

        <div class="container">


            <div class="container main-container">

                <div class="row form-group text-center">
                    <div class="con">
                        <div class="t-con">
                            @include("inc.errorMessages")
                            <div class="h4 h-center">
                                اضافة طالب
                            </div>
                        </div>
                    </div>
                </div>
                @if (Session::has('message'))
                    <div class="alert alert-info">{{ Session::get('message') }}</div>
                @endif
                <form method="post" action="{{url('SchoolEditStudent/'.$student->id)}}">
                    {{csrf_field()}}
                    <div class="row form-group">
                        <div class="col-md-2">

                            {{ Form::label('name', 'الاسم', array('class' => 'col-form-label')) }}
                        </div>
                        <div class="col-md-4">
                            <div class="ui input  fluid ">

                                {{ Form::text('name',$student->name , array('class' => 'form-control')) }}
                            </div>

                        </div>


                        <div class="col-md-2">

                            {{ Form::label('email', 'البريد الالكتروني', array('class' => 'col-form-label')) }}
                        </div>
                        <div class="col-md-4">
                            <div class="ui input  fluid ">

                                {{ Form::email('email', $student->email, array('class' => 'form-control')) }}
                            </div>

                        </div>


                    </div>
                    <div class="row form-group">


                    </div>
                    <div class="row form-group">
                        <div class="col-md-2">

                            {{ Form::label('password', 'كلمة السر', array('class' => 'col-form-label')) }}
                        </div>
                        <div class="col-md-10">


                            <div class="ui input  fluid ">
                                {{ Form::password('password', Input::old('password'), array('class' => 'form-control')) }}
                            </div>
                        </div>

                    </div>


                    <div class="row form-group">

                        <div class="col-md-2">
                            {{ Form::label('educationLevelList', "المراحل الدراسيه المخصصه", array('class' => 'col-form-label')) }}

                        </div>
                        <div class="col-md-4">

                            <select name="educationLevel" id="educationLevels">
                                @foreach ($educationLevels as  $educationLevel)

                                    <option
                                            {{($educationLevel->id==$student->student_grade_id)?"selected=''":""}}

                                            value="{{$educationLevel->id}}">{{$educationLevel->name}}</option>

                                @endforeach
                            </select>

                        </div>

                    </div>


                    <div class="empty"></div>

                {{ Form::button('التالى <i class="fas fa-caret-left"></i>', ['type' => 'submit', 'class' => 'btn btn-primary pull-left'] )  }}
                {{ Form::close() }}
            </div>

        </div>

    </section>
    <!-- if there are creation errors, they will show here -->




@endsection

@section("customBootstrapJS")

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
            integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
            crossorigin="anonymous"></script>
@endsection


@section("CustomContentAfterGeneralJquery")

    {{-- include styles and javascript of bootstrap multiple select--}}


    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/css/bootstrap-select.min.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/js/bootstrap-select.min.js"></script>


    <script>
        $(document).ready(function () {
            $('#countries').selectpicker({});
            $('#educationLevels').selectpicker({});
        });
    </script>

@endsection







