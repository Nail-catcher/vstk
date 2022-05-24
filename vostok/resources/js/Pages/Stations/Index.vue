<template>
    <app-layout class="Base crud">
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
            <div class="base-header__wrapp space-between">
                <div class="obj-header">
                    <h1>Список базовых станций</h1>
                </div>
                <form
                    :action="route('station.index')"
                    method="get"
                    @change.prevent="submit"
                    @submit.prevent="submit"
                >
                    <div class="base-header__input">
                        <!-- <calendar
                            calendarType="range"
                            :isShowTime="true"
                            @selectedDate="
                                (date) => submitDate(date, 'deadline')
                            "
                            @reset="(date) => submitDate(date, 'deadline')"
                            placeholder="Крайний срок"
                        /> -->
                        <v-select
                            :data="$page.props.areas"
                            style="margin-right: 10px"
                            optionName="title"
                            keyName="id"
                            typeSelect="whiteSelect"
                            :resetOption="{
                                isShow: true,
                                text: 'Все',
                                isSendRequestAfterReset: true
                            }"
                            @selected="selectedState"
                        />
                        <v-select
                            typeSelect="whiteSelect"
                            :data="$page.props.stations.data"
                            optionName="bts_id"
                            keyName="bts_id"
                            :globalSearch="{
                                use: true,
                                api: 'api.station.index',
                                dynamicParam: 'bts_id',
                                paramKey: {
                                    bts_id: null
                                }
                            }"
                            placeholderSearch="ID станции"
                            mode="Search"
                            ref="searchInput"
                            :isShowBtnErase="true"
                            :resetOption="{
                                isShow: true,
                                text: 'Все',
                                isSendRequestAfterReset: true
                            }"
                            @reset="
                                value => {
                                    form.bts_id = value
                                    submit()
                                }
                            "
                            @selected="
                                value => {
                                    form.bts_id = value
                                    submit()
                                }
                            "
                        />
                    </div>
                </form>
            </div>
        </template>
        <!-- <inertia-link
            :href="route('station.create')"
            style="
                display: flex;
                align-items: center;
                cursor: pointer;
                color: black;
            "
        >
            <span>Добавить базовую станцию</span>
            <img :src="require('@/../images/icons/plus.svg').default" alt="" />
        </inertia-link> -->
        <div class="table__wrapper">
            <div class="table__wrapper__head">
                <ul>
                    <li>Базовая станция</li>
                    <li>ID</li>
                    <li>Область</li>
                    <li>Кол-во</li>
                    <li>РП</li>
                    <li>ЭУ</li>
                </ul>
            </div>
            <div class="table__wrapper__body">
                <ul
                    v-for="station in $page.props.stations.data"
                    :key="station.id"
                    @dblclick="routeApp(station)"
                >
                    <li><span>Базовая станция</span>{{ station.title }}</li>
                    <li><span>ID</span>{{ station.bts_id }}</li>
                    <li><span>Область</span>{{ station.state.title }}</li>
                    <li>
                        <span>Кол-во</span>
                        <inertia-link
                            :href="route('station.application', station.id)"
                            class="pointer textRight"
                        >
                            {{
                                $tc(
                                    'pluralization.applications',
                                    station.applications_count
                                )
                            }}
                        </inertia-link>
                    </li>
                    <li><span>РП</span>{{ station.division.title }}</li>
                    <li><span>ЭУ</span>{{ station.area.title }}</li>
                </ul>
            </div>
        </div>
        <pagination
            v-if="$page.props.stations.meta.last_page > 1"
            :pagination="$page.props.stations.meta"
        >
        </pagination>
    </app-layout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout'
import VSelect from '@/components/v-select'
import Pagination from '@/components/Pagination'
import Calendar from '@/components/calendar'

export default {
    components: {
        AppLayout,
        VSelect,
        Pagination,
        Calendar
    },
    data() {
        return {
            form: {
                bts_id: '',
                area: '',
                date_to: '',
                date_from: ''
            }
        }
    },
    methods: {
        // submitDate(date, type) {
        //     if (type === 'deadline') {
        //         if (date === null) {
        //             this.form.date_from = null
        //             this.form.date_to = null
        //             this.submit()
        //             return
        //         }
        //         this.form.date_from = date.start.toLocaleString()
        //         this.form.date_to = date.end.toLocaleString()
        //         this.submit()
        //     } else if (type === 'created') {
        //         if (date === null) {
        //             this.form.created_from = null
        //             this.form.created_to = null
        //             this.submit()
        //             return
        //         }
        //         this.form.created_from = date.start.toLocaleString()
        //         this.form.created_to = date.end.toLocaleString()
        //         this.submit()
        //     }
        // },
        routeApp(station) {
            window.open(`station/${station.id}`)
        },
        uploadImport() {
            setTimeout(() => {
                this.$notify({
                    group: 'foo',
                    text: 'Файл успешно загружен'
                })
                document.getElementById('preloads').classList.remove('active')
            }, 2500)
            document.getElementById('preloads').classList.add('active')
        },
        selectedState(area) {
            this.$refs.searchInput.resetSearch()
            this.form.area = area
            this.submit()
        },
        submit() {
            this.$inertia.get(route('station.index'), this.form, {
                preserveScroll: true,
                preserveState: true,
                only: ['stations'],
                bag: 'filter'
            })
        }
    }
}
</script>
