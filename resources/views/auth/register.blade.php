@include('studentLayout.head')
@php
    use \App\Country;
    use \App\EducationLevel;
        $countriesList = Country::orderBy("id", "desc")->select("id", "name")->get();//get list of countries
        $categories_all = EducationLevel::with('children')->whereNull('parent_id')->get();;//get list of education levels
@endphp
<div class="wrapper">
    <div class="login_inner reg">
        @include("inc.errorMessages")
        <div class="row login_form">
            <form  method="POST" action="{{ route('register') }}" class="col-lg-6 col-md-12 right ">
                @csrf
                <h1>إنشاء حساب جديد</h1>
                <div class="form-holder">
                    <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>
                    <span class="highlight"> </span>
                    <span class="bar"></span>
                    <label for=""> الإسم</label>
                </div>
                <div class="form-holder">
                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>
                    <span class="highlight"> </span>
                    <span class="bar"></span>
                    <label for="">البريد الإلكتروني</label>
                </div>
                <div class="form-holder">
                    <input id="password" type="password" class="form-control" name="password" required>
                    <span class="highlight"> </span>
                    <span class="bar"></span>
                    <label for=""> كلمة المرور</label>
                </div>
                <div class="form-holder">
                    <input  id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                    <span class="highlight"> </span>
                    <span class="bar"></span>
                    <label for=""> تأكيد كلمة المرور</label>
                </div>
                {{----}}
                <div class="form-holder">
                    {{ Form::label('countriesList', 'الدوله ', array('class' => '')) }}
                    <select required  name="countriesList" data-live-search="true" id="countries" class="ui dropdown fluid" data-actions-box="true">
                        <option></option>
                        <option value="58888">we</option>
                            @foreach ($countriesList as  $countryValues)
                                <option
                                    @if(old("countriesList") == $countryValues->id)
                                    {{"selected=''"}}
                                    @endif
                                    value="{{$countryValues->id}}">{{$countryValues->name}}
                                </option>
                            @endforeach
                    </select>
                </div>
                <div class="form-holder" data-validate="Password is required" required>
                    <label for="">الصف</label>
                    <select required class="ui dropdown fluid " name="grade">
                        <option value="1"></option>
                        @foreach($categories_all as $parent)
                            <option value="{{$parent->id}}" >
                                &#10000; {{$parent->name}}  
                            </option>
                        @endforeach
                    </select>
                </div>
                {{----}}
                <button class="login_btn"  type="submit">
                    <span>تسجيل</span>
                </button>
            </form>
            <div class="col-lg-6 col-md-6 left">
                <img src="Studentpublic/images/img2.png" alt="" class="img2">
            </div>
        </div>
    </div>
</div>
@section("customBootstrapJS")
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
@endsection
@section("CustomContentAfterGeneralJquery")
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/css/bootstrap-select.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/js/bootstrap-select.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#countries').selectpicker({});
            $('#educationLevels').selectpicker({});
        });
    </script>
@endsection
