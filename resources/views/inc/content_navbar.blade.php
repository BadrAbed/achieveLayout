@php
    use \App\NormalArtical;
    use \App\Content;
    $normalArticleId = @Content::find($content_id)->articalnormal->id;
    $stretchArticleId = @Content::find($content_id)->articalstrach->id;


use App\Http\OwnClasses\STUDENT_ASSIGNED_LESSON_PLANS_ENUMS;
use App\Http\Controllers\CommonStudentTabsProcesses;


@endphp


<style>

    .dot {
        height: 25px;
        width: 25px;
        background-color: #bababc;
        border-radius: 50%;
        display: inline-block;
    }

    .main-taps a {
        padding: 1px !important;
        color: #fff !important;
    }

    .main-taps > input:checked + label a {
        color: #000 !important;
    }
</style>

@php

    //handle navigation links based on user type
    if (Permissions::STUDENT_PERMISSION_ENUM == auth()->user()->is_permission) {//if student
        $url_pattern ="student";
    }
    else{
        $url_pattern ="admin";
    }

@endphp
@php
    $first_tab_url = URL::to($url_pattern.'/content/poll/'.$content_id.'/'.'0'."/".STUDENT_ASSIGNED_LESSON_PLANS_ENUMS::GET_SHORT_SURVEY_TAB_ENUM);
@endphp

<input id="tab1" type="radio" name="tabs"
       onclick="location.href='{{$first_tab_url}}';" <?=($first_tab_url == Request()->url()) ? "checked=''" : "" ?>>
<label for="tab1">

    @if (Permissions::STUDENT_PERMISSION_ENUM == auth()->user()->is_permission)

        <?php
        $tab_short_survey_enum_status = \App\Http\Controllers\CommonStudentTabsProcesses::get_specific_tab_status_of_specific_content_of_specific_lesson_plan_of_student($content_id, STUDENT_ASSIGNED_LESSON_PLANS_ENUMS::GET_SHORT_SURVEY_TAB_ENUM);
        if ($tab_short_survey_enum_status == true) {
            echo "<i class='glyphicon glyphicon-ok-circle'></i>";
        } else {
            echo " <i class='fa fa-spinner' ></i>";
        }

        ?>

    @endif

    السؤال القبلي</label>


@php
    $second_tab_url = URL::to("/".$url_pattern.'/content/artical/short/'.$content_id."/".STUDENT_ASSIGNED_LESSON_PLANS_ENUMS::GET_NORMAL_ARTICLE_TAB_ENUM);
@endphp
<input id="tab2" type="radio" name="tabs"
       onclick="location.href='{{$second_tab_url}}';" <?=($second_tab_url == Request()->url()) ? "checked=''" : "" ?>>
<label for="tab2">

    @if (Permissions::STUDENT_PERMISSION_ENUM == auth()->user()->is_permission)

        <?php
        $tab_short_survey_enum_status = \App\Http\Controllers\CommonStudentTabsProcesses::get_specific_tab_status_of_specific_content_of_specific_lesson_plan_of_student($content_id, STUDENT_ASSIGNED_LESSON_PLANS_ENUMS::GET_NORMAL_ARTICLE_TAB_ENUM);
        if ($tab_short_survey_enum_status == true) {
            echo " <i class='glyphicon glyphicon-ok-circle' ></i>";
        } else {
            echo " <i class='fa fa-spinner' ></i>";
        }

        ?>

    @endif

    المقال</label>

@php
    $third_tab_url = URL::to("/".$url_pattern.'/content/question/'.$content_id.'/'.'0'."/".STUDENT_ASSIGNED_LESSON_PLANS_ENUMS::GET_SHORT_QUESTIONS_TAB_ENUM);
@endphp

<input id="tab3" type="radio" name="tabs"
       onclick="location.href='{{$third_tab_url}}'" <?=($third_tab_url == Request()->url()) ? "checked=''" : "" ?>>
<label for="tab3">
    @if (Permissions::STUDENT_PERMISSION_ENUM == auth()->user()->is_permission)

        <?php
        $tab_short_survey_enum_status = \App\Http\Controllers\CommonStudentTabsProcesses::get_specific_tab_status_of_specific_content_of_specific_lesson_plan_of_student($content_id, STUDENT_ASSIGNED_LESSON_PLANS_ENUMS::GET_SHORT_QUESTIONS_TAB_ENUM);
        if ($tab_short_survey_enum_status == true) {
            echo "<i class='glyphicon glyphicon-ok-circle' ></i>";
        } else {
            echo " <i class='fa fa-spinner' ></i>";
        }

        ?>

    @endif

    الأنشطة</label>


