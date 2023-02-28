{{-- <!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">

        <!-- Scripts -->
        <script src="{{ mix('js/app.js') }}" defer></script>
    </head>
    <body>
        <div class="font-sans text-gray-900 antialiased">
            {{ $slot }}
        </div>
    </body>
</html> --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('assets/css/shared.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/login.css') }}">
    @livewireStyles
    @stack('styles')
</head>
<body>
    <header class="main-header">
        <div>
            <a href="../home/home.html" class="main-header_brand">
                <img src="{{ asset('assets/slike/Logo.png') }}" alt="C++">
            </a>
            <nav class="main-nav">
                <ul class="main-nav_items">
                    <li class="main-nav_item"><a href="/">Početna</a></li>
                    <li class="main-nav_item"><a href="{{ route('sekcije') }}">Oblasti</a></li>
                </ul>
            </nav>
        </div>
    </header>
        {{ $slot }}
    <footer class="login-footer">
        <div>
        </div>
        <p>&copy; 2022</p>
    </footer>
    @livewireScripts
    @stack('scripts')
</body>
</html>
