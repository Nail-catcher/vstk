<template>
    <modal
        name="modal-map-placeShow"
        height="450"
        width="650"
        class="modal-map-placeShow modal_regular"
        @closed="close"
    >
        <div class="modal_regular__header column2" v-if="place.id !== null">
            <p>{{ place.address }}</p>
            <div class="modal_regular__close">
                <span class="material-icons pointer" @click="close">close</span>
            </div>
        </div>
        <div class="modal_regular__body modal-map-placeShow">
            <div ref="placemap" id="place-map"></div>
        </div>
    </modal>
</template>

<script>
import mapboxgl from 'mapbox-gl'

export default {
    data: () => ({
        map: {}
    }),
    methods: {
        createMarker(coordinate, place) {
            const el = document.createElement('div')
            el.className = 'markerMap'
            const marker = new mapboxgl.Marker(el)
                .setLngLat(coordinate)
                .setPopup(
                    new mapboxgl.Popup({ offset: 25 }).setHTML(
                        `
                            <ul>
                              <li>${place.address} заявок</li>
                            </ul>
                          `
                    )
                )
                .addTo(this.map)
            marker.getElement().addEventListener('click', () => {
                this.map.flyTo({
                    center: coordinate,
                    zoom: 10
                })
            })
            return marker
        },
        open(coordinate, place) {
            this.$modal.show('modal-map-placeShow')
            setTimeout(() => {
                this.map = new mapboxgl.Map({
                    container: 'place-map',
                    style: 'mapbox://styles/mapbox/streets-v10',
                    center: [...coordinate], // starting position
                    zoom: 15
                })
                this.map.on('load', () => {
                    this.createMarker(coordinate, place)
                })
            }, 100)
        },
        close() {
            this.$modal.hide('modal-map-placeShow')
        }
    },
    components: {},
    props: {
        place: {
            type: Object,
            default() {
                return {
                    id: null
                }
            }
        }
    },
    mounted() {
        mapboxgl.accessToken =
            'pk.eyJ1IjoiYWJkdWxoYW1pZC13ZWJkZXYiLCJhIjoiY2todTVsOGh5MDIyajJ4bW91ZmxhOGFnbiJ9.ErZ-i1AiL4w7LN4E1WclTg'
    }
}
</script>

<style lang="scss" scoped>
@import 'https://api.tiles.mapbox.com/mapbox-gl-js/v1.12.0/mapbox-gl.css';
</style>
