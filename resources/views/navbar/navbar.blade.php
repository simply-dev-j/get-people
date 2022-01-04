{{-- <div class="navbar-container">
    <div class="navbar">
        <div class="avatar">
            @auth
            <img src="{{asset('/img/avatar.png')}}" class="avatar">
            <span>{{Auth()->user()->name}}</span>
            @endauth
        </div>

        <div class="language">
            @foreach (App\Utils\Localeutil::$locales as $locale)
                @include('navbar.partials.navbar_language', [
                    'locale' => $locale
                ])
            @endforeach
            @auth
                <a class="ml-3" data-toggle="collapse" href="#" data-target="#navbar-collapse" aria-expanded="false">
                    <i class="fas fa-bars fa-lg"></i>
                </a>
            @endauth
        </div>
    </div>
    @include('navbar.partials.navbar_collapse')
</div> --}}

<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->
