<template>
    <p
        v-if="status.id"
        :class="{
            workType: status.id === 3,
            newType: status.id === 1,
            acceptType: status.id === 2,
            noAcceptType: status.id === 6,
            noAccept: status.id === 7,
            noAccept: status.id === 8,
            accept: status.id === 4,
            accept: status.id === 5
        }"
    >
        {{ status.title }}
    </p>
</template>

<script>
export default {
    props: {
        status: {
            type: Object,
            default() {
                return {
                    id: null,
                    title: ''
                }
            }
        }
    }
}
</script>

<style lang="scss" scoped></style>
