<template>
    <app-layout class="report createz">
        <form class="main-wrap reports">
            <div class="base-header">
                <h1><a>Отчеты</a>/<a>Акты</a></h1>
            </div>
            <div style="height: auto" class="reports__content">
                <input
                    id="doc"
                    v-model="show"
                    type="radio"
                    value="doc"
                    name="document"
                />
                <label for="doc">Отчеты</label>
                <input
                    id="act"
                    v-model="show"
                    type="radio"
                    value="act"
                    name="document"
                />
                <label for="act">Акты</label>
                <div v-if="show === 'doc'" class="reports__content__body">
                    <div style="margin-bottom: 18px">
                        <label for="region">Отчеты</label>
                        <v-select
                            v-if="reportsDoc.length"
                            :label="{ show: false }"
                            :data="reportsDoc"
                            keyName="id"
                            optionName="title"
                            typeSelect="test"
                            @selected="changeStation"
                            :resetOption="{
                                isShow: true,
                                text: 'Все',
                                isSendRequestAfterReset: true
                            }"
                        ></v-select>
                    </div>
                    <div v-if="tabsId === 1">
                        <label for="date">Период:</label>
                        <calendar
                            ref="Calendar"
                            :calendarType="'range'"
                            :placeholder="'Выбрать период'"
                            :key="tabsId"
                            :config="calendarConfig"
                            @selectedDate="
                                period =>
                                    setDate(period, reportOperatorPPR_form)
                            "
                        />
                        <div class="row">
                            <div>
                                <label for="region">РП</label>
                                <v-select
                                    :data="$page.props.areas"
                                    style="margin-right: 10px"
                                    optionName="title"
                                    keyName="id"
                                    typeSelect="whiteSelect"
                                    :key="tabsId"
                                    :resetOption="{
                                        isShow: true,
                                        text: 'Все',
                                        isSendRequestAfterReset: true
                                    }"
                                    @selected="
                                        area => {
                                            reportOperatorPPR_form.area_id = area
                                            selectedState(area)
                                        }
                                    "
                                />
                            </div>
                            <div>
                                <label for="region">БС</label>
                                <v-select
                                    v-if="stations.length"
                                    :label="{ show: false }"
                                    :data="stations"
                                    keyName="id"
                                    optionName="bts_id"
                                    typeSelect="whiteSelect"
                                    mode="Search"
                                    :key="tabsId"
                                    typeSearch="Multiple"
                                    id="filterAreasInRequestCreate"
                                    :globalSearch="{
                                        use: true,
                                        api: 'api.station.index',
                                        dynamicParam: 'bts_id',
                                        paramKey: {
                                            bts_id: null,
                                            area: reportOperatorPPR_form.area_id
                                        }
                                    }"
                                    @selected="
                                        stations =>
                                            (reportOperatorPPR_form.stations = stations)
                                    "
                                    :isShowBtnErase="true"
                                    :isShowBtnDone="true"
                                    :isShowValidationLabes="true"
                                ></v-select>
                            </div>
                        </div>
                    </div>
                    <div v-else-if="tabsId === 2">
                        <label for="date">Период:</label>
                        <calendar
                            ref="Calendar"
                            :calendarType="'range'"
                            :key="tabsId"
                            :placeholder="'Выбрать период'"
                            :config="calendarConfig"
                            @selectedDate="period => setDate(period, form)"
                        />
                        <div class="row">
                            <div>
                                <label for="region">РП</label>
                                <v-select
                                    :data="$page.props.divisions"
                                    style="margin-right: 10px"
                                    optionName="title"
                                    keyName="id"
                                    :key="tabsId"
                                    typeSelect="whiteSelect"
                                    :resetOption="{
                                        isShow: true,
                                        text: 'Все',
                                        isSendRequestAfterReset: true
                                    }"
                                    @selected="
                                        division => (form.division = division)
                                    "
                                />
                            </div>
                        </div>
                    </div>
                    <div v-else-if="tabsId === 3">
                        <label for="date">Период:</label>
                        <calendar
                            ref="Calendar"
                            :calendarType="'range'"
                            :placeholder="'Выбрать период'"
                            :key="tabsId"
                            :config="calendarConfig"
                            @selectedDate="
                                period => {
                                    setDate(period, reportAVRMTC_form)
                                }
                            "
                        />
                        <div class="row">
                            <div>
                                <label for="region">РП</label>
                                <v-select
                                    :data="$page.props.areas"
                                    style="margin-right: 10px"
                                    optionName="title"
                                    :key="tabsId"
                                    keyName="id"
                                    typeSelect="whiteSelect"
                                    :resetOption="{
                                        isShow: true,
                                        text: 'Все',
                                        isSendRequestAfterReset: true
                                    }"
                                    @selected="
                                        area => {
                                            reportAVRMTC_form.area_id = area
                                            selectedState(area)
                                        }
                                    "
                                />
                            </div>
                            <div>
                                <label for="region">МТС </label>
                                <v-select
                                    v-if="stations.length"
                                    :label="{ show: false }"
                                    :data="stations"
                                    keyName="id"
                                    :key="tabsId"
                                    optionName="bts_id"
                                    typeSelect="whiteSelect"
                                    mode="Search"
                                    typeSearch="Multiple"
                                    id="filterAreasInRequestCreate"
                                    :globalSearch="{
                                        use: true,
                                        api: 'api.station.index',
                                        dynamicParam: 'bts_id',
                                        paramKey: {
                                            bts_id: null,
                                            area: reportAVRMTC_form.area_id
                                        }
                                    }"
                                    @selected="
                                        stations =>
                                            (reportAVRMTC_form.stations = stations)
                                    "
                                    :isShowBtnErase="true"
                                    :isShowBtnDone="true"
                                    :isShowValidationLabes="true"
                                ></v-select>
                            </div>
                        </div>
                    </div>
                    <div v-else-if="tabsId === 4">
                        <label for="date">Период:</label>
                        <calendar
                            ref="Calendar"
                            :calendarType="'range'"
                            :placeholder="'Выбрать период'"
                            :key="tabsId"
                            :config="calendarConfig"
                            @selectedDate="
                                period => setDate(period, reportAVR_form)
                            "
                        />
                        <div class="row">
                            <div>
                                <label for="region">РП</label>
                                <v-select
                                    :data="$page.props.areas"
                                    style="margin-right: 10px"
                                    optionName="title"
                                    keyName="id"
                                    typeSelect="whiteSelect"
                                    :key="tabsId"
                                    :resetOption="{
                                        isShow: true,
                                        text: 'Все',
                                        isSendRequestAfterReset: true
                                    }"
                                    @selected="
                                        area => {
                                            reportAVR_form.area_id = area
                                            selectedState(area)
                                        }
                                    "
                                />
                            </div>
                            <div>
                                <label for="region">БС</label>
                                <v-select
                                    v-if="stations.length"
                                    :label="{ show: false }"
                                    :data="stations"
                                    keyName="id"
                                    optionName="bts_id"
                                    :key="tabsId"
                                    typeSelect="whiteSelect"
                                    mode="Search"
                                    typeSearch="Multiple"
                                    id="filterAreasInRequestCreate"
                                    :globalSearch="{
                                        use: true,
                                        api: 'api.station.index',
                                        dynamicParam: 'bts_id',
                                        paramKey: {
                                            bts_id: null,
                                            area: reportAVR_form.area_id
                                        }
                                    }"
                                    @selected="
                                        stations =>
                                            (reportAVR_form.stations = stations)
                                    "
                                    :isShowBtnErase="true"
                                    :isShowBtnDone="true"
                                    :isShowValidationLabes="true"
                                ></v-select>
                            </div>
                        </div>
                    </div>
                </div>
                <div v-else class="reports__content__body">
                    <div style="margin-bottom: 18px">
                        <label for="region">Акты</label>
                        <v-select
                            v-if="actDocs.length"
                            :label="{ show: false }"
                            :data="actDocs"
                            keyName="id"
                            optionName="title"
                            typeSelect="test"
                            :resetOption="{
                                isShow: true,
                                text: 'Все',
                                isSendRequestAfterReset: true
                            }"
                            @selected="changeStation"
                        ></v-select>
                    </div>
                    <div v-if="tabsId === 11 || tabsId === 5">
                        <label for="date">Период:</label>
                        <calendar
                            ref="Calendar"
                            calendarType="range"
                            placeholder="Выбрать период"
                            :key="tabsId"
                            :config="calendarConfig"
                            @selectedDate="
                                period => {
                                    setDate(period, workdone_form)
                                    getApplicationsBy({
                                        created_from:
                                            workdone_form.start || null,
                                        created_to: workdone_form.end || null,
                                        statuses: tabsId === 11 ? [7] : [null]
                                    })
                                }
                            "
                        />
                        <div class="row">
                            <div>
                                <label for="region">РП</label>
                                <v-select
                                    :label="{ show: false }"
                                    :data="$page.props.areas"
                                    keyName="id"
                                    title="Выбор ЭУ"
                                    optionName="title"
                                    typeSelect="whiteSelect"
                                    :key="tabsId"
                                    mode="Single"
                                    id="filterAreasInRequestCreate"
                                    @selected="
                                        area => {
                                            workdone_form.area_id = area
                                            getApplicationsBy({
                                                area: area,
                                                types:
                                                    tabsId === 11 ? [1] : [2],
                                                created_from:
                                                    workdone_form.start || null,
                                                created_to:
                                                    workdone_form.end || null
                                            })
                                        }
                                    "
                                ></v-select>
                            </div>
                            <div>
                                <label for="region">№ Документ</label>
                                <v-select
                                    v-if="applications.length"
                                    typeSelect="whiteSelect"
                                    :data="applications"
                                    optionName="id"
                                    keyName="id"
                                    placeholderSearch="Поиск"
                                    :key="tabsId"
                                    mode="Search"
                                    :globalSearch="{
                                        use: true,
                                        api: 'api.application.index',
                                        dynamicParam: 'id',
                                        paramKey: {
                                            id: null,
                                            status_id: 4,
                                            area: workdone_form.area
                                        }
                                    }"
                                    :isShowBtnErase="true"
                                    :resetOption="{
                                        isShow: true,
                                        text: 'Все',
                                        isSendRequestAfterReset: true
                                    }"
                                    @reset="
                                        value => {
                                            workdone_form.application_id = value
                                        }
                                    "
                                    @selected="
                                        value => {
                                            workdone_form.application_id = value
                                            getApplicationById(value)
                                        }
                                    "
                                />
                            </div>
                            <div class="mt16">
                                <label for="region">БС</label>
                                <v-select
                                    v-if="
                                        workdone_form.application_id &&
                                            stations.length
                                    "
                                    :label="{ show: false }"
                                    :data="stations"
                                    keyName="id"
                                    optionName="bts_id"
                                    typeSelect="whiteSelect"
                                    :key="tabsId"
                                    mode="Multiple"
                                    @selected="
                                        stations =>
                                            (workdone_form.stations = stations)
                                    "
                                    :isShowBtnErase="true"
                                    :isShowBtnDone="true"
                                    :isShowValidationLabes="true"
                                ></v-select>
                            </div>
                        </div>
                    </div>
                    <div v-else-if="tabsId === 7">
                        <label for="date">Период:</label>
                        <calendar
                            ref="Calendar"
                            :calendarType="'range'"
                            :placeholder="'Выбрать период'"
                            :key="tabsId"
                            :config="calendarConfig"
                            @selectedDate="
                                period => {
                                    setDate(period, invertingSheet_form)
                                    getApplicationsBy({
                                        created_from:
                                            invertingSheet_form.start || null,
                                        created_to:
                                            invertingSheet_form.end || null
                                    })
                                }
                            "
                        />
                        <div class="row">
                            <div>
                                <label for="region">РП</label>
                                <v-select
                                    :data="$page.props.areas"
                                    style="margin-right: 10px"
                                    optionName="title"
                                    keyName="id"
                                    typeSelect="whiteSelect"
                                    :key="tabsId"
                                    :resetOption="{
                                        isShow: true,
                                        text: 'Все',
                                        isSendRequestAfterReset: true
                                    }"
                                    @selected="
                                        area => {
                                            invertingSheet_form.area_id = area
                                            getApplicationsBy({
                                                area: area,
                                                created_from:
                                                    invertingSheet_form.start ||
                                                    null,
                                                created_to:
                                                    invertingSheet_form.end ||
                                                    null
                                            })
                                            // get applications by area
                                        }
                                    "
                                />
                            </div>
                            <div>
                                <label for="region">Заявки</label>
                                <v-select
                                    v-if="applications.length"
                                    :label="{ show: false }"
                                    :data="applications"
                                    keyName="id"
                                    optionName="document"
                                    typeSelect="whiteSelect"
                                    :key="tabsId"
                                    mode="Multiple"
                                    @selected="
                                        applications => {
                                            invertingSheet_form.applications = applications
                                            getStationsByApplicationsId(
                                                applications
                                            )
                                        }
                                    "
                                    :isShowBtnErase="true"
                                    :isShowBtnDone="true"
                                    :isShowValidationLabes="true"
                                ></v-select>
                            </div>
                            <div class="mt16">
                                <label for="region">БС</label>
                                <v-select
                                    v-if="stations.length"
                                    :label="{ show: false }"
                                    :data="stations"
                                    keyName="id"
                                    optionName="bts_id"
                                    typeSelect="whiteSelect"
                                    :key="tabsId"
                                    mode="Multiple"
                                    @selected="
                                        stations =>
                                            (invertingSheet_form.stations = stations)
                                    "
                                    :isShowBtnErase="true"
                                    :isShowBtnDone="true"
                                    :isShowValidationLabes="true"
                                ></v-select>
                            </div>
                        </div>
                    </div>
                    <div v-else-if="tabsId === 8">
                        <label for="date">Период:</label>
                        <calendar
                            ref="Calendar"
                            :calendarType="'range'"
                            :placeholder="'Выбрать период'"
                            :key="tabsId"
                            :config="calendarConfig"
                            @selectedDate="
                                period => {
                                    setDate(period, actDischarge_form)
                                }
                            "
                        />
                        <div class="row">
                            <div>
                                <label for="region">РП</label>
                                <v-select
                                    :data="$page.props.areas"
                                    style="margin-right: 10px"
                                    optionName="title"
                                    keyName="id"
                                    typeSelect="whiteSelect"
                                    :key="tabsId"
                                    :resetOption="{
                                        isShow: true,
                                        text: 'Все',
                                        isSendRequestAfterReset: true
                                    }"
                                    @selected="
                                        area => {
                                            actDischarge_form.area_id = area
                                            selectedState(area)
                                            // get applications by area
                                        }
                                    "
                                />
                            </div>
                            <div>
                                <label for="region">БС</label>
                                <v-select
                                    v-if="stations.length"
                                    :label="{ show: false }"
                                    :data="stations"
                                    keyName="id"
                                    optionName="bts_id"
                                    typeSelect="whiteSelect"
                                    :key="tabsId"
                                    mode="Multiple"
                                    @selected="
                                        stations =>
                                            (actDischarge_form.stations = stations)
                                    "
                                    :isShowBtnErase="true"
                                    :isShowBtnDone="true"
                                    :isShowValidationLabes="true"
                                ></v-select>
                            </div>
                        </div>
                    </div>
                    <div v-else-if="tabsId === 6">
                        <div class="row">
                            <div>
                                <label for="region">РП</label>
                                <v-select
                                    :data="$page.props.areas"
                                    style="margin-right: 10px"
                                    optionName="title"
                                    keyName="id"
                                    mode="Single"
                                    :key="tabsId"
                                    typeSelect="whiteSelect"
                                    :resetOption="{
                                        isShow: true,
                                        text: 'Все',
                                        isSendRequestAfterReset: true
                                    }"
                                    @selected="
                                        area => {
                                            actEquipmentInstallation_form.area_id = area
                                            getApplicationsByArea(area, {
                                                statuses: [4, 7],
                                                type: 1
                                            })
                                        }
                                    "
                                />
                            </div>
                            <div>
                                <label for="region">№ Документ</label>
                                <v-select
                                    v-if="applications.length"
                                    typeSelect="whiteSelect"
                                    :data="applications"
                                    optionName="id"
                                    keyName="id"
                                    placeholderSearch="Поиск"
                                    :key="tabsId"
                                    mode="Search"
                                    :globalSearch="{
                                        use: true,
                                        api: 'api.application.index',
                                        dynamicParam: 'id',
                                        paramKey: {
                                            id: null,
                                            status_id: 4,
                                            area:
                                                actEquipmentInstallation_form.area_id
                                        }
                                    }"
                                    :isShowBtnErase="true"
                                    :resetOption="{
                                        isShow: true,
                                        text: 'Все',
                                        isSendRequestAfterReset: true
                                    }"
                                    @reset="
                                        value => {
                                            actEquipmentInstallation_form.application_id = value
                                        }
                                    "
                                    @selected="
                                        value => {
                                            actEquipmentInstallation_form.application_id = value
                                            getApplicationById(value)
                                        }
                                    "
                                />
                            </div>
                            <div>
                                <label for="region">БС</label>
                                <v-select
                                    v-if="stations.length"
                                    :label="{ show: false }"
                                    :data="stations"
                                    keyName="id"
                                    optionName="bts_id"
                                    typeSelect="whiteSelect"
                                    :key="tabsId"
                                    mode="Multiple"
                                    @selected="
                                        stations =>
                                            (actEquipmentInstallation_form.stations = stations)
                                    "
                                    :isShowBtnErase="true"
                                    :isShowBtnDone="true"
                                    :isShowValidationLabes="true"
                                ></v-select>
                            </div>
                        </div>
                    </div>
                    <div v-else-if="tabsId === 10">
                        <label for="date">Период:</label>
                        <calendar
                            ref="Calendar"
                            :calendarType="'range'"
                            :placeholder="'Выбрать период'"
                            :key="tabsId"
                            :config="calendarConfig"
                            @selectedDate="
                                period => {
                                    setDate(period, actDefect_form)
                                    getApplicationsBy({
                                        created_from:
                                            actDefect_form.start || null,
                                        created_to: actDefect_form.end || null
                                    })
                                }
                            "
                        />
                        <div class="row">
                            <div>
                                <label for="region">РП</label>
                                <v-select
                                    :data="$page.props.areas"
                                    style="margin-right: 10px"
                                    optionName="title"
                                    keyName="id"
                                    typeSelect="whiteSelect"
                                    :key="tabsId"
                                    :resetOption="{
                                        isShow: true,
                                        text: 'Все',
                                        isSendRequestAfterReset: true
                                    }"
                                    @selected="
                                        area => {
                                            actDefect_form.area_id = area
                                            getApplicationsBy({
                                                area: area,
                                                created_from:
                                                    actDefect_form.start ||
                                                    null,
                                                created_to:
                                                    actDefect_form.end || null
                                            })
                                            // get applications by area
                                        }
                                    "
                                />
                            </div>
                            <div>
                                <label for="region">Заявка</label>
                                <v-select
                                    v-if="applications.length"
                                    :label="{ show: false }"
                                    :data="applications"
                                    keyName="id"
                                    optionName="document"
                                    typeSelect="whiteSelect"
                                    :key="tabsId"
                                    @selected="
                                        application_id =>
                                            (actDefect_form.application_id = application_id)
                                    "
                                ></v-select>
                            </div>
                        </div>
                    </div>

                    <div v-else-if="tabsId === 9">
                        <div class="row">
                            <div>
                                <label for="region">РП</label>
                                <v-select
                                    :data="$page.props.areas"
                                    style="margin-right: 10px"
                                    optionName="title"
                                    keyName="id"
                                    mode="Single"
                                    typeSelect="whiteSelect"
                                    :key="tabsId"
                                    :resetOption="{
                                        isShow: true,
                                        text: 'Все',
                                        isSendRequestAfterReset: true
                                    }"
                                    @selected="
                                        area => {
                                            actReadingElector_form.area_id = area
                                            selectedState(area)
                                        }
                                    "
                                />
                            </div>
                            <div>
                                <label for="region">БС</label>
                                <v-select
                                    v-if="stations.length"
                                    :label="{ show: false }"
                                    :data="stations"
                                    keyName="id"
                                    optionName="bts_id"
                                    typeSelect="whiteSelect"
                                    :key="tabsId"
                                    mode="Multiple"
                                    @selected="
                                        stations =>
                                            (actReadingElector_form.stations = stations)
                                    "
                                    :isShowBtnErase="true"
                                    :isShowBtnDone="true"
                                    :isShowValidationLabes="true"
                                ></v-select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <a
                v-if="tabsId === 2"
                target="_blank"
                :href="
                    route('reports.workload', {
                        start: form.start,
                        end: form.end,
                        division: form.division
                    })
                "
                class="btn btn-orange"
            >
                Выгрузить отчеты
            </a>
            <a
                v-else-if="tabsId === 11"
                target="_blank"
                :href="
                    route('reports.workdoneAVR', {
                        start: workdone_form.start,
                        end: workdone_form.end,
                        area_id: workdone_form.area_id,
                        application_id: workdone_form.application_id
                    })
                "
                class="btn btn-orange"
            >
                Выгрузить отчеты
            </a>
            <a
                v-else-if="tabsId === 5"
                target="_blank"
                :href="
                    route('reports.workdone', {
                        start: workdone_form.start,
                        end: workdone_form.end,
                        area_id: workdone_form.area_id,
                        application_id: workdone_form.application_id
                    })
                "
                class="btn btn-orange"
            >
                Выгрузить отчеты
            </a>
            <a
                v-else-if="tabsId === 8"
                target="_blank"
                :href="route('reports.actDischarge', actDischarge_form)"
                class="btn btn-orange"
            >
                Выгрузить отчеты
            </a>
            <a
                v-else-if="tabsId === 9"
                target="_blank"
                :href="
                    route('reports.actReadingElector', actReadingElector_form)
                "
                class="btn btn-orange"
            >
                Выгрузить отчеты
            </a>
            <a
                v-else-if="tabsId === 10"
                target="_blank"
                :href="route('reports.actDefect', actDefect_form)"
                class="btn btn-orange"
            >
                Выгрузить отчеты
            </a>
            <a
                v-else-if="tabsId === 7"
                target="_blank"
                :href="route('reports.invertingSheet', invertingSheet_form)"
                class="btn btn-orange"
            >
                Выгрузить отчеты
            </a>
            <a
                v-else-if="tabsId === 1"
                target="_blank"
                :href="
                    route('reports.reportOperatorPPR', reportOperatorPPR_form)
                "
                class="btn btn-orange"
            >
                Выгрузить отчеты
            </a>
            <a
                v-else-if="tabsId === 4"
                target="_blank"
                :href="route('reports.reportAVR', reportAVR_form)"
                class="btn btn-orange"
            >
                Выгрузить отчеты
            </a>
            <a
                v-else-if="tabsId === 3"
                target="_blank"
                :href="route('reports.reportByAVRMTC', reportAVRMTC_form)"
                class="btn btn-orange"
            >
                Выгрузить отчеты
            </a>
            <a
                v-else-if="tabsId === 6"
                target="_blank"
                :href="
                    route(
                        'reports.actEquipmentInstallation',
                        actEquipmentInstallation_form
                    )
                "
                class="btn btn-orange"
            >
                Выгрузить отчеты
            </a>
        </form>
    </app-layout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout'
