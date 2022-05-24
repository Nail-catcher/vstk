<template>
    <app-layout class="usr createz users-index">
        <div id="list_worker">
            <div class="base-header">
                <h1>Список сотрудников</h1>
                <form
                    :action="route('user.index')"
                    @submit.prevent="submit"
                    @change.prevent="submit"
                    method="get"
                >
                    <div class="options">
                        <v-select
                            :label="{ show: false }"
                            :data="$page.props.positions"
                            keyName="id"
                            optionName="title"
                            typeSelect="whiteSelect"
                            mode="Multiple"
                            ref="selectPositions"
                            :resetOption="{
                                isShow: true,
                                text: 'Все',
                                isSendRequestAfterReset: true
                            }"
                            @selected="
                                positions => {
                                    form.positions = positions
                                    submit()
                                }
                            "
                        ></v-select>
                        <v-select
                            :label="{ show: false }"
                            :data="$page.props.roles"
                            keyName="id"
                            optionName="name"
                            typeSelect="whiteSelect"
                            mode="Multiple"
                            ref="selectRoles"
                            :resetOption="{
                                isShow: true,
                                text: 'Все',
                                isSendRequestAfterReset: true
                            }"
                            @selected="
                                roles => {
                                    form.roles = roles
                                    submit()
                                }
                            "
                        ></v-select>
                        <div class="input-search">
                            <input
                                type="text"
                                placeholder="Email"
                                v-model="form.email"
                            />
                            <span class="material-icons pointer" @click="submit"
                                >search</span
                            >
                        </div>
                        <div class="input-search">
                            <input
                                type="text"
                                placeholder="Номер телефона"
                                v-model="form.phone"
                            />
                            <span class="material-icons pointer" @click="submit"
                                >search</span
                            >
                        </div>
                        <div class="input-search">
                            <input
                                type="text"
                                placeholder="ФИО"
                                v-model="form.fio"
                            />
                            <span class="material-icons pointer" @click="submit"
                                >search</span
                            >
                        </div>
                        <p
                            class="pointer orange resetText"
                            @click="resetFilters"
                        >
                            Сбросить
                        </p>
                    </div>
                </form>
            </div>
            <inertia-link
                :href="route('user.create')"
                class="textIcon pointer"
                id="addPersonalBtn"
            >
                Добавить сотрудника
                <span class="material-icons">add_circle</span>
            </inertia-link>
            <div class="table__wrapper">
                <div class="table__wrapper__head">
                    <ul>
                        <li>№</li>
                        <li>ФИО</li>
                        <li>РП</li>
                        <li>Роль</li>
                        <li>Должность</li>
                        <li>В работе</li>
                        <li>Телефон</li>
                        <li>E-mail</li>
                        <li>Статус</li>
                    </ul>
                </div>
                <div class="table__wrapper__body">
                    <ul v-for="user in $page.props.users.data" :key="user.id">
                        <li><span>№</span>{{ user.id }}</li>
                        <li>
                            <span>ФИО</span>{{ user.lastname }}
                            {{ user.firstname.charAt(0) }}.
                        </li>
                        <li><span>РП</span>{{ user.division.title }}</li>
                        <li>
                            <span>Роль</span>
                            <p v-if="user.roles.length">
                                {{ user.roles[0].name }}
                            </p>
                        </li>
                        <li><span>Должность</span>{{ user.position.title }}</li>
                        <li>
                            <span>В работе</span>
                            {{
                                user.applications_count
                                    ? $tc(
                                          'pluralization.applications',
                                          user.applications_count
                                      )
                                    : $tc('pluralization.applications', 0)
                            }}
                        </li>
                        <li><span>Телефон</span>{{ user.phone }}</li>
                        <li><span>E-Mail</span>{{ user.email }}</li>
                        <li>
                            <p class="textIcon" id="switchList">
                                {{ user.status.title }}
                                <span
                                    class="material-icons pointer"
                                    @click="
                                        () => {
                                            blockForChangingStatus = user.id
                                            changeStatus_form.userStatus =
                                                user.status.id
                                        }
                                    "
                                    style="display: block"
                                >
                                    more_horiz
                                </span>
                            </p>
                            <div
                                class="modal-req"
                                v-if="blockForChangingStatus === user.id"
                                v-click-outside="closeBlockForChangingStatus"
                            >
                                <button
                                    class="modalReqStatus bg-none"
                                    @click="openModalStatusChange"
                                >
                                    <span class="material-icons gray"
                                        >settings</span
                                    >
                                    Сменить статус
                                </button>
                                <modal
                                    name="modalReq"
                                    class="modal_regular modal_status"
                                    width="284"
                                    height="auto"
                                >
                                    <div class="modal_regular__header column2">
                                        <p>Смена статуса</p>
                                        <div class="modal_regular__close">
                                            <span
                                                class="material-icons pointer"
                                                @click="closeModalStatusChange"
                                            >
                                                close
                                            </span>
                                        </div>
                                    </div>
                                    <div
                                        class="modal_status__body custom-scroll"
                                    >
                                        <form @submit.prevent="updateStatus">
                                            <div
                                                class="modal_status__body_item"
                                                v-for="(status, index) in $page
                                                    .props.statuses"
                                                :key="index"
                                            >
                                                <input
                                                    name="status"
                                                    type="radio"
                                                    v-model="
                                                        changeStatus_form.userStatus
                                                    "
                                                    :id="`status-${status.id}`"
                                                    :value="status.id"
                                                />
                                                <label
                                                    :for="`status-${status.id}`"
                                                    >{{ status.title }}</label
                                                >
                                            </div>
                                            <div class="mt8">
                                                <calendar
                                                    calendarType="range"
                                                    :isShowTime="true"
                                                    @selectedDate="
                                                        date => {
                                                            changeStatus_form.started_at = date.start.toLocaleString()
                                                            changeStatus_form.deadline_at = date.end.toLocaleString()
                                                        }
                                                    "
                                                    @reset="() => {}"
                                                    placeholder="Период"
                                                />
                                            </div>
                                            <div class="btn-block-modal_status">
                                                <button
                                                    class="btn btn-orange"
                                                    type="submit"
                                                >
                                                    Изменить статус
                                                </button>
                                                <button
                                                    class="btn btn-gray mt8"
                                                    @click.prevent="
                                                        closeModalStatusChange
                                                    "
                                                >
                                                    Отмена
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </modal>
                            </div>
                        </li>

                        <li>
                            <inertia-link :href="route('user.edit', user)">
                                <img
                                    :src="
                                        require('@/../images/icons/edit.svg')
                                            .default
                                    "
                                    alt="edit"
                                />
                            </inertia-link>
                        </li>
                    </ul>
                </div>
            </div>

            <pagination
                v-if="$page.props.users.meta.last_page > 1"
                :pagination="$page.props.users.meta"
            >
            </pagination>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout'
