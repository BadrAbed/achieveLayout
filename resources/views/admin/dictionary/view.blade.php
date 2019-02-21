@extends("layouts.app")



@section("custom-content")
@section("OldJqueryVersion")
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script type="text/javascript">
        $(function () {

            var availableTags = [
                "ActionScript",
                "AppleScript",
                "Asp",
                "BASIC",
                "C",
                "C++",
                "Clojure",
                "COBOL",
                "ColdFusion",
                "Erlang",
                "Fortran",
                "Groovy",
                "Haskell",
                "Java",
                "JavaScript",
                "Lisp",
                "Perl",
                "PHP",
                "Python",
                "Ruby",
                "Scala",
                "Scheme"
            ];

            $("#tags").autocomplete({

                source: availableTags


            });
        });
    </script>
@endsection

<div class="content-wrapper">

    <div class="container">

        @if(session('message'))
            <div class="alert alert-info">{{session("message")}}</div>

        @endif
        <div class="row">
            <div class="col-md-9 col-md-offset-2">
                <div class="panel panel-green">
                    <div class="panel-heading"><h4><i class="fa fa-paragraph"></i> معنى {{$word->word}} </h4></div>
                    <div class="panel-body">





                    <div class="row">
                        <div class="col-md-6"><h3>الكلمة:</h3> 
                        <div style="background-color:  #f3f3f3;padding: 50px 20px;border-radius: 5px;">
                          {{$word->word}}  
                        </div>
                        </div>
                        <div class="col-md-6" ><h3>معناها:</h3> 
                        <div style="background-color:  #8a8a8a;color:#fff;padding: 50px 20px;border-radius: 5px;">
                        {{$word->meaning}}
                        </div>
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-md-6"><h5>معلومات عن الكلمة</h5> 
                        <div style="padding: 20px;">
                                <label class="label label-lg label-success"> النوع </label> &nbsp; {{$word->type}}<br><br>
                                 <label class="label label-lg label-success">أمثلة </label> &nbsp;{{$word->examples}}<br><br>
                                 <label class="label label-lg label-success">كلمات قريبه </label>&nbsp; {{$word->relative_words}}<br><br>
                                 <label class="label label-lg label-success">المعني في الانليزية </label> &nbsp;{{$word->meaning_in_english}}

                        </div>  
                        </div>
                        <div class="col-md-6" ><h5>المستوي</h5> 
                        <div style="padding: 20px;">
                                {{$word->education}}
                        </div>
                        </div>
                    </div>



                        

                            <a href="{{url('dictionary/allWords')}}" class="btn btn-danger pull-left"><i class="fa fa-reply"></i> رجوع
                            </a>

                        </form>


                    </div>
                </div>
                @include("inc.errorMessages")
            </div>

        </div>

    </div>

</div>

@endsection