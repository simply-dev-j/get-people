@extends('layout.app_layout')

@section('content-header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h2>资金转账</h2>
            </div>
        </div>
    </div>
@endsection

@section('custom-message')
    @if (!App\Utils\SecurityUtil::IS_AVAILABLE(App\Utils\SecurityUtil::SECURITY_CASE_FUND_TRANSFER))
        <div class="alert alert-danger">
            <i class="icon fas fa-ban"></i>
            系统锁定，24小时后自动解锁
        </div>
    @endif
@endsection

@section('content')
<div>
    <div class="card">

        <div class="card-body">
            <form id="fund_form" method="POST">

                @if (!App\Utils\SecurityUtil::IS_AVAILABLE(App\Utils\SecurityUtil::SECURITY_CASE_FUND_TRANSFER))
                    <fieldset disabled>
                @endif

                @csrf
                <div class="card-body">

                    <div class="form-group">
                        <label>注册积分余额</label>
                        <input type="text"class="form-control" readonly value="{{ auth()->user()->withdrawn }}">
                    </div>
                    <div class="form-group">
                        <label for="transfer_receiver">对方会员账号</label>
                        <input type="text" name="transfer_receiver" class="form-control" id="transfer_receiver" value="{{ old('transfer_receiver') }}">
                    </div>
                    <div class="form-group">
                        <label for="transfer_amount">要转账的金额</label>
                        <input type="text" name="transfer_amount" class="form-control" id="transfer_amount" value="{{ old('transfer_amount') }}">
                    </div>
                    <div class="form-group">
                        <label for="security_code">安全码</label>
                        <input type="text" name="security_code" class="form-control" id="security_code" value="{{ old('security_code') }}">
                    </div>
                    <button type="submit" class="btn btn-primary float-right">确认转账</button>
                </div>

                @if (!App\Utils\SecurityUtil::IS_AVAILABLE(App\Utils\SecurityUtil::SECURITY_CASE_FUND_TRANSFER))
                    </fieldset>
                @endif
            </form>
        </div>

    </div>
</div>

@endsection

@push('post-header-scripts')
    <script src="{{ asset('/js/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('/js/plugins/jquery-validation/additional-methods.min.js') }}"></script>
@endpush

@push('post-body-scripts')
<script>
    $(function () {
      $('#fund_form').validate({
        rules: {
            transfer_receiver: {
                required: true,
            },
            transfer_amount: {
                required: true,
                max: {{ auth()->user()->withdrawn }},
                min: 0
            },
            security_code: {
                required: true
            }
        },
        messages: {
            transfer_receiver: {
                required: ' 请输入对方会员账号',
            },
            transfer_amount: {
                required: ' 请输入转账金额',
                max: ' 可转账金额不足',
                min: ' 可转账金额不足'
            },
            security_code: {
                required: '请输入安全码'
            }
        },
        errorElement: 'span',
        errorPlacement: function (error, element) {
          error.addClass('invalid-feedback');
          element.closest('.form-group').append(error);
        },
        highlight: function (element, errorClass, validClass) {
          $(element).addClass('is-invalid');
        },
        unhighlight: function (element, errorClass, validClass) {
          $(element).removeClass('is-invalid');
        },
      });
    });
    </script>
@endpush


