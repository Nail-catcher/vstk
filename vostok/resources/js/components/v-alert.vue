<template>
    <modal name="modalAlert" height="auto" width="450" class="modal-alert">
        <div class="modal">
            <div class="modal-close">
                <span class="material-icons" id="closeModal" @click="close"
                    >close</span
                >
            </div>
            <p>{{ text }}</p>
            <div class="modal-buttons">
                <button
                    class="modal-button__exit"
                    @click="confirm"
                    ref="button-exit"
                >
                    {{ confirmText }}
                </button>
                <button @click="refuse">
                    {{ refuseText }}
                </button>
            </div>
        </div>
    </modal>
</template>

<script>
export default {
    data: () => ({
        comment: false,
    }),
    props: {
        text: {
            type: String,
            default: 'Вы уверены ?',
        },
        confirmText: {
            type: String,
            default: 'Да',
        },
        refuseText: {
            type: String,
            default: 'Нет',
        },
    },
    methods: {
        confirm() {
            setTimeout(() => {
                this.close()
            }, 500)
            this.$emit('confirm', (this.comment = true))
        },
        refuse() {
            this.close()
            this.$emit('refuse')
        },
        open() {
            this.$modal.show('modalAlert')
        },
        close() {
            this.$modal.hide('modalAlert')
            this.$emit('close')
        },
    },
}
</script>

<style lang="scss" scoped></style>
