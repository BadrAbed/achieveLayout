@include('studentLayout.head')
<div class="wrapper">
    <div id="box" class="login_inner">
        <div class="row login_form">
            <form method="POST" action="{{ route('login') }}" class="col-lg-6 col-md-6 right ">
                @csrf
                <h1> تسجيل الدخول لمنصة القراءة</h1>
                <div class="form-holder">
                    <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                           name="email" value="{{ old('email') }}" required autofocus>
                    <span class="highlight"> </span>
                    <span class="bar"></span>
                    <label for="">البريد الإلكتروني</label>
                    @if ($errors->has('email'))
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="form-holder">
                    <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                           name="password" required>
                    <span class="highlight"> </span>
                    <span class="bar"></span>
                    <label for=""> كلمة المرور</label>
                    @if ($errors->has('password'))
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="checkbox">
                    <input class="check_box" type="checkbox" name="remember" id="remember" {{ old( 'remember') ? 'checked' : '' }}>
                    <label class="form-check-label" for="remember">
                        تذكرني
                    </label>
                </div>
                <button class="login_btn" type="submit">
                    <span>تسجيل الدخول</span>
                </button>
                @if (Route::has('password.request'))
                    <a class="forget" href="{{ route('password.request') }}">
                        هل نسيت كلمة السر؟
                    </a>
                @endif
                <div class="reg">
                    <button class="btn" type="button" onclick="location.href='{{ route('register') }}';">
                        <span>إنشاء حساب جديد</span>
                    </button>
                    <button class="btn" type="button" onclick="location.href='{{ url('/loginSchool')}}';">
                        <span>تسجيل دخول مدرسة</span>
                    </button>
                </div>
            </form>
            <div class="col-lg-6 col-md-6 left">
                <img src="{{url('Studentpublic/images/img2.png')}}" alt="" class="img2">
            </div>
        </div>
    </div>
</div>
 