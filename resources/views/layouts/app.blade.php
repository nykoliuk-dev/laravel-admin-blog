<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>@yield('title', config('app.name'))</title>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400" rel="stylesheet" />
    <link href="{{ asset('assets/css/templatemo-style.css') }}" rel="stylesheet" />
</head>
<body>

<div class="container">
    <!-- Top box -->
    <!-- Logo & Site Name -->
    <div class="placeholder">
        <div class="parallax-window" data-parallax="scroll" data-image-src="{{ asset('assets/img/simple-house-01.jpg') }}">
            <div class="tm-header">
                @hasSection('header')
                    @yield('header')
                @else
                    <div class="row tm-header-inner">
                        <div class="col-md-6 col-12">
                            <img src="{{ asset('assets/img/simple-house-logo.png') }}" alt="Logo" class="tm-site-logo" />
                            <div class="tm-site-text-box">
                                <h1 class="tm-site-title">Simple House</h1>
                                <h6 class="tm-site-description">new restaurant template</h6>
                            </div>
                        </div>
                        <nav class="col-md-6 col-12 tm-nav">
                            <ul class="tm-nav-ul">
                                <li class="tm-nav-li">
                                    <a href="{{ route('home') }}" class="tm-nav-link {{ Route::is('home') ? 'active' : '' }}">Home</a>
                                </li>
                                <li class="tm-nav-li">
                                    <a href="{{ route('posts.index') }}" class="tm-nav-link {{ Route::is('posts.*') ? 'active' : '' }}">Blog</a>
                                </li>
                                <li class="tm-nav-li">
                                    <a href="{{ route('pages.about') }}" class="tm-nav-link {{ Route::is('pages.about') ? 'active' : '' }}">About</a>
                                </li>
                                <li class="tm-nav-li">
                                    <a href="{{ route('pages.contact') }}" class="tm-nav-link {{ Route::is('pages.contact') ? 'active' : '' }}">Contact</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <main>

        @yield('content')

    </main>

    <footer class="tm-footer text-center">
        <p>Copyright &copy; 2020 Simple House

            | Design: <a rel="nofollow" href="https://templatemo.com">TemplateMo</a></p>
    </footer>
</div>
<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
<script src="{{ asset('assets/js/parallax.min.js') }}"></script>
@stack('scripts')
<script>
    $(document).ready(function(){
        // Handle click on paging links
        $('.tm-paging-link').click(function(e){
            e.preventDefault();

            var page = $(this).text().toLowerCase();
            $('.tm-gallery-page').addClass('hidden');
            $('#tm-gallery-page-' + page).removeClass('hidden');
            $('.tm-paging-link').removeClass('active');
            $(this).addClass("active");
        });
    });
</script>
</body>
</html>
