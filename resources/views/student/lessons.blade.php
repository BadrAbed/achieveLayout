@extends('studentLayout.app') @section('content')
    <div class="breadcrumb">
        <div class="row">
            <ul>
                <li>
                    <a href="{{url('studentDashboard')}}">
                        <i class="fa fa-home" aria-hidden="true"></i>
                        <span>الرئيسية</span>
                    </a>
                </li>
                <li>
                    <a href="{{url('studentLessons')}}">الدروس</a>
                </li>

            </ul>
        </div>
    </div>

    <div class="table_lessons">
    <div class="bg"></div>
    <div class="row">
        <div class="header">
            <img src="{{asset('Studentpublic/images/w_book.png')}}" class="" alt="">
            <span>عرض الدروس</span>
        </div>
    </div>
    <div class="row">
        <div class="table-users">
            <table cellspacing="0">
                <thead>
                    <tr class="main_row">
                        <th scope="col">اســـم الـــدرس</th>
                        <th scope="col">التصنيف</th>
                        <th scope="col">التاريخ</th>
                        <th scope="col">الدرجة</th>
                        <th scope="col">الحاله</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($contents as $content)
                        <tr class="details" onclick="window.location='{{url('/content/'. $content->id)}}';">
                            <td data-label="اســـم الـــدرس">
                                <div class="col-md-3 img">
                                    <img src="{{url($content->cover_image)}}" alt=""/>
                                </div>
                                <div class="col-md-9 name">
                                    <h5>{{$content->content_name}}</h5>
                                    <p>{{$content->abstract   }}</p>
                                </div>
                            </td>
                            <td data-label="التصنيف">{{$content->categories->name}}</td>
                            <td data-label="التاريخ">
                                @if($content->contentStatus==\App\Http\OwnClasses\STUDENT_LESSON_PLAN_PROGRESSES_ENUMS::GET_FINISHED)
                                {{$content->achievedContentDate}}
                                @else
                                لم يتنهى بعد

                                @endif
                            </td>
                            <td data-label="الدرجة">  <?php $content_row = \App\StudentLessonPlanProgress::where(['content_id' => $content->id, 'lesson_plan_id' => $lesson_plan_id, 'user_id' => auth()->id()])->first();
                                ?>
                                @if($content_row)
                                    {{$content_row->degree+$content_row->bonus}}
                                @else
                                    0
                                @endif</td>
                            <td data-label="الحاله" class="icon">
                                @if($content->contentStatus==\App\Http\OwnClasses\STUDENT_LESSON_PLAN_PROGRESSES_ENUMS::GET_FINISHED) {{--finished--}}
                                    <i class="fa fa-check-circle" aria-hidden="true"></i>
                                @elseif($content->contentStatus==\App\Http\OwnClasses\STUDENT_LESSON_PLAN_PROGRESSES_ENUMS::GET_STARTED)
                                    <i class="fa fa-spinner"
                                    aria-hidden="true"></i>
                                @elseif (\App\Http\Controllers\CommonStudentLessonsProcesses::checkIfUserAllowedToAccessThisLesson($content->id, $lesson_plan_id))
                                <td><i class="fa fa-unlock"
                                    ></i>
                            @else
                            <i class="fa fa-times-circle"
                                    ></i>


                                    @endif
                                </td>
                        </tr>
                    
                    @endforeach
                </tbody>    
            </table>
        </div>
    </div>
</div>

@endsection






















