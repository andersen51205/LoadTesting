@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header align-middle text-center">
                    <img class="m-2 align-middle d-inline" width="50px" height="50px"
                        src="{{ asset('/image/login-icon.svg') }}">
                    <h1 class="m-2 align-middle d-inline">登入</h1>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('Login') }}">
                        @csrf
                        {{-- 電子郵件 --}}
                        <div class="row mb-3">
                            <div class="col-6 offset-3">
                                <label class="col-form-label" for="email">電子郵件</label>
                                <input type="email" id="email" class="form-control @error('email') is-invalid @enderror"
                                    name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                {{-- 錯誤提示 --}}
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        {{-- 密碼 --}}
                        <div class="row mb-3">
                            <div class="col-6 offset-3">
                                <label class="col-form-label" for="password">密碼</label>
                                <input type="password" id="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    name="password" required autocomplete="current-password">
                                {{-- 錯誤提示 --}}
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        {{-- 記住我 --}}
                        <div class="row mb-3">
                            <div class="col-3 offset-3">
                                <div class="form-check">
                                    <input type="checkbox" id="remember" class="form-check-input"
                                        name="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="remember">記住我</label>
                                </div>
                            </div>
                            <div class="col-3 d-flex justify-content-end">
                                @if (Route::has('password.request'))
                                    <a class="" href="{{ route('password.request') }}">忘記密碼</a>
                                @endif
                            </div>
                        </div>
                        {{-- 表單操作區 --}}
                        <div class="row mb-0">
                            <div class="col-6 offset-3 d-flex justify-content-end">
                                {{-- <a class="btn btn-outline-success mx-3 my-2" href="{{ route('register') }}">我沒有帳號</a> --}}
                                <button type="submit" class="btn btn-primary my-2">登入</button>
                            </div>
                        </div>
                        <div class="row mb-0">
                            <div class="col-6 offset-3">
                                <hr class="w-100">
                                <div class="d-flex justify-content-end">
                                    <p>沒有帳號？<a href="{{ route('register') }}">我要註冊</a></p>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
