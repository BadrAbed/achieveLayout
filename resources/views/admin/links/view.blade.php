@extends('layouts.app')

@section('custom-content')
    <div class="container">
        @include("inc.bar")
        <div class="container main-container">
        <div class="panel panel-green"> 
        <div class="panel panel-heading"><h3 class="text-center"><i class="fa fa-edit"></i> تعديل الروابط</h3></div>
        <div class="panel panel-body"> 

            <!-- will be used to show any messages -->
            @if (Session::has('message'))
                <div class="alert alert-info">{{ Session::get('message') }}</div>
            @endif

            <table class="table table-striped table-bordered">
                <thead>
                <tr>
                    <td>الرقم</td>
                    <td>الاسم </td>
                    <td>الرابط</td>
                    <td>اسم الموضوع التابع له الرابط</td>
                    <td>الاجراء</td>
                </tr>
                </thead>
                <tbody>
                @foreach($links as $key => $value)
                    <tr>
                        <td>{{ $value->id }}</td>
                        <td>{{ $value->link }}</td>
                        <td>{!! $value->href  !!} </td>
                        <td>{{ $value->links->content_name }}</td>

                        <!-- we will also add show, edit, and delete buttons -->
                        <td>



                            <!-- show the nerd (uses the show method found at GET /nerds/{id} -->


                            <!-- edit this nerd (uses the edit method found at GET /nerds/{id}/edit -->
                            <a class="btn btn-success " href="{{ URL::to('links/' . $value->id . '/edit') }}"><i class="fa fa-edit"></i> تعديل</a>

                            <!-- delete the nerd (uses the destroy method DESTROY /nerds/{id} -->
                            <!-- we will add this later since its a little more complicated than the other two buttons -->
                            <a class="btn btn-danger " onclick="return confirm('kghjgjhg')" href="{{url('/links/'.$value->id.'/destroy') }}"><i class="fa fa-trash"></i> حذف</a>


                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table><br>
            <a class="btn btn-primary" href="{{url('/create/links/'.$content_id)}}"><i class="fa fa-plus"></i> اضافة رابط</a>
        </div>
    </div>
      </div>
    </div>

@endsection
