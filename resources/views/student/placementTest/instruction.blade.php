<style>
    .placement .jumbotron{
        direction: rtl;
        padding: 2rem 2rem;
    }
    .container.placement{
        margin: 9.5rem auto;
        display: block;
    }
    .container.placement h2{
        font-family: Cairo-Bold, WinSoftPro-Medium, AdobeInvisFont;
    }
    .container.placement p {
        margin-top: 1rem;
        font-family: 'Amiri', serif;
    }
    .container.placement ul{
        margin: 1rem 0;
    }
    #header ul#menu {
        margin: 1rem 0 !important;
        display: inline-block !important;
        text-align: left;
        position: absolute;
        left: 23rem;
    }
    .container.placement ul li{
        margin-bottom: 0.5rem;
        font-family: 'Amiri', serif;
    }
    .container.placement  a {
        color: rgba(255, 255, 255, 255);
        background: #7fbb50;
        border: 1px solid #7fbb50;
        padding: 0.2rem 4rem;
        margin-left: 1rem;
        font-family: Cairo-Bold, WinSoftPro-Medium, AdobeInvisFont;
        padding: 1rem;
        margin-top: 1rem;
    }
    #return-to-top{
        display: none !important;
    }
</style>
@extends('studentLayout.app')

@section('content')
    <div class="container placement">
        <div class="jumbotron">
            <div class="row">
                <div class="col-md-7">
                    <div class=" ">
                        <br>
                        <h2>مرحبا بك في بيان</h2>
                        <p style="font-size:16px;">عزيزي الطالب/الطالبة
                            فيما يلي أسئلة تقيس مستواك في اللغة العربية.
                        </p>
                        <p>

                        <ul class="tips">
                            <li> أفعل كل ما في وسعك للإجابة على كل الأسئلة</li>
                            <li> إذا لم تستطع الإجابة على السؤال انتقل إلى السؤال التالي</li>
                            <li> يجب عليك التركيز على محتوى السؤال قبل الإجابة</li>
                            <li> يجب عليك الالتزام بالوقت</li>
                        </ul>
                        </p>


                        <a href="{{url('Student/placement_test/'.$placement_id)}}"
                           class="btn btn-success"><i
                                    class="fa fa-location-arrow"></i> بدء اختبار
                            تحديد المستوى</a>
                        <a href="{{url('')}}/logout" class="btn btn-danger"><i
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