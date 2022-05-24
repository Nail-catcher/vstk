<template>
    <div class="status-request">
        <p :class="{ Critical: status === 'critical', Major: status === 'major', Minor: status === 'minor' }">
            <span>{{ priorityText }}</span>
        </p>
    </div>
</template>

<script>
export default {
    props: {
        status: {
            type: String,
            default: 'notConfirmed'
        }
    },
    computed: {
        priorityText() {
            if (this.status === 'critical') {
                return 'Critical'
            }
            if (this.status === 'major') {
                return 'Major'
            }
            if (this.status === 'minor') {
                return 'Minor'
            }
            return ''
        }
    }
}
</script>

<style lang="scss"></style>
