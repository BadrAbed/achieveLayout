@extends("layouts.app")




@section("custom-content")



    <div class="content-wrapper">

        <div class="container">
            @include("admin.placement_test.questions.inc.navbar")
            <br>
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-green">
                    <div class="panel-heading"><h4><i class="fa fa-plus"></i> إضافة سؤال </h4></div>
                    <div class="panel-body">
                        @include("inc.errorMessages")
                    <form method="post" action="{{url('admin/placement_test_questions/'.$exam_id)}}">
                        {{csrf_field()}}
                        <div class="form-group">
                            <label for="exampleInputEmail1">وصف السؤال</label>
                            <input type="text" class="form-control" id="exampleInputEmail1"
                                   aria-describedby="emailHelp" placeholder="وصف" name="desc" required minlength="4">

                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">السؤال</label>
                            <input name="image" type="file" id="upload" class="hidden" onchange="">

                                {{ Form::textarea('name', '', array('class' => 'form-control editor','required')) }}



                        </div>




                        <div class="row form-group">
                            <div class="col-md-2">
                                {{ Form::label('ans1', 'الاختيار الاول', array('class' => 'col-form-label')) }}
                            </div>
                            <div class="col-md-4">
                                {{ Form::text('ans1', '', array('class' => 'form-control','required' => 'required','oninvalid'=>"this.setCustomValidity('من فضلك ادخل الاجابه الاولى  ')",'oninput'=>"setCustomValidity('')")) }}
                            </div>
                            <div class="col-md-2 text-left">
                                {{ Form::label('ans2', 'الاختيار الثانى', array('class' => 'col-form-label')) }}
                            </div>
                            <div class="col-md-4">
                                {{ Form::text('ans2', '', array('class' => 'form-control','required' => 'required','oninvalid'=>"this.setCustomValidity('من فضلك ادخل الاجابه الثانيه  ')",'oninput'=>"setCustomValidity('')")) }}
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
                        <div class="row form-group">
                            <div class="col-md-2">
                                {{ Form::label('true_answer', 'الاجابه الصحيحه', array('class' => 'col-form-label')) }}
                            </div>
                            <div class="col-md-4">
                                {{ Form::select('true_answer', [
                                    'الاجابات' => ['ans1' => 'الاجابه الاولى','ans2' => 'الاجابه التانيه','ans3' => 'الاجابه الثالثه','ans4' => 'الاجابه الرابعه'],

                                ])}}

                            </div>

                            <br>
                            <br>
                            <br>
                            <button type="submit" class="btn btn-success"><i class="fa fa-check"></i> حفظ التعديل</button>
                            <a href="{{url('admin/placement_test')}}" class="btn btn-danger"><i class="fa fa-reply"></i> رجوع</a>

                    </form>
                    </div>
                </div>
                </div>
            </div>
                   </br>
                   </br>

                </div>
                    </div></div>
            </div>
        </div>
    </div>





@endsection