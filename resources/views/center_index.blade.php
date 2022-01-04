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
    {{-- @if(auth()->user()->center->approved ?? false) --}}
        <div>
            <div class="card">
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>注册编码</th>
                                <th>注册姓名</th>
                                <th>推荐人编码</th>
                                <th>注册时间</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($allUsers as $user)
                                <tr>
                                    <td>{{ $user->name ?? '' }}</td>
                                    <td>{{ $user->username ?? '' }}</td>
                                    <td>{{ $user->owner->name ?? '' }}</td>
                                    <td>{{ $user->created_at ?? '' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    {{-- @else
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h5><i class="icon fas fa-ban"></i> 错误信息</h5>
            非报单中心不能操作
        </div>
    @endif --}}
@endsection
