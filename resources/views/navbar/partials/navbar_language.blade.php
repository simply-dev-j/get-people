<a href="{{route(App\WebRoute::LOCALE_CHANGE, [$locale])}}">
    <div class="language-item {{app()->getLocale() == $locale ? 'active' : '' }}">
        <img src="{{asset('img/lang/'.$locale.'.png')}}"/>
        <div>
            {{App\Utils\LocaleUtil::$localeTitles[$locale]}}
        </div>
    </div>
</a>
