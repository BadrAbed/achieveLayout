@extends('layouts.app')
@section('custom-content')
    <div class="container">
        <div class="container main-container">
            @include('inc.errorMessages')
            {!! Form::open(['action' => 'LinksController@store', 'method' => 'POST', 'files'=>'true']) !!}
            {{csrf_field()}}
<div id="links">
    <div class="row form-group">
        <div class="col-md-2 ">
            <label for="link">الاسم</label>
        </div>
        <div class="col-md-4 {{ $errors->has('links.*.link') ? 'has-error' : ''}}">
            <input class="form-control " id="link[0]" name="links[0][link]" type="text" value="" required minlength="4">
        </div>
        <div class="col-md-2 text-left">
            <label for="href">الرابط</label>
        </div>
        <div class="col-md-4 {{ $errors->has('links.*.href') ? 'has-error' : ''}}">
            <input class="form-control " id="href[0]" onblur="ckeckhref();" name="links[0][href]" type="url" value=""  required pattern="https?://.+">
        </div>
        <div class="col-md-2">
        </div>
        <div class="col-md-10">
            <br>
            <button id="addLinks" class="btn btn-md btn-primary"><span class="fa fa-link"></span>&nbsp;إضافة رابط</button>
        </div>
    </div>
</div>
            <center><button type="submit" class="btn btn-md  btn-success"><i class="fas fa-caret-left"></i>&nbsp;حفظ </button>
                <a class="btn btn-md btn-danger" href="{{URL::previous()}}"><span class="fa fa-redo"></span>&nbsp;الرجوع إلي السابق</a>
            </center>
            <input type="hidden" name="content_id" value="{{$content_id}}">
            {{ Form::close() }}
<div class="empty"></div>
        </div>
    </div>
    @endsection
