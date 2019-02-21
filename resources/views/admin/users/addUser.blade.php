@extends('layouts.app')



@section('custom-content')


    <!-- Latest compiled and minified CSS -->

    <!-- Latest compiled and minified CSS -->
    {{ Form::open(array('url' => '/add/Student')) }}
    <section class="content">
        <div class="container">
            <div class="container main-container">
                <div class="panel panel-green">
                    <div class="panel panel-heading">إضافة مستخدم </div>
                    <div class="panel panel-body">
                        @include("inc.errorMessages")
                        <div class="row form-group">
                            <div class="col-md-2">

                                {{ Form::label('name', 'الاسم', array('class' => 'col-form-label')) }}
                            </div>
                            <div class="col-md-4">
                                <div class="ui input  fluid ">

                                    {{ Form::text('name', Input::old('name') , array('class' => 'form-control','required','minlength="4"')) }}
                                </div>

                            </div>


                            <div class="col-md-2">

                                {{ Form::label('email', 'البريد الالكتروني', array('class' => 'col-form-label')) }}
                            </div>
                            <div class="col-md-4">
                                <div class="ui input  fluid ">

                                    {{ Form::email('email', Input::old('email'), array('class' => 'form-control','required')) }}
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
                                    {{ Form::password('password', Input::old('password'), ['class' => 'form-control','required','minlength="6"']) }}
                                </div>
                            </div>

                        </div>


                      <div class="row form-group">

                            <div class="col-md-2">
                                {{ Form::label('countriesList', 'الدول المسموحه', array('class' => 'col-form-label')) }}

                            </div>
                            <div style="z-index: 100" class="col-md-4">

                                <select style="z-index: 100" name="countriesList" id="countries"
                                        class="ui dropdown fluid"  data-live-search="true">
                                    @foreach ($countriesList as  $countryValues)

                                        <option

                                                @if(old("countriesList"))
                                                {{'selected'}}
                                                @endif

                                                value="{{$countryValues->id}}">{{$countryValues->name}}</option>

                                    @endforeach
                                </select>

                            </div>


                            <div class="col-md-2">
                                {{ Form::label('educationLevelList', "المراحل الدراسيه المخصصه", array('class' => 'col-form-label')) }}

                            </div>
                            <div class="col-md-4">

                                <select name="educationLevelList" id="educationLevels" class="ui dropdown fluid"
                                         data-live-search="true">
                                    @foreach ($educationLevels as  $educationLevel)

                                        <option @if(old("educationLevelList"))
                                                {{'selected'}}
                                                @endif
                                                value="{{$educationLevel->id}}">{{$educationLevel->name}}</option>

                                    @endforeach
                                </select>

                            </div>

                        </div>






                        <div class="empty"></div>

                        {{ Form::button('<i class="fas fa-plus"></i>  إضافة المستخدم', ['type' => 'submit', 'class' => 'btn btn-success pull-right'] )  }}
                    </div>
                </div>
            </div>
        </div>


    </section>
    <!-- if there are creation errors, they will show here -->

    {{ Form::close() }}


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







