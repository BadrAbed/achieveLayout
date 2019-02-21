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
                    <div class="panel-heading"><h4><i class="fa fa-edit"></i> تعديل {{$word->word}} </h4></div>
                    <div class="panel-body">
                        <form method="post" action="{{url("dictionary/$word->id/edit")}}">
                            {{csrf_field()}}
                        <div class="form-group">
                            <label for="exampleInputEmail1">الكلمة</label>
                            <input type="text" class="form-control" id="exampleInputEmail1"
                                   aria-describedby="emailHelp" name="word" value="{{$word->word}}">
                        </div>

                        <div class="form-group">
                            <label>المستوي</label>
                            {{--<input  class="form-control"  value="{{$word->education}}">--}}
                            <select class="form-control " name="education_level_id">
                                <option value="{{$word->education_level_id}}">{{$word->education}}</option>
                                @foreach($edu_levels as $parent)

                                    <option value="{{$parent->id}}" disabled="">
                                        &#10000; {{$parent->name}}  </option>

                                    @if ($parent->children->count())
                                        @foreach ($parent->children as $child)
                                            <option

                                                    @if(old("education_level_id") == $child->id)
                                                    {{"selected=''"}}
                                                    @endif

                                                    value="{{ $child->id }}"> &emsp; &#9000;
                                                &#9000; {{ $child->name }}</option>
                                        @endforeach

                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">النوع</label>
                            <input type="text" class="form-control" id="exampleInputEmail1"
                                   aria-describedby="emailHelp" name="type" value="{{$word->type}}">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">المعنى</label>
                            <input type="text" class="form-control" id="exampleInputEmail1"
                                   aria-describedby="emailHelp" name="meaning" value="{{$word->meaning}}">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">أمثلة</label>
                            <textarea rows="8" class="form-control" name="examples" >{{$word->examples}}</textarea>
                            {{--<input type="text" class="form-control" id="exampleInputEmail1"--}}
                            {{--aria-describedby="emailHelp" name="examples" value="{{old('examples')}}">--}}
                        </div>

                        <div class="form-group">
                            <label for="tags">كلمات قريبه</label>
                            <input type="text" class="form-control" id="tags" name="relative_words"
                                   value="{{$word->relative_words}}">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">المعني في الانليزية</label>
                            <input type="text" class="form-control" id="exampleInputEmail1"
                                   aria-describedby="emailHelp" name="meaning_in_english"
                                   value="{{$word->meaning_in_english}}">
                        </div>

                            <button type="submit" class="btn btn-success"><i class="fa fa-edit"></i> تعديل
                            </button>
                            <a href="{{url('dictionary/allWords')}}" class="btn btn-danger"><i class="fa fa-reply"></i> رجوع
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