<template>
    <app-layout>
        <div id="edit_worker">
            <form
                :action="route('user.update', user)"
                method="post"
                @submit.prevent="updateUser"
            >
                <div
                    class="block32 whiteBg edit_worker__block add_worker__block"
                >
                    <div class="base-header">
                        <h1>Общая информация</h1>
                    </div>
                    <div class="form">
                        <div class="profile-inputs profile-inputs__last">
                            <label
                                class="block font-medium text-sm text-gray-700 label"
                                for="lastname"
                            >
                                <span>Фамилия:</span>
                            </label>
                            <input
                                id="lastname"
                                v-model="form.lastname"
                                class="form-input rounded-md shadow-sm mt-1 block w-full"
                                name="lastname"
                                required
                                type="text"
                            />
                            <jet-input-error
                                :message="form.error('lastname')"
                            />
                        </div>
                        <div class="profile-inputs profile-inputs__last">
                            <label
                                class="block font-medium text-sm text-gray-700 label"
                                for="firstname"
                            >
                                <span>Имя:</span>
                            </label>

                            <input
                                id="firstname"
                                v-model="form.firstname"
                                class="form-input rounded-md shadow-sm mt-1 block w-full"
                                name="firstname"
                                required
                                type="text"
                            />
                            <jet-input-error
                                :message="form.error('firstname')"
                            />
                        </div>
                        <div class="profile-inputs profile-inputs__last">
                            <label
                                class="block font-medium text-sm text-gray-700 label"
                                for="middlename"
                            >
                                <span>Отчество:</span>
                            </label>
                            <input
                                id="middlename"
                                v-model="form.middlename"
                                class="form-input rounded-md shadow-sm mt-1 block w-full"
                                name="middlename"
                                type="text"
                            />
                            <jet-input-error
                                :message="form.error('middlename')"
                            />
                        </div>

                        <div class="profile-wrap">
                            <v-select
                                typeSelect="whiteSelect"
                                :data="$page.props.roles"
                                :title="$page.props.roles[1].name"
                                optionName="name"
                                keyName="id"
                                ref="roleSelect"
                                @selected="role => (form.role = role)"
                                :label="{ show: true, text: 'Роль в проекте:' }"
                            />
                            <jet-input-error :message="form.error('role')" />
                            <v-select
                                typeSelect="whiteSelect"
                                :data="$page.props.positions"
                                :title="user.position.title"
                                optionName="title"
                                keyName="id"
                                @selected="pos => (form.position = pos)"
                                :label="{ show: true, text: 'Должность:' }"
                            />
                            <jet-input-error
                                :message="form.error('position')"
                            />
                            <v-select
                                typeSelect="whiteSelect"
                                :data="$page.props.divisions"
                                :title="user.division.title"
                                optionName="title"
                                keyName="id"
                                @selected="
                                    division => (form.division = division)
                                "
                                :label="{ show: true, text: 'РП:' }"
                            />
                            <jet-input-error
                                :message="form.error('division')"
                            />
                        </div>
                        <div class="profile-wrap">
                            <div class="profile-inputs profile-inputs__last">
                                <label
                                    class="block font-medium text-sm text-gray-700 label"
                                    for="email"
                                >
                                    <span>Email:</span>
                                </label>
                                <input
                                    id="email"
                                    v-model="form.email"
                                    class="form-input rounded-md shadow-sm mt-1 block w-full"
                                    name="email"
                                    required
                                    type="email"
                                />
                                <jet-input-error
                                    :message="form.error('email')"
                                />
                            </div>
                            <div class="profile-inputs profile-inputs__last">
                                <label
                                    class="block font-medium text-sm text-gray-700 label"
                                    for="phone"
                                >
                                    <span>Телефон:</span>
                                </label>
                                <input
                                    id="phone"
                                    v-model="form.phone"
                                    class="form-input rounded-md shadow-sm mt-1 block w-full"
                                    name="phone"
                                    required
                                    type="tel"
                                />
                                <jet-input-error
                                    :message="form.error('phone')"
                                />
                            </div>
                        </div>
                    </div>
                </div>
                <div
                    class="block32 whiteBg edit_worker__block add_worker__block"
                >
                    <div class="base-header">
                        <h1>Изменение пароля</h1>
                    </div>
                    <div class="form">
                        <div
                            class="profile-inputs profile-inputs__last"
                            style="margin-top: 24px"
                        >
                            <label
                                class="block font-medium text-sm text-gray-700 label"
                                for="oldPassword"
                            >
                                <span>Старый пароль:</span>
                            </label>
                            <input
                                class="form-input rounded-md shadow-sm mt-1 block w-full"
                                v-model="form.current_password"
                                id="oldPassword"
                                type="password"
                            />
                            <jet-input-error
                                :message="form.error('current_password')"
                            />
                        </div>
                        <div
                            class="profile-inputs profile-inputs__last"
                            style="margin-top: 24px"
                        >
                            <label
                                class="block font-medium text-sm text-gray-700 label"
                                for="newPassword"
                            >
                                <span>Новый пароль:</span>
                            </label>
                            <input
                                class="form-input rounded-md shadow-sm mt-1 block w-full"
                                id="newPassword"
                                v-model="form.password"
                                type="password"
                            />
                            <jet-input-error
                                :message="form.error('password')"
                            />
                        </div>
                        <div
                            class="profile-inputs profile-inputs__last"
                            style="margin-top: 24px"
                        >
                            <label
                                class="block font-medium text-sm text-gray-700 label"
                                for="repeatNP"
                            >
                                <span>Повторите новый пароль:</span>
                            </label>
                            <input
                                class="form-input rounded-md shadow-sm mt-1 block w-full"
                                v-model="form.password_confirmation"
                                id="repeatNP"
                                type="password"
                            />
                            <jet-input-error
                                :message="form.error('password_confirmation')"
                            />
                        </div>
                    </div>
                </div>
                <div class="add_worker__btn">
                    <button type="submit" class="btn btn-orange">
                        Редактировать
                    </button>
                    <inertia-link
                        :href="route('user.index')"
                        class="btn btn-gray"
                        >Отменить</inertia-link
                    >
                </div>
            </form>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from '../../Layouts/AppLayout'
import VSelect from '@/components/v-select'
import JetInputError from '@/Jetstream/InputError'

export default {
    components: {
        AppLayout,
        VSelect,
        JetInputError
    },
    props: {
        user: {
            type: Object
        }
    },
    data() {
        return {
            form: this.$inertia.form(
                {
                    lastname: this.user.lastname,
                    firstname: this.user.firstname,
                    middlename: this.user.middlename,
                    position: this.user.position_id,
                    role: this.user.roles ? this.user.roles[0].id : 1,
                    rule: this.user.props,
                    division: this.user.division_id,
                    email: this.user.email,
                    phone: this.user.phone,
                    current_password: null,
                    password: null,
                    password_confirmation: null
                },
                {
                    bag: 'updateUser',
                    resetOnSuccess: true
                }
            )
        }
    },
    methods: {
        updateUser() {
            this.form.put(route('user.update', this.user), {
                preserveScroll: true
            })
        }
    },
    mounted() {
        // if(this.user.roles.length) {
        //     this.$refs.roleSelect.
        // }
    }
}
</script>

<style scoped></style>
