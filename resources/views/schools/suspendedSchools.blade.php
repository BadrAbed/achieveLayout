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

                                    <td>الاجراء</td>

                                </tr>
                                </thead>
                                <tbody>
                                @foreach($schools as $key => $value)

                                    <tr>
                                        <td>{{ $value->id }}</td>
                                        <td>{{ $value->name }}</td>
                                        <td>{{ $value->email }}</td>


                                        <!-- we will also add show, edit, and delete buttons -->
                                        <td>

                                           <a class="btn btn-info "

                                                                                             href="{{url('RestoreDeleteSchool/'.$value->id)}}"><i
                                                        class="fa fa-check"></i> تفعيل </a>

                                            <a class="btn btn-danger "

                                               href="{{url('ForceDeleteSchool/'.$value->id)}}"><i
                                                        class="fa fa-trash"></i> حذف </a>


                                        </td>
                                    </tr>
                                @endforeach

                                </tbody>
                            </table>
                            {{ $schools->links() }}
                        </div>

                        {{--<a class="btn btn-info" href="{{url("addSchool")}}"><i class="fa fa-plus"></i> اضافة مدرسة</a>--}}
                        <a class="btn btn-danger" href="{{url("viewAllSchools")}}"><i class="fa fa-share"></i> رجوع إلي السابق</a>
                    </div>
                </div>
            </div>
            <!--paneeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeel-->
        </div>
    </div>

@endsection
