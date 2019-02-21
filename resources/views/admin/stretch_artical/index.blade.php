@extends('layouts.app')

@section('custom-content')
<div class="container">
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
@endsection
