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
                :action="route('application.area.show', $page.props.area.id)"
                method="get"
                @submit.prevent="submit(false)"
                @change.prevent="submit(false)"
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
                    <!-- <v-select
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
          /> -->
                </div>
                <div class="main-header__check">
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
                <p class="pointer orange textIcon ml24" @click="submit(true)">
                    Сбросить фильтры <span class="material-icons">cancel</span>
                </p>
            </form>
        </template>
        <div class="mtforfirstelement">
            <div class="area__title">
                <div class="table-title">
                    {{ $page.props.area.title }}
                </div>
                <inertia-link class="textIcon" :href="route('dashboard')">
                    Назад
                    <span class="material-icons">undo</span>
                </inertia-link>
            </div>
            <div class="table__wrapper">
                <div class="table__wrapper__head show">
                    <ul>
                        <li>Тип</li>
                        <li>Приоритет</li>
                        <li>№ ОРД</li>
                        <li>№ ПБ</li>
                        <li>Дата</li>
                        <li>Ответственный</li>
                        <li>Вид работ</li>
                        <li>БС</li>
                        <li>Проект</li>
                        <li>Срок</li>
                        <li>Статус</li>
                        <li>
                            <input
                                type="checkbox"
                                @click="selectedAll"
                                :id="`state${$page.props.area.id}`"
                                :checked="isSelectedAll"
                            /><label
                                :for="`state${$page.props.area.id}`"
                            ></label>
                            <span>Выбрать все</span>
                        </li>
                    </ul>
                </div>
                <div
                    class="table__wrapper__body"
                    v-if="$page.props.applications.data.length"
                >
                    <ul
                        v-for="application in $page.props.applications.data"
                        :key="application.id"
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
                            <span>Тип:</span>{{ application.type.title }}
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
                            <span>№ ОРД:</span>
                            {{ application.document }}
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
                            <span>Дата</span>
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
                            <span>Ответственный:</span>
                            {{ application.user.lastname }}
                            {{ application.user.firstname.charAt(0) }}.
                        </li>
                        <li>
                            <span>Вид работ:</span>
                            <p v-if="application.works.length">
                                {{ application.works[0].title }}
                            </p>
                            <p
                                class="mt8 pointer more_station_btn"
                                v-if="application.works.length > 1"
                                data-type-list="works"
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
                            <span class="pro">БС</span>
                            <p v-if="application.stations.length">
                                {{ application.stations[0].bts_id }}
                            </p>
                            <p
                                class="mt8 pointer more_station_btn"
                                v-if="application.stations.length > 1"
                                @click="openModalBts(application)"
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
                            <span>Проект</span>{{ application.project.title }}
                        </li>
                        <li
                            @click="
                                toggleVisibleApplicationCard(application, true)
                            "
                            class="pointer"
                        >
                            <span>Срок</span>
                            {{
                                new Date(
                                    application.deadline_at
                                ).toLocaleString($page.props.locale)
                            }}
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
                                @click="selectApplication(application.id)"
                            />
                            <label :for="`s${application.id}`"></label>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="approval" v-if="selectedApplications.length">
                <p>Отправить заявки на согласование</p>
                <div class="approval__btns">
                    <button class="btn btn-blue" @click="approvalApplication()">
                        Применить
                    </button>
                    <button class="btn btn-dark">
                        Отмена
                    </button>
                </div>
            </div>
        </div>
        <pagination
            v-if="$page.props.applications.meta.last_page > 1"
            :pagination="$page.props.applications.meta"
        >
        </pagination>
        <transition name="fade">
            <applicationCard
                v-if="isShowApplicationCard"
                @closeSidebar="
                    () => {
                        detailsApplication = {}
                        isShowApplicationCard = false
                    }
                "
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
import status from '@/components/status'
import applicationCard from '@/components/applicationCard'
import Pagination from '@/components/Pagination'
import modalList from '@/components/modalList'

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
        Bar,
        Pagination
    },
    data() {
        return {
            form: {
                states: [],
                priority: [],
                types: [],
                ticket: ''
            },
            keyForPie: 1,
            selectedPeriodForCharts: '',
            inper: [],
            inner: false,
            Comments: null,
            selectedApplications: [],
            isSelectedAll: false,
            isShowApplicationCard: false,
            detailsApplication: {}
        }
    },
    watch: {},
    methods: {
        selectedAll() {
            if (this.isSelectedAll) {
                this.selectedApplications = []
                this.isSelectedAll = false
                return
            }
            this.isSelectedAll = true
            this.$page.props.applications.data.forEach(application => {
                const appIsExist = this.selectedApplications.indexOf(
                    application.id
                )
                if (application.is_approvable && appIsExist === -1) {
                    this.selectedApplications.push(application.id)
                }
            })
        },
        selectApplication(appId) {
            const indexAppIdInList = this.selectedApplications.indexOf(appId) // Получаем индекс appId
            if (indexAppIdInList !== -1) {
                this.selectedApplications.splice(indexAppIdInList, 1) // Уже существует, удаляем
                return
            } else {
                this.selectedApplications.push(appId) // не существует, добавляем
            }
        },
        isSelectedApplication(appId) {
            if (this.selectedApplications.indexOf(appId) !== -1) {
                return true
            } else return false
        },
        openModalList(application, type = 'bts') {
            this.$refs.modalList.switchModalStatus(true, application, type)
        },
        submit(isReset = false) {
            if (isReset) {
                this.form = {
                    states: [],
                    priority: [],
                    types: [],
                    ticket: ''
                }
            }
            this.$inertia.get(
                route('application.area.show', this.$page.props.area.id),
                this.form,
                {
                    preserveScroll: true,
                    preserveState: true,
                    only: ['applications']
                }
            )
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
        },
        CloseComments() {
            this.Comments = null
        },
        approvalApplication() {
            this.$inertia.post(route('application.approval'), {
                applications: this.selectedApplications
            })
            this.$notify({
                group: 'bar',
                text: 'Заявки успешно отправлены'
            })
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
    mounted() {
        const url = new URL(window.location.href)
        const params = url.searchParams
        const priorities = []
        const types = []
        for (let i = 0; i <= 6; i++) {
            const priority = params.get(`priority[${i}]`)
            const type = params.get(`types[${i}]`)
            if (priority !== null) {
                priorities.push(priority)
            }
            if (type !== null) {
                types.push(type)
            }
        }
        this.form.priority = priorities
        this.form.types = types
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
