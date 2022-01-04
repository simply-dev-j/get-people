@extends('layout.app_layout')

@section('content-header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h2>奖金提现</h2>
            </div>
        </div>
    </div>
@endsection

@section('content')
<div class="alert alert-danger alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <h5><i class="icon fas fa-ban"></i> 错误信息</h5>
    请先完善你的银行信息
  </div>
@endsection


