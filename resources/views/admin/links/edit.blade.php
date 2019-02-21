@extends('layouts.app')

@section('content')
    <div class="container">


        <section class="content">
            <div class="container">
                <div class="container main-container">
                    @include("inc.bar")
                    <div class="row form-group text-center">
                        <div class="con">
                            <div class="t-con">
                                <div class="h4 h-center">
                                    تعديل الرابط
                                </div>
                            </div>
                        </div>
                    </div>

                    <h1>تعديل  {{ $links->link }}</h1>

                    <!-- if there are creation errors, they will show here -->
                    @include('inc.errorMessages')

                    {{ Form::model($links, array('route' => array('links.update', $links->id), 'method' => 'PUT')) }}

                    <div class="row form-group">
                        <div class="col-md-2">

                            {{ Form::label('link', 'الاسم ', array('class' => 'col-form-label')) }}
                        </div>
                        <div class="col-md-4">
                            <div class="ui input  fluid ">

                                {{ Form::text('link', Input::old('link'), array('class' => 'form-control','required','minlength'=>'"4"')) }}
                            </div>


                        </div>
                        <div class="col-md-2  text-left">
                            {{ Form::label('href', 'الرابط', array('class' => 'col-form-label')) }}

                        </div>
                        <div class="col-md-4">
                            <div class="ui input  fluid ">
                                {{ Form::text('href', Input::old('href'), array('class' => 'form-control',' required','pattern="https?://.+"')) }}
                            </div>
                        </div>
                    </div>

                    <div class="empty"></div>

                    {{ Form::submit('حفظ التحديثات', array('class' => 'btn btn-primary')) }}
                    <a class="btn pull-left" href="{{url('links/'.$content_id)}}">الرجوع للروابط</a></li>
                    {{ Form::close() }}
                </div>
            </div>
        </section>

    </div>
@endsection