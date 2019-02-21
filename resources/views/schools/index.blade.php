@extends('layouts.app')

@section('custom-content')
    <div class="container">
        <div class="container main-container">
            <div class="col-md-12">
                <!--paneeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeel-->
                <div class="panel panel-green">
                    <div class="panel-heading">
                        <h3 class="text-center"><span class="fa fa-users"></span>&nbsp;&nbsp;المدراس</h3>
                    </div>
                    <div class="panel-body">
                        <br></br>
                        <!-- <table class="lessons" name="tablecontent" id="tablecontent">
                           </table>
                           <div id="jsGrid"></div> -->

                        <!-- will be used to show any messages -->
                        @if (Session::has('message'))
                            <div class="alert alert-info">{{ Session::get('message') }}</div>
                        @endif

                        <div class="row">
                            <table class="table table-striped table-bordered">
                                <thead style="background: #d8d8d8;color: #555655;">
                                <tr>
                                    <td>كود المدرسة</td>
                                    <td>اسم المدرسة</td>
                                    <td>البريد الالكتروني</td>
                                    <td>الحالة</td>

                                    <td>الاجراء</td>

                                </tr>
                                </thead>
                                <tbody>
                                @foreach($schools as $key => $value)

                                    <tr>
                                        <td>{{ $value->id }}</td>
                                        <td>{{ $value->name }}</td>
                                        <td>{{ $value->email }}</td>
                                        <td> @php
                                                $AcountEndDate = new DateTime($value->end_on);
                                                           $Todaydate = new DateTime(date("Y-m-d h:i:sa"));
                                                           if ($AcountEndDate < $Todaydate) {
                                                              $stats="الحساب غير مفعل";
                                                           }
                                            else{
                                                $stats="الحساب مفعل";
                                            }

                                            @endphp
                                        {{$stats}}</td>


                                        <!-- we will also add show, edit, and delete buttons -->
                                        <td>


                                            <!-- show the nerd (uses the show method found at GET /nerds/{id} -->
                                            <a class="btn btn-info"
                                               href="{{url('viewSchool/'.$value->id)}}"><i class="fa fa-desktop"></i>
                                                مشاهدة</a>

                                            <!-- edit this nerd (uses the edit method found at GET /nerds/{id}/edit -->
                                            <a class="btn btn-success "
                                               href="{{url('editSchool/'.$value->id)}}"><i class="fa fa-edit"></i> تعديل</a>

                                            <!-- delete the nerd (uses the destroy method DESTROY /nerds/{id} -->
                                            <!-- we will add this later since its a little more complicated than the other two buttons -->
                                            <a class="btn btn-danger "

                                               href="{{url('SoftDeleteSchool/'.$value->id)}}"><i
                                                        class="fa fa-bell-slash"></i> ايقاف التفعيل  </a>


                                        </td>
                                    </tr>
                                @endforeach

                                </tbody>
                            </table>
                            {{ $schools->links() }}
                        </div>

                        <a class="btn btn-info" href="{{url("addSchool")}}"><i class="fa fa-plus"></i> اضافة مدرسة</a>
                        <a class="btn btn-danger" href="{{url("SuspendedSchools")}}"><i class="fa fa-bell-slash"></i> المدراس
                            الغير مفعلة</a>
                    </div>
                </div>
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
