@extends('layouts.app')

@section('custom-content')
    <style type="text/css">
        .nav-tabs > li {
            width: 33.3333%;
            text-align: center;
        }

        .nav-tabs > li > a {
            color: #05922A;
        }

        .nav-tabs > li.active > a, .nav-tabs > li.active > a:hover, .nav-tabs > li.active > a:focus {
            background-color: #05922A;
            color: #fff;
        }

    </style>
    <div class="container">


        <div class="container main-container">

            <div class="container">
                <div class="container main-container">
                    <div class="col-md-12">

                        <!--paneeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeel-->
                        <div class="panel panel-green">
                            <!--paneeeeel Header-->
                            <div class="panel-heading">
                                <h3 class="text-center"><i class="fa fa-puzzle-piece"></i> إمتحانات تحديد المستوي</h3>
                            </div>


                            <!--paneeeeel body-->
                            <div class="panel-body">

                                <br>
                                <!-- content here -->


                                <hr>
                                <p class="text-center">
                                    <small>يحدد للطالب في هذه المادة عدد من مستويات للإختبار تحدد علي حسب المادة و مستوي
                                        الطالب
                                    </small>
                                </p>
                                <hr>


                                <div id="accordion">
                                    <div class="card">


                                        <table class="table" width="100%">
                                            <thead class="thead-dark"
                                                   style="background: #d8d8d8;color: #555655;">
                                            <tr>
                                                <th scope="col">رقم السؤال</th>
                                                <th scope="col">وصف السوال</th>
                                                <th scope="col">مشاهده</th>
                                                <th scope="col">تعديل</th>
                                                <th scope="col">حذف</th>

                                            </tr>
                                            </thead>
                                            <tbody>

                                            @foreach($placement_test_questions as $placement_test_question)

                                                <tr>

                                                    <?php

                                                    $content = preg_replace("/<img[^>]+\>/i", "", $placement_test_question->question);
                                                    $content_remove_p = str_ireplace('<p>', "", $content);
                                                    $content_remove_p2 = str_ireplace('</p>', '', $content_remove_p);
                                                    $question_name = substr($content_remove_p2, 0, 100);

                                                    ?>
                                                    <td>{{$placement_test_question->id}}</td>
                                                    <td id="number"><b> {{$placement_test_question->desc}}</b></td>
                                                    <td>
                                                        <a class="btn btn-info"
                                                           href="{{url("admin/placement_test_questions/show/".$placement_test_question->id)}}">
                                                            <i class="fa fa-desktop"></i>مشاهده</a>
                                                    </td>
                                                    <td>
                                                        <a class="btn btn-success"
                                                           href="{{url("admin/placement_test_questions/edit/".$placement_test_question->id)}}">
                                                            <i class="fa fa-edit"></i>تعديل</a>
                                                    </td>
                                                    <td>
                                                        <a class="btn btn-danger"
                                                           href="{{url("admin/placement_test_questions/delete/".$placement_test_question->id)}}">
                                                            <i class="fa fa-trash"></i>حذف</a>
                                                    </td>

                                                </tr>

                                            @endforeach

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>


                        </div>

                    @include("inc.errorMessages")


                    <!-- end content here -->
                        <!-- Button trigger modal -->
                        <a class="btn btn-danger" href="{{url('admin/placement_test')}}"><i
                                    class="fa fa-reply"></i> الرجوع إلي السابق</a>

                        <a class="btn btn-info"
                           href="{{url("admin/placement_test_questions/create/".$placement_test->id)}}"><i
                                    class="fa fa-reply"></i> اضافه اسئلة</a>


                        <br>
                        <br><br>
                    </div>
                    <!--end paneeeeel body-->
                </div>
                <!--end paneeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeel-->
            </div>
        </div>
    </div>


    </div>
    </div>

@endsection