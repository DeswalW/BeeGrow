<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="w-full">
        @csrf

        <!-- Email Address -->
        <div class="w-full">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="text-sm block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4 w-full">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4 w-full">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-ungu shadow-sm focus:ring-ungu" name="remember">
                <span class="ms-2 text-sm text-ungu">{{ __('Ingat Saya') }}</span>
            </label>
        </div>

        <div class="flex items-center flex-col justify-end mt-4 space-y-4 w-full">
            @if (Route::has('password.request'))
                <a class="text-sm text-ungu hover:text-ungu/80 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-ungu" href="{{ route('password.request') }}">
                    {{ __('Lupa Password?') }}
                </a>
            @endif

            <x-primary-button class="">
                {{ __('Log in') }}
            </x-primary-button>
            @if (Route::has('register'))
                <a
                    href="{{ route('register') }}"
                    class="flex justify-center items-center w-full rounded-full px-3 py-2 text-sm text-ungu ring-1 ring-ungu transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                >
                    Register
                </a>
            @endif
        </div>
    </form>
</x-guest-layout>
