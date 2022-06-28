@extends('layouts.app')

@section('link')
    <link href="{{ asset('css/dataTable.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="sb-nav-fixed">
        <div id="layoutSidenav">
            {{-- 側邊欄 --}}
            @include('layouts.User.ProjectSidenav')
            {{-- 內容 --}}
            <div id="layoutSidenav_content">
                <main>
                    <div class="container pt-4">
                        <div class="row justify-content-center">
                            <div class="col-md-8 pb-4">
                                <div class="card">
                                    <div class="card-header p-3 align-middle text-center">
                                        <h3 class="m-2 align-middle d-inline"><i class="fa-solid fa-plus"></i> 編輯測試腳本</h3>
                                    </div>
                                    <div class="card-body">
                                        <form id="Form_test_script_information" method="POST" action="{{-- axios --}}">
                                            <div class="row">
                                                {{-- 選擇專案 --}}
                                                <div class="col-2 mb-3 offset-1">
                                                    <label class="col-form-label" for="Select_project">
                                                        <span class="text-danger">*</span>選擇專案
                                                    </label>
                                                </div>
                                                <div class="col-8 mb-3">
                                                    <select id="Select_project" class="form-select necessary"
                                                        name="projectId" value="">
                                                        <option value="">選擇專案...</option>
                                                        @if(isset($data['projectList']))
                                                            @foreach ($data['projectList'] as $project)
                                                                <option value="{{ $project['id'] }}"
                                                                    @if($data['projectData']['id'] === $project['id'])
                                                                        selected
                                                                    @endif
                                                                >{{ $project['name'] }}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row">
                                                {{-- 測試腳本名稱 --}}
                                                <div class="col-2 mb-3 offset-1">
                                                    <label class="col-form-label" for="Input_name">
                                                        <span class="text-danger">*</span>測試腳本名稱
                                                    </label>
                                                </div>
                                                <div class="col-8 mb-3">
                                                    <input type="text" id="Input_name" class="form-control necessary"
                                                        name="testScriptName" value="{{ $data['testScriptData']['name'] }}">
                                                </div>
                                            </div>
                                            <div class="row">
                                                {{-- 測試腳本描述 --}}
                                                <div class="col-2 mb-3 offset-1">
                                                    <label class="col-form-label" for="Textarea_description">
                                                        描述
                                                    </label>
                                                </div>
                                                <div class="col-8 mb-3">
                                                    <textarea id="Textarea_description" class="form-control"
                                                        name="testScriptDescription" rows="4">{{ $data['testScriptData']['description'] }}</textarea>
                                                </div>
                                            </div>
                                            <div class="row">
                                                {{-- 遞增人數 --}}
                                                <div class="col-2 mb-3 offset-1">
                                                    <label class="col-form-label" for="Input_threads">
                                                        <span class="text-danger">*</span>遞增執行緒
                                                    </label>
                                                </div>
                                                <div class="col-8 mb-3 pt-2">
                                                    <div class="form-check form-check-inline">
                                                        <input type="radio" id="Input_incremental_1" class="form-check-input"
                                                            name="testScriptIncremental" value="1"
                                                            onclick="changeIncremental()"
                                                            @if($data['testScriptData']['is_incremental'] === 1) checked @endif>
                                                        <label class="form-check-label" for="Input_incremental_1">是</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input type="radio" id="Input_incremental_0" class="form-check-input"
                                                            name="testScriptIncremental" value="0"
                                                            onclick="changeIncremental()"
                                                            @if($data['testScriptData']['is_incremental'] === 0) checked @endif>
                                                        <label class="form-check-label" for="Input_incremental_0">否</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                {{-- 人數 --}}
                                                <div class="col-2 mb-3 offset-1">
                                                    <label class="col-form-label" for="Input_threads">
                                                        <span class="text-danger">*</span>執行緒(人數)
                                                    </label>
                                                </div>
                                                <div class="col-8 mb-3 d-flex">
                                                    <div class="flex-grow-1">
                                                        <input type="text" id="Input_start_threads"
                                                            class="form-control necessary verify-int d-inline-flex"
                                                            name="testScriptStartThreads" value="{{ $data['testScriptData']['start_thread'] }}">
                                                    </div>
                                                    <div id="Div_thread_tilde" class="flex-grow-1 text-center d-none">
                                                        <label class="col-form-label" for="Input_end_threads">
                                                        ~
                                                        </label>
                                                    </div>
                                                    <div id="Div_end_thread" class="flex-grow-1 d-none">
                                                        <input type="text" id="Input_end_threads"
                                                            class="form-control d-inline-flex"
                                                            name="testScriptEndThreads" value="{{ $data['testScriptData']['end_thread'] }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="Div_increment_amount" class="row d-none">
                                                {{-- 遞增數量 --}}
                                                <div class="col-2 mb-3 offset-1">
                                                    <label class="col-form-label" for="Input_increment_amount">
                                                        <span class="text-danger">*</span>遞增數量
                                                    </label>
                                                </div>
                                                <div class="col-8 mb-3">
                                                    <input type="text" id="Input_increment_amount"
                                                        class="form-control"
                                                        name="testScriptIncrementAmount" value="{{ $data['testScriptData']['increment_amount'] }}">
                                                </div>
                                            </div>
                                            <div class="row">
                                                {{-- 啟動時間 --}}
                                                <div class="col-2 mb-3 offset-1">
                                                    <label class="col-form-label" for="Input_ramp_up_period">
                                                        <span class="text-danger">*</span>啟動時間(秒)
                                                    </label>
                                                </div>
                                                <div class="col-8 mb-3">
                                                    <input type="text" id="Input_ramp_up_period" class="form-control necessary verify-int"
                                                        name="testScriptRampUpPeriod" value="{{ $data['testScriptData']['ramp_up_period'] }}">
                                                </div>
                                            </div>
                                            <div class="row">
                                                {{-- 次數 --}}
                                                <div class="col-2 mb-3 offset-1">
                                                    <label class="col-form-label" for="Input_loops">
                                                        <span class="text-danger">*</span>執行次數
                                                    </label>
                                                </div>
                                                <div class="col-8 mb-3">
                                                    <input type="text" id="Input_loops" class="form-control necessary verify-int"
                                                        name="testScriptLoops" value="{{ $data['testScriptData']['loops'] }}">
                                                </div>
                                            </div>
                                            <div class="row">
                                                {{-- 舊檔案 --}}
                                                <div class="col-2 mb-3 offset-1">
                                                    <label class="col-form-label" for="Input_file">
                                                        <span class="text-danger">*</span>原始腳本
                                                    </label>
                                                </div>
                                                <div class="col-8 mb-3">
                                                    <a class="btn btn-outline-danger"
                                                            href="{{ route('User_TestScript_Download', $data['testScriptData']['id']) }}">
                                                        <i class="fa-solid fa-file-arrow-down"></i> {{ $data['testScriptData']['fileName'] }}
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="row">
                                                {{-- 新腳本檔案 --}}
                                                <div class="col-2 mb-3 offset-1">
                                                    <label class="col-form-label" for="Input_file">
                                                        上傳新腳本
                                                    </label>
                                                </div>
                                                <div class="col-8 mb-3">
                                                    <input type="file" id="Input_file" class="form-control"
                                                        name="file" accept=".jmx">
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>若無需變更腳本，請將欄位留空。</strong>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="row">
                                                {{-- 表單操作區 --}}
                                                <div class="col-10 mb-3 offset-1">
                                                    <div class="d-flex justify-content-center">
                                                        <button type="button" class="btn btn-primary"
                                                                data-type="update" data-id="{{ $data['testScriptData']['id'] }}"
                                                                onclick="submitForm(this)">
                                                            送出
                                                        </button>
                                                        <a class="btn btn-secondary ms-2"
                                                                href="{{ route('User_Project_View', $data['testScriptData']['project_id']) }}">
                                                            返回
                                                        </a>
                                                    </div>
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
    @include('JS_view.User.TestScriptCreate')
@endsection
