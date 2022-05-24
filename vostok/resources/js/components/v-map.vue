<template>
    <div class="map__container">
        <div class="map" id="map"></div>
        <transition name="fade">
            <div
                class="map__navigator"
                v-if="isShowNavigator && statusNavigator && typeMap !== 4"
            >
                <div class="route-modal custom-scroll">
                    <div class="route-modal__header">
                        <div class="route-modal__navigator">
                            <p
                                class="pointer"
                                :class="{
                                    blue: contentRouteModal === 'routes'
                                }"
                                @click="contentRouteModal = 'routes'"
                            >
                                Маршрут
                            </p>
                            <p
                                class="pointer"
                                :class="{
                                    blue: contentRouteModal === 'addresses'
                                }"
                                @click="contentRouteModal = 'addresses'"
                            >
                                Адреса
                            </p>
                        </div>
                        <span
                            class="material-icons pointer"
                            @click="switchStatusNavigator(false)"
                            >close</span
                        >
                    </div>
                    <div
                        class="route-modal__content"
                        v-if="pointsIsSorted && contentRouteModal === 'routes'"
                    >
                        <div
                            class="route-modal__item"
                            v-for="point in routeListPointsWithMetadata"
                            v-once
                        >
                            <p
                                class="oval"
                                :style="{ 'border-color': point.color }"
                            >
                                <span>{{ point.waypoint_index }}</span>
                            </p>
                            <div class="route-modal__unk">
                                <p class="pointer">
                                    {{
                                        point.is_station
                                            ? point.application.ticket
                                            : point.name
                                    }}
                                </p>
                                <p class="gray" v-if="point.is_station">
                                    {{ point.station.bts_id }}
                                </p>
                                <span
                                    class="material-icons pointer gray"
                                    @click="
                                        showMarkerOnMap(point.waypoint_index)
                                    "
                                    >visibility</span
                                >
                            </div>
                        </div>
                    </div>
                    <div
                        class="route-modal__content"
                        v-else-if="contentRouteModal === 'addresses'"
                    >
                        <div
                            class="route-modal__item route-modal__withoutBorder"
                            v-for="point in addressesPointsWithMetadata"
                            :key="point.id"
                        >
                            <span
                                class="route-modal__markerCircle"
                                :style="{ 'border-color': point.color }"
                            ></span>
                            <div class="route-modal__unk">
                                <p class="pointer">
                                    {{ point.name }}
                                </p>
                                <span
                                    class="material-icons pointer gray"
                                    @click="
                                        showMarkerOnMap(point.id, 'addresses')
                                    "
                                    >visibility</span
                                >
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </transition>
        <!-- <transition name="fade">
            <div
                class="route-modal custom-scroll route-modal__listBts"
                v-if="
                    listBts.isShow && isShowNavigator && isShowNavigatorStations
                "
            >
                <div class="route-modal__header">
                    <p>{{ listBts.data.application_ticket }}</p>
                    <span
                        class="material-icons pointer"
                        @click="
                            switchStatusListBtsAndInitialMap(
                                {
                                    application_ticket: null,
                                    stations: null
                                },
                                false
                            )
                        "
                        >keyboard_backspace</span
                    >
                </div>
                <div class="route-modal__content">
                    <div
                        class="route-modal__item"
                        v-for="(station, index) in listBts.data.stations"
                        :key="index"
                    >
                        <p class="oval">
                            <span
                                >{{ listBts.data.round }}.{{
                                    station.round + 1
                                }}</span
                            >
                        </p>
                        <div class="route-modal__unk">
                            <p>{{ station.bts_id }}</p>
                            <p></p>
                            <span
                                class="material-icons icon-action-map pointer"
                                @click="
                                    showMarkerOnMap(
                                        markersOnStationMap,
                                        station.id,
                                        stations_map
                                    )
                                "
                                >visibility</span
                            >
                            <a class="pointer"
                                ><img
                                    :src="require('@/../images/icons/closering.svg').default"
                                    alt=""
                            /></a>
                        </div>
                    </div>
                </div>
            </div>
        </transition> -->
    </div>
