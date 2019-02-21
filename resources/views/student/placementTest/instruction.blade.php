@extends('layouts.app')

@section('content')
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <div class="container">
        <div class="jumbotron">
            <div class="row">
                <div class="col-md-7">
                    <div class=" ">
                        <br>
                        <h2>مرحبا بك في كلمن</h2>
                        <p style="font-size:16px;">عزيزى الطالب/الطالبة
                            فيما يلى أسئلة تقيس مستواك في اللغة العربية.
                        </p>
                        <p>

                        <ul class="tips">
                            <li> أفعل كل ما في وسعك للإجابة على كل الأسئلة</li>
                            <li> إذا لم تستطيع الإجابة على السؤال انتقل إلى السؤال التالي</li>
                            <li> يجب عليك التركيز على محتوى السؤال قبل الإجابة</li>
                            <li> يجب عليك الالتزام بالوقت</li>
                        </ul>
                        </p>


                        <a href="{{url('Student/placement_test/'.$placement_id)}}"
                           class="btn btn-success" style="padding:15px;border-radius: 50px;"><i
                                    class="fa fa-location-arrow"></i> بدأ إختبار
                            تحديد المستوي</a>
                        <a href="" class="btn btn-danger" style="padding:15px;border-radius: 50px;"><i
                                    class="fa fa-share"></i> تسجيل الخروج</a>
                    </div>
                </div>
                <div class="col-md-5">
                    <img src="{{asset("/images/man.png")}}" width="100%" alt="">
                </div>
            </div>
        </div>
    </div>

@endsection