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
                            <div class="col-12 pt-4">
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
                                                        {{ $data['testScript']['name'] }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>描述</th>
                                                    <td>{{ $data['testScript']['description'] }}</td>
                                                </tr>
                                                <tr>
                                                    <th>開始時間</th>
                                                    <td>{{ $data['testScript']['start_at'] }}</td>
                                                </tr>
                                                <tr>
                                                    <th>結束時間</th>
                                                    <td>{{ $data['testScript']['end_at'] }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            {{-- 成功率 --}}
                            <div class="col-12 pt-4">
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
                            <div class="col-12 pt-4">
                                <div class="card">
                                    <div class="card-header p-2 align-middle text-center">
                                        <h5 class="m-2 align-middle d-inline">統計結果</h5>
                                    </div>
                                    <div class="card-body my-3">
                                        <table class="table table-bordered py-2">
                                            <thead class="text-center align-middle">
                                                <tr>
                                                    <th rowspan="2" style="width: 40%">項目</th>
                                                    <th colspan="3">執行請求</th>
                                                    <th colspan="4">回應時間(毫秒)</th>
                                                    <th rowspan="2" style="width: 6%">流通量</th>
                                                    <th colspan="2">速度(KB/秒)</th>
                                                </tr>
                                                <tr>
                                                    <th style="width: 5%">次數</th>
                                                    <th style="width: 5%">失敗</th>
                                                    <th style="width: 5%">失敗率</th>
                                                    <th style="width: 5%">平均</th>
                                                    <th style="width: 5%">最小</th>
                                                    <th style="width: 5%">最大</th>
                                                    <th style="width: 5%">中位數</th>
                                                    <th style="width: 6%">接收</th>
                                                    <th style="width: 3%">傳送</th>
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
