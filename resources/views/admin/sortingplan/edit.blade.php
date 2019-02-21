@extends('layouts.app')

@section('custom-content')
    <div class="container">

        <div class="container main-container">

<input type="hidden" value="{{$planID}}" id="planid" />
<p id="message"></p>





            <div class="col-md-12">
                <br><br>
                <!--paneeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeel-->
                <div class="panel panel-green">
                    <!--paneeeeel Header-->
                    <div class="panel-heading">
                        <h3 class="text-center"><span class="fa fa-edit"></span>&nbsp;&nbsp;&nbsp;خطة الدروس التعليمية</h3>
                    </div>
                    <!--paneeeeel body-->
                    <div class="panel-body text-center">
                        <br>
                        <br>
                        <p class=" text-center">لوريم ايبسوم هو نموذج افتراضي يوضع في التصاميم لتعرض على العميل ليتصور طريقه وضع النصوص بالتصاميم سواء كانت تصاميم مطبوعه.لوريم ايبسوم هو نموذج افتراضي يوضع في التصاميم لتعرض على العميل ليتصور طريقه وضع النصوص بالتصاميم سواء كانت تصاميم مطبوعه.</p>
                        <br>
                        <br>
                        <div class="row text-center">
                            <div class="col-md-6 ">
                                <p class=" text-center"> <i class="fa fa-window-restore"></i>&nbsp;&nbsp; المواد الدراسية المتيقيه <select class="form-control" id="filterinput">
                                        <option>التصنيفات</option>
                                        <option>2</option>
                                        <option>3</option>
                                        <option>4</option>
                                    </select>
                                </p>
                                <input type="text" id="myInput" onkeyup="myFunction()" placeholder="البحث..">
                                <ul id="sortable1" class="connectedSortable">

                                    @for($i=0;$i<count($AllContent);$i++)
                                        <?php $allcontent=$AllContent[$i] ?>
                                        @foreach($allcontent as $allplancontent)
                                                <li class="ui-state-highlight" value="{{$allplancontent->id}}" id="bb"> <a href="#"> {{$allplancontent->content_name}} </a></li>
                                        @endforeach
                                    @endfor

                                </ul>
                            </div>
                            <div class="col-md-6">
                                <p class=" text-center"><i class="fa fa-edit"></i>&nbsp;&nbsp;خطة الدروس الحاليه</p>
                                <ul id="sortable2" class="connectedSortable">
                                    @for($i=0;$i<count($planContent);$i++)
                                        <?php $content=$planContent[$i] ?>
                                        @foreach($content as $plan)
                                            <li class="ui-state-highlight" value="{{$plan->id}}" id="bb">{{$plan->content_name}}</li>


                                        @endforeach
                                    @endfor
                                </ul>
                            </div>
                        </div>
                        <br><br>
                        <button class="btn btn-md btn-success" type="submit" onclick="change();"><span class="fa fa-plus"></span>&nbsp;عدل الخطة</button>
                        <a class="btn btn-md btn-danger" href="{{ URL::previous() }}" ><span class="fa fa-redo"></span>&nbsp;الرجوع إلي السابق</a>
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
        $( function() {
            $( "#sortable1, #sortable2" ).sortable({
                connectWith: ".connectedSortable"
            }).disableSelection();
        } );
    </script>

<script>
    $.ajaxSetup({ headers: { 'csrftoken' : '{{ csrf_token() }}' } });
    function change() {

var planid=$("#planid").val();
        var lis = document.getElementById("sortable2").getElementsByTagName("li");
        console.log($(lis).attr("value"));
        var arr=[];
        var i;
        for ( i=0;i<lis.length;i++){
            var test=  ($(lis[i]).attr("value"));
            arr.push(test);
        }
        console.log(arr);
        var length=lis.length;
        $.ajax({
            type: "GET",
            url:'{{url("updatePlanSpecificLesson")}}/?ordering='+arr+'+&length=' + length +'+&planID=' + planid +'',

            success: function () {
                $("#message").empty();
                window.location.href="{{route('viewplans')}}" ;
                $("#message").append("<b>تمت الاضافه بنجاح</b>");
            },
            error: function () {
                $("#message").empty();
                $("#message").append("<b>حدث خطا حاول مجددا</b>");
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
