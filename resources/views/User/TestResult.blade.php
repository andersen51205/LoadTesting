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
                            {{-- 測試資訊 --}}
                            <div class="col-12 p-4">
                                <div class="card">
                                    <div class="card-header p-2 align-middle text-center">
                                        <h5 class="m-2 align-middle d-inline">測試資訊</h5>
                                    </div>
                                    <div class="card-body">
                                        <table class="table table-bordered">
                                            <tbody>
                                                <tr>
                                                    <th style="width: 25%">
                                                        名稱
                                                    </th>
                                                    <td style="width: 75%">
                                                        {{ $data['testScriptData']['name'] }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>描述</th>
                                                    <td>{{ $data['testScriptData']['description'] }}</td>
                                                </tr>
                                                <tr>
                                                    <th>執行緒(人數)</th>
                                                    <td>{{ $data['testResultData']['threads'] }} 人</td>
                                                </tr>
                                                <tr>
                                                    <th>啟動時間</th>
                                                    <td>{{ $data['testResultData']['ramp_up_period'] }} 秒</td>
                                                </tr>
                                                <tr>
                                                    <th>重複次數</th>
                                                    <td>{{ $data['testResultData']['loops'] }} 次</td>
                                                </tr>
                                                <tr>
                                                    <th>測試時間</th>
                                                    <td>
                                                        {{ $data['testResultData']['start_at'] }} 至 {{ $data['testResultData']['end_at'] }}
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            {{-- 成功率 --}}
                            <div class="col-12 pb-4">
                                <div class="card">
                                    <div class="card-header p-2 align-middle text-center">
                                        <h5 class="m-2 align-middle d-inline">成功率</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col"></div>
                                            <div class="col-3">
                                                <canvas id="Canvas_success_rate"></canvas>
                                            </div>
                                            <div class="col"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- 統計結果 --}}
                            <div class="col-12 pb-4">
                                <div class="card">
                                    <div class="card-header p-2 align-middle text-center">
                                        <h5 class="m-2 align-middle d-inline">統計結果</h5>
                                    </div>
                                    <div class="card-body my-3">
                                        <table class="table table-bordered py-2">
                                            <thead class="text-center align-middle">
                                                <tr>
                                                    {{-- <th rowspan="2" style="width: 40%">項目</th>
                                                    <th colspan="3">執行請求</th>
                                                    <th colspan="5">回應時間(毫秒)</th>
                                                    <th rowspan="2" style="width: 6%">流通量</th>
                                                    <th colspan="2">速度(KB/秒)</th> --}}
                                                    <th rowspan="2">項目</th>
                                                    <th colspan="3">執行請求</th>
                                                    <th colspan="5">回應時間(毫秒)</th>
                                                    <th rowspan="2">流通量</th>
                                                    <th colspan="2">速度(KB/秒)</th>
                                                </tr>
                                                <tr>
                                                    {{-- <th style="width: 5%">次數</th>
                                                    <th style="width: 5%">失敗</th>
                                                    <th style="width: 5%">失敗率</th>
                                                    <th style="width: 5%">平均</th>
                                                    <th style="width: 5%">最小</th>
                                                    <th style="width: 5%">最大</th>
                                                    <th style="width: 5%">中位數</th>
                                                    <th style="width: 6%">90分位</th>
                                                    <th style="width: 6%">接收</th>
                                                    <th style="width: 3%">傳送</th> --}}
                                                    <th>次數</th>
                                                    <th>失敗</th>
                                                    <th>失敗率</th>
                                                    <th>平均</th>
                                                    <th>最小</th>
                                                    <th>最大</th>
                                                    <th>中位數</th>
                                                    <th>90分位</th>
                                                    <th>接收</th>
                                                    <th>傳送</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if(isset($data['result']))
                                                    @foreach ($data['result'] as $result)
                                                        <tr>
                                                            <td class="text-break">
                                                                {{ $result['transaction'] }}
                                                            </td>
                                                            <td class="text-end">
                                                                {{ $result['sampleCount'] }}
                                                            </td>
                                                            <td class="text-end">
                                                                {{ $result['errorCount'] }}
                                                            </td>
                                                            <td class="text-end">
                                                                {{ number_format($result['errorPct'], 2) }}%
                                                            </td>
                                                            <td class="text-end">
                                                                {{ number_format($result['meanResTime'], 2) }}
                                                            </td>
                                                            <td class="text-end">
                                                                {{ $result['minResTime'] }}
                                                            </td>
                                                            <td class="text-end">
                                                                {{ $result['maxResTime'] }}
                                                            </td>
                                                            <td class="text-end">
                                                                {{ number_format($result['medianResTime'], 2) }}
                                                            </td>
                                                            <td class="text-end">
                                                                {{ $result['pct90ResTime'] }}
                                                            </td>
                                                            <td class="text-end">
                                                                {{ number_format($result['throughput'], 2) }}
                                                            </td>
                                                            <td class="text-end">
                                                                {{ number_format($result['receivedKBytesPerSec'], 2) }}
                                                            </td>
                                                            <td class="text-end">
                                                                {{ number_format($result['sentKBytesPerSec'], 2) }}
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            {{-- 失敗統計結果 --}}
                            <div class="col-12 pb-4">
                                <div class="card">
                                    <div class="card-header p-2 align-middle text-center">
                                        <h5 class="m-2 align-middle d-inline">失敗結果</h5>
                                    </div>
                                    <div class="card-body my-3">
                                        <table class="table table-bordered py-2">
                                            <thead class="text-center align-middle">
                                                <tr>
                                                    <th style="width: 48%">項目</th>
                                                    <th style="width: 6%">總次數</th>
                                                    <th style="width: 6%">失敗數</th>
                                                    <th style="width: 40%">錯誤資訊</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if(isset($data['error']) && count($data['error'])>0)
                                                    @foreach ($data['error'] as $error)
                                                        <tr>
                                                            <td class="text-break">
                                                                {{ $error['errorLabel'] }}
                                                            </td>
                                                            <td class="text-end">
                                                                {{ $error['sampleCount'] }}
                                                            </td>
                                                            <td class="text-end">
                                                                {{ $error['errorCount'] }}
                                                            </td>
                                                            <td class="text-break">
                                                                {{ $error['errorType'] }}
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @else
                                                    <tr>
                                                        <td colspan="4" class="text-center">無失敗結果</td>
                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            {{-- 錯誤資訊統計結果 --}}
                            <div class="col-12 pb-4">
                                <div class="card">
                                    <div class="card-header p-2 align-middle text-center">
                                        <h5 class="m-2 align-middle d-inline">錯誤資訊統計結果</h5>
                                    </div>
                                    <div class="card-body my-3">
                                        <table class="table table-bordered py-2">
                                            <thead class="text-center align-middle">
                                                <tr>
                                                    <th style="width: 55%">錯誤資訊</th>
                                                    <th style="width: 15%">次數</th>
                                                    <th style="width: 15%">失敗比例</th>
                                                    <th style="width: 15%">整體比例</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if(isset($data['errorByType']) && count($data['errorByType'])>0)
                                                    @foreach ($data['errorByType'] as $error)
                                                        <tr>
                                                            <td class="text-break">
                                                                {{ $error['errorType'] }}
                                                            </td>
                                                            <td class="text-end">
                                                                {{ $error['errorCount'] }}
                                                            </td>
                                                            <td class="text-end">
                                                                {{ number_format($error['errorPctInError'], 2) }}%
                                                            </td>
                                                            <td class="text-end">
                                                                {{ number_format($error['errorPctInAll'], 2) }}%
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @else
                                                    <tr>
                                                        <td colspan="4" class="text-center">無錯誤資訊</td>
                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 pb-4 text-center">
                                <a class="btn btn-secondary m-1"
                                        href="{{ route('Project_View', $data['testScriptData']['project_id']) }}">
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
    @include('JS_view.User.TestResult')
@endsection
