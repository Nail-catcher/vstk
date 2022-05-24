<template>
    <app-layout class="trim createz">
        <div class="main-wrap equipment">
            <div class="base-header">
                <h1>Справочник ТМЗ</h1>
                <form
                    :action="route('inventory.index')"
                    @submit.prevent="submit"
                    @change.prevent="submit"
                    method="get"
                >
                    <div class="options">
                        <v-select
                            :label="{ show: false }"
                            :data="$page.props.categories"
                            keyName="id"
                            optionName="title"
                            typeSelect="whiteSelect"
                            mode="Multiple"
                            ref="categoriesSelect"
                            :resetOption="{
                                isShow: true,
                                text: 'Все',
                                isSendRequestAfterReset: true
                            }"
                            @selected="
                                area => {
                                    form.categories = area
                                    submit()
                                }
                            "
                        ></v-select>
                        <div class="input-search">
                            <input
                                type="text"
                                placeholder="Тип РРС"
                                v-model="form.rrs"
                            />
                            <span class="material-icons pointer" @click="submit"
                                >search</span
                            >
                        </div>
                        <div class="input-search">
                            <input
                                type="text"
                                placeholder="Наименование"
                                v-model="form.title"
                            />
                            <span class="material-icons pointer" @click="submit"
                                >search</span
                            >
                        </div>
                        <p
                            class="pointer orange textIcon"
                            @click="resetFilters"
                        >
                            Сбросить
                        </p>
                    </div>
                </form>
            </div>
            <div class="table__wrapper">
                <div class="table__wrapper__head">
                    <ul>
                        <li>№</li>
                        <li>Тип РРС</li>
                        <li>Диапазон</li>
                        <li>Тип оборудования</li>
                        <li>Наименование</li>
                        <li>Производитель код</li>
                        <li>Серийный код</li>
                        <li>Штрих-код</li>
                        <li>QR-код</li>
                    </ul>
                </div>
                <div class="table__wrapper__body">
                    <ul
                        v-for="(inventory, index) in $page.props.inventories
                            .data"
                        :key="index"
                    >
                        <li>
                            <span>№:</span>
                            {{ inventory.id }}
                        </li>
                        <li><span>Тип РРС:</span>{{ inventory.rrs }}</li>
                        <li><span>Диапазон:</span>{{ inventory.range }}</li>
                        <li>
                            <span>Тип оборудования:</span>
                            <p v-if="inventory.category">
                                {{ inventory.category.title }}
                            </p>
                            <p v-else>{{ inventory.category }}</p>
                        </li>
                        <li>
                            <span>Наименование</span>
                            {{ inventory.title }}
                        </li>
                        <li>
                            <span>Производитель код</span>
                            {{ inventory.manufacturer_code }}
                        </li>
                        <li>
                            <span>Серийный код</span>
                            {{ inventory.serial_number }}
                        </li>
                        <li><span>Штрих код</span>-</li>
                        <li><span>Qr код</span>-</li>
                        <li>
                            <inertia-link href="#">
                                <img
                                    :src="require('@/../images/icons/delete.svg').default"
                                    alt="edit"
                                />
                            </inertia-link>
                        </li>
                    </ul>
                </div>
            </div>
            <pagination
                v-if="$page.props.inventories.meta.last_page > 1"
                :pagination="$page.props.inventories.meta"
            >
            </pagination>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout'
import VSelect from '@/components/v-select'
import Pagination from '@/components/Pagination'

export default {
    data: () => ({
        form: {
            categories: [],
            title: '',
            rrs: ''
        }
    }),
    components: {
        AppLayout,
        VSelect,
        Pagination
    },
    methods: {
        submit() {
            this.$inertia.get(route('inventory.index'), this.form, {
                preserveScroll: true,
                preserveState: true,
                only: ['inventories']
            })
        },
        resetFilters() {
          this.$refs.categoriesSelect.reset()
            this.form = {
                categories: [],
                title: '',
                rrs: ''
            }
            this.submit()
        }
    }
}
</script>
