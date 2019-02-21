@extends('layouts.app')



@section('custom-content')


    <!-- Latest compiled and minified CSS -->

    <!-- Latest compiled and minified CSS -->
    <form method="post" action="{{url('addSchool')}}">
        {{csrf_field()}}
        <section class="content">
            <div class="container">
                <div class="container main-container">
                    <div class="panel panel-green">
                        <div class="panel panel-heading">إضافة مدرسة </div>
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
                        <div class="col-md-2">

                            {{ Form::label('password', 'كلمة السر', array('class' => 'col-form-label')) }}
                        </div>
                        <div class="col-md-10">


                            <div class="ui input  fluid ">
                                {{ Form::password('password', Input::old('password'), array('class' => 'form-control','required')) }}
                            </div>
                        </div>

                    </div>


                        <div class="row form-group">
                            <div class="col-md-2">

                                {{ Form::label('numberOfStudents', 'عدد الطلاب', array('class' => 'col-form-label')) }}
                            </div>
                            <div class="col-md-10">


                                <input type="number" value="{{old('numberOfStudents')}}" name="numberOfStudents"
                                       class="form-control" min="0"
                                       onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-2">

                                {{ Form::label('address', 'العنوان', array('class' => 'col-form-label')) }}
                            </div>
                            <div class="col-md-10">


                                <input type="text" required name="address" class="form-control" value="{{old('address')}}">
                            </div>
                        </div>





                <div class="row form-group">

                    <div class="col-md-2">
                        {{ Form::label('countriesList', 'يبدا فى  ', array('class' => 'col-form-label')) }}

                    </div>
                    <div style="z-index: 100" class="col-md-4">

                        <input type="date" required name="starts_on" value="{{old('starts_on')}}">

                    </div>


                    <div class="col-md-2">
                        {{ Form::label('educationLevelList', "ينتهى فى ", array('class' => 'col-form-label')) }}

                    </div>
                    <div class="col-md-4">
                        <input type="date" required name="end_in" value="{{old('end_in')}}">

                    </div>

                </div>

                <div class="row form-group">

                    <div class="col-md-2">
                        {{ Form::label('countriesList', 'الدولة ', array('class' => 'col-form-label')) }}

                    </div>
                    <div style="z-index: 100" class="col-md-4">

                        <select name="countries" id="countries">
                            @foreach ($countriesList as  $countryValues)

                                <option

                                        @if(old("countriesList"))
                                        {{(in_array($countryValues->id,old("countriesList")))?"selected=''":""}}
                                        @endif

                                        value="{{$countryValues->id}}">{{$countryValues->name}}</option>

                            @endforeach
                        </select>

                    </div>


                    <div class="col-md-2">
                        {{ Form::label('educationLevelList', "المراحل الدراسيه المخصصه", array('class' => 'col-form-label')) }}

                    </div>
                    <div class="col-md-4">

                        <select name="educationLevelList[]" id="educationLevels" class="ui dropdown fluid"
                                multiple
                                data-actions-box="true" data-live-search="true">
                            @foreach ($educationLevels as  $educationLevel)

                                <option @if(old("educationLevelList"))
                                        {{(in_array($educationLevel->id,old("educationLevelList")))?"selected=''":""}}
                                        @endif
                                        value="{{$educationLevel->id}}">{{$educationLevel->name}}</option>

                            @endforeach
                        </select>

                    </div>

                </div>


                {{ Form::button('إضافة المدرسة    <i class="fa fa-plus"></i>', ['type' => 'submit', 'class' => 'btn btn-success pull-right'] )  }}

            </div>

                </div>
                </div>
        </section>
        <!-- if there are creation errors, they will show here -->

    </form>


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







