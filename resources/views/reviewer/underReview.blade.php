@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header"></div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif
                        <br>
                        <br>
                        <br>
                          <div class="panel panel-green">
                    <div class="panel-heading">
                        <h3 class="text-center"> <!-- <span class="fa fa-window-restore"></span> -->&nbsp;&nbsp; دروسي</h3>
                    </div>
                    <div class="panel-body">
                        <br>
                        <table class="table table-bordered">

                            <thead>
                            <th>اسم المحتوى</th>
                            <th> الحاله</th>
                            <th> الصف</th>
                            <th> البلد</th>
                            <th> عرض</th>
                            </thead>
                            @foreach($contents as $content)
                                <tr>
                                    <td>{{$content->content_name}}</td>
                                    <td>{{\App\Http\OwnClasses\CONTENT_FOLLOW_STATUS_ENUMS::GET_STATUS_OF_CONTENT($content->flowStatus)}}</td>
                                    <td>{{$content->grade->name}}
                                        - <?=App\EducationLevel::find($content->grade->parent_id)->name ?></td>
                                    @if($content->country)
                                        <td>{{$content->country->name}}</td>
                                    @else
                                        <td> عام</td>
                                    @endif
                                    <td><a href="{{url('content/')."/".$content->id}}" class="btn btn-info"> عرض</a></td>
                                </tr>
                                @endforeach
                                </thead>
                        </table>
                  
                        <br>
                         
                        <br><br>
                    </div>
                </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
