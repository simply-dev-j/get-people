@extends('layout.auth_layout')


@section('form-content')

<form class="m-0" action="{{route(App\WebRoute::AUTH_LOGIN_POST)}}" method="POST">
    @method('POST')

    <div class="input-group">
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
                <i class="fa fa-lock"></i>
            </span>
        </div>
        <input type="password" name="password" id="password" class="form-control form-input" value=""
        placeholder="{{ __(App\LocaleConstants::FORM_BASE.App\LocaleConstants::FORM_AUTH_PASSWORD) }}">
    </div>

    <button type="submit" class="form-control btn btn-primary mt-3 mb-0">
        {{ __(App\LocaleConstants::FORM_BASE.App\LocaleConstants::FORM_AUTH_LOGIN) }}
    </button>

    <a class="form-control btn btn-primary mt-3 mb-0" href="{{route(App\WebRoute::AUTH_REGISTER)}}">
        {{ __(App\LocaleConstants::FORM_BASE.App\LocaleConstants::FORM_AUTH_REGISTER) }}
    </a>


</form>
@endsection

@section('footer')
<div class="footer">
    <a href="https://beian.miit.gov.cn" target="_blank">辽ICP备2021013768号</a>
</div>
@endsection


