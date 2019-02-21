@extends('layouts.app')


<script src="{{asset('js/bootstrap-dropdownhover.js')}}"></script>

<style>
    td {
        background-color: #fff !important;
    }
</style>

@section('content')
    <div class="container">
        <br>
        @if(isset($url_feedback_for_lessonplan))
            <a class="btn btn-success" href="{{url('Student/placement_test/feedback/LessonPlan')}}">نتائج الدروس لهذا
                الصف</a>
        @endif
        <div class="container main-container">
            <!-- Latest compiled JavaScript -->
            <div class="panel panel-green">
                <div class="panel-heading">

                    <h3 class="text-center"><span class="fa fa-desktop"></span>&nbsp;&nbsp;عرض الدروس</h3>
                </div>
                <div class="panel-body">


                    <table class="table table-bordered" width="100%">
                        <thead class="thead-dark" style="background: #d8d8d8;color: #555655;">
                        <tr>


                            <th scope="col">إسم الدرس</th>
                            <th scope="col">التصنيف</th>

                            <th scope="col">تاريخ الانتهاء</th>
                            <th scope="col">الدرجه</th>
                            <th scope="col">البونص</th>


                        </tr>
                        </thead>
                        <tbody>


                        @foreach($contents as $content)

                            <tr style="{{($content->contentStatus == \App\Http\OwnClasses\STUDENT_LESSON_PLAN_PROGRESSES_ENUMS::GET_STARTED)?"background-color: #dcdcdc":""}}">


                                <td style="font-weight: bold">

                                    {{$content->content_name}}

                                </td>

                                <td><div class="badge badge-success" style="background-color: black;color: #f1f1f1"> {{$content->categories->name}}</div></td>


                                @php
                                    $LessonFinshedWithStudent=\App\StudentLessonPlanProgress::where(['user_id'=>$student_id,"lesson_plan_id"=>$lesson_plan_id,'content_id'=>$content->id])->first();
                                @endphp
                                <td scope="row" style="font-size: 14px;">
                                   <div class="badge badge-success" style="background-color: green;color: #f1f1f1"> @if($LessonFinshedWithStudent)
                                        {{$LessonFinshedWithStudent->created_at}}
                                    @else لم ينتهى بعد
                                    @endif
                                   </div>
                                </td>
                                <td>
                                    <div class="badge badge-success" style="background-color: red;color: #f1f1f1">   @if($LessonFinshedWithStudent)
                                        {{$LessonFinshedWithStudent->degree}}
                                    @else لم ينتهى بعد
                                    @endif
                                    </div>
                                </td>
                                <td scope="row" style="font-size: 14px;">
                                    <div class="badge badge-success" style="background-color: deepskyblue;color: #f1f1f1">      @if($LessonFinshedWithStudent)
                                        {{$LessonFinshedWithStudent->bonus}}
                                    @else لم ينتهى بعد
                                    @endif
                                    </div>
                                </td>

                            </tr>

                        @endforeach
                        </tbody>
                    </table>
                    <a href="{{url('SchoolAllStudent')}}" class="btn btn-danger"><i class="fa fa-share"></i> رجوع إلي السابق </a>


                    @endsection




                    @section("CustomContentAfterGeneralJquery")
                        <script>


                            /*navigate to the same href of the attached link in td*/
                            $(document).ready(function () {

                                $('.table tr').click(function () {
                                    var href = $(this).find("a").attr("href");

                                    if (href) {
                                        window.location = href;
                                    }
                                });


                                $('.unselectable').each(function (i, obj) {
                                    $(this).closest('tr').css("backgroundColor", "#fff");
                                    $(this).closest('tr').css("cursor", "context-menu");
                                    $(this).closest('tr').hover(function () {
                                        $(this).css("cursor", "context-menu");
                                    });
                                });


                            });
                        </script>
@endsection
