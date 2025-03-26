<x-guest-layout>
    <x-authentication-card>
        <div class="text-center">
            <h1 class="mb-4 text-4xl font-extrabold leading-none tracking-tight text-gray-900 md:text-5xl lg:text-5xl">Welcome</h1>
        </div>

        <x-validation-errors class="mb-4 absolute" />

        @session('status')
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ $value }}
            </div>
        @endsession

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div>
                <x-label for="email" value="{{ __('Email') }}" />
                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            </div>

            <div class="mt-4">
                <x-label for="password" value="{{ __('Password') }}" />
                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
            </div>

            <div class="block mt-4">
                <label for="remember_me"  cclass="flex items-center">
                    <x-checkbox id="remember_me" name="remember" />
                    <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>
            </div>

            <x-button>
                {{ __('Log in') }}
            </x-button>

            

            <div class="flex items-center justify-between mt-2">
                @if (Route::has('password.request'))
                    <a class="text-sm text-gray-600 hover:text-gray-900 hover:underline rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif

                @if (Route::has('register'))
                    <a class="text-sm text-gray-600 hover:text-gray-900 hover:underline rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" 
                    href="{{ route('register') }}">
                        {{ __('Dont have account?') }}
                    </a>
                @endif
            </div>
        </form>

        <div class="flex justify-center items-center text-gray-700 text-sm mt-6 space-x-2">
            <div class="flex-column items-center">
                <p class="m-0">Dikembangkan Oleh :</p>
            </div>
        </div>
        <div class="flex justify-center text-sm gap-1">
            <a href="https://github.com/MRD-Beginner" class="text-gray-800 font-semibold underline hover:no-underline">Muhammad Rizki Dalfi </a>
            <p> & </p>
            <a href="https://github.com/dwinurindahsari" class="text-gray-800 font-semibold underline hover:no-underline">Dwi Nur Indah Sari</a>
        </div>
    </x-authentication-card>
</x-guest-layout>
