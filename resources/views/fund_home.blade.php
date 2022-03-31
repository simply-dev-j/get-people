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
            <div class="item item-blue">
                <a href="{{ route(App\WebRoute::FUND_CONVERSION_INDEX) }}" class="nav-link">
                    资金转换
                </a>
            </div>
            <div class="item item-blue">
                <a href="{{ route(App\WebRoute::FUND_TRANSFER_INDEX) }}" class="nav-link">
                    资金转账
                </a>
            </div>

            @if (App\Utils\UserUtil::isAdmin()) {{-- root 에만 유효 --}}
            <div class="item item-blue">
                <a href="{{ route(App\WebRoute::FUND_COMPANY_EDIT) }}" class="nav-link">
                    积分变更
                </a>
            </div>
            <div class="item item-blue">
                <a href="{{ route(App\WebRoute::FUND_COMPANY_ADJUST) }}" class="nav-link">
                    积分收回
                </a>
            </div>
            <div class="item item-blue">
                <a href="{{ route(App\WebRoute::FUND_COMPANY_TRANSFER) }}" class="nav-link">
                    积分转移
                </a>
            </div>
            @endif

            <div class="item item-blue">
                <a href="{{ route(App\WebRoute::FUND_WITHDRAW_INDEX) }}" class="nav-link">
                    奖金提现
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
