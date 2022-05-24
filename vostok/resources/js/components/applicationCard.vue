<template>
    <div>
        <div
            class="sidebar sidebar__right custom-scroll sidebar__request"
            v-if="detailsApplication"
            v-click-outside="closeOnClickOutside"
        >
            <div class="sidebar__request_header">
                <div class="sidebar__request_header__item sidebar__padding">
                    <p>Заявка {{ detailsApplication.id }}</p>
                    <inertia-link
                        :href="route('application.show', detailsApplication.id)"
                        class="pointer textRight"
                    >
                        Открыть заявку
                    </inertia-link>
                    <a
                        style="
                            position: absolute;
                            top: 73px;
                            right: 25px;
                            text-deciration: underline;
                            cursor: pointer;
                        "
                        @click="closeSidebar()"
                        >Закрыть</a
                    >
                    <p>
                        <status :status="detailsApplication.status" />
                    </p>
                </div>
                <div class="sidebar__request_header__item sidebar__padding">
                    <div>
                        <p class="label">Ответственный РП</p>
                        <p>
                            {{ detailsApplication.user.lastname }}
                            {{ detailsApplication.user.firstname }}
                        </p>
                    </div>
                    <div>
                        <p class="label">Ответственный инженер</p>
                        <p>
                            {{ detailsApplication.engineer.lastname }}
                            {{ detailsApplication.engineer.firstname }}
                        </p>
                    </div>
                    <div class="mt24">
                        <p class="label">Вид работ</p>
                        <p
                            v-for="(work, index) in detailsApplication.works"
                            :key="index"
                        >
                            {{ work.title }}
                        </p>
                    </div>
                    <div class="mt24">
                        <p class="label">Описание аварии</p>
                        <p class="request__comment">
                            {{ detailsApplication.description }}
                        </p>
                    </div>
                    <div class="mt24">
                        <p class="label">Комментарий</p>
                        <p class="request__comment">
                            {{ detailsApplication.comment }}
                        </p>
                    </div>
                </div>
                <div class="sidebar__request_header__item sidebar__padding">
                    <div>
                        <p class="label">Состав бригады</p>
                        <p
                            v-for="(user, index) in detailsApplication.users"
                            :key="index"
                        >
                            {{ user.lastname }} {{ user.firstname }}
                        </p>
                    </div>
                </div>
                <div
                    class="sidebar__request_body border_bottom applicationCard__commentHistory"
                    v-if="detailsApplication.statuses.length"
                >
                    <p>История заявки</p>
                    <div class="sidebar__request_body__item">
                        <div
                            class="applicationCard__commentHistory_item"
                            v-for="comment in detailsApplication.statuses"
                            :key="comment.id"
                        >
                            <p class="blue">Смена статуса:</p>
                            <p>
                                {{ comment.pivot.old_status.title }} ->
                                {{ comment.title }}
                            </p>
                            <p>
                                <span class="blue">Дата:</span>
                                {{
                                    new Date(
                                        comment.pivot.created_at
                                    ).toLocaleTimeString($page.props.locale, {
                                        hour: '2-digit',
                                        minute: '2-digit'
                                    })
                                }}
                            </p>
                            <p>
                                <span class="blue">Автор: </span
                                >{{ comment.pivot.user.firstname }}
                                {{ comment.pivot.user.lastname }}
                            </p>
                            <p>
                                <span class="blue">Комментарий: </span>
                                {{ comment.pivot.comment }}
                                <br />
                            </p>
                        </div>
                        <div
                            class="applicationCard__commentHistory_item"
                            v-for="comment in detailsApplication.comments"
                            :key="comment.id"
                        >
                            <p>
                                <span class="blue">Дата:</span>
                                {{
                                    new Date(
                                        comment.created_at
                                    ).toLocaleTimeString($page.props.locale, {
                                        hour: '2-digit',
                                        minute: '2-digit'
                                    })
                                }}
                            </p>
                            <p>
                                <span class="blue">Комментарий: </span
                                >{{ comment.comment }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div
                style="background: #fff"
                class="sidebar__request_body border_bottom"
            >
                <div
                    v-for="n in detailsApplication.startings"
                    :key="n.id"
                    class="sidebar__request_body__item working_process"
                    :class="{ active: show === true }"
                >
                    <div class="working_process__head">
                        <div class="working_process__item">
                            <span>БС ID:</span>
                            <p>{{ n.station.bts_id }}</p>
                        </div>
                        <div class="working_process__item">
                            <span>Инженер - </span>
                            <p @click="func(n)">
                                {{ n.user.lastname }}
                                {{ n.user.firstname }}
                            </p>
                        </div>
                    </div>
                    <div
                        v-for="progress in n.progresses"
                        :key="progress.id"
                        class="working_process__sect"
                    >
                        <div class="working_process__item">
                            <div>
                                <div style="display: flex">
                                    <span v-if="progress.id === 1">
                                        {{
                                            new Date(progress.created_at)
                                                .toLocaleString(
                                                    $page.props.locale
                                                )
                                                .substr(0, 17)
                                        }}</span
                                    >
                                    <span v-else>
                                        {{
                                            new Date(progress.created_at)
                                                .toLocaleString(
                                                    $page.props.locale
                                                )
                                                .substr(12, 5)
                                        }}
                                    </span>
                                    <p>{{ progress.title }}</p>
                                </div>
                                <div v-if="progress.typeable">
                                    <p>Норма: {{ progress.typeable.value }}</p>
                                    <p>
                                        Отклонение:
                                        {{ progress.typeable.deviation }}
                                    </p>
                                </div>
                                <p v-if="progress.comment">Примечание: {{ progress.comment }}</p>
                                <img
                                    v-for="img in progress.images"
                                    :key="img.id"
                                    style="max-width: 150px"
                                    :src="img.url"
                                    alt="logo"
                                />
                            </div>
                        </div>
                    </div>
                </div>
                <a
                    style="cursor: pointer"
                    v-if="show === false"
                    @click="show = true"
                    >Показать все</a
                >
                <a
                    style="cursor: pointer"
                    v-if="show === true"
                    @click="show = false"
                    >Скрыть</a
                >
            </div>
            <!-- <div class="sidebar__request_body border_bottom">
                <p>Ход работы</p>
                <div class="sidebar__request_body__item working_process">
                    <div
                        class="working_process__item"
                        v-for="(progress, index) in detailsApplication.progress"
                        :key="index"
                    >
                        <p class="working_process__author">
                            {{ comment.pivot.user.firstname }}
                            {{ comment.pivot.user.lastname }}
                        </p>
                        <div class="working_process__time">
                            <p>
                                {{
                                    new Date(
                                        progress.created_at
                                    ).toLocaleTimeString($page.props.locale, {
                                        year: '2-digit',
                                        month: '2-digit',
                                        day: '2-digit',
                                        hour: '2-digit',
                                        minute: '2-digit',
                                    })
                                }}
                            </p>
                        </div>
                        <p class="working_process__arrow">
                            <span></span>
                        </p>
                        <div class="working_process__info">
                            <p>{{ progress.title }}</p>
                            <p class="request__comment" v-if="progress.comment">
                                {{ progress.comment }}
                            </p>
                            <div v-if="progress.id === 4">
                                <p
                                    class="border_bottom"
                                    v-for="(
                                        inventory, index
                                    ) in progress.inventories"
                                    :key="index"
                                >
                                    {{ inventory.title }}
                                </p>
                                <div v-if="progress.id === 5">
                                    <p
                                        class="border_bottom"
                                        v-for="(
                                            inventory, index
                                        ) in progress.inventories"
                                        :key="index"
                                    >
                                        {{ inventory.title }}
                                    </p>
                                </div>
                            </div>
                            <div
                                class="working_process__gallery working_process__gallery_applicationCard"
                                v-if="progress.id === 6"
                            >
                                <div
                                    class="working_process__gallery_item"
                                    v-for="(
                                        image, index
                                    ) in detailsApplication.images"
                                    :key="index"
                                >
                                    <img
                                        :src="image.url"
                                        alt=""
                                        @mouseover="hoverPhotoId = index"
                                        :class="{
                                            blur: hoverPhotoId === index,
                                        }"
                                    />
                                    <transition name="fade">
                                        <div
                                            class="cover pointer"
                                            @mouseleave="hoverPhotoId = null"
                                            @click="openSlider(index)"
                                            v-if="hoverPhotoId === index"
                                        >
                                            <span class="material-icons"
                                                >zoom_in</span
                                            >
                                        </div>
                                    </transition>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> -->

            <div
                class="sidebar__request_footer"
                v-if="detailsApplication.routes.length"
            >
                <a
                    class="btn btn-orange"
                    target="_blank"
                    :href="route('route.show', detailsApplication.routes[0].id)"
                >
                    Посмотреть маршрут заявки
                </a>
            </div>
        </div>
        <vSlider ref="sliderModal" @closeSlider="closeSlider" />
    </div>
