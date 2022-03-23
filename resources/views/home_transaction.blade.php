@extends('layout.app_layout')

@section('content-header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h2>
                    @switch($type)
                        @case(App\Utils\TransactionUtil::TYPE_WITHDRAWN)
                            注册积分
                            @break
                        @case(App\Utils\TransactionUtil::TYPE_RELEASE)
                            购物积分
                            @break
                        @case(App\Utils\TransactionUtil::TYPE_RELEASED_FROM_PENDING)
                            购车积分
                            @break
                        @case(App\Utils\TransactionUtil::TYPE_PENDDING)
                            奖金累计
                            @break

                        @default

                    @endswitch
                </h2>
            </div>
        </div>
    </div>
@endsection

@section('content')

<div class="card">
    <div class="card-header">
        <div class="callout callout-info bg-primary">
            <p>查询统计：总共有 {{ $transactions->total() }} 条记录</p>
        </div>
        @if($type == App\Utils\TransactionUtil::TYPE_RELEASED_FROM_PENDING)
            @if (auth()->user()->is_admin)
                <a type="button" class="btn btn-primary float-right" href="{{ route(App\WebRoute::FUND_TRANSFER_REQUEST_INDEX) }}">
                    审核
                </a>
            @endif

            @if ($needToFundTransferPermission)
                <a type="button" class="btn btn-primary float-right" href="{{ route(App\WebRoute::FUND_TRANSFER_APPROVAL_REQUEST) }}">
                    解冻申请
                </a>
            @endif
        @endif
    </div>

    <div class="card-body">

        <table class="table table-bordered mt-2">
            <thead>
                <tr>
                    <th>记录说明</th>
                    <th>积分变动</th>
                    <th>当前积分</th>
                    <th>发生时间</th>
                </tr>
            </thead>
            <tbody>

                @foreach ($transactions as $transaction)
                    <tr>
                        <td>
                            <div class="d-flex">
                                <div>
                                    @switch($transaction->money_type)
                                        @case(App\Utils\TransactionUtil::TRANSACTION_MONEY_BY_REGISTRATION_OF_ONE)
                                        购物积分 :
                                            @break
                                        @case(App\Utils\TransactionUtil::TRANSACTION_MONEY_BY_REGISTRATION_OF_TWO)
                                        登录奖金 :
                                            @break
                                        @case(App\Utils\TransactionUtil::TRANSACTION_MONEY_BY_TWO_LEAVE)
                                        登录奖金转换成购车积分 :
                                            @break
                                        @case(App\Utils\TransactionUtil::TRANSACTION_MONEY_BY_MOVE_NET)
                                        离队奖金转换成购物积分
                                            @break
                                        @case(App\Utils\TransactionUtil::TRANSACTION_MONEY_BY_MOVE_NET_CROSS)
                                        登录奖金转换成购车积分 :
                                            @break
                                        @case(App\Utils\TransactionUtil::TRANSACTION_MONEY_RELEASE_FROM_PENDING_TO_RELEASE)
                                        购车积分转换成购物积分
                                            @break
                                        @case(App\Utils\TransactionUtil::TRANSACTION_MONEY_RELEASE_TO_WITHDRAWN)
                                        购物积分转换成注册积分
                                            @break
                                        @case(App\Utils\TransactionUtil::TRANSACTION_MONEY_WITHDRAWN_SEND)
                                        注册积分转给分公司 :
                                            @break
                                        @case(App\Utils\TransactionUtil::TRANSACTION_MONEY_WITHDRAWN_RECEIVE)
                                        从用户接受注册积分 :
                                            @break
                                        @case(App\Utils\TransactionUtil::TRANSACTION_MONEY_BY_REGISTRATION_OF_ONE_FOR_ROOT_WITHDRAWN)
                                        注册积分 :
                                            @break
                                        @case(App\Utils\TransactionUtil::TRANSACTION_MONEY_BY_REGISTRATION_OF_ONE_FOR_ROOT_RELEASED)
                                        购物积分 :
                                            @break
                                        @case(App\Utils\TransactionUtil::TRANSACTION_MONEY_BY_ACCEPT_FUND_TRANSFER_REQUEST_RELEASED_FROM_PENDING)
                                        购车积分 :
                                            @break
                                        @case(App\Utils\TransactionUtil::TRANSACTION_MONEY_BY_ACCEPT_FUND_TRANSFER_REQUEST_WITHDRAWN)
                                        购车积分 :
                                            @break
                                        @case(App\Utils\TransactionUtil::TRANSACTION_MONEY_ADJUST_BY_ROOT_WITHDRAWN)
                                        注册积分 :
                                            @break
                                        @case(App\Utils\TransactionUtil::TRANSACTION_MONEY_ADJUST_BY_ROOT_RELEASED)
                                        购物积分 :
                                            @break
                                        @case(App\Utils\TransactionUtil::TRANSACTION_MONEY_ADJUST_BY_ROOT_RELEASED_FROM_PEDNING)
                                        购车积分 :
                                            @break
                                        @default

                                    @endswitch

                                </div>
                                <div>
                                    <div>{{ $transaction->reference_user->name ??  ''}}</div>
                                    <div>{{ $transaction->reference_user2->name ??  ''}}</div>
                                </div>
                            </div>

                        </td>
                        <td>{{ $transaction->amount > 0 ? '+' : '' }}{{ $transaction->amount }}</td>
                        <td>
                            {{ $transaction->current_amount }}
                        </td>
                        <td>{{ $transaction->created_at }}</td>
                    </tr>
                @endforeach

            </tbody>
        </table>


    </div>

    <div class="card-footer clearfix">
        {{ $transactions->links('partials.pagination') }}
    </div>
</div>

@endsection
