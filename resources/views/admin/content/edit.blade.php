@extends('layouts.app')

@section('custom-content')
    @if (Session::has('message'))
        <div class="alert alert-info">{{ Session::get('message') }}</div>
    @endif




    <section class="content">
        <div class="container">

            <div class="container main-container">
                @include("inc.bar")
                <div class="flex flex-ali-ctr flex-juc-ctr flex-col">

                </div>
                <div class="0"></div>
                </h3>
                
 </div>
<div class="panel panel-green">

                <div class="panel-heading"> <h3 class="text-center"><i class="fa fa-edit"></i> تعديل محتوى <b style="font-size: 22px;">{{ $content->content_name }}</b></h3></div>
                <div class="panel-body">
                    @include('inc.errorMessages')
                {!! Form::open(['action' => ['ContentController@update', $content->id],'files' => 'true', 'method' => 'PUT']) !!}
                <div class="row form-group">
                    <div class="col-md-2">
                        {{Form::label('education_level_id', 'المرحلة الدراسية')}}
                    </div>
                    <div class="col-md-4">
                        <div class="ui input  fluid ">

                            <select class="form-control" name="education_level_id" required id="sort-item">


                                @foreach($levels as $parent)

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

                    </div>

                    <div class="col-md-2 text-left">
                        {{Form::label('country_id', 'الدوله')}}
                    </div>
                    <div class="col-md-4">
                        <div class="ui input fluid">
                            <select class="form-control" name="countries" >
                                @if($content->countries!=null)
                                    <option value="{{$content->country->id}}">{{$content->country->name}}</option>
                                @else
                                    <option value="">عام</option>
                                @endif
                                @foreach($countries as $country)
                                    <option value="{{$country->id}}">{{$country->name}}</option>
                                @endforeach
                            </select>
                        </div>

                    </div>

                </div>
                <div class="row form-group">
                    <div class="col-md-2">
                        {{Form::label('main_categories_id', 'التصنيفات ')}}
                    </div>
                    <div class="col-md-4">
                        <div class="ui input fluid">
                            <select class="form-control" name="main_categories_id" id="main_categories" required onchange="changeFunc();">
                                <option value="{{$content->Categories->id}}">{{$content->Categories->name}}</option>
                                @foreach($main_categories_id as $main_category_id)
                                    <option value="{{$main_category_id->id}}">{{$main_category_id->name}}</option>
                                @endforeach

                            </select>
                        </div>

                    </div>

                    <div class="col-md-3">
                        <div class="ui input fluid">
                            <select class="form-control" name="sub_categories_id" id="sub_categories"  onchange="changeFuncsub();"  oninvalid="this.setCustomValidity('من فضلك اختر تصنيف اضافى  ')"
                                    oninput="setCustomValidity('')">
                                <option value="">----</option>

                            </select>
                        </div>

                    </div>

                    <div class="col-md-3">
                        <div class="ui input fluid">
                            <select class="form-control" name="sub_sub_categories_id" id="sub_sub_categories" oninvalid="this.setCustomValidity('من فضلك اختر تصنيف اضافى  ')"
                                    oninput="setCustomValidity('')">
                                <option value="">----</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row form-group">
                <div class="col-md-2">
                    {{ Form::label('goal_id_list', 'نواتج التعلم', array('class' => 'col-form-label')) }}

                </div>
                <div class="col-md-4 {{ $errors->has('goal_id_list') ? 'has-error' : ''}}">

                    <select style="z-index: 100" name="goal_id_list[]" data-live-search="true" required id="countries"
                            class="ui dropdown fluid" multiple="" data-actions-box="true">

                        @foreach ($learingGoal as  $learingGoal)

                            <option

                                    @if(old("goal_id_list"))

                                    @if(in_array($learingGoal->id,old("goal_id_list")))
                                    {{"selected=''"}}
                                    @endif
                                    @elseif(in_array($learingGoal->id,$releted_content_goals))
                                    {{"selected=''"}}
                                    @endif

                                    value="{{$learingGoal->id}}">{{$learingGoal->learing_goals_name}}</option>

                        @endforeach
                    </select>

                </div>

                </div>

                <div class="row form-group">
                    <div class="col-md-2">
                        {{Form::label('content_name', 'اسم الدرس')}}
                    </div>

                    <div class="col-md-4">
                        {{Form::text('content_name', $content->content_name, ['class' => 'form-control','required','minlength="4"'])}}
                    </div>

                </div>


                <div class="row form-group">
                    <div class="col-md-2 ">
                        {{Form::label('poll', 'السؤال القبلي والبعدي')}}
                    </div>
                    <div class="col-md-10">
                        {{Form::text('poll', $content->poll, ['class' => 'form-control','required'])}}
                    </div>
                </div>
                    <div class="row form-group">
                        <div class="col-md-2 ">
                            <label for="abstract">تمهيد مختصر للسؤال القبلى</label>
                        </div>
                        <div class="col-md-10 {{ $errors->has('hint') ? 'has-error' : ''}}">
                            <textarea name="hint" class="form-control" required rows="5">{{$content->hint}}</textarea>
                        </div>
                    </div>

                <div class="row form-group">
                    <div class="col-md-2 ">
                        {{Form::label('abstract', 'نبذه مختصره')}}
                    </div>
                    <div class="col-md-10">
                         <textarea class="form-control " required name="abstract" rows="5"
                                   id="abstract"> {{$content->abstract}}</textarea>
                    </div>
                </div>
                @if ($errors->first('abstract'))
                    <div class="alert alert-danger">

                        {{  $errors->first('abstract')}}

                    </div>
                @endif
                <div class="row form-group">
                    <div class="col-md-2">
                        {{ Form::label('image', 'صورة الغلاف', array('class' => 'col-form-label')) }}
                    </div>
                    <div class="col-md-10">
                        {{ Form::file('image',array('accept="image/*"')) }}

                    </div>
                    <div>
                        <img alt="image" src="{{url('')}}/{{$content->cover_image}}" height="150" width="150">
                    </div>
                </div>
                    <div class="row form-group">
                        <div class="col-md-2">
                            {{ Form::label('image', 'صورة الدرس', array('class' => 'col-form-label')) }}
                        </div>
                        <div class="col-md-10">
                            {{ Form::file('Lesson_image',array('accept="image/*"')) }}

                        </div>
                        <div>
                            <img alt="image" src="{{url('')}}/{{$content->lessonImage}}" height="150" width="150">
                        </div>
                    </div>

                <div class="empty"></div>
                {{ Form::button('التالى <i class="fa fa-share"></i>', ['type' => 'submit', 'class' => 'btn btn-success'] )  }}
            </div>
        </div>
