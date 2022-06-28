@extends('layouts.app')

@section('link')
@endsection

@section('content')
<div class="container pt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header p-3 align-middle text-center">
                    <h3 class="m-2 align-middle d-inline"><i class="fa-solid fa-user-pen"></i> 帳號資訊</h3>
                </div>
                <div class="card-body">
                    <form id="Form_user_information" method="POST" action="{{-- axios --}}">
                        {{-- 使用者名稱 --}}
                        <div class="row mb-3">
                            <div class="col-6 offset-3">
                                <label class="col-form-label" for="name">
                                    <span class="text-danger">*</span>使用者名稱
                                </label>
                                <input type="text" id="Input_name" class="form-control necessary"
                                    name="name" value="{{ $data['name'] }}">
                            </div>
                        </div>
                        {{-- 電子郵件 --}}
                        <div class="row mb-3">
                            <div class="col-6 offset-3">
                                <label class="col-form-label" for="email">
                                    <span class="text-danger">*</span>電子郵件
                                </label>
                                <input type="email" id="Input_email" class="form-control necessary"
                                    name="email" value="{{ $data['email'] }}" disabled>
                            </div>
                        </div>
                        {{-- 舊密碼 --}}
                        <div class="row mb-3">
                            <div class="col-6 offset-3">
                                <label for="Input_current_password" class="col-form-label">舊密碼</label>
                                <input type="password" id="Input_current_password" class="form-control"
                                    name="currentPassword">
                                <span class="invalid-feedback" role="alert">
                                    <strong>若只需變更使用者名稱，請將密碼欄位留空。</strong>
                                </span>
                            </div>
                        </div>
                        {{-- 新密碼 --}}
                        <div class="row mb-3">
                            <div class="col-6 offset-3">
                                <label for="Input_password" class="col-form-label">新密碼</label>
                                <input type="password" id="Input_password" class="form-control"
                                    name="password">
                            </div>
                        </div>
                        {{-- 密碼確認 --}}
                        <div class="row mb-3">
                            <div class="col-6 offset-3">
                                <label for="Input_confirm_password" class="col-form-label">確認新密碼</label>
                                <input type="password" id="Input_confirm_password" class="form-control"
                                    name="confirmPassword">
                            </div>
                        </div>
                        {{-- 表單操作區 --}}
                        <div class="row mb-0">
                            <div class="col-6 offset-3 d-flex justify-content-center">
                                <button type="button" class="btn btn-primary" onclick="submitForm()">送出</button>
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
    @include('JS_view.Manager.UserInformation')
@endsection