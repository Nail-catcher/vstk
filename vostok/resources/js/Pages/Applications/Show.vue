<template>
    <app-layout>
        <div class="main-wrap Base show">
            <div class="base-header">
                <h1>Заявка {{ application.id }}</h1>
            </div>
            <div v-if="alert" class="alert-expired">
                <div class="alert-expired__block">
                    <div class="alert-expired__icons">
                        <span class="material-icons">
                            warning
                        </span>
                        <span>Заявка просрочена</span>
                    </div>
                </div>
                <div class="alert-expired__block">
                    <button>Обновить заявку</button>
                </div>
            </div>
            <div class="Request__actions">
                <div class="Request__actions__item">
                    <p
                        class="textIcon pointer"
                        v-if="!editMode"
                        @click="switchEditMode(true)"
                    >
                        Редактировать
                        <span class="material-icons gray">edit</span>
                    </p>
                    <p
                        class="textIcon pointer"
                        v-else
                        @click="switchEditMode(false)"
                    >
                        Отменить <span class="material-icons gray">reply</span>
                    </p>
                </div>
            </div>
            <div class="Request__information">
                <div id="bgInformation">
                    <div class="base-header">
                        <h1 style="margin-left: 0px">Исходная информация</h1>
                    </div>
                    <div
                        class="main-table base-table mxw1050 Request__table table__wrapper"
                    >
                        <div class="table__wrapper__head">
                            <ul :class="{ editModeClass: editMode }">
                                <li>Приоритет</li>
                                <li>№ Документа</li>
                                <li>БС ID</li>
                                <li>Тип работ</li>
                                <li>Проект</li>
                                <li>Срок</li>
                                <li>Вид работ</li>
                                <li>Статус</li>
                            </ul>
                        </div>
                        <div
                            class="editModeApp_customStyle table__wrapper__body"
                        >
                            <ul
                                class="blackBg"
                                :class="{ editModeClass: editMode }"
                            >
                                <li>
                                    <span>Приоритет:</span>
                                    <div class="">
                                        <priority
                                            :status="application.priority"
                                        />
                                    </div>
                                </li>
                                <li>
                                    <span>№ Документа:</span
                                    >{{ application.ticket }}
                                </li>
                                <li>
                                    <span>БС ID:</span>
                                    <p v-if="application.stations.length">
                                        {{ application.stations[0].bts_id }}
                                    </p>
                                    <p
                                        class="mt8 pointer"
                                        data-type-list="bts"
                                        v-if="application.stations.length > 1"
                                        @click="
                                            openModalList(application, 'bts')
                                        "
                                    >
                                        Еще
                                    </p>
                                </li>
                                <li>
                                    <span>Тип работ:</span
                                    >{{ application.type.title }}
                                </li>
                                <li>
                                    <span>Проект:</span
                                    >{{ application.project.title }}
                                </li>
                                <li>
                                    <span>Срок:</span>
                                    <div v-if="!editMode">
                                        {{
                                            new Date(
                                                application.deadline_at
                                            ).toLocaleString($page.props.locale)
                                        }}
                                    </div>
                                    <calendar
                                        v-else
                                        calendarType="simple"
                                        :isShowTime="true"
                                        @selectedDate="
                                            date => {
                                                form.deadline_at = date
                                            }
                                        "
                                    />
                                </li>
                                <li v-if="!editMode">
                                    <span>Вид работ:</span>
                                    <p v-if="application.works.length">
                                        {{ application.works[0].title }}
                                    </p>
                                    <p
                                        class="mt8 pointer"
                                        data-type-list="works"
                                        v-if="application.works.length > 1"
                                        @click="
                                            openModalList(application, 'works')
                                        "
                                    >
                                        Еще
                                    </p>
                                </li>
                                <v-select
                                    v-else
                                    typeSelect="whiteSelect"
                                    :data="$page.props.works"
                                    optionName="title"
                                    keyName="id"
                                    :label="{ show: false }"
                                    mode="Multiple"
                                    @selected="
                                        works => {
                                            form.works = works
                                        }
                                    "
                                />
                                <li v-if="!editMode">
                                    <span>Статус:</span>
                                    <status :status="application.status" />
                                </li>

                                <li
                                    class="ttt pointer"
                                    @click="
                                        isActiveBlockForChangingStatus = true
                                    "
                                >
                                    <p class="material-icons ltd">more_vert</p>
                                    <div
                                        class="modal-req"
                                        v-if="isActiveBlockForChangingStatus"
                                        v-click-outside="
                                            () => {
                                                isActiveBlockForChangingStatus = false
                                            }
                                        "
                                    >
                                        <button
                                            class="modalReqStatus"
                                            @click="openModalStatusChange"
                                        >
                                            <span class="material-icons gray"
                                                >settings</span
                                            >
                                            Сменить статус
                                        </button>
                                    </div>
                                </li>
                            </ul>
                            <div
                                v-if="application.user.lastname"
                                class="table__wrapper__body none"
                            >
                                <div class="horizontal__body">
                                    <div class="horizontal__body__item">
                                        <p>Ответственный РП:</p>
                                        <td colspan="2">
                                            <div v-show="!editMode">
                                                {{ application.user.lastname }}
                                                {{
                                                    application.user
                                                        .firstname[0]
                                                }}.
                                            </div>
                                            <v-select
                                                v-show="
                                                    editMode && users.length
                                                "
                                                typeSelect="whiteSelect"
                                                :data="users"
                                                optionName="lastname"
                                                keyName="id"
                                                ref="userSelect"
                                                :withInitial="{
                                                    isActive: true,
                                                    optionName: 'firstname'
                                                }"
                                                :isRadioButton="true"
                                                :label="{
                                                    show: true
                                                }"
                                                @selected="
                                                    user => {
                                                        form.user = user
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
                                                        area:
                                                            $page.props
                                                                .application
                                                                .area_id,
                                                        roles: [3]
                                                    }
                                                }"
                                                mode="Search"
                                            />
                                        </td>
                                    </div>
                                    <div class="horizontal__body__item">
                                        <p>Ответственный инженер:</p>
                                        <td colspan="2">
                                            <div v-show="!editMode">
                                                {{
                                                    application.engineer
                                                        .lastname
                                                }}
                                                {{
                                                    application.engineer
                                                        .firstname[0]
                                                }}.
                                            </div>
                                            <v-select
                                                v-show="
                                                    editMode && engineers.length
                                                "
                                                typeSelect="whiteSelect"
                                                :data="engineers"
                                                optionName="lastname"
                                                keyName="id"
                                                ref="engineerSelect"
                                                :withInitial="{
                                                    isActive: true,
                                                    optionName: 'firstname'
                                                }"
                                                :isRadioButton="true"
                                                :label="{
                                                    show: true
                                                }"
                                                @selected="
                                                    user => {
                                                        form.engineer = user
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
                                                        area:
                                                            $page.props
                                                                .application
                                                                .area_id,
                                                        roles: [4]
                                                    }
                                                }"
                                                mode="Search"
                                            />
                                            <!-- <v-select
                                                v-else
                                                typeSelect="whiteSelect"
                                                :data="$page.props.users"
                                                optionName="lastname"
                                                keyName="id"
                                                :label="{ show: false }"
                                                @selected="
                                                    (user) => {
                                                        this.form.user = user
                                                    }
                                                "
                                            /> -->
                                        </td>
                                    </div>
                                    <div class="horizontal__body__item">
                                        <p>Описание аварии:</p>
                                        <td colspan="2">
                                            {{ application.description }}
                                        </td>
                                    </div>
                                    <div class="horizontal__body__item">
                                        <p>Описание заявки:</p>
                                        <td colspan="2">
                                            {{ application.comment }}
                                        </td>
                                    </div>
                                    <div class="horizontal__body__item">
                                        <p>Состав бригады:</p>
                                        <td>
                                            <span
                                                v-for="(user,
                                                index) in application.users"
                                                :key="index"
                                            >
                                                {{ user.lastname }}
                                                {{ user.firstname }},
                                            </span>
                                        </td>
                                        <h3
                                            style="font-weight: bold"
                                            class="mt8"
                                        >
                                            История заявки
                                        </h3>
                                        <!-- <p>Комментарии:</p>
                                        <td>
                                            <p
                                                class="request__comment"
                                                v-for="(
                                                    comment, index
                                                ) in application.comments"
                                                :key="index"
                                            >
                                                {{ comment.comment }}
                                            </p>
                                        </td> -->
                                    </div>
                                    <div
                                        class="horizontal__body__item"
                                        style="align-items: center"
                                    >
                                        <div>
                                            <p>Комментарий:</p>
                                            <span
                                                class="blue"
                                                @click="openModalToAddComment"
                                                >Добавить</span
                                            >
                                        </div>
                                        <div
                                            class="request__comment request_comment_overflow"
                                        >
                                            <span
                                                class="blue"
                                                v-if="
                                                    application.comments.length
                                                "
                                                @click="
                                                    showMoreComments = !showMoreComments
                                                "
                                            >
                                                {{
                                                    showMoreComments
                                                        ? 'Скрыть'
                                                        : 'Показать'
                                                }}
                                            </span>
                                        </div>
                                        <div
                                            class="request__comment__listComment"
                                            v-show="showMoreComments"
                                        >
                                            <div
                                                class="request__comment request_comment_overflow"
                                                v-for="(comment,
                                                index) in application.comments"
                                                :key="comment.id"
                                            >
                                                <p>
                                                    <span class="blue"
                                                        >Дата:</span
                                                    >
                                                    {{
                                                        new Date(
                                                            comment.created_at
                                                        ).toLocaleTimeString(
                                                            $page.props.locale,
                                                            {
                                                                year: '2-digit',
                                                                month:
                                                                    '2-digit',
                                                                day: '2-digit',
                                                                hour: '2-digit',
                                                                minute:
                                                                    '2-digit'
                                                            }
                                                        )
                                                    }}
                                                </p>
                                                <p>
                                                    <span class="blue"
                                                        >Автор:</span
                                                    >
                                                    {{ comment.user.lastname }}
                                                    {{ comment.user.firstname }}
                                                </p>
                                                <p>
                                                    <span class="blue"
                                                        >Комментарий:
                                                    </span>
                                                    {{ comment.comment }}
                                                </p>
                                                <br />
                                                <span
                                                    class="blue"
                                                    v-if="
                                                        index ===
                                                            application.comments
                                                                .length -
                                                                1 &&
                                                            application.comments
                                                                .length > 4
                                                    "
                                                    @click="
                                                        showMoreComments = !showMoreComments
                                                    "
                                                >
                                                    {{
                                                        showMoreComments
                                                            ? 'Скрыть'
                                                            : 'Еще'
                                                    }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div
                                        class="horizontal__body__item"
                                        style="align-items: start"
                                    >
                                        <p>Смена статуса:</p>
                                        <td colspan="2">
                                            <div
                                                class="request__comment request_comment_overflow"
                                                v-for="(comment,
                                                index) in application.statuses"
                                                :key="index"
                                            >
                                                <p class="blue">
                                                    Смена статуса: "{{
                                                        comment.pivot.old_status
                                                            .title
                                                    }}" -> "{{ comment.title }}"
                                                </p>
                                                <p>
                                                    <span class="blue"
                                                        >Дата:</span
                                                    >
                                                    {{
                                                        new Date(
                                                            comment.pivot.created_at
                                                        ).toLocaleTimeString(
                                                            $page.props.locale,
                                                            {
                                                                year: '2-digit',
                                                                month:
                                                                    '2-digit',
                                                                day: '2-digit',
                                                                hour: '2-digit',
                                                                minute:
                                                                    '2-digit'
                                                            }
                                                        )
                                                    }}
                                                </p>
                                                <p>
                                                    <span class="blue">
                                                        Автор:
                                                    </span>
                                                    {{
                                                        comment.pivot.user
                                                            .firstname
                                                    }}
                                                    {{
                                                        comment.pivot.user
                                                            .lastname
                                                    }}
                                                </p>
                                                <p>
                                                    <span class="blue">
                                                        Комментарий:
                                                    </span>
                                                    {{ comment.pivot.comment }}
                                                    <br />
                                                </p>
                                            </div>
                                        </td>
                                    </div>
                                    <div
                                        v-if="application.keys_comment"
                                        class="horizontal__body__item"
                                        style="align-items: start"
                                    >
                                        <p>Забрать ключи:</p>
                                        <p>
                                            {{ application.keys_comment }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <button
                    class="btn btn-orange mt16"
                    v-if="editMode"
                    @click="submitUpdate"
                >
                    Сохранить
                </button>
                <br />
                <div class="base-header">
                    <h1>История статусов</h1>
                </div>
                <br />
                <div class="horizontal__body">
                    <div class="horizontal__body__item">
                        <p>Состав бригады:</p>
                        <td>
                            <span v-for="(user, index) in application.users">
                                {{ user.lastname }} {{ user.firstname }},
                            </span>
                        </td>
                    </div>
                    <div class="horizontal__body__item">
                        <p>Принятие:</p>
                        <td colspan="2">
                            <div
                                class="request__comment request_comment_overflow"
                                v-for="(accept, index) in application.accepts"
                            >
                                <p>
                                    <span class="blue">Принята:</span>
                                    {{
                                        new Date(
                                            accept.created_at
                                        ).toLocaleTimeString(
                                            $page.props.locale,
                                            {
                                                day: '2-digit',
                                                month: '2-digit',
                                                year: 'numeric',
                                                hour: '2-digit',
                                                minute: '2-digit'
                                            }
                                        )
                                    }}
                                </p>
                                <p>
                                    <span class="blue"> Автор: </span>
                                    {{ accept.user.firstname }}
                                    {{ accept.user.lastname }}
                                </p>
                                <p>
                                    <span class="blue">Состав бригады: </span>
                                    <span
                                        class="brg"
                                        v-for="user in accept.users"
                                        :key="user.id"
                                    >
                                        {{ user.firstname }}
                                        {{ user.lastname }},
                                    </span>
                                </p>
                                <p>
                                    <span class="blue">Ответственный: </span>
                                    {{ accept.user.firstname }}
                                    {{ accept.user.lastname }}
                                    <br />
                                </p>
                                <p>
                                    <span class="blue">Комментарий: </span>
                                    {{ accept.comment }}
                                    <br />
                                </p>
                            </div>
                        </td>
                    </div>
                    <div
                        class="horizontal__body__item"
                        v-if="application.hours_count !== null"
                    >
                        <p>Количество часов:</p>
                        <td>
                            <p class="request__comment">
                                {{ application.hours_count }}
                            </p>
                        </td>
                    </div>
                </div>
                <br />
                <div v-if="application.distance" class="base-header">
                    <h1>Километраж</h1>
                </div>
                <br />
                <div v-if="application.distance" class="horizontal__body">
                    <div class="horizontal__body__item">
                        <p>Плановый:</p>
                        <td>
                            <span
                                >{{
                                    Number(application.distance / 1000).toFixed(
                                        2
                                    )
                                }}
                                km</span
                            >
                        </td>
                    </div>
                </div>
                <div
                    class="base-header"
                    style="marign-top: 18px;margin-bottom: 18px"
                >
                    <h1>Ход работы</h1>
                </div>
                <div
                    style="background: #fff"
                    class="sidebar__request_body border_bottom"
                >
                    <div
                        class="sidebar__request_body__item working_process"
                        v-for="(report, reportIndex) in $page.props.application
                            .application_report"
                        :key="report.id"
                        :class="{ active: show === true || reportIndex === 0 }"
                    >
                        <div class="working_process__head">
                            <div class="working_process__item">
                                <span
                                    >Заявка №: {{ report.application_id }}</span
                                >
                            </div>
                        </div>
                        <div>
                            <p>
                                Время завершения:
                                <span v-if="report.created_at">
                                    {{
                                        new Date(
                                            report.created_at
                                        ).toLocaleString()
                                    }}
                                </span>
                            </p>
                            <p v-if="report.engineer">
                                Инженеры:
                                <a
                                    :href="
                                        route('user.edit', report.engineer.id)
                                    "
                                >
                                    {{ report.engineer.firstname }}
                                    {{ report.engineer.lastname }}
                                </a>
                            </p>
                            <p>
                                Список работ:
                                <span
                                    v-for="(reportWork, index) in report.works"
                                    :key="reportWork.id"
                                >
                                    {{ reportWork.title }}
                                    {{ report.works.length > index ? ',' : '' }}
                                </span>
                            </p>
                            <p>
                                Комментарий:
                                {{ report.comment }}
                            </p>
                            <div class="report_gallery_container">
                                <p>Фото:</p>
                                <div class="report_gallery">
                                    <img
                                        class="pointer"
                                        v-for="(img, index) in report.images"
                                        :key="index"
                                        :src="img.url"
                                        alt=""
                                        @mouseover="hoverPhotoId = index"
                                        :class="{
                                            blur: hoverPhotoId === index
                                        }"
                                        @click="
                                            switchSliderModal(
                                                true,
                                                index,
                                                report.images
                                            )
                                        "
                                    />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div
                        v-for="item in $page.props.application.startings"
                        :key="item.id"
                        class="sidebar__request_body__item working_process"
                        :class="{ active: show === true }"
                    >
                        <div class="working_process__head">
                            <div class="working_process__item">
                                <span>БС ID:</span>
                                <p>{{ item.station.bts_id }}</p>
                            </div>
                            <div class="working_process__item">
                                <span>Инженер - </span>
                                <p @click="func(item)">
                                    {{ item.user.lastname }}
                                    {{ item.user.firstname }}
                                </p>
                            </div>
                        </div>
                        <div
                            v-for="(progress, index) in item.progresses"
                            class="working_process__sect"
                            @click="test()"
                            :key="index"
                        >
                            <div class="working_process__item">
                                <div>
                                    <div style="display: flex">
                                        <span v-if="progress.progress.id === 1">
                                            {{
                                                new Date(progress.updated_at)
                                                    .toLocaleString(
                                                        $page.props.locale
                                                    )
                                                    .substr(0, 17)
                                            }}</span
                                        >
                                        <span v-else>
                                            {{
                                                new Date(progress.updated_at)
                                                    .toLocaleString(
                                                        $page.props.locale
                                                    )
                                                    .substr(12, 5)
                                            }}
                                        </span>
                                        <p
                                            v-for="(prog,
                                            i) in progress.progress"
                                            :key="i"
                                        >
                                            {{ prog.title }} 
                                        </p>

                                    </div>
                                    <div v-if="progress.works.length">
                                        <p
                                            v-for="work in progress.works"
                                            :key="work.id"
                                        >
                                            {{ work.title }}
                                        </p>

                                    </div>
                                    <p
                                        v-for="inventory in progress.inventories"
                                        :key="inventory.id"
                                    >
                                        {{ inventory.title }}
                                        {{ inventory.manufacturer_code }}
                                    </p>
                                    <div style="display:flex">
                                        <p
                                            style="background: #007b0029; padding: 10px"
                                        >
                                            {{ progress.progress.title }} 
                                        </p>
                                         <p
                                         style="padding: 10px"
                                           v-if="progress.step"
                                        >
                                            {{progress.step.title}}
                                        </p>
                                    </div>
                                    
                                    <div
                                        v-if="
                                            progress.typeable &&
                                                progress.typeable.modelable
                                        "
                                    >
                                        <p>
                                            {{
                                                progress.typeable.modelable
                                                    .title
                                            }}
                                        </p>
                                    </div>
                                    <div v-if="progress.typeable">
                                        <div style="display:flex">
                                            <p>Норма</p>
                                            <p>{{ progress.typeable.value }}</p>
                                        </div>
                                        <div style="display:flex">
                                            <p>Отклонение</p>
                                            <p>
                                                {{
                                                    progress.typeable.deviation
                                                }}
                                            </p>
                                        </div>
                                    </div>
                                    <div v-if="progress.images.length">
                                        <img
                                            v-for="(img,
                                            index) in progress.images"
                                            :key="img.id"
                                            style="max-width: 150px"
                                            :src="img.url"
                                            @click="
                                                switchSliderModal(
                                                    true,
                                                    index,
                                                    progress.images
                                                )
                                            "
                                        />
                                    </div>
                                    <div
                                        style="display:flex"
                                        v-if="progress.comment"
                                    >
                                        Примечание
                                        <p
                                            style="background: #007b0029; padding: 10px"
                                        >
                                            {{ progress.comment }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <a
                        style="cursor: pointer"
                        v-if="show === false"
                        @click="show = true"
                        >Показать все</a
                    >
                    <a
                        style="cursor: pointer"
                        v-if="show === true"
                        @click="show = false"
                        >Скрыть</a
                    >
                </div>
                <div
                    class="base-header"
                    style="margin-top: 18px;margin-bottom: 18px; display: none"
                >
                    <h1>Отчеты о ППР</h1>
                </div>
                <div
                    style="background: #fff; display: none"
                    class="sidebar__request_body border_bottom"
                >
                    <div
                        class="sidebar__request_body__item working_process active"
                    >
                        <div class="working_process__head">
                            <div class="working_process__item">
                                <span>Контрольный разряд АКБ</span>
                            </div>
                        </div>
                        <div class="working_process__sect">
                            <div class="working_process__item">
                                <div>
                                    <div style="display: flex">
                                        <span>
                                            <!-- {{ new Date()}} -->
                                            10.05.2021, 21:00
                                        </span>
                                        <p>Контрольный разряд акб</p>
                                    </div>
                                    <p>
                                        Норма: Значение
                                    </p>
                                    <p>
                                        Отклонение: Значение
                                    </p>
                                    <p>Примечание: Значение</p>
                                    <p
                                        style="background: #007b0029; padding: 10px"
                                    >
                                        Комментарий
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <a
                        style="cursor: pointer"
                        v-if="show === false"
                        @click="show = true"
                        >Показать все</a
                    >
                    <a
                        style="cursor: pointer"
                        v-if="show === true"
                        @click="show = false"
                        >Скрыть</a
                    >
                </div>
                <div
                    class="base-header"
                    style="margin-top: 18px;margin-bottom: 18px; display: none"
                >
                    <h1>Акт заряда-разряда АКБ</h1>
                </div>
                <div
                    style="background: #fff; display: none"
                    class="sidebar__request_body border_bottom"
                >
                    <div
                        class="sidebar__request_body__item working_process active"
                    >
                        <div class="working_process__head">
                            <div class="working_process__item">
                                <span>АКБ 1</span>
                            </div>
                        </div>
                        <div class="working_process__sect">
                            <div class="working_process__item">
                                <div>
                                    <div style="display: flex">
                                        <span>
                                            <!-- {{ new Date()}} -->
                                            10.05.2021, 21:00
                                        </span>
                                        <p>Контрольный разряд акб</p>
                                    </div>
                                    <p>
                                        Тип АКБ: NSD92FT
                                    </p>
                                    <p>
                                        Номинальная емкость: 92
                                    </p>
                                    <p>Номинальное напряжение: 82</p>
                                    <p>Ток разряда: 56</p>
                                    <p>Дата: 10.05.2021, 21:00</p>
                                    <p>Объект: Значение</p>
                                    <p>№ Элемента группы: Значение</p>
                                    <p
                                        style="background: #007b0029; padding: 10px"
                                    >
                                        Комментарий
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <a
                        style="cursor: pointer"
                        v-if="show === false"
                        @click="show = true"
                        >Показать все</a
                    >
                    <a
                        style="cursor: pointer"
                        v-if="show === true"
                        @click="show = false"
                        >Скрыть</a
                    >
                </div>
                <div
                    class="base-header"
                    style="margin-top: 18px;margin-bottom: 18px; display: none"
                >
                    <h1>Акт сверки показания эл энергии</h1>
                </div>
                <div
                    style="background: #fff; display: none"
                    class="sidebar__request_body border_bottom"
                >
                    <div
                        class="sidebar__request_body__item working_process active"
                    >
                        <div class="working_process__head">
                            <div class="working_process__item">
                                <span>Замеры электроэнергии</span>
                            </div>
                        </div>
                        <div class="working_process__sect">
                            <div class="working_process__item">
                                <div>
                                    <div style="display: flex">
                                        <span>
                                            10.05.2021, 21:00
                                        </span>
                                        <!-- <p>Контрольный разряд акб</p> -->
                                    </div>
                                    <p>
                                        БС: Выбрать
                                    </p>
                                    <p>
                                        Номер счетчика: Ввести
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="working_process__head">
                            <div class="working_process__item">
                                <span>Замеры электроэнергии</span>
                            </div>
                        </div>
                        <div class="working_process__sect">
                            <div class="working_process__item">
                                <div>
                                    <div style="display: flex">
                                        <span>
                                            10.05.2021, 21:00
                                        </span>
                                        <!-- <p>Контрольный разряд акб</p> -->
                                    </div>
                                    <p>
                                        Фаза 1: значение
                                    </p>
                                    <p>
                                        Фаза 2: значение
                                    </p>
                                    <p>
                                        Фаза 3: значение
                                    </p>
                                    <div>
                                        <img
                                            style="max-width: 150px"
                                            src="../../../images/logo.png"
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <a
                        style="cursor: pointer"
                        v-if="show === false"
                        @click="show = true"
                        >Показать все</a
                    >
                    <a
                        style="cursor: pointer"
                        v-if="show === true"
                        @click="show = false"
                        >Скрыть</a
                    >
                </div>
                <div
                    class="base-header"
                    style="margin-top: 18px;margin-bottom: 18px; display: none"
                >
                    <h1>Инвентаризация</h1>
                </div>
                <div
                    style="background: #fff; display: none"
                    class="sidebar__request_body border_bottom"
                >
                    <div
                        class="sidebar__request_body__item working_process active"
                    >
                        <div class="working_process__head">
                            <div class="working_process__item">
                                <span>Инвентаризация</span>
                            </div>
                        </div>
                        <div class="working_process__sect">
                            <div class="working_process__item">
                                <div>
                                    <div style="display: flex">
                                        <span>
                                            10.05.2021, 21:00
                                        </span>
                                        <!-- <p>Контрольный разряд акб</p> -->
                                    </div>
                                    <p>
                                        Название БС: Название БС
                                    </p>
                                    <p>
                                        БС ID: БС ИД
                                    </p>
                                    <p>
                                        Тип станции: Тип
                                    </p>
                                    <p>
                                        Серийный номер: Серийный номер
                                    </p>
                                    <p>ПУФ: ПУФ</p>
                                </div>
                            </div>
                        </div>
                        <div class="working_process__head">
                            <div class="working_process__item">
                                <span>Оборудование</span>
                            </div>
                        </div>
                        <div class="working_process__sect">
                            <div class="working_process__item">
                                <div>
                                    <div style="display: flex"></div>
                                    <p>
                                        STDM: Серийный номер
                                    </p>
                                    <p
                                        style="background: #007b0029; padding: 10px"
                                    >
                                        Примечание
                                    </p>
                                    <p>
                                        SPAM: Серийный номер
                                    </p>
                                    <p
                                        style="background: #007b0029; padding: 10px"
                                    >
                                        Примечание
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <a
                        style="cursor: pointer"
                        v-if="show === false"
                        @click="show = true"
                        >Показать все</a
                    >
                    <a
                        style="cursor: pointer"
                        v-if="show === true"
                        @click="show = false"
                        >Скрыть</a
                    >
                </div>
                <div
                    class="base-header"
                    style="margin-top: 18px;margin-bottom: 18px; display: none"
                >
                    <h1>Акт дефектовки оборудования</h1>
                </div>
                <div
                    style="background: #fff; display: none"
                    class="sidebar__request_body border_bottom"
                >
                    <div
                        class="sidebar__request_body__item working_process active"
                    >
                        <div class="working_process__head">
                            <div class="working_process__item">
                                <span>Дефективное оборудование</span>
                            </div>
                        </div>
                        <div class="working_process__sect">
                            <div class="working_process__item">
                                <div>
                                    <div style="display: flex">
                                        <span>
                                            10.05.2021, 21:00
                                        </span>
                                        <p>STDM</p>
                                    </div>
                                    <p>
                                        BF45574653
                                    </p>
                                    <p>
                                        ПУФ/Инвентарный номер
                                    </p>
                                    <p>
                                        Количество
                                    </p>
                                    <p
                                        style="background: #007b0029; padding: 10px"
                                    >
                                        Примечание
                                    </p>
                                </div>
                            </div>
                            <div class="working_process__item">
                                <div>
                                    <div style="display: flex">
                                        <span>
                                            10.05.2021, 21:00
                                        </span>
                                        <p>STDM</p>
                                    </div>
                                    <p>
                                        BF45574653
                                    </p>
                                    <p>
                                        ПУФ/Инвентарный номер
                                    </p>
                                    <p>
                                        Количество
                                    </p>
                                    <p
                                        style="background: #007b0029; padding: 10px"
                                    >
                                        Примечание
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <a
                        style="cursor: pointer"
                        v-if="show === false"
                        @click="show = true"
                        >Показать все</a
                    >
                    <a
                        style="cursor: pointer"
                        v-if="show === true"
                        @click="show = false"
                        >Скрыть</a
                    >
                </div>
                <!-- <div
                    id="request_information_step"
                    v-if="application.progress.length"
                >
                    <div class="block24 whiteBg">
                        <div class="sidebar__request_body">
                            <div
                                class="sidebar__request_body__item working_process"
                            >
                                <div
                                    class="working_process__item"
                                    v-for="(
                                        progress, index
                                    ) in application.progress"
                                    :key="index"
                                >
                                    <p class="working_process__author">
                                        {{ progress.pivot.user.firstname }}
                                        {{ progress.pivot.user.lastname }}
                                    </p>
                                    <div class="working_process__time">
                                        <p>
                                            {{
                                                new Date(
                                                    progress.pivot.created_at
                                                ).toLocaleTimeString(
                                                    $page.props.locale,
                                                    {
                                                        year: '2-digit',
                                                        month: '2-digit',
                                                        day: '2-digit',
                                                        hour: '2-digit',
                                                        minute: '2-digit',
                                                    }
                                                )
                                            }}
                                        </p>
                                    </div>
                                    <p class="working_process__arrow">
                                        <span></span>
                                    </p>
                                    <div class="working_process__info">
                                        <p>{{ progress.title }}</p>
                                        <p
                                            class="request__comment"
                                            v-if="progress.pivot.comment"
                                        >
                                            {{ progress.pivot.comment }}
                                        </p>
                                        <div v-if="progress.id === 4">
                                            <p
                                                class="border_bottom"
                                                v-for="(
                                                    inventory, index
                                                ) in application.inventories"
                                                :key="index"
                                            >
                                                {{ inventory.title }}
                                            </p>
                                            <div v-if="progress.id === 5">
                                                <p
                                                    class="border_bottom"
                                                    v-for="(
                                                        inventory, index
                                                    ) in application.inventories"
                                                    :key="index"
                                                >
                                                    {{ inventory.title }}
                                                </p>
                                            </div>
                                        </div>
                                        <div
                                            class="working_process__gallery"
                                            v-if="
                                                progress.id === 6 &&
                                                application.images.length
                                            "
                                        >
                                            <div
                                                class="working_process__gallery_item"
                                                v-for="(
                                                    image, index
                                                ) in application.images"
                                                :key="index"
                                            >
                                                <img
                                                    :src="image.url"
                                                    alt=""
                                                    @mouseover="
                                                        hoverPhotoId = index
                                                    "
                                                    :class="{
                                                        blur:
                                                            hoverPhotoId ===
                                                            index,
                                                    }"
                                                />
                                                <transition name="fade">
                                                    <div
                                                        class="cover pointer"
                                                        @click="
                                                            switchSliderModal(
                                                                true,
                                                                index
                                                            )
                                                        "
                                                        @mouseleave="
                                                            hoverPhotoId = null
                                                        "
                                                        v-if="
                                                            hoverPhotoId ===
                                                            index
                                                        "
                                                    >
                                                        <span
                                                            class="material-icons"
                                                            >zoom_in</span
                                                        >
                                                    </div>
                                                </transition>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> -->
                <vSlider ref="sliderModal" />
                <modalList ref="modalList" />
                <addComment :application="application" ref="addComment" />
                <applicationStatusChange
                    :application="application"
                    ref="status_modal_change"
                    keyName="id"
                    :comment="{
                        isShow: true,
                        placeholder: ''
                    }"
                    optionName="title"
                    :statuses="$page.props.statuses"
                />
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout'
import Priority from '@/components/priority'
import Status from '@/components/status'
import vSelect from '@/components/v-select'
import calendar from '@/components/calendar'
import vClickOutside from 'v-click-outside'
import vSlider from '@/components/v-slider'
import array_move from '@/libs/functions/ArrayMove'
import applicationStatusChange from '@/components/applicationStatusChange'
import modalList from '@/components/modalList'
import addComment from '@/components/addComment'
import axios from 'axios'

