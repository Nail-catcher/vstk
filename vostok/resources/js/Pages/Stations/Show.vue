<template>
    <app-layout class="report bscreate createz">
        <form class="main-wrap reports">
            <div class="base-header">
                <h1>{{ $page.props.station.title }}</h1>
            </div>
            <div class="bscreate_btn">
                <inertia-link
                    :href="route('station.edit', $page.props.station.id)"
                >
                    <span>Редактировать БС</span>
                    <img :src="require('@/../images/icons/edit.svg').default" alt="edit"/>
                </inertia-link>
                <inertia-link
                    :href="route('station.destroy', $page.props.station.id)"
                >
                    <span>Удалить</span>
                    <img :src="require('@/../images/icons/delete.svg').default" alt="delete"/>
                </inertia-link>
            </div>
            <div class="bscreate_block">
                <h2>Подробная информация</h2>
                <div class="bscreate_block__wrapper">
                    <div class="bscreate_block__wrapper__item">
                        <span>Наименование</span>
                        <p>{{ $page.props.station.title }}</p>
                    </div>
                    <div class="bscreate_block__wrapper__item">
                        <span>Период</span>
                        <p>
                            {{
                                new Date(
                                    $page.props.station.created_at
                                ).toLocaleString({ minute: '2-digit' })
                            }}
                        </p>
                    </div>
                    <div class="bscreate_block__wrapper__item">
                        <span>Site ID</span>
                        <p>{{ $page.props.station.bts_id }}</p>
                    </div>
                    <div class="bscreate_block__wrapper__item">
                        <span>Область</span>
                        <p>{{ $page.props.station.city_id }}</p>
                    </div>
                    <div class="bscreate_block__wrapper__item">
                        <span>Район</span>
                        <p>{{ $page.props.station.area_id }}</p>
                    </div>
                    <div class="bscreate_block__wrapper__item">
                        <span>Населенный пункт</span>
                        <p>{{ $page.props.station.area_id }}</p>
                    </div>
                    <div class="bscreate_block__wrapper__item">
                        <span>Тип базовой станции</span>
                        <p>{{ $page.props.station.base_station_type }}</p>
                    </div>
                    <div class="bscreate_block__wrapper__item">
                        <span>Поставка</span>
                        <p>{{ $page.props.station.supply }}</p>
                    </div>
                    <div class="bscreate_block__wrapper__item">
                        <span>Расстояние, км</span>
                        <p>{{ $page.props.station.distance }}</p>
                    </div>
                    <div class="bscreate_block__wrapper__item">
                        <span>Наименование БС на RAC</span>
                        <p>{{ $page.props.station.rac }}</p>
                    </div>
                    <div class="bscreate_block__wrapper__item">
                        <span>Широта N</span>
                        <p>{{ $page.props.station.location.coordinates[1] }}</p>
                    </div>
                    <div class="bscreate_block__wrapper__item">
                        <span>Долгота E</span>
                        <p>{{ $page.props.station.location.coordinates[0] }}</p>
                    </div>
                    <div class="bscreate_block__wrapper__item">
                        <span>Широта_N</span>
                        <p>51,735181</p>
                    </div>
                    <div class="bscreate_block__wrapper__item">
                        <span>Долгота_E</span>
                        <p>78,776998</p>
                    </div>
                    <div class="bscreate_block__wrapper__item">
                        <span>Высота опоры, м</span>
                        <p>{{ $page.props.station.prop_height }}</p>
                    </div>
                    <div class="bscreate_block__wrapper__item">
                        <span>Тип опоры</span>
                        <p>{{ $page.props.station.prop_type }}</p>
                    </div>
                    <div class="bscreate_block__wrapper__item">
                        <span>Высота подвеса антенны, А</span>
                        <p>
                            {{
                                $page.props.station.antenna_suspension_height_a
                            }}
                        </p>
                    </div>
                    <div class="bscreate_block__wrapper__item">
                        <span>Высота подвеса антенны, B</span>
                        <p>
                            {{
                                $page.props.station.antenna_suspension_height_b
                            }}
                        </p>
                    </div>
                    <div class="bscreate_block__wrapper__item">
                        <span>Высота подвеса антенны, C</span>
                        <p>
                            {{
                                $page.props.station.antenna_suspension_height_c
                            }}
                        </p>
                    </div>
                    <div class="bscreate_block__wrapper__item">
                        <span>Азимуты антенн/угол наклона, А</span>
                        <p>
                            {{
                                $page.props.station
                                    .antenna_azimuths_tilt_angle_a
                            }}
                        </p>
                    </div>
                    <div class="bscreate_block__wrapper__item">
                        <span>Азимуты антенн/угол наклона, B</span>
                        <p>
                            {{
                                $page.props.station
                                    .antenna_azimuths_tilt_angle_b
                            }}
                        </p>
                    </div>
                    <div class="bscreate_block__wrapper__item">
                        <span>Азимуты антенн/угол наклона, C</span>
                        <p>
                            {{
                                $page.props.station
                                    .antenna_azimuths_tilt_angle_c
                            }}
                        </p>
                    </div>
                    <div class="bscreate_block__wrapper__item">
                        <span>Место установки оборудования</span>
                        <p>
                            {{
                                $page.props.station
                                    .equipment_installation_location
                            }}
                        </p>
                    </div>
                    <div class="bscreate_block__wrapper__item">
                        <span>Место установки антенн</span>
                        <p>
                            {{
                                $page.props.station
                                    .antenna_installation_location
                            }}
                        </p>
                    </div>
                    <div class="bscreate_block__wrapper__item">
                        <span>Наличие гарантированного питания от ДГА</span>
                        <p>
                            {{ $page.props.station.guaranteed_power }}
                        </p>
                    </div>
                    <div class="bscreate_block__wrapper__item">
                        <span>Тип стойки ЭП</span>
                        <p>
                            {{ $page.props.station.stand_type }}
                        </p>
                    </div>
                    <div class="bscreate_block__wrapper__item">
                        <span>Тип выпрямительных блоков</span>
                        <p>
                            {{ $page.props.station.rectifier_units_type }}
                        </p>
                    </div>
                    <div class="bscreate_block__wrapper__item">
                        <span>Кол-во выпрямительных блоков</span>
                        <p>
                            {{ $page.props.station.number_rectifier_units }}
                        </p>
                    </div>
                    <div class="bscreate_block__wrapper__item">
                        <span>Емкость АКБ (А)</span>
                        <p>
                            {{ $page.props.station.battery_capacity }}
                        </p>
                    </div>
                    <div class="bscreate_block__wrapper__item">
                        <span>Кол-во АКБ</span>
                        <p>
                            {{ $page.props.station.battery_count }}
                        </p>
                    </div>
                    <div class="bscreate_block__wrapper__item">
                        <span>Приоритет</span>
                        <p>
                            {{ $page.props.station.priority }}
                        </p>
                    </div>
                    <div class="bscreate_block__wrapper__item">
                        <span>Номер заказа</span>
                        <p>
                            {{ $page.props.station.order_number }}
                        </p>
                    </div>
                    <div class="bscreate_block__wrapper__item">
                        <span>Дополнение к заказу</span>
                        <p>
                            {{ $page.props.station.order_additional }}
                        </p>
                    </div>
                    <div class="bscreate_block__wrapper__item">
                        <span>Переименован</span>
                        <p>
                            {{
                                new Date(
                                    $page.props.station.updated_at
                                ).toLocaleString({ minute: '2-digit' })
                            }}
                        </p>
                    </div>
                    <div class="bscreate_block__wrapper__item">
                        <span>Удален</span>
                        <p>
                            {{
                                new Date(
                                    $page.props.station.deleted_at
                                ).toLocaleString({ minute: '2-digit' })
                            }}
                        </p>
                    </div>
                    <div class="bscreate_block__wrapper__item">
                        <span>Добавален</span>
                        <p>
                            {{
                                new Date(
                                    $page.props.station.created_at
                                ).toLocaleString({ minute: '2-digit' })
                            }}
                        </p>
                    </div>
                    <div class="bscreate_block__wrapper__item">
                        <span>Subcon</span>
                        <p>
                            {{ $page.props.station.subcon }}
                        </p>
                    </div>
                </div>
            </div>
            <div class="bscreate_block">
                <h2>История инвентаризации</h2>
                <div class="table__wrapper">
                    <div class="table__wrapper__head">
                        <ul style="grid-template-columns: 0.4fr 0.4fr 1fr">
                            <li>Дата и время</li>
                            <li>Инженер(ФИО)</li>
                            <li>Список предустановленного оборудования</li>
                        </ul>
                    </div>
                    <div class="table__wrapper__body">
                        <ul
                            style="grid-template-columns: 0.4fr 0.4fr 1fr"
                            v-for="h in history"
                            :key="h.id"
                        >
                            <li><span>Дата и время:</span>{{ h.date }}</li>
                            <li><span>Инженер(ФИО):</span>{{ h.name }}</li>
                            <li>
                                <!-- <span
                                    >Список предустановленного
                                    оборудования:</span
                                > -->
                                <div>
                                    <a
                                        style="cursor: pointer"
                                        @click="showModal = true"
                                    >
                                        Список предустановленного оборудования
                                    </a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div v-if="showModal === true" class="bs-modal">
                <div class="bs-modal__block">
                    <div class="bs-modal__block__header">
                        <p>Список предустановленного оборудования</p>
                        <span
                            style="cursor: pointer; color: grey"
                            @click="showModal = false"
                            >x</span
                        >
                    </div>
                    <div class="bs-modal__block__table">
                        <div class="bs-modal-table__head">
                            <ul>
                                <li>№</li>
                                <li>Наименование платы / блока</li>
                                <li>Серийный номер</li>
                                <li>Примечание</li>
                            </ul>
                        </div>
                        <div class="bs-modal-table__body">
                            <ul>
                                <li>
                                    <span>№:</span>
                                    <p>1</p>
                                </li>
                                <li>
                                    <span>Наименование платы / блока:</span>
                                    <p>STDM</p>
                                </li>
                                <li>
                                    <span>Серийный номер:</span>
                                    <p>BF4568712</p>
                                </li>
                                <li>
                                    <span>Примечание:</span>
                                    <p>Примечание</p>
                                </li>
                            </ul>
                            <ul>
                                <li>
                                    <span>№:</span>
                                    <p>1</p>
                                </li>
                                <li>
                                    <span>Наименование платы / блока:</span>
                                    <p>STDM</p>
                                </li>
                                <li>
                                    <span>Серийный номер:</span>
                                    <p>BF4568712</p>
                                </li>
                                <li>
                                    <span>Примечание:</span>
                                    <p>Примечание</p>
                                </li>
                            </ul>
                        </div>
                        <div class="bs-modal__btn">
                            <div>
                                <button class="btn btn-orange">
                                    Скачать лист инвентаризации
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div>
                <button class="btn btn-orange">Выгрузить историю</button>
            </div>
        </form>
    </app-layout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout'

