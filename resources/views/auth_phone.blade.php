@extends('layout.app_layout')

@section('content-header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h2>手机绑定</h2>
            </div>
        </div>
    </div>
@endsection

@section('content')
<div>
    <div class="card">

        <div class="card-body">
            <form id="center_form">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label>报单列表</label>
                        <input class="form-control" readonly value="{{ auth()->user()->name }}">
                    </div>
                    <div class="form-group">
                        <label>手机号</label>
                        <input class="form-control" readonly value="{{ auth()->user()->phone }}">
                    </div>
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



