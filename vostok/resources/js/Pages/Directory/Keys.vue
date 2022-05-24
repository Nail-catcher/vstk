<template>
    <app-layout class="Base crud">
        <template #header>
            <notifications group="foo" />
            <notifications group="bar" />
            <div class="base-header__wrapp space-between">
                <div class="obj-header">
                    <h1>Метса забора ключей</h1>
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
                <ul style="grid-template-columns: 0.3fr 1fr 0.7fr 0.7fr">
                    <li>Наименование</li>
                    <li>Адрес</li>
                    <li>Широта</li>
                    <li>Долгота</li>
                </ul>
            </div>
            <div class="table__wrapper__body">
                <ul style="grid-template-columns: 0.3fr 1fr 0.7fr 0.7fr">
                    <li>
                        <span>Наименование:</span>
                        <p>Иссык</p>
                    </li>
                    <li>
                        <span>Адрес:</span>
                        <p>Енбекшиказахский р-он, г. Иссык, ул . Абая</p>
                    </li>
                    <li>
                        <span>Широта:</span>
                        <p>43.35265</p>
                    </li>
                    <li>
                        <span>Долгота:</span>
                        <p>77.46605</p>
                    </li>
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
