@extends('layouts.app')

@section('link')
    {{-- <link href="{{ asset('css/dataTable.css') }}" rel="stylesheet"> --}}
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
                    <div class="container-fluid px-4">
                        <div class="row">
                            <div class="col-10 offset-1">
                                <h3 class="my-4">使用者管理</h3>
                            </div>
                        </div>
                        {{-- <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol> --}}
                        <div class="row">
                            <div class="col-10 offset-1">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr class="text-center">
                                            <th style="width:20%">使用者名稱</th>
                                            <th style="width:20%">電子郵件</th>
                                            {{-- <th style="width:10%">註冊日期</th> --}}
                                            <th style="width:8%">專案</th>
                                            <th style="width:8%">腳本</th>
                                            <th style="width:20%">狀態</th>
                                            <th style="width:10%">操作</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(isset($data['userList']))
                                            @if(count($data['userList']) === 0)
                                                <tr>
                                                    <td class="p-3 text-center" colspan="3">無使用者資料</td>
                                                </tr>
                                            @else
                                                @foreach ($data['userList'] as $user)
                                                    <tr>
                                                        <td class="p-3">{{ $user['name'] }}</td>
                                                        <td class="p-3">{{ $user['email'] }}</td>
                                                        {{-- <td class="p-3">{{ $user['created_at'] }}</td> --}}
                                                        <td class="p-3 text-center">{{ count($user['project']) }}</td>
                                                        <td class="p-3 text-center">{{ count($user['testScript']) }}</td>
                                                        <td class="p-3">
                                                            @if($user['expired_at'])
                                                                <i class="fa-solid fa-xmark"></i> {{ "停用(".$user['expired_at'].")" }}
                                                            @elseif(!$user['email_verified_at'])
                                                                <i class="fa-solid fa-exclamation me-1"></i> {{ "尚未完成電子郵件認證" }}
                                                            @else
                                                                <i class="fa-solid fa-check"></i> {{ "正常" }}
                                                            @endif
                                                        </td>
                                                        <td class="text-center">
                                                            {{-- <a class="btn btn-outline-secondary m-1"
                                                                href="{{ route('User_Project_View', $project['id']) }}">
                                                                <i class="fa-solid fa-arrow-right-to-bracket"></i>
                                                            </a> --}}
                                                            {{-- <a class="btn btn-outline-secondary m-1"
                                                                href="{{ route('User_Project_Edit', $project['id']) }}">
                                                                <i class="fa-solid fa-pen-to-square"></i>
                                                            </a> --}}
                                                            @if($user['expired_at'])
                                                                {{-- <button class="btn btn-outline-success m-1 tooltip-label"
                                                                        data-userId="{{ $user['id'] }}"
                                                                        onclick="enableUser(this)"
                                                                        data-tippy-content="啟用">
                                                                    <i class="fa-solid fa-user-check"></i>
                                                                </button> --}}
                                                            @else
                                                                <button class="btn btn-outline-danger m-1 tooltip-label"
                                                                        data-userId="{{ $user['id'] }}"
                                                                        onclick="disableUser(this)"
                                                                        data-tippy-content="停用">
                                                                    <i class="fa-solid fa-user-xmark"></i>
                                                                </button>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        @endif
                                    </tbody>
                                </table>
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
    @include('JS_view.Manager.UserManagement')
@endsection
