@extends('layout.auth_layout')


@section('form-content')

<form action="{{route(App\WebRoute::AUTH_REGISTER_POST)}}" method="POST">
    @method('POST')
    <label for="code">Invitation Code</label>
    <input type="number" name="code" id="code" class="form-control form-input" value="{{old('code')}}">

    <label for="name">Name</label>
    <input type="text" name="name" id="name" class="form-control form-input" value="{{old('name')}}">

    <label for="email">Email</label>
    <input type="text" name="email" id="email" class="form-control form-input" value="{{old('email')}}">

    <label for="password">Password</label>
    <input type="password" name="password" id="password" class="form-control form-input" value="">

    <label for="confirm_password">Confirm Password</label>
    <input type="password" name="confirm_password" id="confirm_password" class="form-control form-input" value="">

    <button type="submit" class="form-control btn btn-primary">Register</button>
    <a href="{{route(App\WebRoute::AUTH_LOGIN)}}">Login</a>
</form>

@endsection


