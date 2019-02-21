@extends('layouts.app')

@section('custom-content')
    <div class="container">

        @include("inc.bar")

        <div class="container main-container">
<div class="panel panel-green"> 
        <div class="panel-heading"> <h3 class="text-center"><i class="fa fa-edit"></i> تعديل المصطلحات</h3></div>
        <div class="panel-body"> 

          
            <!-- will be used to show any messages -->
            @if (Session::has('message'))
                <?php Session::forget('messagebar'); ?>

                <div class="alert alert-info">{{ Session::get('message') }}</div>
            @endif


            <table class="table table-striped table-bordered">
                <thead>
                <tr>
                    <td>الرقم</td>
                    <td>المصطلح</td>
                    <td>معني المصطلح</td>
                    <td>رقم الموضوع التابع له المصطلح</td>
                    <td>الاجراء</td>
                </tr>
                </thead>
                <tbody>
                @foreach($vocabularys as $value)
                    <tr>
                        <td>{{ $value->id }}</td>
                        <td>{{ $value->word }}</td>
                        <td>{!! $value->meaning  !!} </td>
                        <td>{{ $value->content_id }}</td>

                        <!-- we will also add show, edit, and delete buttons -->
                        <td>



                                  <!-- show the nerd (uses the show method found at GET /nerds/{id} -->
                            <a class="btn btn-info" href="{{ URL::to('vocabularys/' . $value->id) }}"><i class="fa fa-desktop"></i> مشاهدة</a>

                            <!-- edit this nerd (uses the edit method found at GET /nerds/{id}/edit -->
                            <a class="btn btn-success " href="{{ URL::to('vocabularys/' . $value->id . '/edit') }}"><i class="fa fa-edit"></i> تعديل</a>

                            <!-- delete the nerd (uses the destroy method DESTROY /nerds/{id} -->
                            <!-- we will add this later since its a little more complicated than the other two buttons -->
                            <a class="btn btn-danger " onclick="return confirm('kghjgjhg')" href="{{url('/vocabularys/'.$value->id.'/delete') }}"><i class="fa fa-trash"></i> حذف</a>


                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <a class="btn btn-primary" href="{{url('create/vocabularys/'.$content_id)}}"><i class="fa fa-plus"></i> اضافة مصطلح </a>

            <?php Session::put('messagebar','false') ?>





        </div>
    </div>
        </div>
    </div>

@endsection
