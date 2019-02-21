@extends('layouts.app')

@section('custom-content')


    <div class="container">
        <div class="container main-container">

            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <i class="glyphicon glyphicon-indent-right"></i><h5 class="modal-title" id="exampleModalLabel">إضافة خطة تعلم جديدة</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body text-right">
                            <form action="{{route('addplan')}}" method="post">
                                {{csrf_field()}}
                                <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                                    <label for="name">أسم الخطة:</label>
                                    <input type="text" class="form-control" id="" name="name" required minlength="4">
                                </div>
                                <div class="form-group {{ $errors->has('country') ? 'has-error' : '' }}">
                                <label for="sel1">الدولة:</label>
                                <select class="form-control" id="country"  name="country" required>
                                    <option value="{{old('country')}}" selected >  @if(old('country')!=null) <?php  $old_edu_name=App\Country::where('id',old('country'))->first();?> {{$old_edu_name->name}} @endif</option>
                                    @foreach($country as $cant)
                                        <option value="{{$cant->id}}" > {{$cant->name}}</option>
                                    @endforeach
                                </select>
                        </div>
                        <div class="form-group {{ $errors->has('grade') ? 'has-error' : '' }}">
                            <label for="sel2">الصف الدراسى :</label>
                            <select class="form-control" id="parentgrade" required name="parentgrade" value="" onchange="sub_grade();" >
                                <option value="{{old('grade')}}">@if(old('grade')!=null) <?php  $old_edu_name=App\EducationLevel::where('id',old('grade'))->first();?> {{$old_edu_name->name}} @endif</option>
                                    @foreach($grade as $parent)
                                        <option value="{{$parent->id}}"  > &#10000; {{$parent->name}}  </option>

                                    @endforeach
                            </select>
                        </div>
                        <div class="form-group {{ $errors->has('grade') ? 'has-error' : '' }}">
                            <label for="sel2">المستوى:</label>
                            <select class="form-control" id="grade" name="grade" value="" required >
                                <option value="{{old('grade')}}">@if(old('grade')!=null) <?php  $old_edu_name=App\EducationLevel::where('id',old('grade'))->first();?> {{$old_edu_name->name}} @endif</option>



                            </select>
                        </div>
                        <div class="form-group {{ $errors->has('active') ? 'has-error' : '' }}">
                            <label for="sel3">التفعيل:</label>
                            <select class="form-control" id="active" name="active" >
                                <option value="" disabled selected>اختر </option>
                                <option value="0" @if(old('active') == 0)selected @endif > غير مفعل</option>
                                <option value="1" @if(old('active') == 1)selected @endif > مفعل</option>

                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" ><i class="glyphicon glyphicon-saved"></i> إضافة الخطة</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="glyphicon glyphicon-remove-circle"></i> إلغاء</button>
                    </div>
                    </form>

                </div>
            </div>
        </div>
        </center>
        <div class="col-md-12">
