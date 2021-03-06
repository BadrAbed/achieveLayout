
@extends('studentLayout.app')


@section('content')
    {{-- ////////////////////// breadcrumb ////////////////////////////// --}}
    <div class="breadcrumb">
        <div class="row">
            <ul>
                <li>
                    <a href="{{url('studentDashboard')}}">
                        <i class="fa fa-home" aria-hidden="true"></i>
                        <span>الرئيسة</span>
                    </a>
                </li>

            </ul>
        </div>
    </div>
    {{-- ////////////////////// #breadcrumb ////////////////////////////// --}}
    <div class="jumbotronme StudentDashboard">
        {{-- ////////////////////// Lessons ////////////////////////////// --}}
        <div class="lessons">
            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-12 right">
                    <div class="square">
                        <img src="{{asset($current_lesson_detail->cover_image)}}" class="" alt="">
                        <span></span>
                    </div>
                </div>
                <div class="col-lg-8 col-md-8 col-sm-12 left">
                    <h2>{{$current_lesson_detail->content_name}}</h2>
                    <p>{{$current_lesson_detail->abstract}}</p>
                    
                    

                </div>
            </div>
            <div class="row show" style="display:block;">
                    <a href="{{URL::to('studentLessons')}}" class="lesson">
                        <img src="{{asset('Studentpublic/images/all_lesson.png')}}" class="" alt="">
                        <span>عرض كل الدروس</span>
                    </a>
                    <a href="{{url('content/'.$current_lesson_detail->id)}}" class="lesson">
                        <img src="{{asset('Studentpublic/images/one_lesson.png')}}" class="" alt="">
                        <span>عرض  الدرس</span>
                    </a>
            </div>
        </div>
        {{-- //////////////////////// Points /////////////////////////// --}}
        <div class="points">
            <div class="row">
                <div class="caret">
                    <i class="fa fa-caret-right right" aria-hidden="true"></i>
                    <i class="fa fa-caret-left left" aria-hidden="true"></i>
                </div>
                <div class="points_slide">
                    <div class="col-md-4 col-sm-12 all point">
                        <div class="split_right"></div>
                        <div class="split_left"></div>
                        <div class="col-md-6 right">
                            <img src="{{asset('Studentpublic/images/message.png')}}" class="" alt="">
                            <span>{{\App\Http\Controllers\QuestionController::getAllDegreesForStudent()}}</span>
                            <h3>إجمالي النقاط</h3>
                        </div>
                        <div class="col-md-6 left">
                            <div class="img">
                                <img src="{{asset('Studentpublic/images/cup.png')}}" class="" alt="">
                            </div>
                        </div>
                    </div>
                    @php
    
                        $yesterday=date('Y-m-d',strtotime("-1 days"));
                    @endphp
                    <div class="col-md-4 col-sm-12 today point">
                        <div class="split_right"></div>
                        <div class="split_left"></div>
                        <div class="col-md-6 right">
                                <img src="{{asset('Studentpublic/images/message.png')}}" class="" alt="">
                            <span>{{App\Http\Controllers\StudentDashboard::getPointsForStudent( date("Y-m-d"),$lesson_plan_id)}}</span>
                            <h3>نقـــاط اليوم</h3>
                        </div>
                        <div class="col-md-6 left">
                            <div class="img">
                                <img src="{{asset('Studentpublic/images/calender.png')}}" class="" alt="">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-12 past point">
                        <div class="split_right"></div>
                        <div class="split_left"></div>
                        <div class="col-md-6 right">
                            <img src="{{asset('Studentpublic/images/message.png')}}" class="" alt="">
                            <span>{{App\Http\Controllers\StudentDashboard::getPointsForStudent($yesterday,$lesson_plan_id)}}</span>
                            <h3> نقـــاط أمــس</h3>
                        </div>
                        <div class="col-md-6 left">
                            <div class="img">
                                <img src="{{asset('Studentpublic/images/calender2.png')}}" class="" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- //////////////////////// Level Par /////////////////////////// --}}
        <div class="level">
            <div class="row">
                <div class="col-xl-2 col-lg-2 col-md-3 col-sm-12 right">
                    <img src="{{asset('Studentpublic/images/round.png')}}" class="" alt="">
                    <span class="pom"></span>
                    <div class="col-md-12">
                        <span>مستوى التقدم  </span>
                    </div>
                </div>
                <div class="col-xl-10 col-lg-10 col-md-9 col-sm-12 left">
                    <div id="myProgress">
                        <div class="toolip" data-toggle="tooltip" style="width: {{$PogressPrecentge}}%">
                            <div class="arrow"></div>
                            <div class="inner">{{$PogressPrecentge}}%</div>
                        </div>
                        <div id="myBar" style="width: {{$PogressPrecentge}}%"></div>

                    </div>
                    <div class="col-md-12">
                        <span class="num">{{$finshedLessson}}/{{$allLessons}}</span>
                    </div>
                </div>
            </div>
        </div>
        {{-- //////////////////////// Lssons Gallery /////////////////////////// --}}
        @php @endphp
        <div class="gallery">
            <div class="row">
                <div class="arrows">
                    <i class="fa fa-caret-right prev" aria-hidden="true"></i>
                    <i class="fa fa-caret-left next" aria-hidden="true"></i>
                </div>
                <div class="imgs">
                    @foreach($contents as $content)
                    <a class="slide" href="">
                        <div class="content-overlay"></div>
                        <img src="{{asset($content->cover_image)}}" class="" alt="">
                        <div class="content-details fadeIn-bottom">
                            <h3 class="title">{{$content->content_name}} </h3>
                        </div>
                    </a>
                    @endforeach

                </div>
                <div class="dots">
                    <a class="dot"></a>
                    <a class="dot"></a>
                    <a class="dot"></a>
                </div>
            </div>
        </div>
    </div>

@endsection























