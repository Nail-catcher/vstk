<template>
    <app-layout class="createz">
        <div id="add_worker">
            <div class="base-header">
                <h1>Добавить нового сотрудника</h1>
            </div>
            <form
                :action="route('user.store')"
                method="post"
                @submit.prevent="createUser"
            >
                <div
                    style="margin-top: 35px"
                    class="block32 whiteBg add_worker__block"
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
                                optionName="name"
                                keyName="id"
                                :resetOption="{
                                    isShow: true,
                                    text: 'Сбросить',
                                    isSendRequestAfterReset: true
                                }"
                                @selected="role => (form.role = role)"
                                :label="{ show: true, text: 'Роль в проекте:' }"
                            />
                            <jet-input-error :message="form.error('role')" />
                            <v-select
                                typeSelect="whiteSelect"
                                :data="$page.props.positions"
                                optionName="title"
                                keyName="id"
                                v-if="testParam === true"
                                :resetOption="{
                                    isShow: true,
                                    text: 'Сбросить',
                                    isSendRequestAfterReset: true
                                }"
                                @selected="pos => (form.position = pos)"
                                :label="{ show: true, text: 'Должность:' }"
                            />
                            <jet-input-error
                                :message="form.error('position')"
                            />
                            <v-select
                                typeSelect="whiteSelect"
                                :data="$page.props.divisions"
                                :resetOption="{
                                    isShow: true,
                                    text: 'Сбросить',
                                    isSendRequestAfterReset: true
                                }"
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
                            <v-select
                                v-if="areas.length"
                                typeSelect="whiteSelect"
                                :data="areas"
                                :resetOption="{
                                    isShow: true,
                                    text: 'Сбросить',
                                    isSendRequestAfterReset: true
                                }"
                                optionName="title"
                                keyName="id"
                                @selected="area => (form.area = area)"
                                :label="{ show: true, text: 'ЭУ:' }"
                            />
                            <jet-input-error :message="form.error('area')" />
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
                                <the-mask
                                    id="phone"
                                    v-model="form.phone"
                                    class="form-input rounded-md shadow-sm mt-1 block w-full"
                                    name="phone"
                                    type="tel"
                                    required
                                    :masked="false"
                                    mask="+7 (###) ### ##-##"
                                />
                                <jet-input-error
                                    :message="form.error('phone')"
                                />
                            </div>
                        </div>
                        <div
                            class="profile-inputs profile-inputs__last"
                            style="margin-top: 24px"
                        >
                            <label
                                class="block font-medium text-sm text-gray-700 label"
                                for="password"
                            >
                                <span>Пароль:</span>
                            </label>
                            <input
                                id="password"
                                v-model="form.password"
                                autocomplete="new-password"
                                class="form-input rounded-md shadow-sm mt-1 block w-full"
                                name="password"
                                required
                                type="password"
                            />
                            <jet-input-error
                                :message="form.error('password')"
                            />
                        </div>
                    </div>
                </div>

                <div class="add_worker__btn">
                    <button
                        type="submit"
                        class="btn btn-orange"
                        :disabled="loading"
                    >
                        Добавить
                    </button>
                    <inertia-link
                        :href="route('user.index')"
                        class="btn btn-gray"
                        style="text-align: center"
                        >Отменить
                    </inertia-link>
                </div>
            </form>
        </div>
    </app-layout>
</template>

<script>
import { TheMask } from 'vue-the-mask'
import AppLayout from '@/Layouts/AppLayout'
import VSelect from '@/components/v-select'
import JetInputError from '@/Jetstream/InputError'
import axios from 'axios'

export default {
    components: {
        AppLayout,
        VSelect,
        JetInputError,
        TheMask
    },
    data() {
        return {
            testParam: true,
            loading: false,
            areas: [],
            form: this.$inertia.form(
                {
                    lastname: '',
                    firstname: '',
                    middlename: '',
                    position: 0,
                    division: null,
                    area: null,
                    role: 3,
                    email: '',
                    phone: '',
                    password: ''
                },
                {
                    bag: 'createUser',
                    resetOnSuccess: true
                }
            )
        }
    },
    methods: {
        createUser() {
            this.loading = true
            this.form.post(route('user.store'), {
                preserveScroll: true,
                onSucces: () => {
                    this.loading = false
                },
                onError: () => {
                    this.loading = false
                }
            })
        }
    },
    watch: {
        'form.division': {
            handler(value) {
                console.log(value)
                this.areas = this.$page.props.areas.filter(
                    area => area.division_id === value
                )
            }
        }
    },
    mounted() {
        this.areas = this.$page.props.areas
    }
}
</script>