export default {
    components: {
        AppLayout,
    },
    data() {
        return {
            showModal: false,
            history: [
                {
                    date: '15.12.2020 13:00',
                    name: 'Иванов Иван Иванович',
                    title: [
                        {
                            val: 'Наименование оборудования1',
                        },
                        {
                            val: 'Наименование оборудования2',
                        },
                    ],
                },
                {
                    date: '15.12.2020 13:00',
                    name: 'Иванов Иван Иванович',
                    title: [
                        {
                            val: 'Наименование оборудования1',
                        },
                        {
                            val: 'Наименование оборудования2',
                        },
                    ],
                },
                {
                    date: '15.12.2020 13:00',
                    name: 'Иванов Иван Иванович',
                    title: [
                        {
                            val: 'Наименование оборудования1',
                        },
                        {
                            val: 'Наименование оборудования2',
                        },
                    ],
                },
                {
                    date: '15.12.2020 13:00',
                    name: 'Иванов Иван Иванович',
                    title: [
                        {
                            val: 'Наименование оборудования1',
                        },
                        {
                            val: 'Наименование оборудования2',
                        },
                    ],
                },
            ],
            items: [
                {
                    name: 'Наименование:',
                    title:
                        'BTS Лебяжинский Майкарагай (3606CE) SN:98CBS114564-001',
                },
                {
                    name: 'Период:',
                    title: '01.11.2018',
                },
                {
                    name: 'Site ID:',
                    title: 'PA028C',
                },
                {
                    name: 'Область:',
                    title: 'Павлодарская',
                },
                {
                    name: 'Район:',
                    title: 'Лебяжинский',
                },
                {
                    name: 'Населенный пункт:',
                    title: 'Майкарагай',
                },
                {
                    name: 'Тип базовой станции:',
                    title: 'BTS3606CE',
                },
                {
                    name: 'Поставка:',
                    title: '2 010',
                },
                {
                    name: 'Расстояние, км:',
                    title: '206,00',
                },
                {
                    name: 'Наименование БС на RAC:',
                    title: 'RUT_Pavl-27-Maikaragay-450',
                },
                {
                    name: 'Широта N:',
                    title: '51°44`6',
                },
                {
                    name: 'Долгота Е:',
                    title: '78°46`37',
                },
                {
                    name: 'Широта_N:',
                    title: '51,735181',
                },
                {
                    name: 'Долгота_Е:',
                    title: '78,776998',
                },
                {
                    name: 'Высота опоры, м:',
                    title: '30,00',
                },
                {
                    name: 'Тип опоры:',
                    title: 'Мачта',
                },
                {
                    name: 'Высота подвеса антенны, А:',
                    title: '20,00',
                },
                {
                    name: 'Высота подвеса антенны, В:',
                    title: '20,00',
                },
                {
                    name: 'Высота подвеса антенны, C:',
                    title: '20,00',
                },
                {
                    name: 'Азимуты антенн/угол наклона, А:',
                    title: '72,00',
                },
                {
                    name: 'Азимуты антенн/угол наклона, B:',
                    title: '230,00',
                },
                {
                    name: 'Азимуты антенн/угол наклона, C:',
                    title: '330,00',
                },
                {
                    name: 'Место установки оборудования:',
                    title: 'Контейнер (ОДТ)',
                },
                {
                    name: 'Место установки антенн:',
                    title: 'Башня (РГУ "ГЛПР "Ертiс орманы")',
                },
                {
                    name: 'Наличие гарантированого питания от ДГА:',
                    title: 'Нет',
                },
                {
                    name: 'Тип стойки ЭП:',
                    title: 'APM30/APM30H',
                },
                {
                    name: 'Тип выпрямительных блоков:',
                    title: 'EPW30-48A',
                },
                {
                    name: 'Кол-во выпрямительных блоков:',
                    title: '2',
                },
                {
                    name: 'Емкость АКБ (А):',
                    title: '100',
                },
                {
                    name: 'Кол-во АКБ',
                    title: '8',
                },
                {
                    name: 'Приоритет:',
                    title: '2',
                },
                {
                    name: 'Номер заказа:',
                    title: '12',
                },
                {
                    name: 'Дополнение к заказу:',
                    title: '2',
                },
                {
                    name: 'Переименован:',
                    title: '15.12.2020',
                },
                {
                    name: 'Удален:',
                    title: '-',
                },
                {
                    name: 'Добавлен:',
                    title: '15.12.2020',
                },
                {
                    name: 'Subcon:',
                    title: 'Kazahtelekom',
                },
            ],
        }
    },
    methods: {
        func() {
            console.log(this.$page.props)
        },
    },
}
</script>
