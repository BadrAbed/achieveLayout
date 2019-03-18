<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Achieve</title>
    <!-- Favicon -->
    <script src="http://demo.expertphp.in/js/jquery.js"></script>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>

    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <link rel="icon" href="{{asset('images/launch-icon.jpg')}}" type="image/icon">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{asset('Studentpublic/css/bootstrap.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/2.3.2/css/bootstrap-responsive.css">
	<link rel="stylesheet" href="{{asset('Studentpublic/plugins/linericon/style.css')}}">
	<link rel="stylesheet" href="{{asset('Studentpublic/css/font-awesome.min.css')}}">
	<link rel="stylesheet" href="{{asset('Studentpublic/plugins/owl-carousel/owl.carousel.min.css')}}">
	<link rel="stylesheet" href="{{asset('Studentpublic/plugins/lightbox/simpleLightbox.css')}}">
	<link rel="stylesheet" href="{{asset('Studentpublic/plugins/nice-select/css/nice-select.css')}}">
	<link rel="stylesheet" href="{{asset('Studentpublic/plugins/animate-css/animate.css')}}">
    <!-- styl css -->
    <link rel="stylesheet" href="{{asset('Studentpublic/css/Mstyle.css')}}">
    <link rel="stylesheet" href="{{asset('Studentpublic/css/style.css')}}">
    <link rel="stylesheet" href="{{asset('Studentpublic/css/responsive.css')}}">
    <!-- rtl layouts -->
    <link rel="stylesheet" href="{{asset('Studentpublic/css/layouts/rtl.css')}}">
    <!-- Fonts  -->
    <link rel="stylesheet" href="{{asset('Studentpublic/fonts/linearicons/style.css')}}">
    <link href='http://fonts.googleapis.com/css?family=ABeeZee' rel='stylesheet' type='text/css'>
    <link href="https://fonts.googleapis.com/css?family=Amiri|Lateef|Scheherazade" rel="stylesheet">
    <style>
        #items{
            list-style:none;
            margin:0px;
            margin-top:4px;
            padding-left:10px;
            padding-right:10px;
            padding-bottom:3px;
            font-size:17px;
            color: #333333;

        }
        hr { width: 85%;
            background-color:#E4E4E4;
            border-color:#E4E4E4;
            color:#E4E4E4;

        }
        #cntnr{
            display:none;
            position:fixed;
            border:1px solid #B2B2B2;
               background:#F9F9F9;
            box-shadow: 3px 3px 2px #E9E9E9;
            border-radius:4px;
        }

        li{

            padding: 3px;
            padding-left:10px;
        }


        #items :hover{
            color: white;
            background:#284570;
            border-radius:2px;
        }

    </style>
    
    @yield('css')
</head>
<body>
