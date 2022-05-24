<template>
    <app-layout class="createz">
        <div class="request">
            <h1>Создание заявки</h1>
            <v-select
                typeSelect="whiteSelect"
                :data="$page.props.areas"
                optionName="title"
                keyName="id"
                :isRadioButton="true"
                :label="{
                    show: true
                }"
                placeholderSearch="Выберите регион"
                @selected="getStationsByAreaId"
                @reset="
                    () => {
                        stations = []
                        form.area = null
                        filter.area = null
                    }
                "
                :isShowBtnErase="true"
                mode="Search"
            />
            <!-- <v-select
                :label="{ show: false }"
                :data="$page.props.areas"
                keyName="id"
                title="Выбор ЭУ"
                optionName="title"
                typeSelect="whiteSelect"
                mode="Single"
                id="filterAreasInRequestCreate"
                @selected="getStationsByAreaId"
            ></v-select> -->
            <form
                :action="route('application.store')"
                method="post"
                style="margin-top: 10px"
                @submit.prevent="createApplication"
            >
                <v-select
                    typeSelect="whiteSelect"
                    :data="$page.props.projects"
                    optionName="title"
                    keyName="id"
                    @selected="
                        project => {
                            form.project = project
                            getStationsByAreaId(form.area, project)
                        }
                    "
                    :label="{ show: true, text: 'Проект' }"
                />
                <div class="request__block mt16">
                    <div class="request__inputs">
                        <div>
                            <label class="label">Номер БС</label>
                            <v-select
                                v-if="filter.area && stations.length"
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
                                        area: form.area,
                                        project: form.project
                                    }
                                }"
                                :isShowBtnErase="true"
                                :isShowBtnDone="true"
                                @selected="changeStation"
                                :label="{ show: false }"
                                :isShowValidationLabes="true"
                                :key="form.area"
                                @reset="
                                    () => {
                                        responsibleUsers = ''
                                        form.user = []
                                    }
                                "
                            />
                            <p v-else>{{ alertTextIfStationsOrAreaEmpty }}</p>
                            <jet-input-error
                                :message="form.error('stations')"
                            />
                        </div>
                        <div>
                            <label class="label">Срок выполнения</label>
                            <calendar
                                calendarType="simple"
                                :isShowTime="true"
                                @selectedDate="
                                    date => {
                                        form.deadline_at = date
                                    }
                                "
                            />
                            <jet-input-error
                                :message="form.error('deadline_at')"
                            />
                            <p v-if="isShowAlertTextDeadlineCalendar">
                                Нельзя указывать срок раньше текущей даты
                            </p>
                        </div>
                    </div>
                    <div class="request-input">
                        <p class="label">Ответственный РП / ЭУ</p>

                        <input
                            style="font-size: 16px"
                            type="text"
                            :key="responsibleUsers"
                            v-model="responsibleUsers"
                            readonly
                        />
                    </div>
                    <!-- <v-select
                        v-if="users.length"
                        typeSelect="whiteSelect"
                        :data="users"
                        optionName="lastname"
                        keyName="id"
                        :key="form.area"
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
                    /> -->
                    <jet-input-error :message="form.error('engineer')" />
                    <jet-input-error :message="form.error('project')" />
                    <v-select
                        typeSelect="whiteSelect"
                        :data="$page.props.types"
                        optionName="title"
                        keyName="id"
                        @selected="
                            type => {
                                form.type = type
                            }
                        "
                        :label="{ show: true, text: 'Тип работ' }"
                    />
                    <jet-input-error :message="form.error('type')" />
                    <!-- <v-select
                        typeSelect="whiteSelect"
                        :data="$page.props.works"
                        optionName="title"
                        keyName="id"
                        mode="MultipleSearch"
                        @selected="
                            works => {
                                form.works = works
                            }
                        "
                        :label="{ show: true, text: 'Вид работ' }"
                    /> -->
                    <jet-input-error :message="form.error('works')" />
                    <div class="request-textarea mt8">
                        <label for="description" class="label">
                            Описание аварии
                        </label>
                        <textarea
                            id="description"
                            style="font-size: 16px"
                            placeholder="Написать описание аварии"
                            v-model="form.description"
                        ></textarea>
                        <jet-input-error :message="form.error('description')" />
                    </div>
                    <div class="request-input" v-if="form.type !== 2">
                        <p class="label">Номер проблемного билета</p>
                        <input
                            style="font-size: 16px"
                            type="text"
                            placeholder="Введите номер"
                            v-model="form.ticket"
                        />
                        <jet-input-error :message="form.error('ticket')" />
                    </div>
                    <div class="request-textarea mt16">
                        <label for="comment" class="label">
                            Описание заявки
                        </label>
                        <textarea
                            id="comment"
                            style="font-size: 16px"
                            placeholder="Написать описание заявки"
                            v-model="form.comment"
                        ></textarea>
                        <jet-input-error :message="form.error('comment')" />
                    </div>
                    <div class="request-radio">
                        <input
                            id="critical"
                            v-model="form.priority"
                            name="req-radio"
                            type="radio"
                            value="critical"
                        />
                        <label for="critical">Critical</label>
                        <input
                            id="major"
                            v-model="form.priority"
                            name="req-radio"
                            type="radio"
                            value="major"
                        />
                        <label for="major">Major</label>
                        <input
                            id="minor"
                            v-model="form.priority"
                            name="req-radio"
                            type="radio"
                            value="minor"
                        />
                        <label for="minor">Minor</label>
                    </div>
                    <jet-input-error :message="form.error('priority')" />
                </div>
                <!-- <div class="request__block">
                    <h1>Ключи</h1>
                    <div class="request__checkbox">
                        <input
                            id="key"
                            v-model="form.pickup_keys"
                            type="checkbox"
                        />
                        <label for="key">Забрать ключи</label>
                        <jet-input-error :message="form.error('pickup_keys')" />
                    </div>
                    <div class="request-textarea">
                        <textarea
                            v-model="form.keys_comment"
                            :disabled="!form.pickup_keys"
                            placeholder="Написать комментарий"
                        ></textarea>
                        <jet-input-error
                            :message="form.error('keys_comment')"
                        />
                    </div>
                </div> -->
                <button
                    type="submit"
                    class="request-button"
                    :disabled="form.processing"
                >
                    Создать
                </button>
            </form>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout'
