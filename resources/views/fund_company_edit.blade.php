@extends('layout.app_layout')

@section('content-header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h2>积分变更</h2>
            </div>
        </div>
    </div>
@endsection

@section('custom-message')
    @if (!App\Utils\SecurityUtil::IS_AVAILABLE(App\Utils\SecurityUtil::SECURITY_CASE_FUND_COMPANY_EDIT))
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
            <form id="fund_form" method="POST" action="{{ route(App\WebRoute::FUND_COMPANY_EDIT_POST) }}">

                @if (!App\Utils\SecurityUtil::IS_AVAILABLE(App\Utils\SecurityUtil::SECURITY_CASE_FUND_COMPANY_EDIT))
                    <fieldset disabled>
                @endif

                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label>分公司</label>
                        <select class="form-control select2" name="company_id" id="company_id">
                            <option class="d-none" disabled selected>请选择分公司</option>
                            @foreach ($subCompanies as $subCompany)
                                <option value="{{$subCompany->id}}">{{$subCompany->name}} ({{$subCompany->username}})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>积分类型</label>
                        <select class="form-control" name="fund_type" id="fund_type">
                            <option class="d-none" disabled selected>请选择积分类型</option>
                            <option value="{{App\Utils\TransactionUtil::TYPE_WITHDRAWN}}">注册积分</option>
                            <option value="{{App\Utils\TransactionUtil::TYPE_RELEASE}}">购物积分</option>
                            <option value="{{App\Utils\TransactionUtil::TYPE_RELEASED_FROM_PENDING}}">购车积分</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>积分余额</label>
                        <input type="text"class="form-control" readonly value="0" id="max-amount">
                    </div>
                    <div class="form-group">
                        <label for="transfer_amount">变更额</label>
                        <input type="text" name="transfer_amount" class="form-control" id="transfer_amount" value="{{ old('transfer_amount') }}">
                    </div>
                    <div class="form-group">
                        <label for="security_code">安全码</label>
                        <input type="text" name="security_code" class="form-control" id="security_code" value="{{ old('security_code') }}">
                    </div>
                    <button type="submit" class="btn btn-primary float-right">确认</button>
                </div>

                @if (!App\Utils\SecurityUtil::IS_AVAILABLE(App\Utils\SecurityUtil::SECURITY_CASE_FUND_COMPANY_EDIT))
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
            company_id: {
                required: true,
            },
            transfer_amount: {
                required: true,
                min: function() {
                    return -(parseInt($('#max-amount').val()));
                }
            },
            fund_type: {
                required: true
            },
            security_code: {
                required: true
            }
        },
        messages: {
            company_id: {
                required: '请选择分公司',
            },
            transfer_amount: {
                required: ' 请输入积分额度',
                max: ' 可积分额度不足',
                min: ' 可积分额度不足'
            },
            fund_type: {
                required: '请选择积分类型'
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
        const updateMaxVal = function() {
            const companyId = $('#company_id').val()
            const fundType = $('#fund_type').val()

            console.log(companyId, fundType)
            var value = 0;

            if (fundType == {{ App\Utils\TransactionUtil::TYPE_WITHDRAWN }}) {
                if (companyId == 2) {
                    value = {{$subCompanies[0]->withdrawn ?? 0}}
                } else if(companyId == 3) {
                    value = {{$subCompanies[1]->withdrawn ?? 0}}
                }
            } else if (fundType == {{ App\Utils\TransactionUtil::TYPE_RELEASE }}) {
                if (companyId == 2) {
                    value = {{$subCompanies[0]->released ?? 0}}
                } else if(companyId == 3) {
                    value = {{$subCompanies[1]->released ?? 0}}
                }
            } else if (fundType == {{ App\Utils\TransactionUtil::TYPE_RELEASED_FROM_PENDING }}) {
                if (companyId == 2) {
                    value = {{$subCompanies[0]->released_from_pending ?? 0}}
                } else if(companyId == 3) {
                    value = {{$subCompanies[1]->released_from_pending ?? 0}}
                }
            }

            $('#max-amount').val(value)
        }

        $('#company_id, #fund_type').on('change', function(e) {
            updateMaxVal()
        })
    })
</script>
@endpush
