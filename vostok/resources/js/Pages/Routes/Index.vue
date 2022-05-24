<template>
    <app-layout class="createz">
        <notifications group="foo" />
        <div class="main-wrap routes rute mxw1050">
            <div class="base-header">
                <h1>Маршруты</h1>
                <div class="options">
                    <v-select
                        :label="{ show: false }"
                        :data="$page.props.areas"
                        keyName="id"
                        optionName="title"
                        typeSelect="whiteSelect"
                        :resetOption="{
                            isShow: true,
                            text: 'Все',
                            isSendRequestAfterReset: true
                        }"
                        mode="Multiple"
                        @selected="
                            area => {
                                areas = area
                                submitFilter()
                            }
                        "
                    ></v-select>
                </div>
            </div>
            <div class="content">
                <div class="content__title">
                    <div class="pointer">
                        <inertia-link
                            :href="route('route.create')"
                            class="orange pointer"
                        >
                            Создать маршрут
                        </inertia-link>
                        <img :src="require('@/../images/icons/plus.svg').default" alt=""/>
                    </div>
                </div>
                <div class="content__inner">
                    <vMap
                        typeMap="routes"
                        ref="map"
                        :isShowNavigator="false"
                        :isShowNavigatorStations="false"
                        :routes="this.$page.props.routes.data"
                        :key="keyForMap"
                    />
                </div>
            </div>
            <div class="routes__table rts">
                <div class="base-header">
                    <h1 id="table_header">Списки маршрутов</h1>
                </div>
                <div class="table__wrapper">
                    <div class="table__wrapper__head">
                        <ul
                            style="grid-template-columns: 1fr 1fr 1fr 1fr 1fr 1fr 1fr 1fr 1fr 1fr"
                        >
                            <li
                                style="max-width: 86.89px; word-break: break-word"
                            >
                                №
                            </li>
                            <li
                                style="max-width: 86.89px; word-break: break-word"
                            >
                                Кол-во заявок
                            </li>
                            <li
                                style="max-width: 86.89px; word-break: break-word"
                            >
                                Кем создан
                            </li>
                            <li
                                style="max-width: 86.89px; word-break: break-word"
                            >
                                Область
                            </li>
                            <li
                                style="max-width: 86.89px; word-break: break-word"
                            >
                                Район
                            </li>
                            <li
                                style="max-width: 86.89px; word-break: break-word"
                            >
                                Номер документа
                            </li>
                            <li
                                style="max-width: 86.89px; word-break: break-word"
                            ></li>
                            <li
                                style="max-width: 86.89px; word-break: break-word"
                            ></li>
                            <li
                                style="max-width: 86.89px; word-break: break-word"
                            ></li>
                            <li
                                style="max-width: 86.89px; word-break: break-word"
                                class="select-all-checkbox"
                            >
                                <input
                                    type="checkbox"
                                    @click="selectAll()"
                                    :checked="isSelectedAll"
                                    id="checkAll"
                                /><label for="checkAll"></label>
                            </li>
                        </ul>
                    </div>
                    <div class="table__wrapper__body">
                        <ul
                            v-for="router in $page.props.routes.data"
                            :key="router.id"
                            style="grid-template-columns: 1fr 1fr 1fr 1fr 1fr 1fr 1fr 1fr 1fr 1fr"
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
                                    `${router.user.firstname} ${router.user.lastname}`
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
                                <span>Номер документа</span>
                                Номер документа
                            </li>
                            <li>
                                <inertia-link
                                    :href="route('route.show', router.id)"
                                    class="pointer orange"
                                >
                                    Показать на карте
                                </inertia-link>
                            </li>
                            <li>
                                <p
                                    class="orange pointer"
                                    @click="
                                        () => {
                                            $refs.modalAlert.open()
                                            closedRoute = router
                                        }
                                    "
                                >
                                    Закрыть маршрут
                                </p>
                            </li>
                            <li>
                                <span class="material-icons gray pointer">
                                    cancel
                                </span>
                            </li>
                            <li class="select-all-checkbox">
                                <input
                                    type="checkbox"
                                    :id="`route${router.id}`"
                                    @click="selectRoute(router.id)"
                                    :checked="isSelectedRoute(router.id)"
                                /><label :for="`route${router.id}`"></label>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="approval" v-if="selectedRoutes.length">
                <p>Отправить маршруты на согласование</p>
                <div class="approval__btns">
                    <button class="btn btn-blue" @click="sendRoutesForApproval">
                        Применить
                    </button>
                    <button class="btn btn-dark" @click="selectAll">
                        Отмена
                    </button>
                </div>
            </div>
            <route-closed
                v-if="closedRoute"
                :router="closedRoute"
                ref="RouteClosed"
            />
            <transition name="fade">
                <vAlert
                    text="Вы уверены что хотите закрыть маршрут"
                    confirmText="Да"
                    refuseText="Нет"
                    @close="closeAlertModal"
                    @confirm="closeRoute"
                    ref="modalAlert"
                />
            </transition>
            <pagination
                v-if="$page.props.routes.meta.last_page > 1"
                :pagination="$page.props.routes.meta"
            >
            </pagination>
        </div>
    </app-layout>
