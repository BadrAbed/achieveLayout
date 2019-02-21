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
            <a class="navbar-brand" href="{{url("")}}"><img src="{{url("images/logo.png")}}" width="111" style="padding-left: 5px;"></a>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav ">

                @if(auth()->check())
                    <li class="{{request()->is("/")?"active":""}}">
                        <a href="{{url("")}}">
                            <center><span class="fa fa-home"></span><br></center>
                            الرئيسية
                            <span class="sr-only">(current)</span>
                        </a>
                    </li>
                    <li class="{{request()->is("content")?"active":""}}">
                        <a href="{{url("content")}}">
                            <center><span class="fa fa-play-circle"></span><br></center>
                            عرض الدروس
                        </a>
                    </li>
                    <li class="{{request()->is("users")?"active":""}}">
                        <a href="{{url("users")}}">
                            <center><span class="fa fa-users"></span><br></center>
                            المستخدمين
                        </a>
                    </li>
                    <li style="display: none" class="{{request()->is("content")?"active":""}}">
                        <a href="{{url("content")}}">
                            <center><span class="fa fa-window-restore "></span><br></center>
                            المحتوى
                        </a>
                    </li>
                    {{--<li class="{{request()->is("vocabularys")?"active":""}}">
                      <a href="{{url("vocabularys")}}">
                        <center><span class="fa fa-server"></span><br></center>
                        المصطلحات
                      </a>
                    </li>--}}
                    <li class="{{request()->is("country")?"active":""}}">
                        <a href="{{url("country")}}">
                            <center><span class="fa fa-flag"></span><br></center>
                            الدول
                        </a>
                    </li>
                    <li class="{{request()->is("education-level")?"active":""}}">
                        <a href="{{url("education-level")}}">
                            <center><span class="fa fa-sitemap"></span><br></center>
                            المراحل الدراسيه
                        </a>
                    </li>
                    <li class="{{request()->is("viewplans")?"active":""}}">
                        <a href="{{url("viewplans")}}">
                            <center><span class="fa fa-window-restore "></span><br></center>
                            خطط التعلم
                        </a>
                    </li>
                    <li class="{{request()->is("categories")?"active":""}}">
                        <a href="{{url("categories")}}">
                            <center><span class="fa fa-filter"></span><br></center>
                            التصنيفات
                        </a>
                    </li>
                    <li class="{{request()->is("showgoal")?"active":""}}">
                        <a href="{{url("showgoal")}}">
                            <center><span class="fa fa-hourglass"></span><br></center>
                            نواتج التعلم
                        </a>
                    </li>
                    <li class="{{request()->is("admin/placement_test")?"active":""}}">
                        <a href="{{url("admin/placement_test")}}">
                            <center><span class="fa fa-puzzle-piece"></span><br></center>
                              امتحانات تحديد المستوي
                        </a>
                    </li>

                    <li class="{{request()->is("dictionary/allWords")?"active":""}}">
                        <a href="{{url("dictionary/allWords")}}">
                            <center><span class="fa fa-paragraph" ></span><br></center>
                            قاموس الكلمات
                        </a>
                    </li>
                @endif
            <!-- Authentication Links -->
                @if(!auth()->check())
                    <li class="{{request()->is("login")?"active":""}}">
                        <a class="" href="{{url("login")}}">
                            <center><span class="fa fa-user"></span><br></center>
                            دخول
                        </a>
                    </li>
                @endif
                @if(!auth()->check())
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

