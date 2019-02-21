@extends('layouts.app')

@section('custom-content')


    <style>
        body {
            background-image: url("{{url("images/school-login-bg.jpg")}}");
            /*background-color: #cccccc;*/
            overflow-y:hidden;


        }
        footer.footer{
            color: #dddddd !important;
            display: none;

        }
        footer.footer a {
            color: #dddddd !important;

        }
    </style>





    <div class="container">
        <div class="container">
            <!-- will be used to show any messages -->
            <div class="row">
                <!--login form content-->
                <div class="limiter">
                    <div class="container-login100">
                        <div class="wrap-login100 p-t-50 p-b-90">
                            <form method="POST" action="{{url('loginSchool')}}" class="login100-form validate-form flex-sb flex-w">
                                {{csrf_field()}}

                                <center><img src="images/ppcirc.png" class="img-rounded"> </center>
                                <br>
                                <span class="login100-form-title p-b-51">
                           تسجيل الدخول
                           </span>
                                <br>
                                <hr>
                                <br> <br>
                                <div class="wrap-input100 validate-input m-b-16" data-validate = "Username is required">
                                    <input id="email" type="email" class="input100 {{ $errors->has('email') ? ' is-invalid' : '' }}"  name="email" placeholder="البريد الالكتروني" value="{{ old('email') }}" required autofocus>
                                    @if ($errors->has('email'))
                                        <div class="alert alert-danger">{{ $errors->first('email') }} </div>
                                    @endif


                                    <span class="focus-input100"></span>
                                </div>
                                <div class="wrap-input100 validate-input m-b-16" data-validate = "Password is required" required>
                                    <input class="input100{{ $errors->has('password') ? ' is-invalid' : '' }}" id="password" type="password"  name="password" required placeholder="كلمة المرور">
                                    @if ($errors->has('password'))
                                        <div class="alert alert-danger">{{ $errors->first('password') }} </div>
                                    @endif

                                    <span class="focus-input100"></span>
                                </div>
                                <br>
                                <div class="flex-sb-m w-full p-t-3 p-b-24">
                                    <div class="contact100-form-checkbox">
                                        <input class="input-checkbox100" id="ckb1" type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                                        <label class="label-checkbox100" for="ckb1">
                                            تذكرني
                                        </label>
                                        <div>
                                            <a href="{{ route('password.request')}}" class="txt1" style="color: black">
                                                نسيت كلمة المرور ؟
                                            </a>
                                        </div>
                                        <br>
                                        <label class="label" for="ckb1">
                                            <a href="{{ route('login')}}" class="badge badge-info" style="background-color: #21ba45;border-radius: 55px"> <i class="fa fa-reply" style="font-size: 20px;color:#fff;"></i> </a>
                                        </label>
                                    </div>
                                    <br>

                                </div>
                                <div class="container-login100-form-btn m-t-17">
                                    <button type="submit" class="login100-form-btn">
                                        تسجيل الدخول
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>







@endsection







{{--
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Login') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="email" class="col-sm-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6 offset-md-4">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>

                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    {{ __('Forgot Your Password?') }}
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
--}}
