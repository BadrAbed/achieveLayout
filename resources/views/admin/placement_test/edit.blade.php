@extends("layouts.app")



@section("custom-content")

    <div class="content-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-md-9 col-md-offset-2">
                    <div class="panel panel-green">
                        @include("inc.errorMessages")
                        <div class="panel-heading"><h4><i class="fa fa-edit"></i> تعديل </h4></div>
                        <div class="panel-body">
                            <form method="post" action="{{url('admin/placement_test/'.$exam->id)}}">
                                {{csrf_field()}}
                                {{method_field("PATCH")}}
                                <div class="form-group">
                                    <label for="exampleInputEmail1">الأسم</label>
                                    <input type="text" class="form-control" id="exampleInputEmail1"
                                           aria-describedby="emailHelp"
                                           value="{{$exam->exam_name}}" placeholder="name" name="name" required minlength="4">
                                </div>
                                <div class="form-group">
                                    <label for="exampleSelect1">الصف</label>
                                    <select class="form-control" id="exampleSelect1" name="parent_education_level"
                                            required>
                                        <option value="">--------------</option>
                                        @foreach($education_levels as $levels)
                                            <option value="{{$levels->id}}"
                                                    @if($levels->id==$exam->parent_education_level) selected @endif>{{$levels->name}}</option>
                                        @endforeach

                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="exampleSelect1">الدوله</label>
                                    <select class="form-control" id="exampleSelect1" name="country"
                                            required>
                                        <option value="">--------------</option>
                                        @foreach($countries as $country)
                                            <option value="{{$country->id}}"
                                                    @if($country->id==$exam->country) selected @endif>{{$country->name}}</option>
                                        @endforeach

                                    </select>
                                </div>
                                <div class="row form-group">
                                    <div class="col-md-4">
                                        {{ Form::label('article', 'توجيهات الامتحان للطالب', array('class' => 'col-form-label')) }}
                                        <input name="image" type="file" id="upload" class="hidden" onchange="">
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-md-12">
                                        {!!   Form::textarea('instructions', $exam->instructions, array('class' => 'form-control editor')) !!}
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-md-2">
                                        {{ Form::label('true_answer', 'الحاله', array('class' => 'col-form-label')) }}
                                    </div>
                                    <div class="col-md-4">
                                        {{ Form::select('active_status', [
                                            'الحاله' => \App\Http\OwnClasses\STUDENT_PLACEMENT_TESTS_ENUMS::STATUS,
                                        ],$exam->status)}}

                                    </div>

                                    <button type="submit" class="btn btn-success"><i class="fa fa-check"></i> حفظ
                                        التعديل
                                    </button>
                                    <a class="btn btn-danger" href="{{url('admin/placement_test')}}"><i
                                                class="fa fa-reply"></i> الرجوع إلي السابق</a>


                            </form>


                        </div>
                    </div>
                </div>
            </div>





@endsection