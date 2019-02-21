@extends('layouts.app')

@section('custom-content')
    <div class="container">

        <div class="container main-container">

            <div class="panel panel-green">

                <div class="panel-heading">
                    <h3 class="text-center"><span class="fa fa-eye-slash"></span>&nbsp;&nbsp;محتويات لم تكتمل بعد</h3>
                </div>
                <div class="col-md-2">

                </div>


                <br> </br>
                <div id="messagediv"></div>
                <!-- will be used to show any messages -->
                @if (Session::has('message'))
                    <div class="alert alert-info">{{ Session::get('message') }}</div>
                @endif
                <div class="panel-body">
                    <div class="row">

                        <a class="btn btn-info"
                           href="{{ URL::to('content/create') }}"><i
                                    class="fa fa-plus"></i> اضافة محتوى</a>


                        <a class="btn btn-danger" value="Delete Row"
                           onclick="deleteRow('dataTable')"><i
                                    class="fa fa-plus"></i> مسح المحدد</a>


                    </div>
                    <div class="row">

                        <table class="table table-striped table-bordered" id="iddata">

                            <thead>
                            <tr>
                                <th><input type="checkbox" onchange="checkAll()" name="chk[]"/></th>
                                <th>اسم المحتوي</th>
                                <th>الفئة العمرية</th>
                                <th>البلد</th>
                                <th>الكاتب</th>
                                <th>الاجراء</th>
                                <th>ملاحضات</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($contents as  $content)

                                @if(empty($content_vocab->content_id) || empty($content_normal->content_id) || empty($content_strach->content_id)  )
                                    <tr>
                                        <td><input type="checkbox" name="chkbox[]"/></td>
                                        <td>{{ $content->content_name }}</td>
                                        <td>{{ $content->grade->name }}</td>
                                        <td hidden>{{$content->id}}</td>
                                        <td> @if($content->countries!=null){{ $content->country->name }} @else
                                                عام @endif </td>
                                        <td>{{ $content->user->name }}</td>
                                        <!-- we will also add show, edit, and delete buttons -->
                                        <td  style="width: 200px">
                                            <!-- show the nerd (uses the show method found at GET /nerds/{id} -->

                                            <!-- edit this nerd (uses the edit method found at GET /nerds/{id}/edit -->
                                            <a class="btn btn-success "
                                               href="{{ URL::to('content/' . $content->id . '/edit') }}"><i
                                                        class="fa fa-edit"></i> تعديل</a>
                                            <!-- delete the nerd (uses the destroy method DESTROY /nerds/{id} -->
                                            <!-- we will add this later since its a little more complicated than the other two buttons -->
                                            <a class="btn btn-danger"
                                               data-href="{{url('/content/'.$content->id.'/delete') }}"
                                               data-toggle="modal" data-target="#confirm-delete">
                                                <i class="fa fa-trash"></i> حذف
                                            </a>
                                        </td>
                                        <td style="width: 500px">
                                            @foreach($content->vocab as $vocab)
                                            @endforeach
                                            @if(empty($vocab->content_id))
                                                <?php Session::put('content_id', $content->id); ?>
                                                <span class="thead-title"><a class="btn btn-info"
                                                                             href="{{URL::to('show_voc_content/'.$content->id)}}">اضف معانى الكلمات </a> </span>

                                            @endif

                                            @if(empty($content->articalnormal->content_id))
                                                <span class="thead-title"><a class="btn btn-success"
                                                                             href="{{URL::to('normal-artical/'.$content->id.'/edit')}}">تعديل المقال المختصر  </a></span>

                                            @endif


                                                @if(empty($content->articalstrach->content_id))
                                                    <span class="thead-title">
                                                <a class="btn btn-success"
                                                   href="{{URL::to('stretch-artical/'.$content->id.'/edit')}}"> تعديل
                                                    المقال الموسع</a>
                                                    </span>
                                                @endif


                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                            </tbody>


                            <br></br>


                        </table>

                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
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
        $('#confirm-delete').on('show.bs.modal', function (e) {
            $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));


        });

        function checkAll() {


            var checkboxes = document.getElementsByTagName('input');

            var val = null;
            for (var i = 0; i < checkboxes.length; i++) {
                if (checkboxes[i].type == 'checkbox') {
                    if (val === null) val = checkboxes[i].checked;
                    {
                        checkboxes[i].checked = val;
                    }
                }

            }
            //  console.log(data);
        }

        function deleteRow(iddata) {
            var table = document.getElementById("iddata");
            var rowCount = table.rows.length;
            data = [];

            for (var i = 1; i < rowCount; i++) {
                var row = table.rows[i];
                var chkbox = row.cells[0].children[0];
                if (chkbox != null && chkbox.checked == true) {
                    // table.deleteRow(i);

                    data.push(document.getElementById("iddata").rows[i].cells.item(3).innerText);
                    // rowCount--;
                    // i--;
                }
            }
            if (confirm('هل تريد المسح ؟')) {
                $.ajax({

                    type: 'GET',
                    url: '{{url("delteseleteccontent")}}/?data=' + data + '+&length=' + data.length + '',

                    success: function (data) {

                        setTimeout(function () {// wait for 5 secs(2)
                            location.reload(); // then reload the page.(3)
                        }, 10);

                        $("#messagediv").append('<div class="alert alert-info">' + ' تم المسح بنجاح' + '</div>');
                    }
                })
            }
        }
    </script>
@endsection
@endsection
