@extends('layout.app_layout')

@section('content-header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h2>{{ __(App\LocaleConstants::FORM_BASE.App\LocaleConstants::FORM_ADMIN_COMPANY_MANAGEMENT) }}</h2>
            </div>
        </div>
    </div>
@endsection

@section('content')
<div>
    <div class="card">

        <div class="card-header">
            <div class="callout callout-info bg-primary">
                <p>推荐会员：总共有 {{ $companies->total() }} 条记录</p>
            </div>

            <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#modal-company-add">
                {{ __(App\LocaleConstants::FORM_BASE.App\LocaleConstants::FORM_ADMIN_COMPANY_ADD) }}
            </button>

            <div class="modal fade" id="modal-company-add">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">{{ __(App\LocaleConstants::FORM_BASE.App\LocaleConstants::FORM_ADMIN_COMPANY_ADD) }}</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            @if (App\Utils\SecurityUtil::IS_AVAILABLE(App\Utils\SecurityUtil::SECURITY_CASE_COMPANY_PROMOTION))
                                <form id="company_form" method="POST" action="{{ route(App\WebRoute::ADMIN_COMPANY_PROMOTE) }}">
                                    @csrf
                                    <div class="form-group">
                                        <label>会员</label>
                                        <select class="select2 form-control w-100" name="user_id" id="user_id">
                                            <option class="d-none" disabled selected>请选择会员</option>
                                            @foreach ($users as $user)
                                                <option value="{{$user->id}}">{{$user->name}} ({{$user->username}})</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="security_code">安全码</label>
                                        <input type="text" name="security_code" class="form-control" id="security_code" value="{{ old('security_code') }}">
                                    </div>
                                </form>
                            @else
                                <div class="alert alert-danger">
                                    <i class="icon fas fa-ban"></i>
                                    系统锁定，24小时后自动解锁
                                </div>
                            @endif
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">取消</button>
                            <button type="button" class="btn btn-primary" role="form-submit" target-form="#company_form">确认</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-body">

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>报单账号</th>
                        <th>报单姓名</th>
                        <th>注册时间</th>
                        <th>升级时间</th>
                        @if (App\Utils\UserUtil::isAdmin())
                            <th>报单注册明细</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach ($companies as $i => $company)
                        <tr>
                            <td>
                                {{ $companies->perPage() * ($companies->currentPage()-1) + ($i + 1) }}
                            </td>
                            <td>{{ $company->name }}</td>
                            <td>{{ $company->username }}</td>
                            <td>{{ $company->created_at }}</td>
                            <td>{{ $company->company_req_date }}</td>
                            @if (App\Utils\UserUtil::isAdmin())
                                <td>
                                    <a href="{{ route(App\WebRoute::TEAM_INDEX, ['company_id' => $company->id]) }}">
                                        点击查看
                                    </a>
                                </td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- /.card-body -->
        <div class="card-footer clearfix">
            {{ $companies->links('partials.pagination') }}
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
    $(function() {
        $('.select2').select2()

        $('#company_form').validate({
        rules: {
            user_id: {
                required: true,
            },
            security_code: {
                required: true
            }
        },
        messages: {
            user_id: {
                required: '请选择会员',
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
@endpush
