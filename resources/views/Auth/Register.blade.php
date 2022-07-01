@extends('layouts.app')

@section('content')
<div class="container pt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header p-3 align-middle text-center">
                    <h3 class="m-2 align-middle d-inline"><i class="fa-solid fa-user-plus"></i> 註冊會員</h3>
                </div>
                <div class="card-body">
                    <form id="Form_register" method="POST" action="{{-- axios --}}">
                        {{-- 使用者名稱 --}}
                        <div class="row mb-3">
                            <div class="col-6 offset-3">
                                <label class="col-form-label" for="name">
                                    <span class="text-danger">*</span>使用者名稱
                                </label>
                                <input type="text" id="name" class="form-control necessary"
                                    name="name" value="">
                                {{-- 錯誤提示 --}}
                                {{-- @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror --}}
                            </div>
                        </div>
                        {{-- 電子郵件 --}}
                        <div class="row mb-3">
                            <div class="col-6 offset-3">
                                <label class="col-form-label" for="email">
                                    <span class="text-danger">*</span>電子郵件
                                </label>
                                <input type="email" id="email" class="form-control necessary"
                                    name="email" value="">
                            </div>
                        </div>
                        {{-- 密碼 --}}
                        <div class="row mb-3">
                            <div class="col-6 offset-3">
                                <label for="Input_password" class="col-form-label">密碼</label>
                                <input type="password" id="Input_password"
                                    class="form-control necessary" name="password">
                            </div>
                        </div>
                        {{-- 密碼確認 --}}
                        <div class="row mb-3">
                            <div class="col-6 offset-3">
                                <label for="Input_password_confirm" class="col-form-label">密碼確認</label>
                                <input type="password" id="Input_password_confirm" class="form-control necessary"
                                    name="password_confirmation">
                            </div>
                        </div>
                        {{-- 表單操作區 --}}
                        <div class="row mb-0">
                            <div class="col-6 offset-3 d-flex justify-content-end">
                                {{-- <a class="mx-4 my-2" href="{{ route('Login_View') }}">改用帳號登入</a> --}}
                                <button type="button" class="btn btn-primary"
                                    onclick="submitForm()">我要註冊</button>
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

@section('script')
    @include('JS_view.Auth.Register')
@endsection
