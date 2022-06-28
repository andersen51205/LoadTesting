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
                            <div class="col-md-8">
                                <h1>如何產生腳本</h1>
                                {{-- collapse按鈕 --}}
                                <button type="button" id="Btn_show_jmeter_card" class="btn btn-primary d-none"
                                        data-bs-toggle="collapse" data-bs-target="#Div_jmeter_card">
                                </button>
                                <button type="button" id="Btn_show_chrome_extension_card" class="btn btn-primary d-none"
                                        data-bs-toggle="collapse" data-bs-target="#Div_chrome_extension">
                                </button>

                                <div id="Div_jmeter_card" class="fade show">
                                    <div class="card my-3">
                                        <div class="card-header">
                                            <h4 class="m-1">透過Jmeter錄製腳本</h4>
                                        </div>
                                        <div class="card-body">
                                            <h5 class="card-title d-inline-block m-0">取得Jmeter</h5>
                                            <a class="btn btn-outline-success ms-2"
                                                    target="_blank" rel="noopener noreferrer"
                                                    href="https://jmeter.apache.org/download_jmeter.cgi">
                                                <i class="fa-solid fa-up-right-from-square"></i> 點我前往
                                            </a>
                                            <div class="mt-3 d-flex justify-content-start">
                                                <p class="my-1 p-0">不想下載Jmeter？</p>
                                                <button type="button" class="btn btn-outline-secondary btn-sm"
                                                        onclick="toggle('chromeExtension')">
                                                    試試擴充套件
                                                </button>
                                            </div>
                                        </div>
                                        <hr class="m-0">
                                        <div class="card-body">
                                            <h5 class="card-title d-inline-block m-0">下載錄製範本</h5>
                                            <a class="btn btn-outline-danger ms-2" href="">
                                                <i class="fa-solid fa-file-arrow-down"></i> 錄製範本(未建立)
                                            </a>
                                        </div>
                                        <hr class="m-0">
                                        <div class="card-body">
                                            <h5 class="card-title d-inline-block">開啟錄製範本</h5>
                                            <ul class="m-0">
                                                <li>開啟Jmeter，並載入錄製範本</li>
                                            </ul>
                                        </div>
                                        <hr class="m-0">
                                        <div class="card-body">
                                            <h5 class="card-title d-inline-block">設定錄製網址</h5>
                                            <ul class="m-0">
                                                <li>點選"HTTP(S) Test Script Recorder"</li>
                                                <li>找到"Requset Filtering"標籤</li>
                                                <li>"URL Patterns to Include"新增要錄製的網站網址</li>
                                            </ul>
                                        </div>
                                        <hr class="m-0">
                                        <div class="card-body">
                                            <h5 class="card-title d-inline-block">產生憑證</h5>
                                            <ul class="m-0">
                                                <li>按下"Start"後，會在Jmeter目錄下產生憑證</li>
                                            </ul>
                                        </div>
                                        <hr class="m-0">
                                        <div class="card-body">
                                            <h5 class="card-title d-inline-block">安裝憑證</h5>
                                            <ul class="m-0">
                                                <li>開啟Jmeter資料夾</li>
                                                <li>雙擊"ApacheJMeterTemporaryRootCA.crt"</li>
                                                <li>點選"安裝憑證"</li>
                                                <li>"下一步"</li>
                                                <li>將憑證放入"受信任的根憑證授權單位"，點選"下一步"</li>
                                                <li>完成</li>
                                            </ul>
                                        </div>
                                        <hr class="m-0">
                                        <div class="card-body">
                                            <h5 class="card-title d-inline-block">設定Proxy</h5>
                                            <ul class="m-0">
                                                <li>開啟Proxy設定</li>
                                                <li>打開手動設定Proxy</li>
                                                <li>輸入位址"http://localhost"與預設連接埠"8888"</li>
                                                <li>按下"儲存"</li>
                                            </ul>
                                        </div>
                                        <hr class="m-0">
                                        <div class="card-body">
                                            <h5 class="card-title d-inline-block">開始錄製</h5>
                                            <ul class="m-0">
                                                <li>設定完成後即可開始錄製腳本</li>
                                            </ul>
                                        </div>
                                        <hr class="m-0">
                                        <div class="card-body">
                                            <h5 class="card-title d-inline-block">完成錄製</h5>
                                            <ul class="m-0">
                                                <li>停止Jmeter錄製</li>
                                                <li>關閉Proxy</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div id="Div_chrome_extension" class="fade d-none">
                                    <div class="card my-3">
                                        <div class="card-header">
                                            <h4 class="m-1">透過chrome的擴充功能錄製腳本</h4>
                                        </div>
                                        <div class="card-body">
                                            <h5 class="card-title d-inline-block m-0">安裝Chrome擴充功能</h5>
                                            <a class="btn btn-outline-success ms-2"
                                                target="_blank" rel="noopener noreferrer"
                                                href="https://chrome.google.com/webstore/detail/blazemeter-the-continuous/mbopgmdnpcbohhpnfglgohlbhfongabi">
                                                <i class="fa-solid fa-up-right-from-square"></i> 點我前往
                                            </a>
                                            <button type="button" class="btn btn-primary"
                                                    onclick="toggle('jmeter')">
                                                試試Jmeter
                                            </button>
                                        </div>
                                        <hr class="m-0">
                                        <div class="card-body">
                                            <h5 class="card-title d-inline-block">準備開始錄製</h5>
                                            <ul class="m-0">
                                                <li>開啟網站與Blazemeter擴充功能</li>
                                                <li>輸入測試名稱</li>
                                                <li>設定Advanced Options</li>
                                            </ul>
                                        </div>
                                        <hr class="m-0">
                                        <div class="card-body">
                                            <h5 class="card-title d-inline-block">開始錄製</h5>
                                            <ul class="m-0">
                                                <li>設定完成後，按下紅色按鈕即可開始錄製腳本</li>
                                            </ul>
                                        </div>
                                        <hr class="m-0">
                                        <div class="card-body">
                                            <h5 class="card-title d-inline-block">完成錄製</h5>
                                            <ul class="m-0">
                                                <li>錄製完成後，按下停止錄製後，開啟Blazemeter擴充功能</li>
                                                <li>點擊Edit，可簡單的編輯錄製內容</li>
                                                <li>若有登入Blazemeter帳號可直接點擊JMX，儲存腳本</li>
                                                <li>沒有帳號可存成JSON，再透過轉換網站轉成JMX檔
                                                    <a class="btn btn-outline-success ms-2"
                                                            target="_blank" rel="noopener noreferrer"
                                                            href="https://converter.blazemeter.com/">
                                                        <i class="fa-solid fa-up-right-from-square"></i> 轉換網站
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <div class="card mb-3">
                                    <div class="card-header">
                                        <h4 class="m-1">腳本處理</h4>
                                    </div>
                                    <div class="card-body">
                                        <h5 class="card-title d-inline-block my-1">
                                            使用 <b>Jmeter(推薦)</b> 或
                                        </h5>
                                        <a class="btn btn-outline-secondary btn-sm ms-2"
                                                target="_blank" rel="noopener noreferrer"
                                                href="https://jmeter-plugins.org/editor/">
                                            <i class="fa-solid fa-up-right-from-square"></i> 線上編輯器
                                        </a>
                                    </div>
                                    <hr class="m-0">
                                    <div class="card-body">
                                        <h5 class="card-title d-inline-block">預處理</h5>
                                        <ul class="m-0">
                                            <li>調整腳本中的各個步驟的名稱提高可讀性</li>
                                            <li>腳本步驟微調</li>
                                        </ul>
                                    </div>
                                    <hr class="m-0">
                                    <div class="card-body">
                                        <h5 class="card-title d-inline-block">修正CSRF token</h5>
                                        <ul class="m-0">
                                            <li>在Get腳本中新增"Regular Expression Extractor"</li>
                                            <li>在Post腳本中新增token的參數</li>
                                        </ul>
                                    </div>
                                    <hr class="m-0">
                                    <div class="card-body">
                                        <h5 class="card-title d-inline-block">完成腳本</h5>
                                        <ul class="m-0">
                                            <li>測試腳本，確認該腳本能順利通過測試即可上傳</li>
                                        </ul>
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
@endsection

@section('script')
    @include('JS_view.user.TestTutorial')
@endsection
