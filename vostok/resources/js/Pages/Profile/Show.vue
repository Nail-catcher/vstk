<template>
    <app-layout>
        <template #header>
            <h1>Профиль пользователя</h1>
            <div
                style="margin-left:45px;"
                @click="openAlertMoal"
                class="profile-out"
            >
                <p class="textIcon">
                    Выйти из системы
                    <img :src="require('@/../images/icons/profile-out.svg').default" alt="exit"/>
                </p>
            </div>
        </template>

        <div>
            <update-profile-information-form
                :firstname="$page.props.user.firstname"
                :lastname="$page.props.user.lastname"
                :middlename="$page.props.user.middlename"
                :email="$page.props.user.email"
                :phone="$page.props.user.phone"
            />

            <jet-section-border />

            <update-password-form />
        </div>
        <vAlert
            ref="alertLogout"
            text="Вы действительно хотите выйти из системы?"
            confirmText="Да, выйти"
            refuseText="Нет"
            @confirm="logout"
        />
    </app-layout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout'
import DeleteUserForm from './DeleteUserForm'
import JetSectionBorder from '@/Jetstream/SectionBorder'
import LogoutOtherBrowserSessionsForm from './LogoutOtherBrowserSessionsForm'
import TwoFactorAuthenticationForm from './TwoFactorAuthenticationForm'
import UpdatePasswordForm from './UpdatePasswordForm'
import UpdateProfileInformationForm from './UpdateProfileInformationForm'
import vAlert from '@/components/v-alert'
export default {
    props: ['sessions'],
    data: () => ({
        showModal: false
    }),

    components: {
        AppLayout,
        DeleteUserForm,
        JetSectionBorder,
        LogoutOtherBrowserSessionsForm,
        TwoFactorAuthenticationForm,
        UpdatePasswordForm,
        vAlert,
        UpdateProfileInformationForm
    },
    methods: {
        logout() {
            this.$inertia.post(route('logout'))
        },
        openAlertMoal() {
            this.$refs.alertLogout.open()
        }
    }
}
</script>
