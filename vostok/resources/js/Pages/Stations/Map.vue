<template>
    <app-layout class="Base row">
        <template #header>
            <div class="base-header__wrapp space-between mxw1050">
                <h1>Карта базовых станции</h1>
                <form
                    :action="route('station.index')"
                    method="get"
                    @change.prevent="submit"
                    @submit.prevent="submit"
                >
                    <div style="display: block" class="base-header__input">
                        <v-select
                            :data="$page.props.areas"
                            optionName="title"
                            keyName="id"
                            typeSelect="whiteSelect"
                            :label="{ show: false }"
                            ref="selectArea"
                            @selected="selectedArea"
                            @reset="selectedArea"
                        />
                        <v-select
                            typeSelect="whiteSelect"
                            :data="$page.props.stations.data"
                            optionName="bts_id"
                            keyName="bts_id"
                            class="mt8"
                            placeholderSearch="ID станции"
                            mode="Search"
                            customRef="selectStation"
                            :globalSearch="{
                                use: true,
                                api: 'api.station.index',
                                dynamicParam: 'bts_id',
                                paramKey: {
                                    area: form.area,
                                    bts_id: null
                                }
                            }"
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
        <div class="main-wrap routes mxw1050">
            <div class="content mt32">
                <div class="content__inner">
                    <div class="content__map" id="map"></div>
                </div>
            </div>
            <div class="route-selected">
                <div class="Base row">
                    <div class="table__wrapper">
                        <div class="table__wrapper__head">
                            <ul>
                                <li>Базовая станция</li>
                                <li>ID</li>
                                <li>Область</li>
                                <li>Район</li>
                                <li>Населенный пункт</li>
                            </ul>
                        </div>
                        <div class="table__wrapper__body">
                            <ul
                                v-for="station in $page.props.stations.data"
                                :key="station.id"
                            >
                                <li>
                                    <span>Базовая станция</span
                                    >{{ station.title }}
                                </li>
                                <li><span>ID</span>{{ station.bts_id }}</li>
                                <li>
                                    <span>Область</span
                                    >{{ station.state.title }}
                                </li>
                                <li>
                                    <span>Район</span>{{ station.region.title }}
                                </li>
                                <li>
                                    <span>Населенный пункт</span
                                    >{{ station.city.title }}
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <pagination
                v-if="$page.props.stations.meta.last_page > 1"
                :pagination="$page.props.stations.meta"
            >
            </pagination>
        </div>
    </app-layout>
</template>

<script>
import VSelect from '@/components/v-select'
import AppLayout from '../../Layouts/AppLayout.vue'
import mapboxgl from 'mapbox-gl'
import Pagination from '@/components/Pagination'

export default {
    props: ['stations'],
    data: () => ({
        selectedRoute: null,
        form: {
            bts_id: '',
            area: ''
        },
        markersOnMap: [],
        map: null,
        defaultValueForSelect: null,
        reloadSelectStation: 1
    }),
    watch: {
        stations(newVal, oldVal) {
            this.markersOnMap.forEach(markerOnMap => markerOnMap.remove())
            let normalPosition = false
            newVal.data.forEach(station => {
                const marker = this.createMarker(station)
                if (newVal.data.length === 1) {
                    this.map.flyTo({
                        center: [
                            station.location.longitude,
                            station.location.latitude
                        ],
                        zoom: 12
                    })
                    marker.togglePopup()
                } else {
                    normalPosition = true
                }
            })
            if (normalPosition) {
                const center = [
                    newVal.data[0].location.longitude,
                    [newVal.data[0].location.latitude]
                ]
                this.map.flyTo({
                    center,
                    zoom: 8
                })
            }
        }
    },
    components: {
        AppLayout,
        VSelect,
        Pagination
    },
    methods: {
        selectedArea(area) {
            this.$refs.searchInput.resetSearch()
            this.form.area = area
            this.submit()
        },
        submit() {
            this.$inertia.get(route('station.map'), this.form, {
                preserveScroll: true,
                preserveState: true,
                only: ['stations'],
                bag: 'filter'
            })
        },
        createMarker(station) {
            const el = document.createElement('div')
            el.className = 'markerMap'
            const marker = new mapboxgl.Marker(el)
                .setLngLat([
                    station.location.longitude,
                    station.location.latitude
                ])
                .setPopup(
                    new mapboxgl.Popup({ offset: 25 }).setHTML(
                        `
                            <ul>
                              <li>${station.bts_id}</li>
                              <li>${station.state.title}</li>
                              <li>${station.applications_count} заявок</li>
                            </ul>
                          `
                    )
                )
                .addTo(this.map)
            marker.id = station.id
            this.markersOnMap.push(marker)
            marker.getElement().addEventListener('click', () => {
                this.map.flyTo({
                    center: [
                        station.location.longitude,
                        station.location.latitude
                    ],
                    zoom: 10
                })
            })
            return marker
        }
    },
    mounted() {
        const queryParams = new URLSearchParams(window.location.search)
        const queryArea = queryParams.get('area')
        const queryStation = queryParams.get('bts_id')
        if (queryArea !== null) {
            const data = this.$page.props.areas.find(
                area => area.id === Number(queryArea)
            )
            if (data) {
                this.form.area = data.id
                this.$refs.selectArea.searches = data.title
                this.$refs.selectArea.selectedId = data.id
            }
        }
        if (queryStation !== null) {
            const data = this.$page.props.stations.data.find(
                station => station.bts_id === queryStation
            )
            if (data) {
                this.$refs.searchInput.search = data.bts_id
            }
        }
        mapboxgl.accessToken =
            'pk.eyJ1IjoiYWJkdWxoYW1pZC13ZWJkZXYiLCJhIjoiY2todTVsOGh5MDIyajJ4bW91ZmxhOGFnbiJ9.ErZ-i1AiL4w7LN4E1WclTg'
        this.map = new mapboxgl.Map({
            container: 'map',
            style: 'mapbox://styles/mapbox/streets-v10',
            center: [
                this.$page.props.stations.data[0].location.longitude,
                this.$page.props.stations.data[0].location.latitude
            ], // starting position
            zoom: 8
        })
        this.map.on('load', async () => {
            this.$page.props.stations.data.forEach(station => {
                this.createMarker(station)
            })
        })
    }
}
</script>
<style lang="scss">
@import 'https://api.tiles.mapbox.com/mapbox-gl-js/v1.12.0/mapbox-gl.css';
</style>
