@extends('layout.app_layout')

@push('post-body-class')
    auth-layout
@endpush

@section('content')

    <div class="col d-flex align-items-center justify-content-center">
        <div class="card card-body mt-5 auth-card">
            @include('partials.validation-error')
            @include('flash::message')

            @yield('form-content')
        </div>
    </div>
@endsection
