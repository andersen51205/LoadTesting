<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    {{-- CSRF Token --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- Web Title --}}
    <title>負載測試平台</title>
    {{-- Scripts --}}
    <script src="{{ asset('js/app.js') }}" defer></script>
    {{-- Fonts --}}
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    {{-- Styles --}}
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">{{-- template CSS --}}
    <link href="{{ asset('css/table.css') }}" rel="stylesheet">{{-- table CSS --}}
    <link href="{{ asset('css/customize.css') }}" rel="stylesheet">{{-- customize CSS --}}
    {{-- favicon.ico --}}
    <link rel="icon" href="{{ asset('favicon.ico') }}"/>

    @yield('link')
</head>
<body>
    <div id="app">
        {{-- navbar --}}
        <nav class="navbar navbar-expand-md navbar-dark bg-secondary shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">負載測試平台</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">
                        @auth
                            @if (Auth::user()->permission === 1)
                                <li class="nav-item">
                                    <a class="nav-link active" href="{{ route('User_View') }}">首頁</a>
                                </li>
                                <li class="nav-item dropdown">
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle active" href="#" role="button"
                                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        基本資料
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item" href="{{ route('User_Infomation_View') }}">
                                            帳號資訊
                                        </a>
                                    </div>
                                </li>
                                <li class="nav-item dropdown">
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle active" href="#" role="button"
                                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        專案
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item" href="{{ route('User_ProjectList_View') }}">
                                            專案管理
                                        </a>
                                        <a class="dropdown-item" href="{{ route('User_ProjectCreate_View') }}">
                                            新增專案
                                        </a>
                                    </div>
                                </li>
                                <li class="nav-item dropdown">
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle active" href="#" role="button"
                                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        測試腳本
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item" href="{{ route('User_TestScriptTutorial_View') }}">
                                            如何產生腳本
                                        </a>
                                        <a class="dropdown-item" href="{{ route('User_TestScriptList_View') }}">
                                            測試腳本管理
                                        </a>
                                        <a class="dropdown-item" href="{{ route('User_TestScriptCreate_View') }}">
                                            新增測試腳本
                                        </a>
                                    </div>
                                </li>
                            @elseif (Auth::user()->permission === 2)
                                <li class="nav-item">
                                    <a class="nav-link active" href="{{ route('Manager_View') }}">首頁</a>
                                </li>
                                <li class="nav-item dropdown">
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle active" href="#" role="button"
                                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        基本資料
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item" href="{{ route('Manager_Infomation_View') }}">
                                            帳號資訊
                                        </a>
                                    </div>
                                </li>
                                <li class="nav-item dropdown">
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle active" href="#" role="button"
                                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        後臺管理
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item" href="{{ route('Manager_UserList_View') }}">
                                            使用者管理
                                        </a>
                                    </div>
                                </li>
                                <li class="nav-item dropdown">
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle active" href="#" role="button"
                                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        專案
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item" href="{{ route('Manager_ProjectList_View') }}">
                                            專案管理
                                        </a>
                                    </div>
                                </li>
                                <li class="nav-item dropdown">
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle active" href="#" role="button"
                                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        測試腳本
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item" href="{{ route('Manager_TestScriptList_View') }}">
                                            測試腳本管理
                                        </a>
                                    </div>
                                </li>
                            @elseif (Auth::user()->permission === 3)
                                <li class="nav-item">
                                    <a class="nav-link active" href="{{ route('Admin_View') }}">首頁</a>
                                </li>
                                <li class="nav-item dropdown">
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle active" href="#" role="button"
                                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        基本資料
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item" href="{{ route('Admin_Infomation_View') }}">
                                            帳號資訊
                                        </a>
                                    </div>
                                </li>
                                <li class="nav-item dropdown">
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle active" href="#" role="button"
                                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        後臺管理
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item" href="{{ route('Admin_UserManagement_View') }}">
                                            人員管理
                                        </a>
                                    </div>
                                </li>
                            @endif
                        @endauth
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('Login_View'))
                                <li class="nav-item">
                                    <a class="nav-link active" href="{{ route('Login_View') }}">登入</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link active" href="{{ route('register') }}">註冊</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('Logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        登出
                                    </a>

                                    <form id="logout-form" action="{{ route('Logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
        {{-- 頁面內容 --}}
        <main class="nav-padding">
            @yield('content')
        </main>
    </div>
    {{-- 公用元件 --}}
    <script type="text/javascript" src="{{asset(mix('/js/utility/SwalUtility.js'))}}"></script>
    <script type="text/javascript" src="{{asset(mix('/js/utility/FrontendValidation.js'))}}"></script>
</body>
@yield('script')
</html>
