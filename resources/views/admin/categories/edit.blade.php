@extends('layouts.app')

@section('custom-content')




    {!! Form::open(['action' => ['CategoriesController@update', $category_selected->id], 'method' => 'PUT']) !!}

    <section class="content">
        <div class="container">
            <div class="container main-container">

                  <div class="panel panel-green">        
                  <div class="panel-heading"> <h3><i class="fa fa-plus"></i> إضافة تصنيف  </h3></div>       
                  <div class="panel-body">
                      @include('inc.errorMessages')
                <div class="row form-group">
                    <div class="col-md-2">
                        {{ Form::label('name', 'اسم التصنيف', array('class' => 'col-form-label')) }}
                    </div>
                    <div class="col-md-4">
                        {{ Form::text('name', $category_selected->name, array('class' => 'form-control','required'=>'required', 'minlength'=>"4")) }}
                    </div>
                    <div class="row form-group">
                        <div class="col-md-2 text-left">
                            {{Form::label('parent_id', 'التصنيف الرئيسى')}}
                        </div>
                        <div class="col-md-4">
                            <div class="ui input fluid">
                                <select class="form-control" name="parent_id">
                                     <option value="">--</option> 
                                    <option value="main"
                                    @if($category_selected->parent_id == null )    
                                                {{'selected'}}
                                            @endif
                                    >تصنيف رئيسئ</option>
                                    @foreach($categories_all as $parent)
                                        <option value="{{$parent->id}}" 
                                            @if($category_selected->parent_id == $parent->id )
                                            {{'selected'}}
                                            @endif
                                            > &#10000; {{$parent->name}}  </option>

                                        @if ($parent->children->count())
                                            @foreach ($parent->children as $child)
                                                <option value="{{ $child->id }}" 
                                                @if($category_selected->parent_id == $child->id )    
                                                {{'selected'}}
                                            @endif
                                            >  &emsp; &#9000; &#9000; {{ $child->name }}</option>
                                            @endforeach

                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="empty"></div>
                {{ Form::button('التالى <i class="fa fa-share"></i>', ['type' => 'submit', 'class' => 'btn btn-success'] )  }}
            </div>

        </div>
    </section>
    <!-- if there are creation errors, they will show here -->

    {{ Form::close() }}


@endsection
