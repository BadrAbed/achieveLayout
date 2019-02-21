@extends('layouts.app')

@section('custom-content')
    <div class="container">




        <div class="container main-container">

            <div class="container">
                <div class="container main-container">
                    <div class="col-md-12">

                        <!--paneeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeel-->
                        <div class="panel panel-green">
                            <!--paneeeeel Header-->
                            <div class="panel-heading">
                                <h3 class="text-center"><i class="fa fa-window-restore"></i> خطط التعلم</h3>
                            </div>


                            <!--paneeeeel body-->
                            <div class="panel-body">
                                 
                               
                                
                                <br>
                                <!-- content here -->
                                <?php $index =1; ?>
                                <table class="table" width="100%">
                                    <thead class="thead-dark" style="background: #d8d8d8;color: #555655;">
                                    <tr>
                                        <th scope="col">الترتيب</th>
                                        <th scope="col">أسم الدرس</th>
                                        <th scope="col">الإجراء</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @for ($i=0;$i<count($content);$i++)
                                        <?php $contentPlan=$content[$i];

                                        ?>
                                        @foreach ($contentPlan as $contentPlan)
                                            <tr>
                                                <td>{{$index}}</td>
                                                <td>{{$contentPlan->content_name}}</td>


                                        <td> <!-- show the nerd (uses the show method found at GET /nerds/{id} -->
                                            <!-- delete the nerd (uses the destroy method DESTROY /nerds/{id} -->
                                            <!-- we will add this later since its a little more complicated than the other two buttons -->
                                            <a class="btn btn-primary" href="{{ URL::to('content/' . $contentPlan->id) }}"> <span
                                                        class="fa fa-desktop" aria-hidden="true"></span>&nbsp;مشاهدة</a>
                                            <a class="btn btn-danger "   href="{{route('deletePlanSpecificLesson',['content_id'=> $contentPlan->id,'plan_id'=>$planid])}}"><span class="fa fa-trash" aria-hidden="true"></span>&nbsp;حذف</a>
                                        </td>
                                    </tr>
                                        @endforeach
                                        <?php $index++; ?>
                                    @endfor
                                    </tbody>

                                </table>
                                <a class="btn btn-success" href="{{route('editPlanSpecificLesson',['plan_id'=>$planid])}}"><i class="fa fa-edit" ></i> تعديل</a>







                                <!-- end content here -->
                                <!-- Button trigger modal -->

                                <a class="btn btn-danger" href="{{url('viewplans')}}"><i
                                            class="fa fa-reply"></i> الرجوع إلي السابق</a>    <!-- Modal -->

                                
                                <br>
                                <br><br>
                            </div>
                            <!--end paneeeeel body-->
                        </div>
                        <!--end paneeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeel-->
                    </div>
                </div>
            </div>




        </div>
    </div>
@endsection