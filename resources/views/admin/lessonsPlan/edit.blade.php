@extends('layouts.app')

@section('custom-content')
    <div class="container">

        @if (Session::has('message'))
            <div class="alert alert-info">{{ Session::get('message') }}</div>
        @endif
        <div class="container main-container">
          
                  <div class="panel panel-green">        
                  <div class="panel-heading"> <h3><i class="fa fa-edit"></i> تعديل خطة التعلم</h3></div>       
                  <div class="panel-body">        
                                    
    <form action="{{route('updatePlan')}}" method="post">
        <input type="hidden" name="planID" value="{{$plans->id}}"/>
        {{csrf_field()}}
        <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
            <label for="recipient-name" class="col-form-label">اسم الخطه:</label>
            <input type="text" class="form-control" required minlength="4" id="plan_name" name="name" placeholder="اسم الخطه" value="{{$plans->name}}" >
        </div>
        <div class="form-group {{ $errors->has('country') ? 'has-error' : '' }}">
            <label for="message-text" class="col-form-label">الدوله:</label>
            <select class="form-control" id="country"  name="country">
                <option value="{{$plans->country->id}}" selected > {{$plans->country->name}}</option>
                @foreach($country as $country)
                    <option value="{{$country->id}}" > {{$country->name}}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group {{ $errors->has('grade') ? 'has-error' : '' }}">
            <label for="sel2">الصف الدراسى :</label>
            <select class="form-control" id="parentgrade" name="parentgrade" value="" onchange="sub_grade();">
                    <?php
                $grade_id=\App\EducationLevel::where('id',$plans->grade_id)->first();
                $parent_name=\App\EducationLevel::find($grade_id->parent_id)->name;

            ?>
                <option value="{{$plans->grade->id}}" selected > {{$parent_name}}</option>
                @foreach($grade as $parent)
                    <option value="{{$parent->id}}"  > &#10000; {{$parent->name}}  </option>

                @endforeach
            </select>
        </div>
        <div class="form-group {{ $errors->has('grade') ? 'has-error' : '' }}">
            <label for="sel2">المستوى:</label>
            <select class="form-control" id="grade" name="grade" value="" >
                <option value="{{$plans->grade->id}}" selected > {{$plans->grade->name}}</option>



            </select>
        </div>
        <div class="form-group {{ $errors->has('active') ? 'has-error' : '' }}">
            <label for="message-text" class="col-form-label">التفعيل:</label>
            <select class="form-control" id="active" name="active" >

                <option value="0" @if($plans->active == 0)selected @endif > غير مفعل</option>
                <option value="1" @if($plans->active == 1)selected @endif > مفعل</option>

            </select>
        </div>
        <div class="modal-footer">

            <button type="submit" class="btn btn-success"><i class="fa fa-edit"></i> تعديل  </button>
            <a class="btn btn-danger" href="{{url('viewplans')}}"><i
                        class="fa fa-reply"></i> الرجوع إلي السابق</a>
        </div>

    </form></div></div>
        </div>
    </div>
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
        </script>
    @endsection
