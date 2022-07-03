@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">首頁</div>
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <h5>{{ $data['user']['name'] }} 你好</h5>
                        <h5 class="mt-3">歡迎使用性能測試平台</h5>
                        <hr>
                        <h5 class="mt-3">專案數：{{ $data['projectCount'] }}</h5>
                        <h5 class="mt-3">測試腳本數：{{ $data['testScriptCount'] }}</h5>
                        <h5 class="mt-3">測試結果數：{{ $data['testResultCount'] }}</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