export default {
    components: {
        AppLayout,
        Priority,
        vSlider,
        Status,
        vSelect,
        calendar,
        modalList,
        applicationStatusChange,
        addComment
    },
    directives: {
        clickOutside: vClickOutside.directive
    },
    props: {
        application: Object
    },
    data() {
        return {
            show: false,
            alert: null,
            result: [],
            isActiveBlockForChangingStatus: false,
            activeMode: 'Info',
            hoverPhotoId: null,
            showMoreComments: false,
            showMoreCommentsInTheTable: false,
            editMode: false,
            users: [],
            engineers: [],
            defaultUser: null,
            defaultEngineer: null,
            form: this.$inertia.form(
                {
                    deadline_at: '',
                    works: '',
                    user: '',
                    engineer: ''
                },
                {
                    bag: 'update',
                    resetOnSuccess: false,
                    only: ['application']
                }
            )
        }
    },
    mounted() {
        console.log(this.$page.props.application)
        if (new Date() > new Date(this.application.deadline_at)) {
            this.alert = true
        } else {
            this.alert = false
        }
        axios
            .get(route('api.user.index'), {
                params: {
                    lastname: this.$page.props.application?.engineer?.lastname
                }
            })
            .then(res => {
                this.defaultEngineer = res.data.data[0]
            })
        axios
            .get(route('api.user.index'), {
                params: {
                    lastname: this.$page.props.application?.user?.lastname
                }
            })
            .then(res => (this.defaultUser = res.data.data[0]))
        axios
            .get(route('api.user.index'), {
                params: {
                    roles: [4],
                    area: this.$page.props.application.area_id
                }
            })
            .then(res => {
                this.engineers = res.data.data
            })
        axios
            .get(route('api.user.index'), {
                params: {
                    roles: [3],
                    area: this.$page.props.application.area_id
                }
            })
            .then(res => (this.users = res.data.data))
        Echo.private(`application.${this.application.id}`).listen(
            'ApplicationUpdated',
            e => {
                console.log(e)
                this.$page.props.application = e.application
            }
        )
    },
    watch: {
        editMode(n, o) {
            if (n) {
                if (this.defaultEngineer) {
                    this.$refs.engineerSelect.selectItemFromSearch({
                        value: this.defaultEngineer.lastname,
                        id: this.defaultEngineer.id,
                        initial: this.defaultEngineer.firstname
                    })
                }
                if (this.defaultUser) {
                    this.$refs.userSelect.selectItemFromSearch({
                        value: this.defaultUser.lastname,
                        id: this.defaultUser.id,
                        initial: this.defaultUser.firstname
                    })
                }
            }
        }
    },
    methods: {
        test() {
            console.log('test', this.$page.props)
        },
        func() {
            console.log(this.$page.props)
        },
        openModalToAddComment() {
            this.$refs.addComment.open()
        },
        switchEditMode(status = null) {
            if (status === null) {
                this.editMode = !this.editMode
                return
            }
            this.editMode = status
        },
        openModalList(application, type = 'bts') {
            this.$refs.modalList.switchModalStatus(true, application, type)
        },
        openModalStatusChange() {
            this.$refs.status_modal_change.open()
        },
        submitUpdate() {
            this.form.deadline_at = this.form.deadline_at.toLocaleString()
            this.form.put(route('application.update', this.application), {
                preserveState: true,
                preserveScroll: true
            })
            this.editMode = false
        },
        switchSliderModal(status, index, images) {
            if (status) {
                this.$refs.sliderModal.open(array_move(images, index, 0))
                return
            }
            this.$refs.sliderModal.close()
        }
    }
}
</script>

<style>
.editModeClass {
    grid-template-columns: 9% 9% 9% 9% 9% 15% 15% 15% 10% !important;
}

.editModeApp_customStyle .select {
    margin-left: 16px;
}

.editModeClass .select span {
    max-width: 150px;
    min-width: 150px;
}
</style>
