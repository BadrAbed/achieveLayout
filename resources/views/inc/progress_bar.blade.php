<br>
@php
    $condition= auth()->user()->is_permission ==App\Http\OwnClasses\TYPE_OF_USERS_ENUMS::LEADER || auth()->user()->is_permission ==App\Http\OwnClasses\TYPE_OF_USERS_ENUMS::SUPER_ADMIN;

@endphp
<section class="example text-center">

    <div class="progress2">
        <div class="circle2 active" id="1">
            <span class="label">1</span>
            <span class="title">المحتوى </span>
        </div>
        <span class="bar2 done"></span>
        <div class="circle2 " id="2">
            <span class="label">2</span>
            <span class="title"> مقال1مختصر </span>
        </div>
        @if($condition)
            @php
                $activity1=3;
                $activity2=4;
            @endphp
            <span class="bar2"></span>
            <div class="circle2" id="3">
                <span class="label">3</span>
                <span class="title"> نشاط1</span>
            </div>
        @endif

        <span class="bar2 half"></span>
        <div class="circle2 " id="4">
            <span class="label">{{(isset($activity1)?$activity1+1:3)}}</span>
            <span class="title"> مقال2موسع </span>
        </div>

        @if($condition)
            <span class="bar2"></span>
            <div class="circle2" id="5">
                <span class="label">5</span>
                <span class="title"> نشاط2</span>
            </div>
        @endif
        <span class="bar2"></span>
        <div class="circle2" id="6">
            <span class="label">{{(isset($activity2)?$activity2+1:4)}}</span>
            <span class="title">الكلمات </span>
        </div>
    </div>


</section>
