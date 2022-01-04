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

        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>会员账号</th>
                        <th>会员姓名</th>
                        <th>手机号码</th>
                        <th>注册时间</th>
                        <th>复投次数</th>
                        <th>复投情况</th>
                        <th>积分所属</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($people as $member)
                        <tr>
                            <td>{{ $member->name }}</td>
                            <td>{{ $member->username }}</td>
                            <td>{{ $member->phone }}</td>
                            <td>{{ $member->created_at }}</td>
                            <td>{{ $member->step }}</td>
                            <td>
                                <a href="{{ route(App\WebRoute::TEAM_NET, $member) }}">点击查看</a>
                            </td>
                            <td>
                                {{ $member->money_by_invitation }}
                                /
                                {{ $member->money_by_step }}
                                /
                                {{ $member->money_by_child_release }}
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
</div>
@endsection
