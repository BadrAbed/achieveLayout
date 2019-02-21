@extends('layouts.app')

@section('custom-content')


    <section class="example text-center">

        <div class="progress2">


            <div class="circle2" id="1">
                <span class="label"><a href="{{url('QuestionsEditor/create/Questions/'.\App\Http\OwnClasses\STUDENT_ASSIGNED_LESSON_PLANS_ENUMS::GET_SHORT_QUESTIONS_TAB_ENUM.'/'.$content_id)}}" style="color: #0f0f10;" >1</a></span>
                <span class="title"> نشاط1</span>
            </div>


            <span class="bar2 half"></span>
            <div class="circle2 " id="2">
                <span class="label"><a href="{{url('QuestionsEditor/create/Questions/'.\App\Http\OwnClasses\STUDENT_ASSIGNED_LESSON_PLANS_ENUMS::GET_LONG_QUESTIONS_TAB_ENUM.'/'.$content_id)}}" style="color: #0f0f10;">2</a></span>
                <span class="title"> نشاط2 </span>
            </div>
        </div>
    </section>

    {!! Form::open(['url' => url("QuestionsEditor/store/Questions/$type/$content_id"), 'method' => 'POST','name'=>'myform']) !!}


    <section class="content">
        <div class="container">
            <div class="container main-container">
                <div class="row form-group text-center">
                    <div class="con">
                        @include("inc.errorMessages")
                        <div class="t-con">
                            <div class="h4 h-center" style="left: 75%; padding: 0 15px">
                                @php
                                    if($type==\App\Http\OwnClasses\STUDENT_ASSIGNED_LESSON_PLANS_ENUMS::GET_SHORT_QUESTIONS_TAB_ENUM)
                                    $kind="الاساسية";
                                   else
                                    $kind="الاضافية";
                                @endphp
                                اضافة الاسئلة {{$kind}}
                            </div>
                        </div>
                    </div>
                </div>




                @if(old('questions')>0)
                    <?php $i = 0?>
                    @foreach(old('questions') as $questions)
                        <div class="q1">
                            <div class="row form-group">

                                <div class="col-md-2">
                                    {{ Form::label('question', 'السؤال', array('class' => 'col-form-label')) }}
                                </div>
                                <div class="col-md-10">
                                    {{ Form::text("questions[$i][question]", $questions['question'], array('class' => 'form-control')) }} {{--,'required' => 'required','oninvalid'=>"this.setCustomValidity('من فضلك ادخل اسم السوال  ')",'oninput'=>"setCustomValidity('')"--}}
                                    <br></br>
                                </div>

                                <div class="row form-group">
                                    <div class="col-md-2">
                                        {{ Form::label('ans1', 'الاختيار الاول', array('class' => 'col-form-label')) }}
                                    </div>
                                    <div class="col-md-4">
                                        {{ Form::text("questions[$i][ans1]", $questions['ans1'], array('class' => 'form-control')) }} {{--'required' => 'required','oninvalid'=>"this.setCustomValidity('من فضلك ادخل الاجابه الاولى  ')",'oninput'=>"setCustomValidity('')"--}}
                                    </div>
                                    <div class="col-md-2 text-left">
                                        {{ Form::label('ans2', 'الاختيار الثانى', array('class' => 'col-form-label')) }}
                                    </div>
                                    <div class="col-md-4">
                                        {{ Form::text("questions[$i][ans2]", $questions['ans2'], array('class' => 'form-control')) }} {{--,'required' => 'required','oninvalid'=>"this.setCustomValidity('من فضلك ادخل الاجابه الثانيه  ')",'oninput'=>"setCustomValidity('')--}}
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-md-2">
                                        {{ Form::label('ans3', 'الاختيار الثالث', array('class' => 'col-form-label')) }}
                                    </div>
                                    <div class="col-md-4">
                                        {{ Form::text("questions[$i][ans3]", $questions['ans3'], array('class' => 'form-control')) }}
                                    </div>
                                    <div class="col-md-2 text-left">

                                        {{ Form::label('ans4', 'الاختيار الرابع', array('class' => 'col-form-label')) }}
                                    </div>
                                    <div class="col-md-4">
                                        {{ Form::text("questions[$i][ans4]", $questions['ans4'], array('class' => 'form-control')) }}
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-md-2">
                                        {{ Form::label('true_answer', 'الاجابه الصحيحه', array('class' => 'col-form-label')) }}
                                    </div>
                                    <div class="col-md-4">
                                        {{ Form::select("questions[$i][true_answer]", [
                                            'الاجابات' => ['ans1' => 'الاجابه الاولى','ans2' => 'الاجابه التانيه','ans3' => 'الاجابه الثالثه','ans4' => 'الاجابه الرابعه'],

                                        ],$questions['true_answer'])}}

                                    </div>

                                </div>
                            </div>
                            <?php $i++?>
                            @endforeach


                            @else
                                <div class="q1">
                                    <div class="row form-group">

                                        <div class="col-md-2">
                                            {{ Form::label('question', 'السؤال', array('class' => 'col-form-label')) }}
                                        </div>
                                        <div class="col-md-10">
                                            {{ Form::text('questions[0][question]', '', array('class' => 'form-control','required' => 'required','oninvalid'=>"this.setCustomValidity('من فضلك ادخل اسم السوال  ')",'oninput'=>"setCustomValidity('')")) }}
                                            <br></br>
                                        </div>

                                        <div class="row form-group">
                                            <div class="col-md-2">
                                                {{ Form::label('ans1', 'الاختيار الاول', array('class' => 'col-form-label')) }}
                                            </div>
                                            <div class="col-md-4">
                                                {{ Form::text('questions[0][ans1]', '', array('class' => 'form-control','required' => 'required','oninvalid'=>"this.setCustomValidity('من فضلك ادخل الاجابه الاولى  ')",'oninput'=>"setCustomValidity('')")) }}
                                            </div>
                                            <div class="col-md-2 text-left">
                                                {{ Form::label('ans2', 'الاختيار الثانى', array('class' => 'col-form-label')) }}
                                            </div>
                                            <div class="col-md-4">
                                                {{ Form::text('questions[0][ans2]', '', array('class' => 'form-control','required' => 'required','oninvalid'=>"this.setCustomValidity('من فضلك ادخل الاجابه الثانيه  ')",'oninput'=>"setCustomValidity('')")) }}
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-md-2">
                                                {{ Form::label('ans3', 'الاختيار الثالث', array('class' => 'col-form-label')) }}
                                            </div>
                                            <div class="col-md-4">
                                                {{ Form::text('questions[0][ans3]', '', array('class' => 'form-control')) }}
                                            </div>
                                            <div class="col-md-2 text-left">

                                                {{ Form::label('ans4', 'الاختيار الرابع', array('class' => 'col-form-label')) }}
                                            </div>
                                            <div class="col-md-4">
                                                {{ Form::text('questions[0][ans4]', '', array('class' => 'form-control')) }}
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-md-2">
                                                {{ Form::label('true_answer', 'الاجابه الصحيحه', array('class' => 'col-form-label')) }}
                                            </div>
                                            <div class="col-md-4">
                                                {{ Form::select('questions[0][true_answer]', [
                                                    'الاجابات' => ['ans1' => 'الاجابه الاولى','ans2' => 'الاجابه التانيه','ans3' => 'الاجابه الثالثه','ans4' => 'الاجابه الرابعه'],

                                                ])}}

                                            </div>

                                        </div>
                                    </div>


                                    <div id="newquest"></div>


                                    <div class="empty"></div>
                                    <input type="hidden" name="submitType">


                                </div>
                            @endif
                            <button class="btn btn-success" type="button" id="addQuestion_f">اضافة سؤال اخر</button>
                            <button class="btn btn-primary pull-left" onclick="setType('saveAndNext')" type="submit">حفظ والذهاب للتالي <i class="fas fa-caret-left"></i></button>
                            <br>
                            <br>
                            <button class="btn btn-success pull-left" onclick="setType('saveAndStay')" type="submit">حفظ <i class="fas fa-caret-left"></i></button>
                            <br>
                            <br>
                            <a href="{{url('allQuestions/' . $content_id)}}" class="btn btn-info pull-left">تخطي<i class="fas fa-step-backward"></i></a>
                            {{-- <button class="btn btn-primary pull-left" onclick="setType('skip')" type="submit">تخطي<i class="fas fa-caret-left"></i></button> --}}
                            <br>


                            <div id="newquest"></div>


                            <div class="empty"></div>


                        </div>
            </div>
    </section>
    <!-- if there are creation errors, they will show here -->







    {{ Form::close() }}


@section('OldJqueryVersion')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
    <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
    <script>
        function setType(type)
        {
            var type=type;
            //formName is the name of your form, submitType is the name of the submit button.
            document.forms["myform"].elements["submitType"].value = type;

            //Alternately, you can access the button by its Id
            document.getElementById("submitId").value = type;
        }
        {{-- </script>

            <script> --}}


        $(document).ready(function () {
            <?php
            if ($type == \App\Http\OwnClasses\STUDENT_ASSIGNED_LESSON_PLANS_ENUMS::GET_SHORT_QUESTIONS_TAB_ENUM) {?>
            $('#1').removeClass('circle2').addClass('circle2 active');
            <?php } else {?>
            $('#1').removeClass('circle2 active').addClass('circle2 done');
            $('#2').removeClass('circle2 active').addClass('circle2 active');
            <?php }?>
        });
    </script>
@endsection
@endsection