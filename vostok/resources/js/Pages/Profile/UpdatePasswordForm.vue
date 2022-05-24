<template>
    <jet-form-section @submitted="updatePassword">
        <template #title>
            Изменение пароля
        </template>

        <template #form>
            <div class="profile-password">
                <jet-label for="current_password" value="Старый пароль"/>
                <jet-input id="current_password" type="password" class="mt-1 block w-full"
                           v-model="form.current_password" ref="current_password" autocomplete="current-password"/>
                <jet-input-error :message="form.error('current_password')" class="mt-2"/>
            </div>

            <div class="profile-password">
                <jet-label for="password" value="Новый пароль"/>
                <jet-input id="password" type="password" class="mt-1 block w-full" v-model="form.password"
                           autocomplete="new-password"/>
                <jet-input-error :message="form.error('password')" class="mt-2"/>
            </div>

            <div class="profile-password">
                <jet-label for="password_confirmation" value="Повторите пароль"/>
                <jet-input id="password_confirmation" type="password" class="mt-1 block w-full"
                           v-model="form.password_confirmation" autocomplete="new-password"/>
                <jet-input-error :message="form.error('password_confirmation')" class="mt-2"/>
            </div>
        </template>

        <template #actions>
            <jet-action-message :on="form.recentlySuccessful" class="mr-3">
                Saved.
            </jet-action-message>

            <jet-button :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Сохранить изменения
            </jet-button>
        </template>
    </jet-form-section>
</template>

<script>
import JetActionMessage from './../../Jetstream/ActionMessage'
import JetButton from './../../Jetstream/Button'
import JetFormSection from './../../Jetstream/FormSection'
import JetInput from './../../Jetstream/Input'
import JetInputError from './../../Jetstream/InputError'
import JetLabel from './../../Jetstream/Label'

export default {
    components: {
        JetActionMessage,
        JetButton,
        JetFormSection,
        JetInput,
        JetInputError,
        JetLabel,
    },

    data() {
        return {
            form: this.$inertia.form({
                current_password: '',
                password: '',
                password_confirmation: '',
            }, {
                bag: 'updatePassword',
            }),
        }
    },

    methods: {
        updatePassword() {
            this.form.put(route('user-password.update'), {
                preserveScroll: true
            }).then(() => {
                this.$refs.current_password.focus()
            })
        },
    },
}
</script>
