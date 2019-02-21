@extends('layouts.app')

@section('custom-content')
<div class="container">

    {{--<nav class="navbar navbar-inverse">--}}
        {{--<div class="navbar-header">--}}
            {{--<a class="navbar-brand" href="{{ URL::to('vocabularys') }}">Nerd Alert</a>--}}
        {{--</div>--}}
        {{--<ul class="nav navbar-nav">--}}
            {{--<li><a href="{{ URL::to('vocabularys') }}">View All Nerds</a></li>--}}
            {{--<li><a href="{{ URL::to('vocabularys/create') }}">Create a Nerd</a>--}}
        {{--</ul>--}}
    {{--</nav>--}}


<div class="container main-container">
    <h1>المصطلح :  {{ $vocabularys->word }}</h1>
    <div id="text-to-print" class="text-center">
        <h2>{{ $vocabularys->word }}</h2>
        <p>
            <strong>معني المصطلح : </strong> {{ $vocabularys->meaning }}<br>
            <strong>رقم الموضوع التابع له المصطلح : </strong> {{ $vocabularys->content_id }}
        </p>
    </div>

    <div class="ui clearing divider"></div>
    <input type="button" class="btn-primary" onclick="printDiv('text-to-print')" value="طباعة المصطلح" />
    <a class="btn pull-left" href="{{url('/show_voc_content/'.$vocabularys->content_id)}}">الرجوع للمصطلحات</a></li>
</div>
</div>
<script>
    function printDiv(divName) {
        var printContents = document.getElementById(divName).innerHTML;
        var originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;

        window.print();

        document.body.innerHTML = originalContents;
    }
</script>
@endsection
