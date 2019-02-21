@include('studentLayout.head')
@include('studentLayout.header')
<div id="app">
    {{--  <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
        <div class="container">

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav mr-auto">

                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto">
                    <!-- Authentication Links -->
                    @guest
                    @else
                        @if(auth()->user()->type==\App\Helper\UsersType::Teacher)
                            @include('layouts.navPars.teacher')
                        @elseif(auth()->user()->type==\App\Helper\UsersType::School)
                            @include('layouts.navPars.school')
                        @elseif(auth()->user()->type==\App\Helper\UsersType::Student)
                            @include('layouts.navPars.student')
                        @endif
                    @endguest
                </ul>
            </div>
        </div>
    </nav>  --}}
    {{-- =====================BreadCrumbs================= --}}
    {{-- =====================#BreadCrumbs================= --}}
    
    <main class="">
        @yield('content')
        @yield('CustomContentAfterGeneralJquery')
    </main>
</div>
</body>
</html>
@include('studentLayout.footer')
