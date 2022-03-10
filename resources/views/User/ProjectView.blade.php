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
                                <hr class="m-1">
                                <div class="mt-0 mb-2">
                                    專案描述：{{ $data['projectData']['description'] }}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-10 offset-1">
                                <div class="my-2 d-flex justify-content-end">
                                    <button type="button" class="btn btn-outline-secondary">
                                        <i class="fa-solid fa-plus"></i> 新增測試
                                    </button>
                                </div>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr class="text-center">
                                            <th style="width:30%">col1</th>
                                            <th style="width:50%">col2</th>
                                            <th style="width:20%">col3</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="p-3">欄位1</th>
                                            <td class="p-3">欄位2</td>
                                            <td class="p-3">欄位3</td>
                                        </tr>
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
@endsection
