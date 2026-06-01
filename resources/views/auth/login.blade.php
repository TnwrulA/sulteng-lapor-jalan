<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="mb-5 rounded-md border border-[#d7dccd] bg-[#f4f6ed] p-4 text-sm text-[#30382e]">
        <p class="font-semibold">Akun admin demo</p>
        <p class="mt-1">Email: <span class="font-mono">admin@gmail.com</span></p>
        <p>Password: <span class="font-mono">admin123</span></p>
        <p class="mt-2 text-xs text-[#626a5d]">Register hanya membuat akun masyarakat. Admin dibuat melalui seeder agar akses admin tidak bisa dipilih bebas.</p>
    </div>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-[#cbd3bf] text-[#7f8f58] shadow-sm focus:ring-[#7f8f58]" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="rounded-md text-sm text-[#626a5d] underline hover:text-[#1f241f] focus:outline-none focus:ring-2 focus:ring-[#7f8f58] focus:ring-offset-2" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="ms-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
