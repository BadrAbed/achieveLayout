<style>
    #header {
        direction: rtl;
        display: block;
        padding: 1rem 0;
        background: #fff;
        z-index: 10;
    }

    .fixed-header {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.2);
        -webkit-box-shadow: 0px 9px 15px 9px rgba(0, 0, 0, 0.2);
        -moz-box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.2);
        -ms-box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.2);
        -o-box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.2);
    }

    #header .row {
        margin: auto;
        width: 85%;
    }

    #header a.logo {
        display: block;
        width: 200px;
        height: auto;
    }

    #header .left {
        margin: auto;
    }

    #header .left .links {
        display: inline-flex;
        margin: 0.5rem 0;
    }

    #header .left .links a {
        font-family: Cairo-Bold, WinSoftPro-Medium, AdobeInvisFont;
        font-size: 13pt;
        text-align: center;
    }

    #header .left .links a:first-child {
        color: rgba(255, 255, 255, 255);
        background: #7fbb50;
        border: 1px solid #7fbb50;
        padding: 0.2rem 4rem;
        margin-left: 1rem;
    }

    #header .left .links a:last-child {
        color: rgba(175, 173, 173, 255);
        background: #fff;
        border: 1px solid rgba(175, 173, 173, 255);
        padding: 0.2rem 1rem;
        padding-left: 2rem;
    }

    #header .left .links a img {
        width: 30px;
        height: 30px;
        margin: 0 0.5rem;
    }

    #header ul#menu {
        margin: 0;
        padding: 0 10px;
        background: #fff;
        color: rgba(35, 31, 32, 255);
        display: inline;
        float: left;
    }

    #header ul#menu>li img.user {
        width: 50px;
        height: 50px;
    }

    #header ul#menu>hr {
        border: none;
        border-left: 2px solid #7fbb50;
        height: 30px;
        width: 1px;
        display: inline-block;
        float: left;
        margin: 0;
        margin-left: 0.5rem;
        margin-top: 0.7rem;
    }

    #header ul#menu>li {
        float: left;
        list-style-type: none;
        position: relative;
        font-family: Arial-BoldMT, WinSoftPro-Medium, AdobeInvisFont;
        font-size: 12pt;
        color: rgba(35, 31, 32, 255);
        text-align: justify;
    }

    #header label {
        position: relative;
        display: block;
        padding: 0 18px 0 12px;
        line-height: 3em;
        cursor: pointer;
    }

    #header label:after {
        content: "";
        position: absolute;
        display: block;
        top: 43%;
        right: -3px;
        width: 0;
        height: 0;
        border-top: 8px solid #f38055;
        border-bottom: 0 solid rgba(255, 255, 255, .5);
        border-left: 8px solid transparent;
        border-right: 8px solid transparent;
        transition: border-bottom .1s, border-top .1s .1s;
    }


    /* #header label:hover,
    #header input:checked~label {
        background: rgba(0, 0, 0, .3);
    } */

    #header input:checked~label:after {
        border-top: 0 solid rgba(255, 255, 255, .5);
        border-bottom: 8px solid #f38055;
        transition: border-top .1s, border-bottom .1s .1s;
    }

    #header input {
        display: none
    }

    #header input:checked~ul.submenu {
        max-height: 300px;
        width: 180px;
        transition: max-height 0.5s ease-in;
    }

    #header ul.submenu {
        width: 180px;
        max-height: 0;
        padding: 0;
        overflow: hidden;
        list-style-type: none;
        background: #444;
        box-shadow: 0 0 1px rgba(0, 0, 0, .3);
        transition: max-height 0.5s ease-out;
        position: absolute;
        min-width: 100%;
    }

    #header ul.submenu li a {
        display: block;
        padding: 12px;
        color: #ddd;
        text-decoration: none;
        box-shadow: 0 -1px rgba(0, 0, 0, .5) inset;
        transition: background .3s;
        white-space: nowrap;
    }

    #header ul.submenu li a:hover {
        background: rgba(0, 0, 0, .3);
    }
</style>
<div id="header" class="header">
    <div class="row">
        <div class="col-md-3">
            <a class="logo" href="">
                <img src="{{asset('Studentpublic/images/logo.png')}}" alt="">
            </a>
        </div>
        <div class="col-md-9 left">
            <div class="links">
                <a href="{{url('studentDashboard')}}">الرئيسية</a>
                <a href="{{url('studentLessons')}}">
                    <img src="{{asset('Studentpublic/images/book.png')}}" class="" alt="">
                    <span>عرض الدروس</span>
                </a>
            </div>
            <ul id="menu">
                <li>
                    <span>{{auth()->user()->name}}</span>
                    <img class="user" src="{{asset('Studentpublic/images/user.png')}}" class="" alt="">
                </li>
                <hr>
                <li>
                    <input id="check01" type="checkbox" name="menu"/>
                    <label for="check01">    <?=
                        \App\Http\Controllers\QuestionController::getAllDegreesForStudent();

                        ?> نقطـــة</label>
                    <ul class="submenu">
                        <li><a href="{{url('')}}/logout">تسجيل خروج</a></li>
                    </ul>
                </li>
                
            </ul>
            
        </div>
    </div>
</div>