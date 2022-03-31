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
    <div class="col-12">
        <div class="item-container">
            <div class="item item-red col-lg-3 col-md-6 col-12">
                <!-- small box -->

                <div class="inner">
                    <h2>
                        {{ auth()->user()->withdrawn }}
                    </h2>

                    <h5>注册积分</h5>
                    {{-- 등록적분 --}}
                </div>
                <div class="item-footer">
                    <a href="{{ route(App\WebRoute::TRANSACTION_INDEX, ['type' => App\Utils\TransactionUtil::TYPE_WITHDRAWN]) }}" class="small-box-footer">查看明细  <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <div class="item item-yellow col-lg-3 col-md-6 col-12">
                <!-- small box -->

                <div class="inner">
                    <h2>
                        {{ auth()->user()->released }}
                    </h2>

                    <h5>购物积分</h5>
                    {{-- 물건구매적분 --}}
                </div>
                <div class="item-footer">
                    <a href="{{ route(App\WebRoute::TRANSACTION_INDEX, ['type' => App\Utils\TransactionUtil::TYPE_RELEASE]) }}" class="small-box-footer">查看明细  <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <div class="item item-blue col-lg-3 col-md-6 col-12">
                <!-- small box -->

                <div class="inner">
                    <h2>
                        {{ auth()->user()->released_from_pending }}
                    </h2>

                    <h5>购车积分</h5>
                    {{-- 차구매적분 --}}
                </div>
                <div class="item-footer">
                    <a href="{{ route(App\WebRoute::TRANSACTION_INDEX, ['type' => App\Utils\TransactionUtil::TYPE_RELEASED_FROM_PENDING]) }}" class="small-box-footer">查看明细  <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <div class="item item-green col-lg-3 col-md-6 col-12">
                <!-- small box -->

                <div class="inner">
                    <h2>
                        {{ auth()->user()->money_added }}
                    </h2>
                    {{-- 종합 --}}
                    <h5>累计积分</h5>
                </div>
                <div class="item-footer">
                {{-- <a href="{{ route(App\WebRoute::TRANSACTION_INDEX, ['type' => App\Utils\TransactionUtil::TYPE_ALL]) }}" class="small-box-footer">查看明细  <i class="fas fa-arrow-circle-right"></i></a> --}}
                    <a class="small-box-footer"><br></a>
                </div>
            </div>
        </div>
    </div>




  </div>
@endsection
