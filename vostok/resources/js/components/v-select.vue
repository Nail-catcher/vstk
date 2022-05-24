<template>
    <div>
        <div
            class="select"
            @click="switchSelect"
            v-if="typeSelect === 'whiteSelect' && data && mode === 'Single'"
            v-click-outside="closeSelect"
        >
            <p v-if="label.show" class="label">{{ label.text }}</p>
            <label style="position: relative">
                <input
                    v-model="searches"
                    :placeholder="title"
                    ref="selectCurrent"
                    :class="{ active: isActive }"
                    class="checker"
                />
            </label>
            <!-- <span
                ref="selectCurrent"
                class="checker"
                :class="{ active: isActive }"
                >{{ title }}</span
            > -->
            <ul
                v-if="isActive"
                class="selectList custom-scroll inner-scroll"
                :class="{ deactivateMaxWidth: maxWidth === '100%' }"
            >
                <li v-if="resetOption.isShow" @click="reset">
                    <label class="resetOption">
                        {{ resetOption.text }}
                    </label>
                </li>
                <div v-for="item in data" :key="item[keyName]">
                    <li
                        v-if="item[optionName] != null"
                        @click="
                            setCurrentSelect(
                                withInitial.isActive
                                    ? `${item[optionName]} ${
                                          item[withInitial.optionName][0]
                                      }.`
                                    : item[optionName],
                                item[keyName]
                            )
                        "
                    >
                        <input
                            :id="item[optionName]"
                            :type="
                                isRadioButton === true ? 'radio' : 'checkbox'
                            "
                            :checked="selectedId === item[keyName]"
                        />
                        <label ref="selectItem" :for="item[optionName]">
                            {{
                                withInitial.isActive
                                    ? `${item[optionName]} ${
                                          item[withInitial.optionName][0]
                                      }.`
                                    : item[optionName]
                            }}
                        </label>
                    </li>
                </div>
            </ul>
        </div>
        <div
            class="select"
            @click="switchSelect"
            v-if="typeSelect === 'test'"
            v-click-outside="closeSelect"
        >
            <p v-if="label.show" class="label">{{ label.text }}</p>
            <label style="position: relative">
                <input
                    readonly
                    v-model="searches"
                    :placeholder="title"
                    ref="selectCurrent"
                    :class="{ active: isActive }"
                    class="checker"
                />
            </label>
            <ul
                v-if="isActive"
                class="selectList custom-scroll inner-scroll"
                :ref="customRef"
                :class="{ deactivateMaxWidth: maxWidth === '100%' }"
            >
                <li v-if="resetOption.isShow" @click="resets()">
                    <label class="resetOption">
                        {{ resetOption.text }}
                    </label>
                </li>
                <div v-for="item in data" :key="item[keyName]">
                    <li
                        v-if="item[optionName] != null"
                        @click="
                            setCurrentSelect(
                                withInitial.isActive
                                    ? `${item[optionName]} ${
                                          item[withInitial.optionName][0]
                                      }.`
                                    : item[optionName],
                                item[keyName]
                            )
                        "
                    >
                        <label ref="selectItem" :for="item[optionName]">
                            {{
                                withInitial.isActive
                                    ? `${item[optionName]} ${
                                          item[withInitial.optionName][0]
                                      }.`
                                    : item[optionName]
                            }}
                        </label>
                    </li>
                </div>
            </ul>
        </div>

        <div
            class="select select__multiple"
            :key="reloadComponent"
            v-click-outside="closeSelect"
            v-if="typeSelect === 'whiteSelect' && data && mode === 'Multiple'"
        >
            <p v-show="label.show" class="label">{{ label.text }}</p>
            <span
                ref="multipleSelect"
                :class="{ active: isActive }"
                @click="switchSelect"
                >{{ title }}</span
            >
            <ul
                v-show="isActive"
                class="custom-scroll inner-scroll"
                :class="{ deactivateMaxWidth: maxWidth === '100%' }"
            >
                <li v-if="resetOption.isShow" @click="reset">
                    <label class="resetOption">
                        {{ resetOption.text }}
                    </label>
                </li>
                <li v-for="item in filteredRole" :key="item[keyName]">
                    <input
                        :type="isRadioButton === true ? 'radio' : 'checkbox'"
                        :id="
                            uuid ? `uuid${item[optionName]}` : item[optionName]
                        "
                    />
                    <label
                        @click="
                            addToTheList({
                                value: item[optionName],
                                id: item[keyName]
                            })
                        "
                        :for="
                            uuid ? `uuid${item[optionName]}` : item[optionName]
                        "
                    >
                        {{
                            withInitial.isActive
                                ? `${item[optionName]} ${
                                      item[withInitial.optionName][0]
                                  }.`
                                : item[optionName]
                        }}</label
                    >
                </li>
            </ul>
        </div>
        <div
            class="select select__multiple"
            :key="reloadComponent"
            v-click-outside="closeSelect"
            v-if="
                typeSelect === 'whiteSelect' &&
                    data &&
                    mode === 'MultipleSearch'
            "
        >
            <p v-show="label.show" class="label">{{ label.text }}</p>
            <span
                ref="multipleSelect"
                :class="{ active: isActive }"
                @click="switchSelect"
                >{{ title }}</span
            >
            <label style="position: relative">
                <input
                    v-model="searches"
                    :placeholder="'Введите вручную'"
                    @click="switchSelect"
                    :class="{ active: isActive }"
                    class="checker"
                />
            </label>
            <ul
                v-show="isActive"
                class="custom-scroll inner-scroll"
                :class="{ deactivateMaxWidth: maxWidth === '100%' }"
            >
                <li v-if="resetOption.isShow" @click="reset">
                    <label class="resetOption">
                        {{ resetOption.text }}
                    </label>
                </li>
                <li v-for="item in filteredRole" :key="item[keyName]">
                    <input
                        :type="isRadioButton === true ? 'radio' : 'checkbox'"
                        :id="
                            uuid ? `uuid${item[optionName]}` : item[optionName]
                        "
                    />
                    <label
                        @click="
                            addToTheList({
                                value: item[optionName],
                                id: item[keyName]
                            })
                        "
                        :for="
                            uuid ? `uuid${item[optionName]}` : item[optionName]
                        "
                    >
                        {{
                            withInitial.isActive
                                ? `${item[optionName]} ${
                                      item[withInitial.optionName][0]
                                  }.`
                                : item[optionName]
                        }}</label
                    >
                </li>
            </ul>
        </div>
        <div
            class="select input-search2"
            v-click-outside="closeSelect"
            v-if="typeSelect === 'whiteSelect' && data && mode === 'Search'"
        >
            <p v-show="label.show" class="label">{{ label.text }}</p>
            <p
                v-if="isShowValidationLabes && dataIsRepeated"
                class="validation_label validation_label__error"
            >
                Данные повторяются
            </p>
            <div @click="func()" class="search-input_container">
                <input
                    type="text"
                    name=""
                    id=""
                    v-if="!globalSearch.use"
                    v-model.trim="search"
                    :placeholder="placeholderSearch"
                    @click="isActive = true"
                    style="padding-right: 72px"
                />
                <input
                    type="text"
                    name=""
                    id=""
                    v-else-if="globalSearch.use"
                    v-model.trim="search"
                    :placeholder="placeholderSearch"
                    @click="isActive = true"
                    @input="runGlobalSearch"
                    style="padding-right: 72px"
                />
                <i
                    class="material-icons pointer done_btn"
                    v-if="isShowBtnDone && search && isDoneSearch === false"
                    @click="endSearch"
                    >done</i
                >
                <i
                    class="material-icons erase_btn pointer"
                    v-if="isShowBtnErase && search"
                    @click="resetSearch"
                    >clear</i
                >
            </div>
            <ul
                v-if="isActive && !globalSearch.use"
                :key="searchData.length"
                class="selectList custom-scroll inner-scroll"
                :class="{ deactivateMaxWidth: maxWidth === '100%' }"
            >
                <li v-if="resetOption.isShow" @click="resetSearch">
                    <label class="resetOption">
                        {{ resetOption.text }}
                    </label>
                </li>
                <li
                    v-for="item in searchData"
                    :key="item[keyName]"
                    :id="`${item.bts_id}`"
                    @click="
                        selectItemFromSearch({
                            value: item[optionName],
                            id: item[keyName]
                        })
                    "
                >
                    {{
                        withInitial.isActive
                            ? `${item[optionName]} ${
                                  item[withInitial.optionName][0]
                              }.`
                            : item[optionName]
                    }}
                    <p v-if="additionalField.isRef">
                        <a
                            @click.stop="routeApp(item)"
                            class="pointer textRight"
                        >
                            {{
                                $tc(
                                    'pluralization.applications',
                                    item.applications_count
                                )
                            }}
                        </a>
                    </p>
                    <p v-if="additionalField.isShow">
                        {{ item[additionalField.optionName] }}test
                    </p>
                </li>
            </ul>
            <ul
                v-else-if="isActive && globalSearch.use"
                :key="globalSearchData.length"
                class="selectList custom-scroll inner-scroll"
                :ref="customRef"
                :class="{ deactivateMaxWidth: maxWidth === '100%' }"
            >
                <li v-if="resetOption.isShow" @click="resetSearch">
                    <label class="resetOption">
                        {{ resetOption.text }}
                    </label>
                </li>
                <li
                    v-for="item in globalSearchData"
                    :key="item[keyName]"
                    :id="`${item.bts_id}`"
                    @click="
                        selectItemFromSearch({
                            value: item[optionName],
                            id: item[keyName],
                            initial: withInitial.isActive
                                ? item[withInitial.optionName]
                                : null
                        })
                    "
                >
                    {{
                        withInitial.isActive
                            ? `${item[optionName]} ${
                                  item[withInitial.optionName][0]
                              }.`
                            : item[optionName]
                    }}

                    <p v-if="additionalField.isRef">
                        <a
                            @click.stop="routeApp(item)"
                            class="pointer textRight"
                        >
                            {{
                                $tc(
                                    'pluralization.applications',
                                    item.applications_count
                                )
                            }}
                        </a>
                    </p>
                    <p v-if="additionalField.isShow">
                        <a v-if="item[additionalField.optionName]">{{
                            item[additionalField.optionName]
                        }}</a>
                        <a v-else>{{ item.area.title }}</a>
                    </p>
                </li>
                <li><a @click="nextPage()">Показать еще</a></li>
            </ul>
        </div>
    </div>
