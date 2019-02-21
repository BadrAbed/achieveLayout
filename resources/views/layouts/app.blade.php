<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Achieve') }}</title>

    <!-- Styles -->
    {{--    <link href="{{ asset('css/bootstrap-rtl.min.css') }}" rel="stylesheet">--}}
    {{--<link href="{{ asset('css/modal.css') }}" rel="stylesheet">
    <link href="{{ asset('css/animate.css') }}" rel="stylesheet" type="text/css">
{{--    <link href="{{ asset('css/fontawesome-all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/main-mQuery.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/semantic.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/main-style.css') }}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="{{ url('/css/dropzone.css') }}">
    <link rel="stylesheet" href="{{ url('/css/custom.css') }}">
    <script src="{{asset('js/tinymce/jquery.tinymce.min.js')}}"></script>
    <script src="{{asset('js/tinymce/tinymce.min.js')}}"></script>--}}


    <link href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="shortcut icon" href="images/launch-icon.jpg" type="image/x-icon"/>
    <!-- Styles -->
    <link href="{{asset("css/bootstrap-rtl.min.css")}}" rel="stylesheet">
    <link href="{{ asset('css/modal.css') }}" rel="stylesheet">
    <link href="{{ asset('css/animate.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/fontawesome-all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/main-mQuery.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/semantic.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{asset("css/progress_bar.css")}}" rel="stylesheet" type="text/css">

    <!-- <link href="http://reading.kalemon.net/css/main-style.css" rel="stylesheet" type="text/css" >-->
    <link href="{{ asset('css/main-style.css') }}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="{{ url('/css/dropzone.css') }}">
    <link rel="stylesheet" href="{{ url('/css/custom.css') }}">
    <script src="{{asset('js/tinymce/jquery.tinymce.min.js')}}"></script>
    <script src="{{asset('js/tinymce/tinymce.min.js')}}"></script>
    <style type="text/css">
        /*.panel-white{
            background-color: #fff !important;
                     padding: 10px;
                     box-shadow: 0px 3px 1px 0px #00000012; border-radius: 5px;
        }*/
        .main-taps > label {
            padding-left: 3px !important;
        }

        #items {
            list-style: none;
            margin: 0px;
            margin-top: 4px;
            padding-left: 10px;
            padding-right: 10px;
            padding-bottom: 3px;
            font-size: 17px;
            color: #333333;

        }

        hr {
            width: 85%;
            background-color: #E4E4E4;
            border-color: #E4E4E4;
            color: #E4E4E4;
        }

        #cntnr {
            display: none;
            position: absolute;
            border: 1px solid #B2B2B2;
            width: 117px;
            background: #F9F9F9;
            box-shadow: 3px 3px 2px #E9E9E9;
            border-radius: 4px;
        }

        /*li {*/

        /*padding: 3px;*/
        /*padding-left: 10px;*/
        /*}*/

        #items :hover {
            color: white;
            background: #284570;
            border-radius: 2px;

        }

        #asd {
            font-size: 20px !important;
        }

        #asd p {
            font-size: 20px !important;
        }

    </style>

</head>
<body>

<div id="app">

    <div id='cntnr' style="z-index: 10000">
        <ul id='items'>
            <li>
                <button onclick="a()">قاموس المتحدة</button>
            </li>
        </ul>
    </div>
    <div id="exampleModalLive" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog"
         aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" style="max-width: 1200px;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title h4" id="myLargeModalLabel"> معنى الكلمة </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true"></span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="asd">

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /#wrapper -->
    @if(\Illuminate\Support\Facades\Auth::guard('school')->check())
        @include('schools.school_nav_bar')
    @endif
    @if(auth()->check())
        @if(App\Http\OwnClasses\Permissions::STUDENT_PERMISSION_ENUM==auth()->user()->is_permission)
            @include('inc.stubent_navbar')
        @elseif(App\Http\OwnClasses\TYPE_OF_USERS_ENUMS::EDITOR==auth()->user()->is_permission)
            @include('editor.editor_navbar')
        @elseif(App\Http\OwnClasses\TYPE_OF_USERS_ENUMS::REVIEWER==auth()->user()->is_permission)
            @include('reviewer.reviewer_navbar')
        @elseif(App\Http\OwnClasses\TYPE_OF_USERS_ENUMS::AUDIT==auth()->user()->is_permission)
            @include('langReviewer.LangReviewer_navbar')
        @elseif(App\Http\OwnClasses\TYPE_OF_USERS_ENUMS::PUBLISHER==auth()->user()->is_permission)
            @include('publisher.Publisher_navbar')
        @elseif(App\Http\OwnClasses\TYPE_OF_USERS_ENUMS::QUESTIONEDITOR==auth()->user()->is_permission)
            @include('questionsEditor.nav_bar')
        @elseif(App\Http\OwnClasses\TYPE_OF_USERS_ENUMS::QUESTIONREVIEWER==auth()->user()->is_permission)
            @include('questionsReviewer.nav_bar')

        @else

            @include('inc.navbar1')
        @endif
    @endif

    @includeWhen(!request()->is("login")&&!request()->is("register") && !request()->is("loginSchool"),'inc.navbar2'){{--include in all except in login and register which have different  architecture --}}

    <div class="container">

        @include('inc.message')
        {{--@include('inc.errorMessages')--}}
        {{--@include('inc.messages')--}}
        @yield('content')
    </div>

    @yield('custom-content')


</div>

<br>
@include('inc.footer')

<!-- Scripts -->

