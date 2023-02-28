<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://kit.fontawesome.com/8f01d27bae.js" crossorigin="anonymous"></script>
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous"> --}}
    <link rel="stylesheet" href="{{ asset('assets/css/shared.css') }}">
    @livewireStyles
    @stack('styles')
</head>
<body>
    <header class="main-header">
        <div>
            <a href="/" class="main-header_brand">
                <img src="{{ asset('assets/slike/Logo.png') }}" alt="C++">
            </a>
        </div>
        <div>
            <nav class="main-nav">
                <ul class="main-nav_items">
                    <li class="main-nav_item"><a href="/">Početna</a></li>
                    <li class="main-nav_item"><a href="{{ route('sekcije') }}">Oblasti</a></li>
                    @if (Route::has('login'))
                        @auth
                            <li class="main-nav_item"><a href="{{ route('objave') }}">Objave</a></li>
                            @if (Auth::user()->utype === 'PROF')
                                <li class="main-nav_item"><a href="{{ route('ucenici') }}">Učenici</a></li>
                                <li class="main-nav_item"><a href="{{ route('kalendar') }}">Kalendar</a></li>
                            @elseif(Auth::user()->utype === 'UCE')
                                <li class="main-nav_item"><a href="{{ route('kalendar.razred', ['razred_name' => Auth::user()->razred->name]) }}">Kalendar</a></li>
                            @endif
                        @endauth
                    @endif
                </ul>
            </nav>
        </div>
        <div>
            <div>
                @if (Route::has('login'))
                    @auth
                        {{-- <img src="{{ asset('assets/slike/profilna.png') }}" alt=""> --}}
                        <span class="main-header_profile">{{ Auth::user()->name }}</span>
                        <form method="POST" class="main-header_logout" action="{{ route('logout') }}">
                            @csrf
                            <a class="main-header_logout_button" href="{{ route('logout') }}" onclick="event.preventDefault();
                                        this.closest('form').submit(); " role="button">
                                <i class="fas fa-sign-out-alt"></i>
                
                                {{ __('Log Out') }}
                            </a>
                        </form>
                    @else
                        <span class="main-header_profile">Gost</span>
                        <div class="main-header_logout">   
                            <a href="{{ route('login') }}" class="main-header_login_button">Login</a>
                        </div>
                    @endauth
                @endif
            </div>
        </div>
    </header>

    {{ $slot }}

    <footer class="main-footer">
        <div>
            <img src="{{ asset('assets/slike/Logo.png') }}" alt="C++">
        </div>
        <p>&copy; 2022</p>
    </footer>
    @livewireScripts
    @stack('scripts')
</body>
</html>