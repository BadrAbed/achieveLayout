<div class="nav02">
    <div class="container">
        <div class="row">
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="col-md-9">
                <ul class="nav navbar-nav navbar-right nav-user">
                    <li class="head_title">
                        <h2 style="color:#fff;padding-right:70px;padding-top: 60px;"><span class="fa fa-home"></span>&nbsp;&nbsp;الرئيسية
                        </h2>
                    </li>
                </ul>
            </div>
            <div class="col-md-3">
                @if(auth()->check())
                    <div class="nav navbar-nav navbar-left nav-user">
                        <li class="btn btn-secondary dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            <a href="#" style="direction: ltr;padding-top: 40px;">
                                <img src="{{asset("images/pp_admin2.png")}}">
                                <span style="color: white;margin-left: 5px;font-size: 14px;background-color: #05932a;padding: 8px;border-radius: 10px;">{{auth()->user()->name}}
                                    @if(App\Http\OwnClasses\Permissions::STUDENT_PERMISSION_ENUM==auth()->user()->is_permission && App\Http\Controllers\StudentPlacementTest::checkIfPlacementTestHasbeenCompleteOrNotByUser(auth()->user()->student_grade_id))
                                        <span class="badge"
                                              style="background-color: #fff;color:#777;padding: 7px;font-size: 11px !important;">نقطة
                                            <?=
                                            \App\Http\Controllers\QuestionController::getAllDegreesForStudent();

                                            ?>
                                         </span>
                                    @endif

                                    <span style="color: white;margin-left: 3px" class="caret"></span>
                            </a>
                        </li>

                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <br><a href="{{url("")}}" style="padding: 20px !important;"><img
                                        src="{{url("images/__logo.png")}}" width="70%"></a><br><br>
                            @if(App\Http\OwnClasses\Permissions::STUDENT_PERMISSION_ENUM==auth()->user()->is_permission)
                                <?php $parent_id = \App\EducationLevel::find(auth()->user()->student_grade_id); ?>


                                @if($parent_id->parent_id || App\Http\OwnClasses\Permissions::STUDENT_PERMISSION_ENUM!=auth()->user()->is_permission)

                                    <li class="divider"></li>


                                    <li class="dropdown-item" style="" href="#"><a href="#"><i class="fa fa-user"
                                                                                               style="font-size: 15px"></i>&nbsp;
                                            الحساب الشخصي</a></li>
                                    <li class="dropdown-item" style="" href="#"><a href="#"><i
                                                    class="fa fa-window-restore"
                                                    style="font-size: 15px"></i>&nbsp;
                                            عرض الدروس</a></li>
                                    <li class="dropdown-item" style="" href="#"><a href="#"><i class="fa fa-edit"
                                                                                               style="font-size: 15px"></i>&nbsp;
                                            تعديل الحساب</a></li>

                                @endif
                            @else


                                <li class="dropdown-item" style="" href="#"><a href="#"><i class="fa fa-user"
                                                                                           style="font-size: 15px"></i>&nbsp;
                                        الحساب الشخصي</a></li>
                                <li class="dropdown-item" style="" href="#"><a href="#"><i
                                                class="fa fa-window-restore"
                                                style="font-size: 15px"></i>&nbsp;
                                        عرض الدروس</a></li>
                                <li class="dropdown-item" style="" href="#"><a href="#"><i class="fa fa-edit"
                                                                                           style="font-size: 15px"></i>&nbsp;
                                        تعديل الحساب</a></li>
                                <li class="divider"></li>
                            @endif




                            <li class="dropdown-item" style=""><a href="{{url('')}}/logout"><i
                                            class="fa fa-share-square"></i>&nbsp; تسجيل الخروج</a></li>
                            <br>
                        </ul>
                    </div>
                @endif
                @if(\Illuminate\Support\Facades\Auth::guard('school')->check())
                    <div class="nav navbar-nav navbar-left nav-user">
                        <li class="btn btn-secondary dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            <a href="#" style="direction: ltr;padding-top: 40px;">
                                <img src="{{asset("images/ppcirc.png")}}">
                                <span style="color: white;margin-left: 5px;font-size: 14px;background-color: #05932a;padding: 8px;border-radius: 10px;">{{\Illuminate\Support\Facades\Auth::guard('school')->user()->name}}


                                    <span style="color: white;margin-left: 3px" class="caret"></span>
                            </a>
                        </li>

                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <br><a href="{{url("")}}" style="padding: 20px !important;"><img
                                        src="{{url("images/__logo.png")}}" width="70%"></a><br><br>


                            <li class="divider"></li>


                            <li class="dropdown-item" style="" href="#"><a href="#"><i class="fa fa-user"
                                                                                       style="font-size: 15px"></i>&nbsp;
                                    الحساب الشخصي</a></li>
                            <li class="dropdown-item" style="" href="#"><a href="#"><i
                                            class="fa fa-window-restore"
                                            style="font-size: 15px"></i>&nbsp;
                                    عرض الدروس</a></li>
                            <li class="dropdown-item" style="" href="#"><a href="#"><i class="fa fa-edit"
                                                                                       style="font-size: 15px"></i>&nbsp;
                                    تعديل الحساب</a></li>
                            <li class="dropdown-item" style=""><a href="{{url('')}}/logoutSchool"><i
                                            class="fa fa-share-square"></i>&nbsp; تسجيل الخروج</a></li>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
