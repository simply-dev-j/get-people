@extends('layout.app_layout')

@section('content-header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h2>推荐列表</h2>
            </div>
        </div>
    </div>
@endsection

@section('content')
<div>
    <div class="card">

        <div class="card-header">
            <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#modal-user-register">
                添加用户
            </button>

            <div class="modal fade" id="modal-user-register">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">添加用户</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="user-form" method="POST" action="{{ route(App\WebRoute::ADMIN_USER_CREATE) }}">
                                @csrf
                                @include('partials.form.user_register_form', ['showCodeInput' => false])
                            </form>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">取消</button>
                            <button type="button" class="btn btn-primary" role="form-submit" target-form="#user-form">确认</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>会员账号</th>
                        <th>会员姓名</th>
                        <th>手机号码</th>
                        <th>注册时间</th>
                        <th>激活</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($people as $member)
                        <tr>
                            <td>{{ $member->name }}</td>
                            <td>{{ $member->username }}</td>
                            <td>{{ $member->phone }}</td>
                            <td>{{ $member->created_at }}</td>
                            <td>
                                @if (!$member->active)
                                    <div class="btn-group">
                                        <a class="btn btn-primary btn-sm" href="#" data-toggle="modal" data-target="#modal-user-active"
                                            onclick="document.getElementById('selected_user_for_active').value={{$member->id}}">激活</a>
                                        <a class="btn btn-danger btn-sm" href="#" role="form-submit" target-form="#member_delete_form_{{$member->id}}">删除</a>
                                        <a class="btn btn-secondary btn-sm" href="#" data-toggle="modal" data-target="#modal-user-register-special"
                                            onclick="document.getElementById('selected_user').value={{$member->id}}">
                                            选择分组
                                        </a>
                                    </div>



                                    <form action="{{ route(App\WebRoute::ADMIN_USER_DELETE, [$member]) }}" method="POST" id="member_delete_form_{{$member->id}}">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                @else
                                    {{-- <a class="btn btn-danger btn-sm" href="{{ route(App\WebRoute::ADMIN_USER_INACTIVATE, [$member]) }}">Inactivate</a> --}}
                                    <i class="fa fa-check text-success"></i>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- /.card-body -->
        <div class="card-footer clearfix">
            {{ $people->links('partials.pagination') }}
        </div>
    </div>

    {{-- Modal --}}
    <div class="modal fade" id="modal-user-register-special">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">添加到另一个网体</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card">
                        <div class="card-body">
                            <form id="user-special-net-form" method="POST" action="{{ route(App\WebRoute::ADMIN_USER_ACTIVATE_IN_SPEC_NET) }}">
                                @csrf
                                <input type="hidden" id="selected_user"  name="user">
                                <table class="table table-bordered">
                                    {{-- <thead>
                                        <tr>
                                            <th></th>
                                            <th>User</th>
                                            <th></th>
                                        </tr>
                                    </thead> --}}
                                    <tbody>
                                        @foreach ($nets as $net)
                                        <tr>
                                            <td>
                                                <div class="custom-control custom-radio">
                                                    <input class="custom-control-input" type="radio" id="netRadio{{$net->id}}" name="selected_net" value="{{$net->id}}">
                                                    <label for="netRadio{{$net->id}}" class="custom-control-label"></label>
                                                </div>
                                            </td>
                                            <td>{{ $net->user->username }} ({{ $net->user->name }})</td>
                                            <td>
                                                @foreach (App\Utils\PeopleUtil::getNet($net->user) as $net_element)
                                                    <i class="fa fa-user" style="color: {{ isset($net_element)? 'blue' : 'lightgray' }}"></i>
                                                @endforeach
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">取消</button>
                    <button type="button" class="btn btn-primary" role="form-submit" target-form="#user-special-net-form">确认</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-user-active">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">激活</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="user-form-active" method="POST" action="{{ route(App\WebRoute::ADMIN_USER_ACTIVATE) }}">
                        @csrf
                        <input type="hidden" name="user" id="selected_user_for_active"/>
                        <div class="input-group mt-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">
                                    <i class="fa fa-key"></i>
                                </span>
                            </div>
                            <input name="security_code" id="security_code" class="form-control form-input"
                            placeholder="{{ __(App\LocaleConstants::FORM_BASE.App\LocaleConstants::FORM_AUTH_SECURITY_CODE) }}">
                        </div>
                    </form>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">取消</button>
                    <button type="button" class="btn btn-primary" role="form-submit" target-form="#user-form-active">确认</button>
                </div>
            </div>
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
      $('#user-form').validate({
        rules: {
          name: {
              required: true,
              remote: "{{ route(App\WebRoute::ADMIN_USER_VALIDATE_NAME) }}"
          },
          username: {
              required: true,
          },
          phone: {
              required: true,
          },
          id_number: {
              required: true,
          },
          security_code: {
              required: true,
          },
          password: {
              required: true,
          },
          confirm_password: {
            equalTo: '#password',
          },
        },
        messages: {
            name: {
                required: "用户名不能为空。",
                remote: "此名称已被占用。 请选择另一个"
            },
            username: {
                required: "账号不能为空。",
            },
            phone: {
                required: "手机不能为空。",
            },
            id_number: {
                required: "身份证号码不能为空。",
            },
            security_code: {
                required: "安全码不能为空。",
            },
            password: {
                required: "密码不能为空。",
            },
            confirm_password: {
                equalTo: '两次输入密码不一致'
            },
        },
        errorElement: 'span',
        errorPlacement: function (error, element) {
          error.addClass('invalid-feedback');
          element.closest('.input-group').append(error);
        },
        highlight: function (element, errorClass, validClass) {
          $(element).addClass('is-invalid');
        },
        unhighlight: function (element, errorClass, validClass) {
          $(element).removeClass('is-invalid');
        }
      });
    });

    $(function () {
      $('#user-special-net-form').validate({
        rules: {
            selected_net: {
                required: true,
            },

        },
        messages: {
            selected_net: {
                required: "请选择网体",
            },
        },
        errorElement: 'span',
        errorPlacement: function (error, element) {
          error.addClass('invalid-feedback');
          element.closest('form').append(error);
        },
        highlight: function (element, errorClass, validClass) {
          $(element).addClass('is-invalid');
        },
        unhighlight: function (element, errorClass, validClass) {
          $(element).removeClass('is-invalid');
        }
      });
    });

    $(function () {
      $('#user-form-active').validate({
        rules: {
            security_code: {
                required: true,
            },

        },
        messages: {
            security_code: {
                required: "请输入安全密码",
            },
        },
        errorElement: 'span',
        errorPlacement: function (error, element) {
          error.addClass('invalid-feedback');
          element.closest('.input-group').append(error);
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

