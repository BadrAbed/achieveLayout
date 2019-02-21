@extends('layouts.app')


@section('content')
    <div class="container">


        <section class="content">
            <div class="container">
                <div class="container main-container">
                    <div class="panel panel-green">
                        <div class="panel panel-heading"><h3 class="text-center"><i class="fa fa-edit"></i> تعديل
                                المستخدم</h3></div>
                        <div class="panel panel-body">
                        @include("inc.errorMessages")

                            <!-- if there are creation errors, they will show here -->
                            {{--{{ Html::ul($errors->all()) }}--}}

                            {{ Form::model($users, array('route' => array('users.update', $users->id), 'method' => 'PUT')) }}

                            <div class="row form-group">
                                <div class="col-md-2">

                                    {{ Form::label('name', 'اسم المستخدم', array('class' => 'col-form-label')) }}
                                </div>
                                <div class="col-md-4">
                                    <div class="ui input  fluid ">

                                        {{ Form::text('name', Input::old('name'), array('class' => 'form-control','required','minlength="4"')) }}
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
                                @if ($users->is_permission != \App\Http\OwnClasses\TYPE_OF_USERS_ENUMS::STUDENT)
                                    <div class="col-md-2">
                                        {{ Form::label('is_permission', 'صلاحية المستخدم', array('class' => 'col-form-label')) }}

                                    </div>
                                    <div class="col-md-2">
                                        @if(auth()->user()->is_permission==\App\Http\OwnClasses\TYPE_OF_USERS_ENUMS::SUPER_ADMIN)
                                            {{ Form::select('is_permission', $permissionList,Input::old('is_permission'), array('class' => 'form-control ui dropdown fluid selection')) }}
                                        @else

                                            {{ Form::select('is_permission', $permissionListForleader,Input::old('is_permission'), array('class' => 'form-control ui dropdown fluid selection')) }}
                                        @endif


                                    </div>

                                @endif

                                <div class="col-md-2">

                                    <label class="form-check-label" for="modifyPW">تعديل كلمة السر</label>
                                </div>
                                <div class="col-md-1">


                                    <div class="form-check">
                                        <input type="checkbox" name="modifyPW" onclick="handlePwModification()"
                                               class="form-check-input" id="modifyPW">

                                    </div>

                                </div>


                                <div class="col-md-1">

                                    {{ Form::label('password', 'كلمة السر', array('class' => 'col-form-label')) }}
                                </div>
                                <div class="col-md-3">


                                    <div class="ui input  fluid ">
                                        {{ Form::password('password', array('class' => 'form-control disabledCustom',"id"=>"pw")) }}
                                    </div>
                                </div>


                            </div>

                            @php
                                $country_name='countriesList[]';
                                $grade_name='educationLevelList[]';
                                            $multi='multiple';
                            if ($users->is_permission == \App\Http\OwnClasses\TYPE_OF_USERS_ENUMS::STUDENT){

                                            $multi='';
                            }



                            @endphp
                            <div class="row form-group">

                                <div class="col-md-2">
                                    {{ Form::label('countriesList', 'الدول المسموحه', array('class' => 'col-form-label')) }}

                                </div>
                                <div class="col-md-4">

                                    <select name="{{$country_name}}" data-live-search="true" id="countries"
                                            class="ui dropdown fluid" {{$multi}} data-actions-box="true">

                                        @foreach ($countriesList as  $countryValues)

                                            <option

                                                    @if(old("countriesList"))

                                                    @if(in_array($countryValues->id,old("countriesList")))

                                                    {{"selected=''"}}
                                                    @endif
                                                    @elseif(in_array($countryValues->id,$userRelatedCountriesIDs))
                                                    {{"selected=''"}}

                                                    @endif

                                                    @if ($users->is_permission == \App\Http\OwnClasses\TYPE_OF_USERS_ENUMS::STUDENT && $users->student_country_id==$countryValues->id && count(old("countriesList"))==0)
                                                    {{"selected=''"}}
                                                    @endif
                                                    value="{{$countryValues->id}}">{{$countryValues->name}}</option>

                                        @endforeach
                                    </select>

                                </div>


                                <div class="col-md-2">
                                    {{ Form::label('educationLevelList', "المراحل الدراسيه المخصصه", array('class' => 'col-form-label')) }}

                                </div>
                                <div class="col-md-4">

                                    <select name="{{$grade_name}}" id="educationLevels" class="ui dropdown fluid"
                                            {{$multi}}
                                            data-actions-box="true" data-live-search="true">

                                        @foreach ($educationLevels as  $level)


                                            <option


                                                    @if(old("educationLevelList"))

                                                    @if(in_array($level->id,old("educationLevelList")))

                                                    {{"selected=''"}}
                                                    @endif
                                                    @elseif(in_array($level->id,$userRelatedEducationGradesIDs))
                                                    {{"selected=''"}}
                                                    @endif
                                                    @if ($users->is_permission == \App\Http\OwnClasses\TYPE_OF_USERS_ENUMS::STUDENT && $users->student_grade_id==$level->id && count(old("educationLevelList"))==0)
                                                    {{"selected=''"}}
                                                    @endif
                                                    value="{{$level->id}}">{{$level->name}}</option>

                                        @endforeach
                                    </select>

                                </div>

                            </div>



                            <div class="empty"></div>

                            {{ Form::submit('   حفظ التحديثات', array('class' => 'btn btn-primary')) }}
                            <a class="btn btn-danger" href="{{url("users")}}"><i class="fa fa-reply"></i> الرجوع
                                للمستخدمين</a></li>
                            {{ Form::close() }}
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </div>
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