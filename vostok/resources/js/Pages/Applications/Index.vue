<template>
    <app-layout class="request-list">
        <div id="preloads" class="modal-preloader-wrapper">
            <div class="modal-preloader">
                <div class="preloader-1">
                    <div>Loading</div>
                    <span class="line line-1"></span>
                    <span class="line line-2"></span>
                    <span class="line line-3"></span>
                    <span class="line line-4"></span>
                    <span class="line line-5"></span>
                    <span class="line line-6"></span>
                    <span class="line line-7"></span>
                    <span class="line line-8"></span>
                    <span class="line line-9"></span>
                </div>
            </div>
        </div>
        <div class="inner-temp">
            <notifications group="foo" />
            <notifications group="bar" />
            <div class="request-list request-reset main-wrap">
                <div class="base-header">
                    <h1 v-if="$page.props.type">
                        {{ $page.props.type.title }}
                    </h1>
                    <form
                        :action="route('application.index')"
                        @submit.prevent="submit"
                        @change.prevent="submit"
                        method="get"
                    >
                        <div class="options">
                            <v-select
                                :label="{ show: false }"
                                :data="$page.props.areas"
                                keyName="id"
                                optionName="title"
                                typeSelect="whiteSelect"
                                mode="Multiple"
                                ref="filter_area"
                                :resetOption="{
                                    isShow: true,
                                    text: 'Все',
                                    isSendRequestAfterReset: true
                                }"
                                @selected="
                                    area => {
                                        form.areas = area
                                        submit()
                                    }
                                "
                            ></v-select>
                            <div class="calendar_block">
                                <calendar
                                    calendarType="range"
                                    :isShowTime="true"
                                    ref="filter_deadline"
                                    @selectedDate="
                                        date => submitDate(date, 'deadline')
                                    "
                                    @reset="
                                        date => submitDate(date, 'deadline')
                                    "
                                    placeholder="Крайний срок"
                                />
                            </div>
                            <div class="input-search">
                                <input
                                    type="text"
                                    placeholder="№ документа"
                                    v-model="form.ticket"
                                />
                                <span
                                    class="material-icons pointer"
                                    @click="submit"
                                    >search</span
                                >
                            </div>
                            <div class="input-search">
                                <input
                                    type="text"
                                    placeholder="ID БС"
                                    v-model="form.bts_id"
                                />
                                <span
                                    class="material-icons pointer"
                                    @click="submit"
                                    >search</span
                                >
                            </div>
                        </div>
                    </form>
                </div>
                <div class="requestList">
                    <div
                        class="filter__modal"
                        v-if="isActiveFilterModal"
                        v-click-outside="
                            () => (this.isActiveFilterModal = false)
                        "
                    >
                        <div class="filter__modal_elems">
                            <div class="filter__modal_elems__title">
                                <form
                                    :action="route('application.index')"
                                    method="get"
                                    @submit.prevent="submit"
                                >
                                    <div>
                                        <h1>По статусу</h1>
                                        <div class="filter__modal_checkbox">
                                            <v-select
                                                :data="$page.props.statuses"
                                                optionName="title"
                                                ref="statusSelect"
                                                keyName="id"
                                                typeSelect="whiteSelect"
                                                mode="Multiple"
                                                maxWidth="100%"
                                                :resetOption="{
                                                    isShow: true,
                                                    text: 'Сбросить',
                                                    isSendRequestAfterReset: false
                                                }"
                                                @selected="
                                                    statuses => {
                                                        form.statuses = statuses
                                                    }
                                                "
                                                :label="{ show: false }"
                                            />
                                        </div>
                                    </div>
                                    <div class="filter-select-box">
                                        <h1 style="margin-top: 8px">
                                            Проект
                                        </h1>
                                        <v-select
                                            :label="{ show: false }"
                                            ref="typeWorkSelect"
                                            typeSelect="whiteSelect"
                                            :data="$page.props.projects"
                                            keyName="id"
                                            optionName="title"
                                            maxWidth="100%"
                                            mode="Multiple"
                                            :resetOption="{
                                                isShow: true,
                                                text: 'Сбросить',
                                                isSendRequestAfterReset: false
                                            }"
                                            @selected="
                                                projects => {
                                                    form.projects = projects
                                                }
                                            "
                                        ></v-select>
                                    </div>
                                    <div class="filter-select-box">
                                        <h1>По типу работ</h1>
                                        <v-select
                                            :label="{ show: false }"
                                            typeSelect="whiteSelect"
                                            ref="typeWorkSelect2"
                                            :data="$page.props.types"
                                            keyName="id"
                                            maxWidth="100%"
                                            optionName="title"
                                            :resetOption="{
                                                isShow: true,
                                                text: 'Сбросить',
                                                isSendRequestAfterReset: false
                                            }"
                                            @selected="
                                                type => {
                                                    form.type = type
                                                }
                                            "
                                        ></v-select>
                                    </div>
                                    <div class="space-between">
                                        <div>
                                            <input
                                                type="checkbox"
                                                v-model="form.priority"
                                                value="critical"
                                                id="critical"
                                            />
                                            <label for="critical"
                                                >Critical</label
                                            >
                                        </div>
                                        <div>
                                            <input
                                                type="checkbox"
                                                v-model="form.priority"
                                                value="major"
                                                id="major"
                                            />
                                            <label for="major">Major</label>
                                        </div>
                                        <div>
                                            <input
                                                type="checkbox"
                                                v-model="form.priority"
                                                value="minor"
                                                id="minor"
                                            />
                                            <label for="minor">Minor</label>
                                        </div>
                                    </div>
                                    <div
                                        class="space-between filter__modal_btns"
                                    >
                                        <button class="btn" type="submit">
                                            Применить
                                        </button>
                                        <p
                                            class="pointer"
                                            @click="resetFilters"
                                        >
                                            Сбросить
                                        </p>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="filter_option">
                        <div class="filter_option__elems filter_option__item">
                            <div
                                class="pointer filter__btn"
                                @click="switchFilterModal()"
                            >
                                <p class="filter__btn textIcon">
                                    Фильтр заявок
                                    <span class="material-icons"
                                        >filter_alt</span
                                    >
                                </p>
                            </div>
                            <div class="pointer">
                                <a
                                    :href="route('route.create')"
                                    class="orange textIcon pointer"
                                >
                                    Создать маршрут
                                    <span class="material-icons"
                                        >add_circle</span
                                    >
                                </a>
                            </div>
                            <div class="calendar_block filter_option__item">
                                <calendar
                                    calendarType="range"
                                    :isShowTime="true"
                                    ref="filter_created"
                                    @selectedDate="
                                        date => submitDate(date, 'created')
                                    "
                                    @reset="date => submitDate(date, 'created')"
                                    placeholder="Дата создания"
                                />
                            </div>
                        </div>
                        <div id="display_type">
                            <span
                                @click="
                                    changeTheDisplayOfElements('horizontal')
                                "
                                class="material-icons pointer gray"
                            >
                                menu
                            </span>
                            <span
                                class="material-icons pointer gray"
                                @click="changeTheDisplayOfElements('vertical')"
                            >
                                apps
                            </span>
                        </div>
                    </div>
                    <div class="table__wrapper">
                        <div class="table__wrapper__head">
                            <ul>
                                <li>№ заявки</li>
                                <li>Тип работ</li>
                                <li>Приоритет</li>
                                <li style="margin-left: -20px">Проект</li>
                                <li>№ ПБ</li>
                                <li style="margin-left: 15px">БС</li>
                                <li style="margin-left: -10px">
                                    Описание аварии
                                </li>
                                <li>Дата создания</li>
                                <li>Срок заявки</li>
                                <li>№ Маршрута</li>
                                <li style="margin-left: -10px">№ ОРД</li>
                                <li style="margin-left: -20px">
                                    Ответственный РП
                                </li>
                                <li style="margin-left: -15px">Статус</li>
                            </ul>
                        </div>
                        <div
                            class="request-list__content"
                            :class="{
                                type_horizontal: display === 'horizontal',
                                type_vertical: display === 'vertical'
                            }"
                            ref="listApplication"
                        >
                            <div
                                class="request-ist__item"
                                v-for="(application, index) in $page.props
                                    .applications.data"
                                :key="index"
                                @click="closeMenus = true"
                            >
                                <div
                                    :class="{
                                        activeRequestDashboard:
                                            detailsApplication.id ===
                                            application.id,
                                        expired:
                                            new Date() >
                                            new Date(application.deadline_at)
                                    }"
                                    @dblclick="routeApp(application)"
                                    class="table__wrapper__body"
                                >
                                    <ul
                                        class="request-list__info pointer"
                                        ref="cardApplication"
                                        @click="
                                            toggleVisibleApplicationCard(
                                                application,
                                                true
                                            )
                                        "
                                    >
                                        <li>
                                            <span>№ заявки</span>
                                            {{ application.id }}
                                        </li>
                                        <li>
                                            <span>Тип работ:</span
                                            >{{ application.type.title }}
                                        </li>
                                        <li>
                                            <span>Приоритет:</span>
                                            <priority
                                                :status="application.priority"
                                                :class="{
                                                    border_bottom:
                                                        display === 'vertical'
                                                }"
                                            />
                                        </li>
                                        <li>
                                            <span>Проект:</span
                                            >{{ application.project.title }}
                                        </li>
                                        <li>
                                            <span>№ ПБ:</span>
                                            {{ application.ticket }}
                                        </li>
                                        <li>
                                            <span>БС ID:</span>
                                            <p
                                                v-if="
                                                    application.stations.length
                                                "
                                            >
                                                {{
                                                    application.stations[0]
                                                        .bts_id
                                                }}
                                                <a
                                                    class="mt8 more_station_btn"
                                                    v-if="
                                                        application.stations
                                                            .length > 1
                                                    "
                                                >
                                                    Еще
                                                </a>
                                            </p>
                                        </li>
                                        <li>
                                            <span>Описание аварии:</span>
                                            <p>
                                                {{
                                                    typeof application.description ===
                                                    'string'
                                                        ? application.description.slice(
                                                              0,
                                                              25
                                                          ) + '...'
                                                        : 'Ull'
                                                }}
                                            </p>
                                        </li>
                                        <li>
                                            <span>Дата создания</span>
                                            {{
                                                new Date(
                                                    application.created_at
                                                ).toLocaleString(
                                                    $page.props.locale
                                                )
                                            }}
                                        </li>
                                        <li>
                                            <span>Срок заявки:</span>
                                            {{
                                                new Date(
                                                    application.deadline_at
                                                ).toLocaleString(
                                                    $page.props.locale
                                                )
                                            }}
                                        </li>
                                        <li>
                                            <span>№ маршрута</span>
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
                                        <li>
                                            <span>№ ОРД</span>
                                            {{ application.document }}
                                        </li>
                                        <li>
                                            <span>Ответственный РП:</span>

                                            {{ application.user.lastname }}
                                            {{
                                                application.user.firstname.charAt(
                                                    0
                                                )
                                            }}.
                                        </li>
                                        <li>
                                            <span>Статус:</span>
                                            <status
                                                :status="application.status"
                                            />
                                        </li>
                                    </ul>
                                    <a>
                                        <span
                                            class="material-icons trd pointer"
                                            style="display: block"
                                            @click="modalCartMenu = index"
                                            id="switchList"
                                        >
                                            more_horiz
                                        </span>
                                    </a>
                                    <transition name="fade">
                                        <div
                                            class="modal-req"
                                            v-if="modalCartMenu === index"
                                            v-click-outside="closeModalCart"
                                        >
                                            <button
                                                class="modalReqStatus"
                                                @click="
                                                    openModalStatusChange(
                                                        application
                                                    )
                                                "
                                            >
                                                <span
                                                    class="material-icons gray"
                                                    >settings</span
                                                >
                                                Сменить статус
                                            </button>
                                            <!--  -->
                                        </div>
                                    </transition>
                                </div>
                            </div>
                        </div>
                    </div>
                    <pagination
                        v-if="$page.props.applications.meta.last_page > 1"
                        :pagination="$page.props.applications.meta"
                    >
                    </pagination>
                </div>
            </div>
        </div>
        <applicationStatusChange
            :application="application_statusChange"
            ref="status_modal_change"
            keyName="id"
            optionName="title"
            :comment="{
                isShow: true,
                placeholder: ''
            }"
            :statuses="$page.props.statuses"
        />
        <transition name="fade">
            <applicationCard
                v-if="isShowApplicationCard"
                @closeSidebar="func()"
                typeTable="Several"
                :detailsApplication="detailsApplication"
                classTable=".table__wrapper__body"
            />
        </transition>
        <modalList ref="modalList" />
    </app-layout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout'
