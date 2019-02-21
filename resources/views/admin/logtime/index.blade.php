@extends("layouts.app")

@section("custom-content")

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <style type="text/css">
        .col-form-label {
            line-height: 1.3
        }

        #Table tbody tr {
            display: none;
        }
    </style>
    <div class="contranier" style="width: 55%;margin: auto;">
        <br>


        <div class="panel panel-green">
            <div class="panel-heading"><h3> سجل الأحداث اليومية </h3></div>
            <div class="panel-body">
                <div class="row">

                    <div class="col-md-3">
                        <label>بحث :</label>


                        <input type="text" id="myInput" onkeyup="myFunctionFilter()" class="form-control"
                               placeholder="بحث">


                    </div>

                    <div class="col-md-2">

                        <div class="form-group">
                            <label for="exampleFormControlSelect1">التصنيف :</label>

                            <select id="myTable" class="form-control">
                                <option value="all">الكل</option>
                                <option value="الدروس">الدروس</option>
                                <option value="country">الدول</option>
                                <option value="education_levels"> المراحل الدراسية</option>
                                <option value="learing_goals">نواتج التعلم</option>
                                <option value="lesson_plans">خطط التعلم</option>
                                <option value="categories">التصنيفات</option>
                                <option value="placement_tests">امتحانات تحديد المستوى</option>
                                <option value="users">المستخدمين</option>


                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="example-date-input" class="col-form-label">من يوم :</label>

                            <input class="form-control" type="date" id="timeStart">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="example-date-input" class="col-form-label">إلي يوم :</label>

                            <input class="form-control" type="date" id="timeEnd" value="{{date('Y-m-d')}}"
                                   id="example-date-input">

                        </div>
                    </div>
                    <div class="col-md-1">
                        <label for="example-date-input" class="col-form-label"> &nbsp;</label>
                        <button onclick="myFunction()" class="btn btn-success btn-block"
                                style="border-radius: 50px;width: 40px;outline: 0"><span class="fa fa-search"></span>
                        </button>
                    </div>
                </div>


            </div>
        </div>
        <p id="demo"></p>
        <div class="text-center"><h3 class="text-center">نتائج البحث <span id="numberOfsearch"
                                                                           class="badge badge-warning" style="    background-color: #5cb85c;
    padding: 7px;
    border-radius: 50px;">  {{count($logtimes)}}  </span></h3> <span class="fa fa-arrow-down"></span></div>

        {{--<div id="filter">--}}
        <table class="table table-striped table-dark table-bordered  table-hover" id="Table">
            <thead>

            <th style="text-align: center"> الحدث</th>
            <th style="text-align: center;width: 15%"> التاريخ</th>

            </thead>
            <tbody id="myTable">

            @for($i=0;  $i<count($logtimes);$i++)
                <tr>

                    <td>

                        {{$logtimes[$i]['user_name']}}( {{$logtimes[$i]['type']}} )
                        ({{ $logtimes[$i]['table']}} )
                        {{$logtimes[$i]['name']}}
                    </td>
                    <td>
                    <span class="badge badge-warning pull-left"
                          style="background-color: #59b0f2">  {{$logtimes[$i]['created_at']}} </span>
                    </td>

                </tr>
            @endfor

            </tbody>
        </table>
        <center>
            <a href="#" id="load"><span class="badge badge-success"
                                        style="background-color: #5cb85c;border-radius: 50px;padding: 10px">  <span
                            class="fa fa-arrow-down"></span>  عرض المزيد <span></a>
            <button class="btn" disabled id="hide"
                    style="background-color: #6c757d;border-radius: 50px;padding: 10px;color: #fff">  <span
                        class="fa fa-arrow-up"></span> اخفاء
            </button>

        </center>
        <center>
        </center>
        <div id="emptydata">
            <h1></h1>
        </div>
    </div>

    {{--</div>--}}

    <script>
        function myFunction() {
            var timeStart = document.getElementById("timeStart").value;
            var timeEnd = document.getElementById("timeEnd").value;
            var myTable = document.getElementById("myTable").value;

            $.ajax({
                type: 'get',
                url: '{{url('')}}/logfiltertime/?timeStart=' + timeStart + '&table=' + myTable + '&timeEnd=' + timeEnd + '',
                success: function (data) {
                    $('#Table tbody').empty();
                    $('#emptydata').empty();
                    if (!$.trim(data)) {
                        $('#numberOfsearch').html(0);
                        $("#load").css("display", "none");
                        $("#hide").css("display", "none");
                        $('#emptydata').append('<div   style="text-align: center;color:#000;" >' + ' لاتوجد نتائج لهذا اليوم' + '</div>')

                    }
                    var i = 0;

                    $.each(data, function (i, value) {

                        $('#numberOfsearch').html(i + 1);

                        $('#Table tbody').append('<tr><td >' + value.user_name + ' (' + value.type + ' ) (' + value.table + ') ' + value.name + '</td>' +

                            ' <td><span class="badge badge-warning pull-left" style="background-color: #59b0f2">' + value.created_at.date + '</span> </td>' +

                            '</tr>');


                    });
                    $("#Table tbody tr").slice(0, 20).show();
                },

            })
        }

        function myFunctionFilter() {
            $("#load").css("display", "none");
            $("#hide").css("display", "none");
            $('#emptydata').empty();
            var input, filter, table, tr, td, i;
            input = document.getElementById("myInput");
            filter = input.value.toUpperCase();
            table = document.getElementById("Table");
            tr = table.getElementsByTagName("tr");
            if (filter === "") {
                $(function () {
                    $("#Table tbody tr").css("display", "none");
                    $("#load").css("display", "");
                    $("#hide").css("display", "");
                    $("#Table tbody tr").slice(0, 20).show(); // select the first ten
                    $("#load").click(function (e) { // click event for load more
                        e.preventDefault();
                        $("#Table tbody tr:hidden").slice(0, 10).show(); // select next 10 hidden divs and show them
                        if ($("#Table tbody tr:hidden").length == 0) { // check if any hidden divs still exist
                            $("#load").css("display", "none");
                            // alert("No more divs"); // alert if there are none left
                        }
                        if ($("#Table tbody tr:visible").length <= 25) { // check if any hidden divs still exist
                            $("#load").css("display", "");
                            document.getElementById("hide").disabled = true;
                            // alert("No more divs"); // alert if there are none left
                        }
                    });
                });
            }
            for (i = 0; i < tr.length; i++) {
                tr[i].style.display = "";
                td = tr[i].getElementsByTagName("td")[0];
                if (td) {
                    if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {


                        tr[i].style.display = "table-row";

                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
            var numOfVisibleRows = $('tr').filter(function () {
                return $(this).css('display') !== 'none';
            }).length;
            $('#numberOfsearch').html(numOfVisibleRows - 1);
            if (numOfVisibleRows == 1) {

                $('#emptydata').append('<div   style="text-align: center;color:#000;">' + ' لاتوجد نتائج لهذا العنوان' + '</div>')

            }
        }

        $(function () {
            $("#Table tbody tr").slice(0, 20).show(); // select the first ten

            $("#load").click(function (e) { // click event for load more
                e.preventDefault();
                $("#Table tbody tr:hidden").slice(0, 10).show();
                document.getElementById("hide").disabled = false;
                // select next 10 hidden divs and show them
                if ($("#Table tbody tr:hidden").length == 0) { // check if any hidden divs still exist
                    $("#load").css("display", "none");
                    // alert("No more divs"); // alert if there are none left
                }
            });
            $("#hide").click(function (e) { // click event for load more
                e.preventDefault();
                $("#Table tbody tr:visible").slice($("#Table tbody tr:visible").length - 10, $("#Table tbody tr:visible").length).hide();
                document.getElementById("hide").disabled = false;
                // select next 10 hidden divs and show them
                if ($("#Table tbody tr:hidden").length > 0) { // check if any hidden divs still exist

                    $("#load").css("display", "");
                    // alert("No more divs"); // alert if there are none left
                }   if ($("#Table tbody tr:visible").length <= 25) { // check if any hidden divs still exist

                    document.getElementById("hide").disabled = true;
                    // alert("No more divs"); // alert if there are none left
                }
            });
        });
    </script>
    <script>


        $(document).ready(function () {


            // $("#myInput").on("keyup", function () {
            //     var value = $(this).val().toLowerCase();
            //
            //
            //     $("#myTable tr").filter(function () {
            //         $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            //
            //     });
            // });
        });
    </script>
@endsection