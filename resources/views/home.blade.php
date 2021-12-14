@extends('layout.app_layout')

@section('content')
<div class="row">

    @include('partials.stat-money')
    @include('partials.stat-people')

</div>

<div class="row">
    <div class="col-12 col-lg-4 col-md-6 col-sm-6">
        <a class="form-input btn btn-outline-primary w-100" href="{{route(App\WebRoute::CODE_CREATE)}}">Create New Code</a>
    </div>
</div>

@include('partials.code-gen-success')

@endsection
