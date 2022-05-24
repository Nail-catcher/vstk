<template>
    <app-layout class="report bscreate createz">
        <form class="main-wrap reports">
            <div class="base-header">
                <h1>Карточка ТМЗ</h1>
            </div>
            <div class="bscreate_btn">
                <a style="cursor: pointer" @click="change = true">
                    <span>Редактировать БС</span>
                    <img :src="require('@/../images/icons/edit.svg').default" alt="edit"/>
                </a>
                <inertia-link>
                    <span>Удалить</span>
                    <img :src="require('@/../images/icons/delete.svg').default" alt="delete"/>
                </inertia-link>
            </div>
            <div class="bscreate_block">
                <h2>Подробная информация</h2>
                <div
                    v-for="item in items"
                    :key="item.id"
                    class="bscreate_block__wrapper"
                >
                    <div class="bscreate_block__wrapper__item">
                        <span>Артикул</span>
                        <p v-if="change === false">{{ item.articul }}</p>
                        <input
                            :placeholder="item.articul"
                            v-model="item.articul"
                            v-if="change === true"
                            type="text"
                        />
                    </div>
                    <div class="bscreate_block__wrapper__item">
                        <span>Наименование</span>
                        <p v-if="change === false">{{item.name}}</p>
                        <input
                            :placeholder="item.name"
                            v-if="change === true"
                            v-model="item.name"
                            type="text"
                        />
                    </div>
                    <div class="bscreate_block__wrapper__item">
                        <span>Состояние/статус</span>
                        <p v-if="change === false">{{item.status}}</p>
                        <input
                            :placeholder="item.status"
                            v-if="change === true"
                            v-model="item.status"
                            type="text"
                        />
                    </div>
                    <div class="bscreate_block__wrapper__item">
                        <span>Регион</span>
                        <p v-if="change === false">{{item.region}}</p>
                        <input
                            :placeholder="item.region"
                            v-if="change === true"
                            v-model="item.region"
                            type="text"
                        />
                    </div>
                    <div class="bscreate_block__wrapper__item">
                        <span>Категория/подкатегория оборудования</span>
                        <p v-if="change === false">{{item.category}}</p>
                        <input
                            :placeholder="item.category"
                            v-model="item.category"
                            v-if="change === true"
                            type="text"
                        />
                    </div>
                </div>
            </div>
            <button @click.prevent="change = false" class="btn btn-orange">
                Сохранить
            </button>
        </form>
    </app-layout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout'

export default {
    components: {
        AppLayout,
    },
    data: () => ({
        change: false,
        items: [
            {
                id: 1,
                articul: 'Артикул',
                name: 'Наименование',
                status: 'Статус',
                region: 'Регион',
                category: 'Категория',
            },
        ],
    }),
    methods: {
        // func(e){
        //     e.preventDefault()
        // },
        change() {},
    },
}
</script>
