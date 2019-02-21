@extends('layouts.app')

@section('custom-content')
    <div class="container">
        <div class="row main-container">
            <div class="panel panel-green">
                <div class="panel-heading">




                    <h3 class="text-center"><span class="fa fa-anchor"></span>&nbsp;&nbsp;الصفوف الدراسية</h3>
                </div>
            </div>
            <div class="panel-body">
                <!-- <table class="lessons" name="tablecontent" id="tablecontent">
                   </table>
                   <div id="jsGrid"></div> -->



                @include('inc.errorMessages')
                @if (Session::has('message'))
                    <div class="alert alert-info">{{ Session::get('message') }}</div>
            @endif
                <!-- <table class="lessons" name="tablecontent" id="tablecontent">
                   </table>
                   <div id="jsGrid"></div> -->
                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <i class="glyphicon glyphicon-indent-right"></i><h5 class="modal-title" id="exampleModalLabel">إضافة مستوى جديد</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body text-right">
                                <div class="col-md-2">
                                    {{ Form::open(array('url' => 'education-level')) }}
                                    <label for="name" class="col-form-label"> المستوى</label>
                                </div>
                                <div class="col-md-3 {{ $errors->has('name') ? 'has-error' : ''}}">
                                    <select class="form-control " name="name">


                                        <option value="أدنى" > أدنى </option>
                                        <option value="متوسط" > متوسط </option>
                                        <option value="متقدم" > متقدم </option>



                                    </select>
                                </div>
                                <div class="row form-group">
                                    <div class="col-md-2">
                                        <label for="parent_id">الصفوف</label>
                                    </div>

                                    <div class="col-md-4 text-right">
                                        <div class="ui input fluid ">
                                            <select class="form-control " name="parent_id" required>
                                                <option value=""> --- </option>
                                                @foreach($educationlevels as $parent)
                                                    <option value="{{$parent->id}}"  > &#10000; {{$parent->name}}  </option>


                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>




                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary" ><i class="glyphicon glyphicon-saved"></i> إضافة مستوى</button>
                                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="glyphicon glyphicon-remove-circle"></i> إلغاء</button>
                            </div>
                            {{ Form::close() }}

                        </div>
                    </div>

                </div>
                <div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <i class="glyphicon glyphicon-indent-right"></i><h5 class="modal-title" id="exampleModalLabel">إضافة صف جديد</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body text-right">
                                <div class="row form-group">
                                    <div class="container">
                                        <div class="col-md-2">
                                            {{ Form::open(array('url' => 'education-level')) }}
                                            <label for="name" class="col-form-label">اسم الصف</label>
                                        </div>
                                        <div class="col-md-3 {{ $errors->has('name') ? 'has-error' : ''}}">
                                            <input class="form-control" name="name" required minlength="4" type="text" value="" id="name">
                                        </div>

                                    </div>
                                </div>
                            </div>




                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary" ><i class="glyphicon glyphicon-saved"></i> إضافة الصف</button>
                                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="glyphicon glyphicon-remove-circle"></i> إلغاء</button>
                            </div>
                            {{ Form::close() }}

                        </div>
                    </div>

                </div>
            <button class="btn btn-md btn-info" type="button" data-toggle="modal" data-target="#exampleModal"><span class="fa fa-plus"></span>&nbsp;إضافة مستوى</button>
                <button class="btn btn-md btn-success" type="button" data-toggle="modal" data-target="#exampleModal2"><span class="fa fa-plus"></span>&nbsp;إضافةصف </button>
          </br>
          </br>

            <div class="well well-lg">
                <ul class="nav nav-list">
                    @foreach($educationlevels as $parent)
                        <li>
                            <label class="tree-toggler nav-header back ">
                                <span class="glyphicon glyphicon-folder-close m5"></span>{{$parent->name}}
                            </label>
                            <div class="operation">
                                <a class="btn btn-danger" data-href="{{"education-level"}}/{{$parent->id}}/delete" data-toggle="modal" data-target="#confirm-delete"><i class="fa fa-trash"></i> حذف</a>
                                <a href="{{url("education-level")}}/{{$parent->id}}/edit" class="btn btn-primary">تعديل</a>
                            </div>
                            <ul class="nav nav-list tree" style="display: none">
                                @if ($parent->children->count())
                                    @foreach ($parent->children as $child)




                                    <li>
                                        <a href="#">{{$child->name}}</a>
                                        <span class="operation-1 pull-left">
                                        <div class="operation">
                                            <a class="btn btn-danger" data-href="{{"education-level"}}/{{$child->id}}/delete" data-toggle="modal" data-target="#confirm-delete"><i class="fa fa-trash" > </i> حذف</a>

                                        </div>

                                    </li>

                                @endforeach
                                @endif
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
                        <p style="margin-right: 80px; color: #9e1317">لا يمكنك المسح توجد دورس لهذا التصنيف  </p>
                        <button class="btn btn-success" data-dismiss="modal">حاول مره اخرى </button>
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