</template>

<script>
import VSelect from '@/components/v-select'
import AppLayout from '../../Layouts/AppLayout.vue'
import Priority from '@/components/priority'
import Pagination from '@/components/Pagination'
import vClickOutside from 'v-click-outside'
import vMap from '@/components/v-map'
import vAlert from '@/components/v-alert'
import RouteClosed from '@/components/RouteClosed'

export default {
    props: ['routes'],
    components: {
        AppLayout,
        VSelect,
        Priority,
        Pagination,
        vMap,
        vAlert,
        RouteClosed
    },
    directives: {
        clickOutside: vClickOutside.directive
    },
    data() {
        return {
            visible: false,
            activeCalendar: true,
            areas: [],
            selectedRoutes: [],
            isSelectedAll: false,
            accept: false,
            isShowAlert: false,
            keyForMap: 1,
            closedRoute: null, // Закрываемый маршрут
            modalCartMenu: null,
            changeStatusForm: this.$inertia.form(
                {
                    status: ''
                },
                {
                    bag: 'changeStatusForm',
                    resetOnSuccess: false
                }
            )
        }
    },
    watch: {
        // async routes(newVal, oldVal) {
        // }
    },
    computed: {},
    methods: {
        func(router) {
            console.log(router)
            console.log(this.$page.props)
        },
        show(data) {
            if (data === true) {
                this.$inertia.put(route('route.update', this.closedRoute), {
                    closed: true
                })
            }
        },
        sendRoutesForApproval() {
            this.selectAll()
            this.$notify({
                group: 'foo',
                text: 'Успешно отправлено'
            })
        },
        selectAll() {
            if (this.isSelectedAll) {
                this.selectedRoutes = []
                this.isSelectedAll = false
                return
            }
            this.$page.props.routes.data.forEach(route => {
                if (!this.isSelectedRoute(route.id)) {
                    this.selectedRoutes.push(route.id)
                }
            })
            this.isSelectedAll = true
        },
        selectRoute(id) {
            if (this.isSelectedRoute(id)) {
                this.removeRouteFromSelectedList(id)
                return
            }
            this.selectedRoutes.push(id)
        },
        removeRouteFromSelectedList(id) {
            this.selectedRoutes.splice(this.selectedRoutes.indexOf(id), 1)
        },
        isSelectedRoute(id) {
            const candidate = this.selectedRoutes.indexOf(id)
            if (candidate !== -1) {
                return true
            }
            return false
        },
        closeAlertModal() {
            this.isShowAlert = false
        },
        closeRoute() {
            // if (data === true) {
            //     this.$inertia.put(route('route.update', this.closedRoute), {
            //         closed: true,
            //     })
            // }
            this.$refs.RouteClosed.open()
        },
        submitFilter() {
            this.keyForMap++
            this.$inertia.get(
                route('route.index'),
                {
                    areas: this.areas
                },
                {
                    preserveScroll: true,
                    preserveState: true,
                    only: ['routes'],
                    bag: 'filter'
                }
            )
        },
        closeModalCart() {
            this.modalCartMenu = null
        },
        openModalStatusChange(status) {
            this.changeStatusForm.status = status
            this.$modal.show('modalReq')
        },
        closeModalStatusChange() {
            this.$modal.hide('modalReq')
        },
        submitChangeStatus(application) {
            this.changeStatusForm.put(
                route('application.update', application),
                {
                    preserveState: true,
                    preserveScroll: true
                }
            )
            this.closeModalStatusChange()
        }
    },
    mounted() {}
}
</script>
<style lang="scss"></style>