</div>
        </div>
    </section>

    <!-- if there are creation errors, they will show here -->
    <!-- if there are creation errors, they will show here -->
    {{ Form::close() }}
    <script>
        function changeFunc() {
            var main_categories = document.getElementById("main_categories");
            var selectedValue = main_categories.options[main_categories.selectedIndex].value;
            var form_data = new FormData();

            var _token = $('input[name=_token]').val();
            form_data.append('_token', _token);
            form_data.append('parent_sb_id', selectedValue);
            $('#sub_categories').empty();
            $('#sub_sub_categories').empty();
            $('#sub_categories').append('  <option value="" >----</option>');

            $.ajax({

                    type: 'get',
                    url: '{{url("getctag")}}/?parent_sb_id=' + selectedValue + '',


                    success: function (data) {

                        $.each(data, function (i, value) {
                            var name = value.name;
                            var id = value.id;


                            $('#sub_categories').append('  <option value="' + id + '">' + name + '</option>');
                            $('#sub_categories').attr('required', 'true');

                        });


                    }


                }
            );
        }

        function changeFuncsub() {
            var main_categories = document.getElementById("sub_categories");
            var selectedValue = main_categories.options[main_categories.selectedIndex].value;
            var form_data = new FormData();

            var _token = $('input[name=_token]').val();
            form_data.append('_token', _token);
            form_data.append('parent_sb_id', selectedValue);
            $('#sub_sub_categories').empty();

            $('#sub_sub_categories').append('<option value="">----</option>');


            $.ajax({

                    type: 'get',
                    url: '{{url("/getctag")}}/?parent_sb_id=' + selectedValue + '',


                    success: function (data) {

                        $.each(data, function (i, value) {
                            var name = value.name;
                            var id = value.id;


                            $('#sub_sub_categories').append('<option value="' + id + '">' + name + '</option>');
                            $('#sub_sub_categories').attr('required', 'true');

                        });


                    }


                }
            );
        }


    </script>


@endsection





@section("customBootstrapJS")

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
            integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
            crossorigin="anonymous"></script>
@endsection


@section("CustomContentAfterGeneralJquery")

    {{-- include styles and javascript of bootstrap multiple select--}}


    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/css/bootstrap-select.min.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/js/bootstrap-select.min.js"></script>


    <script>
        $(document).ready(function () {
            $('#countries').selectpicker({});
            $('#educationLevels').selectpicker({});
        });
    </script>

@endsection