@php
    $fourth_tab_url = URL::to("/".$url_pattern.'/content/poll/'.$content_id.'/'.'1'."/".STUDENT_ASSIGNED_LESSON_PLANS_ENUMS::GET_LONG_SURVEY_TAB_ENUM);
@endphp

<input id="tab4" type="radio" name="tabs"
       onclick="location.href='{{$fourth_tab_url}}'" <?=($fourth_tab_url == Request()->url()) ? "checked=''" : "" ?>>
<label for="tab4">
    @if (Permissions::STUDENT_PERMISSION_ENUM == auth()->user()->is_permission)

        <?php
        $tab_short_survey_enum_status = \App\Http\Controllers\CommonStudentTabsProcesses::get_specific_tab_status_of_specific_content_of_specific_lesson_plan_of_student($content_id, STUDENT_ASSIGNED_LESSON_PLANS_ENUMS::GET_LONG_SURVEY_TAB_ENUM);
        if ($tab_short_survey_enum_status == true) {
            echo " <i class='glyphicon glyphicon-ok-circle' ></i>";
        } else {
            echo " <i class='fa fa-spinner' ></i>";
        }

        ?>

    @endif

    السؤال البعدي</label>

@php
    $fifth_tab_url = URL::to("/".$url_pattern.'/content/artical/long/'.$content_id."/".STUDENT_ASSIGNED_LESSON_PLANS_ENUMS::GET_STRETCH_ARTICLE_TAB_ENUM);
@endphp

<input id="tab5" type="radio" name="tabs"
       onclick="location.href='{{$fifth_tab_url}}'" <?=($fifth_tab_url == Request()->url()) ? "checked=''" : "" ?>>
<label for="tab5">


    @if (Permissions::STUDENT_PERMISSION_ENUM == auth()->user()->is_permission)

        <?php
        $tab_short_survey_enum_status = \App\Http\Controllers\CommonStudentTabsProcesses::get_specific_tab_status_of_specific_content_of_specific_lesson_plan_of_student($content_id, STUDENT_ASSIGNED_LESSON_PLANS_ENUMS::GET_STRETCH_ARTICLE_TAB_ENUM);
        if ($tab_short_survey_enum_status == true) {
            echo " <i class='glyphicon glyphicon-ok-circle' ></i>";
        } else {
            echo "<i class='fa fa-spinner' ></i>";
        }

        ?>

    @endif

    المقال الموسع</label>

@php
    $six_tab_url = URL::to("/".$url_pattern.'/content/question/'.$content_id.'/'.'1'."/".STUDENT_ASSIGNED_LESSON_PLANS_ENUMS::GET_LONG_QUESTIONS_TAB_ENUM);
@endphp

<input id="tab6" type="radio" name="tabs"
       onclick="location.href='{{$six_tab_url}}'" <?=($six_tab_url == Request()->url()) ? "checked=''" : "" ?>>
<label for="tab6">
    @if (Permissions::STUDENT_PERMISSION_ENUM == auth()->user()->is_permission)

        <?php
        $tab_short_survey_enum_status = \App\Http\Controllers\CommonStudentTabsProcesses::get_specific_tab_status_of_specific_content_of_specific_lesson_plan_of_student($content_id, STUDENT_ASSIGNED_LESSON_PLANS_ENUMS::GET_LONG_QUESTIONS_TAB_ENUM);
        if ($tab_short_survey_enum_status == true) {
            echo " <i class='glyphicon glyphicon-ok-circle' ></i>";
        } else {
            echo " <i class='fa fa-spinner' ></i>";
        }

        ?>

    @endif

    نشاط موسع</label>

@if(Permissions::STUDENT_PERMISSION_ENUM != auth()->user()->is_permission)
    @php
        $issues_tab_url='view/issues/'.$content_id
    @endphp
    <input id="tab7" type="radio" name="tabs"
           onclick="location.href='{{url('view/issues/'.$content_id)}}'" <?=(url('view/issues/' . $content_id) == Request()->url()) ? "checked=''" : "" ?> >
    <label for="tab7">


        ملاحظات </label>
@endif






