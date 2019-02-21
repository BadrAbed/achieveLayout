
<!-- Button trigger modal -->
@if(App\Http\OwnClasses\TYPE_OF_USERS_ENUMS::EDITOR!=auth()->user()->is_permission&&App\Http\OwnClasses\TYPE_OF_USERS_ENUMS::QUESTIONEDITOR!=auth()->user()->is_permission)
    {{--<center>--}}
        <button class="btn btn-success" data-toggle="modal" data-target="#exampleModal<?php if(isset($question_id)) echo $question_id; ?>">
            <i class="fa fa-plus"></i> إضافة ملاحظة
        </button>
    {{--</center>--}}
    <!-- Modal -->
    <div class="modal fade" id="exampleModal<?php if(isset($question_id)) echo $question_id; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <span class="modal-title" id="exampleModalLabel">إضافة ملاحظة</span>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <form action="{{url('add/issues'.'/'.$content_id).'/'.$tab_num}}" method="post">
                        {{csrf_field()}}
                        @if(isset($question_id))
                            <input name="question_id" type="hidden" value="{{$question_id}}">
                            @endif
                        <div class="form-group">
                            <div class="col-md-2">
                                {{ Form::label('title', 'العنوان ', array('class' => 'col-form-label')) }}

                            </div>
                            <div class="col-md-13" class="form-group">
                                <input class="form-control" type="text" name="title">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-12">
                                {{ Form::label('name', 'اضافة ملاحظه ', array('class' => 'col-form-label')) }}
                                <input name="image" type="file" id="upload" class="hidden" onchange="">
                            </div>
                            <div class="col-md-12">
                                {{ Form::textarea('name', '', array('class' => 'form-control editor')) }}
                            </div>
                        </div>

                </div>
                <div class="modal-footer">
                    {{ Form::button('إضافة ملاحظة', ['type' => 'submit', 'class' => 'btn btn-primary'] )  }}
                    <button type="button" class="btn btn-danger" data-dismiss="modal">إلغاء</button>
                    </form>
                </div>
            </div>
        </div>
    </div>















    @include('inc.errorMessages')

@endif

@if(\Illuminate\Support\Facades\Request::segment(1)!='allQuestions')
    <br>
    <br>
    <br>
    <hr>
    <br>
    <h3>ملاحظات:</h3>
    <br>
    @php
    $content_issues=\App\Issues::where(['content_id'=>$content_id,'tab_number'=>$tab_num])->get();
$editUrl='#';
if ($tab_num==App\Http\OwnClasses\STUDENT_ASSIGNED_LESSON_PLANS_ENUMS::GET_SHORT_SURVEY_TAB_ENUM||$tab_num==App\Http\OwnClasses\STUDENT_ASSIGNED_LESSON_PLANS_ENUMS::GET_LONG_SURVEY_TAB_ENUM){
$editUrl=url('/content').'/'.$content_id.'/'.'edit';
}
if ($tab_num==App\Http\OwnClasses\STUDENT_ASSIGNED_LESSON_PLANS_ENUMS::GET_NORMAL_ARTICLE_TAB_ENUM){
$editUrl=url('/normal-artical').'/'.$content_id.'/'.'edit';
}
if ($tab_num==App\Http\OwnClasses\STUDENT_ASSIGNED_LESSON_PLANS_ENUMS::GET_SHORT_QUESTIONS_TAB_ENUM||$tab_num==App\Http\OwnClasses\STUDENT_ASSIGNED_LESSON_PLANS_ENUMS::GET_LONG_QUESTIONS_TAB_ENUM){
$editUrl=url('/allQuestions').'/'.$content_id;
}
if ($tab_num==App\Http\OwnClasses\STUDENT_ASSIGNED_LESSON_PLANS_ENUMS::GET_STRETCH_ARTICLE_TAB_ENUM){
$editUrl=url('/stretch-artical').'/'.$content_id.'/'.'edit';
}

@endphp
@if($content_issues->count()>0)
    <table class="table table-bordered" style="padding:50px !important;">
        <thead style="background-color: green;color:#fff;">
        <th> العنوان</th>
        <th> الكاتب</th>
        <th> المؤلف</th>
        <th>الحاله</th>
        <th>تعديل</th>
        <th> عرض</th>
        </thead>
        <tbody>
        @foreach($content_issues as $content_issue)

            <tr style="padding: 30px">
                <td style="font-size: 14px;width: 20%;">{{$content_issue->title}}</td>
                <td>{{$content_issue->user->name}}</td>
                @php
                    $editor_name=\App\User::find($content_issue->content->user_id);
                @endphp
                <td>{{$editor_name->name}}</td>
                <td style="font-size: 14px;">{{App\Http\OwnClasses\ISSUES_STATUS_ENUMS::STATUS($content_issue->status)}}</td>
                <td><a href="{{$editUrl}}" class="btn btn-success"><i class="fa fa-edit"></i> تعديل </a></td>
                <td>
                    <a class="btn btn-info" data-toggle="modal"
                       data-target="#{{$content_issue->id}}"> <i class="fa fa-desktop"></i> عرض
                    </a>


                    @if (auth()->user()->is_permission == \App\Http\OwnClasses\TYPE_OF_USERS_ENUMS::EDITOR || auth()->user()->is_permission == \App\Http\OwnClasses\TYPE_OF_USERS_ENUMS::SUPER_ADMIN || auth()->user()->is_permission == \App\Http\OwnClasses\TYPE_OF_USERS_ENUMS::LEADER)
                        @if($content_issue->status!=1)
                            <a class="btn btn-success" href="{{url('Editor/work/onIssues').'/'.$content_issue->id}}"><i
                                        class="fa fa-anchor"></i>
                                بدأ
                                العمل</a>
                        @endif
                        @if($content_issue->status==1)
                            <a class="btn btn-danger"
                               href="{{url('Editor/close/Issues').'/'.$content_issue->id}}">غلق</a>
                        @endif
                    @endif
                    <div class="modal fade" id="{{$content_issue->id}}" role="dialog">
                        <div class="modal-dialog">

                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;
                                    </button>
                                    <h4 class="modal-title"><i class="fa fa-desktop"></i> عرض الملاحظة </h4>
                                </div>
                                <div class="modal-body" style="text-align: center">

                                    {!! $content_issue->name !!}


                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger pull-right" data-dismiss="modal">
                                        <i class="fa fa-times"></i> إلغاء
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
@else
    <p class="h4">لا توجد ملاحظات</p>
@endif
@endif
