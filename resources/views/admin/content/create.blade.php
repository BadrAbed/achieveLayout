@extends('layouts.app')
@section('custom-content')

    @include('inc.progress_bar')

    <div class="container">
        <div class="container main-container">
            <div class="col-md-12">
                <div class="row">

                    <!-- BEGIN Step Indicator-1 -->

                    <!-- END Step Indicator-1 -->

                </div>
                <br><br>
                <!--paneeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeel-->
                <div class="panel panel-green">
                    <!--paneeeeel Header-->
                    <div class="panel-heading">
                        <h3 class="text-center"><span class="fa fa-plus-circle"></span>&nbsp;&nbsp;اضافة الدرس</h3>
                    </div>
                    <!--paneeeeel body-->
                    <div class="panel-body">
                        <br>
                        @include('inc.errorMessages')
                        {!! Form::open(['action' => 'ContentController@store', 'method' => 'POST', 'files'=>'true']) !!}
                        {{csrf_field()}}

                        <div class="row form-group ">

                            <div class="col-md-2 ">
                                <label for="education_level_id">المرحلة الدراسية</label>


                            </div>
                            <div class="col-md-4 {{ $errors->has('education_level_id') ? 'has-error' : ''}}">
                                <div class="ui input  fluid ">
                                    <select class="form-control" name="education_level_id" id="sort-item" required>
                                        <option value="">-----</option>
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
                                <label for="country_id">الدوله</label>
                            </div>
                            <div class="col-md-4 {{ $errors->has('countries') ? 'has-error' : ''}}">
                                <div class="ui input fluid">
                                    <select class="form-control" name="countries">
                                        @if(old('countries')!=null)
                                            <option value="{{old('countries')}}">    <?php  $old_cant_name = App\Country::where('id', old('countries'))->first();?> {{$old_cant_name->name}} </option>
                                        @else
                                            <option value=""> عام</option>
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
                                <label for="main_categories_id">التصنيفات </label>
                            </div>
                            <div class="col-md-4 {{ $errors->has('main_categories_id') ? 'has-error' : ''}}">
                                <div class="ui input fluid">
                                    <select class="form-control" name="main_categories_id" required id="main_categories"
                                            onchange="changeFunc();">
                                        <option value="{{old('main_categories_id')}}">@if(old('main_categories_id')!=null) <?php  $old_edu_name = App\Categories::where('id', old('main_categories_id'))->first();?> {{$old_edu_name->name}} @endif</option>
                                        @foreach($main_categories_id as $main_category_id)
                                            <option value="{{$main_category_id->id}}">{{$main_category_id->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="ui input fluid">
                                    <select class="form-control" name="sub_categories_id" id="sub_categories"
                                            onchange="changeFuncsub();"
                                            oninvalid="this.setCustomValidity('من فضلك اختر تصنيف اضافى  ')"
                                            oninput="setCustomValidity('')">
                                        <option value="{{old('sub_categories_id')}}">@if(old('sub_categories_id')!=null) <?php  $old_edu_name = App\Categories::where('id', old('sub_categories_id'))->first();?> {{$old_edu_name->name}} @endif</option>

                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="ui input fluid">
                                    <select class="form-control" name="sub_sub_categories_id" id="sub_sub_categories"
                                            oninvalid="this.setCustomValidity('من فضلك اختر تصنيف اضافى  ')"
                                            oninput="setCustomValidity('')">
                                        <option value="{{old('sub_sub_categories_id')}}">@if(old('sub_sub_categories_id')!=null) <?php  $old_edu_name = App\Categories::where('id', old('sub_sub_categories_id'))->first();?> {{$old_edu_name->name}} @endif</option>

                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row form-group ">
                            <div class="col-md-2">
                                {{ Form::label('goal_id_list', 'نواتج التعلم', array('class' => 'col-form-label')) }}

                            </div>
                            <div class="col-md-4 {{ $errors->has('goal_id_list') ? 'has-error' : ''}}">


                                <select style="z-index: 10000" name="goal_id_list[]" required data-live-search="true"
                                        id="countries" title="اختر ناتج"
                                        class="ui dropdown fluid " multiple="" data-actions-box="true">
                                    @foreach ($learingGoal as  $learingGoal)

                                        <option

                                                @if(old("goal_id_list"))
                                                {{(in_array($learingGoal->id,old("goal_id_list")))?"selected=''":""}}
                                                @endif

                                                value="{{$learingGoal->id}}">{{$learingGoal->learing_goals_name}}</option>

                                    @endforeach
                                </select>

                            </div>
                        </div>


                        </br>
                        <div class="row form-group">
                            <div class="col-md-2">
                                <label for="content_name">اسم الدرس</label>
                            </div>
                            <div class="col-md-4 {{ $errors->has('content_name') ? 'has-error' : ''}}">
                                <input class="form-control" name="content_name" type="text" required minlength='4'
                                       value="{{old('content_name')}}" id="content_name">
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-md-2 ">
                                <label for="content_location"> مكان الدرس</label>
                            </div>
                            <div class="col-md-10 {{ $errors->has('content_location') ? 'has-error' : ''}}">
                                <textarea name="content_location" required class="form-control" rows="5">{{old('content_location')}}</textarea>
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-md-2 ">
                                <label for="poll">السؤال القبلي والبعدي</label>
                            </div>
                            <div class="col-md-10 {{ $errors->has('poll') ? 'has-error' : ''}}">
                                <input class="form-control" name="poll" type="text" required value="{{old('poll')}}"
                                       id="poll">
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-md-2 ">
                                <label for="abstract">تمهيد مختصر للسؤال القبلى</label>
                            </div>
                            <div class="col-md-10 {{ $errors->has('hint') ? 'has-error' : ''}}">
                                <textarea name="hint" required class="form-control" rows="5">{{old('hint')}}</textarea>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-2 ">
                                <label for="abstract">نبذه مختصره</label>
                            </div>
                            <div class="col-md-10 {{ $errors->has('abstract') ? 'has-error' : ''}}">
                                <textarea class="form-control " required name="abstract" rows="5"
                                          id="abstract"> {{old('abstract')}}</textarea>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-2">
                                <label for="image" class="col-form-label">صورة الغلاف</label>
                            </div>
                            <div class="col-md-10 {{ $errors->has('image') ? 'has-error' : ''}}">
                                <div class="input-group mb-3">
                                    <div class="input-group-append">
                                        <div class="upload-btn-wrapper ">
                                            <button class="{{ $errors->has('image') ? 'btnme-error' : 'btnme'}}"><span
                                                        class="fa fa-plus-circle"></span>&nbsp;تحميل الملف
                                            </button>
                                            <input type="file" id="image" required accept="image/*" name="image"
                                                   onkeyup="changename();"/>
                                        </div>
                                        <img id="blah" src="#" alt="لا توجد صوره"
                                             style="width:80px;height:80px;background-position:center;background-size:cover;position: relative;"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-2">
                                <label for="image" class="col-form-label">صورة الدرس</label>
                            </div>
                            <div class="col-md-10 {{ $errors->has('Lesson_image') ? 'has-error' : ''}}">
                                <div class="input-group mb-3">
                                    <div class="input-group-append">
                                        <div class="upload-btn-wrapper ">
                                            <button class="{{ $errors->has('Lesson_image') ? 'btnme-error' : 'btnme'}}"><span
                                                        class="fa fa-plus-circle"></span>&nbsp;تحميل الملف
                                            </button>
                                            <input type="file" id="image2" required accept="image/*" name="Lesson_image"
                                                   onkeyup="changename();"/>
                                        </div>
                                        <img id="blah2" src="#" alt="لا توجد صوره"
                                             style="width:80px;height:80px;background-position:center;background-size:cover;position: relative;"/>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if(old('links')>0)
                            <?php $i = 0 ?>
                            @foreach(old('links') as $links)
                                <div id="oldlinks">
                                    <div class="row form-group">
                                        <div class="col-md-2 ">
                                            <label for="link">الاسم</label>
                                        </div>

                                        <div class="col-md-4 {{ $errors->has($links['link']) ? 'has-error' : ''}}">
                                            <input class="form-control " id="link[{{$i}}]" name="links[{{$i}}][link]"
                                                   required type="text" value="{{$links['link']}}">
                                        </div>
                                        <div class="col-md-2 text-left">
                                            <label for="href">الرابط</label>
                                        </div>
                                        <div class="col-md-4 {{ $errors->has('links.'.$i.'.href') ? 'has-error' : ''}}">
                                            <input class="form-control " id="href[{{$i}}]" required
                                                   pattern="https?://.+" name="links[{{$i}}][href]" type="url"
                                                   value="{{$links['href']}}">
                                        </div>
                                        <div class="col-md-2">
                                        </div>

                                        <br>

                                    </div>
                                </div>
                                <?php $i++ ?>
                            @endforeach
                            <div id="links">
                            </div>
                            <div class="col-md-10">
                                <br>
                                <button id="addLinks" class="btn btn-md btn-primary"><span class="fa fa-link"></span>&nbsp;إضافة
                                    رابط
                                </button>
                            </div>

                        @else
                            <div id="links">
                                <div class="row form-group">
                                    <div class="col-md-2 ">
                                        <label for="link">الاسم</label>
                                    </div>

                                    <div class="col-md-4 {{ $errors->has('links.*.link') ? 'has-error' : ''}}">
                                        <input class="form-control " id="link[0]" required name="links[0][link]"
                                               type="text" value="">
                                    </div>
                                    <div class="col-md-2 text-left">
                                        <label for="href">الرابط</label>
                                    </div>
                                    <div class="col-md-4 {{ $errors->has('links.*.href') ? 'has-error' : ''}}">
                                        <input class="form-control " id="href[0]" onblur="ckeckhref();" required
                                               pattern="https?://.+" name="links[0][href]" type="url" value="">
                                    </div>
                                    <div class="col-md-2">
                                    </div>
                                    <div class="col-md-10">
                                        <br>
                                        <button id="addLinks" class="btn btn-md btn-primary"><span
                                                    class="fa fa-link"></span>&nbsp;إضافة رابط
                                        </button>
                                    </div>
                                    <br>

                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="empty"></div>
                    <center>
                        <button type="submit" class="btn btn-md  btn-success"><i class="fas fa-caret-left"></i>&nbsp;المرحلة
                            التالية
                        </button>
                        <a class="btn btn-md btn-danger" href="{{URL::previous()}}"><span class="fa fa-redo"></span>&nbsp;الرجوع
                            إلي السابق</a>
                    </center>
                    <br><br>
                    {{ Form::close() }}
                </div>

            </div>
            </section>
            <!-- if there are creation errors, they will show here -->
            <!-- if there are creation errors, they will show here -->
            </form>
            <br>
            <br><br>
        </div>
        <!--end paneeeeel body-->
    </div>

    <script>
        /* document.getElementById("image").onchange=function (){
             var file = $('#image')[0].files[0].name;
             var url= $('#image')[0].files[0]['mozFullPath'];

          document.getElementById("imagename").innerHTML="<img src=''+file+'' width=\"400px\" height=\"150px\">" ;
         };
*/

        function readURL(input) {

            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#blah').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        function readURL2(input) {

            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#blah2').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        document.getElementById("image").onchange = function () {
            readURL(this);
        };
        document.getElementById("image2").onchange = function () {
            readURL2(this);
        };

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
                    url: '{{url("getctag")}}/?parent_sb_id=' + selectedValue + '',


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
