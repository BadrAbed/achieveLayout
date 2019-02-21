@php
    $grouped = $users->groupBy('is_permission');


    $groupCount = $grouped->map(function ($item, $key) {
        return collect($item)->count();
    });

$schools=\App\School::all()->count();

@endphp


@extends('layouts.app')
<style type="text/css">
    .page-card {

        display: block;
        text-align: center;
        background: #e9e9e9;
        min-height: 300px;
        border-radius: 20px;
    }

    .page-card h2 {
        text-align: center;
        color: #21ba45;
    }

    .page-card:hover {
        background-color: /* Permalink - use to edit and share this gradient: http://colorzilla.com/gradient-editor/#054f0a+1,299a0b+100 */ background: #054f0a; /* Old browsers */
        background: -moz-linear-gradient(top, #054f0a 1%, #299a0b 100%); /* FF3.6-15 */
        background: -webkit-linear-gradient(top, #054f0a 1%, #299a0b 100%); /* Chrome10-25,Safari5.1-6 */
        background: linear-gradient(to bottom, #054f0a 1%, #299a0b 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
        filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#054f0a', endColorstr='#299a0b', GradientType=0); /* IE6-9 */
        color: #fff !important;
        cursor: pointer;
    }

    .page-card:hover > h4 {

        color: #fff !important;

    }

</style>
@section('custom-content')
    <div class="container">
        <div class="container main-container">
            <div class="col-md-12">
                <!--paneeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeel-->

                <div class="container">
                    <a class="btn btn-primary" href="{{url("users")}}/create"><i class="fa fa-plus"></i> اضافة
                        مستخدم</a>
                    <a class="btn btn-info" href="{{url("addSchool")}}"><i class="fa fa-plus"></i> اضافة مدرسة</a>

                    <a class="btn btn-success" href="{{url("/add/Student")}}"><i class="fa fa-plus"></i> اضافة
                        طالب</a>
                    <br>


                    <h3>المستخدمين :</h3>

                    <div class="row" style="margin-top: 30px;">

                        <div class="col-md-4 ">
                            <a href="{{url('viewAllSchools')}}" style="text-decoration-style: none;">
                                <div class="page-card">
                                    <br>
                                    <br>

                                    <img src="images/school.png">

                                    <h4 style="text-align: center;color:#000;">مدارس <span class="badge"
                                                                                           style="background-color: #21ba45">{{$schools}}</span>
                                    </h4>
                                    <button class="btn btn-success" style="border-radius: 50px;"><i
                                                class="fa fa-users"></i> عرض المستخدمين
                                    </button>
                                    <br>
                                    <!--  <a href="" class="btn btn-success" style="border-radius: 20px;"><i class="fa fa-users"></i> عرض المستخدمين</a> -->
                                </div>
                            </a>
                        </div>
                        <div class="col-md-4 ">
                            <a href="{{url('viewSpecificUsers/'.App\Http\OwnClasses\TYPE_OF_USERS_ENUMS::STUDENT)}}"
                               style="text-decoration-style: none;">
                                <div class="page-card">
                                    <br>
                                    <br>

                                    <img src="images/student.png">

                                    <h4 style="text-align: center;color:#000;">طلاب <span class="badge"
                                                                                          style="background-color: #21ba45">{{ (isset($groupCount[4]))?$groupCount[4]:'0'}}</span>
                                    </h4>
                                    <button class="btn btn-success" style="border-radius: 50px;"><i
                                                class="fa fa-users"></i> عرض المستخدمين
                                    </button>
                                    <br>
                                    <!--  <a href="" class="btn btn-success" style="border-radius: 20px;"><i class="fa fa-users"></i> عرض المستخدمين</a> -->
                                </div>
                            </a>
                        </div>
                        <div class="col-md-4 ">
                            <a href="{{url('viewSpecificUsers/'.App\Http\OwnClasses\TYPE_OF_USERS_ENUMS::PARENT)}}"
                               style="text-decoration-style: none;">
                                <div class="page-card">
                                    <br>
                                    <br>

                                    <img src="images/family.png">

                                    <h4 style="text-align: center;color:#000;">ولي أمر <span class="badge"
                                                                                             style="background-color: #21ba45">{{ (isset($groupCount[5]))?$groupCount[5]:'0'}}</span>
                                    </h4>
                                    <button class="btn btn-success" style="border-radius: 50px;"><i
                                                class="fa fa-users"></i> عرض المستخدمين
                                    </button>
                                    <br>
                                    <!--  <a href="" class="btn btn-success" style="border-radius: 20px;"><i class="fa fa-users"></i> عرض المستخدمين</a> -->
                                </div>
                            </a>
                        </div>


                    </div>
                    <br>
                    <div class="row" style="margin-top: 30px;">

                        @if(auth()->user()->is_permission==\App\Http\OwnClasses\TYPE_OF_USERS_ENUMS::SUPER_ADMIN)
                            <div class="col-md-3 ">
                                <a href="{{url('viewSpecificUsers/'.App\Http\OwnClasses\TYPE_OF_USERS_ENUMS::SUPER_ADMIN)}}"
                                   style="text-decoration-style: none;">
                                    <div class="page-card">
                                        <br>
                                        <br>

                                        <img src="images/networking.png">

                                        <h4 style="text-align: center;color:#000;">الإدارة <span class="badge"
                                                                                                 style="background-color: #21ba45">{{ (isset($groupCount[0]))?$groupCount[0]:'0'}}</span>
                                        </h4>
                                        <button class="btn btn-success" style="border-radius: 50px;"><i
                                                    class="fa fa-users"></i> عرض المستخدمين
                                        </button>
                                        <br>
                                        <!--  <a href="" class="btn btn-success" style="border-radius: 20px;"><i class="fa fa-users"></i> عرض المستخدمين</a> -->
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-3 ">
                                <a href="{{url('viewSpecificUsers/'.App\Http\OwnClasses\TYPE_OF_USERS_ENUMS::LEADER)}}"
                                   style="text-decoration-style: none;">
                                    <div class="page-card">
                                        <br>
                                        <br>

                                        <img src="images/manager.png">

                                        <h4 style="text-align: center;color:#000;">رئيس قسم <span class="badge"
                                                                                                  style="background-color: #21ba45">{{ (isset($groupCount[1]))?$groupCount[1]:'0'}}</span>
                                        </h4>
                                        <button class="btn btn-success" style="border-radius: 50px;"><i
                                                    class="fa fa-users"></i> عرض المستخدمين
                                        </button>
                                        <br>
                                        <!--  <a href="" class="btn btn-success" style="border-radius: 20px;"><i class="fa fa-users"></i> عرض المستخدمين</a> -->
                                    </div>
                                </a>
                            </div>
                        @endif



                            <div class="col-md-3 ">
                                <a href="{{url('viewSpecificUsers/'.App\Http\OwnClasses\TYPE_OF_USERS_ENUMS::EDITOR)}}"
                                   style="text-decoration-style: none;">
                                    <div class="page-card">
                                        <br>
                                        <br>

                                        <img src="images/business-presentation.png">

                                        <h4 style="text-align: center;color:#000;">محرر <span class="badge"
                                                                                              style="background-color: #21ba45">{{ (isset($groupCount[2]))?$groupCount[2]:'0'}}</span>
                                        </h4>
                                        <button class="btn btn-success" style="border-radius: 50px;"><i
                                                    class="fa fa-users"></i> عرض المستخدمين
                                        </button>
                                        <br>
                                        <!--  <a href="" class="btn btn-success" style="border-radius: 20px;"><i class="fa fa-users"></i> عرض المستخدمين</a> -->
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-3 ">
                                <a href="{{url('viewSpecificUsers/'.App\Http\OwnClasses\TYPE_OF_USERS_ENUMS::REVIEWER)}}"
                                   style="text-decoration-style: none;">
                                    <div class="page-card">
                                        <br>
                                        <br>

                                        <img src="images/interview.png">

                                        <h4 style="text-align: center;color:#000;">مراجع فني <span class="badge"
                                                                                                   style="background-color: #21ba45">{{ (isset($groupCount[3]))?$groupCount[3]:'0'}}</span>
                                        </h4>
                                        <button class="btn btn-success" style="border-radius: 50px;"><i
                                                    class="fa fa-users"></i> عرض المستخدمين
                                        </button>
                                        <br>
                                        <!--  <a href="" class="btn btn-success" style="border-radius: 20px;"><i class="fa fa-users"></i> عرض المستخدمين</a> -->
                                    </div>
                                </a>
                            </div>

                    </div>

                    <div class="row" style="margin-top: 30px;">


                        <div class="col-md-3 ">
                            <a href="{{url('viewSpecificUsers/'.App\Http\OwnClasses\TYPE_OF_USERS_ENUMS::QUESTIONEDITOR)}}"
                               style="text-decoration-style: none;">
                                <div class="page-card">
                                    <br>
                                    <br>

                                    <img src="images/business-presentation.png">

                                    <h4 style="text-align: center;color:#000;">مدخل اسئلة<span class="badge"
                                                                                              style="background-color: #21ba45">{{ (isset($groupCount[8]))?$groupCount[8]:'0'}}</span>
                                    </h4>
                                    <button class="btn btn-success" style="border-radius: 50px;"><i
                                                class="fa fa-users"></i> عرض المستخدمين
                                    </button>
                                    <br>
                                    <!--  <a href="" class="btn btn-success" style="border-radius: 20px;"><i class="fa fa-users"></i> عرض المستخدمين</a> -->
                                </div>
                            </a>
                        </div>

                        <div class="col-md-3 ">
                            <a href="{{url('viewSpecificUsers/'.App\Http\OwnClasses\TYPE_OF_USERS_ENUMS::QUESTIONREVIEWER)}}"
                               style="text-decoration-style: none;">
                                <div class="page-card">
                                    <br>
                                    <br>

                                    <img src="images/interview.png">

                                    <h4 style="text-align: center;color:#000;">مراجع اسئلة <span class="badge"
                                                                                              style="background-color: #21ba45">{{ (isset($groupCount[9]))?$groupCount[9]:'0'}}</span>
                                    </h4>
                                    <button class="btn btn-success" style="border-radius: 50px;"><i
                                                class="fa fa-users"></i> عرض المستخدمين
                                    </button>
                                    <br>
                                    <!--  <a href="" class="btn btn-success" style="border-radius: 20px;"><i class="fa fa-users"></i> عرض المستخدمين</a> -->
                                </div>
                            </a>
                        </div>
                        <div class="col-md-3 ">
                            <a href="{{url('viewSpecificUsers/'.App\Http\OwnClasses\TYPE_OF_USERS_ENUMS::AUDIT)}}"
                               style="text-decoration-style: none;">
                                <div class="page-card">
                                    <br>
                                    <br>

                                    <img src="images/evaluation.png">

                                    <h4 style="text-align: center;color:#000;">مصحح لغوى<span class="badge"
                                                                                              style="background-color: #21ba45">{{ (isset($groupCount[6]))?$groupCount[6]:'0'}}</span>
                                    </h4>
                                    <button class="btn btn-success" style="border-radius: 50px;"><i
                                                class="fa fa-users"></i> عرض المستخدمين
                                    </button>
                                    <br>
                                    <!--  <a href="" class="btn btn-success" style="border-radius: 20px;"><i class="fa fa-users"></i> عرض المستخدمين</a> -->
                                </div>
                            </a>
                        </div>

                        <div class="col-md-3 ">
                            <a href="{{url('viewSpecificUsers/'.App\Http\OwnClasses\TYPE_OF_USERS_ENUMS::PUBLISHER)}}"
                               style="text-decoration-style: none;">
                                <div class="page-card">
                                    <br>
                                    <br>

                                    <img src="images/archive.png">

                                    <h4 style="text-align: center;color:#000;">ناشر <span class="badge"
                                                                                          style="background-color: #21ba45">{{ (isset($groupCount[7]))?$groupCount[7]:'0'}}</span>
                                    </h4>
                                    <button class="btn btn-success" style="border-radius: 50px;"><i
                                                class="fa fa-users"></i> عرض المستخدمين
                                    </button>
                                    <br>
                                    <!--  <a href="" class="btn btn-success" style="border-radius: 20px;"><i class="fa fa-users"></i> عرض المستخدمين</a> -->
                                </div>
                            </a>
                        </div>

                    </div>


                </div>
                {{--<div class="panel panel-green">--}}
                {{--<div class="panel-heading">--}}
                {{--<h3 class="text-center"><span class="fa fa-users"></span>&nbsp;&nbsp;المستخدمين</h3>--}}
                {{--</div>--}}
                {{--<div class="panel-body">--}}
                {{--<br></br>--}}
                {{--<!-- <table class="lessons" name="tablecontent" id="tablecontent">--}}
                {{--</table>--}}
                {{--<div id="jsGrid"></div> -->--}}

                {{--<!-- will be used to show any messages -->--}}
                {{--@if (Session::has('message'))--}}
                {{--<div class="alert alert-info">{{ Session::get('message') }}</div>--}}
                {{--@endif--}}

                {{--<div class="row">--}}
                {{--<table class="table table-striped table-bordered">--}}
                {{--<thead style="background: #d8d8d8;color: #555655;">--}}
                {{--<tr>--}}
                {{--<td>كود المستخدم</td>--}}
                {{--<td>اسم المستخدم</td>--}}
                {{--<td>البريد الالكتروني</td>--}}
                {{--<td>صالحية المستخدم</td>--}}
                {{--<td>الاجراء</td>--}}

                {{--</tr>--}}
                {{--</thead>--}}
                {{--<tbody>--}}
                {{--@foreach($users as $key => $value)--}}

                {{--<tr>--}}
                {{--<td>{{ $value->id }}</td>--}}
                {{--<td>{{ $value->name }}</td>--}}
                {{--<td>{{ $value->email }}</td>--}}
                {{--<td>{{Permissions::getPermissionStringByInt($value->is_permission)}}</td>--}}


                {{--<!-- we will also add show, edit, and delete buttons -->--}}
                {{--<td>--}}


                {{--<!-- show the nerd (uses the show method found at GET /nerds/{id} -->--}}
                {{--<a class="btn btn-info"--}}
                {{--href="{{ URL::to('users/' . $value->id) }}"><i class="fa fa-desktop"></i>--}}
                {{--مشاهدة</a>--}}

                {{--<!-- edit this nerd (uses the edit method found at GET /nerds/{id}/edit -->--}}
                {{--<a class="btn btn-success "--}}
                {{--href="{{ URL::to('users/' . $value->id . '/edit') }}"><i--}}
                {{--class="fa fa-edit"></i> تعديل</a>--}}

                {{--<!-- delete the nerd (uses the destroy method DESTROY /nerds/{id} -->--}}
                {{--<!-- we will add this later since its a little more complicated than the other two buttons -->--}}
                {{--<a class="btn btn-danger "--}}
                {{--onclick="return confirm('kghjgjhg')"--}}
                {{--href="{{url('/users/'.$value->id.'/delete') }}"><i--}}
                {{--class="fa fa-trash"></i> حذف</a>--}}


                {{--</td>--}}
                {{--</tr>--}}
                {{--@endforeach--}}

                {{--</tbody>--}}
                {{--</table>--}}
                {{--{{ $users->links() }}--}}
                {{--</div>--}}
                {{--<a class="btn btn-primary" href="{{url("users")}}/create"><i class="fa fa-plus"></i> اضافة--}}
                {{--مستخدم</a>--}}
                {{--<a class="btn btn-info" href="{{url("addSchool")}}"><i class="fa fa-plus"></i> اضافة مدرسة</a>--}}
                {{--<a class="btn btn-success" href="{{url("viewAllSchools")}}"><i class="fa fa-plus"></i> مشاهدة--}}
                {{--المدراس</a>--}}
                {{--</div>--}}
                {{--</div>--}}
            </div>

            <!--paneeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeel-->
        </div>
    </div>
    {{--
<div class="container">

    <div class="container main-container">


        <div class="row form-group text-center">
            <div class="con">
                <div class="t-con">
                    <div class="h4 h-center">
                        المستخدمين
                    </div>
                </div>
            </div>

    <!-- will be used to show any messages -->
    @if (Session::has('message'))
        <div class="alert alert-info">{{ Session::get('message') }}</div>
    @endif

    <table class="table table-striped table-bordered">
        <thead>
        <tr>
            <td>كود المستخدم</td>
            <td>اسم المستخدم</td>
            <td>البريد الالكتروني</td>
            <td>صالحية المستخدم</td>
            <td>الاجراء</td>

        </tr>
        </thead>
        <tbody>
        @foreach($users as $key => $value)

            <tr>
                <td>{{ $value->id }}</td>
                <td>{{ $value->name }}</td>
                <td>{{ $value->email }}</td>
                <td>{{Permissions::getPermissionStringByInt($value->is_permission)}}</td>
             

                <!-- we will also add show, edit, and delete buttons -->
                <td>



                    <!-- show the nerd (uses the show method found at GET /nerds/{id} -->
                    <a class="ui primary basic pull-right ui button" href="{{ URL::to('users/' . $value->id) }}">مشاهدة</a>

                    <!-- edit this nerd (uses the edit method found at GET /nerds/{id}/edit -->
                    <a class="ui positive basic button pull-right ui " href="{{ URL::to('users/' . $value->id . '/edit') }}">تعديل</a>

                    <!-- delete the nerd (uses the destroy method DESTROY /nerds/{id} -->
                    <!-- we will add this later since its a little more complicated than the other two buttons -->
                <a class="ui negative basic button pull-right ui " onclick="return confirm('kghjgjhg')" href="{{url('/users/'.$value->id.'/delete') }}">حذف</a>


                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
  <a class="ui primary basic pull-right ui button" href="{{url("users")}}/create">اضافة مستخدم</a>
    </div>
</div>
--}}
@endsection
