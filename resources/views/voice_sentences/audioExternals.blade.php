<link href='http://fonts.googleapis.com/css?family=Open+Sans:300,600,400' rel='stylesheet' type='text/css'>
<link rel="stylesheet" type="text/css" href="{{URL::asset("css/audioSentences/demos.css")}}" />
<link rel="stylesheet" type="text/css" href="{{URL::asset("css/audioSentences/jsgrid.min.css")}}" />
<link rel="stylesheet" type="text/css" href="{{URL::asset("css/audioSentences/jsgrid-theme.min.css")}}" />

<link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/cupertino/jquery-ui.css">


<style>
    .ui-widget *, .ui-widget input, .ui-widget select, .ui-widget button  {
        font-family: 'Helvetica Neue Light', 'Open Sans', Helvetica;
        font-size: 14px;
        font-weight: 300 !important;
    }

    .details-form-field input,
    .details-form-field select {
        width: 250px;
        float: right;
    }

    .details-form-field {
        margin: 30px 0;
    }

    .details-form-field:first-child {
        margin-top: 10px;
    }

    .details-form-field:last-child {
        margin-bottom: 10px;
    }

    .details-form-field button {
        display: block;
        width: 100px;
        margin: 0 auto;
    }

    input.error, select.error {
        border: 1px solid #ff9999;
        background: #ffeeee;
    }

    label.error {
        float: right;
        margin-left: 100px;
        font-size: .8em;
        color: #ff6666;
    }
</style>

<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js"></script>

<script>window.jQuery || document.write('<script src="/js/jquery-1.8.3.js"><\/script>')</script>

<script src="{{URL::asset("js/audioSentences/jsgrid.min.js")}}"></script>
<script src="{{URL::asset("js/audioSentences/jsgrid-fr.js")}}"></script>



