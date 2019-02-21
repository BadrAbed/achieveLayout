@extends('layouts.app')

@section('content')
<style>
 
       td{
        background-color:#ffffff !important;
       color: #000 !important;
       
   }
   th{
    background-color: #049d2c !important;
    color: #fff
   }
   td,th{
    padding: 30px !important;
    text-align: center;
  
    
   }
   td{
       background-color: #5f5f5f;
       color: #fff
   }
 
  </style>
    <div class="container">
    </br>
    
        </br>
       <h2> النتيجة النهائية للدرس</h2>
        </br>

     <table class="table table-bordered table-hover text-white">
        <thead>
                        <tr class="bg-success">
            <th>المحتوى</th>
            <th>الدرجة</th>
            <th>البونص</th>
        </tr>
        </thead>
        @foreach($allLessonPlanContents as $LessonPlanContents)

            <tr class="active">
                <td> {{$LessonPlanContents->content->content_name}}</td>
                <td>{{$LessonPlanContents->degree}}</td>
                <td>{{$LessonPlanContents->bonus}}</td>
            </tr>
        @endforeach
    </table>
<br><a href="{{url('Student/next/placement_test')}}" class="btn btn-success"><i class="fa fa-reply"></i> امتحان تحديد المستوى التالى </a>


    </div>












@endsection