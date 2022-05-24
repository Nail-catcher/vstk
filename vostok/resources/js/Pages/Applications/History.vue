<template>
    <app-layout class="createz">
        <div class="history-page">
            <div class="base-header">
                <div class="base-header__wrapp">
                    <h1>История заявок</h1>
                    <!-- <div class="base-header__input history-page__form">
                        <form
                            :action="route('application.history')"
                            method="get"
                            @submit.prevent="submit"
                            @change.prevent="submit"
                        >
                            <div class="history-page__form-item">
                            </div>
                            <div class="history-page__form-item">
                                <button
                                    class="btn btn-blue history-page__form-item--reset"
                                >
                                    Сбросить фильтры
                                </button>
                            </div>
                        </form>
                    </div> -->
                </div>
                <div class="history-page__filter request-list">
                    <div class="pointer filter__btn">
                        <button
                            class="filter__btn textIcon"
                            @click="switchFilterModal()"
                        >
                            Фильтр заявок
                            <span class="material-icons">filter_alt</span>
                        </button>
                    </div>
                    <transition name="fade">
                        <div
                            class="filter__modal"
                            v-if="isVisibleFilterModal"
                            v-click-outside="
                                () => {
                                    if (isVisibleFilterModal) {
                                        switchFilterModal(false)
                                    }
                                }
                            "
                        >
                            <div class="filter__modal_elems">
                                <div class="filter__modal_elems__title">
                                    <form>
                                        <span
                                            class="filter__modal_close material-icons"
                                            @click="switchFilterModal(false)"
                                        >
                                            close
                                        </span>
                                        <div class="filter__modal_body">
                                            <div>
                                                <div>
                                                    <p
                                                        class="filter__modal_filterTitle"
                                                    >
                                                        ID станции
                                                    </p>
                                                    <input
                                                        type="text"
                                                        v-model="form.bts_id"
                                                        placeholder="Введите ID станции"
                                                    />
                                                </div>
                                                <div class="filter-select-box">
                                                    <p
                                                        class="filter__modal_filterTitle"
                                                        style="margin-top: 8px"
                                                    >
                                                        Период
                                                    </p>
                                                    <div class="calendar_block">
                                                        <calendar
                                                            calendarType="range"
                                                            :isShowTime="true"
                                                            @selectedDate="
                                                                submitDate
                                                            "
                                                            ref="filter_period"
                                                            @reset="submitDate"
                                                            placeholder="Выберите период"
                                                        />
                                                    </div>
                                                </div>
                                                <div class="filter-select-box">
                                                    <p
                                                        class="filter__modal_filterTitle"
                                                    >
                                                        Номер заявки
                                                    </p>
                                                    <div class="input-search">
                                                        <input
                                                            type="number"
                                                            placeholder="Введите ID заявки"
                                                            v-model="form.id"
                                                        />
                                                    </div>
                                                </div>
                                            </div>
                                            <div>
                                                <div>
                                                    <p
                                                        class="filter__modal_filterTitle"
                                                    >
                                                        Номер ПБ
                                                    </p>
                                                    <div class="input-search">
                                                        <input
                                                            type="text"
                                                            v-model="
                                                                form.ticket
                                                            "
                                                            placeholder="Введите № ПБ"
                                                        />
                                                        <span
                                                            class="material-icons pointer"
                                                            @click="submit"
                                                            >search</span
                                                        >
                                                    </div>
                                                </div>
                                                <div class="filter-select-box">
                                                    <div class="calendar_block">
                                                        <p
                                                            class="filter__modal_filterTitle"
                                                        >
                                                            Дата создания заявки
                                                        </p>
                                                        <calendar
                                                            calendarType="simple"
                                                            :isShowTime="true"
                                                            ref="filter_createdAt"
                                                            @selectedDate="
                                                                created_from => {
                                                                    form.created_from = created_from.toLocaleString()
                                                                }
                                                            "
                                                            @reset="
                                                                () => {
                                                                    form.created_from = null
                                                                }
                                                            "
                                                            placeholder="Дата создания заявки"
                                                        />
                                                    </div>
                                                </div>
                                                <div class="filter-select-box">
                                                    <p
                                                        class="filter__modal_filterTitle"
                                                    >
                                                        Статус заявки
                                                    </p>
                                                    <v-select
                                                        v-if="
                                                            $page.props.statuses
                                                                .data
                                                        "
                                                        :data="
                                                            $page.props.statuses
                                                                .data
                                                        "
                                                        optionName="title"
                                                        keyName="id"
                                                        mode="Multiple"
                                                        typeSelect="whiteSelect"
                                                        :label="{ show: false }"
                                                        @selected="
                                                            statuses => {
                                                                form.statuses = statuses
                                                            }
                                                        "
                                                    />
                                                </div>
                                            </div>
                                        </div>
                                        <div
                                            class="space-between filter__modal_btns"
                                        >
                                            <button
                                                class="pointer btn btn-gray"
                                                @click.prevent="resetFilters"
                                            >
                                                Сбросить
                                            </button>
                                            <button
                                                class="btn"
                                                @click.prevent="submit"
                                            >
                                                Применить
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </transition>
                </div>
            </div>
            <div class="table__wrapper">
                <div style="padding: 0px 5px" class="table__wrapper__head">
                    <ul>
                        <li>ID</li>
                        <li>Тип работ</li>
                        <li>Приоритет</li>
                        <li>Проект</li>
                        <li>№ ПБ</li>
                        <li>БС</li>
                        <li>Описание аварии</li>
                        <li>Дата создания</li>
                        <li>Срок заявки</li>
                        <li>№ Маршрут</li>
                        <li>№ ОРД</li>
                        <li>Ответственный</li>
                        <li>Статус</li>
                    </ul>
                </div>
                <div class="table__wrapper__body">
                    <ul
                        class="pointer"
                        v-for="application in $page.props.applications.data"
                        :key="application.id"
                        @click="redirect(application.id)"
                    >
                        <li
                            @click="
                                toggleVisibleApplicationCard(application, true)
                            "
                            class="pointer"
                        >
                            <span>ID:</span>{{ application.id }}
                        </li>
                        <li
                            @click="
                                toggleVisibleApplicationCard(application, true)
                            "
                            class="pointer"
                        >
                            <span>Тип работ:</span>{{ application.type.title }}
                        </li>
                        <li
                            @click="
                                toggleVisibleApplicationCard(application, true)
                            "
                            class="pointer"
                        >
                            <span>Приоритет:</span>
                            <priority :status="application.priority" />
                        </li>
                        <li
                            @click="
                                toggleVisibleApplicationCard(application, true)
                            "
                            class="pointer"
                        >
                            <span>Проект</span>{{ application.project.title }}
                        </li>
                        <li
                            @click="
                                toggleVisibleApplicationCard(application, true)
                            "
                            class="pointer"
                        >
                            <span>№ ПБ:</span>
                            {{ application.ticket }}
                        </li>
                        <li
                            @click="
                                toggleVisibleApplicationCard(application, true)
                            "
                            class="pointer"
                        >
                            <span class="pro">БС</span>
                            <p v-if="application.stations.length">
                                {{ application.stations[0].bts_id }}
                            </p>
                            <p
                                class="mt8 pointer more_station_btn"
                                v-if="application.stations.length > 1"
                                data-type-list="bts"
                                @click="openModalList(application, 'bts')"
                            >
                                Еще
                            </p>
                        </li>
                        <li
                            @click="
                                toggleVisibleApplicationCard(application, true)
                            "
                            class="pointer"
                        >
                            <span>Описание аварии:</span>
                            <p>
                                {{
                                    typeof application.description === 'string'
                                        ? application.description.slice(0, 25) +
                                          '...'
                                        : 'Ull'
                                }}
                            </p>
                        </li>
                        <li
                            @click="
                                toggleVisibleApplicationCard(application, true)
                            "
                            class="pointer"
                        >
                            <span>Дата создания</span>
                            {{
                                new Date(application.created_at).toLocaleString(
                                    $page.props.locale
                                )
                            }}
                        </li>
                        <li
                            @click="
                                toggleVisibleApplicationCard(application, true)
                            "
                            class="pointer"
                        >
                            <span>Срок заявки</span>
                            {{
                                new Date(
                                    application.deadline_at
                                ).toLocaleString($page.props.locale)
                            }}
                        </li>
                        <li>
                            <span>№ Маршрут</span>
                            <inertia-link
                                v-if="application.routes.length"
                                :href="
                                    route(
                                        'route.show',
                                        application.routes[0].id
                                    )
                                "
                                class="pointer orange"
                            >
                                {{ application.routes[0].id }}
                            </inertia-link>
                        </li>
                        <li
                            @click="
                                toggleVisibleApplicationCard(application, true)
                            "
                            class="pointer"
                        >
                            <span>№ ОРД:</span>
                            {{ application.document }}
                        </li>
                        <li
                            @click="
                                toggleVisibleApplicationCard(application, true)
                            "
                            class="pointer"
                        >
                            <span>Ответственный:</span>
                            {{ application.user.lastname }}
                            {{ application.user.firstname.charAt(0) }}.
                        </li>
                        <li
                            @click="
                                toggleVisibleApplicationCard(application, true)
                            "
                            class="pointer"
                        >
                            <span>Статус</span>
                            {{ application.status.title }}
                        </li>
                    </ul>
                </div>
            </div>
            <pagination
                v-if="$page.props.applications.meta.last_page > 1"
                :pagination="$page.props.applications.meta"
            >
            </pagination>
        </div>
        <transition name="fade">
            <applicationCard
                v-if="isShowApplicationCard"
                @closeSidebar="
                    () => {
                        detailsApplication = {}
                        isShowApplicationCard = false
                    }
                "
                typeTable="Single"
                :detailsApplication="detailsApplication"
                classTable=".table__wrapper__body"
        /></transition>
        <modalList ref="modalList" />
    </app-layout>
