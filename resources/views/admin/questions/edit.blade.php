@extends('layouts.app')

@section('custom-content')


    {!! Form::open(['url' => url("editQuestion/$question->id"), 'method' => 'POST']) !!}
    <section class="content">
        <div class="container">
            <div class="container main-container">
                @include("inc.bar")

                <div class="row form-group text-center">
                    <div class="con">
                        @include("inc.errorMessages")
                        <div class="t-con">
                            <div class="h4 h-center" style="left: 75%; padding: 0 15px">
                                تعديل
                            </div>
                        </div>
                    </div>
                </div>


                <div class="q1">
                    <div class="row form-group">
                        <input value="activityquest" type="hidden" name="typeofquest"></input>
                        <div class="col-md-2">
                            {{ Form::label('question', 'السؤال', array('class' => 'col-form-label')) }}
                        </div>
                        <div class="col-md-10">
                            {{ Form::text('questions[0][question]',$question->question , array('class' => 'form-control','required' => 'required','oninvalid'=>"this.setCustomValidity('من فضلك ادخل اسم السوال  ')",'oninput'=>"setCustomValidity('')")) }}
                            <br></br>
                        </div>

                        <div class="row form-group">
                            <div class="col-md-2">
                                {{ Form::label('ans1', 'الاختيار الاول', array('class' => 'col-form-label')) }}
                            </div>
                            <div class="col-md-4">
                                {{ Form::text('questions[0][ans1]', $question->ans1, array('class' => 'form-control','required' => 'required','oninvalid'=>"this.setCustomValidity('من فضلك ادخل الاجابه الاولى  ')",'oninput'=>"setCustomValidity('')")) }}
                            </div>
                            <div class="col-md-2 text-left">
                                {{ Form::label('ans2', 'الاختيار الثانى', array('class' => 'col-form-label')) }}
                            </div>
                            <div class="col-md-4">
                                {{ Form::text('questions[0][ans2]', $question->ans2, array('class' => 'form-control','required' => 'required','oninvalid'=>"this.setCustomValidity('من فضلك ادخل الاجابه الثانيه  ')",'oninput'=>"setCustomValidity('')")) }}
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-2">
                                {{ Form::label('ans3', 'الاختيار الثالث', array('class' => 'col-form-label')) }}
                            </div>
                            <div class="col-md-4">
                                {{ Form::text('questions[0][ans3]', $question->ans3, array('class' => 'form-control')) }}
                            </div>
                            <div class="col-md-2 text-left">

                                {{ Form::label('ans4', 'الاختيار الرابع', array('class' => 'col-form-label')) }}
                            </div>
                            <div class="col-md-4">
                                {{ Form::text('questions[0][ans4]', $question->ans4, array('class' => 'form-control')) }}
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-2">
                                {{ Form::label('true_answer', 'الاجابه الصحيحه', array('class' => 'col-form-label')) }}
                            </div>
                            <div class="col-md-4">
                                {{ Form::select('questions[0][true_answer]', [
                                    'الاجابات' => ['ans1' => 'الاجابه الاولى','ans2' => 'الاجابه التانيه','ans3' => 'الاجابه الثالثه','ans4' => 'الاجابه الرابعه'],

                                ],$question->true_answer)}}

                            </div>

                        </div>
                    </div>





                </div>


                {{ Form::button('التالى <i class="fas fa-caret-left"></i>', ['type' => 'submit', 'class' => 'btn btn-primary pull-left'] )  }}
                <br>


                <div id="newquest"></div>




                <div class="empty"></div>


            </div>
        </div>
    </section>
    <!-- if there are creation errors, they will show here -->







    {{ Form::close() }}

@endsection
