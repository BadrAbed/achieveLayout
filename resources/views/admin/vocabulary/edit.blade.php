@extends('layouts.app')

@section('content')
    <div class="container">


        <section class="content">
            <div class="container">
                <div class="container main-container">
                    @include("inc.bar")
                    <div class="row form-group text-center">
                        <div class="con">
                            @include("inc.errorMessages")
                            <div class="t-con">
                                <div class="h4 h-center">
                                    تعديل المصطلح
                                </div>
                            </div>
                        </div>
                    </div>

                    <h1>تعديل {{ $vocabularys->word }}</h1>


                    {{ Form::model($vocabularys, array('route' => array('vocabularys.update', $vocabularys->id), 'method' => 'PUT')) }}

                    <div class="row form-group">
                        <div class="col-md-2">

                            {{ Form::label('word', 'مصطلح', array('class' => 'col-form-label')) }}
                        </div>
                        <div class="col-md-4">
                            <div class="ui input  fluid ">

                                {{ Form::text('word', (old('word')?Input::old('word'):$vocabularys->word), array('class' => 'form-control','required')) }}
                            </div>


                        </div>
                        <div class="col-md-2  text-left">
                            {{ Form::label('meaning', 'معني مصطلح', array('class' => 'col-form-label')) }}

                        </div>
                        <div class="col-md-4">
                            <div class="ui input  fluid ">
                                {{ Form::text('meaning', (old('meaning')?Input::old('meaning'):$vocabularys->meaning), array('class' => 'form-control','required')) }}
                            </div>
                        </div>
                    </div>

                    <div class="empty"></div>

                    {{ Form::submit('حفظ التحديثات', array('class' => 'btn btn-primary')) }}
                    <a class="btn pull-left" href="{{url('/show_voc_content/'.$content_id)}}">الرجوع للمصطلحات</a></li>
                    {{ Form::close() }}


                    <br>
                    <br>
                    <br>
                    <br>


                </div>
            </div>
        </section>

    </div>
@endsection