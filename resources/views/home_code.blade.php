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
<div class="card">
    <div class="card-header">
        <div class="callout callout-info bg-primary">
            <p>推荐会员：总共有 {{ $people->total() }} 条记录</p>
        </div>

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
    </div>

    <div class="card-body">

        <table class="table table-bordered mt-2">
            <thead>
                <tr>
                    <th>#</th>
                    <th>注册账号</th>
                    <th>注册姓名</th>
                    <th>手机号码</th>
                    <th>网体排列</th>
                    <th>复投情况</th>
                    <th>资格所属</th>
                    <th>注册时间</th>
                    {{-- <th>#</th> --}}
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
                        <td>{{ $member->phone }}</td>
                        <td>
                            @if($member->active)
                                <a href="{{ route(App\WebRoute::TEAM_NET, $member) }}">点击查看</a>
                            @endif
                        </td>
                        <td>
                            @if($member->active)
                                {{ $member->step }}
                            @endif
                        </td>
                        <td>
                            @if($member->active)
                                @php
                                    $refOwnerEntries = App\Utils\PeopleUtil::getRefOwners($member);
                                @endphp

                                @foreach ($refOwnerEntries as $entry)
                                <div>
                                    <a href="{{ route(App\WebRoute::TEAM_NET, ['user' => $entry->user, 'showMember' => true]) }}">
                                        {{ $entry->user->name ?? '' }}({{ $entry->user->username ?? '' }})
                                    </a>
                                </div>
                                @endforeach
                            @endif
                        </td>
                        <td>{{ $member->created_at }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>


    </div>

    <div class="card-footer">
        {{ $people->links('partials.pagination') }}
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
</script>
@endpush
