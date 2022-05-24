<template>
    <app-layout class="createz hist-table">
        <div class="main-wrap routes mxw1050">
            <div class="base-header">
                <h1>История маршрутов</h1>
            </div>
            <div class="routes__table rts">
                <div class="base-header">
                    <h1 id="table_header">Список маршрутов</h1>
                </div>
                <div class="table__wrapper">
                    <div class="table__wrapper__head mt21">
                        <ul>
                            <li>№</li>
                            <li>Кол-во заявок</li>
                            <li>Кем создан</li>
                            <li>Область</li>
                            <li>Район</li>
                            <li></li>
                            <li>Статус</li>
                        </ul>
                    </div>
                    <div class="table__wrapper__body mt21">
                        <ul
                            v-for="(router, index) in $page.props.routes.data"
                            :key="index"
                        >
                            <li><span>№</span>{{ router.id }}</li>
                            <li>
                                <span>Кол-во заявок</span>
                                <span class="blue2 displayBlock">{{
                                    router.applications_count
                                }}</span>
                                <!-- <div>
                                    <span class="orange displayBlock">АВР 3 шт</span><br /><span class="blue2 displayBlock"
                                      >ППР 3 шт</span
                                    >
                                  </div> -->
                            </li>
                            <li>
                                <span>Кем создан</span>
                                {{
                                    router.user
                                        ? `${router.user.firstname} ${router.user.lastname}`
                                        : ''
                                }}
                            </li>
                            <li>
                                <span>РП</span>
                                {{ router.division.title }}
                            </li>
                            <li>
                                <span>ЭУ</span>
                                {{ router.area.title }}
                            </li>
                            <li>
                                <inertia-link
                                    :href="route('route.show', router.id)"
                                    class="pointer orange"
                                >
                                    Показать на карте
                                </inertia-link>
                            </li>
                            <li class="hist-table_changeStatus">
                                <span>Статус</span>{{ router.activity.title }}
                                <i
                                    class="material-icons"
                                    @click="changeStatusModal = index"
                                >
                                    more_horiz
                                </i>
                                <!-- <button @click="reloadRoute(router)">
                                    Заново!
                                </button> -->
                                <transition name="fade">
                                    <div
                                        class="modal-req"
                                        v-if="changeStatusModal === index"
                                        v-click-outside="
                                            () => {
                                                changeStatusModal = null
                                            }
                                        "
                                    >
                                        <button
                                            class="modalReqStatus"
                                            @click="reloadRoute(router.id)"
                                        >
                                            <span class="material-icons gray"
                                                >autorenew</span
                                            >
                                            Новая
                                        </button>
                                        <!--  -->
                                    </div>
                                </transition>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <pagination
                v-if="$page.props.routes.meta.last_page > 1"
                :pagination="$page.props.routes.meta"
            >
            </pagination>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from '../../Layouts/AppLayout.vue'
import Pagination from '@/components/Pagination'
export default {
    data() {
        return {
            userGeo: null,
            activity: this.$inertia.form({ activity: 1 }),
            changeStatusModal: null
        }
    },
    components: {
        AppLayout,
        Pagination
    },
    methods: {
        reloadRoute(router) {
            this.activity.put(route('route.update', router), this.activity)
        }
    },
    mounted() {
        console.log(this.$page.props.routes)
    }
}
</script>
<style lang="scss"></style>
