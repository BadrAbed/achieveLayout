@extends('layouts.app')


@php

    use \App\Country;
    use \App\EducationLevel;

        $countriesList = Country::orderBy("id", "desc")->select("id", "name")->get();//get list of countries
        $categories_all = EducationLevel::with('children')->whereNull('parent_id')->get();;//get list of education levels

@endphp

@section('custom-content')

    <style>
        body {
            background-image: url("{{url("images/bg2.jpg")}}");
            
        }
        footer.footer{
            color: #dddddd !important;

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
                            @include("inc.errorMessages")
                            <form method="POST" action="{{ route('register') }}"
                                  class="login100-form validate-form flex-sb flex-w">
                                @csrf
                                <center><img src="images/pp_login.png" class="img-rounded"></center>
                                <br>
                                <span class="login100-form-title p-b-51">
                           إنشاء حساب
                           </span>
                                <br>
                                <hr>
                                <br> <br>
                                <div class="wrap-input100 validate-input m-b-16" data-validate="Username is required">
                                    <input id="name" type="text" name="name" value="{{ old('name') }}" class="input100"
                                           placeholder="أسم المستخدم" required autofocus>
                                    {{--@if ($errors->has('name'))--}}
                                    {{--<div class="alert alert-danger">{{ $errors->first('name') }} </div>--}}
                                    {{--@endif--}}
                                    <span class="focus-input100"></span>
                                </div>
                                <div class="wrap-input100 validate-input m-b-16" data-validate="Username is required">
                                    <input id="email" type="email" class="input100" placeholder="البريد الإلكتروني"
                                           name="email" value="{{ old('email') }}" required>
                                    {{--@if ($errors->has('email'))--}}
                                    {{--<div class="alert alert-danger">{{ $errors->first('email') }} </div>--}}
                                    {{--@endif--}}
                                    <span class="focus-input100"></span>
                                </div>
                                <div class="wrap-input100 validate-input m-b-16" data-validate="Password is required"
                                     required>
                                    <input class="input100" id="password" type="password" name="password" required
                                           placeholder="كلمة المرور">
                                    {{--@if ($errors->has('password'))--}}
                                    {{--<div class="alert alert-danger">{{ $errors->first('password') }} </div>--}}
                                    {{--@endif--}}
                                    <span class="focus-input100"></span>
                                </div>


                                <div class="wrap-input100 validate-input m-b-16" data-validate="Password is required"
                                     required>
                                    <input class="input100" id="password-confirm" type="password"
                                           name="password_confirmation" required placeholder="كلمة المرور">

                                    <span class="focus-input100"></span>
                                </div>
                                <br>

                                <div class="row form-group">

                                    <div class="col-md-2">
                                        {{ Form::label('countriesList', 'الدوله ', array('class' => 'col-form-label')) }}

                                    </div>
                                    <div style="z-index: 100" class="col-md-4">

                                        <select required style="z-index: 100" name="countriesList"
                                                data-live-search="true"
                                                id="countries"
                                                class="ui dropdown fluid" data-actions-box="true">

                                            <option>------------</option>
                                            <option value="58888">we</option>

                                            @foreach ($countriesList as  $countryValues)

                                                <option

                                                        @if(old("countriesList") == $countryValues->id)
                                                        {{"selected=''"}}
                                                        @endif

                                                        value="{{$countryValues->id}}">{{$countryValues->name}}</option>

                                            @endforeach
                                        </select>

                                    </div>

                                </div>

                                <div class="wrap-input100 validate-input m-b-16" data-validate="Password is required"
                                     required>
                                    <label for="">الصف</label>
                                    <select required class="form-control " name="grade">
                                        <option value="1">-----</option>
                                        @foreach($categories_all as $parent)
        
                                            <option value="{{$parent->id}}" >
                                                &#10000; {{$parent->name}}  </option>


                                        @endforeach
                                    </select>
                                </div>


                                <br>
                                <div class="flex-sb-m w-full p-t-3 p-b-24">

                                    <br>
                                    <div>
                                        <a href="#" class="txt1" style="color: black">
                                            نسيت كلمة المرور ؟
                                        </a>
                                    </div>
                                    <br>
                                </div>
                                <div class="container-login100-form-btn m-t-17">
                                    <button class="login100-form-btn">
                                        إنشاء حساب
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        @endsection


        @section("customBootstrapJS")

            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
                    integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
                    crossorigin="anonymous"></script>
        @endsection


        @section("CustomContentAfterGeneralJquery")

            {{-- include styles and javascript of bootstrap multiple select--}}


            <link rel="stylesheet"
                  href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/css/bootstrap-select.min.css">

            <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/js/bootstrap-select.min.js"></script>


            <script>
                $(document).ready(function () {
                    $('#countries').selectpicker({});
                    $('#educationLevels').selectpicker({});
                });
            </script>

@endsection