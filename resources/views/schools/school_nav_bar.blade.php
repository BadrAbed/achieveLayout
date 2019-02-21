<nav class="navbar navbar-default ">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{url("")}}"><img src="{{url("images/logo.png")}}" width="65%"></a>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav ">

                @if(\Illuminate\Support\Facades\Auth::guard('school')->check())


                    <li class="{{request()->is("SchoolDashboard")?"active":""}}">
                        <a href="{{url('SchoolDashboard')}}">
                            <center><span class="fa fa-home"></span><br></center>
                            الرئيسية
                            <span class="sr-only">(current)</span>
                        </a>
                    </li>
                    <li class="{{request()->is("SchoolAllStudent")?" ":""}}">
                        <a href="{{url('SchoolAllStudent')}}">
                            <center><span class="fa fa-users"></span><br></center>
                            المستخدمين
                            <span class="sr-only">(current)</span>
                        </a>
                    </li>


                @endif
            <!-- Authentication Links -->
                @if(!\Illuminate\Support\Facades\Auth::guard('school')->check())
                    <li class="{{request()->is("login")?"active":""}}">
                        <a class="" href="{{url("login")}}">
                            <center><span class="fa fa-user"></span><br></center>
                            دخول
                        </a>
                    </li>
                @endif
                @if(!\Illuminate\Support\Facades\Auth::guard('school')->check())
                    <li class="{{request()->is("register")?"active":""}}">
                        <a class="" href="{{url("register")}}">
                            <center><span class="fa fa-lock"></span><br></center>
                            تسجيل
                        </a>
                    </li>
                @endif

            </ul>

        </div>
    </div>

</nav>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
    var audio = new Audio('{{url('sounds/slow-spring-board.mp3')}}');
    $(document).ready(function () {
        myfun();
    });

    function myfun() {
        $.ajax({
            url: '{{url('load/numberOfNotification')}}', //php
            data: "", //the data "caller=name1&&callee=name2"
            dataType: 'json', //data format
            success: function (data) {
                //on receive of reply


                if ($('#notifications').html() < data) {
                    audio.play();
                }
                $('#notifications').html("" + data + "");
            }
        });
    }


    setInterval(myfun, 100000);
</script>
