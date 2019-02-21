@extends("layouts.app")




@section("custom-content")



    <div class="content-wrapper">

        <div class="container">
            @include("admin.placement_test.questions.inc.navbar")
            <br>
            <div class="row">
                <div class="col-md-1"></div>
                <div class="col-md-10">
                    <div class="panel panel-info">
                        <div class="panel panel-heading"><i class="fa fa-desktop"></i> مشاهدة</div>
                        <div class="panel panel-body">
                            <div class="form-group">
                                <label for="exampleInputEmail1">السؤال</label>

                                </br>
                                {!! $placement_test_question->question  !!}

                            </div>


                            <div class="row form-group">

                                @php $count = count($placement_test_question->placementQuestionAnswers); @endphp




                                @for($i = 0  ; $i < $count; $i++)


                                    @if($i == 0)
                                        @php $answer_name = "الاول"; @endphp
                                    @elseif($i == 1)
                                        @php $answer_name = "الثاني"; @endphp
                                    @elseif($i == 2)
                                        @php $answer_name = "الثالث"; @endphp
                                    @elseif($i == 3)
                                        @php $answer_name = "الرابع"; @endphp
                                    @endif
                                    <div class="row">
                                        <div class="col-md-2">
                                            {{ Form::label('ans'.$i, 'الاختيار  '.$answer_name, array('class' => 'col-form-label')) }}
                                        </div>
                                        <div class="col-md-8">
                                            {{ Form::text('ans'.$i,$placement_test_question->placementQuestionAnswers[$i]->answer, array('class' => 'form-control','disabled' => '')) }}
                                        </div>
                                    </div>
                                    @if($placement_test_question->placementQuestionAnswers[$i]->is_true==1)
                                        <?php
                                        $true_answer = $answer_name;
                                        ?>
                                    @endif
                                    @php unset($answer_name); @endphp

                                @endfor

                            </div>


                            {{--

                            <div class="row form-group">
                                <div class="col-md-2">
                                    {{ Form::label('ans1', 'الاختيار الاول', array('class' => 'col-form-label')) }}
                                </div>
                                <div class="col-md-4">
                                    {{ Form::text('ans1','', array('class' => 'form-control','' => '','oninvalid'=>"this.setCustomValidity('من فضلك ادخل الاجابه الاولى  ')",'oninput'=>"setCustomValidity('')")) }}
                                </div>
                                <div class="col-md-2 text-left">
                                    {{ Form::label('ans2', 'الاختيار الثانى', array('class' => 'col-form-label')) }}
                                </div>
                                <div class="col-md-4">
                                    {{ Form::text('ans2', '', array('class' => 'form-control','' => '','oninvalid'=>"this.setCustomValidity('من فضلك ادخل الاجابه الثانيه  ')",'oninput'=>"setCustomValidity('')")) }}
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-md-2">
                                    {{ Form::label('ans3', 'الاختيار الثالث', array('class' => 'col-form-label')) }}
                                </div>
                                <div class="col-md-4">
                                    {{ Form::text('ans3', '', array('class' => 'form-control')) }}
                                </div>
                                <div class="col-md-2 text-left">

                                    {{ Form::label('ans4', 'الاختيار الرابع', array('class' => 'col-form-label')) }}
                                </div>
                                <div class="col-md-4">
                                    {{ Form::text('ans4', '', array('class' => 'form-control')) }}
                                </div>
                            </div>

                            --}}
                            <div class="row form-group">
                                <div class="col-md-2">
                                    {{ Form::label('true_answer', 'الاجابه الصحيحه', array('class' => 'col-form-label')) }}
                                </div>
                                <div class="col-md-4">
                                    {{ Form::select('true_answer' ,[
                                  ' الاختيار '.  $true_answer
                                       ,
                                    ])}}

                                </div>


                                @include("inc.errorMessages")
                            </div>
                            <a class="btn btn-danger" href="{{url('admin/placement_test/'.$placement_test_question->exam_id)}}"><i
                                        class="fa fa-reply"></i> الرجوع إلي السابق</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-1"></div>
            </div>
        </div>





@endsection