@hasSection("OldJqueryVersion") {{-- there are plugins that use specific old jquery .js and ui.js for specific plugins of voice sentences module --}}
@yield("OldJqueryVersion")
@else
    <script src="{{ asset('/js/jquery.js') }}"></script>
@endif


@hasSection("customBootstrapJS") {{-- there are plugins that use specific old BOOTSTRAP .js and ui.js for specific plugins of voice sentences module and multiple select js --}}
@yield("customBootstrapJS")
@else
    <div id="script">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
                integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
                crossorigin="anonymous"></script>
    </div>
@endif


{{-- we faced many issues of the blade ordering, so this will create a place when you need to use it after the general jquery--}}
@hasSection("CustomContentAfterGeneralJquery")
    @yield("CustomContentAfterGeneralJquery")
@endif

<script src="{{asset("js/fontawesome-all.min.js")}}"></script>
<script src="{{asset("js/wow.min.js")}}"></script>
<script src="{{asset("js/semantic.min.js")}}"></script>
<script src="{{asset("js/mainJS.js")}}"></script>
<script src="{{asset("js/sweetalert.min.js")}}"></script>
<script src="{{asset("js/ajax.js")}}"></script>
<script src="{{asset("js/script.js")}}"></script>
<script src="//f1-eu.readspeaker.com/script/3/webReader/webReader.js?pids=wr" type="text/javascript"></script>

<script>
    tinymce.init({
        height: 300,
        selector: "textarea.editor", // change this value according to your HTML
        plugins: ['print  preview fullpage searchreplace autolink directionality visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists textcolor wordcount imagetools contextmenu colorpicker textpattern help', "advlist autolink lists link image charmap print preview hr anchor pagebreak",
            "searchreplace wordcount visualblocks visualchars code fullscreen",
            "insertdatetime media nonbreaking save table contextmenu directionality",
            "emoticons template paste textcolor colorpicker textpattern table wordcount"],
        toolbar1: 'ContentSeperator | fullscreen | formatselect | bold italic strikethrough forecolor backcolor | image link | alignleft aligncenter alignright alignjustify | numlist bullist outdent indent | removeformat',
        toolbar2: "print preview styleselect  ",
        image_advtab: true,
        language: 'ar',
        relative_urls: false,
        remove_script_host: false,
        convert_urls: true,

        style_formats: [

            {title: 'مسافه للصورة', block: 'p', styles: {margin: '20px'}},

        ],

        theme: "modern",
        paste_data_images: true,
        file_picker_callback: function (callback, value, meta) {
            if (meta.filetype == 'image') {
                $('#upload').trigger('click');
                $('#upload').on('change', function () {
                    var file = this.files[0];
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        callback(e.target.result, {
                            alt: ''
                        });
                    };
                    reader.readAsDataURL(file);
                });
            }
        },
        setup: function (editor) {
            editor.addButton('mybutton', {
                text: 'My button',
                icon: false,
                onclick: function () {
                    var ele = tinymce.DOM.get('img');
                    var text = $(ele).css('margin', '10px');
                    console.log(text);
                }
            });

            function insertDate() {
                var html = "<?=\App\Http\OwnClasses\CONTENT_EDITOR_NEW_CONTENT_SEPERATOR_ICON::CONTENT_EDITOR_SEPERATOR?>"; //fixed agreed seperator
                editor.insertContent(html);
            }

            editor.addButton('ContentSeperator', {
                icon: 'glyphicon glyphicon-plus bold',
                //image: 'http://p.yusukekamiyamane.com/icons/search/fugue/icons/calendar-blue.png',
                tooltip: "اضافة محتوي جديد",
                onclick: insertDate,

            });
        },
        templates: [{
            title: 'Test template 1',
            content: 'Test 1'
        }, {
            title: 'Test template 2',
            content: 'Test 2'
        }]
    });
</script>
<script type="text/javascript">
    <!--
    window.rsConf = {general: {usePost: true}};
    //-->
</script>
{{--"قاموس المتحدة"--}}
<script>

    $('body').bind("contextmenu", function (e) {
        e.preventDefault();
        var top = e.pageY;
        $("#cntnr").css("left", e.pageX);
        $("#cntnr").css("top", top);
        // $("#cntnr").hide(100);
        $("#cntnr").fadeIn(200, startFocusOut());
        $('#script').empty();
        $('#script').html('<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" >\n');

    });

    function startFocusOut() {

        $(document).on("click", function () {
            $('#script').empty();
            $('#script').html('<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"  crossorigin="anonymous">');

            $("#cntnr").hide();
            $(document).off("click");
        });
        $(window).scroll(function () {
            $('#script').empty();
            $('#script').html('<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"  crossorigin="anonymous">');

            $('#cntnr').fadeOut();
        })
    }


    $("#items > li").click(function () {
        $("#op").text("You have selected " + $(this).text());
    });

</script>

<script>
    if (!window.x) {
        x = {};
    }
    x.Selector = {};
    x.Selector.getSelected = function () {
        var t = '';
        if (window.getSelection) {
            t = window.getSelection();
        } else if (document.getSelection) {
            t = document.getSelection();
        } else if (document.selection) {
            t = document.selection.createRange().text;
        }
        return t;
    }

    function a() {

        var mytext = x.Selector.getSelected();
        $.ajax({
            type: "GET",
            url: "http://www.analyzer.ga:8082/WebApplication1/faces/Api.xhtml?pram=" + encodeURIComponent(mytext),
            crossDomain: true,
            async: true,
            success: function (data) {
                $("#asd").html(data);
                $("#exampleModalLive").modal('show');
            }
        });
    }

</script>


</body>
</html>
