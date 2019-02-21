@extends('layouts.app')



@section('custom-content')


    <!-- Latest compiled and minified CSS -->

    <!-- Latest compiled and minified CSS -->
    <form method="post" action="{{url('editSchool/'.$school->id)}}">
        {{csrf_field()}}
        <section class="content">
            <div class="container">
                <div class="container main-container">
                    <div class="panel panel-green">
                        <div class="panel panel-heading"> {{$school->name}}تعديل المدرسة</div>
                        <div class="panel panel-body">
                            @include("inc.errorMessages")
                    @if (Session::has('message'))
                        <div class="alert alert-info">{{ Session::get('message') }}</div>
                    @endif
                    <div class="row form-group">
                        <div class="col-md-2">

                            {{ Form::label('name', 'الاسم', array('class' => 'col-form-label')) }}
                        </div>
                        <div class="col-md-4">
                            <div class="ui input  fluid ">

                                {{ Form::text('name', $school->name , array('class' => 'form-control')) }}
                            </div>

                        </div>


                        <div class="col-md-2">

                            {{ Form::label('email', 'البريد الالكتروني', array('class' => 'col-form-label')) }}
                        </div>
                        <div class="col-md-4">
                            <div class="ui input  fluid ">

                                {{ Form::email('email', $school->email, array('class' => 'form-control')) }}
                            </div>

                        </div>


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

                                {{ Form::label('numberOfStudents', 'عدد الطلاب', array('class' => 'col-form-label')) }}
                            </div>
                            <div class="col-md-10">


                                <input type="number" value="{{$school->numberOfStudents}}" name="numberOfStudents"
                                       class="form-control" min="0"
                                       onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-2">

                                {{ Form::label('address', 'العنوان', array('class' => 'col-form-label')) }}
                            </div>
                            <div class="col-md-10">


                                <input type="text" name="address" class="form-control" value="{{$school->address}}">
                            </div>
                        </div>





                <div class="row form-group">

                    <div class="col-md-2">
                        {{ Form::label('countriesList', 'يبدا فى  ', array('class' => 'col-form-label')) }}

                    </div>
                    <div style="z-index: 100" class="col-md-4">

                        <input type="date" name="starts_on" value="{{date('Y-m-d',strtotime($school->start_on))}}">

                    </div>


                    <div class="col-md-2">
                        {{ Form::label('educationLevelList', "ينتهى فى ", array('class' => 'col-form-label')) }}

                    </div>
                    <div class="col-md-4">
                        <input type="date" name="end_in" value="{{date('Y-m-d',strtotime($school->end_on))}}">

                    </div>

                </div>
                <div class="row form-group">
                    <div class="col-md-2">

                        {{ Form::label('password', ' المتبقى على الانتهاء', array('class' => 'col-form-label')) }}
                    </div>
                    <div class="col-md-10">

                        @php
                            $AcountEndDate = new DateTime($school->end_on);
                                       $Todaydate = new DateTime(date("Y-m-d h:i:sa"));
                                       if ($AcountEndDate < $Todaydate) {
                                          $remain="الحساب غير مفعل";
                                       }
                        else{
                        $diff=$Todaydate->diff($AcountEndDate);

                        $remainYears=$diff->format('%Y');
                        $remainMonths=$diff->format('%M');
                        $remainDays=$diff->format('%D');
$remain=$remainYears.'years-'.$remainMonths.'month-'.$remainDays.'Days';
                        }

                        @endphp
                        <div class="ui input  fluid ">
                            <input style="font-size: 20px" value="{{$remain }}" disabled
                                   class="form-control"/>
                        </div>
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


                                        {{($countryValues->id==$school->countries)?"selected=''":""}}


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

                                <option
                                        @if(count($grades_id)>0)
                                        {{(in_array($educationLevel->id,$grades_id))?"selected=''":""}}
                                                @else
                                        selected
                                        @endif
                                        value="{{$educationLevel->id}}">{{$educationLevel->name}}</option>

                            @endforeach
                        </select>

                    </div>

                </div>


                {{ Form::button('حفظ التعديل <i class="fas fa-check"></i>', ['type' => 'submit', 'class' => 'btn btn-info pull-right'] )  }} &nbsp;
                <a class="btn btn-danger" href="{{url("viewAllSchools")}}"><i class="fa fa-share"></i> رجوع إلي السابق </a>
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







