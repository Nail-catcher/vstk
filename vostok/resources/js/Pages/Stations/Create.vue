<template>
    <app-layout class="report bs createz">
        <form class="main-wrap reports">
            <div class="base-header">
                <h1>Добавить БС</h1>
            </div>
            <div style="height: auto" class="reports__content">
                <div class="reports__content__body">
                    <div>
                        <!-- <label for="date">Наименование:</label>
                        <calendar
                            ref="Calendar"
                            :calendarType="'range'"
                            :placeholder="'Выбрать период'"
                            @selectedDate="setDate"
                        /> -->
                        <div
                            style="grid-template-columns: 1fr"
                            class="row form"
                        >
                            <div
                                v-for="item in items"
                                :key="item.id"
                                class="profile-inputs profile-inputs__last"
                            >
                                <label
                                    class="block font-medium text-sm text-gray-700 label"
                                >
                                    <span>{{ item.name }}</span>
                                </label>
                                <input
                                    class="form-input rounded-md shadow-sm mt-1 block w-full"
                                    name="lastname"
                                    required
                                    v-model="item.title"
                                    type="text"
                                />
                            </div>
                            <div class="profile-inputs profile-inputs__last">
                                <label
                                    class="block font-medium text-sm text-gray-700 label"
                                    >Период:</label
                                >
                                <calendar
                                    ref="Calendar"
                                    :calendarType="'range'"
                                    :placeholder="'Выбрать период'"
                                    @selectedDate="setDate"
                                />
                            </div>
                            <div class="profile-inputs profile-inputs__last">
                                <label
                                    class="block font-medium text-sm text-gray-700 label"
                                    >Переименован:</label
                                >
                                <calendar
                                    ref="Calendar"
                                    :placeholder="'15.12.2020'"
                                    @selectedDate="setDate"
                                />
                            </div>
                            <div class="profile-inputs profile-inputs__last">
                                <label
                                    class="block font-medium text-sm text-gray-700 label"
                                    >Удален:</label
                                >
                                <calendar
                                    ref="Calendar"
                                    :placeholder="'-'"
                                    @selectedDate="setDate"
                                />
                            </div>
                            <div class="profile-inputs profile-inputs__last">
                                <label
                                    class="block font-medium text-sm text-gray-700 label"
                                    >Добавлен:</label
                                >
                                <calendar
                                    ref="Calendar"
                                    :placeholder="'15.12.2020'"
                                    @selectedDate="setDate"
                                />
                            </div>
                            <!-- <div class="profile-inputs profile-inputs__last">
                                <label
                                    class="block font-medium text-sm text-gray-700 label"
                                >
                                    <span>Site ID:</span>
                                </label>
                                <input
                                    class="form-input rounded-md shadow-sm mt-1 block w-full"
                                    name="lastname"
                                    required
                                    value="PA028C"
                                    type="text"
                                />
                            </div>
                            <div class="profile-inputs profile-inputs__last">
                                <label
                                    class="block font-medium text-sm text-gray-700 label"
                                >
                                    <span>Область:</span>
                                </label>
                                <input
                                    class="form-input rounded-md shadow-sm mt-1 block w-full"
                                    name="lastname"
                                    required
                                    value="Павлодарская"
                                    type="text"
                                />
                            </div>
                            <div class="profile-inputs profile-inputs__last">
                                <label
                                    class="block font-medium text-sm text-gray-700 label"
                                >
                                    <span>Район:</span>
                                </label>
                                <input
                                    class="form-input rounded-md shadow-sm mt-1 block w-full"
                                    name="lastname"
                                    required
                                    value="Лебяженский"
                                    type="text"
                                />
                            </div>
                            <div class="profile-inputs profile-inputs__last">
                                <label
                                    class="block font-medium text-sm text-gray-700 label"
                                >
                                    <span>Населенный пункт:</span>
                                </label>
                                <input
                                    class="form-input rounded-md shadow-sm mt-1 block w-full"
                                    name="lastname"
                                    required
                                    value="Майкарагай"
                                    type="text"
                                />
                            </div>
                            <div class="profile-inputs profile-inputs__last">
                                <label
                                    class="block font-medium text-sm text-gray-700 label"
                                >
                                    <span>Тип базовой станции:</span>
                                </label>
                                <input
                                    class="form-input rounded-md shadow-sm mt-1 block w-full"
                                    name="lastname"
                                    required
                                    value="BTS3606CE"
                                    type="text"
                                />
                            </div>
                            <div class="profile-inputs profile-inputs__last">
                                <label
                                    class="block font-medium text-sm text-gray-700 label"
                                >
                                    <span>Поставка:</span>
                                </label>
                                <input
                                    class="form-input rounded-md shadow-sm mt-1 block w-full"
                                    name="lastname"
                                    required
                                    value="2 010"
                                    type="text"
                                />
                            </div>
                            <div class="profile-inputs profile-inputs__last">
                                <label
                                    class="block font-medium text-sm text-gray-700 label"
                                >
                                    <span>Расстояние, км:</span>
                                </label>
                                <input
                                    class="form-input rounded-md shadow-sm mt-1 block w-full"
                                    name="lastname"
                                    required
                                    value="206,00"
                                    type="text"
                                />
                            </div>
                            <div class="profile-inputs profile-inputs__last">
                                <label
                                    class="block font-medium text-sm text-gray-700 label"
                                >
                                    <span>Наименование БС на RAC:</span>
                                </label>
                                <input
                                    class="form-input rounded-md shadow-sm mt-1 block w-full"
                                    name="lastname"
                                    required
                                    value="RUT_Pavl-27-Maikagaray-450"
                                    type="text"
                                />
                            </div>
                            <div class="profile-inputs profile-inputs__last">
                                <label
                                    class="block font-medium text-sm text-gray-700 label"
                                >
                                    <span>Широта N:</span>
                                </label>
                                <input
                                    class="form-input rounded-md shadow-sm mt-1 block w-full"
                                    name="lastname"
                                    required
                                    value="51°44`6"
                                    type="text"
                                />
                            </div>
                            <div class="profile-inputs profile-inputs__last">
                                <label
                                    class="block font-medium text-sm text-gray-700 label"
                                >
                                    <span>Долгота Е:</span>
                                </label>
                                <input
                                    class="form-input rounded-md shadow-sm mt-1 block w-full"
                                    name="lastname"
                                    required
                                    value="78°46`37"
                                    type="text"
                                />
                            </div>
                            <div class="profile-inputs profile-inputs__last">
                                <label
                                    class="block font-medium text-sm text-gray-700 label"
                                >
                                    <span>Широта_N:</span>
                                </label>
                                <input
                                    class="form-input rounded-md shadow-sm mt-1 block w-full"
                                    name="lastname"
                                    required
                                    value="51°44`6"
                                    type="text"
                                />
                            </div>
                            <div class="profile-inputs profile-inputs__last">
                                <label
                                    class="block font-medium text-sm text-gray-700 label"
                                >
                                    <span>Долгота_Е:</span>
                                </label>
                                <input
                                    class="form-input rounded-md shadow-sm mt-1 block w-full"
                                    name="lastname"
                                    required
                                    value="78°46`37"
                                    type="text"
                                />
                            </div>
                            <div class="profile-inputs profile-inputs__last">
                                <label
                                    class="block font-medium text-sm text-gray-700 label"
                                >
                                    <span>Высота опоры, м:</span>
                                </label>
                                <input
                                    class="form-input rounded-md shadow-sm mt-1 block w-full"
                                    name="lastname"
                                    required
                                    value="30,00"
                                    type="text"
                                />
                            </div>
                            <div class="profile-inputs profile-inputs__last">
                                <label
                                    class="block font-medium text-sm text-gray-700 label"
                                >
                                    <span>Тип опоры:</span>
                                </label>
                                <input
                                    class="form-input rounded-md shadow-sm mt-1 block w-full"
                                    name="lastname"
                                    required
                                    value="Мачта"
                                    type="text"
                                />
                            </div>
                            <div class="profile-inputs profile-inputs__last">
                                <label
                                    class="block font-medium text-sm text-gray-700 label"
                                >
                                    <span>Высота подвеса антенны, A:</span>
                                </label>
                                <input
                                    class="form-input rounded-md shadow-sm mt-1 block w-full"
                                    name="lastname"
                                    required
                                    value="20,00"
                                    type="text"
                                />
                            </div>
                            <div class="profile-inputs profile-inputs__last">
                                <label
                                    class="block font-medium text-sm text-gray-700 label"
                                >
                                    <span>Высота подвеса антенны, B:</span>
                                </label>
                                <input
                                    class="form-input rounded-md shadow-sm mt-1 block w-full"
                                    name="lastname"
                                    required
                                    value="20,00"
                                    type="text"
                                />
                            </div>
                            <div class="profile-inputs profile-inputs__last">
                                <label
                                    class="block font-medium text-sm text-gray-700 label"
                                >
                                    <span>Высота подвеса антенны, C:</span>
                                </label>
                                <input
                                    class="form-input rounded-md shadow-sm mt-1 block w-full"
                                    name="lastname"
                                    required
                                    value="20,00"
                                    type="text"
                                />
                            </div>
                            <div class="profile-inputs profile-inputs__last">
                                <label
                                    class="block font-medium text-sm text-gray-700 label"
                                >
                                    <span>Азимуты антенн/угол наклона, A:</span>
                                </label>
                                <input
                                    class="form-input rounded-md shadow-sm mt-1 block w-full"
                                    name="lastname"
                                    required
                                    value="72,00"
                                    type="text"
                                />
                            </div>
                            <div class="profile-inputs profile-inputs__last">
                                <label
                                    class="block font-medium text-sm text-gray-700 label"
                                >
                                    <span>Азимуты антенн/угол наклона, B:</span>
                                </label>
                                <input
                                    class="form-input rounded-md shadow-sm mt-1 block w-full"
                                    name="lastname"
                                    required
                                    value="230,00"
                                    type="text"
                                />
                            </div>
                            <div class="profile-inputs profile-inputs__last">
                                <label
                                    class="block font-medium text-sm text-gray-700 label"
                                >
                                    <span>Азимуты антенн/угол наклона, C:</span>
                                </label>
                                <input
                                    class="form-input rounded-md shadow-sm mt-1 block w-full"
                                    name="lastname"
                                    required
                                    value="330,00"
                                    type="text"
                                />
                            </div>
                            <div class="profile-inputs profile-inputs__last">
                                <label
                                    class="block font-medium text-sm text-gray-700 label"
                                >
                                    <span>Место установки оборудования:</span>
                                </label>
                                <input
                                    class="form-input rounded-md shadow-sm mt-1 block w-full"
                                    name="lastname"
                                    required
                                    value="Контейнер(ОДТ)"
                                    type="text"
                                />
                            </div>
                            <div class="profile-inputs profile-inputs__last">
                                <label
                                    class="block font-medium text-sm text-gray-700 label"
                                >
                                    <span>Место установки антенн:</span>
                                </label>
                                <input
                                    class="form-input rounded-md shadow-sm mt-1 block w-full"
                                    name="lastname"
                                    required
                                    value="Башня(РГУ 'ГЛПР'Eptic орманы'' )"
                                    type="text"
                                />
                            </div>
                            <div class="profile-inputs profile-inputs__last">
                                <label
                                    class="block font-medium text-sm text-gray-700 label"
                                >
                                    <span
                                        >Наличие гарантированого питания от
                                        ДГА:</span
                                    >
                                </label>
                                <input
                                    class="form-input rounded-md shadow-sm mt-1 block w-full"
                                    name="lastname"
                                    required
                                    value="Нет"
                                    type="text"
                                />
                            </div>
                            <div class="profile-inputs profile-inputs__last">
                                <label
                                    class="block font-medium text-sm text-gray-700 label"
                                >
                                    <span>Азимуты антенн/угол наклона, C:</span>
                                </label>
                                <input
                                    class="form-input rounded-md shadow-sm mt-1 block w-full"
                                    name="lastname"
                                    required
                                    value="330,00"
                                    type="text"
                                />
                            </div> -->
                        </div>
                    </div>
                </div>
            </div>
            <div style="display: flex">
                <button class="btn btn-orange">Добавить</button>
                <button style="background: #cacaca; margin-left: 15px; color: #fff" class="btn btn-dark">Отмена</button>
            </div>
        </form>
    </app-layout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout'
import VSelect from '@/components/v-select'
import Calendar from '@/components/calendar'
export default {
    components: {
        AppLayout,
        VSelect,
        Calendar,
    },
    data() {
        return {
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
                    name: 'Subcon:',
                    title: 'Kazahtelekom',
                },
            ],
        }
    },
}
</script>