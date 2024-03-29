@extends('layouts.app')

@section('link')
    {{-- <link href="{{ asset('css/dataTable.css') }}" rel="stylesheet"> --}}
@endsection

@section('content')
<div class="container pt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header p-3 align-middle text-center">
                    <h3 class="m-2 align-middle d-inline"><i class="fa-solid fa-users"></i> 登入</h3>
                </div>
                <div class="card-body">
                    <form id="Form_login" method="POST" action="{{-- axios --}}">
                        {{-- 錯誤提示 --}}
                        @error('error')
                            <div class="alert alert-danger text-center" role="alert">
                                {{ $message }}
                            </div>
                        @enderror
                        {{-- 電子郵件 --}}
                        <div class="row mb-3">
                            <div class="col-6 offset-3">
                                <label class="col-form-label" for="email">
                                    <span class="text-danger">*</span>電子郵件
                                </label>
                                <input type="email" id="email" class="form-control necessary @error('email') is-invalid @enderror"
                                    name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                            </div>
                        </div>
                        {{-- 密碼 --}}
                        <div class="row mb-3">
                            <div class="col-6 offset-3">
                                <label class="col-form-label" for="password">
                                    <span class="text-danger">*</span>密碼
                                </label>
                                <input type="password" id="password"
                                    class="form-control necessary @error('password') is-invalid @enderror"
                                    name="password" required autocomplete="current-password">
                            </div>
                        </div>
                        {{-- 記住我 --}}
                        {{-- <div class="row mb-3">
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
                        </div> --}}
                        {{-- 表單操作區 --}}
                        <div class="row mb-0">
                            <div class="col-6 offset-3 d-flex justify-content-end">
                                {{-- <a class="btn btn-outline-success mx-3 my-2" href="{{ route('register') }}">我沒有帳號</a> --}}
                                <button type="button" class="btn btn-primary my-2"
                                        onclick="submitForm()">
                                    登入
                                </button>
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

@section('script')
    @include('JS_view.Auth.Login')
@endsection
