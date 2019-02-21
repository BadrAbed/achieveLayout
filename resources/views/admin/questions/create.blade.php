@extends('layouts.app')

@section('custom-content')

    <?php
    $kind="activityquest";
if($type==\App\Http\OwnClasses\STUDENT_ASSIGNED_LESSON_PLANS_ENUMS::GET_LONG_QUESTIONS_TAB_ENUM){
    $kind="addationquest";
}

    ?>
    @include('inc.progress_bar')


    {!! Form::open(['url' => url("createquestion/store/$content_id"), 'method' => 'POST']) !!}
    <section class="content">
        <div class="container">
            <div class="container main-container">
                <div class="row form-group text-center">
                    <div class="con">
                        @include("inc.errorMessages")
                        <div class="t-con">
                            <div class="h4 h-center" style="left: 75%; padding: 0 15px">
                               اضافة الاسئله {{($kind=="activityquest")?'الاساسية':'الاضافية'}}
                            </div>
                        </div>
                    </div>
                </div>

                @if(old('questions')>0)
                    <?php $i = 0 ?>
                    @foreach(old('questions') as $questions)
                        <div class="q1">
                            <div class="row form-group">
                                <input value="{{$kind}}" type="hidden" name="typeofquest"></input>
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
                            <?php $i++ ?>
                            @endforeach


                            @else
                                <div class="q1">
                                    <div class="row form-group">
                                        <input value="{{$kind}}" type="hidden" name="typeofquest"></input>
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


                                </div>
                            @endif
                            <button class="btn btn-success" type="button" id="addQuestion_f">اضافة سؤال اخر</button>
                            {{ Form::button('التالى <i class="fas fa-caret-left"></i>', ['type' => 'submit', 'class' => 'btn btn-primary pull-left'] )  }}
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


        $(document).ready(function () {
            $('#1').removeClass('circle2 active').addClass('circle2 done');
            $('#2').removeClass('circle2 active').addClass('circle2 done');
            $('#3').removeClass('circle2').addClass('circle2 active');
             <?php
            if( $kind  =='addationquest'){?>
            $('#3').removeClass('circle2 active').addClass('circle2 done');
            $('#4').removeClass('circle2 active').addClass('circle2 done');
            $('#5').removeClass('circle2 active').addClass('circle2 active');
           <?php }
            ?>
        });

    </script>
@endsection
@endsection
