<template>
    <modal
        name="RouteClosed"
        class="modal_regular modal_comment modal_status"
        width="420"
        height="380"
    >
        <div class="modal_regular__header column2">
            <p>Добавить комментарий к закрытию маршрута {{ route.id }}</p>
            <div class="modal_regular__close">
                <span class="material-icons pointer" @click="close">
                    close
                </span>
            </div>
        </div>
        <div class="modal_status__body">
            <form
                :action="route('route.closed', router)"
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
                    comment: '',
                },
                {
                    resetOnSuccess: false,
                }
            ),
        }
    },
    props: {
        router: {
            type: Object,
            required: true,
        },
    },
    methods: {
        open() {
            this.$modal.show('RouteClosed')
        },
        close() {
            this.$modal.hide('RouteClosed')
        },
        submit() {
            this.form.post(route('route.closed', this.router), {
                preserveState: true,
                preserveScroll: true,
            })
            this.close()
        },
    },
}
</script>

<style lang="scss" scoped></style>
