@extends('layouts.app')

@section('content')
    <div class="container">


        <section class="content">
            <div class="container">
                <div class="container main-container">
                      
                  <div class="panel panel-green">        
                  <div class="panel-heading"> <h3><i class="fa fa-edit"></i> تعديل  {{ $editGoal->learing_goals_name    }}</h3></div>       
                  <div class="panel-body">

                  @include('inc.errorMessages')
                    

                    <!-- if there are creation errors, they will show here -->


                    {{ Form::model($editGoal, array('route' => array('updategoal', 'id'=>$editGoal->id), 'method' => 'PUT')) }}

                    <div class="row form-group">
                        <div class="col-md-2">

                            {{ Form::label('name', 'الفئة العمرية', array('class' => 'col-form-label')) }}
                        </div>
                        <div class="col-md-4">
                            <div class="ui input  fluid ">

                                {{ Form::text('name',$editGoal->learing_goals_name, array('class' => 'form-control','required','minlength'=>'"4"')) }}
                            </div>


                        </div>

                    </div>

                    <div class="empty"></div>

                    {{ Form::submit('حفظ التحديثات', array('class' => 'btn btn-primary')) }}
                    <a class="btn btn-danger" href="{{url("showgoal")}}"><i class="fa fa-reply"></i> الرجوع الى نواتج التعلم </a></li>
                    {{ Form::close() }}
                </div>

            </div>
        </section></div></div>

    </div>
@endsection