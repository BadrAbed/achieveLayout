@extends('layouts.app')

@section('content')
<div class="container">


        <section class="content">
            <div class="container">
                <div class="container main-container">
                   
                  <div class="panel panel-green">        
                  <div class="panel-heading"> <h3><i class="fa fa-edit"></i> تعديل  {{ $country->name }}</h3></div>       
                  <div class="panel-body">

                      @include("inc.errorMessages")
                     
   



    {{ Form::model($country, array('route' => array('country.update', $country->id), 'method' => 'PUT')) }}
        <div class="row form-group">
            <div class="col-md-2">
                {{ Form::label('name', 'البلد', array('class' => 'col-form-label')) }}
            </div>
            <div class="col-md-4">
                {{ Form::text('name', $country->name, array('class' => 'form-control','required','minlength'=>'"4"')) }}
            </div>
            <div class="col-md-2">
                {{ Form::label('value', 'القيمه', array('class' => 'col-form-label')) }}
            </div>
            <div class="col-md-4">
                {{ Form::text('value', $country->value , array('class' => 'form-control','required')) }}
            </div>
        </div>
        <div class="empty"></div>
    {{ Form::submit('حفظ التحديثات', array('class' => 'btn btn-primary')) }}
             <a class="btn btn-danger" href="/country"><i class="fa fa-reply"></i> الرجوع لقائمة الدول</a></li>
    {{ Form::close() }}
                </div>

            </div>
            </div>
            </div>
        </section>

</div>
@endsection