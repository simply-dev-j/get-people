@extends('layout.app_layout')

@section('content')

@include('flash::message')

<div class="col-12">

    @foreach ($codes as $code)
        <div class="row">
            @include('partials.single-code', ['code' => $code])
        </div>
    @endforeach

    {{ $codes->links('vendor.pagination.default') }}

</div>

@endsection
