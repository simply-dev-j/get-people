@extends('layout.app_layout')

@section('content-header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-12 text-center home-avatar">
                <img src="/img/car.jpg" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="col-12 home-title mt-2">
                {{ auth()->user()->username }}<br>
                {{ auth()->user()->name }}
            </div>
        </div>
    </div>
@endsection

@section('content')
<div class="row px-3">

    <div class="col-12 mt-3">
        <div class="item-container">
            <div class="item item-green">
                <a href="{{ route(App\WebRoute::AUTH_PROFILE) }}">
                    个人信息
                </a>
            </div>
            <div class="item item-green">
                <a href="{{ route(App\WebRoute::AUTH_BANK) }}">
                    银行信息
                </a>
            </div>
            <div class="item item-green">
                <a href="{{ route(App\WebRoute::AUTH_RESET_PASSWORD) }}">
                    修改密码
                </a>
            </div>
            <div class="item item-green">
                <a href="{{ route(App\WebRoute::AUTH_PHONE) }}">
                    手机绑定
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
