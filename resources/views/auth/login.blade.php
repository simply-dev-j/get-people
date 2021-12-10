@extends('layout.auth_layout')


@section('form-content')

<form action="{{route(App\WebRoute::AUTH_LOGIN_POST)}}" method="POST">
    @method('POST')

    <label for="email">Email</label>
    <input type="text" name="email" id="email" class="form-control form-input" value="{{old('email')}}">

    <label for="password">Password</label>
    <input type="password" name="password" id="password" class="form-control form-input" value="">

    <button type="submit" class="form-control btn btn-primary">Login</button>
    <a href="{{route(App\WebRoute::AUTH_REGISTER)}}">Register</a>
</form>

@endsection


