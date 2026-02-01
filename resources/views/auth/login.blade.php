<x-guest-layout>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required
                autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password" :value="__('Senha')" />

            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox"
                    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Lembrar senha') }}</span>
            </label>
        </div>

        <div class="flex flex-col items-center gap-4 mt-4">
            <div class="flex items-center justify-end w-full">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-blue-500 hover:text-blue-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                        href="{{ route('password.request') }}">
                        {{ __('Esqueceu a senha?') }}
                    </a>
                @endif

                <x-primary-button class="ms-3 !bg-blue-600 hover:!bg-blue-700 focus:!bg-blue-700 active:!bg-blue-800">
                    {{ __('Entrar') }}
                </x-primary-button>

            </div>

            <div class="w-full border-t border-gray-100 pt-4 text-center">
                <p class="text-sm text-gray-600 mb-2">Ainda não tem uma conta?</p>
                <a href="{{ route('register') }}"
                    class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150 w-full justify-center">
                    Cadastre-se agora
                </a>
            </div>
        </div>
    </form>
</x-guest-layout>
