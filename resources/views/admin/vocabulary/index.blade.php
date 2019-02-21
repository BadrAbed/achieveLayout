@extends('layouts.app')

@section('custom-content')
<div class="container">

    <div class="container main-container">

    <h1>المصطلحات</h1>

    <!-- will be used to show any messages -->
    @if (Session::has('message'))
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
        @foreach($vocabularys as $key => $value)
            <tr>
                <td>{{ $value->id }}</td>
                <td>{{ $value->word }}</td>
                <td>{!! $value->meaning  !!} </td>
                <td>{{ $value->content_id }}</td>

                <!-- we will also add show, edit, and delete buttons -->
                <td>



                    <!-- show the nerd (uses the show method found at GET /nerds/{id} -->
                    <a class="ui primary basic pull-right ui button" href="{{ URL::to('vocabularys/' . $value->id) }}">مشاهدة</a>

                    <!-- edit this nerd (uses the edit method found at GET /nerds/{id}/edit -->
                    <a class="ui positive basic button pull-right ui " href="{{ URL::to('vocabularys/' . $value->id . '/edit') }}">تعديل</a>

                    <!-- delete the nerd (uses the destroy method DESTROY /nerds/{id} -->
                    <!-- we will add this later since its a little more complicated than the other two buttons -->
                <a class="ui negative basic button pull-right ui " onclick="return confirm('kghjgjhg')" href="{{url('/vocabularys/'.$value->id.'/delete') }}">حذف</a>


                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
  <a class="ui primary basic pull-right ui button" href="{{url('/vocabularys/create')}}">اضافة مصطلح</a>
    </div>
</div>

@endsection
