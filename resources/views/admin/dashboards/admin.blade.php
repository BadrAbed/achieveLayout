@extends("layouts.app")


@section("custom-content")
    @php
        $grouped = $users->groupBy('is_permission');


        $groupCount = $grouped->map(function ($item, $key) {
        return collect($item)->count();
        });

        $grouped_contents = $contents->groupBy('flowStatus');


        $groupCount_contents = $grouped_contents->map(function ($item, $key) {
        return collect($item)->count();
        });

        $schools=\App\School::all()->count();

    @endphp

    <div class="content-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="">لوحة التحكم الرئيسية</h2>
                    <br>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="panel" style="background-color: #05932a !important;color: #fff;padding: 25px;">
                        تعطيك لوحة التحكم الرئيسية لمحه عن التقدم الشامل الخاص بك ومعلومات الحساب العامه
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-4">
                                    <i class="fa fa-window-restore fa-2x"></i>
                                </div>
                                <div class="col-xs-8 text-right">
                                    <div class="huge">{{count($contents)}}</div>
                                    <br>
                                    <div style="font-size: 18px;">الدروس التعليمية</div>
                                </div>
                            </div>
                            <hr>

                            <i class="pull-righ fa fa-window-restore fa-1x"></i> <span class="badge badge-default"
                                                                                       style="font-size: 15px;">&nbsp; المنشور :{{ (isset($groupCount_contents[7]))?$groupCount_contents[7]:'0'}}</span><br><br>
                            <i class="pull-righ fa fa-filter fa-1x"></i> <span class="badge badge-default"
                                                                               style="font-size: 15px;">&nbsp; تحت الانشاء : {{ (isset($groupCount_contents[1]))?$groupCount_contents[1]:'0'}} </span><br><br>
                            <i class="pull-righ fa fa-search fa-1x"></i> <span class="badge badge-default"
                                                                               style="font-size: 15px;">&nbsp;تحت المراجعة :


                                {{ (isset($groupCount_contents[1])&&isset($groupCount_contents[7]))?count($contents)-($groupCount_contents[1]+$groupCount_contents[7]):count($contents),
                                (isset($groupCount_contents[1])&&!isset($groupCount_contents[7]))?count($contents)-$groupCount_contents[1]:count($contents),
                                (isset($groupCount_contents[7])&&!isset($groupCount_contents[1]))?count($contents)-$groupCount_contents[7]:count($contents)




                                                                                                 }}</span><br><br>
                        </div>
                        <a href="{{url("content")}}">
                            <div class="panel-footer">
                                <span class="pull-right">عرض التفاصيل</span>
                                <span class="pull-left"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-4">
                                    <i class="fa fa-users fa-2x"></i>
                                </div>
                                <div class="col-xs-8 text-right">
                                    <div class="huge">{{count($users)+$schools}}</div>
                                    <br>
                                    <div style="font-size: 18px;">المستخدمين</div>

                                </div>
                            </div>
                            <hr>
                            <i class="pull-righ fa fa-cog fa-1x"></i> <span class="badge badge-default"
                                                                            style="background-color:#fff;color:green;font-size: 15px;">&nbsp; الادارة :{{ (isset($groupCount[4]))?count($users)-$groupCount[4]:count($users)}}</span><br><br>
                            <i class="pull-righ fa fa-users fa-1x"></i> <span class="badge badge-default"
                                                                              style="background-color:#fff;color:green;font-size: 15px;">&nbsp;الطلاب :{{ (isset($groupCount[4]))?$groupCount[4]:'0'}}</span><br><br>
                            <i class="pull-righ fa fa-university fa-1x"></i> <span class="badge badge-default"
                                                                                   style="background-color:#fff;color:green;font-size: 15px;">&nbsp;المدارس :{{$schools}}</span><br><br>
                        </div>
                        <a href="{{url("users")}}">
                            <div class="panel-footer">
                                <span class="pull-right">عرض التفاصيل</span>
                                <span class="pull-left"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-yellow">
                        <div class="panel-heading">
                            <div class="row">

                                <div class="col-xs-4">
                                    <i class="fa fa-flag fa-2x"></i>
                                </div>
                                <div class="col-xs-8 text-right">
                                    <div class="huge">{{count($countries)}}</div>
                                    <div>الدول</div>
                                    <br>
                                </div>
                            </div>
                            {{--<hr>--}}
                            {{--<i class="pull-righ fa fa-window-restore fa-1x"></i>&nbsp;المنشور :15<br>--}}
                            {{--<i class="pull-righ fa fa-window-restore fa-1x"></i>&nbsp;المحذوف :15<br>--}}
                            {{--<i class="pull-righ fa fa-window-restore fa-1x"></i>&nbsp;تحت المراجعة :15--}}


                        </div>
                        <a href="{{url("country")}}">
                            <div class="panel-footer">
                                <span class="pull-right">عرض التفاصيل</span>
                                <span class="pull-left"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                    <div class="panel panel-red">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-4">
                                    <i class="fa fa-sitemap fa-2x"></i>
                                </div>
                                <div class="col-xs-8 text-right">
                                    <div class="huge">{{count($grade)}}</div>
                                    <div>المراحل الدراسية</div>
                                </div>
                            </div>
                            <br>
                            {{--<hr>--}}
                            {{--<i class="pull-righ fa fa-window-restore fa-1x"></i>&nbsp;المنشور :15<br>--}}
                            {{--<i class="pull-righ fa fa-window-restore fa-1x"></i>&nbsp;المحذوف :15<br>--}}
                            {{--<i class="pull-righ fa fa-window-restore fa-1x"></i>&nbsp;تحت المراجعة :15--}}
                        </div>
                        <a href="{{url("education-level")}}">
                            <div class="panel-footer">
                                <span class="pull-right">عرض التفاصيل</span>
                                <span class="pull-left"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>


                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-4">
                                    <i class="fa fa-filter fa-2x"></i>
                                </div>
                                <div class="col-xs-8 text-right">
                                    <div class="huge">{{count($catgerory)}}</div>
                                    <div>التصنيفات</div>
                                    <br>
                                </div>
                            </div>
                            {{--<hr>--}}
                            {{--<i class="pull-righ fa fa-window-restore fa-1x"></i>&nbsp;المنشور :15<br>--}}
                            {{--<i class="pull-righ fa fa-window-restore fa-1x"></i>&nbsp;المحذوف :15<br>--}}
                            {{--<i class="pull-righ fa fa-window-restore fa-1x"></i>&nbsp;تحت المراجعة :15--}}
                        </div>
                        <a href="{{url("categories")}}">
                            <div class="panel-footer">
                                <span class="pull-right">عرض التفاصيل</span>
                                <span class="pull-left"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                    <div class="panel panel-yellow">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-4">
                                    <i class="fa fa-hourglass fa-2x"></i>
                                </div>
                                <div class="col-xs-8 text-right">
                                    <div class="huge">{{count($goal)}}</div>
                                    <div>نواتج التعلم</div>
                                    <br>
                                </div>
                            </div>
                            {{--<hr>--}}
                            {{--<i class="pull-righ fa fa-window-restore fa-1x"></i>&nbsp;المنشور :15<br>--}}
                            {{--<i class="pull-righ fa fa-window-restore fa-1x"></i>&nbsp;المحذوف :15<br>--}}
                            {{--<i class="pull-righ fa fa-window-restore fa-1x"></i>&nbsp;تحت المراجعة :15--}}
                        </div>
                        <a href="{{url("showgoal")}}">
                            <div class="panel-footer">
                                <span class="pull-right">عرض التفاصيل</span>
                                <span class="pull-left"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>

            </div>
            <div class="row">
                <div class="col-md-3">
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <i class="fa fa-bell fa-fw"></i> الإشعارات
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="list-group">
                                <a href="#" class="list-group-item">
                                    <i class="fa fa-comment fa-1x"></i> {{count($newcontents)}} محتوي جديد
                                    @if($timecontenthours<=0)
                                        <span class="pull-left text-muted small"><em>{{$timecontentmint}} دقيقية</em>
                              </span>
                                    @else

                                        <span class="pull-left text-muted small"><em> {{$timecontenthours}} ساعه</em>
                                            @endif
                           </span>
                                </a>
                                <a href="#" class="list-group-item">
                                    <i class="fa fa-users fa-fw"></i> {{count($newusers)}} مستخدمين جدد
                                    @if($timeuserhours<=0)
                                        <span class="pull-left text-muted small"><em>{{$timeusermint}} دقيقية </em>
                           </span>
                                    @else
                                        <span class="pull-left text-muted small"><em>{{$timeuserhours}} ساعه </em>
                           </span>
                                    @endif
                                </a>
                                <a href="#" class="list-group-item">
                                    <i class="fa fa-envelope fa-fw"></i> رسالة
                                    <span class="pull-left text-muted small"><em>27 دقيقية</em>
                           </span>
                                </a>
                                <a href="{{route('logtime')}}" class="list-group-item">
                                    <i class="fa fa-envelope fa-fw"></i> {{count($logtimes)}}الاحداث اليومية
                                    @if($timeloghours<=0)
                                        <span class="pull-left text-muted small"><em>{{$timelogmint}} دقيقية </em>
                           </span>
                                    @else
                                        <span class="pull-left text-muted small"><em>{{$timeloghours}} ساعه </em>
                           </span>
                                    @endif
                                </a>
                            </div>
                            <!-- /.list-group -->
                            <a href="#" class="btn btn-success btn-block">عرض الإشعارات</a>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <hr/>
                    <hr/>
                    <div class="chat-panel panel panel-success">
                        <div class="panel-heading">
                            <i class="fa fa-comments fa-fw"></i> الرسائل
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <ul class="chat">
                                <li class="left clearfix">
                              <span class="chat-img pull-right">
                              <img src="images/pp_admin.png" width="50%" alt="User Avatar" class="img-circle">
                              </span>
                                    <div class="chat-body clearfix">
                                        <div class="header">
                                            <strong class="pull-right primary-font">إيهاب </strong><br>
                                            <small class="pull-right text-muted">
                                                <i class="fa fa-clock fa-fw"></i> 12 دقيقة
                                            </small>
                                        </div>
                                        <br>
                                        <p>
                                            لوريم ايبسوم هو نموذج افتراضي يوضع في التصاميم لتعرض على العميل ليتصور طريقه
                                            وضع النصوص
                                        </p>
                                    </div>
                                </li>
                                <li class="left clearfix">
                              <span class="chat-img pull-right">
                              <img src="images/pp_sender.png" width="50%" alt="User Avatar" class="img-circle">
                              </span>
                                    <div class="chat-body clearfix">
                                        <div class="header">
                                            <strong class="pull-right primary-font">أحمد </strong><br>
                                            <small class="pull-right text-muted">
                                                <i class="fa fa-clock fa-fw"></i> 12 دقيقة
                                            </small>
                                        </div>
                                        <br>
                                        <p>
                                            لوريم ايبسوم هو نموذج افتراضي يوضع في التصاميم لتعرض على العميل ليتصور طريقه
                                            وضع النصوص
                                        </p>
                                    </div>
                                </li>
                                <li class="left clearfix">
                              <span class="chat-img pull-right">
                              <img src="images/pp_admin.png" width="50%" alt="User Avatar" class="img-circle">
                              </span>
                                    <div class="chat-body clearfix">
                                        <div class="header">
                                            <strong class="pull-right primary-font">إيهاب </strong><br>
                                            <small class="pull-right text-muted">
                                                <i class="fa fa-clock fa-fw"></i> 12 دقيقة
                                            </small>
                                        </div>
                                        <br>
                                        <p>
                                            لوريم ايبسوم هو نموذج افتراضي يوضع في التصاميم لتعرض على العميل ليتصور طريقه
                                            وضع النصوص
                                        </p>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <!-- /.panel-body -->
                        <div class="panel-footer">
                            <div class="input-group">
                                <input id="btn-input" type="text" class="form-control input-sm"
                                       placeholder="أكتب رسالتك هنا ...">
                                <span class="input-group-btn">
                           <button class="btn btn-success btn-sm" id="btn-chat">
                           إرسال
                           </button>
                           </span>
                            </div>
                        </div>
                        <!-- /.panel-footer -->
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="Compose-Message">
                        <div class="panel panel-success">
                            <div class="panel-heading">
                                <i class="fa fa-bell fa-fw"></i> الإحصائيات
                            </div>
                            <div class="panel-body">

                                <img src="images/chart.png" style="float:left;width:37%;padding: 20px;">
                                <div style="float:right;width:60%;">
                                    <br><br><br><span style="color: #00838f;" class="fa fa-circle"></span>&nbsp;عنوان
                                    عنوان عنوان عنوان<br>
                                    <span style="color: #ef5350;" class="fa fa-circle"></span>&nbsp;عنوان عنوان عنوان
                                    عنوان<br>
                                    <span style="color: #ffce00;" class="fa fa-circle"></span>&nbsp;عنوان عنوان عنوان
                                    عنوان<br><br><br><br>
                                    <p>لوريم ايبسوم هو نموذج افتراضي يوضع في التصاميم لتعرض على العميل ليتصور طريقه وضع
                                        النصوص بالتصاميم سواء كانت تصاميم مطبوعهلوريم ايبسوم هو نموذج افتراضي يوضع في
                                        التصاميم لتعرض على العميل ليتصور طريقه وضع النصوص بالتصاميم سواء كانت
                                        تصاميم </p>
                                </div>

                            </div>
                            <div class="panel-footer text-muted">
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>

    <script>

        setTimeout(function () {
            window.location.reload(1);
        }, 200000);
    </script>
@endsection