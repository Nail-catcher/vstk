<template>
    <app-layout>
        <div class="main-wrap swap">
            <div class="base-header">
                <h1>Список оборудования</h1>
                <v-select
                    :label="{ show: false }"
                    :data="options"
                    keyName="id"
                    optionName="name"
                    typeSelect="whiteSelect"
                    mode="Multiple"
                    :resetOption="{
                        isShow: true,
                        text: 'Все',
                        isSendRequestAfterReset: true,
                    }"
                    @selected="
                        (area) => {
                            form.areas = area
                            submit()
                        }
                    "
                ></v-select>
            </div>
            <div class="table__wrapper">
                <div class="table__wrapper__head">
                    <ul
                        style="
                            grid-template-columns: 1fr 1fr 1fr 1fr 1fr 0.5fr 0.1fr 0.1fr;
                        "
                    >
                        <li>
                            <input type="checkbox" id="all" v-model="all" />
                            <label style="top: -13px" for="all"></label>
                            <span>Выбрать все</span>
                        </li>
                        <li>Артикул</li>
                        <li>Наименование</li>
                        <li>Статус</li>
                        <li>Регион</li>
                        <li>Категория</li>
                        <li></li>
                    </ul>
                </div>
                <div class="table__wrapper__body">
                    <ul
                        :class="{
                            activeRequestDashboard: n.checked === true,
                        }"
                        v-for="n in items"
                        :key="n.id"
                        style="
                            grid-template-columns: 1fr 1fr 1fr 1fr 1fr 0.5fr 0.1fr 0.1fr;
                        "
                    >
                        <li>
                            <span></span>
                            <p>
                                <label style="top: -13px">
                                    <input
                                        class="check-box"
                                        type="checkbox"
                                        @click="checked(n)"
                                        :value="n.id"
                                        v-model="selected"
                                    />
                                    <p class="check-item"></p>
                                </label>
                            </p>
                        </li>
                        <li>
                            <span>Артикул</span>
                            <p>{{ n.articul }}</p>
                        </li>
                        <li>
                            <span>Наименование</span>
                            <p>{{ n.name }}</p>
                        </li>
                        <li>
                            <span>Статус</span>
                            <p>{{ n.status }}</p>
                        </li>
                        <li>
                            <span>Регион</span>
                            <p>{{ n.region }}</p>
                        </li>
                        <li>
                            <span>Категория</span>
                            <p>{{ n.category }}</p>
                        </li>
                        <li>
                            <inertia-link>
                                <img
                                    style="top: 15px; position: static"
                                    :src="require('@/../images/icons/bucket.svg').default"
                                    alt="edit"
                                />
                            </inertia-link>
                        </li>
                        <li>
                            <inertia-link
                            @click="func()">
                                <img
                                    style="
                                        top: 15px;
                                        max-width: 20px;
                                        position: static;
                                    "
                                    :src="require('@/../images/icons/visibility.svg').default"
                                    alt="edit"
                                />
                            </inertia-link>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="tmz-btn">
                <div>
                    <p>
                        Выбрано: <span>{{ selected.length }}</span>
                    </p>
                </div>
                <div class="tmz-btn__item">
                    <p><img :src="require('@/../images/icons/pechat1.svg').default" alt=""/></p>
                    <button class="btn btn-orange">Сохранить</button>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout'
import VSelect from '@/components/v-select'

export default {
    data: () => ({
        selected: [],
        items: [
            {
                id: 1,
                articul: '123456',
                name: 'Станция БС',
                status: '2 звявки',
                region: 'Алматы',
                category: 'Станция БС',
                checked: false,
            },
            {
                id: 2,
                articul: '123456',
                name: 'Станция БС',
                status: '2 звявки',
                region: 'Алматы',
                category: 'Станция БС',
                checked: false,
            },
            {
                id: 3,
                articul: '123456',
                name: 'Станция БС',
                status: '2 звявки',
                region: 'Алматы',
                category: 'Станция БС',
                checked: false,
            },
            {
                id: 4,
                articul: '123456',
                name: 'Станция БС',
                status: '2 звявки',
                region: 'Алматы',
                category: 'Станция БС',
                checked: false,
            },
            {
                id: 5,
                articul: '123456',
                name: 'Станция БС',
                status: '2 звявки',
                region: 'Алматы',
                category: 'Станция БС',
                checked: false,
            },
        ],
        options: [
            {
                id: 1,
                name: 'Сортировка',
            },
            {
                id: 2,
                name: 'Все',
            },
        ],
    }),
    methods: {
        checked(n) {
            if (n.checked != true) {
                n.checked = true
            } else {
                n.checked = false
            }
        },
        func() {
            document.location.href = '/inventory/show'
        },
    },
    computed: {
        all: {
            get() {
                return this.selected === this.items
            },
            set(val) {
                this.selected = val ? this.items.map((n) => n.id) : []
                this.items.map((n) => (n.checked = true))
                if (val === false) {
                    this.items.map((n) => (n.checked = false))
                }
                // if (check === true) {
                //     this.items.map((i) => (i.checked = false))
                //     console.log('privet')
                // }
            },
        },
    },
    components: {
        AppLayout,
        VSelect,
    },
}
</script>

<style scoped>
</style>
