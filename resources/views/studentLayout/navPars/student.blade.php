<?php
$student = \App\Repository\StudentRepository::find('user_id', auth()->id());
?>
@if($student->lessonPlan_id!=null)
    <li class="nav-item">
        <a href="{{url('StudentLessons/'.$student->lessonPlan_id)}}" class="nav-link">الدروس</a>
    </li>
@endif