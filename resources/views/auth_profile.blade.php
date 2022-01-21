@extends('layout.app_layout')

@section('content-header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h2>个人信息</h2>
            </div>
        </div>
    </div
@endsection

@section('content')
<div>
    <div class="card">

        <div class="card-body">
            <form id="center_form" method="POST" action="{{ route(App\WebRoute::AUTH_PROFILE_POST) }}">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label>报单列表</label>
                        <input class="form-control" readonly value="{{ auth()->user()->name }}">
                    </div>
                    <div class="form-group">
                        <label>报单姓名</label>
                        <input class="form-control" readonly value="{{ auth()->user()->username }}">
                    </div>
                    <div class="form-group">
                        <label>手机号码</label>
                        <input class="form-control" readonly value="{{ auth()->user()->phone }}">
                    </div>
                    <div class="form-group">
                        <label for="id_number">身份证号码</label>
                        <input type="text" name="id_number" class="form-control" id="id_number" value="{{ old('id_number', auth()->user()->id_number) }}">
                    </div>
                    <button type="submit" class="btn btn-primary float-right">确定</button>
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



