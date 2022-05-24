<template>
    <app-layout class="Base crud">
        <template #header>
            <notifications group="foo"/>
            <notifications group="bar"/>
            <div class="base-header__wrapp space-between">
                <div class="obj-header">
                    <h1>Адреса прибывания</h1>
                </div>
                <form
                    :action="route('station.index')"
                    method="get"
                    @change.prevent="submit"
                    @submit.prevent="submit"
                >
                    <div class="base-header__input"></div>
                </form>
            </div>
        </template>
        <div class="table__wrapper">
            <div class="table__wrapper__head">
                <ul style="grid-template-columns: 1fr 1fr 1fr 1fr 1fr 1fr 1fr 1fr">
                    <li>Название гостиницы</li>
                    <li>Область</li>
                    <li>Район</li>
                    <li>Город</li>
                    <li>Улица</li>
                    <li>Стоимость</li>
                    <li>Широта</li>
                    <li>Долгота</li>
                </ul>
            </div>
            <div class="table__wrapper__body">
                <ul
                    style="grid-template-columns: 1fr 1fr 1fr 1fr 1fr 1fr 1fr 1fr"
                    v-for="(address, index) in $page.props.addresses.data"
                    :key="index"
                >
                    <li>
                        <span>Название гостиницы:</span>
                        <p>{{ address.title }}</p>
                    </li>
                    <li>
                        <span>Область:</span>
                        <p>{{ address.state.title }}</p>
                    </li>
                    <li>
                        <span>Район:</span>
                        <p>{{ address.region.title }}</p>
                    </li>
                    <li>
                        <span>Город:</span>
                        <p>{{ address.city.title }}</p>
                    </li>
                    <li>
                        <span>Улица:</span>
                        <p>{{ address.address }}</p>
                    </li>
                    <li>
                        <span>Стоимость:</span>
                        <p>{{ address.cost }}</p>
                    </li>
                    <li>
                        <span>Широта:</span>
                        <p>{{ address.location.latitude }}</p>
                    </li>
                    <li>
                        <span>Долгота:</span>
                        <p>{{ address.location.longitude }}</p>
                    </li>
                </ul>
            </div>
        </div>
        <pagination
            v-if="$page.props.addresses.meta.last_page > 1"
            :pagination="$page.props.addresses.meta"
        >
        </pagination>
    </app-layout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout'
import Pagination from '@/components/Pagination'

export default {
    data() {
        return {}
    },
    methods: {},
    components: {
        AppLayout,
        Pagination,
    },
}
</script>

<style scoped>
</style>
