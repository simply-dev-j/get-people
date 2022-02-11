@extends('layout.app_layout')

@section('content-header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h2>解冻申请目录</h2>
            </div>
        </div>
    </div>
@endsection

@section('content')
<div>
    <div class="card">

        <div class="card-header">
            <div class="callout callout-info bg-primary">
                <p>查询统计：总共有 {{ $requests->total() }} 条记录</p>
            </div>
        </div>

        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>名称</th>
                        <th>时间</th>
                        <th>解冻</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($requests as $i => $request)
                        <tr>
                            <td>
                                {{ $requests->perPage() * ($requests->currentPage()-1) + ($i + 1) }}
                            </td>
                            <td>
                                {{ $request->username }} ({{ $request->name }})
                            </td>
                            <td>
                                {{ $request->fund_transfer_req_date }}
                            </td>
                            <td>
                                @if ($request->fund_transfer_status == 1)
                                    <a type="button" class="btn btn-primary float-right" href="{{ route(App\WebRoute::FUND_TRANSFER_REQUEST_APPROVE, ['user' => $request]) }}">
                                        同意
                                    </a>
                                @elseif ($request->fund_transfer_status == 2)
                                    <i class="fa fa-check text-success"></i>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="card-footer clearfix">
            {{ $requests->links('partials.pagination') }}
        </div>
    </div>
</div>

@endsection

@push('post-header-scripts')
    <script src="{{ asset('/js/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('/js/plugins/jquery-validation/additional-methods.min.js') }}"></script>
@endpush

@push('post-body-scripts')

@endpush


