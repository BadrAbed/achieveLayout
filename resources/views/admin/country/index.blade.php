@extends('layouts.app')

@section('custom-content')
    <div class="container">
        <div class="container main-container">
            <div class="col-md-12">
                <!--paneeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeel-->
                <div class="panel panel-green">
                    <div class="panel-heading">
                        <h3 class="text-center"><span class="fa fa-flag"></span>&nbsp;&nbsp;البلاد</h3>
                    </div>
                    <div class="panel-body">
                        <br></br>
                        <!-- <table class="lessons" name="tablecontent" id="tablecontent">
                           </table>
                           <div id="jsGrid"></div> -->
                        @if(session("message"))
                            <div class="alert alert-info">{{session("message")}}</div>

                        @endif
                        <div class="row">
                            <table class="table table-striped table-bordered">
                                <thead style="background: #d8d8d8;color: #555655;">
                                <tr>
                                    <td>الرقم</td>
                                    <td>البلد</td>
                                    <td>القيمه</td>
                                    <td>الاجراء</td>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($countrys as $country)
                                    <tr>
                                        <td>{{$country->id}}</td>
                                        <td>{{$country->name}}</td>
                                        <td>{{$country->value}}</td>
                                        <!-- we will also add show, edit, and delete buttons -->
                                        <td>
                                            <!-- edit this nerd (uses the edit method found at GET /nerds/{id}/edit -->
                                            <a class="btn btn-success " href="{{url("country/".$country->id."/edit")}}"><i
                                                        class="fa fa-edit"></i> تعديل</a>
                                            <a class="btn btn-danger" data-href="{{url("country/".$country->id."/delete")}}" data-toggle="modal" data-target="#confirm-delete">
                                                <i class="fa fa-trash"></i> حذف
                                            </a>
                                            <!-- delete the nerd (uses the destroy method DESTROY /nerds/{id} -->
                                            <!-- we will add this later since its a little more complicated than the other two buttons -->
                                        </td>
                                    </tr>





                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <a class="btn btn-info" href="{{url("country/create")}}"><i class="fa fa-flag"></i> اضافة بلد
                            أخري</a>
                    </div>
                </div>
            </div>
            <!--paneeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeel-->
        </div>
    </div>


    @if(Session::has('alert'))

        {{--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>--}}
        {{--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>--}}
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
                        <p style="margin-right: 80px; color: #9e1317">لا يمكنك المسح توجد دورس لهذا البد </p>
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


{{--

    @if (Session::has('message'))
        <div class="alert alert-info">{{ Session::get('message') }}</div>
    @endif

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
                        <p style="margin-right: 80px; color: #9e1317">لا يمكنك المسح توجد دورس لهذا البد </p>
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
<div class="container">

    <div class="container main-container">

    <h1>البلاد</h1>

    <!-- will be used to show any messages -->

    <table class="table table-striped table-bordered">
        <thead>
        <tr>
            <td>الرقم</td>
            <td>البلد</td>
            <td>القيمه</td>
            <td>الاجراء</td>
        </tr>
        </thead>
        <tbody>
        @foreach($countrys as $key => $value)
            <tr>
                <td>{{ $value->id }}</td>
                <td>{{ $value->name }}</td>
                <td>{{ $value->value }}</td>
                <!-- we will also add show, edit, and delete buttons -->
                <td>
                <!-- edit this nerd (uses the edit method found at GET /nerds/{id}/edit -->
                    <a class="ui positive basic button pull-right ui " href="{{ URL::to('country/' . $value->id . '/edit') }}">تعديل</a>

                    <a class="ui negative basic button pull-right ui "  href="{{url('/country/'.$value->id.'/delete') }}">حذف</a>
                    <!-- delete the nerd (uses the destroy method DESTROY /nerds/{id} -->
                    <!-- we will add this later since its a little more complicated than the other two buttons -->
                    {{--{{ Form::open(array('url' => 'country/' . $value->id, 'class' => 'pull-right')) }}--}}
{{--{{ Form::hidden('_method', 'DELETE') }}--}}
{{--{{ Form::submit('حذف', array('class' => 'ui negative basic button')) }}--}}
{{--{{ Form::close() }}--}}
{{--
</td>
</tr>
@endforeach
</tbody>
</table>
<a class="ui primary basic pull-right ui button" href="{{ URL::to('country/create') }}">اضافة بلد</a>
</div>
</div>


--}}
