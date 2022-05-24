<template>
    <modal
        name="sliderModal"
        height="450"
        width="500"
        class="modal-gallery"
        @closed="close"
    >
        <splide>
            <splide-slide
                class="slider__img_container"
                v-for="(image, index) in images"
                :key="index"
            >
                <img v-if="image.url" :src="image.url" alt="" />
            </splide-slide>
        </splide>
    </modal>
</template>

<script>
import { Splide, SplideSlide } from '@splidejs/vue-splide'
import '@splidejs/splide/dist/css/themes/splide-default.min.css'
export default {
    components: {
        Splide,
        SplideSlide
    },
    data: () => ({
        images: []
    }),
    methods: {
        open(images) {
            this.images = images
            this.$modal.show('sliderModal')
        },
        close() {
            this.$emit('closeSlider')
            this.$modal.hide('sliderModal')
        }
    },
    props: {
        // images: {
        //   type: Array,
        //   required: true
        // }
    }
}
</script>

<style lang="scss" scoped></style>
