@extends("layouts.app")



@section("custom-content")

    <div class="content-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-md-9 col-md-offset-2">
                    <div class="panel panel-green">
                        <div class="panel-heading"><h4><i class="fa fa-plus"></i> إضافة إمتحان </h4></div>
                        <div class="panel-body">
                            @include("inc.errorMessages")
                            <form method="post" action="{{url('admin/placement_test')}}">
                                {{csrf_field()}}
                                <div class="form-group">
                                    <label for="exampleInputEmail1">الاسم</label>
                                    <input type="text" class="form-control" id="exampleInputEmail1"
                                           aria-describedby="emailHelp" placeholder="name" required name="name" minlength="4" >

                                </div>


                                <div class="form-group">
                                    <label for="exampleSelect1">الصف</label>
                                    <select class="form-control" id="exampleSelect1" name="parent_education_level"
                                            required>
                                        <option value="">--------------</option>
                                        @foreach($education_levels as $levels)
                                            <option value="{{$levels->id}}">{{$levels->name}}</option>
                                        @endforeach

                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="exampleSelect1">الدوله</label>
                                    <select class="form-control" id="exampleSelect1" name="country"
                                            required>
                                        <option value="">--------------</option>
                                        @foreach($countries as $country)
                                            <option value="{{$country->id}}">{{$country->name}}</option>
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
                                        {{ Form::textarea('instructions', '', array('class' => 'form-control editor')) }}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="exampleSelect1">الحاله</label>
                                    <select class="form-control" id="exampleSelect1" name="active_status" required>
                                        <option value="">--------------</option>

                                        @foreach(\App\Http\OwnClasses\STUDENT_PLACEMENT_TESTS_ENUMS::STATUS as $statusIndex => $statusValue)
                                            <option
                                                <?= (old("active_status") == $statusIndex) ? "selected=''" : "" ?> value="{{$statusIndex}}">
                                                {{$statusValue}}
                                            </option>
                                        @endforeach


                                    </select>
                                </div>


                                <button type="submit" class="btn btn-success"><i class="fa fa-plus"></i> إضافة</button>
                                <a class="btn btn-danger" href="{{url('admin/placement_test')}}"><i
                                            class="fa fa-reply"></i> الرجوع إلي السابق</a>

                            </form>


                        </div>
                    </div>
                </div>
            </div>





@endsection