</template>

<script>
import AppLayout from '../../Layouts/AppLayout.vue'
import Calendar from '@/components/calendar'
import Pagination from '@/components/Pagination'
import applicationCard from '@/components/applicationCard'
import modalList from '@/components/modalList'
import Priority from '@/components/priority'
import vClickOutside from 'v-click-outside'
import status from '@/components/status'
import axios from 'axios'
import VSelect from '@/components/v-select'
export default {
    directives: {
        clickOutside: vClickOutside.directive
    },
    components: {
        AppLayout,
        Calendar,
        Pagination,
        applicationCard,
        modalList,
        status,
        Priority,
        VSelect
    },
    data: () => ({
        form: {
            date_from: '',
            date_to: '',
            bts_id: '',
            ticket: '',
            created_from: null,
            id: null,
            statuses: []
        },
        detailsApplication: {},
        isShowApplicationCard: false,
        isVisibleFilterModal: false
    }),
    methods: {
        openModalList(application, type = 'bts') {
            this.$refs.modalList.switchModalStatus(true, application, type)
        },
        switchFilterModal(status = !this.isVisibleFilterModal) {
            this.isVisibleFilterModal = status
        },
        submit() {
            this.$inertia.get(route('application.history'), this.form, {
                preserveScroll: true,
                preserveState: true,
                only: ['applications'],
                bag: 'filter',
                onSuccess: () => {
                    this.switchFilterModal(false)
                }
            })
        },
        resetFilters() {
            this.$inertia.get(
                route('application.history'),
                {},
                {
                    preserveScroll: true,
                    preserveState: true,
                    only: ['applications'],
                    bag: 'filter',
                    onSuccess: () => {
                        this.form = {
                            date_from: '',
                            date_to: '',
                            bts_id: '',
                            ticket: '',
                            created_from: null,
                            id: null
                        }
                        this.$refs.filter_createdAt.resetDate()
                        this.$refs.filter_period.resetDate()
                    }
                }
            )
        },
        redirect(id) {
            window.location.href = route('application.show', id)
        },
        show() {
            this.$modal.show('my-first-modal')
        },
        hide() {
            this.$modal.hide('my-first-modal')
        },
        submitDate(date = null) {
            if (date === null) {
                this.form.date_from = null
                this.form.date_to = null
                return
            }
            this.form.date_from = date.start.toLocaleString()
            this.form.date_to = date.end.toLocaleString()
        },
        toggleVisibleApplicationCard(detailsInfo, status = true) {
            const more_station_btn = document.querySelectorAll(
                '.more_station_btn'
            )
            const btnArr = []
            more_station_btn.forEach(btn => btnArr.push(btn))
            if (btnArr.some(btn => btn.contains(event.target))) {
                this.openModalList(
                    detailsInfo,
                    event.target.dataset.typeList || 'bts'
                )
                return
            }
            this.detailsApplication = detailsInfo
            this.isShowApplicationCard = status
        }
    },
    mount() {
        this.show()
    }
}
</script>

<style lang="scss" scoped></style>
