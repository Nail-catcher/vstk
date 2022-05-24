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
                    <h1>Восстановление пароля</h1>
                    <p style="width:300px; padding:20px 0;">
                        Введите адрес электронной почты, который вы использовали при
                        регистрации, и мы пришлем вам инструкции по сбросу пароля.
                    </p>
                    <p style="width:300px; padding:20px 0; color: firebrick" v-if="form.successful">
                        Ссылка для восстановления пароля отправлена на указанный E-mail.
                    </p>
                    <form method="POST" :action="route('password.email')" @submit.prevent="forgot">
                        <div class="form">
                            <input
                                id="email"
                                type="email"
                                name="email"
                                v-model="form.email"
                                placeholder="Email"
                                required
                                autofocus
                            />
                            <input-error :message="form.error('email')"></input-error>
                        </div>
                        <button type="submit" class="button">
                            Восстановить
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
        return {
            form: this.$inertia.form(
                {
                    email: this.email
                },
                {
                    bag: 'forgot',
                    resetOnSuccess: true
                }
            )
        }
    },
    methods: {
        forgot() {
            this.form.post(route('password.email'), {
                preserveScroll: true
            })
        }
    },
    components: {
        InputError
    }
}
</script>
