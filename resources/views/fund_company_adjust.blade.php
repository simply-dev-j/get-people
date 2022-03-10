@extends('layout.app_layout')

@section('content-header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h2>积分收回</h2>
            </div>
        </div>
    </div>
@endsection

@section('custom-message')
    @if (!App\Utils\SecurityUtil::IS_AVAILABLE(App\Utils\SecurityUtil::SECURITY_CASE_FUND_COMPANY_ADJUST))
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
            <form id="fund_form" method="POST" action="{{ route(App\WebRoute::FUND_COMPANY_ADJUST_POST) }}">

                @if (!App\Utils\SecurityUtil::IS_AVAILABLE(App\Utils\SecurityUtil::SECURITY_CASE_FUND_COMPANY_ADJUST))
                    <fieldset disabled>
                @endif

                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label>会员</label>
                        <select class="form-control select2" name="member_id" id="member_id">
                            <option class="d-none" disabled selected
                                withdrawn="0"
                                released="0"
                                released_from_pending="0" >
                                请选择会员
                            </option>
                            @foreach ($members as $member)
                                <option value="{{$member->id}}"
                                    withdrawn="{{$member->withdrawn}}"
                                    released="{{$member->released}}"
                                    released_from_pending="{{$member->released_from_pending}}">
                                    {{$member->name}} ({{$member->username}})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>积分种类</label>
                        <select class="form-control" name="fund_type" id="fund_type">
                            <option class="d-none" disabled selected>请选择积分种类</option>
                            <option value="{{App\Utils\TransactionUtil::TYPE_WITHDRAWN}}">注册积分</option>
                            <option value="{{App\Utils\TransactionUtil::TYPE_RELEASE}}">购物积分</option>
                            <option value="{{App\Utils\TransactionUtil::TYPE_RELEASED_FROM_PENDING}}">购车积分</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>注册积分余额</label>
                        <input type="text"class="form-control" readonly value="0" id="max-amount">
                    </div>
                    <div class="form-group">
                        <label for="transfer_amount">转移额</label>
                        <input type="text" name="transfer_amount" class="form-control" id="transfer_amount" value="{{ old('transfer_amount') }}">
                    </div>
                    <div class="form-group">
                        <label for="security_code">安全码</label>
                        <input type="text" name="security_code" class="form-control" id="security_code" value="{{ old('security_code') }}">
                    </div>
                    <button type="submit" class="btn btn-primary float-right">确认</button>
                </div>

                @if (!App\Utils\SecurityUtil::IS_AVAILABLE(App\Utils\SecurityUtil::SECURITY_CASE_FUND_COMPANY_ADJUST))
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
    <!-- Select2 -->
    <script src="{{ asset('/js/plugins/select2/js/select2.full.min.js')}}"></script>
@endpush

@push('post-styles')
    <link rel="stylesheet" href="{{ asset('/css/plugins/select2/css/select2.min.css')}}">
    {{-- <link rel="stylesheet" href="{{ asset('/css/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}"> --}}
@endpush

@push('post-body-scripts')
<script>
    $(function () {
        $('.select2').select2()

        $('#fund_form').validate({
            rules: {
                member_id: {
                    required: true,
                },
                fund_type: {
                    required: true
                },
                transfer_amount: {
                    required: true,
                    max: function() {
                        return parseInt($('#max-amount').val());
                    },
                    min: 0
                },
                security_code: {
                    required: true
                }
            },
            messages: {
                member_id: {
                    required: '请选择会员',
                },
                fund_type: {
                    required: '请选择积分种类'
                },
                transfer_amount: {
                    required: ' 请输入积分额度',
                    max: ' 可积分额度不足',
                    min: ' 可积分额度不足'
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
            }
        });
    });
</script>

<script>
    $(document).ready(function(e) {
        $('#member_id, #fund_type').on('change', function(e) {

            const type = $('#fund_type').val()

            var maxAmount = 0;

            switch(type) {
                case "{{App\Utils\TransactionUtil::TYPE_WITHDRAWN}}":
                    maxAmount = $('#member_id').find(":selected").attr('withdrawn');
                    break;
                case "{{App\Utils\TransactionUtil::TYPE_RELEASE}}":
                    maxAmount = $('#member_id').find(":selected").attr('released');
                    break;
                case "{{App\Utils\TransactionUtil::TYPE_RELEASED_FROM_PENDING}}":
                    maxAmount = $('#member_id').find(":selected").attr('released_from_pending');
                    break;
                default:
                    maxAmount = 0
            }

            $('#max-amount').val(maxAmount)
        })
    })
</script>
@endpush
