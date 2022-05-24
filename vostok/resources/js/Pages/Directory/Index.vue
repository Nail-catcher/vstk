<template>
    <app-layout class="Base crud">
        <template #header>
            <notifications group="foo" />
            <notifications group="bar" />
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
                    <div class="base-header__input">
                    </div>
                </form>
            </div>
        </template>
        <div class="table__wrapper">
            <div class="table__wrapper__head">
                <ul style="grid-template-columns: 1fr 1fr 1fr">
                    <li>Название</li>
                    <li>Адрес</li>
                    <li>Стоимость проживания</li>
                </ul>
            </div>
            <div class="table__wrapper__body">
                <ul style="grid-template-columns: 1fr 1fr 1fr">
                    <li><span>Название:</span>Тестовое название</li>
                    <li><span>Адрес:</span>Москва</li>
                    <li><span>Стоимость проживания:</span>test</li>
                </ul>
            </div>
        </div>
        <!-- <pagination
            v-if="$page.props.stations.meta.last_page > 1"
            :pagination="$page.props.stations.meta"
        >
        </pagination> -->
    </app-layout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout'
import Calendar from '@/components/calendar'
import VSelect from '@/components/v-select'

export default {
    data() {
        return {}
    },
    methods: {},
    components: {
        AppLayout,
        Calendar,
        VSelect,
    },
}
</script>

<style scoped>
</style>
