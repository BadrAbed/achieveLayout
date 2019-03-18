@php
    use \App\NormalArtical;
    use \App\Content;
    $normalArticleId = @Content::find($content_id)->articalnormal->id;
    $stretchArticleId = @Content::find($content_id)->articalstrach->id;


use App\Http\OwnClasses\STUDENT_ASSIGNED_LESSON_PLANS_ENUMS;
use App\Http\Controllers\CommonStudentTabsProcesses;
    $first_tab_url = URL::to('student'.'/content/poll/'.$content_id.'/'.'0'."/".STUDENT_ASSIGNED_LESSON_PLANS_ENUMS::GET_SHORT_SURVEY_TAB_ENUM);
 $second_tab_url = URL::to("/".'student'.'/content/artical/short/'.$content_id."/".STUDENT_ASSIGNED_LESSON_PLANS_ENUMS::GET_NORMAL_ARTICLE_TAB_ENUM);
$third_tab_url = URL::to("/".'student'.'/content/question/'.$content_id.'/'.'0'."/".STUDENT_ASSIGNED_LESSON_PLANS_ENUMS::GET_SHORT_QUESTIONS_TAB_ENUM);
$fourth_tab_url = URL::to("/".'student'.'/content/poll/'.$content_id.'/'.'1'."/".STUDENT_ASSIGNED_LESSON_PLANS_ENUMS::GET_LONG_SURVEY_TAB_ENUM);
 $fifth_tab_url = URL::to("/".'student'.'/content/artical/long/'.$content_id."/".STUDENT_ASSIGNED_LESSON_PLANS_ENUMS::GET_STRETCH_ARTICLE_TAB_ENUM);
  $six_tab_url = URL::to("/".'student'.'/content/question/'.$content_id.'/'.'1'."/".STUDENT_ASSIGNED_LESSON_PLANS_ENUMS::GET_LONG_QUESTIONS_TAB_ENUM);

@endphp
<ul class="tabs">
    <li class="tab-link {{(request()->url()==$first_tab_url?"current":"")}}" data-tab="tab-1" onclick="location.href='{{$first_tab_url}}';">
        {{--<img src="{{asset('Studentpublic/images/tab1.png')}}" class="" alt="">--}}
        <span class="{{(request()->url()==$first_tab_url?"active":"current")}}" ></span>
        <span class="">السؤال القبلي</span>
    </li>
    <li class="tab-link {{(request()->url()==$second_tab_url?"current":"")}}" data-tab="tab-2" onclick="location.href='{{$second_tab_url}}';">
        {{--<img src="{{asset('Studentpublic/images/tab2.png')}}" class="" alt="">--}}
        <span class="{{(request()->url()==$second_tab_url?"active":"current")}}"></span>
        <span>المقـال</span>
    </li>
    <li class="tab-link {{(request()->url()==$third_tab_url?"current":"")}}" data-tab="tab-3" onclick="location.href='{{$third_tab_url}}';">
        {{--<img src="{{asset('Studentpublic/images/tab3.png')}}" class="" alt="">--}}
        <span class="{{(request()->url()==$third_tab_url?"active":"current")}}"></span>
        <span>الأنشطــة</span>
    </li>
    <li class="tab-link {{(request()->url()==$fourth_tab_url?"current":"")}} " data-tab="tab-4" onclick="location.href='{{$fourth_tab_url}}';">
        {{--<img src="{{asset('Studentpublic/images/tab1.png')}}" class="" alt="">--}}
        <span class="{{(request()->url()==$fourth_tab_url?"active":"current")}}"></span>
        <span>السؤال البعدي</span>
    </li>
    <li class="tab-link {{(request()->url()==$fifth_tab_url?"current":"")}}" data-tab="tab-5" onclick="location.href='{{$fifth_tab_url}}';">
        {{--<img src="{{asset('Studentpublic/images/tab2.png')}}" class="" alt="">--}}
        <span class="{{(request()->url()==$fifth_tab_url?"active":"current")}}"></span>
        <span>المقال الموسع</span>
    </li>
    <li class="tab-link {{(request()->url()==$six_tab_url?"current":"")}}" data-tab="tab-6" onclick="location.href='{{$six_tab_url}}';">
        {{--<img src="{{asset('Studentpublic/images/tab5.png')}}" class="" alt="">--}}
        <span class="{{(request()->url()==$six_tab_url?"active":"current")}}"></span>
        <span>نشاط موسع</span>
    </li>
</ul>
