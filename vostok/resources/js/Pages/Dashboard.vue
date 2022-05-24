<template>
    <app-layout class="dashboard">
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
        <template #header>
            <notifications group="foo" />
            <notifications group="bar" />
            <form
                style="display: flex; align-items: center"
                :action="route('dashboard')"
                method="get"
                @submit.prevent="submit"
                @change.prevent="submit"
            >
                <div>
                    <div class="input-search">
                        <input
                            type="text"
                            placeholder="№ документа"
                            v-model="form.ticket"
                        />
                        <span class="material-icons pointer" @click="submit"
                            >search</span
                        >
                    </div>
                    <v-select
                        :data="$page.props.areas"
                        optionName="title"
                        keyName="id"
                        class="mt8"
                        typeSelect="whiteSelect"
                        mode="Multiple"
                        :resetOption="{
                            isShow: true,
                            text: 'Все',
                            isSendRequestAfterReset: true
                        }"
                        :label="{ show: false }"
                        @selected="
                            area => {
                                form.areas = area
                                submit()
                            }
                        "
                    />
                </div>
                <div class="main-header__dashboardStatusFilter">
                    <inertia-link
                        :class="{
                            activeReq: $page.url === '/dashboard?status[0]=1'
                        }"
                        :href="route('dashboard', { status: [1] })"
                    >
                        Новые заявки
                    </inertia-link>
                    <v-select
                        v-if="$page.props.statuses.data"
                        :data="$page.props.statuses.data"
                        optionName="title"
                        keyName="id"
                        class="mt8"
                        typeSelect="whiteSelect"
                        mode="Multiple"
                        :resetOption="{
                            isShow: true,
                            text: 'Все',
                            isSendRequestAfterReset: true
                        }"
                        :label="{ show: false }"
                        @selected="
                            statuses => {
                                form.statuses = statuses
                                submit()
                            }
                        "
                    />
                </div>
                <div class="main-header__check">
                    <div class="main-wrap-sort">
                        <inertia-link
                            :class="{ activeReq: $page.url === '/dashboard' }"
                            :href="route('dashboard')"
                            >Все заявки
                        </inertia-link>
                    </div>
                    <input
                        type="checkbox"
                        v-model="form.priority"
                        value="critical"
                        id="critical"
                    />
                    <label for="critical">Critical</label>
                    <input
                        type="checkbox"
                        v-model="form.priority"
                        value="major"
                        id="major"
                    />
                    <label for="major">Major</label>
                    <input
                        type="checkbox"
                        v-model="form.priority"
                        value="minor"
                        id="minor"
                    />
                    <label for="minor">Minor</label>
                </div>
                <div class="main-header__check-end">
                    <input
                        type="checkbox"
                        v-model="form.types"
                        value="1"
                        id="abp"
                    />
                    <label for="abp">АВР</label>
                    <input
                        type="checkbox"
                        v-model="form.types"
                        value="2"
                        id="ppr"
                    />
                    <label for="ppr">ППР</label>
                </div>
            </form>
            <div class="main-header__check-end">
                <input
                    type="file"
                    hidden
                    id="pprFile"
                    ref="import"
                    @change.prevents="uploadImport"
                />
                <label for="pprFile" class="textIcon orange">
                    Загрузить ППР
                    <span class="material-icons">publish</span>
                </label>
            </div>
        </template>
        <div
            v-for="(area, index) in $page.props.areas"
            :key="area.id"
            :class="{ mtforfirstelement: index === 0 }"
        >
            <div v-if="area.applications.length" class="area__title">
                <div class="table-title">
                    {{ area.title }}
                </div>
                <inertia-link
                    class="textIcon"
                    :href="
                        route('application.area.show', {
                            area,
                            types: form.types,
                            priority: form.priority
                        })
                    "
                >
                    Показать все
                    <span class="material-icons">visibility</span>
                </inertia-link>
            </div>
            <div class="table__wrapper" v-if="area.applications.length">
                <div class="table__wrapper__head show">
                    <ul>
                        <li>ID</li>
                        <li>Тип работ</li>
                        <li>Приоритет</li>
                        <li>Проект</li>
                        <li style="margin-left: 15px">№ ПБ</li>
                        <li style="margin-left: 15px">БС</li>
                        <li style="margin-left: 15px">Описание аварии</li>
                        <li style="margin-left: 15px">Дата создания</li>
                        <li style="margin-left: 15px">Срок заявки</li>
                        <li>№ Маршрут</li>
                        <li style="margin-left: 15px">№ ОРД</li>
                        <li>Ответственный</li>
                        <li>Статус</li>
                        <li>
                            <input
                                type="checkbox"
                                @click="selectedAll(area.id)"
                                :id="`state${area.id}`"
                                :checked="
                                    isActiveCheckBoxForSelectingAllApp(area.id)
                                "
                            /><label :for="`state${area.id}`"></label>
                            <span>Выбрать все</span>
                        </li>
                    </ul>
                </div>
                <div class="table__wrapper__body">
                    <ul
                        v-for="application in area.applications"
                        :key="application.id"
                        @dblclick="routeApp(application)"
                        :class="{
                            activeRequestDashboard:
                                detailsApplication.id === application.id,
                            expired:
                                new Date() > new Date(application.deadline_at)
                        }"
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
                            <status :status="application.status" />
                        </li>
                        <li
                            class="pointer"
                            @click="
                                toggleVisibleApplicationCard(application, false)
                            "
                        >
                            <input
                                v-if="application.is_approvable"
                                type="checkbox"
                                :id="`s${application.id}`"
                                :checked="isSelectedApplication(application.id)"
                                @click="selectedItem(application.id)"
                            />
                            <label :for="`s${application.id}`"></label>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="approval" v-if="isSelectedAppInTheTable(area.id)">
                <p>Отправить заявки на согласование</p>
                <div class="approval__btns">
                    <button
                        class="btn btn-blue"
                        @click="approvalApplication(area.id)"
                    >
                        Применить
                    </button>
                    <button
                        class="btn btn-dark"
                        @click="unselectApplications(area.id)"
                    >
                        Отмена
                    </button>
                </div>
            </div>
        </div>
        <div class="chart__title">
            <h1>Статистика заявок</h1>
            <calendar
                :isShowApplyBtn="false"
                ref="Calendar"
                :calendarType="'range'"
                :placeholder="'Выбрать период'"
                @selectedDate="date => setDate(date, false)"
                @reset="
                    () => {
                        date = {
                            start: null,
                            end: null
                        }
                        setDate(undefined, false)
                    }
                "
            />
            <div style="margin-left: 16px">
                <input
                    type="checkbox"
                    v-model="statisticByType"
                    value="1"
                    id="avrDownload"
                />
                <label for="avrDownload">АВР</label>
                <input
                    type="checkbox"
                    v-model="statisticByType"
                    value="2"
                    id="pprStatistic"
                />
                <label for="pprStatistic">ППР</label>
            </div>
            <button
                @click="setDate(undefined, true)"
                class="dashboard-btn-statistic"
            >
                Применить
            </button>
        </div>
        <div class="charts">
            <div class="charts__item">
                <div class="chars__item__header">
                    <h2>Заявки по РП</h2>
                    <p class="gray">{{ selectedPeriodForCharts }}</p>
                </div>
                <Pie
                    v-if="
                        charts.appByCity.labels.length &&
                            charts.appByCity.data.length
                    "
                    :labels="charts.appByCity.labels"
                    :data="charts.appByCity.data"
                    :key="keyForPie"
                ></Pie>
            </div>
            <div class="charts__item">
                <div class="chars__item__header">
                    <h2>Заявки по приоритетам</h2>
                    <p class="gray">{{ selectedPeriodForCharts }}</p>
                </div>
                <Pie
                    v-if="
                        charts.appByPriority.labels.length &&
                            charts.appByPriority.data.length
                    "
                    :labels="charts.appByPriority.labels"
                    :data="charts.appByPriority.data"
                    :key="keyForPie"
                ></Pie>
            </div>
            <div class="charts__item">
                <div class="chars__item__header">
                    <h2>Заявки по крайнему сроку</h2>
                    <p class="gray">{{ selectedPeriodForCharts }}</p>
                    <br />
                </div>
                <Bar
                    v-if="
                        charts.workLoad.labels.length &&
                            charts.workLoad.data.length
                    "
                    :labels="charts.workLoad.labels"
                    :data="charts.workLoad.data"
                    :key="keyForPie"
                >
                </Bar>
            </div>
        </div>
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
import Welcome from '@/Jetstream/Welcome'
import VSelect from '@/components/v-select'
import Calendar from '@/components/calendar'
import Pie from '@/Mixins/charts/Pie'
import Bar from '@/Mixins/charts/Bar'
import Priority from '@/components/priority'
import vClickOutside from 'v-click-outside'
import applicationCard from '@/components/applicationCard'
import modalList from '@/components/modalList'
import status from '@/components/status'

