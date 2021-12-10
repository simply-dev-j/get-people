<div class="navbar">
    <div class="avatar">
        @auth
        <img src="{{asset('img/avatar.png')}}" class="avatar">
        <span>{{Auth()->user()->name}}</span>
        @endauth
    </div>

    <div class="language">
        @foreach (App\Utils\Localeutil::$locales as $locale)
            @include('navbar.partials.navbar_language', [
                'locale' => $locale
            ])
        @endforeach
    </div>
</div>
