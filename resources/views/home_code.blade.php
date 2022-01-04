@extends('layout.app_layout')

@section('content')

<div class="card">
    <div class="card-header">
        <a class="btn btn-primary float-right" href="{{ route(App\WebRoute::CODE_CREATE) }}">生成推荐码</a>
    </div>

    <div class="card-body">

        <table class="table table-bordered mt-2">
            <thead>
                <tr>
                    <th>推荐码</th>
                    <th>创建于</th>
                    <th>用户名</th>
                    <th>账号</th>
                    <th>手机</th>
                    {{-- <th>#</th> --}}
                </tr>
            </thead>
            <tbody>
                @foreach ($codes as $code)
                    <tr>
                        <td> {{ $code->code }} </td>
                        <td> {{ $code->created_at }} </td>
                        <td> {{ $code->user->name ?? '' }} </td>
                        <td> {{ $code->user->username ?? '' }} </td>
                        <td> {{ $code->user->phone ?? '' }} </td>
                        {{-- <td>
                            @if (!$code->accepted)

                            @endif
                        </td> --}}
                    </tr>
                @endforeach
            </tbody>
        </table>


    </div>

    <div class="card-footer">
        {{ $codes->links('partials.pagination') }}
    </div>
</div>

@endsection