</template>

<script>
import vClickOutside from 'v-click-outside'
import Status from '@/components/status'
import vSlider from '@/components/v-slider'
import array_move from '@/libs/functions/ArrayMove'

export default {
    directives: {
        clickOutside: vClickOutside.directive
    },
    components: {
        Status,
        vSlider
    },
    data: () => ({
        show: false,
        routeApplications: [],
        hoverPhotoId: null,
        isActiveSliderModal: false
    }),
    props: {
        detailsApplication: {
            type: Object,
            required: true
        },
        typeTable: {
            type: String,
            required: true
        },
        classTable: {
            type: String,
            required: true
        }
    },

    methods: {
        closeSidebar() {
            this.$emit('closeSidebar')
            console.log(this)
        },
        closeOnClickOutside() {
            if (this.isActiveSliderModal) {
                return
            }
            if (this.typeTable === 'Single') {
                const table = document.querySelector(this.classTable)
                if (!table.contains(event.target)) {
                    this.closeSidebar()
                }
            } else if (this.typeTable === 'Several') {
                const tableBody = document.querySelectorAll(this.classTable)
                const arr = []
                tableBody.forEach(item => arr.push(item))
                if (!arr.some(table => table.contains(event.target))) {
                    this.closeSidebar()
                }
            }
        },
        closeSlider() {
            this.isActiveSliderModal = false
        },
        openSlider(index) {
            const images = [...this.detailsApplication.images]
            this.$refs.sliderModal.open(array_move(images, index, 0))
            this.isActiveSliderModal = true
        }
    }
}
</script>

<style lang="scss" scoped></style>
