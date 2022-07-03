@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">管理員首頁</div>
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <h5>管理員 {{ $data['user']['name'] }} 你好</h5>
                        <h5 class="mt-3">歡迎使用平台管理系統</h5>
                        <hr>
                        <h5 class="mt-3">使用者數：{{ $data['userCount'] }}</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
