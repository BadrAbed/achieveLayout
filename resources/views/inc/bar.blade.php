@php
    use \App\NormalArtical;
    use \App\Content;
    $normalArticleId = @Content::find($content_id)->articalnormal->id;
    $stretchArticleId = @Content::find($content_id)->articalstrach->id;

@endphp
<style type="text/css">
    table thead tr th {
        background-color: #05932a !important;
        /* color: #fff; */
        border-left: 0.5px solid #fff;
        text-align: center;
        padding: 0 !important;
    }

    table thead tr th.active {
        background-color: #0FC23E !important;
        cursor: pointer;
    }

    table thead tr th:hover {
        background-color: #0FC23E !important;
        cursor: pointer;
    }

    .thead-title a {
        color: #fff !important;
        font-size: 12px;
        text-decoration: none !important;
        padding: 0px
    }
</style>
<br>
<div class="panel panel-default" style="padding: 20px;border:none !important;">
    <table class="lessons" name="tablecontent" id="tablecontent">

        <thead>
        @if (auth()->user()->is_permission != \App\Http\OwnClasses\TYPE_OF_USERS_ENUMS::QUESTIONEDITOR && auth()->user()->is_permission != \App\Http\OwnClasses\TYPE_OF_USERS_ENUMS::QUESTIONREVIEWER)

        @php $firstUrl =URL::to('content/'.$content_id.'/edit');  @endphp
        <tr>
            <th onclick="location.href='<?=$firstUrl?>';" style="padding: 0 !important;" 
                class="<?= (request()->url() == $firstUrl) ? 'active' : '' ?>">
                <!--<i class="far fa-bookmark"></i>-->
                <span class="thead-title"><i class="fa fa-edit" style="color: #fff"></i> <br><a
                            href="{{$firstUrl}}">تعديل المحتوى  </a></span>
            </th>
            @php $secondUrl =URL::to('normal-artical/'.$content_id.'/edit');  @endphp
            <th onclick="location.href='<?=$secondUrl?>';" style="padding: 0 !important;"
                class="<?= (request()->url() == $secondUrl) ? 'active' : '' ?>">
                <!--<i class="far fa-calendar-alt"></i>-->
                <span class="thead-title"><i class="fa fa-edit" style="color: #fff"></i> <br><a
                            href="{{$secondUrl}}">تعديل المقال المختصر  </a></span>
            </th>

            @php $thirdUrl =URL::to('stretch-artical/'.$content_id.'/edit');  @endphp
            <th onclick="location.href='<?=$thirdUrl?>';" style="padding: 0 !important;"
                class="<?= (request()->url() == $thirdUrl) ? 'active' : '' ?>">
                <!--<i class="fas fa-hashtag"></i>-->
                <span class="thead-title"><i class="fa fa-edit" style="color: #fff"></i> <br> <a
                            href="{{$thirdUrl}}"> تعديل المقال الموسع  </a></span>
            </th>

            @php $fourthUrl =URL::to('show_voc_content/'.$content_id);  @endphp
            <th onclick="location.href='<?=$fourthUrl?>';" style="padding: 0 !important;"
                class="<?= (request()->url() == $fourthUrl) ? 'active' : '' ?>">
                <!--<i class="fas fa-book"></i>-->
                <span class="thead-title"><i class="fa fa-edit" style="color: #fff"></i> <br><a
                            href="{{$fourthUrl}}">تعديل معانى الكلمات </a> </span>
            </th>
            @php $fifthUrl =URL::to('links/'.$content_id);  @endphp
            <th onclick="location.href='<?=$fifthUrl?>';" style="padding: 0 !important;"
                class="<?= (request()->url() == $fifthUrl) ? 'active' : '' ?>">
                <!--<i class="far fa-bookmark"></i>-->
                <span class="thead-title"><i class="fa fa-edit" style="color: #fff"></i> <br><a
                            href="{{$fifthUrl}}">تعديل الروابط  </a></span>
            </th>

        @php $SixtUrl =URL::to('allQuestions/'.$content_id);  @endphp
        <tr>
            <th onclick="location.href='<?=$SixtUrl?>';" style="padding: 0 !important;"
                class="<?= (request()->url() == $SixtUrl) ? 'active' : '' ?>">
                <!--<i class="far fa-bookmark"></i>-->
                <span class="thead-title"><i class="fa fa-edit" style="color: #fff"></i> <br><a
                            href="{{$SixtUrl}}">تعديل الاسئلة  </a></span>
            </th>
        </tr>
        @endif
        </thead>
    </table>
</div>