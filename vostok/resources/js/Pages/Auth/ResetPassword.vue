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
                    <h1>Введите новый пароль</h1>
                    <form method="POST" :action="route('password.update')" @submit.prevent="reset">
                        <div class="form">
                            <input
                                id="password"
                                type="password"
                                name="password"
                                v-model="form.password"
                                placeholder="Новый пароль"
                                required
                                autofocus
                            />
                            <p class="label">Минимум 6 символов</p>
                            <input-error :message="form.error('email')"></input-error>
                        </div>
                        <button type="submit" class="button">
                            Восстановить пароль
                        </button>
                    </form>
                </div>
            </div>
            <div class="login-col"></div>
        </div>
    </section>
</template>

<script>
import InputError from '@/Jetstream/InputError'

export default {
    name: 'ForgotPassword',
    data() {
        let params = new URLSearchParams(window.location.search);
        return {
            form: this.$inertia.form(
                {
                    token: route().params.token,
                    email: params.get('email'),
                    password: ''
                },
                {
                    bag: 'login',
                    resetOnSuccess: true
                }
            )
        }
    },
    methods: {
        reset() {
            this.form.post(route('password.update'), {
                preserveScroll: true
            })
        }
    },
    components: {
        InputError
    }
}
</script>
