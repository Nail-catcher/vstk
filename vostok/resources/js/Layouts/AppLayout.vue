<template>
    <div class="main-layout main">
        <notifications position="top center" group="success" />
        <notifications position="top center" group="warn" />
        <div class="inner">
            <aside class="aside">
                <div class="menu" :class="{ show: showMenu === true }">
                    <div @click="showMenu = !showMenu" class="menu-close">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                    <div class="menu__logo">
                        <inertia-link :href="route('dashboard')">
                            <img
                                :src="require('@/../images/logo.png').default"
                                alt="logo"
                            />
                        </inertia-link>
                    </div>
                    <nav id="menu">
                        <ul>
                            <li
                                class="home-icon"
                                :class="{
                                    active: route().current('dashboard')
                                }"
                            >
                                <inertia-link :href="route('dashboard')"
                                    >Главный экран
                                </inertia-link>
                            </li>
                            <li
                                class="hist-icon"
                                :class="{
                                    active: route().current('history.index')
                                }"
                            >
                                <span
                                    class="notifications-counter"
                                    :class="{ new_history: new_history }"
                                >
                                </span>
                                <inertia-link :href="route('history.index')">
                                    История действий
                                </inertia-link>
                            </li>
                            <arrow-link
                                :class="{
                                    active: route().current('application.*')
                                }"
                            >
                                <template #header>
                                    <inertia-link
                                        :href="route('application.index')"
                                    >
                                        Заявки
                                    </inertia-link>
                                </template>
                                <li>
                                    <inertia-link
                                        :href="route('application.create')"
                                        :class="{
                                            active:
                                                $page.url ===
                                                '/application/create'
                                        }"
                                    >
                                        Создать заявку
                                    </inertia-link>
                                </li>
                                <li
                                    :class="{
                                        activesssss: route().current(
                                            'application.history'
                                        )
                                    }"
                                >
                                    <inertia-link
                                        :href="route('application.history')"
                                        :class="{
                                            active:
                                                $page.url ===
                                                '/application/history'
                                        }"
                                        >История заявок
                                    </inertia-link>
                                </li>
                            </arrow-link>
                            <li class="nav-icon arrow-link">
                                <inertia-link
                                    :href="route('route.index')"
                                    :class="{
                                        active:
                                            route().current('route.index') ||
                                            route().current('vehicles.index')
                                    }"
                                >
                                    Маршруты
                                </inertia-link>
                                <ul class="sub-menu">
                                    <li>
                                        <inertia-link
                                            :href="route('route.create')"
                                            :class="{
                                                active:
                                                    $page.url ===
                                                    '/route/create'
                                            }"
                                            >Создать маршрут
                                        </inertia-link>
                                    </li>
                                    <li>
                                        <inertia-link
                                            :href="route('route.history')"
                                            :class="{
                                                active: route().current(
                                                    'route.history'
                                                )
                                            }"
                                            >История маршрутов
                                        </inertia-link>
                                    </li>
                                    <li>
                                        <inertia-link
                                            :href="route('vehicles.index')"
                                            :class="{
                                                active: route().current(
                                                    'vehicles.index'
                                                )
                                            }"
                                            >Транспортные средства
                                        </inertia-link>
                                    </li>
                                    <li>
                                        <inertia-link
                                            :href="route('addresses.index')"
                                            :class="{
                                                active:
                                                    $page.url === '/addresses'
                                            }"
                                        >
                                            Адреса прибывания
                                        </inertia-link>
                                    </li>
                                    <li>
                                        <inertia-link
                                            :href="route('places.index')"
                                            :class="{
                                                active: $page.url === '/places'
                                            }"
                                        >
                                            Заборы ключей
                                        </inertia-link>
                                    </li>
                                </ul>
                            </li>
                            <li
                                class="signal-icon"
                                :class="{
                                    active: route().current('station.index')
                                }"
                            >
                                <inertia-link :href="route('station.index')">
                                    Базовые станции
                                </inertia-link>
                            </li>
                            <li
                                class="base-icon"
                                :class="{
                                    active: route().current('station.map')
                                }"
                            >
                                <inertia-link :href="route('station.map')"
                                    >Карта БС
                                </inertia-link>
                            </li>
                            <li
                                class="personal-icon"
                                :class="{ active: route().current('user.*') }"
                            >
                                <inertia-link :href="route('user.index')"
                                    >Персонал
                                </inertia-link>
                            </li>
                            <li
                                class="report-icon"
                                :class="{
                                    active: route().current('reports.index')
                                }"
                            >
                                <inertia-link :href="route('reports.index')">
                                    Отчеты
                                </inertia-link>
                            </li>
                            <li
                                class="stats-icon"
                                :class="{
                                    active: route().current('statistics.index')
                                }"
                            >
                                <inertia-link :href="route('statistics.index')">
                                    Статистика
                                </inertia-link>
                            </li>
                            <li class="uo-icon arrow-link">
                                <inertia-link
                                    :href="route('inventory.index')"
                                    :class="{
                                        active:
                                            route().current('inventory.*') ||
                                            route().current(
                                                'directory.material'
                                            )
                                    }"
                                >
                                    Учет оборудования
                                </inertia-link>
                                <ul
                                    class="sub-menu"
                                    v-if="route().current('inventory.*')"
                                >
                                    <li>
                                        <inertia-link
                                            :href="route('inventory.index')"
                                            :class="{
                                                active: route().current(
                                                    'inventory.index'
                                                )
                                            }"
                                            >Справочник ТМЗ
                                        </inertia-link>
                                    </li>

                                    <li>
                                        <inertia-link
                                            :href="route('inventory.history')"
                                            :class="{
                                                active:
                                                    $page.url ===
                                                    '/inventory/history'
                                            }"
                                            >Отчеты о движении ТМЗ
                                        </inertia-link>
                                    </li>
                                    <li>
                                        <inertia-link
                                            :href="route('consumables.index')"
                                            :class="{
                                                active: route().current(
                                                    'consumables.index'
                                                )
                                            }"
                                            >Расходные материалы
                                        </inertia-link>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </nav>
                    <div class="menu-user">
                        <inertia-link :href="route('profile.show')">
                            <span>
                                <img
                                    :src="$page.props.user.profile_photo_url"
                                    alt=""
                                />
                            </span>
                            <h4>
                                {{ $page.props.user.lastname }}
                                {{ $page.props.user.firstname.charAt(0) }}.
                            </h4>
                        </inertia-link>
                    </div>
                </div>
            </aside>

            <!-- Page Content -->
            <div class="main-wrap">
                <div class="main-header">
                    <div class="burger" @click="showMenu = !showMenu">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                    <slot name="header"></slot>
                </div>
                <slot></slot>
            </div>

            <!-- Modal Portal -->
            <portal-target name="modal" multiple></portal-target>
        </div>
    </div>
</template>

<script>
import ArrowLink from '@/components/ArrowLink'

export default {
    components: {
        ArrowLink
    },
    data() {
        return {
            showMenu: false,
            showingNavigationDropdown: false,
            new_history: null
        }
    },

    computed: {
        path() {
            return window.location.pathname
        }
    },
    mounted() {
        this.new_history = JSON.parse(localStorage.getItem('new_history'))
        Echo.channel('history').listen('HistoryUpdated', e => {
            console.log('channel history', e)
            localStorage.removeItem('new_history')
            localStorage.setItem('new_history', true)
            this.new_history = JSON.parse(localStorage.getItem('new_history'))
        })
    }
}
</script>
