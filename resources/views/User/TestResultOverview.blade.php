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
                                <h3 class="mx-4 mt-4">結果總覽</h3>
                            </div>
                        </div>
                        {{-- 測試結果 --}}
                        <div class="row">
                            <div class="col-12 p-4">
                                <table class="table table-bordered py-2">
                                    <thead class="text-center align-middle">
                                        <tr class="text-center">
                                            <th>編號</th>
                                            <th>測試時間</th>
                                            <th>執行緒(人數)</th>
                                            <th>啟動時間</th>
                                            <th>重複次數</th>
                                            <th>錯誤率</th>
                                            <th>操作</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($data['testResultList'] as $testResult)
                                            <tr>
                                                <td class="p-3 text-center align-middle">
                                                    {{ $testResult['id'] }}
                                                </td>
                                                <td class="p-3 text-center align-middle">
                                                    {{ $testResult['end_at'] }}
                                                </td>
                                                <td class="p-3 text-center align-middle">
                                                    {{ $testResult['threads'] }} 人
                                                </td>
                                                <td class="p-3 text-center align-middle">
                                                    {{ $testResult['ramp_up_period'] }} 秒
                                                </td>
                                                <td class="p-3 text-center align-middle">
                                                    {{ $testResult['loops'] }} 次
                                                </td>
                                                <td class="p-3 text-center align-middle">
                                                    xx %
                                                </td>
                                                <td class="text-center align-middle">
                                                    <a class="btn btn-outline-secondary m-1 tippy-label"
                                                            href="{{ route('TestResult_View', $testResult['id']) }}">
                                                        <i class="fa-solid fa-magnifying-glass"></i>
                                                    </a>
                                                    <button class="btn btn-outline-secondary m-1"
                                                            onclick="deleteTestResult(this)"
                                                            data-result-id="{{ $testResult['id'] }}">
                                                        <i class="fa-solid fa-trash-can"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
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
