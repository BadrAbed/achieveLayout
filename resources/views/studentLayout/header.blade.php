
<div id="header" class="header">
    <div class="row">
        <div class="col-md-3">
            <a class="logo" href="">
                <img src="{{asset('Studentpublic/images/logo.png')}}" alt="">
            </a>
        </div>
        @if(auth()->user()->is_permission==\App\Http\OwnClasses\TYPE_OF_USERS_ENUMS::STUDENT)
        @if(\App\Http\Controllers\StudentPlacementTest::checkIfPlacementTestHasbeenCompleteOrNotByUser(auth()->user()->student_grade_id))
        <div class="col-md-9 left">
            <div class="links">
                <a href="{{url('studentDashboard')}}">الرئيسة</a>
                <a href="{{url('studentLessons')}}">
                    <img src="{{asset('Studentpublic/images/book.png')}}" class="" alt="">
                    <span>عرض الدروس</span>
                </a>
            </div>
            @endif
            @endif
            <ul id="menu">
                <li>
                    <span>{{auth()->user()->name}}</span>
                    <img class="user" src="{{asset('Studentpublic/images/user.png')}}" class="" alt="">
                </li>
                <hr>
                @if(auth()->user()->is_permission==\App\Http\OwnClasses\TYPE_OF_USERS_ENUMS::STUDENT)
                    @if(\App\Http\Controllers\StudentPlacementTest::checkIfPlacementTestHasbeenCompleteOrNotByUser(auth()->user()->student_grade_id))
                <li>
                    <input id="check01" type="checkbox" name="menu"/>
                    <label for="check01">    <?=
                        \App\Http\Controllers\QuestionController::getAllDegreesForStudent();

                        ?> نقطـــة</label>
                    <ul class="submenu">
                        <li><a href="{{url('')}}/logout">تسجيل خروج</a></li>
                    </ul>
                    <ul class="submenu_small_screen">
                        <li><a href="{{url('studentDashboard')}}"> الرئيسة</a></li>
                        <li><a href="{{url('studentLessons')}}">عرض الدروس</a></li>
                        <li><a href="{{url('')}}/logout">تسجيل خروج</a></li>
                    </ul>
    
                </li>
                
            </ul>
            @endif
            @endif
        </div>
    </div>
</div>