@extends('layouts.app')

@include("voice_sentences.partials.CSSaudioPlugin")

@section('custom-content')


    @php
        $stretchContentArr = \App\Http\OwnClasses\CONTENT_EDITOR_NEW_CONTENT_SEPERATOR_ICON::getArrayOfContentsByStringConcatenatedString($content->articalstrach->article);//process mutliple tabs for the same content

    @endphp



    <link rel="stylesheet" href="{{asset("/css/components/mark_as_completed.css")}}">




    <div class="container">
        <br>
        <!--paneeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeel-->
        <div class="panel panel-green">
            <div class="panel-heading">
                <div class="">
                    <p class="h3">
                        {{$content->content_name}}
                    </p>
                </div>
            </div>
        </div>
        <!--paneeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeel-->


    </div>
    <div class="container">
        <div class="col-sm-8">
            <div class="row">
                <div class="tab-container">
                    <div class="main-taps">
                        @include('inc.content_navbar')
                    </div>

                    <section id="content6" style="padding-top: 40px;">
                        <table class="table table-bordered">
                            <thead style="background-color: green;color:#fff;">
                            <th> العنوان</th>
                            <th> الكاتب</th>
                            <th> المؤلف</th>
                            <th>الحاله</th>
                            <th> عرض</th>
                            </thead>
                            <tbody>
                            @foreach($content_issues as $content_issue)

                                <tr>
                                    <td>{{$content_issue->title}}</td>
                                    <td>{{$content_issue->user->name}}</td>
                                    @php
                                        $editor_name=\App\User::find($content_issue->content->user_id);
                                    @endphp
                                    <td>{{$editor_name->name}}</td>
                                    <td>{{App\Http\OwnClasses\ISSUES_STATUS_ENUMS::STATUS($content_issue->status)}}</td>
                                    <td>
                                        <button type="button" class="btn btn-info" data-toggle="modal"
                                                data-target="#{{$content_issue->id}}"><i class="fa fa-desktop"></i> عرض
                                        </button>
                                        <div class="modal fade" id="{{$content_issue->id}}" role="dialog">
                                            <div class="modal-dialog">

                                                <!-- Modal content-->
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal">&times;
                                                        </button>
                                                        <h4 class="modal-title"><i class="fa fa-desktop"></i>   عرض الملاحظة </h4>
                                                    </div>
                                                    <div class="modal-body" style="text-align: center">

                                                        {!! $content_issue->name !!}



                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-danger pull-right" data-dismiss="modal">
                                                            <i class="fa fa-times"></i>   إلغاء
                                                        </button>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </td>
                                </tr>


                            @endforeach
                            </tbody>
                        </table>


                    </section>
                </div>
            </div>
        </div>
        @include('inc.admin_content_side_bar')
    </div>

@endsection
