@extends('layout.app_layout')

@section('content-header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h2>修改密码</h2>
            </div>
        </div>
    </div>
@endsection

@section('content')
<div>
    <div class="card">

        <div class="card-body">
            <form id="password_form" method="POST" action="{{ route(App\WebRoute::AUTH_RESET_PASSWORD_POST) }}">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="old_password">原始登录密码</label>
                        <input class="form-control" name="old_password" id="old_password">
                    </div>
                    <div class="form-group">
                        <label for="password">新的登录密码</label>
                        <input class="form-control" name="password" id="password">
                    </div>
                    <div class="form-group">
                        <label for="confirm_password">确认登录密码</label>
                        <input type="text" name="confirm_password" class="form-control" id="confirm_password">
                    </div>
                    <button type="submit" class="btn btn-primary float-right">更改密码</button>
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
      $('#password_form').validate({
        rules: {
          old_password: {
            required: true,
          },
          password: {
            required: true,
          },
          confirm_password: {
            equalTo: '#password'
          },
        },
        messages: {
            old_password: {
                required: '请输入原始登录密码',
            },
            password: {
                required: '请输入新的登录密码',
            },
            confirm_password: {
                equalTo: '两次输入密码不一致'
            },
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
