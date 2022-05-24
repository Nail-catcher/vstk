<template>
    <app-layout class="createz">
        <vMapPlaceShow ref="placeMap" :place="placeOnMap" />

        <div class="base-header">
            <h1>Создать маршрут</h1>
        </div>
        <!-- <v-select
            class="mt24"
            :label="{ show: false }"
            :data="$page.props.areas"
            keyName="id"
            title="Выбор ЭУ"
            optionName="title"
            typeSelect="whiteSelect"
            mode="Single"
            :resetOption="{
                isShow: true,
                text: 'Сбросить',
                isSendRequestAfterReset: true
            }"
            @selected="getApplicationsByState"
        ></v-select> -->
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
            @selected="
                area_id => {
                    getAddressesByArea(area_id)
                    getVehiclesByArea(area_id)
                }
            "
            :isShowBtnErase="true"
            mode="Search"
        />
        <div class="block32 whiteBg create-route-block">
            <h1>Ответственный</h1>
            <v-select
                v-if="users.length"
                typeSelect="whiteSelect"
                :data="users"
                optionName="lastname"
                keyName="id"
                :withInitial="{
                    isActive: true,
                    optionName: 'firstname'
                }"
                :isRadioButton="true"
                :label="{
                    show: false
                }"
                :key="form.area"
                @selected="
                    user => {
                        getApplicationsByAreaAndEngineer(user)
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
            />
            <!-- <v-select
                v-if="users.length"
                typeSelect="whiteSelect"
                :data="users"
                optionName="lastname"
                keyName="id"
                mode="Search"
                typeSearch="whiteSelect"
                :additionalField="{
                    isShow: true,
                    optionName: 'test',
                }"
                :isShowBtnErase="true"
                @selected="
                    (user) => {
                        form.engineer = user
                    }
                "
                :label="{ show: false }"
            /> -->
            <!-- <v-select
                :data="$page.props.users"
                optionName="lastname"
                keyName="id"
                typeSelect="whiteSelect"
                :label="{ show: false }"
                @selected="
                    (user) => {
                        form.user = user
                    }
                "
            /> -->
        </div>
        <div class="block32 whiteBg create-route-block">
            <h1>Заявки на маршруте</h1>
            <div class="create-route__request">
                <div
                    class="create-route__request_item"
                    v-for="(item, index) in applications"
                    :key="index"
                >
                    <span class="round roundRed">{{ index + 1 }}</span>
                    <div class="create-route__request_item__body">
                        <p v-if="item.ticket">{{ item.ticket }}</p>
                        <p v-else>{{ item.document }}</p>
                        <p v-if="item.stations.length">
                            {{ item.stations[0].bts_id }}
                            <span
                                @click="openModalBts(item)"
                                class="more_bts_btn"
                                v-if="item.stations.length > 1"
                                ><br />
                                Еще</span
                            >
                        </p>
                        <p>{{ item.area.title }}</p>
                        <p>{{ item.type.title }}</p>
                        <div>
                            <input
                                :id="`app-${item.id}`"
                                type="radio"
                                @click="mainApplication = item.id"
                                :checked="mainApplication === item.id"
                            />
                            <label :for="`app-${item.id}`">Главная</label>
                        </div>
                        <span
                            class="material-icons gray pointer"
                            id="delete"
                            @click="deleteApplication(item.id)"
                            >delete</span
                        >
                    </div>
                </div>
            </div>
            <div>
                <ul>
                    <li v-if="placesToSleep.length">
                        <span style="display: flex" class=""
                            >Место ночлега:<span
                                class="text-blue-hover pointer"
                                v-for="place in placesToSleep"
                                :key="place.id"
                                @click="showPlaceOnMap(place)"
                                >{{ place.title }}
                            </span>
                            <span
                                class="material-icons pointer"
                                @click="placesToSleep = []"
                                >close</span
                            >
                        </span>
                    </li>
                    <li class="mt8" v-if="placesOfCollectionOfKeys.length">
                        <span style="display: flex" class=""
                            >Место забора ключей:
                            <span
                                class="text-blue-hover pointer"
                                v-for="place in placesOfCollectionOfKeys"
                                :key="place.id"
                                @click="showPlaceOnMap(place)"
                                >{{ place.title }}
                            </span>
                            <span
                                class="material-icons pointer"
                                @click="placesOfCollectionOfKeys = []"
                                >close</span
                            >
                        </span>
                    </li>
                </ul>
                <br />
            </div>
            <p class="textIcon pointer" @click="openCreateRouteModal">
                <img
                    :src="require('@/../images/icons/plus.svg').default"
                    alt=""
                />
                Добавить заявки и адреса на маршрут
            </p>
        </div>
        <div class="block32 whiteBg create-route-block">
            <h1>Период маршрута</h1>
            <calendar
                calendarType="range"
                :isShowTime="true"
                @selectedDate="
                    date => {
                        form.started_at = date.start.toLocaleString()
                        form.deadline_at = date.end.toLocaleString()
                    }
                "
                @reset="() => {}"
                placeholder="Период маршрута"
            />
            <div class="mt32">
                <div>
                <h1>Вид транспорта</h1>
                <v-select

                        typeSelect="whiteSelect"
                        :data="vehicle_types"
                        optionName="title"
                        keyName="id"
                        placeholderSearch="Выберите вид транспорта"
                        mode="Search"
                        :globalSearch="{
                        use: true,
                        api: 'api.vehicle_types.index',
                    }"
                        :isShowBtnErase="true"
                        :resetOption="{
                        isShow: true,
                        text: 'Все',
                        isSendRequestAfterReset: true
                    }"
                        :key="form.area"
                        @reset="
                        value => {
                            form.vehicle_type = value
                        }
                    "
                        @selected="
                        value => {
                            form.vehicle_type = value
                        }
                    "
                />
            </div>
                <div v-if="form.vehicle_type==1">
                <h1>Транспорт</h1>
                <v-select
                    v-if="vehicles.length"
                    typeSelect="whiteSelect"
                    :data="vehicles"
                    optionName="number"
                    keyName="id"
                    placeholderSearch="Выберите транспорт"
                    mode="Search"
                    :globalSearch="{
                        use: true,
                        api: 'api.vehicles.index',
                        dynamicParam: 'title',
                        paramKey: {
                            title: null,
                            area: form.area
                        }
                    }"
                    :isShowBtnErase="true"
                    :resetOption="{
                        isShow: true,
                        text: 'Все',
                        isSendRequestAfterReset: true
                    }"
                    :key="form.area"
                    @reset="
                        value => {
                            form.vehicle = value
                        }
                    "
                    @selected="
                        value => {
                            form.vehicle = value
                        }
                    "
                />
                </div>
            </div>
        </div>
        <form
            :action="route('route.store')"
            method="post"
            @submit.prevent="createRoute"
        >
            <div class="create-route__btns">
                <button type="submit" class="btn btn-orange">
                    Создать маршрут
                </button>
                <inertia-link :href="route('route.index')" class="pointer">
                    Отмена
                </inertia-link>
            </div>
        </form>
        <div class="routes">
            <modal
                name="createRouteModal"
                class="modal_regular modal_status createRouteModal"
                height="auto"
                width="450"
            >
                <div class="modal_regular__header column2">
                    <p>Добавить заявку на маршрут</p>
                    <div class="modal_regular__close">
                        <span
                            class="material-icons pointer"
                            @click="closeCreateModal"
                            >close</span
                        >
                    </div>
                </div>
                <div class="modal_status__body">
                    <div
                        id="addRoute"
                        class="pointer"
                        @click="isVisibleSearchBlock = 'route'"
                        v-if="isVisibleSearchBlock !== 'route'"
                    >
                        <img
                            :src="require('@/../images/icons/plus.svg').default"
                            alt=""
                        />Добавить заявку
                    </div>
                    <div v-else>
                        <input
                            type="text"
                            v-model="search"
                            @input="searchApplications"
                            placeholder="Поиск"
                        />
                        <div class="search">
                            <div class="search__inner custom-scroll">
                                <div
                                    class="search__item pointer"
                                    v-for="item in routes"
                                    :key="item.id"
                                    :class="{
                                        isAdded: isAddedApplication(item)
                                    }"
                                >
                                    <div
                                        class="search__item_inner"
                                        @click="selectedApplication(item)"
                                    >
                                        <div
                                            class="search__item_header"
                                            v-if="item.stations.length"
                                        >
                                            <p
                                                @click="func(item)"
                                                v-if="item.document"
                                            >
                                                <!-- {{ item.document }} -->
                                            </p>
                                            <p>{{ item.id }}</p>
                                            <!-- <p v-else>{{ item.document }}</p> -->
                                        </div>
                                        <div class="search__item_body">
                                            <p v-if="item.stations.length">
                                                {{ item.stations[0].bts_id
                                                }}<span
                                                    class="more_bts_btn"
                                                    v-if="
                                                        item.stations.length > 1
                                                    "
                                                    ><br />
                                                    Еще</span
                                                >
                                            </p>
                                            <p v-if="item.stations.length">
                                                {{
                                                    item.stations[0].area.title
                                                }}
                                            </p>
                                            <p style="text-align: right">
                                                {{ item.type.title }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div
                        id="addRoute"
                        class="pointer mt8"
                        @click="isVisibleSearchBlock = 'placeToSleep'"
                        v-if="isVisibleSearchBlock !== 'placeToSleep'"
                    >
                        <img
                            :src="require('@/../images/icons/plus.svg').default"
                            alt=""
                        />Место ночлега
                    </div>
                    <div v-else class="mt8">
                        <input
                            type="text"
                            v-model="search"
                            @input="searchPlace"
                            placeholder="Место ночлега"
                        />
                        <div class="search" v-if="addresses.length">
                            <div class="search__inner custom-scroll">
                                <div
                                    class="search__item_place pointer"
                                    v-for="address in addresses"
                                    :key="address.id"
                                    :class="[
                                        {
                                            isAdded: isAddedPlace(
                                                placesToSleep,
                                                address
                                            )
                                        }
                                    ]"
                                    @click="
                                        () => {
                                            placesToSleep = selectPlace(
                                                placesToSleep,
                                                address
                                            )
                                        }
                                    "
                                >
                                    <p>{{ address.title }}</p>
                                    <p>{{ address.address }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div
                        id="addRoute"
                        class="pointer mt8"
                        @click="isVisibleSearchBlock = 'keyCollectionPoint'"
                        v-if="isVisibleSearchBlock !== 'keyCollectionPoint'"
                    >
                        <img
                            :src="require('@/../images/icons/plus.svg').default"
                            alt=""
                        />Место забора ключей
                    </div>
                    <div v-else class="mt8">
                        <input
                            type="text"
                            v-model="search"
                            placeholder="Место забора ключей"
                            @input="searchPlace"
                        />
                        <div class="search" v-if="places.length">
                            <div class="search__inner custom-scroll">
                                <div
                                    class="search__item_place pointer"
                                    v-for="place in places"
                                    :class="[
                                        {
                                            isAdded: isAddedPlace(
                                                placesOfCollectionOfKeys,
                                                place
                                            )
                                        }
                                    ]"
                                    :key="place.id"
                                    @click="
                                        () => {
                                            placesOfCollectionOfKeys = selectPlace(
                                                placesOfCollectionOfKeys,
                                                place
                                            )
                                        }
                                    "
                                >
                                    <p>{{ place.address }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <p class="pointer" @click="closeCreateModal">Добавить</p>
                </div>
            </modal>
            <modalList ref="modalList" />
        </div>
    </app-layout>
</template>

<script>
import VSelect from '@/components/v-select.vue'
import AppLayout from '@/Layouts/AppLayout.vue'
import modalList from '@/components/modalList'
import calendar from '@/components/calendar'
import vMapPlaceShow from '@/components/v-map-placeShow'
import axios from 'axios'

export default {
    components: {
        AppLayout,
        VSelect,
        modalList,
        calendar,
        vMapPlaceShow
    },
    props: {},
    data() {
        return {
            isVisibleSearchBlock: null,
            search: '',
            placeOnMap: {},
            routes: [],
            mainApplication: null,
            vehicles: [],
            vehicle_types: [],
            applications: [],
            users: [],
            divisionId: null,
            placesToSleep: [],
            addresses: [],
            places: [],
            placesOfCollectionOfKeys: [],
            form: this.$inertia.form({
                applications: [],
                engineer: null,
                area: '',
                addresses: [],
                deadline_at: null,
                started_at: null,
                start_at: null,
                vehicle: null,
                vehicle_type: null,
                places: []
            })
        }
    },
    methods: {
        func(item) {
            console.log(item.id)
        },
        createRoute() {
            if (!this.applications.length) {
                this.$notify({
                    group: 'warn',
                    text: 'Заявка не выбрана'
                })
                return
            }
            if (this.form.deadline_at === null) {
                this.$notify({
                    group: 'warn',
                    text: 'Выберите период маршрута'
                })
                return
            }
            if (this.pointsCount > 10) {
                this.$notify({
                    group: 'warn',
                    text: `Превышен лимит точек, создания маршрута отменена ( Добавлено точек -  ${this.pointsCount}. Лимит - 10 )`
                })
                return
            }
            this.form.applications = this.applications.map(
                application => application.id
            )
            this.form.addresses = [...this.placesToSleep].map(
                address => address.id
            )
            this.form.places = [...this.placesOfCollectionOfKeys].map(
                place => place.id
            )
            if (this.mainApplication) {
                const indexMainApplication = this.applications.findIndex(
                    app => app.id === this.mainApplication
                )
                this.applications.unshift(
                    ...this.applications.splice(indexMainApplication, 1)
                )
            }
            this.form.post(route('route.store'))
        },
        showPlaceOnMap(place) {
            console.log('placeOnMap', this.placeOnMap)
            console.log('place', place)
            this.placeOnMap = place
            const coordinate = [
                place.location.longitude,
                place.location.latitude
            ]
            this.$refs.placeMap.open(coordinate, place)
        },
        closeCreateModal() {
            this.search = ''
            this.isVisibleSearchBlock = null
            this.$modal.hide('createRouteModal')
        },
        openCreateRouteModal() {
            if (!this.routes.length) {
                this.$notify({
                    group: 'warn',
                    text: 'Заявка не найдена'
                })
                return
            }
            if (!this.form.engineer) {
                this.$notify({
                    group: 'warn',
                    text: 'Выберите ответственного инженера '
                })
                return
            }
            this.searchApplications()
            this.$modal.show('createRouteModal')
        },
        searchPlace() {
            const params = { title: this.search, area: this.form.area }
            this.getAddresses(params)
        },
        isAddedPlace(places, place) {
            return Boolean(places.find(p => p.id === place.id))
        },
        selectPlace(places, place) {
            const isExist = this.isAddedPlace(places, place)
            if (!isExist) {
                places.push(place)
                return places
            }
            places.splice(places.indexOf(place), 1)
            return places
        },
        searchApplications() {
            axios
                .get(
                    route('api.application.index', {
                        areas: [this.form.area],
                        engineer: this.form.engineer,
                        ticket: this.search,
                        status: 3,
                        routes: [1, 2, 3]
                    })
                )
                .then(result => {
                    this.routes = result.data.data
                })
        },
        isAddedApplication(application) {
            const app = this.applications.find(app => app.id === application.id)
            if (app === undefined) {
                return false
            }
            return true
        },
        getAddresses(params = { title: '', division: this.divisionId }) {
            axios.get(route('api.addresses.index', params)).then(res => {
                this.addresses = res.data.data
            })
        },
        getPlaces(params = { title: '', division: this.divisionId }) {
            axios.get(route('api.places.index', params)).then(res => {
                this.places = res.data.data
            })
        },
        getApplicationsByAreaAndEngineer(user) {
            this.form.engineer = user
            axios
                .get(
                    route('api.application.index', {
                        areas: [this.form.area],
                        engineer: user,
                        status: 3,
                        routes: [1, 2, 3]
                    })
                )
                .then(result => {
                    this.routes = result.data.data
                })
        },
        getAddressesByArea(id) {
            const area = this.$page.props.areas.find(a => a.id === id)
            this.divisionId = area?.division_id
            axios
                .get(route('api.user.index', { roles: [4], area: id }))
                .then(res => (this.users = res.data.data))
            this.form.area = id
            this.getAddresses({ title: '', division: this.divisionId })
            this.getPlaces({ title: '', division: this.divisionId })
        },
        getVehiclesByArea(area) {
            axios
                .get(route('api.vehicles.index'), {
                    params: {
                        area
                    }
                })
                .then(res => {
                    this.vehicles = res.data.data
                })
        },

        deleteApplication(id) {
            if (this.mainApplication === id) {
                this.mainApplication = null
            }
            this.applications = this.applications.filter(
                application => application.id !== id
            )
        },
        openModalBts(application) {
            this.$refs.modalList.switchModalStatus(true, application)
        },
        selectedApplication(application) {
            const more_station_btn = document.querySelectorAll('.more_bts_btn')
            const btnArr = []
            more_station_btn.forEach(btn => btnArr.push(btn))
            if (btnArr.some(btn => btn.contains(event.target))) {
                this.openModalBts(application)
                return
            }
            if (!this.applications.length) {
                this.search = application.ticket
                this.applications.push(application)
                if (this.applications.length === 1) {
                    this.mainApplication = application.id
                }
                return
            }
            if (!this.applications.find(app => app.id === application.id)) {
                this.search = application.ticket
                this.applications.push(application)
                if (this.applications.length === 1) {
                    this.mainApplication = application.id
                }
            }
        }
    },
    computed: {
        pointsCount() {
            let count = 0
            this.applications.forEach(app => {
                count += app.stations.length
            })
            count +=
                this.placesToSleep.length + this.placesOfCollectionOfKeys.length
            return count
        },

    },
    watch: {
        isVisibleSearchBlock() {
            this.search = ''
        },
        'form.area': {
            handler() {
                this.form.engineer = null
                this.form.applications = []
                this.form.addresses = []
                this.form.places = []
                this.form.vehicle = null
                this.form.vehicle_types = null
            }
        }
    },
    mounted() {

            axios
                .get(route('api.vehicle_types.index'))
                .then(res => {
                    this.vehicle_types = res.data.data
                })

    }
}
</script>

<style></style>
