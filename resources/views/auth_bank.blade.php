@extends('layout.app_layout')

@section('content-header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h2>银行信息</h2>
            </div>
        </div>
    </div>
@endsection

@section('content')
<div>
    <div class="card">

        <div class="card-body">
            <form id="center_form" method="POST" action="{{ route(App\WebRoute::AUTH_BANK_POST) }}">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label>报单姓名</label>
                        <input class="form-control" readonly value="{{ auth()->user()->username }}">
                    </div>
                    <div class="form-group">
                        <label for="bank">银行姓名</label>
                        <select class="custom-select" id="bank" name="bank">
                            <option disabled class="d-none" value=0 selected>请选择收款方式</option>
                            @foreach (App\BankConfig::SUPPORTED_BANKS as $bank)
                                <option value="{{ $bank['value'] }}"
                                {{ $bank['value'] == auth()->user()->bank ? 'selected' : '' }}>
                                    {{ $bank['title'] }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="bank_number">银行卡号</label>
                        <input class="form-control" name="bank_number" id="bank_number" value="{{ old('bank_number', auth()->user()->bank_number) }}">
                    </div>
                    <div class="form-group">
                        <label for="bank_address">开户行地址</label>
                        <input type="text" name="bank_address" class="form-control" id="bank_address" value="{{ old('bank_address', auth()->user()->bank_address) }}">
                    </div>
                    <button type="submit" class="btn btn-primary float-right">确定绑定</button>
                </div>
            </form>
        </div>

    </div>
</div>

@endsection

@push('post-header-scripts')
    <script src="{{ asset('/js/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('/js/plugins/jquery-validation/additional-methods.min.js') }}"></script>
@endpush



