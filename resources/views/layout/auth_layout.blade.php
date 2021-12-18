@extends('layout.app_layout')


@section('content')

    <div class="col d-flex align-items-center">
        <div class="card card-body mt-5">
            @include('partials.validation-error')
            @include('flash::message')

            @yield('form-content')
        </div>
    </div>
@endsection
