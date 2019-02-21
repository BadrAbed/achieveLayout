@extends("layouts.app")

@section("custom-content")
    <div class="container">
        <div class="container">
            <!-- will be used to show any messages -->
            <div class="row text-center">
                <!--login form content-->
                <br>
                <center><img src="{{URL::asset("images/noaccessbg.png")}}" width="50%"></center>
                <h3 class="text-center">  عذرا !!!</h3>
                <p class="text-center">  الصفحة التي تبحث عنها غير مسموح لك بالدخول إليها</p>
                <div class="text-center"><br><a class="btn btn-success " href="{{url("")}}"><i class="fa fa-home"></i>&nbsp;العودة إلي الصفحة الرئيسية</a></div>
                <br><br><br>
            </div>
        </div>
    </div>
@endsection