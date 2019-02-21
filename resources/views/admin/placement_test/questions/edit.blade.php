@extends("layouts.app")




@section("custom-content")



    <div class="content-wrapper">

        <div class="container">
            @include("admin.placement_test.questions.inc.navbar")
            <br>
            <div class="row">
                <div class="col-md-1"></div>
                <div class="col-md-10">
                 <div class="panel panel-green">
                <div class="panel panel-heading"><i class="fa fa-edit"></i> تعديل</div>
                <div class="panel panel-body">
                    @include("inc.errorMessages")
                    <form method="post"
                          action="{{url('admin/placement_test_questions/update/'.$placement_test_question->id)}}">
                        {{csrf_field()}}
                        <div class="form-group">
                            <label for="exampleInputEmail1">وصف السؤال</label>
                            <input type="text" class="form-control" id="exampleInputEmail1" value="{{$placement_test_question->desc}}"
                                   aria-describedby="emailHelp" placeholder="وصف" name="desc" required>

                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">السؤال</label>
                            <input name="image" type="file" id="upload" class="hidden" onchange="">

                            {{ Form::textarea('name', $placement_test_question->question, array('class' => 'form-control editor','required')) }}

                        </div>

                        <div class="row form-group">


                            @foreach($placement_test_question->placementQuestionAnswers as $index => $eachQuestion)

                                @php $r = $index + 1; @endphp

                                @if($index == 0)
                                    @php $answer_name = "الاول"; @endphp
                                @elseif($index == 1)
                                    @php $answer_name = "الثاني"; @endphp
                                @elseif($index == 2)
                                    @php $answer_name = "الثالث"; @endphp
                                @elseif($index == 3)
                                    @php $answer_name = "الرابع"; @endphp
                                @endif



                                <div class="col-md-2">
                                    {{ Form::label('ans'.$r, 'الاختيار  '.$answer_name, array('class' => 'col-form-label')) }}
                                </div>
                                <div class="col-md-4">
                                    {{ Form::text('ans'.$r,$eachQuestion->answer, array('class' => 'form-control','required' => 'required')) }}
                                </div>
                                @if($eachQuestion->is_true==\App\Http\OwnClasses\PLACEMENT_TEST_QUESTION_ANSWERS_ENUMS::GET_IS_TRUE)
                                    <?php
                                    $true_answer = 'ans' . $r;
                                    ?>
                                @endif
                                @php unset($answer_name); @endphp

                            @endforeach

                        </div>

                        @php $count = count($placement_test_question->placementQuestionAnswers); @endphp


                        <div class="row form-group">
                            <div class="col-md-2">
                                {{ Form::label('true_answer', 'الاجابه الصحيحه', array('class' => 'col-form-label')) }}
                            </div>
                            <div class="col-md-4">
                                {{ Form::select('true_answer', [
                                    'الاجابات' => ['ans1' => 'الاجابه الاولى','ans2' => 'الاجابه التانيه','ans3' => 'الاجابه الثالثه','ans4' => 'الاجابه الرابعه'],
                                ],$true_answer)}}

                            </div>

                            <br>
                            <br>
                            <div style="padding: 20px;">
                            <button  type="submit" class="btn btn-success"><i class="fa fa-check"></i> حفظ التعديل</button>
                                <a class="btn btn-danger" href="{{url('admin/placement_test/'.$placement_test_question->exam_id)}}"><i
                                            class="fa fa-reply"></i> الرجوع إلي السابق</a>
                            </div>
                    </form>
                                    </div>
            </div>

                </div>
                <div class="col-md-1"></div>
            </div>
        </div>
    </div>





@endsection