@if(count($errors->all())>0)
                <script>
                    $("#exampleModal").modal();

                </script>
    @endif
            <!--paneeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeel-->
            <div class="panel panel-green">
                <!--paneeeeel Header-->
                <div class="panel-heading">
                    <h3 class="text-center"><span class="glyphicon glyphicon-indent-right"></span>&nbsp;&nbsp;خطط التعلم</h3>
                </div>
                <!--paneeeeel body-->
                <div class="panel-body">
                    @include('inc.errorMessages')
                    <br>
                    <!-- content here -->
                    <center><h3></h3>نوع العرض</h3></center>
                    <div class="form-group">
                        <label for="sel1">البلد:</label>
                        <select class="form-control" name="country" id="countryfilter" onchange="changeFuncCounrty();" >
                            <option value="">-------</option>
                            @foreach($country as $country)
                                <option value="{{$country->id}}">{{$country->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="sel2">المرحلة:</label>
                        <select class="form-control" name="grade" id="gardefilter" onchange="changeFuncGrade();" >
                            <option value="">-------</option>
                            @foreach($grade as $grade)
                                <option value="{{$grade->id}}">{{$grade->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    @if(session()->has('deletemessage'))
                        <div class="alert alert-info">
                            {{Session::get('deletemessage')}}
                        </div>
                        @endif

                    <table class="table" width="100%" id="filtertable">
                        <thead class="thead-dark" style="background: #d8d8d8;color: #555655;">
                        <tr>
                            <th scope="col">أسم الخطة</th>
                            <th scope="col">الفئة العمرية</th>
                            <th scope="col">البلد</th>
                            <th scope="col">الكاتب</th>
                            <th scope="col">الحالة</th>
                            <th scope="col">الإجراء</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if($plans->count() >0)
                        @foreach($plans as  $plans)
                            <tr>
                                <td scope="row">{{ $plans->name }}</td>
                                <td>
                                    {{$plans->guid1}} </td>
                                <td> {{ $plans->country->name }}</td>

                                <td>{{ $plans->user->name }} </td>
                                <td>
                                    @if($plans->active==1)
                                        مفعل
                                    @else
                                        غير مفعل
                                    @endif

                                </td>
                                <td> <!-- show the nerd (uses the show method found at GET /nerds/{id} -->
                                    <a class="btn btn-primary" href="{{route('viewSpecificPlan',['planID'=>$plans->id])}}"> <span class="fa fa-desktop" aria-hidden="true"></span>&nbsp;مشاهدة</a>
                                    <!-- edit this nerd (uses the edit method found at GET /nerds/{id}/edit -->
                                    <a class="btn btn-success " href="{{route('updatePlan',['planID'=>$plans->id])}}"><span class="fa fa-edit" aria-hidden="true"></span>&nbsp;تعديل</a>
                                    <!-- delete the nerd (uses the destroy method DESTROY /nerds/{id} -->
                                    <!-- we will add this later since its a little more complicated than the other two buttons -->
                                    <a class="btn btn-danger" data-href="{{route('deletePlan',['planID'=>$plans->id])}}" data-toggle="modal" data-target="#confirm-delete">
                                        <i class="fa fa-trash"></i> حذف
                                    </a>

                                </td>
                            </tr>
                        @endforeach
                            @else
                                لاتوجد خطط تعلم
                            @endif


                        </tbody>
                    </table>



                    <center>

                        <button class="btn btn-md btn-primary" type="button" data-toggle="modal" data-target="#exampleModal"><span class="fa fa-plus"></span>&nbsp;إضافة خطة تعلم جديدة</button>

                    </center>


                    <!-- end content here -->
                    <!-- Button trigger modal -->

                    <br>
                    <br><br>
                </div>
                <!--end paneeeeel body-->
            </div>
            <!--end paneeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeel-->
        </div>
        @if(Session::has('alert'))

            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
            <div id="myModal" class="modal fade">
                <div class="modal-dialog modal-confirm">
                    <div class="modal-content">
                        <div class="modal-header">
                            <div class="icon-box">
                                <i class="material-icons">&#xE5CD;</i>
                            </div>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        </div>
                        <div class="modal-body text-center">
                            <h4>Ooops!</h4>
                            <p style="margin-right: 80px; color: #9e1317">لا يمكنك المسح الخطه مفعله </p>
                            <button class="btn btn-success" data-dismiss="modal">حاول مره اخرى </button>
                        </div>
                    </div>
                </div>
            </div>
    </div>

    <script>


        $("#myModal").modal();

    </script>
    @endif
    <div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">تاكيد المسح</h4>
            </div>

            <div class="modal-body">
                <p>هل تريد المسح؟ </p>
                <p class="debug-url"></p>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">الغاء</button>
                <a class="btn btn-danger btn-ok">مسح</a>
            </div>
        </div>
    </div>
    </div>

@section('OldJqueryVersion')
    <script data-require="jquery@*" data-semver="2.0.3" src="http://code.jquery.com/jquery-2.0.3.min.js"></script>

    <script>
        $('#confirm-delete').on('show.bs.modal', function(e) {
            $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));


        });
    </script>
@endsection
        <script>
            function  sub_grade() {
                var parent_id = document.getElementById("parentgrade").value;

                $.ajax({
                    type: 'get',
                    url: '{{url('')}}/get_sub_garde/?parent_id=' + parent_id + '',
                    success: function (data) {
                        $('#grade').empty();
                        $.each(data, function (i, value) {
                            var name = value.name;
                            var id = value.id;


                            $('#grade').append('  <option value="' + id + '">' + name + '</option>');
                            $('#grade').attr('required', 'true');

                        });


                    }
                });
            }
            $(document).ready(function(){

                $(document).ajaxStart(function(){
                    $("#wait").css("display", "block");
                });
                $(document).ajaxComplete(function(){
                    $("#wait").css("display", "none");
                });

            });
            function changeFuncCounrty () {

                var country = document.getElementById("countryfilter");
                var selectedcountry=country.options[country.selectedIndex].value;
                var grade = document.getElementById("gardefilter");
                var selectedGrade=grade.options[grade.selectedIndex].value;
                console.log(selectedGrade);



                $.ajax({
                        type: 'get',
                        url: '{{url('')}}/planFilterCountry/?countryfilter=' + selectedcountry+'+&grade_id=' + selectedGrade +'',
                        success: function (data) {
                            // $('#links').append(' '+ data.links +' ')


                            // $('body ').html(data);
                            $('#filtertable tbody').empty();
                            $.each(data, function (i, value) {

                                if (value.active==1){
                                    active="مفعل";
                                }
                                else {
                                    active="غير مفعل";
                                }

                                var  viewurl ='{{route('viewSpecificPlan',['planID'=>'id' ])}}';
                                var viewurl = viewurl.replace('id', value.id);
                                var  editurl ='{{route('updatePlan',['planID'=>'id' ])}}';
                                var editurl = editurl.replace('id', value.id);
                                var  deleteurl ='{{route('deletePlan',['planID'=>'id','grade_id'=>'edu' ,'countryfilter'=>'cant' ])}}';
                                deleteurl = deleteurl.replace('id', value.id);
                                deleteurl = deleteurl.replace('edu', selectedGrade);
                                deleteurl = deleteurl.replace('cant', selectedcountry);
                                $('#filtertable tbody').append('<tr>' + '<td>' + value.name + '</td>' +

                                    '<td>' + value.guid1 + '</td>' +
                                    '<td>' + value.country.name + '</td>' +
                                    '<td>' + value.user.name + '</td>' +

                                    '<td>' + active + '</td>' +
                                    '<td>'+' <a class="btn btn-primary" href='+viewurl+'> <span class="fa fa-desktop" aria-hidden="true"></span> مشاهدة</a>'+
                                    ' <a class="btn btn-success" href='+ editurl+' ><span class="fa fa-edit" aria-hidden="true"></span >تعديل</a>'+
                                    ' <a class="btn btn-danger" data-href='+deleteurl +' data-toggle="modal" data-target="#confirm-delete"><i class="fa fa-trash"></i> حذف</a>'+
                                    '</td>'+
                                    '</tr>');

                            });







                        }
                    }
                );
            }
            function changeFuncGrade () {

                var grade = document.getElementById("gardefilter");
                var selectedGrade=grade.options[grade.selectedIndex].value;
                var country = document.getElementById("countryfilter");
                var selectedcountry=country.options[country.selectedIndex].value;


                $.ajax({
                        type: 'get',
                        url: '{{url('')}}/planFilterGrade/?gradefilter=' + selectedGrade+'+&country_id=' + selectedcountry +'',
                        success: function (data) {
                            // $('#links').append(' '+ data.links +' ')
                            console.log(data);

                            // $('body ').html(data);
                            $('#filtertable tbody').empty();
                            $.each(data, function (i, value) {

                                if (value.active==1){
                                    active="مفعل";
                                }
                                else {
                                    active="غير مفعل";
                                }

                                var  viewurl ='{{route('viewSpecificPlan',['planID'=>'id' ])}}';
                                viewurl = viewurl.replace('id', value.id);
                                var  editurl ='{{route('updatePlan',['planID'=>'id' ])}}';
                                editurl = editurl.replace('id', value.id);
                                var  deleteurl ='{{route('deletePlan',['planID'=>'id','gradefilter'=>'edu' ,'country_id'=>'cant' ])}}';
                                deleteurl = deleteurl.replace('id', value.id);
                                deleteurl = deleteurl.replace('edu', selectedGrade);
                                deleteurl = deleteurl.replace('cant', selectedcountry);


                                $('#filtertable tbody').append('<tr>' + '<td>' + value.name + '</td>' +

                                    '<td>' + value.guid1 + '</td>' +
                                    '<td>' + value.country.name + '</td>' +
                                    '<td>' + value.user.name + '</td>' +

                                    '<td>' + active + '</td>' +
                                    '<td>'+' <a class="btn btn-primary" href='+viewurl+'> <span class="fa fa-desktop" aria-hidden="true"></span> مشاهدة</a>'+
                                    ' <a class="btn btn-success" href='+ editurl+' ><span class="fa fa-edit" aria-hidden="true"></span >تعديل</a>'+
                                    ' <a class="btn btn-danger" data-href='+deleteurl +' data-toggle="modal" data-target="#confirm-delete"><i class="fa fa-trash"></i> حذف</a>'+
                                    '</td>'+
                                    '</tr>');

                            });


                        }
                    }
                );
            }

        </script>


@endsection
