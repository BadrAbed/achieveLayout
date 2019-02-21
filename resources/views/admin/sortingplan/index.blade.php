@extends('layouts.app')

@section('custom-content')



    <input type="hidden" value="{{Session::get('plan_id')}}" id="planid"/>
    <div class="container">
        <div class="container main-container">
            <div class="col-md-12">
                <br><br>
                <!--paneeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeel-->
                <div class="panel panel-green">
                    <!--paneeeeel Header-->
                    <div class="panel-heading">
                        <h3 class="text-center"><span class="fa fa-edit"></span>&nbsp;&nbsp;&nbsp;خطة الدروس التعليمية
                        </h3>
                    </div>
                    <!--paneeeeel body-->
                    <div class="panel-body text-center">
                        <br>
                        <br>
                        <p class=" text-center">لوريم ايبسوم هو نموذج افتراضي يوضع في التصاميم لتعرض على العميل ليتصور
                            طريقه وضع النصوص بالتصاميم سواء كانت تصاميم مطبوعه.لوريم ايبسوم هو نموذج افتراضي يوضع في
                            التصاميم لتعرض على العميل ليتصور طريقه وضع النصوص بالتصاميم سواء كانت تصاميم مطبوعه.</p>
                        <br>
                        <br>
                        <div class="row text-center">
                            <div class="col-md-6 ">
                                <p class=" text-center"><i class="fa fa-window-restore"></i>&nbsp;&nbsp; المواد الدراسية
                                    <select class="form-control" id="filterinput">
                                        <option>التصنيفات</option>
                                        <option>2</option>
                                        <option>3</option>
                                        <option>4</option>
                                    </select>
                                </p>
                                <input type="text" id="myInput" onkeyup="myFunction()" placeholder="البحث..">
                                <ul id="sortable1" class="connectedSortable">
                                    @foreach($planContent as $planContent)
                                        <li class="ui-state-default" value="{{$planContent->id}}" id="bb"><a
                                                    href="#"> {{$planContent->content_name}} </a></li>


                                    @endforeach


                                </ul>
                            </div>
                            <div class="col-md-6">
                                <p class=" text-center"><i class="fa fa-edit"></i>&nbsp;&nbsp;خطة الدروس التعليمية </p>
                                <ul id="sortable2" class="connectedSortable">

                                </ul>
                            </div>
                        </div>
                        <br><br>

                        <br>

                        <p id="message"></p>

                        <br>
                        <button class="btn btn-md btn-success" type="submit" onclick="change();"><span
                                    class="fa fa-plus"></span>&nbsp;أضف الخطة
                        </button>
                        <a class="btn btn-md btn-danger" href="{{ URL::previous() }}"><span class="fa fa-redo"></span>&nbsp;الرجوع
                            إلي السابق</a>
                        <br><br>
                    </div>
                    <!--end paneeeeel body-->
                </div>
                <!--end paneeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeel-->
            </div>
        </div>
    </div>

    {{ csrf_field() }}
@section("OldJqueryVersion")
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <script>
        $(function () {
            $("#sortable1, #sortable2").sortable({
                connectWith: ".connectedSortable"
            }).disableSelection();
        });
    </script>

    <script>
        $.ajaxSetup({headers: {'csrftoken': '{{ csrf_token() }}'}});

        function change() {

            var planid = $("#planid").val();

            var lis = document.getElementById("sortable2").getElementsByTagName("li");
            console.log($(lis).attr("value"));
            var arr = [];
            var i;
            for (i = 0; i < lis.length; i++) {
                var test = ($(lis[i]).attr("value"));
                arr.push(test);
            }
            console.log(arr);
            var length = lis.length;
            $.ajax({
                type: "GET",
                url: '{{url("addLessonPlan")}}/?ordering=' + arr + '+&length=' + length + '+&planID=' + planid + '',

                success: function () {
                    $("#message").empty();
                    window.location.href = "{{route('viewplans')}}";
                    $("#message").append("<div class='alert alert-success'>تمت الاضافه بنجاح</div>");
                },
                error: function () {
                    $("#message").empty();
                    $("#message").append("<div class='alert alert-danger'>يجب ان تضيف دروس للخطه</div>");

                }

            });
        }

        function myFunction() {
            var input, filter, ul, li, a, i;
            input = document.getElementById("myInput");
            filter = input.value.toUpperCase();
            ul = document.getElementById("sortable1");
            li = ul.getElementsByTagName("li");
            for (i = 0; i < li.length; i++) {
                a = li[i].getElementsByTagName("a")[0];
                if (a.innerHTML.toUpperCase().indexOf(filter) > -1) {
                    li[i].style.display = "";
                } else {
                    li[i].style.display = "none";

                }
            }
        }
    </script>
@endsection
@endsection
