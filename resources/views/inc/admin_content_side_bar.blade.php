<div class="col-sm-4">
    <div class="row">
        <div class="vocabulary-col">
            <div class="vocabulary-title">
                <header class="vocabulary-t" style="background-color:#05932a ;padding:12px;border-radius: 5px;">
                    <p style="color:#fff;">الاجراء</p>
                </header>
            </div>
            <div class="vocabulary">

                <br> @php
                $content=App\Content::find($content->id);
                $CheckAssignContentToLangReviewer = \App\AssignLessonsToReviewers::where(['status' => App\Http\OwnClasses\CONTENT_FOLLOW_STATUS_ENUMS::UNDER_LANG_CORRECT, 'content_id' =>  $content->id])->first();
                $conditionForUsers= auth()->user()->is_permission == \App\Http\OwnClasses\TYPE_OF_USERS_ENUMS::SUPER_ADMIN|| auth()->user()->is_permission == \App\Http\OwnClasses\TYPE_OF_USERS_ENUMS::LEADER;

                $conditionForReviewer=$content->flowStatus==App\Http\OwnClasses\CONTENT_FOLLOW_STATUS_ENUMS::UNDER_REVIEW||$content->flowStatus==App\Http\OwnClasses\CONTENT_FOLLOW_STATUS_ENUMS::RESEND_TO_REVIEWER;
                $conditionForLangReviewer=$content->flowStatus==App\Http\OwnClasses\CONTENT_FOLLOW_STATUS_ENUMS::UNDER_LANG_CORRECT||$content->flowStatus==App\Http\OwnClasses\CONTENT_FOLLOW_STATUS_ENUMS::RESEND_TO_LangREVIEWER;
                $conditionForLangPublisher=$content->flowStatus==App\Http\OwnClasses\CONTENT_FOLLOW_STATUS_ENUMS::UNDER_PUBLISH||$content->flowStatus==App\Http\OwnClasses\CONTENT_FOLLOW_STATUS_ENUMS::RESEND_TO_PUBLISHER;
                $content_creatorAndReviewer = \App\Http\Controllers\ContentController::GetContentCreatorAndReviewer($content->id);
                @endphp
                @if($conditionForUsers)
                <a href=" {{url('Reviewer/sendToCreateQuestions')."/". $content->id}}"
                 class="btn btn-success">ادخال
             الاسئلة</a>
             <a class="btn btn-danger "
             href="{{ URL::to('QuestionsReviewer/refusedQuestions/' . $content_id) }}"><i
             ></i>رفض الاسئلة </a>
             <br>
             <br>
             @endif

             @if (auth()->user()->is_permission == \App\Http\OwnClasses\TYPE_OF_USERS_ENUMS::EDITOR || auth()->user()->is_permission == \App\Http\OwnClasses\TYPE_OF_USERS_ENUMS::SUPER_ADMIN|| auth()->user()->is_permission == \App\Http\OwnClasses\TYPE_OF_USERS_ENUMS::LEADER)

             @if(App\Http\Controllers\ContentFollowStatusController::CheckIfUserAllowToAccessThisContentOrNot($content_id)||$conditionForUsers)

             @if($content->flowStatus==App\Http\OwnClasses\CONTENT_FOLLOW_STATUS_ENUMS::UNDER_CREATE||$conditionForUsers)
             <a href=" {{url('Editor/review')."/". $content->id}}" class="btn btn-info"> مراجعه
             المحتوى</a>
             @elseif($content->flowStatus==App\Http\OwnClasses\CONTENT_FOLLOW_STATUS_ENUMS::REFUSED_FROM_PUBLISHER||$content->flowStatus==App\Http\OwnClasses\CONTENT_FOLLOW_STATUS_ENUMS::REFUSED_FROM_LANG_CORRECT||$content->flowStatus==App\Http\OwnClasses\CONTENT_FOLLOW_STATUS_ENUMS::REFUSED_FROM_Editor ||$conditionForUsers)
             <a href=" {{url('Editor/resendLessonFromEditorToReviewer')."/". $content->id}}"
                 class="btn btn-info"> اعادة اراسال</a>
                 @else
                 {{App\Http\OwnClasses\CONTENT_FOLLOW_STATUS_ENUMS::GET_STATUS_OF_CONTENT($content->flowStatus)}}

                 @endif
                 @endif

                 @endif

                 @if (auth()->user()->is_permission == \App\Http\OwnClasses\TYPE_OF_USERS_ENUMS::REVIEWER||$conditionForUsers)

                 @if(auth()->user()->is_permission == \App\Http\OwnClasses\TYPE_OF_USERS_ENUMS::REVIEWER&&$conditionForReviewer||$conditionForUsers)
                 @if(App\Http\Controllers\ContentFollowStatusController::CheckIfUserAllowToAccessThisContentOrNot($content_id)||$conditionForUsers)
                 <a href=" {{url('Reviewer/refused')."/". $content->id}}" class="btn btn-danger">رفض
                 المحتوى</a>
                 <br>
                 <br>
                 @if($CheckAssignContentToLangReviewer)
                 <a href=" {{url('Reviewer/ResendToLangReview')."/". $content->id}}"
                     class="btn btn-info">مراجعه
                 لغوية</a>
                 @else
                 <a href=" {{url('Reviewer/sendToCreateQuestions')."/". $content->id}}"
                     class="btn btn-success">ادخال
                 الاسئلة</a>

                 @endif
                 @else


                 @endif
                 @else
                 {{App\Http\OwnClasses\CONTENT_FOLLOW_STATUS_ENUMS::GET_STATUS_OF_CONTENT($content->flowStatus)}}
                 @endif

                 @endif


                 @if (auth()->user()->is_permission == \App\Http\OwnClasses\TYPE_OF_USERS_ENUMS::AUDIT ||  $conditionForUsers)

                 @if(auth()->user()->is_permission == \App\Http\OwnClasses\TYPE_OF_USERS_ENUMS::AUDIT&&$conditionForLangReviewer||$conditionForUsers)
                 @if(App\Http\Controllers\ContentFollowStatusController::CheckIfUserAllowToAccessThisContentOrNot($content_id)||$conditionForUsers)
                 <a href=" {{url('LangReviewer/LangReviewerRefuse')."/". $content->id}}"
                     class="btn btn-danger">رفض
                 المحتوى لغويا</a><br><br>
                 <a href=" {{url('LangReviewer/LangReviewerSendToPublisher')."/". $content->id}}"
                     class="btn btn-info">اراسل للنشر</a>
                     @else

                     {{App\Http\OwnClasses\CONTENT_FOLLOW_STATUS_ENUMS::GET_STATUS_OF_CONTENT($content->flowStatus)}}
                     @endif
                     @endif
                     @if (auth()->user()->is_permission == \App\Http\OwnClasses\TYPE_OF_USERS_ENUMS::PUBLISHER || $conditionForUsers)
                     @if(auth()->user()->is_permission == \App\Http\OwnClasses\TYPE_OF_USERS_ENUMS::PUBLISHER&&$conditionForLangPublisher ||$conditionForUsers)
                     @if(App\Http\Controllers\ContentFollowStatusController::CheckIfUserAllowToAccessThisContentOrNot($content_id)||$conditionForUsers)
                     <a href=" {{url('publisher/refused')."/". $content->id}}" class="btn btn-danger">رفض
                     النشر</a>
                     <a href=" {{url('publisher/publish')."/". $content->id}}" class="btn btn-info">نشر</a>
                     @else

                     {{App\Http\OwnClasses\CONTENT_FOLLOW_STATUS_ENUMS::GET_STATUS_OF_CONTENT($content->flowStatus)}}
                     @endif
                     @endif
                     @endif
                     @endif


                 </div>
             </div>
             <div class="vocabulary-col">
                <div class="vocabulary-title">
                    <header class="vocabulary-t" style="background-color:#05932a ;padding:12px;border-radius: 5px;">
                        <p style="color:#fff;">مترادفات</p>
                    </header>
                    <h3>معاني المفردات</h3>
                </div>
                <div class="vocabulary">
                    <table class="vocabulary-table">

                        @foreach($content->vocab as $vocab)
                        <tr>
                            <td class="v-txt-style">{{$vocab->word}}</td>
                            <td>{{$vocab->meaning}}</td>
                        </tr>
                        @endforeach

                    </table>
                </div>

                <!--<div class="vocabulary-end"></div>-->
            </div>
            @if(auth()->user()->is_permission==\App\Http\OwnClasses\TYPE_OF_USERS_ENUMS::SUPER_ADMIN||auth()->user()->is_permission==\App\Http\OwnClasses\TYPE_OF_USERS_ENUMS::LEADER)
            <div class="vocabulary-col">
                <div class="vocabulary-title">
                    <header class="vocabulary-t" style="background-color:#05932a ;padding:12px;border-radius: 5px;">
                        <p style="color:#fff;">مؤلفين ومراجعين المحتوي </p>
                    </header>

                </div>
                <div class="vocabulary">
                    <table class="vocabulary-table">



                        <tr>
                            <td class="v-txt-style">المؤلف</td>
                            <td>{{$content_creatorAndReviewer['editor']}}</td>
                        </tr> <tr>
                            <td class="v-txt-style">مراجع فنى</td>
                            <td>{{$content_creatorAndReviewer['reviwer']}}</td>
                        </tr> <tr>
                            <td class="v-txt-style">مدخل الاسئلة</td>
                            <td>{{$content_creatorAndReviewer['questionCreator']}}</td>
                        </tr>
                        <tr>
                            <td class="v-txt-style">مراجع  الاسئلة</td>
                            <td> {{$content_creatorAndReviewer['questionReviwer']}}</td>
                        </tr>

                        <tr>
                            <td class="v-txt-style">مراجع لغوى</td>
                            <td>{{$content_creatorAndReviewer['langReviewer']}}</td>
                        </tr>


                        <tr>
                            <td class="v-txt-style">الناشر</td>
                            <td>{{$content_creatorAndReviewer['publisher']}}</td>
                        </tr>





                    </table>
                </div>

                <!--<div class="vocabulary-end"></div>-->
            </div>
            @endif
            <div class="vocabulary-col">
                <div class="vocabulary-title">
                    <header class="vocabulary-t" style="background-color:#05932a ;padding:12px;border-radius: 5px;">
                        <p style="color:#fff;">الروابط الإثرائية</p>
                    </header>
                </div>
                <div class="vocabulary">

                    @if(count($content->links)>0)

                    @foreach($content->links as $links)


                    <a target="_blank" href="{{$links->href}}"> {{$links->link}}</a>
                    <br></br>
                    @endforeach
                    @endif
                </div>
            </div>


        </div>
    </div>