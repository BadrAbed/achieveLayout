@extends('layouts.app')

@section('content')
    <div class="row">
        @if(count($photos) > 0)
        @foreach($photos as $photo)
        <div class="col-md-4 col-sm-6">
            <div class="img-box">
                <img src="{{ URL::asset("images/{$photo->filename}") }}">
                <div class="form-group">
                    <input class="form-control" type="text" value="{{ URL::asset("images/{$photo->resized_name}") }}">
                </div>
                <div class="form-group row" style="margin-bottom: 0px">
                    <div class="col-md-8 form-group">
                        <input type="text" class="form-control" value="{{$photo->tags}}" id="tags{{$photo->id}}">
                    </div>
                    <div class="col-md-4 ">
                        <input type="hidden" id="id{{$photo->id}}" value="{{$photo->id}}">
                        <button class="btn btn-block btn-success addTag" id="add{{$photo->id}}" style="padding:9px 23px;">اضافة</button>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
        @else
            <p>لا توجد صور...</p>
        @endif
    </div>



    {{--<div class="table-responsive-sm">--}}
        {{--<table class="table">--}}
            {{--<thead>--}}
            {{--<tr>--}}
                {{--<th scope="col">الصوره</th>--}}
                {{--<th scope="col">اسمها</th>--}}
                {{--<th scope="col">Original Filename</th>--}}
                {{--<th scope="col">Resized Filename</th>--}}
            {{--</tr>--}}
            {{--</thead>--}}
            {{--<tbody>--}}
            {{--@foreach($photos as $photo)--}}
                {{--<tr>--}}
{{--                    <td><img src="/images/{{ $photo->resized_name }}"></td>--}}
                    {{--<td><img src="{{ URL::asset("images/{$photo->resized_name}") }}"></td>--}}
                    {{--<td>{{ $photo->filename }}</td>--}}
                    {{--<td>{{ $photo->original_name }}</td>--}}
                    {{--<td>{{ $photo->resized_name }}</td>--}}
                {{--</tr>--}}
            {{--@endforeach--}}
            {{--</tbody>--}}
        {{--</table>--}}
    {{--</div>--}}
@endsection