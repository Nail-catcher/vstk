<template>
    <section class="login">
        <div class="login-wrap">
            <div class="login-form">
                <div class="container">
                    <div class="logo">
                        <inertia-link :href="route('index')">
                            <img :src="require('@/../images/logo.png').default" alt="logo"/>
                        </inertia-link>
                    </div>
                    <h1>Авторизация</h1>
                    <form method="POST" :action="route('login')" @submit.prevent="login">
                        <div class="form">
                            <input id="email" type="email" name="email" v-model="form.email"
                                   placeholder="Email" required autofocus/>
                            <input-error :message="form.error('email')"></input-error>
                            <input id="password" type="password" name="password"
                                   v-model="form.password"
                                   placeholder="Пароль"
                                   required autocomplete="current-password"/>
                            <input-error :message="form.error('password')"></input-error>
                        </div>
                        <p class="forgot-password">
                            Забыли пароль?
                            <inertia-link :href="route('password.request')">Восстановить пароль</inertia-link>
                        </p>
                        <button type="submit" class="button">
                            Авторизоваться
                        </button>
                    </form>
                </div>
            </div>
            <div class="login-col"></div>
        </div>
    </section>
</template>

<script>
import InputError from "@/Jetstream/InputError";

export default {
    components: {
        InputError
    },
    data() {
        return {
            form: this.$inertia.form({
                email: this.email,
                password: this.password,
                remember: true
            }, {
                bag: 'login',
                resetOnSuccess: true,
            }),
        }
    },
    methods: {
        login() {
            this.form.post(route('login'), {
                preserveScroll: true
            })

        }
    }
}
</script>
