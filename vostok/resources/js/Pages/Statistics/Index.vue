<template>
    <app-layout class="createz">
        <div class="request" style="max-width: 708px">
            <div class="obj-header">
                <h1>Статистика по заявкам</h1>
            </div>
            <form
                :action="route('application.store')"
                method="post"
                style="margin-top: 10px"
                @submit.prevent="createApplication"
            >
                <div class="request__block">
                    <div style="align-items: center" class="request__inputs">
                        <div>
                            <label class="label">Выберите дату</label>
                            <calendar
                                ref="Calendar"
                                calendarType="range"
                                placeholder="Выбрать период"
                                @selectedDate="
                                    date => {
                                        form.from = date.start
                                        form.to = date.end
                                    }
                                "
                            />
                        </div>
                        <div>
                            <label for="region">Регион</label>
                            <v-select
                                :label="{ show: false }"
                                :data="$page.props.areas"
                                keyName="id"
                                title="Выбор ЭУ"
                                optionName="title"
                                typeSelect="whiteSelect"
                                mode="Single"
                                id="filterAreasInRequestCreate"
                                @selected="getStationsByAreaId"
                            ></v-select>
                        </div>
                        <div>
                            <label for="region">Вид работ</label>
                            <v-select
                                v-if="$page.props.works"
                                typeSelect="whiteSelect"
                                :data="$page.props.works"
                                optionName="title"
                                keyName="id"
                                mode="Search"
                                typeSearch="Multiple"
                                :isShowBtnErase="true"
                                :isShowBtnDone="true"
                                @selected="works => (form.works = works)"
                                :label="{ show: false }"
                                :isShowValidationLabes="true"
                                @reset="
                                    () => {
                                        form.works = []
                                    }
                                "
                            />
                        </div>
                        <v-select
                            v-if="engineers.length"
                            typeSelect="whiteSelect"
                            :data="engineers"
                            optionName="lastname"
                            keyName="id"
                            :withInitial="{
                                isActive: true,
                                optionName: 'firstname'
                            }"
                            :isRadioButton="true"
                            :label="{
                                show: true,
                                text: 'Ответственный инженер (РП)'
                            }"
                            @selected="
                                user => {
                                    form.engineer = user
                                }
                            "
                            :isShowBtnErase="true"
                            :resetOption="{
                                isShow: true,
                                text: 'Сбросить',
                                isSendRequestAfterReset: true
                            }"
                            :key="form.area"
                            :globalSearch="{
                                use: true,
                                api: 'api.user.index',
                                dynamicParam: 'lastname',
                                paramKey: {
                                    lastname: null,
                                    area: form.area,
                                    roles: [4]
                                }
                            }"
                            mode="Search"
                        />
                        <div
                            style="margin-bottom: 54px"
                            class="request-input"
                            v-if="form.area"
                        >
                            <p class="label">Выгрузить по отдельным БС</p>
                            <input
                                type="checkbox"
                                id="checked"
                                v-model="stat"
                            />
                            <label for="checked" style="display: block"></label>
                            <div v-if="stat === true" style="margin-top: 22px">
                                <label class="label">Номер БС</label>
                                <v-select
                                    typeSelect="whiteSelect"
                                    :data="stations"
                                    optionName="bts_id"
                                    keyName="id"
                                    mode="Search"
                                    typeSearch="Multiple"
                                    :additionalField="{
                                        isRef: true,
                                        isShow: true,
                                        optionName: 'area_title'
                                    }"
                                    :globalSearch="{
                                        use: true,
                                        api: 'api.station.index',
                                        dynamicParam: 'bts_id',
                                        paramKey: {
                                            bts_id: null,
                                            area: form.area
                                        }
                                    }"
                                    @selected="changeStation"
                                    :isShowBtnErase="true"
                                    :isShowBtnDone="true"
                                    :label="{ show: false }"
                                    :isShowValidationLabes="true"
                                    @reset="
                                        () => {
                                            responsibleUsers = ''
                                            form.user = []
                                        }
                                    "
                                />
                            </div>
                            <!-- <button v-if="stat" style="min-height: auto; min-width: auto; margin-top: 15px" class="request-button">Выгрузить</button> -->
                        </div>
                        <!-- <div>
                            <label>Сформировать документ</label>
                            <vue-excel-xlsx
                                style="background: #000; display: block; color: #fff"
                                :data="data"
                                :columns="columns"
                                :filename="'filename'"
                                :sheetname="'sheetname'"
                            >
                                Click me
                            </vue-excel-xlsx>
                        </div> -->
                    </div>
                </div>
            </form>
        </div>
        <div class="main-wrap reports">
            <!-- <div class="base-header">
                <h1>Статистика по заявкам</h1>
            </div> -->
            <!-- <div class="reports__content">
                <div class="reports__content__header">
                    <h2>Выгрузить отчеты по заявкам</h2>
                </div>
                <div class="reports__content__body">
                    <label for="date">Дата:</label>
                    <calendar
                        ref="Calendar"
                        :calendarType="'range'"
                        :placeholder="'Выбрать период'"
                        @selectedDate="setDate"
                    />
                    <div class="row">
                        <div>
                            <label for="region">Регион</label>
                            <input type="text" id="region" />
                        </div>
                        <div>
                            <label for="documents">Документы</label>
                        </div>
                    </div>
                </div>
            </div> -->
            <a
                :href="
                    route('statistics.applications', {
                        created_from: form.from.toLocaleString(
                            $page.props.locale
                        ),
                        created_to: form.to.toLocaleString($page.props.locale),
                        area: form.area,
                        works: form.works,
                        engineer: form.engineer,
                        stations: form.stations
                    })
                "
                target="_blank"
                class="btn btn-orange"
                >Выгрузить отчеты</a
            >
        </div>
    </app-layout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout'
