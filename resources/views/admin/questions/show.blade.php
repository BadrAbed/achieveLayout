{{--

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>lessons</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!--<link rel="stylesheet" href="css/bootstrap.min.css">-->
    <link rel="stylesheet" href="css/bootstrap-rtl.min.css">
    <link rel="stylesheet" href="css/semantic.min.css">
    <link rel="stylesheet" href="css/fontawesome-all.min.css">
    <link rel="stylesheet" href="css/animate.css">
    <link rel="stylesheet" href="css/main-style.css">
    <link rel="stylesheet" href="css/main-mQuery.css">
    <!--[if lt IE 9]>
    <script src="js/html5shiv.min.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->
</head>
<body>

<nav class="navbar navbar-inverse nav01">
    <div class="container">
        <div class="row">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li><a href="index.html">الرئيسية <span class="sr-only">(current)</span></a></li>
                    <li><a href="#">عرض الدروس</a></li>
                    <li><a href="#">المستخدمين</a></li>
                    <li class="active"><a href="#">اضافة درس</a></li>
                    <li><a href="#">اضافة تصنيف</a></li>
                    <li><a href="#">اضافة مرحلة</a></li>
                    <li><a href="#">اضافة دولة</a></li>
                    <li><a href="#">تحليلات</a></li>
                    <!--<li class="dropdown">-->
                    <!--<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Dropdown <span class="caret"></span></a>-->
                    <!--<ul class="dropdown-menu">-->
                    <!--<li><a href="#">Action</a></li>-->
                    <!--<li><a href="register.html">Another action</a></li>-->
                    <!--<li><a href="#">Something else here</a></li>-->
                    <!--<li role="separator" class="divider"></li>-->
                    <!--<li><a href="#">Separated link</a></li>-->
                    <!--<li role="separator" class="divider"></li>-->
                    <!--<li><a href="#">One more separated link</a></li>-->
                    <!--</ul>-->
                    <!--</li>-->
                </ul>
                <ul class="nav navbar-nav navbar-left">
                    <li class=""><a href="register.html"><i class="fas fa-sign-in-alt"></i> دخول </a></li>
                </ul>
            </div>
        </div>
    </div>
    </div>
</nav>
<nav class="navbar navbar-inverse nav02">
    <div class="container">
        <div class="row">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header navbar-header-height">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-2" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-2">
                <ul class="nav navbar-nav">
                    <li class="active"><a href="index.html">الرئيسية <span class="sr-only">(current)</span></a></li>
                    <li><a href="#">عرض الدروس</a></li>
                    <li><a href="#">المستخدمين</a></li>
                    <li><a href="add-lessons.html">اضافة درس</a></li>
                    <li><a href="#">اضافة تصنيف</a></li>
                    <li><a href="#">اضافة مرحلة</a></li>
                    <li><a href="#">اضافة دولة</a></li>
                    <li><a href="#">تحليلات</a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Dropdown <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="#">Action</a></li>
                            <li><a href="register.html">Another action</a></li>
                            <li><a href="#">Something else here</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="#">Separated link</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="#">One more separated link</a></li>
                        </ul>
                    </li>
                </ul>
                <ul class="nav navbar-nav navbar-left nav-user">
                    <li class="">
                        <a href="#" style="direction: ltr">
                            <img src="images/user-icon-boy.png">
                            <span style="color: white;margin-left: 5px">أحمد</span>
                            <span style="color: white;margin-left: 3px" class="caret"></span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    </div>
</nav>



<div class="container-margin" style="margin-top: 0">

    <div class="container">
        <div class="lesson-title">
            <p class="h3">
                عنوان الدرس
            </p>
            <p class="h5">
                عنوان الدرس الفرعى او اسم الوحدة
            </p>
        </div>
    </div>
    <div class="container">
        <div class="col-sm-8">
            <div class="row">
                <div class="tab-container">
                    <div class="main-taps">

                        <input id="tab1" type="radio" name="tabs" checked >
                        <label for="tab1">اقرأ واجب</label>

                        <input id="tab2" type="radio" name="tabs">
                        <label for="tab2">معلومة اثرائية</label>
                        <?php foreach ($quest as $quests ): ?>  <?php endforeach; ?>
                        <input id="tab3" type="radio" name="tabs"  <?php if (session()->has('data')): ?>  checked <?php endif; ?> >
                        <label for="tab3">الأنشطة</label>

                        <input id="tab4" type="radio" name="tabs">
                        <label for="tab4">العنصر الرابع</label>

                        <input id="tab5" type="radio" name="tabs" <?php if (session()->has('addationdata')): ?>  checked <?php endif; ?>>
                        <label for="tab5">  اسئله اضافيه</label>
                        <!--
                                                <input id="tab6" type="radio" name="tabs">
                                                <label for="tab6">العنصر السادس</label>-->






                        <section id="content1">
                            <p class="tabcontent">
                                هناك حقيقة مثبتة منذ زمن طويل وهي أن المحتوى المقروء لصفحة ما سيلهي القارئ عن التركيز على الشكل الخارجي للنص أو شكل توضع الفقرات في الصفحة التي يقرأها. ولذلك يتم استخدام طريقة لوريم إيبسوم لأنها تعطي توزيعاَ طبيعياَ -إلى حد ما- للأحرف عوضاً عن استخدام "هنا يوجد محتوى نصي، هنا يوجد محتوى نصي" فتجعلها تبدو (أي الأحرف) وكأنها نص مقروء. العديد من برامح النشر المكتبي وبرامح تحرير صفحات الويب تستخدم لوريم إيبسوم بشكل إفتراضي كنموذج عن النص،
                            </p>
                            <label class="t-lable">
                                <i class="fas fa-caret-left quiz-color"></i>
                                <span class="h4 quiz-color">
                                    سؤال على الفقرة السابقة؟
                                    </span>
                            </label>
                            <div class="selections">
                                <div class="field">
                                    <div class="ui radio checkbox">
                                        <input type="radio" name="example2" checked="checked">
                                        <label>الاجابة رقم واحد</label>
                                    </div>
                                </div>
                                <div class="field">
                                    <div class="ui radio checkbox">
                                        <input type="radio" name="example2">
                                        <label>الاجابة رقم اثنين</label>
                                    </div>
                                </div>
                                <div class="field">
                                    <div class="ui radio checkbox">
                                        <input type="radio" name="example2">
                                        <label>الاجابة رقم اربعة</label>
                                    </div>
                                </div>
                            </div>
                            <p>لماذا قمت باختيار هذه الاجابة؟</p>
                            <div class="ui form form-group">
                                <div class="field">
                                    <textarea rows="2"></textarea>
                                </div>
                            </div>
                            <button type="button" class="btn btn-dark">
                                ارسال
                            </button>
                        </section>


                        <section id="content2">
                            <div class="h4">
                                هذا النص عبارة عن عنوان للفقرة:
                            </div>
                            <p class="tabcontent">
                                هناك حقيقة مثبتة منذ زمن طويل وهي أن المحتوى المقروء لصفحة ما سيلهي القارئ عن التركيز على الشكل الخارجي للنص أو شكل توضع الفقرات في الصفحة التي يقرأها. ولذلك يتم استخدام طريقة لوريم إيبسوم لأنها تعطي توزيعاَ طبيعياَ -إلى حد ما- للأحرف عوضاً عن استخدام "هنا يوجد محتوى نصي، هنا يوجد محتوى نصي" فتجعلها تبدو (أي الأحرف) وكأنها نص مقروء. العديد من برامح النشر المكتبي وبرامح تحرير صفحات الويب تستخدم لوريم إيبسوم بشكل إفتراضي كنموذج عن النص،


                            </p>

                            <div class="article-image pull-right">
                                <div class="image">
                                    <img alt="image" src="images/article-pic.jpg">
                                </div>
                                <p class="caption">
                                    وصف الصورة
                                </p>
                            </div>

                            <p class="">
                                هناك حقيقة مثبتة منذ زمن طويل وهي أن المحتوى المقروء لصفحة ما سيلهي القارئ عن التركيز على الشكل الخارجي للنص أو شكل توضع الفقرات في الصفحة التي يقرأها. ولذلك يتم استخدام طريقة لوريم إيبسوم لأنها تعطي توزيعاَ طبيعياَ -إلى حد ما- للأحرف عوضاً عن استخدام "هنا يوجد محتوى نصي، هنا يوجد محتوى نصي" فتجعلها تبدو (أي الأحرف) وكأنها نص مقروء. العديد من برامح النشر المكتبي وبرامح تحرير صفحات الويب تستخدم لوريم إيبسوم بشكل إفتراضي كنموذج عن النص،
                                هناك حقيقة مثبتة منذ زمن طويل وهي أن المحتوى المقروء لصفحة ما سيلهي القارئ عن التركيز على الشكل الخارجي للنص أو شكل توضع الفقرات في الصفحة التي يقرأها. ولذلك يتم استخدام طريقة لوريم إيبسوم لأنها تعطي توزيعاَ طبيعياَ -إلى حد ما- للأحرف عوضاً عن استخدام "هنا يوجد محتوى نصي، هنا يوجد محتوى نصي" فتجعلها تبدو (أي الأحرف) وكأنها نص مقروء. العديد من برامح النشر المكتبي وبرامح تحرير صفحات الويب تستخدم لوريم إيبسوم بشكل إفتراضي كنموذج عن النص،

                            </p>
                            <button type="button" class="btn btn-primary pull-left">
                                استكمال الانشطة
                            </button>
                            <div class="clearfix"></div>
                        </section>







                        <section id="content3">

                            <?php foreach ($quest as $quests ): ?>

                                <form method="post" action="{{route('addanswer')}}">

                                @csrf
                                    <input type="hidden" name="questions[{{$quests->id}}][question]" value="{{$quests->id}}" >  </input>
                                    <input type="hidden" name="typeofquest" value="activity" >  </input>

                            <label>
                                    <span class="h4">
                                   قم باختيار الاجابة الصحيحة فيما ياتي.
                                    </span>
                            </label>
                                    <br></br>
                            <label class="t-lable">
                                <i class="fas fa-caret-left quiz-color"></i>
                                <span class="h4 quiz-color">
  {{$quests->question}}
                                    </span>
                            </label>
                            <div class="selections">

                                <div  class="activity-option">
                                    <span class="ac-option01 text-center">أ</span>
                                    <div class="a-option">
                                        <span class="mc-option"><input type="radio" name="questions[{{$quests->id}}][ans]" value="ans1" required  oninvalid="this.setCustomValidity('من فضلك ادخل اسم السوال   ')" oninput="setCustomValidity('')"> {{$quests->ans1}} </input></span>
                                    </div>
                                </div>
                                <div  class="activity-option">
                                    <span class="ac-option01 text-center">ب</span>
                                    <div class="a-option">
                                        <span class="mc-option"> <input type="radio" name="questions[{{$quests->id}}][ans]" value="ans2" required> {{$quests->ans2}} </input></span>
                                    </div>
                                </div>
                                <?php if(!empty($quests->ans3)):?>
                                <div  class="activity-option">
                                    <span class="ac-option01 text-center">ج</span>
                                    <div class="a-option">
                                        <span class="mc-option"><input type="radio" name="questions[{{$quests->id}}][ans]" value="ans3" required> {{$quests->ans3}} </input></span>
                                    </div>
                                </div>
                                <?php endif;?>
                                <?php if(!empty($quests->ans4)):?>
                                <div  class="activity-option">
                                    <span class="ac-option01 text-center">د</span>
                                    <div class="a-option">
                                        <span class="mc-option"> <input type="radio" name="questions[{{$quests->id}}][ans]" value="ans4" required> {{$quests->ans4}} </input></span>
                                    </div>
                                </div>
                                <?php endif;?>
                            </div>
                            <div style="margin-top: 20px; margin-bottom: 20px">
                            </div>
                            <div class="clearfix"></div>

                                <input type="submit" class="btn btn-dark pull-left" value="ارسال" ></input>
                            </form>

                                <?php endforeach; ?>

                                <?php if (empty($quests)): ?>
                                <?php

                                $answer = DB::table('questions')->where('type','activityquest')->where('questions.content_id',1)->
                                join('answers_questions', function ($join) {
                                    $join->on('questions.true_answer', '=', 'answers_questions.answer');
                                    $join->on('answers_questions.question_id','=','questions.id');
                                })


                                    ->get()->count();
                                $questrestult=DB::table('questions')->where('content_id',1)->where('type','activityquest')->count();

                                ?>
                                YOUR RESULT IS {{$answer}}  OUT OF {{$questrestult}}
                                <?php endif; ?>

                        </section>










                        <section id="content4">
                            <p class="tabcontent">
                                نص 04
                            </p>
                        </section>
                        <section id="content5">

                            <?php foreach ($addationquests as $addationquest ): ?>


                            <form method="post" action="{{route('addanswer')}}">


                                @csrf

                                <input type="hidden" name="questions[{{$addationquest->id}}][question]" value="{{$addationquest->id}}" required>  </input>

                                <input value="addationquest" type="hidden" name="typeofquest" ></input>







                                <label>
                                    <span class="h4">
                                   قم باختيار الاجابة الصحيحة فيما ياتي.
                                    </span>
                                </label>
                                <div class="article-image text-center">
                                    <br></br>
                                </div>
                                <label class="t-lable">
                                    <i class="fas fa-caret-left quiz-color"></i>
                                    <span class="h4 quiz-color">
  {{$addationquest->question}}
                                    </span>
                                </label>
                                <div class="selections">

                                    <div  class="activity-option">
                                        <span class="ac-option01 text-center">أ</span>
                                        <div class="a-option">
                                            <span class="mc-option"><input type="radio" name="questions[{{$addationquest->id}}][ans]" value="ans1" required> {{$addationquest->ans1}} </input></span>
                                        </div>
                                    </div>

                                    <div  class="activity-option">
                                        <span class="ac-option01 text-center">ب</span>
                                        <div class="a-option">
                                            <span class="mc-option"> <input type="radio" name="questions[{{$addationquest->id}}][ans]" value="ans2" required> {{$addationquest->ans2}} </input></span>
                                        </div>
                                    </div>
                                    <?php if(!empty($addationquest->ans3)):?>
                                    <div  class="activity-option">
                                        <span class="ac-option01 text-center">ج</span>
                                        <div class="a-option">
                                            <span class="mc-option"><input type="radio" name="questions[{{$addationquest->id}}][ans]" value="ans3" required> {{$addationquest->ans3}} </input></span>
                                        </div>
                                    </div>
                                    <?php endif;?>
                                    <?php if(!empty($addationquest->ans4)):?>
                                    <div  class="activity-option">
                                        <span class="ac-option01 text-center">د</span>
                                        <div class="a-option">
                                            <span class="mc-option"> <input type="radio" name="questions[{{$addationquest->id}}][ans]" value="ans4" required> {{$addationquest->ans4}} </input></span>
                                        </div>
                                    </div>
                                </div>
                                <?php endif;?>
                                <div style="margin-top: 20px; margin-bottom: 20px">



                                </div>
                                <div class="clearfix"></div>

                                <input type="submit" class="btn btn-dark pull-left" value="ارسال" ></input>
                            </form>


                            <?php endforeach; ?>

                            <?php if (empty($addationquest)): ?>
                            <?php

                            $answer = DB::table('questions')->where('type','addationquest')->where('questions.content_id',1)->
                            join('answers_questions', function ($join) {
                                $join->on('questions.true_answer', '=', 'answers_questions.answer');
                                $join->on('answers_questions.question_id','=','questions.id');
                            })


                                ->get()->count();
                            $questrestult=DB::table('questions')->where('content_id',1)->where('type','addationquest')->count();

                            ?>
                           لقد احرزت {{$answer}}  من {{$questrestult}}
                            <?php endif; ?>

                        </section>


                        <!--                        <section id="content6">
                                                    <p class="tabcontent">
                                                        نص 05
                                                    </p>
                                                </section>-->


                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="row">
                <div class="vocabulary-col">
                    <div class="vocabulary-title">
                        <header class="vocabulary-t">
                            <p>مترادفات</p>
                            <h3>معاني المفردات</h3>
                        </header>
                    </div>
                    <div class="vocabulary">
                        <table class="vocabulary-table">
                            <tr>
                                <td class="v-txt-style">الكلمة</td>
                                <td>المعنى</td>
                            </tr>
                            <tr>
                                <td class="v-txt-style">الكلمة</td>
                                <td> إفتراضي كنموذج عن النص</td>
                            </tr>
                            <tr>
                                <td class="v-txt-style">الكلمة</td>
                                <td> إفتراضي كنموذج عن النص</td>
                            </tr>
                            <tr>
                                <td class="v-txt-style">الكلمة</td>
                                <td> إفتراضي كنموذج عن النص</td>
                            </tr>
                        </table>
                    </div>

                    <!--<div class="vocabulary-end"></div>-->
                </div>
                <div class="vocabulary-col">
                    <div class="vocabulary-title">
                        <header class="vocabulary-t">
                            <p>نتائج الاختبارات </p>

                        </header>
                    </div>


                    <div class="vocabulary">
                        <table class="vocabulary-table">

                            <tr>

                                <?php

                                $answer = DB::table('questions')->where('type','activityquest')->where('questions.content_id',1)->
                                join('answers_questions', function ($join) {
                                    $join->on('questions.true_answer', '=', 'answers_questions.answer');
                                    $join->on('answers_questions.question_id','=','questions.id');
                                })


                                    ->get()->count();
                                $questrestult=DB::table('questions')->where('content_id',1)->where('type','activityquest')->count();
                                $answeraddation = DB::table('questions')->where('type','addationquest')->where('questions.content_id',1)->
                                join('answers_questions', function ($join) {
                                    $join->on('questions.true_answer', '=', 'answers_questions.answer');
                                    $join->on('answers_questions.question_id','=','questions.id');
                                })


                                    ->get()->count();
                                $questrestultaddation=DB::table('questions')->where('content_id',1)->where('type','addationquest')->count();
                                ?>

                                <?php if (empty($quests)): ?>
                                <td class="v-txt-style"> الانشطه</td>
                                <td> لقد احرزت  {{$answer}}  من {{$questrestult}}</td>

                            </tr>
                                <?php endif; ?>
                                <?php if (empty($addationquest)): ?>
<tr>
    <td class="v-txt-style"> الاضافيه</td>
    <td> لقد احرزت  {{$answeraddation}}  من {{$questrestultaddation}}</td>
</tr>
                                <?php endif; ?>
                        </table>
                    </div>

                <!--<div class="vocabulary-end"></div>-->
                </div>
            </div>
            </div>

        </div>

    </div>
</div>



<footer class="footer">
    <p> جميع الحقوق محفوظة <span class="en-font">© kalemon 2017</span></p>
    <div class="Social-Media">
        <a href="#"><i class="fab fa-facebook"></i></a>
        <a href="#"><i class="fab fa-twitter"></i></a>
        <a href="#"><i class="fab fa-linkedin"></i></a>
        <a href="#"><i class="fab fa-google-plus"></i></a>
    </div>
</footer>

<script src="js/fontawesome-all.min.js"></script>
<script src="js/jquery-3.1.1.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/semantic.min.js"></script>
<script src="js/wow.min.js"></script>
<script src="js/mainJS.js"></script>
<script>
    $('.ui.dropdown').dropdown();
    $('.checkbox').checkbox();
    new WOW().init();
</script>
</body>
</html>

--}}