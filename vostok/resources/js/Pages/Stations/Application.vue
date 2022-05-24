<template>
    <app-layout class="createz">
        <div class="history-page">
            <div class="base-header">
                <div class="base-header__wrapp">
                    <h1>История заявок БС {{ $page.props.station.bts_id }}</h1>
                </div>
            </div>
            <div class="table__wrapper">
                <div style="padding: 0px 5px" class="table__wrapper__head">
                    <ul>
                        <li>БС ID</li>
                        <li>№ ОРД</li>
                        <li>№ ПБ</li>
                        <li>Крайний срок</li>
                        <li>Дата обслуживания</li>
                        <li>Ответственный</li>
                        <li>Проект</li>
                        <li>Тип работ</li>
                        <li>Вид работ</li>
                        <li>Статус</li>
                    </ul>
                </div>
                <div class="table__wrapper__body">
                    <ul
                        class="pointer"
                        v-for="application in $page.props.applications.data"
                        :key="application.id"
                        :class="{
              activeRequestDashboard: detailsApplication.id === application.id,
            }"
                        @click="toggleVisibleApplicationCard(application, true)"
                    >
                        <li>
                            <span>БС ID:</span>
                            <p v-if="application.stations.length">
                                {{ application.stations[0].bts_id }}
                            </p>
                            <p
                                class="mt8 pointer more_station_btn"
                                @click="openModalBts(application)"
                                v-if="application.stations.length > 1"
                            >
                                Еще
                            </p>
                        </li>
                        <li><span>№ ОРД:</span>{{ application.document }}</li>

                        <li><span>№ ПБ:</span>{{ application.ticket }}</li>
                        <li>
                            <span>Крайний срок:</span>
                            {{
                                new Date(application.deadline_at).toLocaleString(
                                    $page.props.locale
                                )
                            }}
                        </li>
                        <li>
                            <span>Дата обслуживания:</span>
                            {{
                                new Date(application.deadline_at).toLocaleString(
                                    $page.props.locale
                                )
                            }}
                        </li>
                        <li>
                            <span>Ответственный:</span>
                            {{ application.user.lastname }}
                            {{ application.user.firstname.charAt(0) }}.
                        </li>
                        <li><span>Проект:</span>{{ application.project.title }}</li>
                        <li><span>Тип работ:</span>{{ application.type.title }}</li>
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
                        <li>
                            <span>Статус:</span>
                            <p
                                :class="{
                  workType: application.status.title === 'В работе',
                  newType: application.status.title === 'Новая',
                  acceptType: application.status.title === 'Принята',
                  noAcceptType: application.status.title === 'Не принята',
                  noAccept: application.status.title === 'Не выполнена',
                  accept: application.status.title === 'Выполнена',
                }"
                            >
                                {{ application.status.title }}
                            </p>
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
        />
        <modalList ref="modalList"/>
    </app-layout>
</template>

<script>
import AppLayout from '../../Layouts/AppLayout.vue'
import Calendar from '@/components/calendar'
import Pagination from '@/components/Pagination'
import applicationCard from '@/components/applicationCard'
import modalList from '@/components/modalList'

export default {
    components: {
        AppLayout,
        Calendar,
        Pagination,
        applicationCard,
        modalList,
    },
    data: () => ({
        form: {
            date_from: '',
            date_to: '',
            bts_id: '',
            ticket: '',
        },
        detailsApplication: {},
        isShowApplicationCard: false,
    }),
    methods: {
        openModalList(application, type = 'bts') {
            this.$refs.modalList.switchModalStatus(true, application, type)
        },
        submit() {
            this.$inertia.get(route('application.history'), this.form, {
                preserveScroll: true,
                preserveState: true,
                only: ['applications'],
                bag: 'filter',
            })
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
                this.submit()
                return
            }
            this.form.date_from = date.start.toLocaleString()
            this.form.date_to = date.end.toLocaleString()
            this.submit()
        },
        toggleVisibleApplicationCard(detailsInfo, status = true) {
            const statusModalChange = document.querySelectorAll(
                '.statusModalChange'
            )
            const statusBtnModalChange = []
            statusModalChange.forEach((btn) => statusBtnModalChange.push(btn))
            const more_station_btn = document.querySelectorAll(
                '.more_station_btn'
            )
            const btnArr = []
            more_station_btn.forEach((btn) => btnArr.push(btn))
            if (btnArr.some((btn) => btn.contains(event.target))) {
                this.openModalList(
                    detailsInfo,
                    event.target.dataset.typeList || 'bts'
                )
                return
            }
            if (
                statusBtnModalChange.some((btn) => btn.contains(event.target))
            ) {
                return
            }
            this.detailsApplication = detailsInfo
            this.isShowApplicationCard = status
        },
    },
    mount() {
        this.show()
    },
}
</script>

<style lang="scss" scoped></style>
