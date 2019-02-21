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
                        <br>
                        <br>
                        <form action="{{url('Reviewer/refused').'/'.$id}}" method="post">
                            {{csrf_field()}}
                            <div class="form-group">
                                <label for="exampleInputEmail1">الملاحظات</label>
                                <input name="image" type="file" id="upload" class="hidden" onchange="">

                                {{ Form::textarea('feedback', '', array('class' => 'form-control editor')) }}


                            </div>
                            <button type="submit" class="btn btn-success"><i class="fa fa-check"></i> حفظ التعديل
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
