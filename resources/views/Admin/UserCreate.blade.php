@extends('layouts.app')

@section('link')
    <link href="{{ asset('css/dataTable.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="sb-nav-fixed">
        <div id="layoutSidenav">
            {{-- 側邊欄 --}}
            {{-- @include('layouts.User.ProjectSidenav') --}}
            {{-- 內容 --}}
            {{-- <div id="layoutSidenav_content"> --}}
            <div id="layoutSidenav_content" class="ps-0">
                <main>
                    <div class="container pt-4">
                        <div class="row justify-content-center">
                            <div class="col-md-8">
                                <div class="card">
                                    <div class="card-header p-3 align-middle text-center">
                                        <h3 class="m-2 align-middle d-inline"><i class="fa-solid fa-user-plus"></i> 新增管理員</h3>
                                    </div>
                                    <div class="card-body">
                                        <form id="Form_user_information" method="POST" action="{{-- axios --}}">
                                            {{-- 管理員名稱 --}}
                                            <div class="row mb-3">
                                                <div class="col-6 offset-3">
                                                    <label class="col-form-label" for="Input_name">
                                                        <span class="text-danger">*</span>管理員名稱
                                                    </label>
                                                    <input type="text" id="Input_name" class="form-control necessary"
                                                        name="managerName" value="">
                                                </div>
                                            </div>
                                            {{-- 電子郵件 --}}
                                            <div class="row mb-3">
                                                <div class="col-6 offset-3">
                                                    <label class="col-form-label" for="Input_email">
                                                        <span class="text-danger">*</span>電子郵件
                                                    </label>
                                                    <input type="email" id="Input_email" class="form-control necessary"
                                                        name="managerEmail" value="">
                                                </div>
                                            </div>
                                            {{-- 密碼 --}}
                                            <div class="row mb-3">
                                                <div class="col-6 offset-3">
                                                    <label class="col-form-label" for="Input_password">
                                                        <span class="text-danger">*</span>密碼
                                                    </label>
                                                    <input type="password" id="Input_password" class="form-control necessary"
                                                        name="managerPassword" value="">
                                                </div>
                                            </div>
                                            {{-- 密碼確認 --}}
                                            <div class="row mb-3">
                                                <div class="col-6 offset-3">
                                                    <label class="col-form-label" for="Input_password_confirm">
                                                        <span class="text-danger">*</span>密碼確認
                                                    </label>
                                                    <input type="password" id="Input_password_confirm" class="form-control necessary"
                                                        name="managerPasswordConfirm" value="">
                                                </div>
                                            </div>
                                            {{-- 表單操作區 --}}
                                            <div class="row mb-0">
                                                <div class="col-6 offset-3 d-flex justify-content-center">
                                                    <button type="button" class="btn btn-primary"
                                                            data-submit-type="create" onclick="submitForm(this)">
                                                        送出
                                                    </button>
                                                    <a class="btn btn-secondary ms-2"
                                                            href="{{ route('Admin_UserManagement_View') }}">
                                                        返回
                                                    </a>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Your Website 2021</div>
                            <div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
    </div>
{{--
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="assets/demo/chart-area-demo.js"></script>
    <script src="assets/demo/chart-bar-demo.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
    <script src="js/datatables-simple-demo.js"></script>
--}}
@endsection

@section('script')
    @include('JS_view.Admin.UserCreate')
@endsection
