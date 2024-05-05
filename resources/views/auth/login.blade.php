{{-- <x-guest-layout>
    <x-jet-authentication-card>
        <x-slot name="logo">
            <x-jet-authentication-card-logo />
        </x-slot>

        <x-jet-validation-errors class="mb-4" />

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div>
                <x-jet-label for="email" value="{{ __('Email') }}" />
                <x-jet-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            </div>

            <div class="mt-4">
                <x-jet-label for="password" value="{{ __('Password') }}" />
                <x-jet-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
            </div>

            <div class="block mt-4">
                <label for="remember_me" class="flex items-center">
                    <x-jet-checkbox id="remember_me" name="remember" />
                    <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif

                <x-jet-button class="ml-4">
                    {{ __('Log in') }}
                </x-jet-button>
            </div>
        </form>
    </x-jet-authentication-card>
</x-guest-layout> --}}

<x-guest-layout>
    <main>
        <div class="login-image-box">      
            <img src="{{ asset('assets/slike/Logo.png') }}" alt="">
        </div>
        <div class="login-box">
            <h1>Login</h1>
            <x-jet-validation-errors class="mb-4" />
            <form class="login-form" method="POST" action="{{ route('login') }}">
                @csrf
                <div class="login-form_group">
                    <label for="username">Email</label>
                    <input type="email" id="email" placeholder="Unesite email" name="email" value="{{ old('email') }}" required autofocus>
                </div>
                <div class="login-form_group">
                    <label for="password">Password</label>
                    <input type="password" placeholder="Unesite password" name="password" required autocomplete="current-password">
                </div>
                <div class="login-form_group">
                    <label for="password">
                        <input type="checkbox" name="remember" id="rememberme" value="forever"><span>Zapamti me</span>
                    </label>
                </div>
                <div class="login-submit">
                    <a href="{{ route('password.request') }}">Zaboravili Ste Password?</a>
                    <button type="submit">Log in</button>
                </div>
            </form>
        </div>
    </main>
</x-guest-layout>
