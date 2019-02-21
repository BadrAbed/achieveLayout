@if(count($errors) > 0)
    <!-- <div class="panel panel-info">
        <div class="panel-heading">Status</div>
        <div class="panel-body"> -->
            <ul class="list-group">

                @foreach($errors->all() as $error)
                            <div class="alert alert-danger text-center" style="background-color:#e35757;border: none;font-size: 12px;">
                    <li style="">{{$error}}</li>
                            </div>
                @endforeach

            </ul>
<!--         </div>
    </div> -->
@endif