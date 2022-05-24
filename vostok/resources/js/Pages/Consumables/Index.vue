<template>
    <app-layout class="Base crud">
        <template #header>
            <notifications group="foo"/>
            <notifications group="bar"/>
            <div class="base-header__wrapp space-between">
                <div class="obj-header">
                    <h1>Расходные материалы</h1>
                </div>
            </div>
        </template>
        <div class="table__wrapper">
            <div class="table__wrapper__head">
                <ul style="grid-template-columns: 1fr 1fr 1fr">
                    <li>Наименование</li>
                    <li>Единица измерения</li>
                    <li>Стоимость за единицу</li>
                </ul>
            </div>
            <div class="table__wrapper__body">
                <ul style="grid-template-columns: 1fr 1fr 1fr"
                    v-for="(consumable, index) in $page.props.consumables.data" :key="index">
                    <li><span>Наименование:</span>{{ consumable.title }}</li>
                    <li><span>Единица измерения:</span> {{ consumable.unit.title }}</li>
                    <li><span>Стоимость за единицу:</span>{{ consumable.unit.cost }}</li>
                </ul>
            </div>
        </div>
        <pagination
            v-if="$page.props.consumables.meta.last_page > 1"
            :pagination="$page.props.consumables.meta"
        >
        </pagination>
    </app-layout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout'
import Pagination from "@/components/Pagination";

export default {
    components: {
        AppLayout,
        Pagination
    },
}
</script>
