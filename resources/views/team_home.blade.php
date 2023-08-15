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

            @if(App\Utils\UserUtil::isAdminOrCompany())
            <div class="item item-yellow">
                <a href="{{ route(App\WebRoute::TEAM_INDEX) }}" {{ App\Utils\UserUtil::isAdminOrCompany() ? '' : 'disabled' }}>
                    报单列表
                </a>
            </div>
            @endif

            {{-- root 에만 유효 --}}
            @if(App\Utils\UserUtil::isAdmin())
            <div class="item item-yellow">
                <a href="{{ route(App\WebRoute::ADMIN_COMPANY_INDEX) }}">
                    {{ __(App\LocaleConstants::FORM_BASE.App\LocaleConstants::FORM_ADMIN_COMPANY_MANAGEMENT) }}
                </a>
            </div>
            @endif

            <div class="item item-yellow">
                <a href="{{ route(App\WebRoute::CODE_INDEX) }}">
                    推荐列表
                </a>
            </div>
            <div class="item item-yellow">
                <a href="{{ route(App\WebRoute::TEAM_NET) }}">
                    网体排列
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