</template>
<script>
import vClickOutside from 'v-click-outside'
import axios from 'axios'

export default {
    directives: {
        clickOutside: vClickOutside.directive
    },
    data: () => ({
        currentPage: 1,
        globalSearchCurrent: [],
        isActive: false,
        listOfSelectedItems: [],
        listOfSelectedId: [],
        search: '',
        searches: '',
        selectedId: null,
        reloadComponent: 1,
        lengthSearch: 0,
        isDoneSearch: false,
        dataIsRepeated: false,
        testParam: '',
        globalSearchData: [],
        keywords: ''
    }),
    props: {
        returnObject: {
            type: Boolean,
            default: false
        },
        isRadioButton: {
            type: Boolean,
            default: false
        },
        maxWidth: {
            type: String,
            default: 'default'
        },
        typeSelect: {
            type: String,
            required: true
        },
        customRef: {
            type: String,
            default: ''
        },
        typeSearch: {
            type: String,
            default: 'Single'
        },
        placeholderSearch: {
            type: String,
            default: 'Поиск'
        },
        resetOption: {
            type: Object,
            default() {
                return {
                    isShow: false,
                    text: '',
                    isSendRequestAfterReset: false
                }
            }
        },
        all: {
            type: Object,
            default() {
                return {
                    text: 'Выбрать'
                }
            }
        },
        isShowValidationLabes: {
            type: Boolean,
            default: false
        },
        title: {
            type: String,
            default: 'Выбрать'
        },
        data: {
            type: Array,
            required: true
        },
        optionName: {
            type: String,
            required: true
        },
        keyName: {
            type: String,
            required: true
        },
        label: {
            type: Object,
            default() {
                return {
                    show: false,
                    text: ''
                }
            }
        },
        isShowBtnErase: {
            type: Boolean,
            default: false
        },
        isShowBtnDone: {
            type: Boolean,
            default: false
        },
        mode: {
            type: String,
            default: 'Single'
        },
        globalSearch: {
            type: Object,
            default() {
                return {
                    use: false,
                    api: '',
                    paramKey: {},
                    dynamicParam: null
                }
            }
        },
        defaultValue: {
            type: Object,
            default() {
                return {
                    isShow: false,
                    data: Object,
                    optionName: String,
                    keyName: String
                }
            }
        },
        uuid: {
            type: Boolean,
            default: false
        },
        withInitial: {
            type: Object,
            default() {
                return {
                    isActive: false,
                    optionName: ''
                }
            }
        },
        additionalField: {
            type: Object,
            default() {
                return {
                    isRef: false,
                    isShow: false,
                    optionName: ''
                }
            }
        }
    },

    watch: {
        search() {
            this.isDoneSearch = false
            const arr = this.search.split(',').filter(bts => bts)
            arr.forEach((item, index) => {
                for (let i = 0; i <= arr.length - 1; i++) {
                    if (index === i) {
                        continue
                    }
                    if (item.toLowerCase() === arr[i].toLowerCase()) {
                        this.dataIsRepeated = true
                        return
                    }
                    this.dataIsRepeated = false
                }
            })
        }
    },
    methods: {
        nextPage() {
            this.currentPage += 1
            axios
                .get(
                    `/web-api/station?page=${this.currentPage}&area=${this.globalSearch.paramKey.area}`
                )
                .then(res => {
                    res.data.data.forEach(item => {
                        this.data.push(item)
                    })
                    this.$nextTick(() => {
                        const el = this.$refs[this.customRef]
                        if (el) {
                            el.scrollTop = el.scrollHeight
                        }
                    })
                })
        },
        func() {
            if (this.globalSearch.use) {
                this.globalSearchData = this.data
            }
            if (this.defaultValue.isShow) {
                this.setCurrentSelect(
                    this.defaultValue.data[this.defaultValue.optionName],
                    this.defaultValue.data[this.defaultValue.keyName]
                )
            }
        },
        routeApp(item) {
            window.open(route('station.application', item.id))
        },
        runGlobalSearch() {
            this.globalSearch.paramKey[this.globalSearch.dynamicParam] =
                this.search.length > 7
                    ? this.search
                          .substr(this.search.lastIndexOf(','))
                          .replace(',', '')
                    : this.search
            if (this.globalSearch.use) {
                axios
                    .get(
                        route(this.globalSearch.api, this.globalSearch.paramKey)
                    )
                    .then(result => {
                        this.globalSearchData = result.data.data
                    })
            }
        },
        switchSelect() {
            document.querySelectorAll('.selectList').forEach(item => {
                item.classList.remove('active')
            })
            this.isActive = !this.isActive
        },
        closeSelect() {
            document.querySelectorAll('.selectList').forEach(item => {
                item.classList.remove('active')
            })
            this.isActive = false
            if (this.typeSearch === 'Multiple' && this.isDoneSearch === false) {
                this.endSearch()
            }
        },
        endSearch() {
            if (this.typeSearch === 'Multiple' && this.isDoneSearch === false) {
                this.search = this.search.replace(/\s+/g, '')
                let arrSearch = this.search.split(',').filter(bts => bts)
                const bts_arr = arrSearch.filter(
                    (item, index) => arrSearch.indexOf(item) === index
                )
                if (this.dataIsRepeated) {
                    this.search = bts_arr.join(',')
                    this.dataIsRepeated = false
                } else {
                    this.search = bts_arr.join(',')
                    this.isActive = false
                    this.isDoneSearch = true
                    const idOfSelectedBts = []
                    if (this.globalSearch.use === true) {
                        if (bts_arr.length > this.globalSearchData.length) {
                            for (const [item, key] of bts_arr.entries()) {
                                this.globalSearch.paramKey[
                                    this.globalSearch.dynamicParam
                                ] = key
                                axios
                                    .get(
                                        route(
                                            this.globalSearch.api,
                                            this.globalSearch.paramKey
                                        )
                                    )
                                    .then(res => {
                                        if (res.data.data.length) {
                                            const foundItem = res.data.data[0]
                                            idOfSelectedBts.push(
                                                foundItem[this.keyName]
                                            )
                                            this.globalSearchCurrent.push(
                                                foundItem[this.keyName]
                                            )
                                        }
                                    })
                            }
                        } else {
                            bts_arr.forEach(bts => {
                                this.globalSearchData.forEach(station => {
                                    if (
                                        station[
                                            this.optionName
                                        ].toLowerCase() === bts.toLowerCase() &&
                                        this.globalSearchCurrent.indexOf(
                                            station[this.keyName]
                                        ) === -1
                                    ) {
                                        idOfSelectedBts.push(
                                            station[this.keyName]
                                        )
                                        this.globalSearchCurrent.push(
                                            station[this.keyName]
                                        )
                                        return
                                    }
                                })
                            })
                        }
                        this.$emit('selected', this.globalSearchCurrent)
                    } else {
                        bts_arr.forEach(bts => {
                            this.data.forEach(station => {
                                if (
                                    station[this.optionName].toLowerCase() ===
                                    bts.toLowerCase()
                                ) {
                                    idOfSelectedBts.push(station[this.keyName])
                                }
                            })
                        })

                        this.$emit('selected', idOfSelectedBts)
                    }
                    // this.$emit('selected', this.globalSearchCurrent)
                    // this.$emit('selected', idOfSelectedBts)
                    return
                }
            }
        },
        setCurrentSelect(selected, key = null) {
            let current = this.$refs.selectCurrent
            current.innerText = selected
            this.searches = selected
            this.selectedId = key
            this.$emit('selected', key)
        },
        selectItemFromSearch({ value, id, initial }) {
            if (this.typeSearch === 'Multiple') {
                const arr = this.search.split(',')
                arr[arr.length - 1] = `${value},`
                this.search = arr.join(',')
                return
            }
            if (this.returnObject) {
                const obj = this.globalSearchData.find(
                    o => o[this.keyName] === id
                )
                this.$emit('selected', obj)
            } else {
                this.$emit('selected', id)
            }
            if (this.withInitial.isActive) {
                this.search = `${value} ${initial[0]}.`
            } else this.search = value
            this.isActive = false
            let test = 'test'
        },
        addToTheList(item) {
            if (
                this.listOfSelectedItems.indexOf(item.value) != -1 &&
                this.listOfSelectedId.indexOf(item.id) != -1
            ) {
                this.listOfSelectedId = this.listOfSelectedId
                    .map(elem => {
                        if (elem !== item.id) {
                            return elem
                        }
                    })
                    .filter(elem => elem !== undefined)
                this.$emit('selected', this.listOfSelectedId)
                this.listOfSelectedItems = this.listOfSelectedItems
                    .map(elem => {
                        if (elem !== item.value) {
                            return elem
                        }
                    })
                    .filter(elem => elem !== undefined)
                if (this.listOfSelectedItems.length) {
                    this.$refs.multipleSelect.innerText = [
                        ...this.listOfSelectedItems
                    ]
                    return
                }
                this.$refs.multipleSelect.innerText = 'Выбрать'
                return
            }
            this.listOfSelectedItems.push(item.value)
            this.listOfSelectedId.push(item.id)
            this.$refs.multipleSelect.innerText = [...this.listOfSelectedItems]
            this.$emit('selected', this.listOfSelectedId)
        },
        resets() {
            this.searches = ''
        },
        reset() {
            if (this.resetOption.isShow) {
                if (this.resetOption.isSendRequestAfterReset) {
                    this.$emit('selected', null)
                }
                this.closeSelect()
            }
            if (this.mode === 'Single') {
                ;[
                    this.selectedId,
                    this.listOfSelectedItems,
                    this.listOfSelectedId,
                    this.$refs.selectCurrent.innerText
                ] = [
                    null,
                    [],
                    [],
                    this.mode === 'Single' ? 'Выбрать' : 'Выбрать'
                ]
                return
            }
            ;[
                this.selectedId,
                this.listOfSelectedItems,
                this.listOfSelectedId,
                this.$refs.multipleSelect.innerText
            ] = [null, [], [], 'Выбрать']
            this.reloadComponent += 1
        },
        resetSearch() {
            this.search = ''
            this.globalSearchCurrent = []
            this.$emit('reset')
        }
    },
    computed: {
        filteredRole() {
            return [...this.data].sort((i, n) => i.title.localeCompare(n.title))
            // return this.data.filter(item => {
            //     return item[this.optionName]
            //         .toLowerCase()
            //         .includes(this.searches.toLowerCase())
            // })
        },
        searchData() {
            if (!this.mode === 'Search' && !this.globalSearch.use) {
                return 0
            }
            if (this.data && this.search && !this.globalSearch.use) {
                if (this.typeSearch === 'Multiple') {
                    const arr = this.search.split(',')
                    const newArray = []

                    let obj = this.data
                    const search = arr[arr.length - 1].toLowerCase()
                    this.isDoneSearch = false

                    for (let item of obj) {
                        let el = item[this.optionName]
                        if (el.toLowerCase().indexOf(search) != -1)
                            newArray.push(item)
                    }

                    this.lengthSearch = arr.length

                    return newArray
                }
                let obj = this.data
                let newArray = []
                const search = this.search.toLowerCase()
                for (let item of obj) {
                    let el = item[this.optionName]
                    if (el.toLowerCase().indexOf(search) != -1)
                        newArray.push(item)
                }
                return newArray
            } else {
                return [...this.data].sort((i, n) =>
                    i.title.localeCompare(n.title)
                )
            }
        }
    },
    mounted() {
        if (this.globalSearch.use) {
            this.globalSearchData = this.data
        }
        if (this.defaultValue.isShow) {
            this.setCurrentSelect(
                this.defaultValue.data[this.defaultValue.optionName],
                this.defaultValue.data[this.defaultValue.keyName]
            )
        }
    }
}
</script>

<style lang="scss" scoped>
.resetOption {
    font-size: 14px;
    font-weight: 500;
    color: #282828;
}
</style>
