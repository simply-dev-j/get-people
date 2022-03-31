@extends('layout.app_layout')

@section('content-header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h2>报单列表</h2>
            </div>
        </div>
    </div>
@endsection

@section('content')
<div>
    <div class="card">

        <div class="card-header">
            <div class="callout callout-info bg-primary">
                <p>推荐会员：总共有 {{ $people->total() }} 条记录</p>
            </div>

            <div class="text-right">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-user-register">
                    添加用户
                </button>
            </div>

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
                                @include('partials.form.user_register_form', [
                                    'showCodeInput' => false,
                                    'subCompanies' => $subCompanies,
                                    'showVerifier' => $subCompanies->count() > 0
                                    ])
                            </form>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">取消</button>
                            <button type="button" class="btn btn-primary" role="form-submit" target-form="#user-form">确认</button>
                        </div>
                    </div>
                </div>
            </div>

            @if (App\Utils\UserUtil::isAdmin())
                <form  id="company_select_form" method="GET" action="{{ route(App\WebRoute::TEAM_INDEX) }}">
                    <div class="form-group">
                        <label></label>
                        <select class="form-control select2" id="company_id" name="company_id">
                            <option class="d-none" disabled selected >请选择会员</option>
                            <option value
                                @if (Request::get('company_id') == null)
                                    selected
                                @endif>
                                全部
                            </option>
                            @foreach ($subCompanies as $company)
                                <option value="{{$company->id}}"
                                    @if (Request::get('company_id') == $company->id)
                                        selected
                                    @endif>
                                    {{$company->name}} ({{$company->username}})
                                </option>
                            @endforeach
                        </select>
                    </div>
                </form>
            @endif
        </div>

        <div class="card-body">



            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>报单账号</th>
                        <th>报单姓名</th>
                        <th>推荐人</th>
                        <th>手机号码</th>
                        <th>注册时间</th>
                        <th>激活</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($people as $i => $member)
                        <tr>
                            <td>
                                {{ $people->perPage() * ($people->currentPage()-1) + ($i + 1) }}
                            </td>
                            <td>{{ $member->name }}</td>
                            <td>{{ $member->username }}</td>
                            <td>{{ $member->owner->username }} ({{ $member->owner->name }})</td>
                            <td>{{ $member->phone }}</td>
                            <td>{{ $member->created_at }}</td>
                            <td>
                                @if (!$member->active)
                                    <div class="btn-group">
                                        <a class="btn btn-primary btn-sm" href="#" data-toggle="modal" data-target="#modal-user-register-special"
                                            onclick="document.getElementById('selected_user').value={{$member->id}}">
                                            激活
                                        </a>
                                        {{-- <a class="btn btn-primary btn-sm" href="#" data-toggle="modal" data-target="#modal-user-active"
                                            onclick="document.getElementById('selected_user_for_active').value={{$member->id}}">激活</a> --}}
                                        <a class="btn btn-danger btn-sm" href="#" role="form-submit" target-form="#member_delete_form_{{$member->id}}">删除</a>

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

    <div class="modal fade" id="modal-user-register-special">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">添加到另一个网体</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @if ($isAcceptable)
                    <div class="modal-body">
                        @if (!App\Utils\SecurityUtil::IS_AVAILABLE(App\Utils\SecurityUtil::SECURITY_CASE_USER_ACTIVATION))
                            <div class="alert alert-danger">
                                <i class="icon fas fa-ban"></i>
                                系统锁定，24小时后自动解锁
                            </div>
                        @else
                            <div class="card">
                                <div class="card-body">
                                    <form id="user-special-net-form" method="POST" action="{{ route(App\WebRoute::ADMIN_USER_ACTIVATE_IN_SPEC_NET) }}">
                                        @csrf
                                        <input type="hidden" id="selected_user"  name="user">
                                        <div class="input-group mt-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1">
                                                    <i class="fa fa-key"></i>
                                                </span>
                                            </div>
                                            <input name="security_code" id="security_code" class="form-control form-input"
                                            placeholder="{{ __(App\LocaleConstants::FORM_BASE.App\LocaleConstants::FORM_AUTH_SECURITY_CODE) }}">
                                        </div>
                                        <input class="custom-control-input" type="radio" id="netRadio0" name="selected_net" value="0">
                                        <table class="table table-bordered mt-5">
                                            <thead>
                                                <tr>
                                                    <th colspan="3">
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text" id="basic-addon1">
                                                                    <i class="fas fa-search"></i>
                                                                </span>
                                                            </div>
                                                            <input type="text" class="form-control form-input" id="group-search">
                                                        </div>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($nets as $net)
                                                <tr class="group-table-row" value="{{ $net->user->username }} {{ $net->user->name }}">
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
                        @endif
                    </div>
                @else
                    <div class="modal-body">
                        <div class="alert alert-danger">
                            注册积分不足
                        </div>
                    </div>
                @endif
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
                @if ($isAcceptable)
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
                @else
                    <div class="modal-body">
                        <div class="alert alert-danger">
                            注册积分不足
                        </div>
                    </div>
                @endif
            </div>
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
          verifier_id: {
              required: true
          }
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
            verifier_id: {
                required: '请选择分公司'
            }
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
            security_code: {
                required: true,
            },
        },
        messages: {
            selected_net: {
                required: "请选择网体.",
            },
            security_code: {
                required: "请输入安全密码.",
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

    $(document).ready(function() {
        $('#group-search').on('change, keyup', function(e) {

            const query = $(this).val();

            $('.group-table-row').each(function(ele) {
                const value = $(this).attr('value');

                if (value.includes(query)) {
                    $(this).removeClass('d-none')
                } else {
                    $(this).addClass('d-none')
                    $(this).find('input').prop('checked', false)
                }

            })
        })

        $('#company_id').on('change', function() {
            $('#company_select_form').submit();
        })
    })
</script>
@endpush
