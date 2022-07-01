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
                    <h3 class="m-2 align-middle d-inline">
                        <i class="fa-solid fa-envelope-circle-check"></i> Email信箱認證
                    </h3>
                </div>
                <div class="card-body">
                    <form id="Form_verify" method="POST" action="{{-- axios --}}">
                        {{-- 提示訊息 --}}
                        <div class="row mb-3">
                            <div class="col-6 offset-3">
                                <div class="alert alert-warning text-center" role="alert">
                                    <H4><b>註冊成功</b></H4>
                                    請點擊下方「發送認證信」按鈕寄送認證信<br>
                                    完成信箱認證後才能使用平台上的所有功能<br>
                                    認證碼的有效時間為30分鐘
                                </div>
                            </div>
                        </div>
                        {{-- 認證碼 --}}
                        <div class="row mb-3">
                            <div class="col-6 offset-3">
                                <label class="col-form-label" for="email">
                                    <span class="text-danger">*</span>認證碼
                                </label>
                                <input type="text" id="Input_authentication_code"
                                    class="form-control necessary"
                                    name="authenticationCode" value="">
                            </div>
                        </div>
                        {{-- 送出 --}}
                        <div class="row mb-0">
                            <div class="col-6 offset-3 d-flex justify-content-center">
                                <button type="button" class="btn btn-primary my-2"
                                        onclick="sentVerifyEmail()">
                                    發送認證信
                                </button>
                                <button type="button" class="btn btn-success my-2 ms-2"
                                        onclick="submitForm()">
                                    送出
                                </button>
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
    @include('JS_view.Auth.Verify')
@endsection
