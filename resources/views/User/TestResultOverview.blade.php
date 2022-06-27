@extends('layouts.app')

@section('link')
    {{-- <link href="{{ asset('css/dataTable.css') }}" rel="stylesheet"> --}}
@endsection

@section('content')
    <div class="sb-nav-fixed">
        <div id="layoutSidenav">
            {{-- 側邊欄 --}}
            @include('layouts.User.ResultSidenav')
            {{-- 內容 --}}
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <div class="row">
                            <div class="col-12">
                                <h3 class="mx-4 mt-4">腳本資訊</h3>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 px-4 py-2">
                                <table class="table table-bordered align-middle">
                                    <tbody>
                                        <tr>
                                            <th style="width: 25%">腳本名稱</th>
                                            <td style="width: 75%">{{ $data['testScriptData']['name'] }}</td>
                                        </tr>
                                        <tr>
                                            <th>描述</th>
                                            <td>{{ $data['testScriptData']['description'] }}</td>
                                        </tr>
                                        <tr>
                                            <th>腳本檔</th>
                                            <td>
                                                <a class="btn btn-outline-danger"
                                                        href="{{ route('User_TestScript_Download', $data['testScriptData']['id']) }}">
                                                    <i class="fa-solid fa-file-arrow-down"></i> {{ $data['testScriptData']['filename']['name'] }}
                                                </a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <h3 class="mx-4 mt-2">結果總覽</h3>
                            </div>
                        </div>
                        {{-- 測試結果 --}}
                        <div class="row">
                            <div class="col-12 px-4 py-2 text-center">
                                <table class="table table-bordered">
                                    <thead class="text-center align-middle">
                                        <tr class="text-center">
                                            <th>編號</th>
                                            <th>測試時間</th>
                                            <th>執行緒(人數)</th>
                                            <th>啟動時間</th>
                                            <th>重複次數</th>
                                            <th>平均回應時間(毫秒)</th>
                                            <th>錯誤率</th>
                                            <th>操作</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(count($data['testResultList']) === 0)
                                            <tr>
                                                <td class="p-3 text-center align-middle" colspan="8">
                                                    無測試結果
                                                </td>
                                            </tr>
                                        @else
                                            @for($i=0; $i<count($data['testResultList']); $i++)
                                                <tr>
                                                    <td class="p-3 text-center align-middle">
                                                        {{ $i+1 }}
                                                    </td>
                                                    <td class="p-3 text-center align-middle">
                                                        {{ $data['testResultList'][$i]['start_at'] }}
                                                    </td>
                                                    <td class="p-3 text-center align-middle">
                                                        {{ $data['testResultList'][$i]['threads'] }} 人
                                                    </td>
                                                    <td class="p-3 text-center align-middle">
                                                        {{ $data['testResultList'][$i]['ramp_up_period'] }} 秒
                                                    </td>
                                                    <td class="p-3 text-center align-middle">
                                                        {{ $data['testResultList'][$i]['loops'] }} 次
                                                    </td>
                                                    <td class="p-3 text-center align-middle">
                                                        {{ $data['testResultList'][$i]['response_time'] }} ms
                                                    </td>
                                                    <td class="p-3 text-center align-middle">
                                                        {{ $data['testResultList'][$i]['error_rate'] }} %
                                                    </td>
                                                    <td class="text-center align-middle">
                                                        <a class="btn btn-outline-secondary m-1 tooltip-label"
                                                                data-tippy-content="查看"
                                                                href="{{ route('User_TestResult_View', $data['testResultList'][$i]['id']) }}">
                                                            <i class="fa-solid fa-magnifying-glass"></i>
                                                        </a>
                                                        <button class="btn btn-outline-secondary m-1 tooltip-label"
                                                                data-tippy-content="刪除"
                                                                onclick="deleteTestResult(this)"
                                                                data-result-id="{{ $data['testResultList'][$i]['id'] }}">
                                                            <i class="fa-solid fa-trash-can"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endfor
                                        @endif
                                    </tbody>
                                </table>
                                <a class="btn btn-secondary m-1"
                                        href="{{ route('User_Project_View', $data['testScriptData']['project_id']) }}">
                                    返回列表
                                </a>
                            </div>
                        </div>
                    </div>
                </main>
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
    @include('JS_view.User.TestResultOverview')
@endsection
