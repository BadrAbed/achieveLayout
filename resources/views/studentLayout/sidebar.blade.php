<div class="row links">
    <div class="col-md-2 img">
        <img src="{{asset('Studentpublic/images/link.png')}}" alt="">
        <span>روابط إثرائية</span>
    </div>
    <div class="col-md-10 link">
        @if(count($content->links)>0)
            @foreach($content->links as $links)
            <a target="_blank" href="{{$links->href}}"> {{$links->link}}</a>
            @endforeach
        @endif


    </div>
</div>
</div>
{{-- ////////////////////// Bottom --- Left ////////////////////////////// --}}
<div class="col-md-4 left">
    <div class="vocabulary_col">
        <div class="vocabulary_title">
            <h2>مترادفات</h2>
        </div>
        <div class="vocabulary">
            <table class="vocabulary_table">
                <tbody>
                @foreach(Session::get('vocab') as $vocab)
                    <tr>
                        <td class="txt col-md-3">{{$vocab->word}}</td>
                        <td  class="mean col-md-9">{{$vocab->meaning}}</td>
                    </tr>
                @endforeach


                </tbody>
            </table>
        </div>
    </div>
</div>