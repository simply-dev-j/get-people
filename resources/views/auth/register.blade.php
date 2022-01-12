@extends('layout.auth_layout')


@section('form-content')

<form class="m-0" action="{{route(App\WebRoute::AUTH_REGISTER_POST)}}" method="POST">
    @method('POST')

    <div class="input-group">
        <div class="input-group-prepend">
            <span class="input-group-text" id="basic-addon1">@</span>
        </div>
        <input type="text" name="code" id="code" class="form-control form-input" value="{{old('code')}}"
        placeholder="{{ __(App\LocaleConstants::FORM_BASE.App\LocaleConstants::FORM_AUTH_CODE) }}">
    </div>

    <div class="input-group mt-3">
        <div class="input-group-prepend">
            <span class="input-group-text" id="basic-addon1">
                <i class="fa fa-user"></i>
            </span>
        </div>
        <input type="text" name="name" id="name" class="form-control form-input" value="{{old('name')}}"
        placeholder="{{ __(App\LocaleConstants::FORM_BASE.App\LocaleConstants::FORM_AUTH_NAME) }}">
    </div>

    <div class="input-group mt-3">
        <div class="input-group-prepend">
            <span class="input-group-text" id="basic-addon1">
                <i class="fa fa-user"></i>
            </span>
        </div>
        <input type="text" name="username" id="username" class="form-control form-input" value="{{old('username')}}"
        placeholder="账号">
    </div>

    <div class="input-group mt-3">
        <div class="input-group-prepend">
            <span class="input-group-text" id="basic-addon1">
                <i class="fa fa-mobile"></i>
            </span>
        </div>
        <input type="text" name="phone" id="phone" class="form-control form-input" value="{{old('phone')}}"
        placeholder="手机">
    </div>

    <div class="input-group mt-3">
        <div class="input-group-prepend">
            <span class="input-group-text" id="basic-addon1">
                <i class="fa fa-id-card"></i>
            </span>
        </div>
        <input type="text" name="id_number" id="id_number" class="form-control form-input" value="{{old('id_number')}}"
        placeholder="身份证号码">
    </div>

    {{-- <label for="email">
        {{ __(App\LocaleConstants::FORM_BASE.App\LocaleConstants::FORM_AUTH_EMAIL) }}
    </label>
    <input type="text" name="email" id="email" class="form-control form-input" value="{{old('email')}}"> --}}

    <div class="input-group mt-3">
        <div class="input-group-prepend">
            <span class="input-group-text" id="basic-addon1">
                <i class="fa fa-key"></i>
            </span>
        </div>
        <input name="security_code" id="security_code" class="form-control form-input" value="{{old('security_code')}}"
        placeholder="{{ __(App\LocaleConstants::FORM_BASE.App\LocaleConstants::FORM_AUTH_SECURITY_CODE) }}">
    </div>

    <div class="input-group mt-3">
        <div class="input-group-prepend">
            <span class="input-group-text" id="basic-addon1">
                <i class="fa fa-lock"></i>
            </span>
        </div>
        <input type="password" name="password" id="password" class="form-control form-input" value=""
        placeholder="{{ __(App\LocaleConstants::FORM_BASE.App\LocaleConstants::FORM_AUTH_PASSWORD) }}">
    </div>

    <div class="input-group mt-3">
        <div class="input-group-prepend">
            <span class="input-group-text" id="basic-addon1">
                <i class="fa fa-lock"></i>
            </span>
        </div>
        <input type="password" name="confirm_password" id="confirm_password" class="form-control form-input" value=""
        placeholder="{{ __(App\LocaleConstants::FORM_BASE.App\LocaleConstants::FORM_AUTH_CONFIRM_PASSWORD) }}">
    </div>

    <button type="submit" class="form-control btn btn-primary mt-3 mb-0">
        {{ __(App\LocaleConstants::FORM_BASE.App\LocaleConstants::FORM_AUTH_REGISTER) }}
    </button>

    <a class="form-control btn btn-primary mt-3 mb-0" href="{{route(App\WebRoute::AUTH_LOGIN)}}">
        {{ __(App\LocaleConstants::FORM_BASE.App\LocaleConstants::FORM_AUTH_LOGIN) }}
    </a>

</form>

@endsection


