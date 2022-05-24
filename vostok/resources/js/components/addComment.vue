<template>
    <modal
        name="addComment"
        class="modal_regular modal_comment modal_status"
        width="420"
        height="350"
    >
        <div class="modal_regular__header column2">
            <p>Добавить комментарий к заявке {{ application.id }}</p>
            <div class="modal_regular__close">
                <span class="material-icons pointer" @click="close">
                    close
                </span>
            </div>
        </div>
        <div class="modal_status__body">
            <form
                :action="route('comment.store', application)"
                method="post"
                @submit.prevent="submit"
            >
                <div class="modal_status__body_padding">
                    <div class="request-textarea mt16">
                        <textarea
                            v-model="form.comment"
                            placeholder="Написать комментарий"
                        ></textarea>
                    </div>
                    <button type="submit" class="request-button">
                        Добавить
                    </button>
                </div>
            </form>
        </div>
    </modal>
</template>

<script>
export default {
    data() {
        return {
            apps: false,
            form: this.$inertia.form(
                {
                    comment: ''
                },
                {
                    resetOnSuccess: false
                }
            )
        }
    },
    props: {
        options: {
            type: Object,
            default() {
                return {
                    show: false
                }
            }
        },
        application: {
            type: Object,
            required: true
        }
    },
    methods: {
        open() {
            this.$modal.show('addComment')
        },
        close() {
            this.$modal.hide('addComment')
        },
        submit() {
            this.form.post(route('comment.store', this.application), {
                preserveState: true,
                preserveScroll: true
            })

            this.$emit('show', (this.apps = true))

            this.close()
        }
        // submit() {
        //     this.form.post(route('comment.store', this.application), {
        //         preserveState: true,
        //         preserveScroll: true,
        //     })

        //     this.$emit('show', (this.apps = true))

        //     this.close()
        // },
    }
}
</script>

<style lang="scss" scoped></style>
