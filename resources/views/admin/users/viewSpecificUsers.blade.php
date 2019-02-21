@extends('layouts.app')

@section('custom-content')

    <div class="container">

        <div class="container main-container">


            <div class="row form-group text-center">
                <div class="panel panel-green">
                    <div class="panel-heading">المستخدمين
                    </div>
                    <div class="panel-body">


                        <!-- will be used to show any messages -->
                        @if (Session::has('message'))
                            <div class="alert alert-info">{{ Session::get('message') }}</div>
                        @endif
                        <br>
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
                                    <td>
                                        @if ($value->is_permission!=\App\Http\OwnClasses\TYPE_OF_USERS_ENUMS::STUDENT)
                                            {{\App\Http\OwnClasses\Permissions::getPermissionStringByInt($value->is_permission)}}
                                        @else
                                            طالب
                                        @endif
                                    </td>


                                    <!-- we will also add show, edit, and delete buttons -->
                                    <td>


                                        <!-- show the nerd (uses the show method found at GET /nerds/{id} -->
                                        <a class="btn btn-info"
                                           href="{{ URL::to('users/' . $value->id) }}"> <i class="fa fa-desktop"></i>
                                            مشاهدة </a>

                                        <!-- edit this nerd (uses the edit method found at GET /nerds/{id}/edit -->
                                        <a class="btn btn-success "
                                           href="{{ URL::to('users/' . $value->id . '/edit') }}"><i
                                                    class="fa fa-edit"></i> تعديل </a>

                                        <!-- delete the nerd (uses the destroy method DESTROY /nerds/{id} -->
                                        <!-- we will add this later since its a little more complicated than the other two buttons -->
                                        <a class="btn btn-danger " onclick="return confirm('kghjgjhg')"
                                           href="{{url('/users/'.$value->id.'/delete') }}"><i class="fa fa-trash"></i>
                                            حذف </a>


                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                            {{$users->links()}}
                        </table>
                        @if ($user_type==App\Http\OwnClasses\TYPE_OF_USERS_ENUMS::STUDENT)
                            <a class="btn btn-primary" href="{{url("/add/Student")}}"><i class="fa fa-plus"></i> اضافة
                                طالب</a>
                        @else
                            <a class="btn btn-primary" href="{{url("users")}}/create"><i class="fa fa-plus"></i> اضافة
                                مستخدم</a>
                        @endif


                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
