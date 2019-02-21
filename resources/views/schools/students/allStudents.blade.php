@extends('layouts.app')
<style type="text/css">
    .nav02 {
        position: relative;
        min-height: 150px !important;
        background: url({{url("images/nav2bg3.jpg")}}) no-repeat !important;
        background-attachment: fixed;
        background-size: contain;
    }

    ul li.head_title h2 {
        display: none !important;
    }
</style>
@section('custom-content')
    <div class="container">
        <div class="container main-container">
            <div class="col-md-12">
                <!--paneeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeel-->
                <div class="panel panel-green">
                    <div class="panel-heading">
                        <h3 class="text-center"><span class="fa fa-users"></span>&nbsp;&nbsp;المستخدمين</h3>
                    </div>
                    <div class="panel-body">
                        <br>
                        <!-- <table class="lessons" name="tablecontent" id="tablecontent">
                           </table>
                           <div id="jsGrid"></div> -->

                        <!-- will be used to show any messages -->

                        @if (Session::has('message'))
                            <div class="alert alert-info">{{ Session::get('message') }}</div>
                        @endif

                        @include('inc.errorMessages')
                        @php
                            session()->forget('errors');
                        @endphp
                        <div class="row">
                            <table class="table table-striped table-bordered">
                                <thead style="background: #d8d8d8;color: #555655;">
                                <tr>
                                    <td>كود المستخدم</td>
                                    <td>اسم المستخدم</td>
                                    <td>البريد الالكتروني</td>
                                    <td>الصف</td>

                                    <td>الاجراء</td>

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
                                        <td>


                                            <!-- show the nerd (uses the show method found at GET /nerds/{id} -->
                                            <!-- edit this nerd (uses the edit method found at GET /nerds/{id}/edit -->
                                            <a class="btn btn-success "
                                               href="{{ URL::to('SchoolEditStudent/' . $value->id ) }}"><i
                                                        class="fa fa-edit"></i> تعديل</a>

                                            <!-- delete the nerd (uses the destroy method DESTROY /nerds/{id} -->
                                            <!-- we will add this later since its a little more complicated than the other two buttons -->
                                            <a class="btn btn-danger "
                                               onclick="return confirm('kghjgjhg')"
                                               href="{{url('/deleteStudent/'.$value->id) }}"><i
                                                        class="fa fa-trash"></i> حذف</a>
                                            <a class="btn btn-primary"
                                               href="{{url('FollowStudentInSchool/'.$value->id)}}"><i
                                                        class="fa fa-desktop"></i> متابعة</a>

                                        </td>
                                    </tr>
                                @endforeach

                                </tbody>
                            </table>
                            {{ $users->links() }}
                        </div>
                        <a class="btn btn-primary" href="{{url("SchoolAddStudent")}}"> <i class="fa fa-plus"></i> اضافة
                            مستخدم</a>

                        <span class="dropdown">
                          <a class="btn btn-success dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown"
                             aria-haspopup="true" aria-expanded="false">
                           <i class="fa fa-upload"></i>  رفع و تحميل ملفات الطلبة <i class="fa fa-caret-down"></i>
                          </a>
                          <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item btn btn-info" style="display: block;margin-bottom: 10px;"
                               href="{{url("getCSVFileForStudent")}}"><i
                                        class="fa fa-download"></i> تحميل CSV للطلبة</a>
                                <a class="dropdown-item btn btn-success" style="display: block;margin-bottom: 10px;"
                                   href="{{url("downloadEmptyCSVFile")}}"> <i class="fa fa-download"></i> تحميل CSV فارغ</a>
                            <a class="dropdown-item btn btn-info" style="display: block;margin-bottom: 10px;"
                               data-toggle="modal" data-target="#myModal"><i class="fa fa-upload"></i> تسجيل مجموعة طلبة</a>
                            <a class="dropdown-item btn btn-success" style="display: block;margin-bottom: 10px;"
                               href="{{url("downloadLevelsCSVFile")}}"> <i class="fa fa-download"></i> تحميل CSV لارقام صفوف الطلاب</a>
                          </div>
                        </span>


                    </div>
                </div>
            </div>


            <!-- Modal -->
            <div class="modal fade" id="myModal" role="dialog">
                <div class="modal-dialog">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">تسجيل مجموعة طلبة</h4>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="{{url('uploadCSVFileFormSchool')}}"
                                  enctype="multipart/form-data" >
                                {{csrf_field()}}
                                <input type="file" name="filename" accept=".csv,.xlsx"/>
                                <br>
                                {{ Form::button('رفع الملف <i class="fa fa-upload"></i>', ['type' => 'submit', 'class' => 'btn btn-info '] )  }}
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        </div>
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
