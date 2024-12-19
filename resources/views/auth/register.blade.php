<x-guest-layout>
    <form method="POST" action="{{ route('register') }}" class="w-full">
        @csrf

        <!-- Name -->
        <div class="w-full">
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="text-sm block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4 w-full">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="text-sm block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4 w-full">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4 w-full">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center flex-col justify-end mt-4 space-y-4 w-full">
            <a class="text-sm text-ungu hover:text-ungu/80 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-ungu" href="{{ route('login') }}">
                {{ __('Sudah punya akun?') }}
            </a>
            <x-primary-button class="">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>