@extends('layouts.app')

@section('custom-content')


    {{ Html::ul($errors->all()) }}

    {{ Form::open(array('url' => 'categories')) }}
    <section class="content">
        <div class="container">
            <div class="container main-container">
                <div class="row form-group text-center">
                    <div class="con">
                        <div class="t-con">
                            <div class="h4 h-center">
                                اضافة تصنيف
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-md-2">
                        {{ Form::label('name', 'اسم التصنيف', array('class' => 'col-form-label')) }}
                    </div>
                    <div class="col-md-4">
                        {{ Form::text('name', '', ['class' => 'form-control','required'=>'true','minlength'=>'"4"']) }}
                        @if ($errors->first('name'))
                            <div class="alert alert-danger ">

                                {{  $errors->first('name')}}

                            </div>
                        @endif

                    </div>

                    <div class="row form-group">
                        <div class="col-md-2 text-left">
                            {{Form::label('parent_id', 'التصنيف ا   يسى')}}
                        </div>
                        <div class="col-md-4">
                            <div class="ui input fluid">
                                <select class="form-control" name="parent_id">
                                    <option value="">--</option>
                                    @foreach($categories_all as $category_all)
                                        <option value="{{$category_all->id}}">{{$category_all->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            @if ($errors->first('parent_id'))
                                <div class="alert alert-danger ">

                                    {{--{{  $errors->first('parent_id')}}--}}

                                </div>
                            @endif
                        </div>
                    </div>

                </div>
                <div class="empty"></div>
                {{ Form::button('التالى <i class="fas fa-caret-left"></i>', ['type' => 'submit', 'class' => 'btn btn-primary pull-left'] )  }}
{{ Form::close() }}
                <div class="row main-container">
                    <div class="well well-lg">
                        <ul class="nav nav-list">
                            @foreach($categories as $category)
                                <li>
                                    <label class="tree-toggler nav-header back ">
                                        <span class="glyphicon glyphicon-folder-close m5"></span>{{$category->name}}
                                    </label>
                                    <div class="operation">
                                        <a class="btn btn-danger">حذف</a>
                                        <a href="{{url("categories")}}/{{$category->id}}/edit" class="btn btn-primary">تعديل</a>
                                    </div>
                                    <ul class="nav nav-list tree" style="display: none">
                                        @foreach($sub_categories[$category->id] as $sub_category)
                                            <li>
                                                <label class="tree-toggler nav-header back">
                                                    <span class="glyphicon glyphicon-folder-close m5"></span>{{$sub_category->name}}
                                                </label>
                                                <div class="operation">
                                                    <a class="btn btn-danger">حذف</a>
                                                    <a href="{{url("categories")}}/{{$sub_category->id}}/edit" class="btn btn-primary">تعديل</a>
                                                </div>
                                                <ul class="nav nav-list tree " style="display: none">
                                                    @foreach($sub_sub_categories[$sub_category->id] as $sub_sub_category)
                                                        <li>
                                                            <a href="#">{{$sub_sub_category->name}}</a>
                                                            <span class="operation-1 pull-left">
                                        <a class="btn btn-danger">حذف</a>
                                        <a href="{{url("categories")}}/{{$sub_sub_category->id}}/edit" class="btn btn-primary">تعديل</a>
                                    </span>
                                                            {{--<ul class="nav nav-list tree" style="display: none">--}}
                                                            {{--<li>--}}
                                                            {{--<a href="#">الفرعية</a>--}}
                                                            {{--<span class="operation-1 pull-left">--}}
                                                            {{--<button class="btn btn-danger">حذف</button>--}}
                                                            {{--<button class="btn btn-primary">تعديل</button>--}}
                                                            {{--</span>--}}
                                                            {{--</li>--}}
                                                            {{--</ul>--}}
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </li>
                                        @endforeach
                                    </ul>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- if there are creation errors, they will show here -->







    {{ Form::close() }}


@endsection
