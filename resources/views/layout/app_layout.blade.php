<html>

<head>
    <meta charset="big-5">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">

    {{-- Title --}}
    @stack('pre-title')
    <title>@section('site-title'){{ $site_title ?? config('app.name', 'Get People') }}@show</title>
    @stack('post-title')

    {{-- Scripts --}}
    @stack('pre-header-scripts')
    <script>
        window.Laravel = {!! json_encode(['csrfToken' => csrf_token()]); !!};
    </script>

    <script src="{{ mix('js/vendor.js') }}"></script>
    <script src="{{ mix('js/app.js') }}"></script>
    <script src="{{ asset('js/adminlte.min.js') }}"></script>

    @stack('post-header-scripts')

    {{-- Styles --}}
    @stack('pre-styles')
    <link href="{{ asset('css/adminlte.min.css') }}" rel="stylesheet">
    <link href="{{ mix('/css/extension.css') }}" rel="stylesheet">
    @stack('post-styles')

    <link rel="shortcut icon" href="/img/logo_header_{{ app()->getLocale() }}.png"/>
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-footer-fixed">
    <div class="wrapper">
        @if ( auth()->user()->active )
            <!-- Top nav bar -->
            @include('navbar.navbar')

            {{-- @include('navbar.aside_nav') --}}

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Main content -->
                <section class="content-header">
                    @yield('content-header')
                </section>

                <section class="content">
                    @include('partials.flash_message')
                </section>

                <section class="content">
                    @yield('custom-message')
                </section>

                <section class="content">
                    @yield('content')
                </section>
            </div>
            <footer class="main-footer">
                <a href="{{ route(App\WebRoute::AUTH_LOGOUT) }}" class="nav-link">
                    安全退出
                </a>
            </footer>
        @else
            <div class="container pt-5">
                <div class="alert alert-danger alert-dismissible">
                    <i class="icon fas fa-ban"></i>
                    登录尚未授权.

                    <a class=" btn btn-primary btn-sm float-right" style="text-decoration: none" href="{{ route(App\WebRoute::AUTH_LOGOUT) }}">
                        安全退出
                    </a>
                </div>
            </div>
        @endif
    </div>

    <div class="overlay-wrapper custom-overlay-wrapper d-none">
        <div class="overlay">
            <i class="fa fa-3x fa-spinner fa-spin"></i>
        </div>
    </div>

    @stack('post-body-scripts')

    <script>
        $(document).ready(function() {
            $('form').on('submit', function(e) {
                var isValid = false;

                try {
                    // if the jquery form validation is applied to form, then check form is valid.
                    isValid = $(this).valid()
                } catch (e) {
                    // if not, set it as validated because no need to check its validation statue, directly submit.
                    isValid = true
                }

                if (isValid) {
                    $('.overlay-wrapper').removeClass('d-none')
                }
            })
        })
    </script>
</body>
