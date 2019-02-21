@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">


                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                            @endif

                            {!! $content->feedback !!}

                            </br>
                            </br>

                            <a class="btn btn-success btn-sm" style="display: inline;margin-left:5px ;"
                               href="{{url('content/').'/'.$content->content_id.'/'.'edit'}}"> <span class="fa fa-edit"
                                                                                             aria-hidden="true"></span>
                                &nbsp;تعديل</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
