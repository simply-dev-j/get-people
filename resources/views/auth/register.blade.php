@extends('layout.auth_layout')


@section('form-content')

<form action="{{route(App\WebRoute::AUTH_REGISTER_POST)}}" method="POST">
    @method('POST')
    <label for="code">
        {{ __(App\LocaleConstants::FORM_BASE.App\LocaleConstants::FORM_AUTH_CODE) }}
    </label>
    <input type="text" name="code" id="code" class="form-control form-input" value="{{old('code')}}">

    <label for="name">
        {{ __(App\LocaleConstants::FORM_BASE.App\LocaleConstants::FORM_AUTH_NAME) }}
    </label>
    <input type="text" name="name" id="name" class="form-control form-input" value="{{old('name')}}">

    <label for="email">
        {{ __(App\LocaleConstants::FORM_BASE.App\LocaleConstants::FORM_AUTH_EMAIL) }}
    </label>
    <input type="text" name="email" id="email" class="form-control form-input" value="{{old('email')}}">

    <label for="password">
        {{ __(App\LocaleConstants::FORM_BASE.App\LocaleConstants::FORM_AUTH_PASSWORD) }}
    </label>
    <input type="password" name="password" id="password" class="form-control form-input" value="">

    <label for="confirm_password">
        {{ __(App\LocaleConstants::FORM_BASE.App\LocaleConstants::FORM_AUTH_CONFIRM_PASSWORD) }}
    </label>
    <input type="password" name="confirm_password" id="confirm_password" class="form-control form-input" value="">

    <button type="submit" class="form-control btn btn-primary">
        {{ __(App\LocaleConstants::FORM_BASE.App\LocaleConstants::FORM_AUTH_REGISTER) }}
    </button>

    <div class="text-center">
        <a href="{{route(App\WebRoute::AUTH_LOGIN)}}">
            {{ __(App\LocaleConstants::FORM_BASE.App\LocaleConstants::FORM_AUTH_LOGIN) }}
        </a>
    </div>

</form>

@endsection


