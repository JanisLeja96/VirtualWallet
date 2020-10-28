<x-guest-layout>
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
        <div class="d-block username">
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="username">
                <x-jet-label for="username" value="{{ __('Username') }}" />
                <input dusk="username" id="username" class="block mt-1 w-full" name="username" value="{{ old('username') }}" required autofocus>
            </div>

            <div class="mt-4">
                <x-jet-label for="password" value="{{ __('Password') }}" />
                <x-jet-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
            </div>

            <div class="block mt-4">
                <label for="remember_me" class="flex items-center">
                    <input id="remember_me" type="checkbox" class="form-checkbox" name="remember">
                    <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>
            </div>
            <div class="items-center justify-end mt-4 d-inline-block">
                <x-jet-button class="ml-4">
                    {{ __('Login') }}
                </x-jet-button>
            </div>
        </form>
        <div class="items-center align-items-start mt-4 d-inline-block">
            <form method="GET" action="{{ route('register') }}">
                <x-jet-button class="ml-4">
                    {{ __('Register') }}
                </x-jet-button>
            </form>
        </div>
        </div>
    </x-jet-authentication-card>
</x-guest-layout>