</template>

<script>
import mapboxgl from 'mapbox-gl'
import * as turf from '@turf/turf'
import randomColor from 'randomcolor'
import axios from 'axios'
export default {
    data: () => ({
        base_url:
            'https://api.mapbox.com/optimized-trips/v1/mapbox/driving-traffic',
        routesOnMap: [],
        routesOnStationMap: [],
        markersOnMap: [],
        markersOnStationMap: [],
        application_map: null,
        nestedRoute_map: null,
        colorRoute: '#999999',
        statusNavigator: true,
        pointsIsSorted: false,
        sortedStations: [],
        contentRouteModal: 'routes'
    }),
    props: {
        routeTraveled: {
            type: Array,
            default() {
                return []
            }
        },
        typeMap: {
            type: String,
            default: 'route'
            // routes - route/index
            // route - route/show
        },
        isShowNavigator: {
            type: Boolean,
            default: false
        },
        placeOfReturn: {
            type: Array,
            default() {
                return []
            }
        },
        addresses: {
            type: Array,
            default() {
                return []
            }
        },
        applications: {
            type: Array,
            default() {
                return []
            }
        },
        routes: {
            type: Array,
            default() {
                return []
            }
        }
    },
    methods: {
        drawTraversedRoute(
            data = {
                routeTraveled: this.routeTraveled,
                map: this.application_map
            }
        ) {
            const colorTraveledRoute = '#00d803'
            this.generateSourceAndLayersForMap(
                data.map,
                'traveled',
                colorTraveledRoute
            )
            const geometry = {
                coordinates: [],
                type: 'LineString'
            }
            geometry.coordinates = data.routeTraveled.map(point =>
                Object.values(point.location).reverse()
            )
            if (geometry.coordinates.length) {
                data.map.getSource('routetraveled').setData(geometry)
            }
        },
        redrawTraversedRoute(routeTraveled) {
            this.removeSourceAndLayers(this.application_map, 'traveled')
            this.drawTraversedRoute({
                routeTraveled,
                map: this.application_map
            })
        },
        /**
         * @param {Array<Number>} start
         * @param {Array<Number>} end
         */
        createRoute(start, end) {
            const points = [start, end]
            return new Promise((resolve, reject) => {
                try {
                    axios
                        .get(`${this.base_url}/${points.join(';')}`, {
                            params: {
                                geometries: 'geojson',
                                source: 'first',
                                overview: 'full',
                                steps: true,
                                destination: 'last',
                                roundtrip: false,
                                access_token: mapboxgl.accessToken
                            }
                        })
                        .then(res => resolve(res.data))
                        .catch(e => reject(e))
                } catch (e) {
                    console.log('284', e)
                }
            })
        },
        sendEmitForDeletionApp(id) {
            this.$emit('deleteApplication', id)
        },
        removeSourceAndLayers(map = this.application_map, appId) {
            if (map.getLayer(`routeline${appId}`)) {
                map.removeLayer(`routeline${appId}`)
            }
            if (map.getSource(`route${appId}`)) {
                map.removeSource(`route${appId}`)
            }
        },
        generateSourceAndLayersForMap(
            map = this.application_map,
            appId,
            colorRoute = '#999'
        ) {
            map.addSource(`route${appId}`, {
                type: 'geojson',
                data: turf.featureCollection([])
            })
            map.addLayer(
                {
                    id: `routeline${appId}`,
                    type: 'line',
                    source: `route${appId}`,
                    layout: {
                        'line-join': 'round',
                        'line-cap': 'round'
                    },
                    paint: {
                        'line-color': colorRoute,
                        'line-width': [
                            'interpolate',
                            ['linear'],
                            ['zoom'],
                            12,
                            3,
                            22,
                            12
                        ]
                    }
                },
                'waterway-label'
            )
        },
        createMarker(
            {
                index,
                applicationId,
                applicationTicket,
                position,
                typeMarker = 'routeCircle',
                useZiggy = false,
                color = '#fff'
            },
            map = this.application_map,
            sub_bts = {
                status: false,
                bts_index: null
            }
        ) {
            let el
            if (typeMarker === 'routeCircle') {
                el = document.createElement('span')
                el.className = 'round'
                el.style.cssText = `border-color: ${color}`
                if (sub_bts.status) {
                    el.innerText = `${index}.${sub_bts.bts_index + 1}`
                } else {
                    el.innerText = index
                }
            } else if (typeMarker === 'userCircle') {
                el = document.createElement('span')
                el.className = 'userGeo'
            } else if (typeMarker === 'place_return') {
                el = document.createElement('span')
                el.className = 'place-return-on-map'
            }
            el.style.position = 'absolute'
            const marker = new mapboxgl.Marker(el)
                .setLngLat(position)
                .setPopup(
                    new mapboxgl.Popup({ offset: 25 }) // add popups
                        .setHTML(
                            (() => {
                                if (typeMarker === 'routeCircle') {
                                    return `
                                        <h1>${applicationId} ${applicationTicket}</h1>
                                        ${
                                            useZiggy
                                                ? `
                                        <a href="${this.route(
                                            'station.show',
                                            applicationId
                                        )}
                                        "class="orange" style="font-size:14px;">Открыть</a>

                                        `
                                                : ''
                                        }
                                        `
                                } else {
                                    return `
                                <h1>${applicationTicket}</h1>
                                `
                                }
                            })()
                        )
                )
                .addTo(map)
            if (
                !sub_bts.status &&
                typeMarker !== 'userGeo' &&
                this.typeMap !== 4
            ) {
                marker.getElement().addEventListener('dblclick', event => {
                    this.drawBaseStationsOnMap({
                        applicationId,
                        round: index
                    })
                })
            }
            return marker
        },

        getMarkersOnListByWaypointIndex(waypoint_index) {
            const marker = this.markersOnMap.find(
                m => m.waypoint_index === waypoint_index
            )
            return marker
        },

        /**
         * @param {Number} id
         * @return {object} marker
         */
        getMarkersOnListById(id) {
            const marker = this.markersOnMap.find(m => m.id === id)
            return marker
        },

        /**
         * @param {Number} id
         * @param {String} type
         */
        showMarkerOnMap(id, type = 'routes') {
            const marker =
                type === 'routes'
                    ? this.getMarkersOnListByWaypointIndex(id)
                    : this.getMarkersOnListById(id)
            if (marker) {
                this.application_map.flyTo({
                    center: marker.marker.location,
                    zoom: 8
                })
                this.markersOnMap.forEach(m => {
                    m.marker._popup.remove()
                })
                marker.marker.togglePopup()
            }
        },
        removeAllMarkers(markers) {
            markers.forEach(marker => {
                marker.remove()
            })
        },
        /**
         * @param {object} applications
         */
        async getApplicationRouteAndDrawRouteAndMarkerOnApplicationMap() {
            if (this.routePoints) {
                console.log('route points',this.routePoints)
                console.log('route list points with metadata', this.routeListPointsWithMetadata)
                this.getPoints(this.routePoints).then(res => {
                    if (res.message) {
                        alert(res.message)
                    }
                    res.waypoints.forEach((point, index) => {
                        this.routeListPointsWithMetadata[index].waypoint_index =
                            point.waypoint_index
                        const stationId = () => {
                            if (
                                this.routeListPointsWithMetadata[index]
                                    .is_station
                            ) {
                                return this.routeListPointsWithMetadata[index]
                                    .station.id
                            }
                            return ''
                        }
                        const marker = this.createMarker({
                            index: point.waypoint_index,
                            applicationId: stationId(),
                            applicationTicket: this.routeListPointsWithMetadata[
                                index
                            ]?.name,
                            position: point.location,
                            color: this.routeListPointsWithMetadata[index]
                                .color,
                            useZiggy: this.routeListPointsWithMetadata[index]
                                .is_station
                        })
                        marker.location = point.location
                        this.markersOnMap.push({
                            marker,
                            waypoint_index: point.waypoint_index,
                            id: this.routeListPointsWithMetadata[index]?.id
                        })
                    })
                    const points = this.sortListPointsWithMetadata(
                        this.routeListPointsWithMetadata
                    )

                    // draw addresses markers
                    this.addressesPointsWithMetadata.forEach(point => {
                        const marker = this.createMarker({
                            index: '',
                            applicationId: '',
                            applicationTicket: point.name,
                            position: point.location,
                            color: point.color,
                            useZiggy: false
                        })
                        marker.location = point.location
                        this.markersOnMap.push({
                            marker,
                            waypoint_index: -1,
                            id: point.id
                        })
                    })
                    //

                    // draw sorted routes

                    if (points.length) {
                        for (let i = 0; i <= points.length; i++) {
                            const currentPoint = points[i]
                            let nextPoint
                            // get next point
                            if (i !== points.length - 1) {
                                nextPoint = points[i + 1]
                            } else {
                                nextPoint = null
                            }
                            if (nextPoint) {
                                this.createRoute(
                                    currentPoint.location,
                                    nextPoint.location
                                ).then(res => {
                                    this.generateSourceAndLayersForMap(
                                        this.application_map,
                                        `station${currentPoint.waypoint_index}`,
                                        currentPoint.color
                                    )
                                    this.application_map
                                        .getSource(
                                            `routestation${currentPoint.waypoint_index}`
                                        )
                                        .setData(res.trips[0].geometry)
                                })
                            }
                        }
                    }
                    this.sortListPointsWithMetadata(
                        this.routeListPointsWithMetadata
                    )
                    // this.generateSourceAndLayersForMap(
                    //     this.application_map,
                    //     'application',
                    //     this.colorRoute
                    // )
                    // this.application_map
                    //     .getSource('routeapplication')
                    //     .setData(res.trips[0].geometry)
                    this.pointsIsSorted = true
                })
            }
        },

        /**
         * @param {object} routeItem
         */
        getPointsInRoute(routeItem) {
            const points = []
            const pointsWithMetadata = []
            const stations = []
            routeItem.applications.forEach(application => {
                application.stations.forEach(station => {
                    stations.push(station)
                    const point = {
                        location: [
                            station.location.longitude,
                            station.location.latitude
                        ],
                        is_station: true,
                        name: station.title,
                        station,
                        application
                    }
                    points.push(point.location)
                    pointsWithMetadata.push(point)
                })
            })
            return { points, pointsWithMetadata, stations }
        },

        /**
         * @description map on Route/Index page showing a list of routes
         */
        async drawRoutes() {
            if (this.routes.length) {
                for (const routeItem of this.routes) {
                    const {
                        points,
                        pointsWithMetadata
                    } = this.getPointsInRoute(routeItem)
                    const color = randomColor()
                    axios
                        .get(`${this.base_url}/${points.join(';')}`, {
                            params: {
                                geometries: 'geojson',
                                source: 'first',
                                overview: 'full',
                                steps: true,
                                destination: 'last',
                                roundtrip: false,
                                access_token: mapboxgl.accessToken
                            }
                        })
                        .then(res => {
                            res.data.waypoints.forEach((point, index) => {
                                this.createMarker({
                                    index: point.waypoint_index + 1,
                                    applicationId:
                                        pointsWithMetadata[index]?.station?.id,
                                    applicationTicket:
                                        pointsWithMetadata[index]?.name,
                                    position: point.location
                                })
                            })
                            this.generateSourceAndLayersForMap(
                                this.application1map,
                                `${routeItem.id}`,
                                color
                            )
                            this.application_map
                                .getSource(`route${routeItem.id}`)
                                .setData(res.data.trips[0].geometry)
                        })
                }
            }
        },
        initialMap(
            params = {
                container: 'map',
                style: 'mapbox://styles/mapbox/streets-v10',
                center: [67.11644093113631, 48.0462127659441],
                zoom: 4
            },
            cb
        ) {
            const map = new mapboxgl.Map(params)
            map.on('load', cb)
            return map
        },
        createApplication() {},
        getPoints(points) {
            return new Promise((resolve, reject) => {
                try {
                    axios
                        .get(`${this.base_url}/${points}`, {
                            params: {
                                geometries: 'geojson',
                                source: 'first',
                                overview: 'full',
                                steps: true,
                                destination: 'last',
                                roundtrip: false,
                                access_token: mapboxgl.accessToken
                            }
                        })
                        .then(res => resolve(res.data))
                } catch (e) {
                    reject(e)
                }
            })
        },
        /**
         * @param {Array<object>} points
         * @return {Array<object>} points
         */
        sortListPointsWithMetadata(points) {
            return points.sort((a, b) => {
                return a.waypoint_index - b.waypoint_index
            })
        },
        async start() {
            if (this.typeMap === 'route') {
                this.getApplicationRouteAndDrawRouteAndMarkerOnApplicationMap()
            } else {
                this.drawRoutes()
            }
        },
        switchStatusNavigator(status) {
            this.statusNavigator = status
        }
    },
    mounted() {
        mapboxgl.accessToken =
            'pk.eyJ1IjoiYWJkdWxoYW1pZC13ZWJkZXYiLCJhIjoiY2todTVsOGh5MDIyajJ4bW91ZmxhOGFnbiJ9.ErZ-i1AiL4w7LN4E1WclTg'
        // Initialize a map
        this.application_map = this.initialMap(
            {
                container: 'map',
                style: 'mapbox://styles/mapbox/streets-v10',
                center: [67.11644093113631, 48.0462127659441],
                zoom: 4
            },
            () => {
                this.application_map.on('click', () => {
                    this.switchStatusNavigator(true)
                })
                this.application_map.resize()
                // if (this.startGeo.length) {
                //     this.userMarker = this.createMarker(
                //         {
                //             inded: 0,
                //             applicationId: 'user',
                //             applicationTicket: 'user',
                //             position: this.startGeo,
                //             typeMarker: 'userCircle'
                //         },
                //         this.application_map
                //     )
                // }
                this.start()
                if (this.routeTraveled.length) {
                    this.drawTraversedRoute({
                        routeTraveled: this.routeTraveled,
                        map: this.application_map
                    })
                }
                // if (this.placeOfReturn.length) {
                //     this.createMarker(
                //         {
                //             inded: 0,
                //             applicationId: 'place_return',
                //             applicationTicket: 'Место возврата',
                //             position: this.placeOfReturn,
                //             typeMarker: 'place_return'
                //         },
                //         this.application_map
                //     )
                // }
                // if (this.addresses.length) {
                //     this.addresses.forEach(place => {
                //         this.createMarker(
                //             {
                //                 inded: 0,
                //                 applicationId: place.id,
                //                 applicationTicket: place.title,
                //                 position: place.location.coordinates,
                //                 typeMarker: 'place_return'
                //             },
                //             this.application_map
                //         )
                //     })
                // }
            }
        )
    },
    watch: {
        /**
         * @description user point update
         */
        startGeo() {
            if (this.startGeo.length && this.markersOnMap.length) {
                const marker = this.markersOnMap[0]
                marker.marker.location = this.startGeo
                marker.marker.setLngLat(this.startGeo)
            }
        }
    },
    computed: {
        /**
         * @return {object} user marker
         */
        userMarker() {
            if (this.markersOnMap.length) {
                return this.markersOnMap[0]
            }
            return null
        },

        /**
         * @return {Array} startGeo
         */
        startGeo() {
            if (this.routeTraveled.length) {
                this.routeTraveled = this.routeTraveled.filter(point => point)
                console.log(
                    'routetraveled v-map 702 startgeo',
                    this.routeTraveled
                )
                return Object.values(
                    this.routeTraveled[this.routeTraveled.length - 1]?.location
                ).reverse()
            }
            return []
        },

        /**
         * @return {Array<Array>} points
         */
        addressesCoordinates() {
            const points = []
            this.addresses.forEach(point => {
                points.push(point.location.coordinates)
            })
            return points
        },

        /**
         * @return {Array<object>} stations
         * @description return list of stations in the route
         */
        routeStations() {
            const stations = []
            this.applications.forEach(application => {
                application.stations.forEach(station => {
                    stations.push(station)
                })
            })
            return stations
        },

        /**
         * @return {Array<object>} stations
         */
        routeStationsWithMetadata() {
            const stations = this.routeListPointsWithMetadata
                .map(point => {
                    if (point.is_station) {
                        return point
                    }
                })
                .filter(point => point)
            if (this.pointsIsSorted) {
                return stations.sort((a, b) => {
                    return a.waypoint_index - b.waypoint_index
                })
            }
            return stations
        },

        /**
         * @return {Array<object>} points
         * @description returns an array of points with metadata
         */
        routeListPointsWithMetadata() {
            const points = []
            this.applications.forEach(application => {
                application.stations.forEach(station => {
                    const point = {
                        location: station.location.coordinates,
                        is_station: true,
                        name: station.title,
                        station,
                        application,
                        color: randomColor(),
                        id: station.id
                    }
                    points.push(point)
                })
            })
            if (this.startGeo.length) {
                // точка старта - гео юзера
                points.unshift({
                    location: this.startGeo.toString(),
                    is_station: false,
                    name: 'Инженер',
                    color: randomColor()
                })
                // точка возврата - РП
                points.push({
                    location: this.placeOfReturn,
                    is_station: false,
                    name: 'Место возврата',
                    color: randomColor()
                })
            } else {
                //  Точка старта
                points.unshift({
                    location: this.placeOfReturn,
                    is_station: false,
                    name: 'Точка старта',
                    color: randomColor()
                })
                // и возврата РП
                points.push({
                    location: this.placeOfReturn,
                    is_station: false,
                    name: 'Точка возврата',
                    color: randomColor()
                })
            }
            return points
        },

        /**
         * @return {Array<Array>}
         * @description an array of all route points
         */
        routeListPoints() {
            const points = []
            this.routeStations.forEach(station => {
                const point = station.location.coordinates
                points.push(point)
            })
            // this.addressesCoordinates.forEach(address => {
            //     points.push(address)
            // })
            if (this.startGeo.length) {
                // точка старта - гео юзера
                points.unshift(this.startGeo.toString())
                // точка возврата - РП
                points.push(this.placeOfReturn)
            } else {
                //  Точка старта
                points.unshift(this.placeOfReturn)
                // и возврата РП
                points.push(this.placeOfReturn)
            }
            return points
        },

        /**
         * @return {String}
         * @description list of points in text format to send to api
         */
        routePoints() {
            if (this.routeListPoints.length) {
                return this.routeListPoints.join(';')
            }
            return ''
        },
        addressesPointsWithMetadata() {
            const points = []
            this.addresses.forEach(point => {
                points.push({
                    location: point.location.coordinates,
                    is_station: false,
                    name: point.title,
                    color: randomColor(),
                    id: point.id
                })
            })
            return points
        }
    }
}
</script>

<style lang="scss" scoped>
@import 'https://api.tiles.mapbox.com/mapbox-gl-js/v1.12.0/mapbox-gl.css';
</style>
