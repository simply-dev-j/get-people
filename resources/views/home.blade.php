@extends('layout.app_layout')

@section('content-header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                {{-- <h2>奖金提现</h2> --}}
            </div>
        </div>
    </div>
@endsection

@section('content')
<div class="row">

    <div class="col-lg-3 col-md-6 col-12">
        <!-- small box -->
        <div class="small-box bg-info">
          <div class="inner">
            <h5>
                {{ auth()->user()->withdrawn }}
            </h5>

            <div class="text-sm">注册积分</div>
            {{-- 등록적분 --}}
          </div>
          <div class="icon">
            <i class="ion ion-bag"></i>
          </div>
          <a href="{{ route(App\WebRoute::TRANSACTION_INDEX, ['type' => App\Utils\TransactionUtil::TYPE_WITHDRAWN]) }}" class="small-box-footer">查看明细  <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 col-12">
        <!-- small box -->
        <div class="small-box bg-info">
          <div class="inner">
            <h5>
                {{ auth()->user()->released }}
            </h5>

            <div class="text-sm">购物积分</div>
            {{-- 물건구매적분 --}}
          </div>
          <div class="icon">
            <i class="ion ion-bag"></i>
          </div>
          <a href="{{ route(App\WebRoute::TRANSACTION_INDEX, ['type' => App\Utils\TransactionUtil::TYPE_RELEASE]) }}" class="small-box-footer">查看明细  <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 col-12">
        <!-- small box -->
        <div class="small-box bg-info">
          <div class="inner">
            <h5>
                {{ auth()->user()->released_from_pending }}
            </h5>

            <div class="text-sm">购车积分</div>
            {{-- 차구매적분 --}}
          </div>
          <div class="icon">
            <i class="ion ion-bag"></i>
          </div>
          <a href="{{ route(App\WebRoute::TRANSACTION_INDEX, ['type' => App\Utils\TransactionUtil::TYPE_RELEASED_FROM_PENDING]) }}" class="small-box-footer">查看明细  <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>


    <div class="col-lg-3 col-md-6 col-6">
        <!-- small box -->
        <div class="small-box bg-info">
          <div class="inner">
            <h5>
                {{ auth()->user()->pending }}
            </h5>

            <div class="text-sm">奖金累计</div>
          </div>
          <div class="icon">
            <i class="ion ion-bag"></i>
          </div>
          <a href="{{ route(App\WebRoute::TRANSACTION_INDEX, ['type' => App\Utils\TransactionUtil::TYPE_PENDDING]) }}" class="small-box-footer">查看明细  <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>

    <!-- ./col -->
    <div class="col-lg-3 col-md-6 col-6">
      <!-- small box -->
      <div class="small-box bg-warning">
        <div class="inner">
          <h5>
              {{ auth()->user()->invite_codes()->count() }}
              /
              {{ $acceptedCount }}
          </h5>

          <div class="text-sm">总 / 已注册</div>
        </div>
        <div class="icon">
          <i class="ion ion-person-add"></i>
        </div>
        <a href="{{ route(App\WebRoute::CODE_INDEX) }}" class="small-box-footer">查看明细  <i class="fas fa-arrow-circle-right"></i></a>
      </div>
    </div>
  </div>
@endsection