import Calendar from '@/components/calendar'
import VSelect from '@/components/v-select'
import axios from 'axios'

export default {
    data() {
        return {
            search: '',
            mts: [],
            areaId: null,
            selectedId: null,
            selectedNum: [],
            stations: [],
            show: false,
            tabsId: null,
            subMenu: [
                { id: 1 },
                { id: 2 },
                { id: 3 },
                { id: 4 },
                { id: 5 },
                { id: 6 },
                { id: 7 },
                { id: 8 }
            ],
            calendarConfig: {
                start: {
                    timeAdjust: '00:00:00'
                },
                end: {
                    timeAdjust: '23:59:00'
                }
            },
            form: {
                division: '',
                start: '',
                end: '',
                date: ''
            },
            actReadingElector_form: {
                area_id: null,
                stations: []
            },
            workdone_form: {
                start: '',
                end: '',
                application_id: null,
                area_id: null,
                stations: []
            },
            actDefect_form: {
                start: null,
                end: null,
                application_id: null,
                area_id: null
            },
            invertingSheet_form: {
                start: null,
                end: null,
                area_id: null,
                applications: [],
                stations: []
            },
            actDischarge_form: {
                start: null,
                end: null,
                area_id: null,
                stations: []
            },
            reportOperatorPPR_form: {
                area_id: null,
                end: null,
                start: null,
                stations: []
            },
            reportAVR_form: {
                start: null,
                end: null,
                area_id: null,
                stations: []
            },
            actEquipmentInstallation_form: {
                stations: [],
                area_id: null,
                application_id: null
            },
            reportAVRMTC_form: {
                area_id: null,
                start: null,
                end: null,
                stations: []
            },
            formAct: {
                act: null,
                area: null,
                end: null,
                start: null
            },
            applications: []
        }
    },
    computed: {
        filtered() {
            return this.selectedNum.filter(post => {
                if (post.ticket != null) {
                    return (
                        post.document
                            .toLowerCase()
                            .includes(this.search.toLowerCase()) ||
                        post.ticket
                            .toLowerCase()
                            .includes(this.search.toLowerCase()) ||
                        post.id
                            .toString()
                            .toLowerCase()
                            .includes(this.search.toLowerCase())
                    )
                }
            })
        },
        reportsDoc() {
            const docs = []
            this.$page.props.documents.forEach(doc => {
                if (doc.type === 'report') docs.push(doc)
            })
            return docs
        },
        actDocs() {
            const docs = []
            this.$page.props.documents.forEach(doc => {
                if (doc.type === 'act') docs.push(doc)
            })
            docs.unshift(docs.pop())

            return docs
        }
    },
    methods: {
        submitAct() {
            let api, form
            switch (this.tabsId) {
                case 5:
                    api = 'reports.workdone'
                    form = this.workdone_form
                    break

                default:
                    break
            }
            window.open(route(api, this.workdone_form), '_blank')
        },
        selectedAvr(area) {
            this.areaId = area
            let array = []
            this.mts = []
            console.log(this.$page.props)
            this.$page.props.areas[this.areaId - 1].applications.forEach(
                item => {
                    array.push(item.type)
                }
            )
            array.forEach(item => {
                if (item.id === 1) {
                    this.mts.push(item)
                }
            })
            console.log(this.mts)
        },
        setDate(period, form) {
            form.end = period.end.toLocaleString(this.$page.props.locale)
            form.start = period.start.toLocaleString(this.$page.props.locale)
        },
        selectedMts(area) {
            this.areaId = area
            let array = []
            this.mts = []
            console.log(this.$page.props)
            this.$page.props.areas[this.areaId - 1].applications.forEach(
                item => {
                    array.push(item.project)
                }
            )
            array.forEach(item => {
                if (item.id === 2) {
                    this.mts.push(item)
                }
            })
            console.log(this.mts)
        },
        selectedState(area) {
            this.areaId = area
            axios
                .get(
                    route('api.station.index', {
                        area: this.areaId
                    })
                )
                .then(res => {
                    this.stations = res.data.data
                })
        },
        getByAreaId(areaId = '') {
            this.selectedId = areaId
            this.selectedNum = this.$page.props.areas[
                this.selectedId - 1
            ].applications
            console.log(this.selectedNum)
        },
        changeStation(stationList) {
            this.$page.props.documents.forEach(doc => {
                if (stationList === doc.id) {
                    this.tabsId = doc.id
                }
            })
        },
        /**
         * @param {Array} ids
         */
        getStationsByApplicationsId(ids) {
            this.stations = []
            axios
                .get(
                    route('api.application.index', {
                        ids
                    })
                )
                .then(res => {
                    console.log(res)
                    const applications = res.data.data
                    if (!applications) {
                        return
                    }
                    applications.forEach(application => {
                        this.stations.push(...application.stations)
                    })
                })
        },
        getApplicationById(id) {
            axios
                .get(
                    route('api.application.index', {
                        id: this.workdone_form.application_id,
                        statuses: [4, 7]
                    })
                )
                .then(res => {
                    console.log(res)
                    const application = res.data.data[0]
                    this.stations = []
                    this.applications = []
                    this.applications = res.data.data
                    if (!application) {
                        return
                    }
                    this.applications.forEach(application => {
                        this.stations.push(...application.stations)
                    })
                })
        },
        getApplicationsByArea(area, params = {}) {
            axios
                .get(
                    route('api.application.index', {
                        area,
                        ...params
                    })
                )
                .then(res => {
                    this.stations = []
                    this.applications = []
                    this.applications = res.data.data
                    this.applications.forEach(application => {
                        this.stations.push(...application.stations)
                    })
                })
        },
        getApplicationsBy(params) {
            // start, end, area, status
            axios
                .get(
                    route('api.application.index', {
                        status: 7,
                        ...params
                    })
                )
                .then(result => {
                    console.log(result)
                    this.stations = []
                    this.applications = []
                    this.applications = result.data.data
                    applications.forEach(application => {
                        this.stations.push(...application.stations)
                    })
                })
        }
    },
    components: {
        AppLayout,
        Calendar,
        VSelect
    },
    mounted() {}
}
</script>

<style scoped></style>
