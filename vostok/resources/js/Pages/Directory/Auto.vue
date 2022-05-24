<template>
    <app-layout class="Base crud">
        <template #header>
            <notifications group="foo" />
            <notifications group="bar" />
            <div class="base-header__wrapp space-between">
                <div class="obj-header">
                    <h1>Транспортные средства</h1>
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
                <ul
                    style="
                        grid-template-columns: 0.5fr 1fr 0.5fr 0.5fr 0.5fr 0.5fr 0.5fr 0.5fr 0.5fr 0.5fr 0.5fr;
                    "
                >
                    <li style="padding: 0px 10px">Номер</li>
                    <li style="padding: 0px 10px">Автомобиль</li>
                    <li style="padding: 0px 10px">РП</li>
                    <li style="padding: 0px 10px">ЭУ</li>
                    <li style="padding: 0px 10px">Базовая</li>
                    <li style="padding: 0px 10px">Летняя</li>
                    <li style="padding: 0px 10px">Зимняя</li>
                    <li style="padding: 0px 10px">День начало зимы</li>
                    <li style="padding: 0px 10px">Месяц начало зимы</li>
                    <li style="padding: 0px 10px">День окончания зимы</li>
                    <li style="padding: 0px 10px">Месяц окончания зимы</li>
                </ul>
            </div>
            <div class="table__wrapper__body">
                <ul
                    style="
                        grid-template-columns: 0.5fr 1fr 0.5fr 0.5fr 0.5fr 0.5fr 0.5fr 0.5fr 0.5fr 0.5fr 0.5fr;
                    "
                >
                    <li style="padding: 10px 10px">
                        <span>Номер:</span>
                        <p>810CR02</p>
                    </li>
                    <li style="padding: 10px 10px">
                        <span>Автомобиль:</span>
                        <p>
                            Автомобиль грузопас. УАЗ-390995-(460) (№ кузова
                            ХТТ390995G1212478 /№дв.409 (гос№810CR02)
                        </p>
                    </li>
                    <li style="padding: 10px 10px">
                        <span>РП:</span>
                        <p>Алматы</p>
                    </li>
                    <li style="padding: 10px 10px">
                        <span>ЭУ:</span>
                        <p>Алматы</p>
                    </li>
                    <li style="padding: 10px 10px">
                        <span>Базовая:</span>
                        <p>17,50</p>
                    </li>
                    <li style="padding: 10px 10px">
                        <span>Летняя:</span>
                        <p>21,50</p>
                    </li>
                    <li style="padding: 10px 10px">
                        <span>Зимняя:</span>
                        <p>21,50</p>
                    </li>
                    <li style="padding: 0px 10px">
                        <span>День начало зимы:</span>1
                    </li>
                    <li style="padding: 0px 10px">
                        <span>Месяц начало зимы:</span>1
                    </li>
                    <li style="padding: 0px 10px">
                        <span>День окончания зимы:</span>31
                    </li>
                    <li style="padding: 0px 10px">
                        <span>Месяц окончания зимы:</span>31
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
