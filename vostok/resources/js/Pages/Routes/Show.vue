<template>
    <app-layout class="createz prom">
        <div class="main-wrap routes great slice mxw1050">
            <div
                style="margin-top: 0px; display: flex; align-item: center"
                class="base-header"
            >
                <h1>Маршрут №{{ $page.props.route.id }}</h1>
                <p
                    style="margin-left: 15px; font-weight: bold"
                    v-if="$page.props.route.activity"
                >
                    {{ $page.props.route.activity.title }}
                </p>
            </div>
            <div class="content">
                <div class="content__inner">
                    <vMap
                        ref="map"
                        :placeOfReturn="
                            $page.props.route.area.location.coordinates
                        "
                        :addresses="$page.props.route.addresses"
                        :applications="$page.props.route.applications"
                        :isShowNavigator="true"
                        :isShowNavigatorStations="true"
                        :key="$page.props.route.applications.length"
                        :routeTraveled="routeTraveled"
                        @deleteApplication="switchAlertModal"
                    />
                </div>
            </div>
            <div class="route-inform">
                <div class="base-header mt8">
                    <h1 @click="func()" class="mt16">Информация по маршруту</h1>
                </div>
                <a
                    v-if="$page.props.route.activity.id != 6"
                    @click="
                        () => {
                            $refs.modalAlert.open()
                            closedRoute = $page.props.route
                        }
                    "
                    style="display: block; color: #ff5930; cursor: pointer; width: fit-content"
                    >Закрыть маршрут</a
                >
                <div style="display:flex">
                    <button
                        v-if="$page.props.route.unid === null"
                        type="submit"
                        class="btn btn-blue"
                        @click="sendForApproval"
                    >
                        Отправить на согласование
                    </button>
                    <button
                        style="margin-left:16px"
                        v-if="isActiveEditRouteInform"
                        type="submit"
                        class="btn btn-blue"
                        @click="updateRoute"
                    >
                        Сохранить
                    </button>
                    <button
                        v-if="$page.props.route.order_number"
                        type="submit"
                        class="btn btn-blue"
                        @click="sendForApproval"
                    >
                        Отправить на изменение
                    </button>
                </div>
                <div
                    v-if="
                        new Date($page.props.route.deadline_at * 1000) <
                            new Date()
                    "
                    class="alert-expired"
                >
                    <div class="alert-expired__block">
                        <img
                            :src="
                                require('@/../images/icons/warning.svg').default
                            "
                            alt="logo"
                        />
                        <span>Маршрут просрочен</span>
                        <span>
                            {{
                                new Date(
                                    $page.props.route.started_at
                                ).toLocaleString($page.props.locale)
                            }}
                            -
                            {{
                                new Date(
                                    $page.props.route.deadline_at
                                ).toLocaleString($page.props.locale)
                            }}
                        </span>
                    </div>
                    <div class="alert-expired__block">
                        <button>Обновить маршрут</button>
                    </div>
                </div>
                <div class="route-inform__block mt32">
                    <div class="route-inform__block__item">
                        <div>
                            <span
                                class="textIcon pointer"
                                v-if="!isActiveEditRouteInform"
                                @click="isActiveEditRouteInform = true"
                                >Редактировать
                                <span class="material-icons pointer"
                                    >edit</span
                                ></span
                            >
                            <span
                                class="textIcon pointer"
                                v-else
                                @click="cancelEditRoute"
                                >Отменить
                                <span class="material-icons pointer"
                                    >close</span
                                ></span
                            >
                        </div>
                    </div>
                    <div class="route-inform__block__item">
                        <span>Сроки маршрута</span>
                        <p class="textIcon" v-if="!isActiveEditRouteInform">
                            {{
                                new Date(
                                    $page.props.route.started_at
                                ).toLocaleString($page.props.locale)
                            }}
                            -
                            {{
                                new Date(
                                    $page.props.route.deadline_at
                                ).toLocaleString($page.props.locale)
                            }}
                        </p>
                        <div v-else class="route-inform__block__calendarEdit">
                            <calendar
                                calendarType="range"
                                :isShowTime="true"
                                @selectedDate="
                                    date => {
                                        cloneRoute.deadline_at = date.end.toLocaleString()
                                        cloneRoute.started_at = date.start.toLocaleString()
                                    }
                                "
                                @reset="() => {}"
                                placeholder="Период маршрута"
                            />
                        </div>
                    </div>
                    <div
                        class="route-inform__block__item"
                        v-if="$page.props.route.order_number"
                    >
                        <span>Номер документа</span>
                        <p>{{ $page.props.route.order_number }}</p>
                    </div>
                    <div class="route-inform__block__item">
                        <!-- Скрыть до интеграции с лотусом -->
                        <!-- <span>Номер документа:</span>
                        <p>0346/У-ВТК</p> -->
                    </div>
                    <div class="route-inform__block__item">
                        <span>Ответственный</span>
                        <p v-if="!isActiveEditRouteInform">
                            {{ $page.props.route.engineer.lastname }}
                            {{ $page.props.route.engineer.firstname }}
                        </p>
                        <v-select
                            v-else-if="
                                engineers.length && isActiveEditRouteInform
                            "
                            typeSelect="whiteSelect"
                            :data="engineers"
                            optionName="lastname"
                            keyName="id"
                            :placeholderSearch="engineerName"
                            mode="Search"
                            :globalSearch="{
                                use: true,
                                api: 'api.user.index',
                                dynamicParam: 'lastname',
                                paramKey: {
                                    lastname: null
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
                                    cloneRoute.engineer_id = value
                                }
                            "
                            @selected="
                                value => {
                                    cloneRoute.engineer_id = value
                                }
                            "
                        />
                    </div>
                    <div class="route-inform__block__item" v-if="cloneRoute">
                        <span>Бригада</span>
                        <p>
                            <span
                                class="textIcon mt8"
                                v-for="(user, index) in cloneRoute.users"
                                :key="user.id"
                                >{{ `${user.lastname} ${user.firstname}` }}
                                <span
                                    v-if="isActiveEditRouteInform"
                                    @click="deleteBrigade(user)"
                                    class="material-icons text-blue-hover pointer"
                                    >close</span
                                >
                                <br />
                            </span>
                            <v-select
                                v-if="
                                    brigades.length && isActiveEditRouteInform
                                "
                                typeSelect="whiteSelect"
                                class="mt8"
                                :data="brigades"
                                optionName="lastname"
                                keyName="id"
                                mode="Search"
                                :returnObject="true"
                                :globalSearch="{
                                    use: true,
                                    api: 'api.user.index',
                                    dynamicParam: 'lastname',
                                    paramKey: {
                                        lastname: null,
                                        roles: [4]
                                    }
                                }"
                                :isShowBtnErase="true"
                                :resetOption="{
                                    isShow: true,
                                    text: 'Все',
                                    isSendRequestAfterReset: true
                                }"
                                placeholderSearch="Поиск"
                                @selected="
                                    brigade => {
                                        addBrigade(brigade)
                                    }
                                "
                            />
                        </p>
                    </div>
                    <div
                        class="route-inform__block__item mt8"
                        v-if="$page.props.route.vehicle_type_id == 1"
                    >
                        <span>Транспортное средство</span>
                        <p>
                            {{
                                $page.props.route.vehicle_type
                                    ? $page.props.route.vehicle_type.title
                                    : ''
                            }}
                            {{
                                $page.props.route.vehicle
                                    ? $page.props.route.vehicle.title
                                    : ''
                            }}
                        </p>
                    </div>
                    <div
                        class="route-inform__block__item mt8"
                        v-else-if="$page.props.route.vehicle_type_id != 1"
                    >
                        <span>Транспортное средство</span>
                        <p v-if="$page.props.route.vehicle_type">
                            {{ $page.props.route.vehicle_type.title }}
                        </p>
                    </div>
                    <div
                        class="route-inform__block__item"
                        v-for="(address, index) in $page.props.route.addresses"
                        :key="index"
                    >
                        <span>Место ночлега {{ index + 1 }}</span>
                        <p>{{ address.address }}</p>
                    </div>
                    <div class="route-inform__block__item">
                        <span>Место возврата</span>
                        <p>{{ $page.props.route.area.address }}</p>
                    </div>
                    <div class="route-inform__block__item">
                        <span>Командировочные</span>
                        <p>{{ $page.props.route.travel_costs.toFixed(2) }}</p>
                    </div>
                    <div class="route-inform__block__item">
                        <span>Расходы ГСМ,л</span>
                        <p>{{ $page.props.route.fuels.toFixed(2) }}</p>
                    </div>
                    <div class="route-inform__block__item">
                        <span>Расходы ГСМ, тенге</span>
                        <p>{{ $page.props.route.fuel_costs.toFixed(2) }}</p>
                    </div>
                    <div class="route-inform__block__item">
                        <span>Расходы на проживание, тенге</span>
                        <p>
                            {{ $page.props.route.overnight_costs.toFixed(2) }}
                        </p>
                    </div>
                    <div class="route-inform__block__item">
                        <span>Расходные материалы, тенге</span>
                        <p>{{ $page.props.route.material_costs.toFixed(2) }}</p>
                    </div>
                    <div class="route-inform__block__item">
                        <span>Общие расходы по маршруту, тенге</span>
                        <p>{{ $page.props.route.expenses.toFixed(2) }}</p>
                    </div>
                </div>
            </div>
            <div class="route-inform">
                <div class="base-header mt8">
                    <h1 class="mt16">Комментарии</h1>
                </div>
                <div class="route-inform__block">
                    <div class="route-inform__block__comment">
                        <div
                            class="request__comment request_comment_overflow"
                            v-for="comment in $page.props.route.closures"
                            :key="comment.id"
                        >
                            <p>
                                <span class="blue">Дата:</span>
                                {{
                                    new Date(
                                        comment.created_at
                                    ).toLocaleTimeString($page.props.locale, {
                                        year: '2-digit',
                                        month: '2-digit',
                                        day: '2-digit',
                                        hour: '2-digit',
                                        minute: '2-digit'
                                    })
                                }}
                            </p>
                            <p>
                                <!-- <span class="blue">Автор:</span> -->
                                <!-- {{ comment.user.lastname }}
                                {{ comment.user.firstname }} -->
                            </p>
                            <p>
                                <span class="blue">Комментарий: </span>
                                {{ comment.comment }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="route-closed" v-if="$page.props.route.closed_at">
                <ul>
                    <li>
                        <span>Дата закрытия:</span>
                        {{
                            new Date(
                                $page.props.route.closed_at
                            ).toLocaleString($page.props.locale)
                        }}
                    </li>
                    <li>
                        <span>Инициатор: </span>
                    </li>
                    <li>
                        <span>Комментарий:</span>
                    </li>
                </ul>
            </div>
            <div class="route-selected">
                <div class="routes__table">
                    <div class="base-header">
                        <h1 class="mt16">
                            Заявки на маршруте №{{ $page.props.route.id }}
                        </h1>
                        <p
                            class="orange pointer textIcon"
                            @click="openCreateModal"
                        >
                            Добавить заявку на маршрут
                            <img
                                :src="
                                    require('@/../images/icons/plus.svg')
                                        .default
                                "
                                alt=""
                            />
                        </p>
                    </div>
                    <div class="distance_information">
                        <div class="distance_information__item">
                            <p>
                                Километраж по маршруту:
                                <span
                                    >{{
                                        Number(
                                            $page.props.route.distance / 1000
                                        ).toFixed(2)
                                    }}
                                    km</span
                                >
                            </p>
                        </div>
                        <div class="distance_information__item">
                            <p>
                                Километраж по заявкам:
                                <span
                                    >{{
                                        Number(
                                            $page.props.route.distance / 1000
                                        ).toFixed(2)
                                    }}
                                    km</span
                                >
                            </p>
                        </div>
                    </div>
                    <div
                        class="distance_information"
                        v-if="routeTraveled.length"
                    >
                        <div class="distance_information__item">
                            <p>
                                Фактический маршрут
                                <span>
                                    {{
                                        $page.props.route.actual_distance /
                                            1000 || '0'
                                    }}
                                    км
                                </span>
                            </p>
                        </div>
                    </div>
                    <div class="table__wrapper">
                        <div class="table__wrapper__head">
                            <ul>
                                <li>№</li>
                                <li>ID</li>
                                <li>Тип работ</li>
                                <li>Приоритет</li>
                                <li style="margin-left: -10px;">Проект</li>
                                <li style="margin-left: -10px;">№ ПБ</li>
                                <li style="margin-left: -10px;">БС</li>
                                <li style="margin-left: -10px;">
                                    Описание аварии
                                </li>
                                <li style="margin-left: -10px;">
                                    Дата создания
                                </li>
                                <li style="margin-left: -15px;">Срок заявки</li>
                                <li style="margin-left: -10px;">№ Маршрута</li>
                                <li>№ ОРД</li>
                                <li style="margin-left: -10px;">
                                    Ответственный
                                </li>
                                <li style="margin-left: -15px;">Статус</li>
                                <li style="margin-left: -15px;">Вид работ</li>
                            </ul>
                        </div>
                        <draggable
                            class="table__wrapper__body"
                            :list="$page.props.route.applications"
                            ghost-class="ghost"
                            tag="div"
                            ref="draggable"
                            @end="onEnd(map, 'main')"
                            handle=".handle"
                        >
                            <ul
                                class="hoverBlue"
                                v-for="(application, index) in $page.props.route
                                    .applications"
                                :key="index"
                            >
                                <li scope="row">
                                    <span>№:</span>
                                    <span
                                        class="round roundGray"
                                        style="top: 0; left: -5px"
                                    >
                                        {{ index + 1 }}
                                    </span>
                                </li>
                                <li
                                    @click="
                                        toggleVisibleApplicationCard(
                                            application,
                                            true
                                        )
                                    "
                                    class="pointer"
                                >
                                    <span>ID:</span>{{ application.id }}
                                </li>
                                <li
                                    @click="
                                        toggleVisibleApplicationCard(
                                            application,
                                            true
                                        )
                                    "
                                    class="pointer"
                                >
                                    <span>Тип работ:</span
                                    >{{
                                        application.type
                                            ? application.type.title
                                            : ''
                                    }}
                                </li>
                                <li
                                    @click="
                                        toggleVisibleApplicationCard(
                                            application,
                                            true
                                        )
                                    "
                                    class="pointer"
                                >
                                    <span>Приоритет:</span>
                                    <priority
                                        :status="application.priority"
                                        style="font-size: 10px"
                                    />
                                </li>
                                <li
                                    @click="
                                        toggleVisibleApplicationCard(
                                            application,
                                            true
                                        )
                                    "
                                    class="pointer"
                                >
                                    <span>Проект</span
                                    >{{
                                        application.project
                                            ? application.project.title
                                            : ''
                                    }}
                                </li>
                                <li
                                    @click="
                                        toggleVisibleApplicationCard(
                                            application,
                                            true
                                        )
                                    "
                                    class="pointer"
                                >
                                    <span>№ ПБ:</span>
                                    {{ application.ticket }}
                                </li>
                                <li
                                    @click="
                                        toggleVisibleApplicationCard(
                                            application,
                                            true
                                        )
                                    "
                                    class="pointer"
                                >
                                    <span class="pro">БС</span>
                                    <p v-if="application.stations.length">
                                        {{ application.stations[0].bts_id }}
                                    </p>
                                    <p
                                        class="mt8 pointer more_station_btn"
                                        v-if="application.stations.length > 1"
                                        data-type-list="bts"
                                        @click="
                                            openModalList(application, 'bts')
                                        "
                                    >
                                        Еще
                                    </p>
                                </li>
                                <li
                                    @click="
                                        toggleVisibleApplicationCard(
                                            application,
                                            true
                                        )
                                    "
                                    class="pointer"
                                >
                                    <span>Описание аварии:</span>
                                    <p>
                                        {{
                                            typeof application.description ===
                                            'string'
                                                ? application.description.slice(
                                                      0,
                                                      25
                                                  ) + '...'
                                                : 'Ull'
                                        }}
                                    </p>
                                </li>
                                <li
                                    @click="
                                        toggleVisibleApplicationCard(
                                            application,
                                            true
                                        )
                                    "
                                    class="pointer"
                                >
                                    <span>Дата создания</span>
                                    {{
                                        new Date(
                                            application.created_at
                                        ).toLocaleString($page.props.locale)
                                    }}
                                </li>
                                <li
                                    @click="
                                        toggleVisibleApplicationCard(
                                            application,
                                            true
                                        )
                                    "
                                    class="pointer"
                                >
                                    <span>Срок заявки</span>
                                    {{
                                        new Date(
                                            application.deadline_at
                                        ).toLocaleString($page.props.locale)
                                    }}
                                </li>
                                <li>
                                    <span>№ Маршрут</span>
                                    <p
                                        v-if="application.routes.length"
                                        :href="
                                            route(
                                                'route.show',
                                                application.routes[0].id
                                            )
                                        "
                                        class="pointer orange"
                                    >
                                        {{ application.routes[0].id }}
                                    </p>
                                </li>
                                <li
                                    @click="
                                        toggleVisibleApplicationCard(
                                            application,
                                            true
                                        )
                                    "
                                    class="pointer"
                                >
                                    <span>№ ОРД:</span>
                                    {{ application.document }}
                                </li>
                                <li
                                    @click="
                                        toggleVisibleApplicationCard(
                                            application,
                                            true
                                        )
                                    "
                                    class="pointer"
                                >
                                    <span>Ответственный:</span>
                                    {{ application.user.lastname }}
                                    {{ application.user.firstname.charAt(0) }}.
                                </li>
                                <li
                                    @click="
                                        toggleVisibleApplicationCard(
                                            application,
                                            true
                                        )
                                    "
                                    class="pointer"
                                >
                                    <span>Статус</span>
                                    <status :status="application.status" />
                                </li>
                                <li>
                                    <span>Вид работ</span>
                                    <p v-if="application.works.length">
                                        {{
                                            application.works[0]
                                                ? application.works[0].title
                                                : ''
                                        }}
                                    </p>
                                    <p
                                        class="mt8 pointer"
                                        @click="
                                            openModalList(application, 'works')
                                        "
                                        v-if="application.works.length > 1"
                                    >
                                        Еще
                                    </p>
                                </li>
                                <li>
                                    <inertia-link
                                        :href="
                                            route(
                                                'application.show',
                                                application.id
                                            )
                                        "
                                        style="font-size: 14px"
                                        class="pointer textRight orange"
                                    >
                                        Открыть
                                    </inertia-link>
                                </li>
                                <li>
                                    <span
                                        class="material-icons gray pointer"
                                        @click="
                                            switchAlertModal(application.id)
                                        "
                                    >
                                        delete
                                    </span>
                                </li>
                                <li>
                                    <span
                                        class="material-icons gray drag_btn handle"
                                    >
                                        drag_indicator
                                    </span>
                                </li>
                            </ul>
                        </draggable>
                    </div>
                </div>
            </div>
            <div class="route-selected">
                <div class="routes__table">
                    <div class="base-header">
                        <h1 class="mt16">
                            Заявки на маршруте №{{ $page.props.route.id }}
                            отправленные на доработку
                        </h1>
                    </div>

                    <div
                        class="distance_information"
                        v-if="routeTraveled.length"
                    >
                        <div class="distance_information__item">
                            <p>
                                Фактический маршрут
                                <span>
                                    {{
                                        $page.props.route.actual_distance /
                                            1000 || '0'
                                    }}
                                    км
                                </span>
                            </p>
                        </div>
                    </div>
                    <div class="table__wrapper">
                        <div class="table__wrapper__head">
                            <ul>
                                <li>№</li>
                                <li>ID</li>
                                <li>Тип работ</li>
                                <li>Приоритет</li>
                                <li style="margin-left: -10px;">Проект</li>
                                <li style="margin-left: -10px;">№ ПБ</li>
                                <li style="margin-left: -10px;">БС</li>
                                <li style="margin-left: -10px;">
                                    Описание аварии
                                </li>
                                <li style="margin-left: -10px;">
                                    Дата создания
                                </li>
                                <li style="margin-left: -15px;">Срок заявки</li>
                                <li style="margin-left: -10px;">№ Маршрута</li>
                                <li>№ ОРД</li>
                                <li style="margin-left: -10px;">
                                    Ответственный
                                </li>
                                <li style="margin-left: -15px;">Статус</li>
                                <li style="margin-left: -15px;">Вид работ</li>
                            </ul>
                        </div>
                        <draggable
                            class="table__wrapper__body"
                            :list="$page.props.route.applications"
                            ghost-class="ghost"
                            tag="div"
                            ref="draggable"
                            @end="onEnd(map, 'main')"
                            handle=".handle"
                        >
                            <ul
                                class="hoverBlue"
                                v-for="(application, index) in $page.props.route
                                    .ex_applications"
                                :key="index"
                            >
                                <li scope="row">
                                    <span>№:</span>
                                    <span
                                        class="round roundGray"
                                        style="top: 0; left: -5px"
                                    >
                                        {{ index + 1 }}
                                    </span>
                                </li>
                                <li
                                    @click="
                                        toggleVisibleApplicationCard(
                                            application,
                                            true
                                        )
                                    "
                                    class="pointer"
                                >
                                    <span>ID:</span>{{ application.id }}
                                </li>
                                <li
                                    @click="
                                        toggleVisibleApplicationCard(
                                            application,
                                            true
                                        )
                                    "
                                    class="pointer"
                                >
                                    <span>Тип работ:</span
                                    >{{
                                        application.type
                                            ? application.type.title
                                            : ''
                                    }}
                                </li>
                                <li
                                    @click="
                                        toggleVisibleApplicationCard(
                                            application,
                                            true
                                        )
                                    "
                                    class="pointer"
                                >
                                    <span>Приоритет:</span>
                                    <priority :status="application.priority" />
                                </li>
                                <li
                                    @click="
                                        toggleVisibleApplicationCard(
                                            application,
                                            true
                                        )
                                    "
                                    class="pointer"
                                >
                                    <span>Проект</span
                                    >{{
                                        application.project
                                            ? application.project.title
                                            : ''
                                    }}
                                </li>
                                <li
                                    @click="
                                        toggleVisibleApplicationCard(
                                            application,
                                            true
                                        )
                                    "
                                    class="pointer"
                                >
                                    <span>№ ПБ:</span>
                                    {{ application.ticket }}
                                </li>
                                <li
                                    @click="
                                        toggleVisibleApplicationCard(
                                            application,
                                            true
                                        )
                                    "
                                    class="pointer"
                                >
                                    <span class="pro">БС</span>
                                    <p v-if="application.stations.length">
                                        {{ application.stations[0].bts_id }}
                                    </p>
                                    <p
                                        class="mt8 pointer more_station_btn"
                                        v-if="application.stations.length > 1"
                                        data-type-list="bts"
                                        @click="
                                            openModalList(application, 'bts')
                                        "
                                    >
                                        Еще
                                    </p>
                                </li>
                                <li
                                    @click="
                                        toggleVisibleApplicationCard(
                                            application,
                                            true
                                        )
                                    "
                                    class="pointer"
                                >
                                    <span>Описание аварии:</span>
                                    <p>
                                        {{
                                            typeof application.description ===
                                            'string'
                                                ? application.description.slice(
                                                      0,
                                                      25
                                                  ) + '...'
                                                : 'Ull'
                                        }}
                                    </p>
                                </li>
                                <li
                                    @click="
                                        toggleVisibleApplicationCard(
                                            application,
                                            true
                                        )
                                    "
                                    class="pointer"
                                >
                                    <span>Дата создания</span>
                                    {{
                                        new Date(
                                            application.created_at
                                        ).toLocaleString($page.props.locale)
                                    }}
                                </li>
                                <li
                                    @click="
                                        toggleVisibleApplicationCard(
                                            application,
                                            true
                                        )
                                    "
                                    class="pointer"
                                >
                                    <span>Срок заявки</span>
                                    {{
                                        new Date(
                                            application.deadline_at
                                        ).toLocaleString($page.props.locale)
                                    }}
                                </li>
                                <li>
                                    <span>№ Маршрут</span>
                                    <inertia-link
                                        v-if="application.routes.length"
                                        :href="
                                            route(
                                                'route.show',
                                                application.routes[0].id
                                            )
                                        "
                                        class="pointer orange"
                                    >
                                        {{ application.routes[0].id }}
                                    </inertia-link>
                                </li>
                                <li
                                    @click="
                                        toggleVisibleApplicationCard(
                                            application,
                                            true
                                        )
                                    "
                                    class="pointer"
                                >
                                    <span>№ ОРД:</span>
                                    {{ application.document }}
                                </li>
                                <li
                                    @click="
                                        toggleVisibleApplicationCard(
                                            application,
                                            true
                                        )
                                    "
                                    class="pointer"
                                >
                                    <span>Ответственный:</span>
                                    {{ application.user.lastname }}
                                    {{ application.user.firstname.charAt(0) }}.
                                </li>
                                <li
                                    @click="
                                        toggleVisibleApplicationCard(
                                            application,
                                            true
                                        )
                                    "
                                    class="pointer"
                                >
                                    <span>Статус</span>
                                    <status :status="application.status" />
                                </li>
                                <li>
                                    <span>Вид работ</span>
                                    <p v-if="application.works.length">
                                        {{
                                            application.works[0]
                                                ? application.works[0].title
                                                : ''
                                        }}
                                    </p>
                                    <p
                                        class="mt8 pointer"
                                        @click="
                                            openModalList(application, 'works')
                                        "
                                        v-if="application.works.length > 1"
                                    >
                                        Еще
                                    </p>
                                </li>
                                <li>
                                    <inertia-link
                                        :href="
                                            route(
                                                'application.show',
                                                application.id
                                            )
                                        "
                                        style="font-size: 14px"
                                        class="pointer textRight orange"
                                    >
                                        Открыть
                                    </inertia-link>
                                </li>
                                <li>
                                    <span
                                        class="material-icons gray pointer"
                                        @click="
                                            switchAlertModal(application.id)
                                        "
                                    >
                                        delete
                                    </span>
                                </li>
                                <li>
                                    <span
                                        class="material-icons gray drag_btn handle"
                                    >
                                        drag_indicator
                                    </span>
                                </li>
                            </ul>
                        </draggable>
                    </div>
                </div>
            </div>
            <div class="change_routes" v-if="isActiveModalChangeRoutes">
                <div class="change_routes__content">
                    <div class="change_routes__close">
                        Изменить маршрут
                        <img
                            class="pointer"
                            @click="switchModalChangeRoutes"
                            :src="
                                require('@/../images/icons/closers.svg').default
                            "
                            alt=""
                        />
                    </div>
                    <div class="change_routes__item" id="itienary">
                        <h1 class="change_routes__title">
                            Порядок заявок в маршруте
                        </h1>
                        <input type="text" />

                        <p id="showInMap">Показать на карте</p>
                    </div>
                    <div class="change_routes__item">
                        <h1 class="change_routes__title">
                            Добавить заявку к маршруту
                        </h1>
                        <div class="space-between">
                            <input type="text" />
                            <button class="btn">Добавить</button>
                        </div>
                        <button class="btn btn-white">Применить</button>
                        <button class="btn btn-white">Отмена</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="routes">
            <modal
                name="createRouteModal"
                class="modal_regular modal_status createRouteModal"
                width="398"
                height="auto"
            >
                <div class="modal_regular__header column2">
                    <p>Добавить заявку на маршрут</p>
                    <div class="modal_regular__close">
                        <span
                            class="material-icons pointer"
                            @click="closeCreateModal"
                            >close</span
                        >
                    </div>
                </div>
                <div class="modal_status__body">
                    <div
                        id="addRoute"
                        class="pointer"
                        @click="isVisibleSearchBlock = true"
                        v-if="isVisibleSearchBlock === false"
                    >
                        <img
                            :src="require('@/../images/icons/plus.svg').default"
                            alt=""
                        />Добавить точку
                    </div>
                    <div v-else>
                        <input
                            type="text"
                            v-model="search"
                            @input="searchApplications"
                        />
                        <div class="search">
                            <div class="search__inner custom-scroll">
                                <div
                                    class="search__item pointer"
                                    v-for="item in routes"
                                    @click="search = item.number"
                                    :key="item.id"
                                >
                                    <div
                                        class="search__item_inner"
                                        @click="selectedApplication(item)"
                                    >
                                        <div class="search__item_header">
                                            <p>
                                                {{ item.id }}
                                            </p>
                                        </div>
                                        <div class="search__item_body">
                                            <p v-if="item.stations.length">
                                                {{ item.stations[0].bts_id }}
                                                <span
                                                    class="more_bts_btn"
                                                    v-if="
                                                        item.stations.length > 1
                                                    "
                                                >
                                                    <br />Еще
                                                </span>
                                            </p>
                                            <p
                                                v-if="
                                                    item.stations.length &&
                                                        item.stations[0].area
                                                "
                                            >
                                                {{
                                                    item.stations[0].area
                                                        ? item.stations[0].area
                                                              .title
                                                        : ''
                                                }}
                                            </p>
                                            <p
                                                style="text-align: right"
                                                v-if="item.type"
                                            >
                                                {{ item.type.title }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <p class="pointer" @click="closeCreateModal">Отмена</p>
                </div>
            </modal>
        </div>
        <transition name="fade">
            <vAlert
                text="Вы уверены что хотите закрыть маршрут"
                confirmText="Да"
                refuseText="Нет"
                @close="closeAlertModal"
                @confirm="closeRoute"
                ref="modalAlert"
            />
        </transition>
        <route-closed
            v-if="closedRoute"
            :router="closedRoute"
            ref="RouteClosed"
        />
        <modal
            width="300"
            height="auto"
            name="alert"
            class="modal_regular alert_modal"
        >
            <div class="modal_regular__header">
                <p>Удалить заявку из маршрута ?</p>
            </div>
            <div class="modal_regular__body">
                <button class="btn btn-orange" @click="deleteApplication">
                    Удалить
                </button>
                <p @click="switchAlertModal()" class="pointer">Отмена</p>
            </div>
        </modal>
        <modalList ref="modalList" />
    </app-layout>
</template>

<script>
import draggable from 'vuedraggable'
import AppLayout from '../../Layouts/AppLayout.vue'
import VSelect from '@/components/v-select'
import Priority from '@/components/priority'
import modalList from '@/components/modalList'
import vMap from '@/components/v-map'
import calendar from '@/components/calendar'
import _ from 'lodash'
import RouteClosed from '@/components/RouteClosed'
import vAlert from '@/components/v-alert'
import axios from 'axios'
import status from '@/components/status'

export default {
    name: 'Show',
    components: {
        AppLayout,
        draggable,
        VSelect,
        Priority,
        modalList,
        vMap,
        calendar,
        vAlert,
        RouteClosed,
        status
    },
    data() {
        return {
            engineerName:
                this.$page.props.route.engineer.lastname +
                ' ' +
                this.$page.props.route.engineer.firstname,
            isShowAlert: false,
            closedRoute: null,
            alert: true,
            engineers: [],
            brigades: [],
            isActiveEditRouteInform: false,
            dragging: false,
            isVisibleSearchBlock: false,
            isActiveModalChangeRoutes: false,
            search: '',
            routes: [],
            geoDataApplications: [],
            applications: [],
            colorRoute: '#999999',
            map: null,
            stations_map: null,
            markers: [],
            routesOnMap: [],
            routesOnStationMap: [],
            isShowStation_map: false,
            markersOnMap: [],
            markersOnStationMap: [],
            isShowRouteModal: true,
            deletedApp: null,
            cloneRoute: null,
            routeTraveled: []
        }
    },
    mounted() {
        console.log(this.$page.props.route)
        axios
            .get(route('api.route.locations', this.$page.props.route.id))
            .then(res => (this.routeTraveled = res.data.data))
        axios
            .get(
                route('api.user.index', {
                    roles: [4],
                    area: this.$page.props.route.area_id
                })
            )
            .then(res => (this.brigades = res.data.data))
        this.cloneRoute = _.cloneDeep(this.$page.props.route)
        axios
            .get(route('api.user.index'))
            .then(res => (this.engineers = res.data.data))
        Echo.private(`route.${this.$page.props.route.id}`)
            .listen('RouteUpdated', e => {
                console.log('строка 736', e)
                this.$page.props.route = e.route
            })
            .listen('RouteLocationUpdated', e => {
                console.log('строка 740', e)
                this.routeTraveled.push(e.collection[0])
                console.log('routetraveled строка 742', this.routeTraveled)
            })
    },

    methods: {
        func() {
            console.log(this.$page.props)
        },
        show(data) {
            if (data === true) {
                this.$inertia.put(route('route.update', this.closedRoute), {
                    closed: true
                })
            }
        },
        sendForApproval() {
            if (!this.$page.props.user.lotus_login) {
                this.$notify({
                    group: 'success',
                    text: 'Лотус логин отсутствует'
                })
                return
            }
            this.$inertia.post(
                route('route.approval', this.$page.props.route.id),
                {},
                {
                    preserveScroll: true,
                    preserveState: true,
                    onSuccess: p => {
                        this.$notify({
                            group: 'success',
                            text: 'Маршрут отправлен на согласование'
                        })
                    }
                }
            )
        },
        closeAlertModal() {
            this.isShowAlert = false
        },
        closeRoute() {
            this.$refs.RouteClosed.open()
        },
        deleteBrigade(brigade) {
            const candidate = this.cloneRoute.users.indexOf(brigade)
            if (candidate !== -1) {
                this.cloneRoute.users.splice(candidate, 1)
            }
        },
        addBrigade(brigade) {
            const candidate = this.cloneRoute.users.indexOf(brigade)
            if (candidate !== -1) {
                this.deleteBrigade(brigade)
                return
            }
            this.cloneRoute.users.push(brigade)
        },
        cancelEditRoute() {
            this.isActiveEditRouteInform = false
            this.cloneRoute = _.cloneDeep(this.$page.props.route)
        },
        openModalList(application, type = 'bts') {
            this.$refs.modalList.switchModalStatus(true, application, type)
        },
        onEnd() {
            const dataToSend = []
            const appPositions = this.$refs.draggable.list.map((app, index) => {
                const application = {
                    id: app.id,
                    position: ++index,
                    ticket: app.ticket
                }
                const appToSend = {
                    application_id: app.id,
                    sort: ++index
                }
                dataToSend.push(appToSend)
                return application
            })
            // this.$refs.map.changeRouteOrder(this.$refs.draggable.list)
            this.$inertia.put(
                route('route.update', this.$page.props.route.id),
                { applications: dataToSend },
                {
                    preserveScroll: true,
                    preserveState: true,
                    only: ['route'],
                    bag: 'applications'
                }
            )
        },
        updateRoute() {
            this.isActiveEditRouteInform = false
            console.log(this.cloneRoute)
            const form = {
                started_at: this.cloneRoute.started_at,
                deadline_at: this.cloneRoute.deadline_at,
                engineer: this.cloneRoute.engineer.id,
                users: this.cloneRoute.users.map(user => user.id)
            }
            this.$inertia.put(
                route('route.update', this.$page.props.route.id),
                form
            )
        },
        saveChangesRouteInform() {},
        switchStatusListBts(
            { application_ticket, stations, round, applicationId },
            status = false
        ) {
            try {
                if (status) {
                    this.isShowRouteModal = false
                    this.listBts.data = {
                        application_ticket,
                        stations,
                        round
                    }
                    this.listBts.isShow = status
                    // this.drawBaseStationsOnMap({
                    //   applicationId,
                    //   round
                    // }) вызвать через ref
                    return
                }
                this.isShowStation_map = false
                this.listBts.isShow = status
                this.isShowRouteModal = true
            } catch (e) {}
        },
        switchStatusRouteModal(status = true) {
            this.isShowRouteModal = status
        },
        openCreateModal() {
            this.searchApplications()
            this.$modal.show('createRouteModal')
        },
        closeCreateModal() {
            this.search = ''
            this.isVisibleSearchBlock = false
            this.$modal.hide('createRouteModal')
        },
        switchModalChangeRoutes() {
            this.isActiveModalChangeRoutes = !this.isActiveModalChangeRoutes
        },
        searchApplications() {
            axios
                .get(
                    route('api.application.index', {
                        ticket: this.search,
                        area: this.$page.props.route.area_id
                    })
                )
                .then(result => {
                    this.routes = result.data.data
                })
        },
        async selectedApplication(application) {
            try {
                const more_station_btn = document.querySelectorAll(
                    '.more_bts_btn'
                )
                const btnArr = []
                more_station_btn.forEach(btn => btnArr.push(btn))
                if (btnArr.some(btn => btn.contains(event.target))) {
                    this.openModalBts(application)
                    return
                }
                if (
                    this.$page.props.route.applications.some(
                        app => app.id === application.id
                    )
                ) {
                    return
                }
                this.$refs.map.createApplication(application)
                this.applications.push(application)
                this.search = application.ticket
                this.$inertia.post(
                    route('route.application.store', this.$page.props.route.id),
                    {
                        application: application.id
                    },
                    {
                        preserveScroll: true,
                        preserveState: true,
                        only: ['route'],
                        bag: 'filter'
                    }
                )
                this.$modal.hide('createRouteModal')
                this.$notify({
                    group: 'success',
                    text: 'Заявка добавлена'
                })
            } catch (e) {
                console.error(e)
            }
        },
        switchAlertModal(deleted) {
            if (deleted) {
                this.$modal.show('alert')
                this.deletedApp = deleted
                return
            }
            this.deletedApp = null
            this.$modal.hide('alert')
        },

        async deleteApplication() {
            this.$inertia.delete(
                route('route.application.delete', {
                    route: this.$page.props.route.id,
                    application: this.deletedApp
                }),
                {
                    preserveScroll: true,
                    preserveState: true,
                    only: ['route'],
                    bag: 'filter'
                }
            )
            this.switchAlertModal()
            this.$notify({
                group: 'success',
                text: 'Заявка удалена'
            })
        }
    },
    watch: {
        routeTraveledLength() {
            this.$refs.map.redrawTraversedRoute(this.routeTraveled)
        }
    },
    computed: {
        routeTraveledLength() {
            return this.routeTraveled.length
        }
    }
}
</script>

<style lang="scss"></style>
