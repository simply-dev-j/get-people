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

<body class="hold-transition sidebar-mini layout-fixed ">
    <div class="wrapper">
        @if ( auth()->user()->active )
            <!-- Top nav bar -->
            @include('navbar.navbar')

            @include('navbar.aside_nav')

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
                    @yield('content')
                </section>
            </div>
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

    @stack('post-body-scripts')
</body>
