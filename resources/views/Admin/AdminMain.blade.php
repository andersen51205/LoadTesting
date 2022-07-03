@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">最高管理員首頁</div>
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <h5>最高管理員 {{ $data['user']['name'] }} 你好</h5>
                        <h5 class="mt-3">歡迎使用平台管理系統</h5>
                        <hr>
                        <h5 class="mt-3">管理員數：{{ $data['managerCount'] }}</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
