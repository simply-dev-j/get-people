@extends('layout.app_layout')


@section('content')

    <div class="col h-100 d-flex align-items-center">
        <div class="card card-body">
            @include('partials.validation-error')
            @include('flash::message')

            @yield('form-content')
        </div>
    </div>
@endsection
