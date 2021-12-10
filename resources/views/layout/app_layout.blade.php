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

    @stack('post-header-scripts')

    {{-- Styles --}}
    @stack('pre-styles')
    <link href="{{ mix('/css/app.css') }}" rel="stylesheet">
    @stack('post-styles')

    <link rel="shortcut icon" href="/img/logo_header_{{ app()->getLocale() }}.png"/>

</head>

<body>
    @section('app-body')
        <div class="app-body min-vh-100" id="app-body">

            <div class="app-content container" id="app-content">
                @yield('content')
            </div>
        </div>
    @show

    <script>
        $('#flash-overlay-modal').modal();
    </script>
</body>
