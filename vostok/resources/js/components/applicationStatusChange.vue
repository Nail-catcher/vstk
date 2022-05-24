<template>
    <modal
        name="modalReq"
        class="modal_regular modal_status"
        :width="comment.isShow ? '550' : '250'"
        :height="comment.isShow ? 'auto' : '300'"
        :class="{ modalStatusChangeWithComment: comment.isShow }"
    >
        <div class="modal_regular__header column2">
            <p>Смена статуса</p>
            <div class="modal_regular__close">
                <span class="material-icons pointer" @click="close">
                    close
                </span>
            </div>
        </div>
        <div class="modal_status__body custom-scroll">
            <form
                @submit.prevent="submit(application)"
            >
                <div class="modal_status__body_items">
                    <div
                        class="modal_status__body_item"
                        v-for="(status, index) in statuses"
                        :key="index"
                    >
                        <input
                            name="status"
                            v-model="form.status"
                            :value="status.id"
                            :id="`status-${status.id}`"
                            type="radio"
                        />
                        <label :for="`status-${status.id}`">
                            {{ status.title }}
                        </label>
                    </div>
                </div>
                <div class="modal_status__body_padding">
                    <div class="request-textarea mt16">
                        <textarea
                            v-model="form.comment"
                            placeholder="Написать комментарий"
                        ></textarea>
                    </div>
                    <button type="submit" class="request-button">
                        Изменить
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
            form: this.$inertia.form(
                {
                    status: '',
                    comment: ''
                },
                {
                    bag: 'changeStatusForm',
                    resetOnSuccess: false
                }
            )
        }
    },
    props: {
        application: {
            type: Object,
            required: true
        },
        statuses: {
            type: Array,
            default() {
                return [
                    {
                        id: 0,
                        title: 0
                    }
                ]
            }
        },
        comment: {
            type: Object,
            default() {
                return {
                    isShow: false,
                    placeholder: 'Комментарий'
                }
            }
        }
    },
    methods: {
        open() {
            this.$modal.show('modalReq')
        },
        close() {
            this.$modal.hide('modalReq')
        },
        submit() {
            this.form.put(route('application.update', this.application), {
                preserveState: true,
                preserveScroll: true
            })
            this.close()
        }
    }
}
</script>

<style lang="scss" scoped></style>
