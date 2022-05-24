<template>
    <app-layout class="Base crud">
        <template #header>
            <notifications group="foo"/>
            <notifications group="bar"/>
            <div class="base-header__wrapp space-between">
                <div class="obj-header">
                    <h1>Места забора ключей</h1>
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
                <ul style="grid-template-columns: 1fr 1fr 1fr">
                    <li>№</li>
                    <li>Наименование</li>
                    <li>Адрес</li>
                </ul>
            </div>
            <div class="table__wrapper__body">
                <ul style="grid-template-columns: 1fr 1fr 1fr" v-for="(place, index) in $page.props.places.data"
                    :key="index">
                    <li><span>№:</span>{{ place.id }}</li>
                    <li><span>Наименование:</span>{{ place.title }}</li>
                    <li><span>Адрес:</span>{{ place.address }}</li>
                </ul>
            </div>
        </div>
        <pagination
            v-if="$page.props.places.meta.last_page > 1"
            :pagination="$page.props.places.meta"
        >
        </pagination>
    </app-layout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout';
import Pagination from "@/components/Pagination";

export default {
    data() {
        return {}
    },
    methods: {},
    components: {
        AppLayout,
        Pagination
    },
}
</script>

<style scoped>
</style>
