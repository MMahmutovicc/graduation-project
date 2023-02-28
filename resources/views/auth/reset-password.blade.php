{{-- <x-guest-layout>
    <x-jet-authentication-card>
        <x-slot name="logo">
            <x-jet-authentication-card-logo />
        </x-slot>

        <x-jet-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('password.update') }}">
            @csrf

            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <div class="block">
                <x-jet-label for="email" value="{{ __('Email') }}" />
                <x-jet-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $request->email)" required autofocus />
            </div>

            <div class="mt-4">
                <x-jet-label for="password" value="{{ __('Password') }}" />
                <x-jet-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            </div>

            <div class="mt-4">
                <x-jet-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
                <x-jet-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-jet-button>
                    {{ __('Reset Password') }}
                </x-jet-button>
            </div>
        </form>
    </x-jet-authentication-card>
</x-guest-layout> --}}
<x-guest-layout>
    @push('styles')
        <style>
            .login-box {
                margin-bottom: 3rem
            }
        </style>
    @endpush
    <main>
        <div class="login-image-box">      
            <img src="{{ asset('assets/slike/Logo.png') }}" alt="">
        </div>
        <div class="login-box">
            <h1>Promijenite Password</h1>
            <x-jet-validation-errors class="mb-4" />
            <form class="login-form" method="POST" action="{{ route('password.update') }}">
                @csrf
                <input type="hidden" name="token" value="{{ $request->route('token') }}">
                <div class="login-form_group">
                    <label for="username">Email</label>
                    <input type="email" id="email" placeholder="Unesite email" name="email" value="{{ $request->email }}" required autofocus>
                </div>
                <div class="login-form_group">
                    <label for="password">Password</label>
                    <input type="password" id="password" placeholder="Unesite password" name="password" required autocomplete="current-password">
                </div>
                <div class="login-form_group">
                    <label for="password_confirmation">Potvrdite Password</label>
                    <input type="password" id="password_confirmation" placeholder="Potvrdite password" name="password_confirmation" required autocomplete="current-password">
                </div>
                <div class="login-submit">
                    <button type="submit">Promijenite Password</button>
                </div>
            </form>
        </div>
    </main>
</x-guest-layout>
