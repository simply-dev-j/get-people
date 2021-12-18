@extends('layout.auth_layout')


@section('form-content')

<form action="{{route(App\WebRoute::AUTH_LOGIN_POST)}}" method="POST">
    @method('POST')

    <label for="email">
        {{ __(App\LocaleConstants::FORM_BASE.App\LocaleConstants::FORM_AUTH_EMAIL) }}
    </label>
    <input type="text" name="email" id="email" class="form-control form-input" value="{{old('email')}}">

    <label for="password">
        {{ __(App\LocaleConstants::FORM_BASE.App\LocaleConstants::FORM_AUTH_PASSWORD) }}
    </label>
    <input type="password" name="password" id="password" class="form-control form-input" value="">

    <button type="submit" class="form-control btn btn-primary">
        {{ __(App\LocaleConstants::FORM_BASE.App\LocaleConstants::FORM_AUTH_LOGIN) }}
    </button>

    <div class="text-center">
        <a href="{{route(App\WebRoute::AUTH_REGISTER)}}">
            {{ __(App\LocaleConstants::FORM_BASE.App\LocaleConstants::FORM_AUTH_REGISTER) }}
        </a>
    </div>

</form>

@endsection


