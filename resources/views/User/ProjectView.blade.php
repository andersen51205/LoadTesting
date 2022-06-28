@extends('layouts.app')

@section('link')
    {{-- <link href="{{ asset('css/dataTable.css') }}" rel="stylesheet"> --}}
@endsection

@section('content')
    <div class="sb-nav-fixed">
        <div id="layoutSidenav">
            {{-- 側邊欄 --}}
            @include('layouts.User.ProjectSidenav')
            {{-- 內容 --}}
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <div class="row">
                            <div class="col-10 offset-1 ">
                                <h3 class="mt-4 mb-0">專案名稱：{{ $data['projectData']['name'] }}</h3>
                                <div class="my-2">
                                    專案描述：{{ $data['projectData']['description'] }}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-10 offset-1">
                                <div class="my-2 d-flex justify-content-end">
                                    <a class="btn btn-outline-secondary me-2"
                                        target="_blank" rel="noopener noreferrer"
                                        href="{{ route('User_TestScriptTutorial_View') }}">
                                        <i class="fa-regular fa-circle-question"></i> 如何產生腳本
                                    </a>
                                    <a class="btn btn-outline-secondary"
                                        href="{{ route('User_TestScriptCreate_View') }}?projectId={{ $data['projectData']['id'] }}">
                                        <i class="fa-solid fa-plus"></i> 新增測試
                                    </a>
                                </div>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr class="text-center">
                                            <th style="width:20%">名稱</th>
                                            <th style="width:30%">描述</th>
                                            <th style="width:12%">狀態</th>
                                            <th style="width:13%">最後修改日期</th>
                                            <th style="width:25%">操作</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(isset($data['testScriptList']))
                                            @if(count($data['testScriptList']) === 0)
                                                <tr>
                                                    <td class="p-3 text-center" colspan="5">無測試腳本資料</th>
                                                </tr>
                                            @else
                                                @foreach ($data['testScriptList'] as $testScript)
                                                    <tr>
                                                        {{-- 名稱 --}}
                                                        <td class="p-3 align-middle">{{ $testScript['name'] }}</th>
                                                        {{-- 描述 --}}
                                                        <td class="p-3 align-middle">{{ $testScript['description'] }}</td>
                                                        {{-- 狀態 --}}
                                                        <td class="p-3 text-center align-middle">
                                                            @if($testScript['status'] === 1)
                                                                準備就緒
                                                            @elseif($testScript['status'] === 2)
                                                                等待開始
                                                            @elseif($testScript['status'] === 3)
                                                                測試中
                                                            @elseif($testScript['status'] === 4)
                                                                測試完成
                                                            @elseif($testScript['status'] === 5)
                                                                失敗
                                                            @else
                                                                其他
                                                            @endif
                                                        </td>
                                                        {{-- 最後修改日期 --}}
                                                        <td class="p-3 text-center align-middle">
                                                            @if(isset($testScript['updateDate'])
                                                                    && isset($testScript['updateTime']))
                                                                {{ $testScript['updateDate'] }}<br>{{ $testScript['updateTime'] }}
                                                            @else
                                                                {{ $testScript['updated_at'] }}
                                                            @endif
                                                        </td>
                                                        {{-- 操作區 --}}
                                                        <td class="text-center align-middle">
                                                            {{-- 開始測試 --}}
                                                            <button class="btn btn-outline-secondary m-1 tooltip-label"
                                                                    data-id="{{ $testScript['id'] }}"
                                                                    data-tippy-content="開始測試"
                                                                    onclick="startTesting(this)"
                                                                    @if($testScript['status'] === 2
                                                                            || $testScript['status'] === 3)
                                                                        disabled
                                                                    @endif>
                                                                <i class="fa-solid fa-play"></i>
                                                            </button>
                                                            {{-- 查看結果 --}}
                                                            <a class="btn btn-outline-secondary m-1 tooltip-label"
                                                                    data-tippy-content="查看結果"
                                                                    href="{{ route('User_TestResultList_View', $testScript['id']) }}">
                                                                <i class="fa-solid fa-chart-line"></i>
                                                            </a>
                                                            {{-- 編輯腳本 --}}
                                                            <button class="btn btn-outline-secondary m-1 tooltip-label"
                                                                    data-tippy-content="編輯"
                                                                    onclick="editTestScript(this)"
                                                                    @if($testScript['status'] !== 2
                                                                            && $testScript['status'] !== 3)
                                                                        data-href="{{ route('User_TestScript_Edit', $testScript['id']) }}"
                                                                    @else
                                                                        disabled
                                                                    @endif>
                                                                <i class="fa-solid fa-pen-to-square"></i>
                                                            </button>
                                                            {{-- 刪除腳本 --}}
                                                            <button class="btn btn-outline-secondary m-1 tooltip-label"
                                                                    data-tippy-content="刪除"
                                                                    onclick="deleteTestScript(this)"
                                                                    @if($testScript['status'] !== 2
                                                                            && $testScript['status'] !== 3)
                                                                        data-script-id="{{ $testScript['id'] }}"
                                                                    @else
                                                                        disabled
                                                                    @endif>
                                                                <i class="fa-solid fa-trash-can"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        @endif
                                    </tbody>
                                </table>
                                <div class="text-center">
                                    <a class="btn btn-secondary mb-3" href="{{ route('User_ProjectList_View') }}">
                                        返回列表
                                    </a>
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
    @include('JS_view.User.ProjectView')
@endsection