import VSelect from '@/components/v-select'
import Calendar from '@/components/calendar'
import applicationStatusChange from '@/components/applicationStatusChange'
import Status from '@/components/status'
import Priority from '@/components/priority'
import vClickOutside from 'v-click-outside'
import Pagination from '@/components/Pagination'
import mapboxgl from 'mapbox-gl'
import applicationCard from '@/components/applicationCard'
import modalList from '@/components/modalList'

export default {
    directives: {
        clickOutside: vClickOutside.directive
    },
    components: {
        AppLayout,
        VSelect,
        Calendar,
        Status,
        Priority,
        Pagination,
        applicationCard,
        modalList,
        applicationStatusChange
    },
    data() {
        return {
            application_statusChange: {
                id: null
            },
            form: {
                date_to: '',
                date_from: '',
                created_from: '',
                created_to: '',
                areas: [],
                statuses: [],
                status: [],
                type: '',
                projects: [],
                priority: [],
                ticket: '',
                bts_id: ''
            },
            routeApplications: [],
            modalCartMenu: null,
            activeRequest: null,
            display: 'horizontal',
            activeCalendar: false,
            closeMenus: false,
            visible: false,
            isActiveFilterModal: false,
            isActiveDropdownBrigade: false,
            isActiveModalChangeRoutes: true,
            detailsApplication: {},
            showMoreCompBrigade_sidebar: false,
            showMoreComments_sidebar: false,
            isShowApplicationCard: false
        }
    },
    methods: {
        test() {
            console.log(this.$page.props)
        },
        func() {
            this.isShowApplicationCard = false
        },
        routeApp(application) {
            window.open(`/application/${application.id}`)
        },
        openModalList(application, type = 'bts') {
            this.$refs.modalList.switchModalStatus(true, application, type)
        },
        resetFilters() {
            this.$refs.statusSelect.reset()
            this.$refs.typeWorkSelect.reset()
            this.$refs.typeWorkSelect2.reset()
            this.form.priority = []
            this.$refs.filter_area.reset()
            this.$refs.filter_deadline.resetDate()
            this.$refs.filter_created.resetDate()
            this.form.ticket = null
            this.$inertia.get(
                route('application.index'),
                {},
                {
                    preserveScroll: true,
                    preserveState: true,
                    only: ['applications'],
                    bag: 'filter'
                }
            )
        },
        submitDate(date, type) {
            if (type === 'deadline') {
                if (date === null) {
                    this.form.date_from = null
                    this.form.date_to = null
                    this.submit()
                    return
                }
                this.form.date_from = date.start.toLocaleString()
                this.form.date_to = date.end.toLocaleString()
                this.submit()
            } else if (type === 'created') {
                if (date === null) {
                    this.form.created_from = null
                    this.form.created_to = null
                    this.submit()
                    return
                }
                this.form.created_from = date.start.toLocaleString()
                this.form.created_to = date.end.toLocaleString()
                this.submit()
            }
        },
        submit() {
            this.$inertia.get(route('application.index'), this.form, {
                preserveScroll: true,
                preserveState: true,
                only: ['applications'],
                bag: 'filter'
            })
            this.isActiveFilterModal = false
        },
        selectedArea(area) {
            this.form.area = area
        },
        openModalStatusChange(application) {
            this.application_statusChange = application
            this.$refs.status_modal_change.open()
        },
        mount() {
            this.show()
        },
        changeTheDisplayOfElements(display) {
            this.display = display
        },
        closeModalCart() {
            this.modalCartMenu = null
        },
        switchFilterModal(status = null) {
            status === null
                ? (this.isActiveFilterModal = !this.isActiveFilterModal)
                : (this.isActiveFilterModal = status)
        },
        switchDropdownBrigade(status = null) {
            status === null
                ? (this.isActiveDropdownBrigade = !this.isActiveDropdownBrigade)
                : (this.isActiveDropdownBrigade = status)
        },
        applyFilter() {
            this.switchFilterModal(false)
        },
        toggleVisibleApplicationCard(detailsInfo, status = true) {
            axios
                .get(route('api.application.show', detailsInfo.id))
                .then(response => {
                    this.detailsApplication = response.data.data
                    document
                        .getElementById('preloads')
                        .classList.remove('active')
                    this.isShowApplicationCard = true
                })
            document.getElementById('preloads').classList.add('active')

            const statusModalChange = document.querySelectorAll(
                '.statusModalChange'
            )
            const statusBtnModalChange = []
            statusModalChange.forEach(btn => statusBtnModalChange.push(btn))
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
            if (statusBtnModalChange.some(btn => btn.contains(event.target))) {
                return
            }
            // this.isShowApplicationCard = status
        }
    }
}
</script>

<style></style>
