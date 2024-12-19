<x-guest-layout>
    <div class="my-4 text-sm text-gray-600">
        {{ __('Lupa Password? Tidak masalah. Hanya perlu memberitahu kami alamat email Anda dan kami akan mengirimkan tautan reset password yang akan memungkinkan Anda memilih yang baru.') }}
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="w-full">
        @csrf

        <!-- Email Address -->
        <div class="w-full">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="text-sm block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex items-center flex-col justify-end mt-4 space-y-4 w-full">
            <x-primary-button>
                {{ __('Email Password Reset Link') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>