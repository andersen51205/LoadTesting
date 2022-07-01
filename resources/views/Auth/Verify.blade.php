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
                    <h3 class="m-2 align-middle d-inline"><i class="fa-solid fa-users"></i> Email信箱認證</h3>
                </div>
                <div class="card-body">
                    <form id="Form_verify" method="POST" action="{{-- axios --}}">
                        {{-- 錯誤提示 --}}
                        <div class="alert alert-danger text-center d-none" role="alert">
                            {{-- $message --}}
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
