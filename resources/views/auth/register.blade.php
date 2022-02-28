@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header align-middle text-center">
                    <img class="m-2 align-middle d-inline" width="50px" height="50px"
                        src="{{ asset('/image/register-icon.svg') }}">
                    <h1 class="m-2 align-middle d-inline">註冊會員</h1>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        {{-- 使用者名稱 --}}
                        <div class="row mb-3">
                            <div class="col-6 offset-3">
                                <label class="col-form-label" for="name">使用者名稱</label>
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                                    name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                                {{-- 錯誤提示 --}}
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        {{-- 電子郵件 --}}
                        <div class="row mb-3">
                            <div class="col-6 offset-3">
                                <label class="col-form-label" for="email">電子郵件</label>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                    name="email" value="{{ old('email') }}" required autocomplete="email">
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
                                <label for="password" class="col-form-label">密碼</label>
                                <input id="password" type="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    name="password" required autocomplete="new-password">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        {{-- 密碼確認 --}}
                        <div class="row mb-3">
                            <div class="col-6 offset-3">
                                <label for="password-confirm" class="col-form-label">密碼確認</label>
                                <input id="password-confirm" type="password" class="form-control"
                                    name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>
                        {{-- 表單操作區 --}}
                        <div class="row mb-0">
                            <div class="col-6 offset-3 d-flex justify-content-end">
                                {{-- <a class="mx-4 my-2" href="{{ route('Login_View') }}">改用帳號登入</a> --}}
                                <button type="submit" class="btn btn-primary">我要註冊</button>
                            </div>
                        </div>
                        {{-- 其他選項 --}}
                        <div class="row mb-0">
                            <div class="col-6 offset-3">
                                <hr class="w-100">
                                <div class="d-flex justify-content-end">
                                    <p>已有帳號？<a href="{{ route('Login_View') }}">改用帳號登入</a></p>
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
