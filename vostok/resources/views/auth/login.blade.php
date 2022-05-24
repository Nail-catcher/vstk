<x-guest-layout>
    <section class="login">
        <div class="login-wrap">
            <div class="login-form">
                <div class="container">
                    <div class="logo">
                        <a href="{{ url('/') }}">
                            <img src="{{ asset('images/logo.png') }}" alt="logo"/>
                        </a>
                    </div>
                    <h1>Авторизация</h1>
                    <p class="registration">
                        Нет аккаунта?
                        <a href="{{ route('register') }}">Зарегистрироваться</a>
                    </p>
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="form">
                            <x-jet-input id="email" type="email" name="email" :value="old('email')"
                                         placeholder="{{ __('Email') }}" required autofocus/>
                            <x-jet-input id="password" type="password" name="password"
                                         placeholder="{{ __('Password') }}"
                                         required autocomplete="current-password"/>
                        </div>
                        <p class="forgot-password">
                            {{ __('Forgot your password?') }}
                            <a href="{{ route('password.request') }}">Восстановить пароль</a>
                        </p>
                        <x-jet-button class="button">
                            {{ __('Login') }}
                        </x-jet-button>
                    </form>
                </div>
            </div>
            <div class="login-col"></div>
        </div>
    </section>
</x-guest-layout>
