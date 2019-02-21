@extends('layouts.app')

@section('custom-content')
<div class="container">
    <div class="row main-container">
        <div class="panel panel-green">
        <div class="panel-heading">
            <h3 class="text-center"><span class="fa fa-plus"></span>&nbsp;&nbsp;اضافة تصنيف</h3>
        </div>
        </div>
        <div class="panel-body">
            <!-- <table class="lessons" name="tablecontent" id="tablecontent">
               </table>
               <div id="jsGrid"></div> -->
            <div class="row form-group">
                <div class="container">
                    @include('inc.errorMessages')
                    <div class="col-md-2">

                        {{ Form::open(array('url' => 'categories')) }}
                        <label for="name" class="col-form-label">اسم التصنيف</label>
                    </div>
                    <div class="col-md-3 {{ $errors->has('name') ? 'has-error' : ''}}">
                        <input class="form-control" name="name" type="text" value="" id="name" required minlength="4" >
                    </div>
                    <div class="row form-group">
                        <div class="col-md-2">
                            <label for="parent_id">التصنيفات</label>
                        </div>

                        <div class="col-md-4 text-right">
                            <div class="ui input fluid ">
                                <select class="form-control " name="parent_id">
                                    <option value=""> تصنيف رئيسى </option>
                                    @foreach($categories_all as $parent)
                                       <option value="{{$parent->id}}"  > &#10000; {{$parent->name}}  </option>

                                            @if ($parent->children->count())
                                            @foreach ($parent->children as $child)
                                                    <option value="{{ $child->id }}" >  &emsp; &#9000; &#9000; {{ $child->name }}</option>
                                            @endforeach

                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{ Form::button('حفظ <i class="fas fa-caret-left"></i>', ['type' => 'submit', 'class' => 'btn btn-primary pull-left'] ) }}
            {{ Form::close() }}

        </div>

        <div class="well well-lg">
            <ul class="nav nav-list">
                @foreach($categories as $category)
                <li>
                    <label class="tree-toggler nav-header back ">
                        <span class="glyphicon glyphicon-folder-close m5"></span>{{$category->name}}
                    </label>
                    <div class="operation">
                        <a class="btn btn-danger" data-href="{{"categories"}}/{{$category->id}}/delete" data-toggle="modal" data-target="#confirm-delete"><i class="fa fa-trash"></i> حذف</a>
                        <a href="{{url("categories")}}/{{$category->id}}/edit" class="btn btn-primary">تعديل</a>
                    </div>
                    <ul class="nav nav-list tree" style="display: none">
                        @foreach($sub_categories[$category->id] as $sub_category)
                        <li>
                            <label class="tree-toggler nav-header back">
                                <span class="glyphicon glyphicon-folder-close m5"></span>{{$sub_category->name}}
                            </label>
                            <div class="operation">
                                <a class="btn btn-danger" data-href="{{"categories"}}/{{$sub_category->id}}/delete" data-toggle="modal" data-target="#confirm-delete"><i class="fa fa-trash" > </i> حذف</a>
                                <a href="{{"categories"}}/{{$sub_category->id}}/edit" class="btn btn-primary">تعديل</a>
                            </div>
                            <ul class="nav nav-list tree " style="display: none">
                                @foreach($sub_sub_categories[$sub_category->id] as $sub_sub_category)
                                    <li>
                                        <a href="#">{{$sub_sub_category->name}}</a>
                                        <span class="operation-1 pull-left">
                                        <a class="btn btn-danger" data-href="{{"categories"}}/{{$sub_sub_category->id}}/delete" data-toggle="modal" data-target="#confirm-delete"><i class="fa fa-trash"></i> حذف</a>
                                        <a href="{{"categories"}}/{{$sub_sub_category->id}}/edit" class="btn btn-primary">تعديل</a>
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
@if(Session::has('alert'))

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <div id="myModal" class="modal fade">
        <div class="modal-dialog modal-confirm">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="icon-box">
                        <i class="material-icons">&#xE5CD;</i>
                    </div>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body text-center">
                    <h4>Ooops!</h4>
                    <p style="margin-right: 80px; color: #9e1317"> {{Session::get('alert')}} </p>
                    <button class="btn btn-success" data-dismiss="modal">رجوع </button>
                </div>
            </div>
        </div>
    </div>
    </div>

    <script>


        $("#myModal").modal();

    </script>
@endif

<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">تاكيد المسح</h4>
            </div>

            <div class="modal-body">
                <p>هل تريد المسح؟ </p>
                <p class="debug-url"></p>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">الغاء</button>
                <a class="btn btn-danger btn-ok">مسح</a>
            </div>
        </div>
    </div>
</div>

@section('OldJqueryVersion')
    <script data-require="jquery@*" data-semver="2.0.3" src="http://code.jquery.com/jquery-2.0.3.min.js"></script>

    <script>
        $('#confirm-delete').on('show.bs.modal', function(e) {
            $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));


        });

    </script>
@endsection
@endsection
