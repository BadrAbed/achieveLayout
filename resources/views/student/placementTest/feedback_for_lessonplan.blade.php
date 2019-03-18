@extends('studentLayout.app')

@section('content')
    <style>

        td {
            background-color: #ffffff !important;
            color: #000 !important;

        }

        th {
            background-color: #7fbb50!important;
            color: #fff
        }

        td, th {
            padding: 30px !important;
            text-align: center;

        }



        td {
            background-color: #5f5f5f;
            color: #fff
        }

        .container h2 {
            font-family: Cairo-SemiBold, WinSoftPro-Medium, AdobeInvisFont;
        }

        .container table {
            font-family: 'Amiri', serif;
        }

        .container {
            width: 60%;
            margin: 3rem auto;
        }
    </style>
    <div class="container">
        </br>

        </br>
        <h2> النتيجة النهائية للدروس</h2>
        </br>

        <table class="table table-bordered table-hover text-white">
            <thead>
            <tr class="bg-success">


                <th>البونص</th>
                <th>الدرجة</th>
                <th>المحتوى</th>
            </tr>
            </thead>
            @foreach($allLessonPlanContents as $LessonPlanContents)

                <tr class="active">


                    <td>{{$LessonPlanContents->bonus}}</td>
                    <td>{{$LessonPlanContents->degree}}</td>
                    <td> <a href="{{url('student/content/question/'.$LessonPlanContents->content->id.'/0/2')}}"> {{$LessonPlanContents->content->content_name}} </a> </td>
                </tr>
            @endforeach
        </table>
        {{--<br><a href="{{url('Student/next/placement_test')}}" class="btn btn-success"><i class="fa fa-reply"></i> امتحان تحديد المستوى التالى </a>--}}


    </div>












@endsection