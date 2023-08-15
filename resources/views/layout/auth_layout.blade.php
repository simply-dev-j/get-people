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

    @stack('post-header-scripts')

    {{-- Styles --}}
    @stack('pre-styles')
    <link href="{{ mix('/css/app.css') }}" rel="stylesheet">
    @stack('post-styles')

    <link rel="shortcut icon" href="/img/logo_header_{{ app()->getLocale() }}.png"/>

</head>

<body>
    @section('app-body')
        <div class="app-body min-vh-100 auth-layout" id="app-body">

            <div class="app-content container min-h-100 min-w-100" >
                <div class="text-center">
                    <img src="/img/logo-bright.png" width="100%" height="auto"/>
                </div>
                <div class="col d-flex align-items-center justify-content-center">

                    <div class="card card-body mt-5 auth-card">
                        @include('partials.validation-error')
                        @include('flash::message')

                        @yield('form-content')
                    </div>
                </div>
            </div>

            @yield('footer')
        </div>
    @show

    <script>
        window.addEventListener('load', function(E) {
            $('#flash-overlay-modal').modal();

            // enable tooltip
            $(function () {
                $('[data-toggle="tooltip"]').tooltip()
            });
        })
    </script>
</body>
