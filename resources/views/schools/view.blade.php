@extends('layouts.app')



@section('custom-content')


    <!-- Latest compiled and minified CSS -->

    <!-- Latest compiled and minified CSS -->

    <section class="content">
        <div class="container">
            <div class="container main-container">
                <div class="panel panel-green">
                    <div class="panel panel-heading"> {{$school->name}}مدرسة </div>
                    <div class="panel panel-body">

                        <div class="row form-group">
                            <div class="col-md-2">

                                {{ Form::label('name', 'الاسم', array('class' => 'col-form-label')) }}
                            </div>
                            <div class="col-md-4">
                                <div class="ui input  fluid ">

                                    <input value="{{$school->name}}" disabled class="form-control"/>
                                </div>

                            </div>


                            <div class="col-md-2">

                                {{ Form::label('email', 'البريد الالكتروني', array('class' => 'col-form-label')) }}
                            </div>
                            <div class="col-md-4">
                                <div class="ui input  fluid ">

                                    <input value="{{$school->email}}" disabled class="form-control"/>
                                </div>

                            </div>


                        </div>




                        <div class="row form-group">
                            <div class="col-md-2">

                                {{ Form::label('numberOfStudents', 'عدد الطلاب', array('class' => 'col-form-label')) }}
                            </div>
                            <div class="col-md-10">


                                <input value="{{$school->numberOfStudents}}" disabled class="form-control"/>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-2">

                                {{ Form::label('address', 'العنوان', array('class' => 'col-form-label')) }}
                            </div>
                            <div class="col-md-10">


                                <input value="{{$school->address}}" disabled class="form-control"/>
                            </div>
                        </div>






                        <div class="row form-group">

                            <div class="col-md-2">
                                {{ Form::label('countriesList', 'يبدا فى  ', array('class' => 'col-form-label')) }}

                            </div>
                            <div style="z-index: 100" class="col-md-4">

                                <input value="{{$school->start_on}}" disabled class="form-control"/>

                            </div>


                            <div class="col-md-2">
                                {{ Form::label('educationLevelList', "ينتهى فى ", array('class' => 'col-form-label')) }}

                            </div>
                            <div class="col-md-4">
                                <input value="{{$school->end_on}}" disabled class="form-control"/>

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

                                <input value="{{$school->country->name}}" disabled class="form-control"/>

                            </div>


                            <div class="col-md-2">
                                {{ Form::label('educationLevelList', "المراحل الدراسيه المخصصه", array('class' => 'col-form-label')) }}

                            </div>
                            <div class="col-md-4">


                                <select name="educationLevelList[]" id="educationLevels">
                                    @foreach ($educationLevels as  $educationLevel)

                                        <option value="{{$educationLevel->id}}" disabled>{{$educationLevel->name}}</option>

                                    @endforeach
                                </select>


                            </div>

                        </div>

                    </div></div>
                {{-- Show student of School --}}

                @if (auth()->user()->is_permission==\App\Http\OwnClasses\TYPE_OF_USERS_ENUMS::SUPER_ADMIN)

                    <div class="panel panel-green">
                        <div class="panel panel-heading">
                            <h3 class="text-center"><span class="fa fa-users"></span>&nbsp;&nbsp;الطلاب</h3>
                        </div>
                        <div class="panel panel-body">
                            <br></br>
                            <!-- <table class="lessons" name="tablecontent" id="tablecontent">
                               </table>
                               <div id="jsGrid"></div> -->

                            <!-- will be used to show any messages -->
                            @if (Session::has('message'))
                                <div class="alert alert-info">{{ Session::get('message') }}</div>
                            @endif
                            @php

                                    @endphp
                            <div class="row">
                                <table class="table table-striped table-bordered">
                                    <thead style="background: #d8d8d8;color: #555655;">
                                    <tr>
                                        <td>كود المستخدم</td>
                                        <td>اسم المستخدم</td>
                                        <td>البريد الالكتروني</td>
                                        <td>الصف</td>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($users as $key => $value)

                                        <tr>
                                            <td>{{ $value->id }}</td>
                                            <td>{{ $value->name }}</td>
                                            <td>{{ $value->email }}</td>
                                            <td>{{ $value->grade }}</td>

                                            <!-- we will also add show, edit, and delete buttons -->

                                        </tr>
                                    @endforeach

                                    </tbody>
                                </table>
                                {{ $users->links() }}
                            </div>

                            @endif

                            <a class="btn btn-danger" href="{{url("viewAllSchools")}}"><i class="fa fa-share"></i> رجوع إلي السابق </a>
                        </div>




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







