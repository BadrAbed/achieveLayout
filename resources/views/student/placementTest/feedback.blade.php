<style>
    #header ul#menu {
        margin: 1rem;
        display: inline-block;
        text-align: left;
        position: absolute;
        left: 23rem;
    }
    .page-card:hover {
        background-color: /* Permalink - use to edit and share this gradient: http://colorzilla.com/gradient-editor/#054f0a+1,299a0b+100 */ background: #054f0a !important;
        background: -moz-linear-gradient(top, #054f0a 1%, #299a0b 100%) !important;
        background: -webkit-linear-gradient(top, #7fbb50 1%, #7fbb50 100%) !important;
        background: linear-gradient(to bottom, #7fbb50 1%, #7fbb50 100%) !important;
        filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#054f0a', endColorstr='#299a0b', GradientType=0) !important;
        color: #fff !important;
    }
    a.lesson{
        font-family: Cairo-SemiBold, WinSoftPro-Medium, AdobeInvisFont;
        float: none !important;
        text-align: center !important;
        background: #7ebe5b;
        color: #fff;
        padding: 1rem !important;
        margin: auto !important;
        border-radius: 0 !important;
    }
    #return-to-top{
        display: none !important;
    }
    .page-card:hover  a.lesson {
        background: #fff;
        color:  #7ebe5b;
    }
</style>
@extends('studentLayout.app')

@section('content')
    <style>


        .page-card {

            display: block;
            text-align: center;
            background: #e9e9e9;
            min-height: 300px;
            border-radius: 20px;
        }

        .page-card h2 {
            text-align: center;
            color: #21ba45;
        }

        .page-card:hover {
            background-color: /* Permalink - use to edit and share this gradient: http://colorzilla.com/gradient-editor/#054f0a+1,299a0b+100 */ background: #054f0a; /* Old browsers */
            background: -moz-linear-gradient(top, #054f0a 1%, #299a0b 100%); /* FF3.6-15 */
            background: -webkit-linear-gradient(top, #054f0a 1%, #299a0b 100%); /* Chrome10-25,Safari5.1-6 */
            background: linear-gradient(to bottom, #054f0a 1%, #299a0b 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
            filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#054f0a', endColorstr='#299a0b', GradientType=0); /* IE6-9 */
            color: #fff !important;
            cursor:  ;
        }

        .page-card:hover > h2 {

            color: #fff !important;

        }

        #return-to-top{
            display: none !important;
        }

    </style>



    <div class="container">
        </br>

        </br>

        </br>
        <div class="row">
            <div class="col-md-8">
                <div class="page-card">
                    <br>

                    <h3 style="padding-right: 30px;">نتيجة الاختبار</h3>
                    <img src="{{asset("/images/cardiogram.png")}}">
                    <h2>  {{$feedback->grade}}%</h2>
                    <br>
                    <br><br>
                </div>
            </div>
            <div class="col-md-4">
                <div class="page-card">
                    <br>
                    <h3 style="padding-right: 30px;">المستوى</h3>
                    <img  src="{{asset("/images/organization.png")}}">
                    <h3 style="text-align: center;">

                        @foreach($feedback->level as $level)
                            {{$level->name}} - {{App\Http\OwnClasses\STUDENT_PLACEMENT_TEST_RESULT_ENUMS::getGrade($feedback->grade)}} </h3>
                    @endforeach

                    <a class="btn  lesson" href="{{url('studentDashboard')}}" style="margin-bottom:40px;border-radius: 50px;"><i class="fa fa-arrow-left"></i> الذهاب لصفحتي الرئيسة</a>
                </div>
            </div>
        </div>












    </div>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
@endsection