import VSelect from '@/components/v-select'
import Calendar from '@/components/calendar'
import JetInputError from '@/Jetstream/InputError'
import vClickOutside from 'v-click-outside'
import axios from 'axios'
import area from '@turf/area'

export default {
    components: {
        AppLayout,
        VSelect,
        Calendar,
        JetInputError
    },
    directives: {
        clickOutside: vClickOutside.directive
    },
    data() {
        return {
            filter: {
                area: null
            },
            isShowAlertTextDeadlineCalendar: false,
            responseFromStationsApiIsReceived: false,
            stat: false,
            stations: [],
            responsibleUsers: '',
            users: [],
            form: this.$inertia.form(
                {
                    area: '',
                    stations: [],
                    project: null,
                    users: [],
                    type: 0,
                    works: [],
                    user: [],
                    deadline_at: new Date(),
                    comment: '',
                    description: '',
                    ticket: '',
                    priority: 'minor',
                    pickup_keys: false,
                    keys_comment: '',
                    engineer: ''
                },
                {
                    bag: 'createApplication',
                    resetOnSuccess: true
                }
            )
        }
    },
    watch: {
        'form.area': {
            handler() {
                this.form.stations = []
                this.form.engineer = null
            }
        },
        'form.deadline_at': {
            handler(val) {
                if (new Date(val) <= new Date()) {
                    this.isShowAlertTextDeadlineCalendar = true
                } else {
                    this.isShowAlertTextDeadlineCalendar = false
                }
            }
        }
    },
    methods: {
        createApplication() {
            this.form.deadline_at = this.form.deadline_at.toLocaleString(
                this.$page.props.locale
            )
            this.form
                .post(route('application.store'), {
                    preserveScroll: true
                })
                .then(response => {
                    this.form.processing = false
                })
                .catch(error => {
                    this.form.processing = false
                })
        },
        getUsersByArea() {
            if (this.form.area) {
                axios
                    .get(route('api.user.index'), {
                        params: {
                            area: this.form.area,
                            roles: [4]
                        }
                    })
                    .then(res => (this.users = res.data.data))
            }
        },
        getStationsByAreaId(areaId = '', project = this.form.project) {
            this.filter.area = areaId
            this.form.area = areaId
            this.getUsersByArea(areaId)
            this.stations = []
            this.responseFromStationsApiIsReceived = false
            const form = {}
            if (this.filter.area) {
                form.area = this.filter.area
            }
            if (this.form.project) {
                form.project = this.form.project
            }
            axios.get(route('api.station.index', form)).then(result => {
                this.stations = result.data.data.map(station => {
                    station.area_title = station.area.title
                    return station
                })
                this.responseFromStationsApiIsReceived = true
            })
        },
        changeStation(stationList) {
            this.form.user = []
            this.form.stations = stationList
            this.responsibleUsers = ''
            stationList.forEach((item, index) => {
                this.stations.forEach(station => {
                    this.responsibleUsers = `${station.division.user.lastname} ${station.division.user.firstname[0]}.`
                    if (station.id === item) {
                        this.responsibleUsers = `${station.division.user.lastname} ${station.division.user.firstname[0]}.`
                        this.form.user = station.division.user.id
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
        this.stations = this.getStationsByAreaId()
    },
    computed: {
        alertTextIfStationsOrAreaEmpty() {
            if (!this.form.area) {
                return 'Выберите ЭУ'
            } else if (
                this.form.area &&
                !this.stations.length &&
                this.responseFromStationsApiIsReceived
            ) {
                return 'Список БС по выбранному ЭУ не найден'
            } else {
                return 'Загрузка...'
            }
        }
    }
}
</script>
