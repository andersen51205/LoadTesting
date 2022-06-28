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
                                <h3 class="my-4">專案管理</h3>
                            </div>
                        </div>
                        {{-- <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol> --}}
                        <div class="row">
                            <div class="col-10 offset-1">
                                {{-- <div class="my-2 d-flex justify-content-end">
                                    <a class="btn btn-outline-secondary" href="{{ route('User_ProjectCreate_View') }}">
                                        <i class="fa-solid fa-plus"></i> 新增專案
                                    </a>
                                </div> --}}
                                <table class="table table-bordered">
                                    <thead>
                                        <tr class="text-center">
                                            <th style="width:15%">擁有者</th>
                                            <th style="width:20%">專案名稱</th>
                                            <th style="width:40%">描述</th>
                                            <th style="width:10%">腳本數</th>
                                            <th style="width:15%">操作</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(isset($data['projectList']))
                                            @if(count($data['projectList']) === 0)
                                                <tr>
                                                    <td class="p-3 text-center" colspan="3">查無專案資料</td>
                                                </tr>
                                            @else
                                                @foreach ($data['projectList'] as $project)
                                                    <tr>
                                                        <td class="p-3">{{ $project['user']['name'] }}</td>
                                                        <td class="p-3">{{ $project['name'] }}</td>
                                                        <td class="p-3">{{ $project['description'] }}</td>
                                                        <td class="p-3">{{ count($project['testScript']) }}</td>
                                                        <td class="text-center">
                                                            <a class="btn btn-outline-primary m-1 tooltip-label"
                                                                href="{{ route('Manager_Project_View', $project['id']) }}"
                                                                data-tippy-content="查看">
                                                                <i class="fa-solid fa-arrow-right-to-bracket"></i>
                                                            </a>
                                                            <a class="btn btn-outline-success m-1 tooltip-label"
                                                                href="{{ route('Manager_Project_Edit', $project['id']) }}"
                                                                data-tippy-content="編輯">
                                                                <i class="fa-solid fa-pen-to-square"></i>
                                                            </a>
                                                            <button class="btn btn-outline-danger m-1 tooltip-label"
                                                                data-projectId="{{ $project['id'] }}"
                                                                onclick="deleteProject(this)"
                                                                data-tippy-content="刪除">
                                                                <i class="fa-solid fa-trash-can"></i>
                                                            </button>
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
    @include('JS_view.Manager.ProjectManagement')
@endsection
