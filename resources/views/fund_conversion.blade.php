@extends('layout.app_layout')

@section('content-header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h2>资金转换</h2>
            </div>
        </div>
    </div>
@endsection

@section('content')
<div>
    <div class="card">

        <div class="card-header">
            @if ($needToFundTransferPermission)
            <a type="button" class="btn btn-primary float-right" href="{{ route(App\WebRoute::FUND_TRANSFER_APPROVAL_REQUEST) }}">
                解冻申请
            </a>
            @endif
        </div>

        <div class="card-body">
            <form id="fund_form" method="POST">
                @csrf
                <div class="form-group">
                    <label>转换类型</label>
                    <select class="custom-select" id="conversion_method" name="conversion_method">
                        <option class="d-none" disabled selected value>请选择</option>
                        <option value="1" {{ $needToFundTransferPermission ? 'disabled' : ''}} class="{{ $needToFundTransferPermission ? 'text-danger' : ''}}">
                            购车积分转换成购物积分（税费20%）
                        </option>
                        <option value="2">
                            购物积分转换成注册积分（无税费）
                        </option>
                    </select>
                </div>
                <div class="form-group">
                    <label>账户余额</label>
                    <input type="text"class="form-control" readonly id="max_amount" value="0">
                </div>
                <div class="form-group">
                    <label for="conversion_amount">转换金额</label>
                    <input type="text" name="conversion_amount" class="form-control" id="conversion_amount" value="{{ old('conversion_amount') }}">
                </div>
                <button type="submit" class="btn btn-primary float-right">确认申请</button>
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
            conversion_method: {
                required: true
            },
          conversion_amount: {
            required: true,
            max: function() {
                return parseInt($('#max_amount').val());
            },
            min: 0,
            digits: true
          },
        },
        messages: {
            conversion_method: {
                required: '请选择转换类型'
            },
            conversion_amount: {
                required: "请输入转换金额",
                min: ' 账户余额不足',
                max: ' 账户余额不足'
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
    $(document).ready(function() {
        $('#conversion_method').on('change', function() {
            const method = $(this).val()
            if (method == 1) {
                $('#max_amount').val({{ auth()->user()->released_from_pending }})
            } else if(method == 2) {
                $('#max_amount').val({{ auth()->user()->released }})
            }
        })
    })
</script>
@endpush


