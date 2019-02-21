@extends('layouts.app')

@section('custom-content')
    <style type="text/css">
        .nav02{
            position: relative;
            min-height: 150px !important;
            background: url({{url("images/nav2bg3.jpg")}}) no-repeat  !important;
            background-attachment: fixed;
            background-size:contain;
        }
        ul li.head_title h2{
            display: none !important;
        }
    </style>
    <div class="container">
        <div class="container main-container">
            <div class="col-md-12">
                <!--paneeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeel-->
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <h2 class="">لوحة التحكم الرئيسية</h2>
                            <br>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="alert alert-success">
                                لوريم ايبسوم هو نموذج افتراضي يوضع في التصاميم لتعرض على العميل ليتصور طريقه وضع النصوص بالتصاميم سواء كانت تصاميم مطبوعه.
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="panel panel-success">
                                <div class="panel-heading">
                                    <svg class="svg-inline--fa fa-bell fa-w-14 fa-fw" aria-hidden="true" data-prefix="fa" data-icon="bell" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg=""><path fill="currentColor" d="M433.884 366.059C411.634 343.809 384 316.118 384 208c0-79.394-57.831-145.269-133.663-157.83A31.845 31.845 0 0 0 256 32c0-17.673-14.327-32-32-32s-32 14.327-32 32c0 6.75 2.095 13.008 5.663 18.17C121.831 62.731 64 128.606 64 208c0 108.118-27.643 135.809-49.893 158.059C-16.042 396.208 5.325 448 48.048 448H160c0 35.346 28.654 64 64 64s64-28.654 64-64h111.943c42.638 0 64.151-51.731 33.941-81.941zM224 472a8 8 0 0 1 0 16c-22.056 0-40-17.944-40-40h16c0 13.234 10.766 24 24 24z"></path></svg><!-- <i class="fa fa-bell fa-fw"></i> --> الإشعارات
                                </div>
                                <!-- /.panel-heading -->
                                <div class="panel-body">
                                    <div class="list-group">
                                        <a href="#" class="list-group-item">
                                            <svg class="svg-inline--fa fa-comment fa-w-18 fa-1x" aria-hidden="true" data-prefix="fa" data-icon="comment" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" data-fa-i2svg=""><path fill="currentColor" d="M576 240c0 115-129 208-288 208-48.3 0-93.9-8.6-133.9-23.8-40.3 31.2-89.8 50.3-142.4 55.7-5.2.6-10.2-2.8-11.5-7.7-1.3-5 2.7-8.1 6.6-11.8 19.3-18.4 42.7-32.8 51.9-94.6C21.9 330.9 0 287.3 0 240 0 125.1 129 32 288 32s288 93.1 288 208z"></path></svg><!-- <i class="fa fa-comment fa-1x"></i> --> محتوي جديد
                                            <span class="pull-left text-muted small"><em>4 دقيقية</em>
                           </span>
                                        </a>
                                        <a href="#" class="list-group-item">
                                            <svg class="svg-inline--fa fa-users fa-w-20 fa-fw" aria-hidden="true" data-prefix="fa" data-icon="users" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512" data-fa-i2svg=""><path fill="currentColor" d="M320 64c57.99 0 105 47.01 105 105s-47.01 105-105 105-105-47.01-105-105S262.01 64 320 64zm113.463 217.366l-39.982-9.996c-49.168 35.365-108.766 27.473-146.961 0l-39.982 9.996C174.485 289.379 152 318.177 152 351.216V412c0 19.882 16.118 36 36 36h264c19.882 0 36-16.118 36-36v-60.784c0-33.039-22.485-61.837-54.537-69.85zM528 300c38.66 0 70-31.34 70-70s-31.34-70-70-70-70 31.34-70 70 31.34 70 70 70zm-416 0c38.66 0 70-31.34 70-70s-31.34-70-70-70-70 31.34-70 70 31.34 70 70 70zm24 112v-60.784c0-16.551 4.593-32.204 12.703-45.599-29.988 14.72-63.336 8.708-85.69-7.37l-26.655 6.664C14.99 310.252 0 329.452 0 351.477V392c0 13.255 10.745 24 24 24h112.169a52.417 52.417 0 0 1-.169-4zm467.642-107.09l-26.655-6.664c-27.925 20.086-60.89 19.233-85.786 7.218C499.369 318.893 504 334.601 504 351.216V412c0 1.347-.068 2.678-.169 4H616c13.255 0 24-10.745 24-24v-40.523c0-22.025-14.99-41.225-36.358-46.567z"></path></svg><!-- <i class="fa fa-users fa-fw"></i> --> مستخدمين جدد
                                            <span class="pull-left text-muted small"><em>12 دقيقية </em>
                           </span>
                                        </a>
                                        <a href="#" class="list-group-item">
                                            <svg class="svg-inline--fa fa-envelope fa-w-16 fa-fw" aria-hidden="true" data-prefix="fa" data-icon="envelope" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg=""><path fill="currentColor" d="M502.3 190.8c3.9-3.1 9.7-.2 9.7 4.7V400c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V195.6c0-5 5.7-7.8 9.7-4.7 22.4 17.4 52.1 39.5 154.1 113.6 21.1 15.4 56.7 47.8 92.2 47.6 35.7.3 72-32.8 92.3-47.6 102-74.1 131.6-96.3 154-113.7zM256 320c23.2.4 56.6-29.2 73.4-41.4 132.7-96.3 142.8-104.7 173.4-128.7 5.8-4.5 9.2-11.5 9.2-18.9v-19c0-26.5-21.5-48-48-48H48C21.5 64 0 85.5 0 112v19c0 7.4 3.4 14.3 9.2 18.9 30.6 23.9 40.7 32.4 173.4 128.7 16.8 12.2 50.2 41.8 73.4 41.4z"></path></svg><!-- <i class="fa fa-envelope fa-fw"></i> --> رسالة
                                            <span class="pull-left text-muted small"><em>27 دقيقية</em>
                           </span>
                                        </a>
                                        <a href="#" class="list-group-item">
                                            <svg class="svg-inline--fa fa-tasks fa-w-16 fa-fw" aria-hidden="true" data-prefix="fa" data-icon="tasks" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg=""><path fill="currentColor" d="M208 132h288c8.8 0 16-7.2 16-16V76c0-8.8-7.2-16-16-16H208c-8.8 0-16 7.2-16 16v40c0 8.8 7.2 16 16 16zm0 160h288c8.8 0 16-7.2 16-16v-40c0-8.8-7.2-16-16-16H208c-8.8 0-16 7.2-16 16v40c0 8.8 7.2 16 16 16zm0 160h288c8.8 0 16-7.2 16-16v-40c0-8.8-7.2-16-16-16H208c-8.8 0-16 7.2-16 16v40c0 8.8 7.2 16 16 16zM64 368c-26.5 0-48.6 21.5-48.6 48s22.1 48 48.6 48 48-21.5 48-48-21.5-48-48-48zm92.5-299l-72.2 72.2-15.6 15.6c-4.7 4.7-12.9 4.7-17.6 0L3.5 109.4c-4.7-4.7-4.7-12.3 0-17l15.7-15.7c4.7-4.7 12.3-4.7 17 0l22.7 22.1 63.7-63.3c4.7-4.7 12.3-4.7 17 0l17 16.5c4.6 4.7 4.6 12.3-.1 17zm0 159.6l-72.2 72.2-15.7 15.7c-4.7 4.7-12.9 4.7-17.6 0L3.5 269c-4.7-4.7-4.7-12.3 0-17l15.7-15.7c4.7-4.7 12.3-4.7 17 0l22.7 22.1 63.7-63.7c4.7-4.7 12.3-4.7 17 0l17 17c4.6 4.6 4.6 12.2-.1 16.9z"></path></svg><!-- <i class="fa fa-tasks fa-fw"></i> --> مهام
                                            <span class="pull-left text-muted small"><em>43 دقيقية</em>
                           </span>
                                        </a>
                                        <a href="#" class="list-group-item">
                                            <svg class="svg-inline--fa fa-exclamation fa-w-6 fa-fw" aria-hidden="true" data-prefix="fa" data-icon="exclamation" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 192 512" data-fa-i2svg=""><path fill="currentColor" d="M176 432c0 44.112-35.888 80-80 80s-80-35.888-80-80 35.888-80 80-80 80 35.888 80 80zM25.26 25.199l13.6 272C39.499 309.972 50.041 320 62.83 320h66.34c12.789 0 23.331-10.028 23.97-22.801l13.6-272C167.425 11.49 156.496 0 142.77 0H49.23C35.504 0 24.575 11.49 25.26 25.199z"></path></svg><!-- <i class="fa fa-exclamation fa-fw"></i> --> عطل في السيرفر
                                            <span class="pull-left text-muted small"><em>10:57 ص</em>
                           </span>
                                        </a>
                                    </div>
                                    <!-- /.list-group -->
                                    <a href="#" class="btn btn-success btn-block">عرض الإشعارات</a>
                                </div>
                                <!-- /.panel-body -->
                            </div>


                            <!-- /.panel-footer -->
                        </div>

                        <div class="col-lg-3">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <div class="row">
                                        <div class="col-xs-4">
                                            <svg class="svg-inline--fa fa-window-restore fa-w-16 fa-2x" aria-hidden="true" data-prefix="fa" data-icon="window-restore" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg=""><path fill="currentColor" d="M512 48v288c0 26.5-21.5 48-48 48h-48V176c0-44.1-35.9-80-80-80H128V48c0-26.5 21.5-48 48-48h288c26.5 0 48 21.5 48 48zM384 176v288c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V176c0-26.5 21.5-48 48-48h288c26.5 0 48 21.5 48 48zm-68 28c0-6.6-5.4-12-12-12H76c-6.6 0-12 5.4-12 12v52h252v-52z"></path></svg><!-- <i class="fa fa-window-restore fa-2x"></i> -->
                                        </div>
                                        <div class="col-xs-8 text-right">
                                            <div class="huge">26</div>
                                            <div>الدروس التعليمية</div>
                                        </div>
                                    </div>
                                    <hr>
                                    <svg class="svg-inline--fa fa-window-restore fa-w-16 pull-righ fa-1x" aria-hidden="true" data-prefix="fa" data-icon="window-restore" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg=""><path fill="currentColor" d="M512 48v288c0 26.5-21.5 48-48 48h-48V176c0-44.1-35.9-80-80-80H128V48c0-26.5 21.5-48 48-48h288c26.5 0 48 21.5 48 48zM384 176v288c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V176c0-26.5 21.5-48 48-48h288c26.5 0 48 21.5 48 48zm-68 28c0-6.6-5.4-12-12-12H76c-6.6 0-12 5.4-12 12v52h252v-52z"></path></svg><!-- <i class="pull-righ fa fa-window-restore fa-1x"></i> -->&nbsp;المنشور :15<br>
                                    <svg class="svg-inline--fa fa-window-restore fa-w-16 pull-righ fa-1x" aria-hidden="true" data-prefix="fa" data-icon="window-restore" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg=""><path fill="currentColor" d="M512 48v288c0 26.5-21.5 48-48 48h-48V176c0-44.1-35.9-80-80-80H128V48c0-26.5 21.5-48 48-48h288c26.5 0 48 21.5 48 48zM384 176v288c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V176c0-26.5 21.5-48 48-48h288c26.5 0 48 21.5 48 48zm-68 28c0-6.6-5.4-12-12-12H76c-6.6 0-12 5.4-12 12v52h252v-52z"></path></svg><!-- <i class="pull-righ fa fa-window-restore fa-1x"></i> -->&nbsp;المحذوف :15<br>
                                    <svg class="svg-inline--fa fa-window-restore fa-w-16 pull-righ fa-1x" aria-hidden="true" data-prefix="fa" data-icon="window-restore" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg=""><path fill="currentColor" d="M512 48v288c0 26.5-21.5 48-48 48h-48V176c0-44.1-35.9-80-80-80H128V48c0-26.5 21.5-48 48-48h288c26.5 0 48 21.5 48 48zM384 176v288c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V176c0-26.5 21.5-48 48-48h288c26.5 0 48 21.5 48 48zm-68 28c0-6.6-5.4-12-12-12H76c-6.6 0-12 5.4-12 12v52h252v-52z"></path></svg><!-- <i class="pull-righ fa fa-window-restore fa-1x"></i> -->&nbsp;تحت المراجعة :15
                                </div>
                                <a href="#">
                                    <div class="panel-footer">
                                        <span class="pull-right">عرض التفاصيل</span>
                                        <span class="pull-left"><svg class="svg-inline--fa fa-arrow-circle-right fa-w-16" aria-hidden="true" data-prefix="fa" data-icon="arrow-circle-right" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg=""><path fill="currentColor" d="M256 8c137 0 248 111 248 248S393 504 256 504 8 393 8 256 119 8 256 8zm-28.9 143.6l75.5 72.4H120c-13.3 0-24 10.7-24 24v16c0 13.3 10.7 24 24 24h182.6l-75.5 72.4c-9.7 9.3-9.9 24.8-.4 34.3l11 10.9c9.4 9.4 24.6 9.4 33.9 0L404.3 273c9.4-9.4 9.4-24.6 0-33.9L271.6 106.3c-9.4-9.4-24.6-9.4-33.9 0l-11 10.9c-9.5 9.6-9.3 25.1.4 34.4z"></path></svg><!-- <i class="fa fa-arrow-circle-right"></i> --></span>
                                        <div class="clearfix"></div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="panel panel-green">
                                <div class="panel-heading">
                                    <div class="row">
                                        <div class="col-xs-4">
                                            <svg class="svg-inline--fa fa-users fa-w-20 fa-2x" aria-hidden="true" data-prefix="fa" data-icon="users" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512" data-fa-i2svg=""><path fill="currentColor" d="M320 64c57.99 0 105 47.01 105 105s-47.01 105-105 105-105-47.01-105-105S262.01 64 320 64zm113.463 217.366l-39.982-9.996c-49.168 35.365-108.766 27.473-146.961 0l-39.982 9.996C174.485 289.379 152 318.177 152 351.216V412c0 19.882 16.118 36 36 36h264c19.882 0 36-16.118 36-36v-60.784c0-33.039-22.485-61.837-54.537-69.85zM528 300c38.66 0 70-31.34 70-70s-31.34-70-70-70-70 31.34-70 70 31.34 70 70 70zm-416 0c38.66 0 70-31.34 70-70s-31.34-70-70-70-70 31.34-70 70 31.34 70 70 70zm24 112v-60.784c0-16.551 4.593-32.204 12.703-45.599-29.988 14.72-63.336 8.708-85.69-7.37l-26.655 6.664C14.99 310.252 0 329.452 0 351.477V392c0 13.255 10.745 24 24 24h112.169a52.417 52.417 0 0 1-.169-4zm467.642-107.09l-26.655-6.664c-27.925 20.086-60.89 19.233-85.786 7.218C499.369 318.893 504 334.601 504 351.216V412c0 1.347-.068 2.678-.169 4H616c13.255 0 24-10.745 24-24v-40.523c0-22.025-14.99-41.225-36.358-46.567z"></path></svg><!-- <i class="fa fa-users fa-2x"></i> -->
                                        </div>
                                        <div class="col-xs-8 text-right">
                                            <div class="huge">12</div>
                                            <div>المستخدمين</div>

                                        </div>
                                    </div>
                                    <hr>
                                    <svg class="svg-inline--fa fa-window-restore fa-w-16 pull-righ fa-1x" aria-hidden="true" data-prefix="fa" data-icon="window-restore" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg=""><path fill="currentColor" d="M512 48v288c0 26.5-21.5 48-48 48h-48V176c0-44.1-35.9-80-80-80H128V48c0-26.5 21.5-48 48-48h288c26.5 0 48 21.5 48 48zM384 176v288c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V176c0-26.5 21.5-48 48-48h288c26.5 0 48 21.5 48 48zm-68 28c0-6.6-5.4-12-12-12H76c-6.6 0-12 5.4-12 12v52h252v-52z"></path></svg><!-- <i class="pull-righ fa fa-window-restore fa-1x"></i> -->&nbsp;المنشور :15<br>
                                    <svg class="svg-inline--fa fa-window-restore fa-w-16 pull-righ fa-1x" aria-hidden="true" data-prefix="fa" data-icon="window-restore" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg=""><path fill="currentColor" d="M512 48v288c0 26.5-21.5 48-48 48h-48V176c0-44.1-35.9-80-80-80H128V48c0-26.5 21.5-48 48-48h288c26.5 0 48 21.5 48 48zM384 176v288c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V176c0-26.5 21.5-48 48-48h288c26.5 0 48 21.5 48 48zm-68 28c0-6.6-5.4-12-12-12H76c-6.6 0-12 5.4-12 12v52h252v-52z"></path></svg><!-- <i class="pull-righ fa fa-window-restore fa-1x"></i> -->&nbsp;المحذوف :15<br>
                                    <svg class="svg-inline--fa fa-window-restore fa-w-16 pull-righ fa-1x" aria-hidden="true" data-prefix="fa" data-icon="window-restore" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg=""><path fill="currentColor" d="M512 48v288c0 26.5-21.5 48-48 48h-48V176c0-44.1-35.9-80-80-80H128V48c0-26.5 21.5-48 48-48h288c26.5 0 48 21.5 48 48zM384 176v288c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V176c0-26.5 21.5-48 48-48h288c26.5 0 48 21.5 48 48zm-68 28c0-6.6-5.4-12-12-12H76c-6.6 0-12 5.4-12 12v52h252v-52z"></path></svg><!-- <i class="pull-righ fa fa-window-restore fa-1x"></i> -->&nbsp;تحت المراجعة :15
                                </div>
                                <a href="#">
                                    <div class="panel-footer">
                                        <span class="pull-right">عرض التفاصيل</span>
                                        <span class="pull-left"><svg class="svg-inline--fa fa-arrow-circle-right fa-w-16" aria-hidden="true" data-prefix="fa" data-icon="arrow-circle-right" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg=""><path fill="currentColor" d="M256 8c137 0 248 111 248 248S393 504 256 504 8 393 8 256 119 8 256 8zm-28.9 143.6l75.5 72.4H120c-13.3 0-24 10.7-24 24v16c0 13.3 10.7 24 24 24h182.6l-75.5 72.4c-9.7 9.3-9.9 24.8-.4 34.3l11 10.9c9.4 9.4 24.6 9.4 33.9 0L404.3 273c9.4-9.4 9.4-24.6 0-33.9L271.6 106.3c-9.4-9.4-24.6-9.4-33.9 0l-11 10.9c-9.5 9.6-9.3 25.1.4 34.4z"></path></svg><!-- <i class="fa fa-arrow-circle-right"></i> --></span>
                                        <div class="clearfix"></div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <!--  <div class="col-lg-2">
                            <div class="panel panel-yellow">
                               <div class="panel-heading">
                                  <div class="row">
                                     <div class="col-xs-4">
                                        <i class="fa fa-flag fa-2x"></i>
                                     </div>
                                     <div class="col-xs-8 text-right">
                                        <div class="huge">124</div>
                                        <div>الدول</div>
                                        <br>
                                     </div>
                                  </div>
                                  <hr>
                                  <i class="pull-righ fa fa-window-restore fa-1x"></i>&nbsp;المنشور :15<br>
                                  <i class="pull-righ fa fa-window-restore fa-1x"></i>&nbsp;المحذوف :15<br>
                                  <i class="pull-righ fa fa-window-restore fa-1x"></i>&nbsp;تحت المراجعة :15
                               </div>
                               <a href="#">
                                  <div class="panel-footer">
                                     <span class="pull-right">عرض التفاصيل</span>
                                     <span class="pull-left"><i class="fa fa-arrow-circle-right"></i></span>
                                     <div class="clearfix"></div>
                                  </div>
                               </a>
                            </div>
                         </div> -->
                        <div class="col-lg-3">
                            <div class="panel panel-red">
                                <div class="panel-heading">
                                    <div class="row">
                                        <div class="col-xs-4">
                                            <svg class="svg-inline--fa fa-sitemap fa-w-20 fa-2x" aria-hidden="true" data-prefix="fa" data-icon="sitemap" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512" data-fa-i2svg=""><path fill="currentColor" d="M616 320h-48v-48c0-22.056-17.944-40-40-40H344v-40h48c13.255 0 24-10.745 24-24V24c0-13.255-10.745-24-24-24H248c-13.255 0-24 10.745-24 24v144c0 13.255 10.745 24 24 24h48v40H112c-22.056 0-40 17.944-40 40v48H24c-13.255 0-24 10.745-24 24v144c0 13.255 10.745 24 24 24h144c13.255 0 24-10.745 24-24V344c0-13.255-10.745-24-24-24h-48v-40h176v40h-48c-13.255 0-24 10.745-24 24v144c0 13.255 10.745 24 24 24h144c13.255 0 24-10.745 24-24V344c0-13.255-10.745-24-24-24h-48v-40h176v40h-48c-13.255 0-24 10.745-24 24v144c0 13.255 10.745 24 24 24h144c13.255 0 24-10.745 24-24V344c0-13.255-10.745-24-24-24z"></path></svg><!-- <i class="fa fa-sitemap fa-2x"></i> -->
                                        </div>
                                        <div class="col-xs-8 text-right">
                                            <div class="huge">13</div>
                                            <div>المراحل الدراسية</div>
                                        </div>
                                    </div>
                                    <hr>
                                    <svg class="svg-inline--fa fa-window-restore fa-w-16 pull-righ fa-1x" aria-hidden="true" data-prefix="fa" data-icon="window-restore" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg=""><path fill="currentColor" d="M512 48v288c0 26.5-21.5 48-48 48h-48V176c0-44.1-35.9-80-80-80H128V48c0-26.5 21.5-48 48-48h288c26.5 0 48 21.5 48 48zM384 176v288c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V176c0-26.5 21.5-48 48-48h288c26.5 0 48 21.5 48 48zm-68 28c0-6.6-5.4-12-12-12H76c-6.6 0-12 5.4-12 12v52h252v-52z"></path></svg><!-- <i class="pull-righ fa fa-window-restore fa-1x"></i> -->&nbsp;المنشور :15<br>
                                    <svg class="svg-inline--fa fa-window-restore fa-w-16 pull-righ fa-1x" aria-hidden="true" data-prefix="fa" data-icon="window-restore" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg=""><path fill="currentColor" d="M512 48v288c0 26.5-21.5 48-48 48h-48V176c0-44.1-35.9-80-80-80H128V48c0-26.5 21.5-48 48-48h288c26.5 0 48 21.5 48 48zM384 176v288c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V176c0-26.5 21.5-48 48-48h288c26.5 0 48 21.5 48 48zm-68 28c0-6.6-5.4-12-12-12H76c-6.6 0-12 5.4-12 12v52h252v-52z"></path></svg><!-- <i class="pull-righ fa fa-window-restore fa-1x"></i> -->&nbsp;المحذوف :15<br>
                                    <svg class="svg-inline--fa fa-window-restore fa-w-16 pull-righ fa-1x" aria-hidden="true" data-prefix="fa" data-icon="window-restore" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg=""><path fill="currentColor" d="M512 48v288c0 26.5-21.5 48-48 48h-48V176c0-44.1-35.9-80-80-80H128V48c0-26.5 21.5-48 48-48h288c26.5 0 48 21.5 48 48zM384 176v288c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V176c0-26.5 21.5-48 48-48h288c26.5 0 48 21.5 48 48zm-68 28c0-6.6-5.4-12-12-12H76c-6.6 0-12 5.4-12 12v52h252v-52z"></path></svg><!-- <i class="pull-righ fa fa-window-restore fa-1x"></i> -->&nbsp;تحت المراجعة :15
                                </div>
                                <a href="#">
                                    <div class="panel-footer">
                                        <span class="pull-right">عرض التفاصيل</span>
                                        <span class="pull-left"><svg class="svg-inline--fa fa-arrow-circle-right fa-w-16" aria-hidden="true" data-prefix="fa" data-icon="arrow-circle-right" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg=""><path fill="currentColor" d="M256 8c137 0 248 111 248 248S393 504 256 504 8 393 8 256 119 8 256 8zm-28.9 143.6l75.5 72.4H120c-13.3 0-24 10.7-24 24v16c0 13.3 10.7 24 24 24h182.6l-75.5 72.4c-9.7 9.3-9.9 24.8-.4 34.3l11 10.9c9.4 9.4 24.6 9.4 33.9 0L404.3 273c9.4-9.4 9.4-24.6 0-33.9L271.6 106.3c-9.4-9.4-24.6-9.4-33.9 0l-11 10.9c-9.5 9.6-9.3 25.1.4 34.4z"></path></svg><!-- <i class="fa fa-arrow-circle-right"></i> --></span>
                                        <div class="clearfix"></div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <!--                <div class="col-lg-2">
                                          <div class="panel panel-green">
                                             <div class="panel-heading">
                                                <div class="row">
                                                   <div class="col-xs-4">
                                                      <i class="fa fa-filter fa-2x"></i>
                                                   </div>
                                                   <div class="col-xs-8 text-right">
                                                      <div class="huge">13</div>
                                                      <div>التصنيفات</div>
                                                      <br>
                                                   </div>
                                                </div>
                                                <hr>
                                                <i class="pull-righ fa fa-window-restore fa-1x"></i>&nbsp;المنشور :15<br>
                                                <i class="pull-righ fa fa-window-restore fa-1x"></i>&nbsp;المحذوف :15<br>
                                                <i class="pull-righ fa fa-window-restore fa-1x"></i>&nbsp;تحت المراجعة :15
                                             </div>
                                             <a href="#">
                                                <div class="panel-footer">
                                                   <span class="pull-right">عرض التفاصيل</span>
                                                   <span class="pull-left"><i class="fa fa-arrow-circle-right"></i></span>
                                                   <div class="clearfix"></div>
                                                </div>
                                             </a>
                                          </div>
                                       </div>
                                       <div class="col-lg-2">
                                          <div class="panel panel-yellow">
                                             <div class="panel-heading">
                                                <div class="row">
                                                   <div class="col-xs-4">
                                                      <i class="fa fa-hourglass fa-2x"></i>
                                                   </div>
                                                   <div class="col-xs-8 text-right">
                                                      <div class="huge">13</div>
                                                      <div>نواتج التعلم</div>
                                                      <br>
                                                   </div>
                                                </div>
                                                <hr>
                                                <i class="pull-righ fa fa-window-restore fa-1x"></i>&nbsp;المنشور :15<br>
                                                <i class="pull-righ fa fa-window-restore fa-1x"></i>&nbsp;المحذوف :15<br>
                                                <i class="pull-righ fa fa-window-restore fa-1x"></i>&nbsp;تحت المراجعة :15
                                             </div>
                                             <a href="#">
                                                <div class="panel-footer">
                                                   <span class="pull-right">عرض التفاصيل</span>
                                                   <span class="pull-left"><i class="fa fa-arrow-circle-right"></i></span>
                                                   <div class="clearfix"></div>
                                                </div>
                                             </a>
                                          </div>
                                       </div> -->
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="chat-panel panel panel-success">
                                <div class="panel-heading">
                                    <svg class="svg-inline--fa fa-comments fa-w-18 fa-fw" aria-hidden="true" data-prefix="fa" data-icon="comments" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" data-fa-i2svg=""><path fill="currentColor" d="M224 358.857c-37.599 0-73.027-6.763-104.143-18.7-31.375 24.549-69.869 39.508-110.764 43.796a8.632 8.632 0 0 1-.89.047c-3.736 0-7.111-2.498-8.017-6.061-.98-3.961 2.088-6.399 5.126-9.305 15.017-14.439 33.222-25.79 40.342-74.297C17.015 266.886 0 232.622 0 195.429 0 105.16 100.297 32 224 32s224 73.159 224 163.429c-.001 90.332-100.297 163.428-224 163.428zm347.067 107.174c-13.944-13.127-30.849-23.446-37.46-67.543 68.808-64.568 52.171-156.935-37.674-207.065.031 1.334.066 2.667.066 4.006 0 122.493-129.583 216.394-284.252 211.222 38.121 30.961 93.989 50.492 156.252 50.492 34.914 0 67.811-6.148 96.704-17 29.134 22.317 64.878 35.916 102.853 39.814 3.786.395 7.363-1.973 8.27-5.467.911-3.601-1.938-5.817-4.759-8.459z"></path></svg><!-- <i class="fa fa-comments fa-fw"></i> --> الرسائل
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
                                                        <svg class="svg-inline--fa fa-clock fa-w-16 fa-fw" aria-hidden="true" data-prefix="fa" data-icon="clock" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg=""><path fill="currentColor" d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8zm57.1 350.1L224.9 294c-3.1-2.3-4.9-5.9-4.9-9.7V116c0-6.6 5.4-12 12-12h48c6.6 0 12 5.4 12 12v137.7l63.5 46.2c5.4 3.9 6.5 11.4 2.6 16.8l-28.2 38.8c-3.9 5.3-11.4 6.5-16.8 2.6z"></path></svg><!-- <i class="fa fa-clock fa-fw"></i> --> 12 دقيقة
                                                    </small>
                                                </div>
                                                <br>
                                                <p>
                                                    لوريم ايبسوم هو نموذج افتراضي يوضع في التصاميم لتعرض على العميل ليتصور طريقه وضع النصوص
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
                                                        <svg class="svg-inline--fa fa-clock fa-w-16 fa-fw" aria-hidden="true" data-prefix="fa" data-icon="clock" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg=""><path fill="currentColor" d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8zm57.1 350.1L224.9 294c-3.1-2.3-4.9-5.9-4.9-9.7V116c0-6.6 5.4-12 12-12h48c6.6 0 12 5.4 12 12v137.7l63.5 46.2c5.4 3.9 6.5 11.4 2.6 16.8l-28.2 38.8c-3.9 5.3-11.4 6.5-16.8 2.6z"></path></svg><!-- <i class="fa fa-clock fa-fw"></i> --> 12 دقيقة
                                                    </small>
                                                </div>
                                                <br>
                                                <p>
                                                    لوريم ايبسوم هو نموذج افتراضي يوضع في التصاميم لتعرض على العميل ليتصور طريقه وضع النصوص
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
                                                        <svg class="svg-inline--fa fa-clock fa-w-16 fa-fw" aria-hidden="true" data-prefix="fa" data-icon="clock" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg=""><path fill="currentColor" d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8zm57.1 350.1L224.9 294c-3.1-2.3-4.9-5.9-4.9-9.7V116c0-6.6 5.4-12 12-12h48c6.6 0 12 5.4 12 12v137.7l63.5 46.2c5.4 3.9 6.5 11.4 2.6 16.8l-28.2 38.8c-3.9 5.3-11.4 6.5-16.8 2.6z"></path></svg><!-- <i class="fa fa-clock fa-fw"></i> --> 12 دقيقة
                                                    </small>
                                                </div>
                                                <br>
                                                <p>
                                                    لوريم ايبسوم هو نموذج افتراضي يوضع في التصاميم لتعرض على العميل ليتصور طريقه وضع النصوص
                                                </p>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <!-- /.panel-body -->
                                <div class="panel-footer">
                                    <div class="input-group">
                                        <input id="btn-input" type="text" class="form-control input-sm" placeholder="أكتب رسالتك هنا ...">
                                        <span class="input-group-btn">
                                      <button class="btn btn-success btn-sm" id="btn-chat">
                                      إرسال
                                      </button>
                                      </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-9">
                            <div class="Compose-Message">
                                <div class="panel panel-success">
                                    <div class="panel-heading">
                                        <svg class="svg-inline--fa fa-bell fa-w-14 fa-fw" aria-hidden="true" data-prefix="fa" data-icon="bell" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg=""><path fill="currentColor" d="M433.884 366.059C411.634 343.809 384 316.118 384 208c0-79.394-57.831-145.269-133.663-157.83A31.845 31.845 0 0 0 256 32c0-17.673-14.327-32-32-32s-32 14.327-32 32c0 6.75 2.095 13.008 5.663 18.17C121.831 62.731 64 128.606 64 208c0 108.118-27.643 135.809-49.893 158.059C-16.042 396.208 5.325 448 48.048 448H160c0 35.346 28.654 64 64 64s64-28.654 64-64h111.943c42.638 0 64.151-51.731 33.941-81.941zM224 472a8 8 0 0 1 0 16c-22.056 0-40-17.944-40-40h16c0 13.234 10.766 24 24 24z"></path></svg><!-- <i class="fa fa-bell fa-fw"></i> --> الإحصائيات
                                    </div>
                                    <div class="panel-body">

                                        <img src="images/chart.png" style="float:left;width:37%;padding: 20px;">
                                        <div style="float:right;width:60%;">
                                            <br><br><br><svg style="color: #00838f;" class="svg-inline--fa fa-circle fa-w-16" aria-hidden="true" data-prefix="fa" data-icon="circle" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg=""><path fill="currentColor" d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8z"></path></svg><!-- <span style="color: #00838f;" class="fa fa-circle"></span> -->&nbsp;عنوان عنوان عنوان عنوان<br>
                                            <svg style="color: #ef5350;" class="svg-inline--fa fa-circle fa-w-16" aria-hidden="true" data-prefix="fa" data-icon="circle" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg=""><path fill="currentColor" d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8z"></path></svg><!-- <span style="color: #ef5350;" class="fa fa-circle"></span> -->&nbsp;عنوان عنوان عنوان عنوان<br>
                                            <svg style="color: #ffce00;" class="svg-inline--fa fa-circle fa-w-16" aria-hidden="true" data-prefix="fa" data-icon="circle" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg=""><path fill="currentColor" d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8z"></path></svg><!-- <span style="color: #ffce00;" class="fa fa-circle"></span> -->&nbsp;عنوان عنوان عنوان عنوان<br><br><br><br>
                                            <p>لوريم ايبسوم هو نموذج افتراضي يوضع في التصاميم لتعرض على العميل ليتصور طريقه وضع النصوص بالتصاميم سواء كانت تصاميم مطبوعهلوريم ايبسوم هو نموذج افتراضي يوضع في التصاميم لتعرض على العميل ليتصور طريقه وضع النصوص بالتصاميم سواء كانت تصاميم </p>
                                        </div>

                                    </div>
                                    <div class="panel-footer text-muted">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3"></div>
                        <div class="col-md-4">
                            <div class="panel panel-green">
                                <div class="panel-heading">
                                    <svg class="svg-inline--fa fa-bell fa-w-14 fa-fw" aria-hidden="true" data-prefix="fa" data-icon="bell" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg=""><path fill="currentColor" d="M433.884 366.059C411.634 343.809 384 316.118 384 208c0-79.394-57.831-145.269-133.663-157.83A31.845 31.845 0 0 0 256 32c0-17.673-14.327-32-32-32s-32 14.327-32 32c0 6.75 2.095 13.008 5.663 18.17C121.831 62.731 64 128.606 64 208c0 108.118-27.643 135.809-49.893 158.059C-16.042 396.208 5.325 448 48.048 448H160c0 35.346 28.654 64 64 64s64-28.654 64-64h111.943c42.638 0 64.151-51.731 33.941-81.941zM224 472a8 8 0 0 1 0 16c-22.056 0-40-17.944-40-40h16c0 13.234 10.766 24 24 24z"></path></svg><!-- <i class="fa fa-bell fa-fw"></i> --> الإحصائيات
                                </div>
                                <div class="panel-body">
                                    <p>لوريم ايبسوم هو نموذج افتراضي يوضع في التصاميم لتعرض على العميل ليتصور طريقه وضع النصوص بالتصاميم سواء كانت تصاميم مطبوعهلوريم ايبسوم هو نموذج افتراضي يوضع في التصاميم لتعرض على العميل ليتصور طريقه وضع النصوص بالتصاميم سواء كانت تصاميم.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="panel panel-green">
                                <div class="panel-heading">
                                    <svg class="svg-inline--fa fa-bell fa-w-14 fa-fw" aria-hidden="true" data-prefix="fa" data-icon="bell" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg=""><path fill="currentColor" d="M433.884 366.059C411.634 343.809 384 316.118 384 208c0-79.394-57.831-145.269-133.663-157.83A31.845 31.845 0 0 0 256 32c0-17.673-14.327-32-32-32s-32 14.327-32 32c0 6.75 2.095 13.008 5.663 18.17C121.831 62.731 64 128.606 64 208c0 108.118-27.643 135.809-49.893 158.059C-16.042 396.208 5.325 448 48.048 448H160c0 35.346 28.654 64 64 64s64-28.654 64-64h111.943c42.638 0 64.151-51.731 33.941-81.941zM224 472a8 8 0 0 1 0 16c-22.056 0-40-17.944-40-40h16c0 13.234 10.766 24 24 24z"></path></svg><!-- <i class="fa fa-bell fa-fw"></i> --> الإحصائيات
                                </div>
                                <div class="panel-body">
                                    <p>لوريم ايبسوم هو نموذج افتراضي يوضع في التصاميم لتعرض على العميل ليتصور طريقه وضع النصوص بالتصاميم سواء كانت تصاميم مطبوعهلوريم ايبسوم هو نموذج افتراضي يوضع في التصاميم لتعرض على العميل ليتصور طريقه وضع النصوص بالتصاميم سواء كانت تصاميم.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--paneeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeel-->
            </div>
        </div>

@endsection
