@extends('layouts.app')

@section('custom-content')
    @php

        $content=\App\Content::find($content_id);
    @endphp
    <div class="container">

        <div class="container main-container">
            @include("inc.bar")
            <h1>الاسئلة</h1>

            <!-- will be used to show any messages -->
            {{--@if (Session::has('message'))--}}
            {{--<div class="alert alert-info">{{ Session::get('message') }}</div>--}}
            {{--@endif--}}
            @if(auth()->user()->is_permission==\App\Http\OwnClasses\TYPE_OF_USERS_ENUMS::QUESTIONEDITOR||auth()->user()->is_permission==\App\Http\OwnClasses\TYPE_OF_USERS_ENUMS::SUPER_ADMIN||auth()->user()->is_permission==\App\Http\OwnClasses\TYPE_OF_USERS_ENUMS::LEADER)
                @if(App\Http\Controllers\ContentFollowStatusController::CheckIfUserAllowToAccessThisContentOrNot($content_id))
                    <a class="btn btn-success "
                       href="{{ URL::to('QuestionsEditor/create/Questions/'.\App\Http\OwnClasses\STUDENT_ASSIGNED_LESSON_PLANS_ENUMS::GET_SHORT_QUESTIONS_TAB_ENUM .'/'. $content_id) }}"><i
                                class="fa fa-plus-square"></i> اضافة اسئلة</a>

                    @if($content->flowStatus==App\Http\OwnClasses\CONTENT_FOLLOW_STATUS_ENUMS::REFUSE_QUESTIONS)
                        <a class="btn btn-info "
                           href="{{ URL::to('QuestionsEditor/resendQuestionsToQuestionsReviewer/' . $content_id) }}"><i
                                    class="fa fa-share-square"></i>اعادة ارسال</a>
                    @else
                        <a class="btn btn-warning "
                           href="{{ URL::to('QuestionsEditor/SendToQuestionReviewer/' . $content_id) }}"><i
                                    class="fa fa-arrow-circle-left"></i> ارسال للمراجعة</a>




                    @endif
                @endif
            @endif
            @if(auth()->user()->is_permission==\App\Http\OwnClasses\TYPE_OF_USERS_ENUMS::QUESTIONREVIEWER||auth()->user()->is_permission==\App\Http\OwnClasses\TYPE_OF_USERS_ENUMS::SUPER_ADMIN||auth()->user()->is_permission==\App\Http\OwnClasses\TYPE_OF_USERS_ENUMS::LEADER)
                @if(App\Http\Controllers\ContentFollowStatusController::CheckIfUserAllowToAccessThisContentOrNot($content_id))
                    @if ($content->flowStatus != \App\Http\OwnClasses\CONTENT_FOLLOW_STATUS_ENUMS::REVIEW_QUESTIONS  && $content->flowStatus != \App\Http\OwnClasses\CONTENT_FOLLOW_STATUS_ENUMS::RESEND_QUESTIONS)

                        {{App\Http\OwnClasses\CONTENT_FOLLOW_STATUS_ENUMS::GET_STATUS_OF_CONTENT($content->flowStatus)}}
                    @else
                        <a class="btn btn-warning "
                           href="{{ URL::to('QuestionsReviewer/SendToLangReview/' . $content_id) }}"><i
                                    class="fa fa-arrow-circle-left"></i> ارسال للمراجعةاللغوية</a>
                        <a class="btn btn-danger "
                           href="{{ URL::to('QuestionsReviewer/refusedQuestions/' . $content_id) }}"><i
                                    class="fa fa-share"></i>رفض المحتوي </a>
                    @endif
                @endif
            @endif
            <br>
            </br>
            <table class="table table-striped table-bordered">
                <thead>
                <tr>

                    <td>السؤال</td>
                    <td>النوع</td>

                    <td>الاجراء</td>
                </tr>

                </thead>
                <tbody>
                @foreach($questions as $key => $value)
                    @php
                        $row=\App\Issues::where('question_id',$value->id)->first();
                    @endphp
                    @if($row  || auth()->user()->is_permission!=\App\Http\OwnClasses\TYPE_OF_USERS_ENUMS::QUESTIONEDITOR||$content->flowStatus==\App\Http\OwnClasses\CONTENT_FOLLOW_STATUS_ENUMS::CREATE_QUESTIONS)
                        <tr @if($row)    style=" background-color: #8b8c8d;"
                             @endif >


                            <td>{{ $value->question }}</td>
                            <td> @if($value->type=="activityquest")
                                    انشطة
                                    <?php
                                    $typeEnum = App\Http\OwnClasses\STUDENT_ASSIGNED_LESSON_PLANS_ENUMS::GET_SHORT_QUESTIONS_TAB_ENUM;
                                    ?>
                                @else
                                    موسع
                                    <?php
                                    $typeEnum = App\Http\OwnClasses\STUDENT_ASSIGNED_LESSON_PLANS_ENUMS::GET_LONG_QUESTIONS_TAB_ENUM;
                                    ?>
                                @endif
                            </td>

                            <!-- we will also add show, edit, and delete buttons -->
                            <td>
                                <!-- edit this nerd (uses the edit method found at GET /nerds/{id}/edit -->


                                <a class="btn btn-success " href="{{ URL::to('editQuestion/' . $value->id ) }}"><i
                                            class="fa fa-edit"></i> تعديل</a>
                                <a class="btn btn-danger" data-href="{{URL::to('deleteQuestion/' . $value->id )}}"
                                   data-toggle="modal" data-target="#confirm-delete">
                                    <i class="fa fa-trash"></i> حذف</a>
                                <button type="button" class="btn btn-info" data-toggle="modal"
                                        data-target="#{{$value->id}}"> عرض
                                </button>


                                @if($row)
                                    @if(auth()->user()->is_permission!=\App\Http\OwnClasses\TYPE_OF_USERS_ENUMS::QUESTIONEDITOR)

                                    <a class="btn btn-info" data-toggle="modal"
                                       data-target="#exampleModal<?php if (isset($row->question_id)) {
                                           echo $row->question_id;
                                       }
                                       ?>"> <i class="fa fa-desktop"></i> عرض الملاحظات
                                    </a>
                                    {{-- view of show issues and update it--}}
                                    <div class="modal fade" id="exampleModal<?php if (isset($row->question_id)) {
                                        echo $row->question_id;
                                    }
                                    ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                         }
                                         }
                                         aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                <span class="modal-title" id="exampleModalLabel<?php if (isset($row->question_id)) {
                    echo $row->question_id;
                }
                ?>"> ملاحظة</span>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">

                                                    <form action="{{url('edit/issues'.'/'.$row->question_id).'/'.$typeEnum}}"
                                                          method="post">
                                                        {{csrf_field()}}
                                                        @if(isset($question_id))
                                                            <input name="question_id" type="hidden"
                                                                   value="{{$row->question_id}}">
                                                        @endif
                                                        <div class="form-group">
                                                            <div class="col-md-2">
                                                                {{ Form::label('title', 'العنوان ', array('class' => 'col-form-label')) }}

                                                            </div>
                                                            <div class="col-md-13" class="form-group">
                                                                <input class="form-control" type="text"
                                                                       value="{{ $row->title}} " name="title">
                                                            </div>
                                                        </div>
                                                        <div class="row form-group">
                                                            <div class="col-md-12">
                                                                {{ Form::label('name', ' ملاحظه ', array('class' => 'col-form-label')) }}
                                                                <input name="image" type="file" id="upload"
                                                                       class="hidden" onchange="">
                                                            </div>
                                                            <div class="col-md-12">
                                                                {{ Form::textarea('name', $row->name, array('class' => 'form-control editor')) }}
                                                            </div>
                                                        </div>

                                                </div>
                                                <div class="modal-footer">
                                                    @if(auth()->user()->is_permission!=\App\Http\OwnClasses\TYPE_OF_USERS_ENUMS::QUESTIONEDITOR)
                                                        {{ Form::button('تعديل', ['type' => 'submit', 'class' => 'btn btn-primary'] )  }}
                                                    @endif
                                                    <button type="button" class="btn btn-danger" data-dismiss="modal">
                                                        إلغاء
                                                    </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                @else
                                    <a class="btn btn-info" data-toggle="modal"
                                       data-target="#{{$row->id}}"> <i class="fa fa-desktop"></i> عرض الملاحظات
                                    </a>

                                    <div class="modal fade" id="{{$row->id}}" role="dialog">
                                        <div class="modal-dialog">

                                            <!-- Modal content-->
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal">&times;
                                                    </button>
                                                    <h4 class="modal-title"><i class="fa fa-desktop"></i> عرض الملاحظة
                                                    </h4>
                                                </div>
                                                <div class="modal-body" style="text-align: center">

                                                    {!! $row->name !!}


                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-danger pull-right"
                                                            data-dismiss="modal">
                                                        <i class="fa fa-times"></i> إلغاء
                                                    </button>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                @endif
                                @else
                                    @include('inc.issues',['tab_num'=>$typeEnum,'question_id'=>$value->id])
                                @endif


                                <div class="modal fade" id="{{$value->id}}" role="dialog">
                                    <div class="modal-dialog">

                                        <!-- Modal content-->
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal">&times;
                                                </button>
                                                <h4 class="modal-title"></h4>
                                            </div>
                                            <div class="modal-body">
                                                <div class="q1">
                                                    <div class="row form-group">

                                                        <div class="col-md-2">
                                                            {{ Form::label('question', 'السؤال', array('class' => 'col-form-label')) }}
                                                        </div>
                                                        <div class="col-md-10">
                                                            {{ Form::text('questions[0][question]',$value->question , array('class' => 'form-control','required' => 'required','oninvalid'=>"this.setCustomValidity('من فضلك ادخل اسم السوال  ')",'oninput'=>"setCustomValidity('')")) }}
                                                            <br></br>
                                                        </div>

                                                        <div class="row form-group">
                                                            <div class="col-md-2">
                                                                {{ Form::label('ans1', 'الاختيار الاول', array('class' => 'col-form-label')) }}
                                                            </div>
                                                            <div class="col-md-4">
                                                                {{ Form::text('questions[0][ans1]', $value->ans1, array('class' => 'form-control','required' => 'required','oninvalid'=>"this.setCustomValidity('من فضلك ادخل الاجابه الاولى  ')",'oninput'=>"setCustomValidity('')")) }}
                                                            </div>
                                                            <div class="col-md-2 text-left">
                                                                {{ Form::label('ans2', 'الاختيار الثانى', array('class' => 'col-form-label')) }}
                                                            </div>
                                                            <div class="col-md-4">
                                                                {{ Form::text('questions[0][ans2]', $value->ans2, array('class' => 'form-control','required' => 'required','oninvalid'=>"this.setCustomValidity('من فضلك ادخل الاجابه الثانيه  ')",'oninput'=>"setCustomValidity('')")) }}
                                                            </div>
                                                        </div>
                                                        <div class="row form-group">
                                                            <div class="col-md-2">
                                                                {{ Form::label('ans3', 'الاختيار الثالث', array('class' => 'col-form-label')) }}
                                                            </div>
                                                            <div class="col-md-4">
                                                                {{ Form::text('questions[0][ans3]', $value->ans3, array('class' => 'form-control')) }}
                                                            </div>
                                                            <div class="col-md-2 text-left">

                                                                {{ Form::label('ans4', 'الاختيار الرابع', array('class' => 'col-form-label')) }}
                                                            </div>
                                                            <div class="col-md-4">
                                                                {{ Form::text('questions[0][ans4]', $value->ans4, array('class' => 'form-control')) }}
                                                            </div>
                                                        </div>
                                                        <div class="row form-group">
                                                            <div class="col-md-2">
                                                                {{ Form::label('true_answer', 'الاجابه الصحيحه', array('class' => 'col-form-label')) }}
                                                            </div>
                                                            <div class="col-md-4">
                                                                {{ Form::select('questions[0][true_answer]', [
                                                                    'الاجابات' => ['ans1' => 'الاجابه الاولى','ans2' => 'الاجابه التانيه','ans3' => 'الاجابه الثالثه','ans4' => 'الاجابه الرابعه'],

                                                                    ],$value->true_answer)}}

                                                            </div>

                                                        </div>
                                                    </div>


                                                </div>


                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">
                                                    Close
                                                </button>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <!-- delete the nerd (uses the destroy method DESTROY /nerds/{id} -->
                                <!-- we will add this later since its a little more complicated than the other two buttons -->
                                {{--{{ Form::open(array('url' => 'country/' . $value->id, 'class' => 'pull-right')) }}--}}
                                {{--{{ Form::hidden('_method', 'DELETE') }}--}}
                                {{--{{ Form::submit('حذف', array('class' => 'ui negative basic button')) }}--}}
                                {{--{{ Form::close() }}--}}


                            </td>
                        </tr>
                    @endif
                @endforeach
                </tbody>
            </table>
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
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;
                                </button>
                            </div>
                            <div class="modal-body text-center">
                                <h4>Ooops!</h4>
                                <p style="margin-right: 80px; color: #9e1317">لا يمكنك المسح توجد دورس لهذا
                                    البد </p>
                                <button class="btn btn-success" data-dismiss="modal">حاول مره اخرى</button>
                            </div>
                        </div>
                    </div>
                </div>
        </div>

        <script>


            $("#myModal").modal();

        </script>
        @endif

        <div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
             aria-hidden="true">
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
            <script data-require="jquery@*" data-semver="2.0.3"
                    src="http://code.jquery.com/jquery-2.0.3.min.js"></script>

            <script>
                $('#confirm-delete').on('show.bs.modal', function (e) {
                    $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));


                });
            </script>
        @endsection

    </div>
    </div>

@endsection
