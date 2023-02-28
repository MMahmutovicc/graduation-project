{{-- <x-guest-layout>
    <x-jet-authentication-card>
        <x-slot name="logo">
            <x-jet-authentication-card-logo />
        </x-slot>

        <div class="mb-4 text-sm text-gray-600">
            {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
        </div>

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif

        <x-jet-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="block">
                <x-jet-label for="email" value="{{ __('Email') }}" />
                <x-jet-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-jet-button>
                    {{ __('Email Password Reset Link') }}
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
            <h1>Zaboravili Ste Password? </h1>
            @if (session('status'))
                <div class="mb-4 font-medium text-sm text-green-600">
                    {{ session('status') }}
                </div>
            @endif
            <x-jet-validation-errors class="mb-4" />
            <form class="login-form" method="POST" action="{{ route('password.email') }}">
                @csrf
                <div class="login-form_group">
                    <label for="username">Email</label>
                    <input type="email" id="email" placeholder="Unesite email" name="email" value="{{ old('email') }}" required autofocus>
                </div>
                <div class="login-submit">
                    <button type="submit">Pošalji Link</button>
                </div>
            </form>
        </div>
    </main>
</x-guest-layout>