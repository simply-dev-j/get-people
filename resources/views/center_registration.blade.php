@extends('layout.app_layout')

@section('content-header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h2>报单中心</h2>
            </div>
        </div>
    </div>
@endsection

@section('content')
<div>
    <div class="card">

        <div class="card-body">
            <form id="center_form" method="POST" action="{{ route(App\WebRoute::CENTER_REGISTER_POST) }}">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label>申请会员</label>
                        <input class="form-control" readonly value="{{ auth()->user()->name }}">
                    </div>
                    <div class="form-group">
                        <label for="center_name">中心名称</label>
                        <input type="text" name="center_name" class="form-control" id="center_name" value="{{ old('center_name') }}">
                    </div>
                    <div class="form-group">
                        <label for="center_address">所在地区</label>
                        <input type="text" name="center_address" class="form-control" id="center_address" value="{{ old('center_address') }}">
                    </div>
                    <button type="submit" class="btn btn-primary float-right">确认申请</button>
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

@push('post-body-scripts')
<script>
    $(function () {
      $('#center_form').validate({
        rules: {
          center_name: {
            required: true,
          },
          center_address: {
            required: true
          },
        },
        messages: {
            center_name: {
            required: "请填写中心名称",
          },
          center_address: {
            required: "请填写所在地区",
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
@endpush


