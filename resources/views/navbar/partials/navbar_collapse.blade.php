<div class="container collapse navbar-collapse" id="navbar-collapse">
    <div class="row text-center">

        @include('navbar.partials.navbar_collapse_item', [
            'title' => '<i class="fas fa-home"></i> '.__(App\LocaleConstants::FORM_BASE.App\LocaleConstants::FORM_HOME),
            'link' => route(App\WebRoute::HOME_INDEX),
        ])

        @include('navbar.partials.navbar_collapse_item', [
            'title' => '<i class="fas fa-sign-out-alt"></i> '.__(App\LocaleConstants::FORM_BASE.App\LocaleConstants::FORM_AUTH_LOGOUT),
            'link' => route(App\WebRoute::AUTH_LOGOUT),
        ])

    </div>
</div>
