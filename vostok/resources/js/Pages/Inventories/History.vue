<template>
    <app-layout class="createz">
        <div class="main-wrap traffic-reports">
            <div class="base-header">
                <h1>Отчеты о движении ТМЗ</h1>
            </div>
            <div class="traffic-reports__filter mxw1050 mt32">
                <div>
                    <p class="label">Дата:</p>
                    <calendar
                        calendarType="range"
                        :isShowTime="true"
                        ref="calendar"
                        @reset="
                            date => {
                                test.date_from = date
                                test.date_to = date
                                submit()
                            }
                        "
                        @selectedDate="
                            date => {
                                test.date_from = date.start
                                test.date_to = date.end
                                submit()
                            }
                        "
                    />
                </div>
                <v-select
                    typeSelect="whiteSelect"
                    :data="$page.props.users"
                    optionName="lastname"
                    keyName="id"
                    :withInitial="{
                        isActive: true,
                        optionName: 'firstname'
                    }"
                    :isRadioButton="true"
                    :label="{
                        show: true,
                        text: 'МОЛ'
                    }"
                    @reset="
                        value => {
                            test.user = value
                            submit()
                        }
                    "
                    @selected="
                        value => {
                            test.user = value
                            submit()
                        }
                    "
                    :isShowBtnErase="true"
                    :resetOption="{
                        isShow: true,
                        text: 'Сбросить',
                        isSendRequestAfterReset: true
                    }"
                    :globalSearch="{
                        use: true,
                        api: 'api.user.index',
                        dynamicParam: 'lastname',
                        paramKey: {
                            lastname: null,
                            area: form.area,
                        }
                    }"
                    mode="Search"
                    ref="vSelect2"
                />
                <!-- <v-select
                    :data="$page.props.users"
                    keyName="id"
                    optionName="lastname"
                    :label="{ show: true, text: 'МОЛ' }"
                    typeSelect="whiteSelect"
                    :resetOption="{
                        isShow: true,
                        text: 'Сбросить',
                        isSendRequestAfterReset: true
                    }"
                    @reset="
                        value => {
                            test.user = value
                            submit()
                        }
                    "
                    @selected="
                        value => {
                            test.user = value
                            submit()
                        }
                    "
                    ref="vSelect2"
                ></v-select> -->
                <v-select
                    typeSelect="whiteSelect"
                    :data="$page.props.divisions"
                    optionName="title"
                    keyName="id"
                    :isRadioButton="true"
                    :label="{
                        show: true,
                        text: 'Регион'
                    }"
                    @selected="
                        value => {
                            test.division = value
                            submit(value)
                        }
                    "
                    @reset="
                        value => {
                            test.division = value
                            submit()
                        }
                    "
                    :isShowBtnErase="true"
                    mode="Search"
                />
                <div id="filterReset">
                    <p class="pointer orange textIcon" @click="resetFilters">
                        Сбросить фильтры
                        <span class="material-icons">cancel</span>
                    </p>
                </div>
            </div>
            <div class="table__wrapper">
                <div class="table__wrapper__head">
                    <ul>
                        <!--            <li>-->
                        <!--              <input type="checkbox" id="all" @click="selectedAll" />-->
                        <!--              <label for="all"></label>-->
                        <!--            </li>-->
                        <li>МОЛ</li>
                        <li>Кол-во позиций</li>
                        <li>Дата</li>
                        <li>Регион</li>
                    </ul>
                </div>
                <div class="table__wrapper__body">
                    <ul
                        v-for="(item, index) in $page.props.history"
                        :key="index"
                    >
                        <!--            <li>-->
                        <!--              <input-->
                        <!--                type="checkbox"-->
                        <!--                :checked="isSelected(index)"-->
                        <!--                :id="`s${index}`"-->
                        <!--                @click="selectedItem(item.user.id)"-->
                        <!--              />-->
                        <!--              <label :for="`s${index}`"></label>-->
                        <!--            </li>-->
                        <li>
                            <span>Мол</span>{{ item.user.lastname }}
                            {{ item.user.firstname }}
                        </li>
                        <li><span>Кол-во позиций</span>{{ item.count }}</li>
                        <li>
                            <span>Дата</span>
                            {{
                                new Date(item.created_at).toLocaleDateString(
                                    $page.props.locale
                                )
                            }}
                        </li>
                        <li>
                            <span>Регион</span>
                            {{ item.user.division.title }}
                        </li>
                    </ul>
                </div>
            </div>
            <div class="traffic-reports__btns mxw1050">
                <p class="orange">
                    {{
                        isSelectedList.length
                            ? `Выбрано: ${isSelectedList.length}`
                            : ``
                    }}
                </p>
                <a
                    style="margin-top: 15px"
                    class="btn btn-orange"
                    :href="route('inventory.history.download', form)"
                    @click="download"
                >
                    Выгрузить отчет
                </a>
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout'
import Calendar from '@/components/calendar'
import vSelect from '@/components/v-select'

export default {
    components: {
        AppLayout,
        Calendar,
        vSelect
    },
    data() {
        return {
            isSelectedList: [],
            isSelectedAll: false,
            test: {
                user: '',
                date_from: '',
                date_to: '',
                division: ''
            },
            form: {
                user: '',
                date_from: '',
                date_to: '',
                division: ''
            }
        }
    },
    computed: {},
    methods: {
        submit() {
            this.form.date_from = new Date(this.test.date_from).toLocaleString()
            this.form.date_to = new Date(this.test.date_to).toLocaleString()
            this.form.division = this.test.division
            this.form.user = this.test.user
            this.$inertia.get(route('inventory.history'), this.form, {
                preserveScroll: true,
                preserveState: true,
                only: ['history'],
                bag: 'filter'
            })
        },

        download() {
            axios.get(
                route('inventory.history.download', {
                    users: this.isSelectedList,
                    date: this.form.end
                })
            )
        },
        selectedAll() {
            if (this.isSelectedAll === true) {
                this.isSelectedAll = false
                this.isSelectedList = []
                return
            }
            this.isSelectedAll = true
            this.isSelectedList = [0, 1, 2, 3, 4]
        },
        isSelected(index) {
            return this.isSelectedList.indexOf(index) !== -1
        },
        selectedItem(index) {
            this.isSelectedList.push(index)
        },
        resetFilters() {
            // this.$refs.vSelect.reset()
            // this.$refs.vSelect2.reset()
            // this.$refs.calendar.resetDate()
            // this.form.date_from = null
            // this.form.date_to = null
            // this.submit()
            window.location.href = '/inventory/history'
        }
    }
}
</script>

<style scoped></style>