import Pagination from '@/components/Pagination'
import vClickOutside from 'v-click-outside'
import vSelect from '@/components/v-select'
import calendar from '@/components/calendar'
export default {
    directives: {
        clickOutside: vClickOutside.directive
    },
    components: {
        AppLayout,
        Pagination,
        vSelect,
        calendar
    },
    data: () => ({
        blockForChangingStatus: null,
        changeStatus_form: {
            userStatus: null,
            started_at: null,
            deadline_at: null
        },
        form: {
            positions: [],
            roles: [],
            email: '',
            phone: '',
            fio: ''
        }
    }),
    methods: {
        openModalStatusChange() {
            this.$modal.show('modalReq')
            this.closeModalStatusChange()
        },
        closeModalStatusChange() {
            this.$modal.hide('modalReq')
        },
        closeBlockForChangingStatus() {
            this.blockForChangingStatus = null
            this.changeStatus_form = {
                userStatus: null,
                started_at: null,
                deadline_at: null
            }
        },
        updateStatus() {
            if (
                !this.changeStatus_form.started_at ||
                !this.changeStatus_form.deadline_at
            ) {
                this.$notify({
                    group: 'warn',
                    text: 'Выберите период'
                })
                return
            }
            this.$inertia.put(
                route('user.status', this.blockForChangingStatus),
                {
                    status: this.changeStatus_form.userStatus,
                    started_at: this.changeStatus_form.started_at,
                    deadline_at: this.changeStatus_form.deadline_at
                },
                {
                    reserveScroll: true,
                    preserveState: true,
                    only: ['users'],
                    bag: 'status'
                }
            )
            this.closeModalStatusChange()
        },
        submit() {
            this.$inertia.get(route('user.index'), this.form, {
                preserveScroll: true,
                preserveState: true,
                only: ['users']
            })
        },
        resetFilters() {
            this.$refs.selectRoles.reset()
            this.$refs.selectPositions.reset()
            this.form = {
                categories: [],
                roles: [],
                title: '',
                rrs: ''
            }
            this.submit()
        }
    }
}
</script>
