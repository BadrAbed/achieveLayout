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
            <a class="navbar-brand" href="{{url("studentDashboard")}}"><img src="{{url("images/logo.png")}}" width="65%"></a>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav ">

                @if(auth()->check())
                  <?php $parent_id=\App\EducationLevel::find(auth()->user()->student_grade_id)->parent_id ?>
                @if($parent_id)
                    <li class="{{request()->is("studentDashboard")?"active":""}}">
                        <a href="{{url("studentDashboard")}}">
                            <center><span class="fa fa-home"></span><br></center>
                            الرئيسية
                            <span class="sr-only">(current)</span>
                        </a>
                    </li>
                    <li class="{{request()->is("studentLessons")?"active":""}}">
                        <a href="{{url("studentLessons")}}">
                            <center><span class="fa fa-play-circle"></span><br></center>
                            عرض الدروس
                        </a>
                    </li>
                      @endif
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