export default {
    directives: {
        clickOutside: vClickOutside.directive
    },
    components: {
        AppLayout,
        Welcome,
        VSelect,
        Calendar,
        Pie,
        Priority,
        status,
        applicationCard,
        modalList,
        Bar
    },
    data() {
        return {
            form: {
                states: [],
                priority: [],
                types: [],
                ticket: '',
                statuses: []
            },
            statistic: {
                created_from: null,
                created_to: null
            },
            upload: this.$inertia.form(
                {
                    file: ''
                },
                {
                    bag: 'upload',
                    resetOnSuccess: true
                }
            ),
            keyForPie: 1,
            selectedPeriodForCharts: '',
            inper: [],
            inner: false,
            Comments: null,
            selectedApplications: [],
            isSelectedAll: new Map(),
            statisticByType: [],
            charts: {
                appByCity: {
                    labels: [],
                    data: []
                },
                appByPriority: {
                    labels: [],
                    data: []
                },
                workLoad: {
                    labels: [],
                    data: []
                }
            },
            isShowApplicationCard: false,
            detailsApplication: {},

            date: {
                start: null,
                end: null
            }
        }
    },
    watch: {},
    methods: {
        func() {
            this.isShowApplicationCard = false
        },
        routeApp(application) {
            window.open(`/application/${application.id}`)
        },
        openModalList(application, type = 'bts') {
            this.$refs.modalList.switchModalStatus(true, application, type)
        },

        submit() {
            this.$inertia.get(route('dashboard'), this.form, {
                preserveScroll: true,
                preserveState: true,
                only: ['areas'],
                bag: 'filter'
            })
        },
        uploadImport() {
            this.upload.file = this.$refs.import.files[0]
            console.log(this.upload.file)
            this.upload
                .post(route('application.import'), {
                    preserveScroll: true,
                    preserveState: true,
                    only: ['application'],
                    bag: 'upload'
                })
                .then(response => {
                    console.log(response)
                    document
                        .getElementById('preloads')
                        .classList.remove('active')
                    this.$notify({
                        group: 'foo',
                        text: 'Файл успешно загружен'
                    })
                })
            document.getElementById('preloads').classList.add('active')
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
            // this.isShowApplicationCard = status
        },
        CloseComments() {
            this.Comments = null
        },

        /**
         * @param {object} date
         */
        async setDate(date = this.date, sendRequest = false) {
            if (!date.start && !date.end) {
                const date_n = new Date()
                const y = date_n.getFullYear()
                const m = date_n.getMonth()
                const start_n = new Date(y, m, 1)
                const end_n = new Date(y, m + 1, 0)
                this.date.start = start_n
                this.date.end = end_n
                if (sendRequest) {
                    this.selectedPeriodForCharts = `${start_n.toLocaleString()} - ${end_n.toLocaleString()}`
                }
            } else {
                this.date = date
                if (sendRequest) {
                    this.selectedPeriodForCharts = `${new Date(
                        date.start
                    ).toLocaleString()} - ${new Date(
                        date.end
                    ).toLocaleString()}`
                }
            }
            if (sendRequest) {
                const params = {
                    created_from: new Date(date.start).toLocaleString(),
                    created_to: new Date(date.end).toLocaleString(),
                    types: this.statisticByType
                }
                const getWorkLoadData = () => {
                    return new Promise((resolve, reject) => {
                        try {
                            axios
                                .get(route('api.application.workload'), {
                                    params: {
                                        created_from: params.created_from,
                                        created_to: params.created_to,
                                        types: params.types
                                    }
                                })
                                .then(res => {
                                    ;[
                                        this.charts.workLoad.labels,
                                        this.charts.workLoad.data
                                    ] = [[], []]
                                    res.data.data.forEach(item => {
                                        this.charts.workLoad.labels.push(
                                            new Date(
                                                item.deadline_at
                                            ).toLocaleDateString(
                                                this.$page.props.locale
                                            )
                                        )
                                        this.charts.workLoad.data.push(
                                            item.applications_count
                                        )
                                    })
                                    resolve()
                                })
                        } catch (e) {}
                    })
                }
                const dataByCity = () => {
                    return new Promise(resolve => {
                        try {
                            axios
                                .get(route('api.division.index'), {
                                    params: {
                                        created_from: params.created_from,
                                        created_to: params.created_to,
                                        types: params.types
                                    }
                                })
                                .then(res => {
                                    ;[
                                        this.charts.appByCity.labels,
                                        this.charts.appByCity.data
                                    ] = [[], []]
                                    this.keyForPie++
                                    res.data.data.forEach(item => {
                                        if (item.applications_count) {
                                            this.charts.appByCity.data.push(
                                                item.applications_count
                                            )
                                            this.charts.appByCity.labels.push(
                                                item.title
                                            )
                                        }
                                        resolve()
                                    })
                                })
                        } catch (e) {}
                    })
                }
                const dataByPriority = () => {
                    return new Promise(resolve => {
                        try {
                            axios
                                .get(route('api.priority.index'), {
                                    params: params
                                })
                                .then(res => {
                                    ;[
                                        this.charts.appByPriority.labels,
                                        this.charts.appByPriority.data
                                    ] = [[], []]
                                    if (res.data.data) {
                                        res.data.data.forEach(item => {
                                            this.charts.appByPriority.labels.push(
                                                item.priority
                                            )
                                            this.charts.appByPriority.data.push(
                                                item.applications_count
                                            )
                                        })
                                    }
                                    resolve()
                                })
                        } catch (e) {}
                    })
                }
                dataByCity(), dataByPriority(), getWorkLoadData()
            }
        },
        getApplicationsByStateId(id) {
            const applicationsId = []
            this.$page.props.areas.forEach(area => {
                if (area.id === id) {
                    area.applications.forEach(application => {
                        applicationsId.push(application.id)
                    })
                }
            })
            return applicationsId
        },
        unselectApplications(id) {
            this.isSelectedAll.delete(id)
            this.getApplicationsByStateId(id).forEach(applicationId => {
                const idx = this.selectedApplications.indexOf(applicationId)
                if (idx > -1) {
                    this.selectedApplications.splice(idx, 1)
                }
            })
        },
        isActiveCheckBoxForSelectingAllApp(id) {
            if (this.isSelectedAll.has(id)) {
                return true
            }
            return false
        },
        isSelectedAppInTheTable(id) {
            const applicationsId = this.getApplicationsByStateId(id)
            for (const appId of applicationsId) {
                if (this.isSelectedApplication(appId)) {
                    return true
                }
            }
            return false
        },

        selectedAll(areaId) {
            const listAppIdByAreaId = this.$page.props.areas
                .map(area => {
                    if (area.id === areaId) {
                        const ids = []
                        area.applications.forEach(app => {
                            if (app.is_approvable) {
                                ids.push(app.id)
                            }
                        })
                        return ids
                    }
                })
                .filter(el => el)[0] // Получаем все заявки по городу stateId
            if (!this.isSelectedAll.has(areaId)) {
                listAppIdByAreaId.forEach(appId => {
                    const AppIdisExistInList = true
                        ? this.selectedApplications.push(appId) !== -1
                        : false // Проверяем существует ли айди заявки в массиве
                    if (!AppIdisExistInList) {
                        this.selectedApplications.push(appId) // Не существует, добавляем
                    }
                })
                this.isSelectedAll.set(areaId, true)
                // Для города stateid уже выполнился этот функция для вapыбора всех элементов, отмечаем
            } else {
                // Функция уже была выполнена для города stateId, удаляем из массива выбранных элементов заявки по городу stateId
                listAppIdByAreaId.forEach(appId => {
                    const indexInList = this.selectedApplications.indexOf(appId)
                    if (indexInList !== -1) {
                        this.selectedApplications.splice(indexInList, 1)
                    }
                })
                this.isSelectedAll.delete(areaId)
                // Сбрасываем флаг выполнения функции для города stateId
            }
        },
        isSelectedApplication(appId) {
            if (this.selectedApplications.indexOf(appId) !== -1) {
                return true
            } else return false
            // Если переданный appId уже существует в массиве, значит он выбран, возвращаем true для аттрибута checked, иначе false
        },
        selectedItem(appId) {
            const indexAppIdInList = this.selectedApplications.indexOf(appId) // Получаем индекс appId
            if (indexAppIdInList !== -1) {
                this.selectedApplications.splice(indexAppIdInList, 1) // Уже существует, удаляем
                return
            } else {
                this.selectedApplications.push(appId) // не существует, добавляем
            }
        },
        approvalApplication(areaId) {
            this.$inertia.post(route('application.approval'), {
                applications: this.selectedApplications
            })
            this.$notify({
                group: 'bar',
                text: 'Заявки успешно отправлены'
            })
            this.selectedAll(areaId)
        }
    },
    computed: {
        filters() {
            var self = this
            const filtered = this.$page.props.areas.filter(function(area) {
                return area.title.indexOf(self.inper) > -1
            })
            return filtered
        }
    },
    created() {},
    mounted() {
        this.setDate(undefined, true)
    }
}
</script>

<style lang="scss">
.chart__title {
    margin-top: 46px;
    display: flex;
    align-items: center;

    h1 {
        font-size: 20px;
        color: #000505;
        padding-right: 24px;
        font-weight: 600;
    }
}

.mtforfirstelement {
    margin-top: 150px;
}

@media (min-width: 1025px) and (max-width: 1300px) {
    .mtforfirstelement {
        margin-top: 150px;
    }
}

@media (max-width: 1024px) {
    .mtforfirstelement {
        margin-top: 40px;
    }
}
</style>