import VSelect from '@/components/v-select'
import Calendar from '@/components/calendar'
import vClickOutside from 'v-click-outside'

export default {
    components: {
        AppLayout,
        VSelect,
        Calendar
    },
    directives: {
        clickOutside: vClickOutside.directive
    },
    data() {
        return {
            stat: false,
            filter: {
                area: null
            },
            stations: [],
            engineers: [],
            responsibleUsers: '',
            form: {
                from: '',
                to: '',
                area: '',
                works: [],
                engineer: '',
                stations: []
            }
        }
    },
    methods: {
        getStationsByAreaId(areaId = '') {
            this.filter.area = areaId
            this.form.area = areaId
            axios
                .get(
                    route('api.station.index', {
                        area: this.filter.area
                    })
                )
                .then(result => {
                    this.stations = result.data.data.map(station => {
                        station.area_title = station.area.title
                        return station
                    })
                })
            axios
                .get(
                    route('api.user.index', {
                        area: this.filter.area
                    })
                )
                .then(res => (this.engineers = res.data.data))
        },
        changeStation(stationList) {
            this.form.user = []
            this.form.station = []
            this.responsibleUsers = ''
            stationList.forEach((item, index) => {
                this.stations.forEach(station => {
                    if (station.id === item) {
                        this.responsibleUsers = `${station.division.user.lastname} ${station.division.user.firstname[0]}.`
                        this.form.user = station.division.user.id
                        this.form.stations.push(station.id)
                    }
                })
            })
            // this.form.user = `${user.lastname} ${user.firstname[0]}.`
        },
        setAreaTitleOnStations(stations, areas = this.$page.props.areas) {
            stations = stations.map(station => {
                areas.forEach(area => {
                    if (station.area_id === area.id) {
                        station.area_title = area.title
                        return station
                    }
                })
                return station
            })
            return stations
        }
    },
    mounted() {
        this.getStationsByAreaId()
    }
}
</script>

<style scoped></style>
