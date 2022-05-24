<template>
    <div id="preloads" class="modal-preloader-wrapper">
        <div class="modal-preloader">
            <div class="preloader-1">
                <div>{{text}}</div>
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
</template>

<script>
export default {
    name: 'preoloader',
    props: {
        status: {
            type: Boolean,
            default: false
        },
        text: {
            type: String,
            default: 'Загрузка...'
        }
    },
    mounted() {
        this.status
            ? document.getElementById('preloads').classList.add('active')
            : document.getElementById('preloads').classList.remove('active')
    }
}
</script>

<style lang="scss" scoped></style>
