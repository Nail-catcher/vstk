<template>
    <app-layout class="Base crud">
        <template #header>
            <div class="base-header__wrapp space-between">
                <div class="obj-header">
                    <h1>История событий</h1>
                </div>
            </div>
        </template>
        <div class="table__wrapper">
            <div class="table__wrapper__head">
                <ul style="grid-template-columns: 1fr 1fr 1fr">
                    <li>Сотрудник</li>
                    <li>Действие</li>
                    <li>Время</li>
                </ul>
            </div>
            <div class="table__wrapper__body">
                <!-- data from active_log -->
                <ul
                    style="grid-template-columns: 1fr 1fr 1fr"
                    v-for="(item, index) in $page.props.logs.data"
                >
                    <li
                        v-for="user in $page.props.users"
                        v-if="user.id == item.causer_id"
                    >
                        <span>Сотрудник</span>
                        <a :href="route('user.edit', user.id)"
                            >{{ user.firstname }} {{ user.lastname }}</a
                        >
                    </li>
                    <li v-if="item.description == 'created'">
                        <span>Действие</span>
                        <p v-if="item.subject_type == 'App\\Models\\Route'">
                            Маршрут #
                            <intertia-link
                                :href="route('route.show', item.subject_id)"
                            >
                                {{ item.subject_id }}
                            </intertia-link>
                            построен
                        </p>
                        <p
                            v-if="
                                item.subject_type == 'App\\Models\\Application'
                            "
                        >
                            {{ item.properties.attributes['status.title'] }}
                            заявка #<inertia-link
                                :href="route('route.show', item.subject_id)"
                            >
                                {{ item.subject_id }}
                            </inertia-link>
                        </p>
                        <p
                            v-if="
                                item.subject_type ===
                                    'App\\Models\\StartingProgress'
                            "
                        >
                            Произведено действие
                            {{
                                item.properties.attributes
                                    ? item.properties.attributes[
                                          'progress.title'
                                      ]
                                    : ''
                            }}
                            По БС
                            {{
                                item.properties.attributes
                                    ? item.properties.attributes[
                                          'starting.station.bts_id'
                                      ]
                                    : ''
                            }}
                            на заявке #
                            <inertia-link
                                :href="
                                    route(
                                        'application.show',
                                        item.properties.attributes[
                                            'starting.application.id'
                                        ]
                                    )
                                "
                            >
                                {{
                                    item.properties.attributes[
                                        'starting.application.id'
                                    ]
                                }}
                            </inertia-link>
                        </p>
                    </li>
                    <li
                        v-else-if="
                            item.description == 'updated' &&
                                item.properties &&
                                item.subject_type == 'App\\Models\\Route'
                        "
                    >
                        <span>Действие</span>
                        Маршрут #
                        <inertia-link
                            class="pointer"
                            :href="route('route.show', item.subject_id)"
                        >
                            {{ item.subject_id }}
                        </inertia-link>
                        {{
                            item.properties.attributes
                                ? `${item.properties.attributes[
                                      'status.title'
                                  ] ||
                                      item.properties.attributes[
                                          'activity.title'
                                      ]}`
                                : ''
                        }}
                    </li>
                    <li
                        v-else-if="
                            item.description == 'updated' && item.properties
                        "
                    >
                        <span>Действие</span>
                        изменен статус на заявке #
                        <inertia-link
                            :href="route('application.show', item.subject_id)"
                        >
                            {{ item.subject_id }}
                        </inertia-link>

                        <br />
                        {{
                            item.properties.old
                                ? item.properties.old['status.title']
                                : ''
                        }}
                        {{
                            item.properties.attributes
                                ? `-> ${item.properties.attributes[
                                      'status.title'
                                  ] ||
                                      item.properties.attributes[
                                          'activity.title'
                                      ]}`
                                : ''
                        }}
                    </li>
                    <li v-else-if="item.description === 'deleted'">
                        <p
                            v-if="
                                item.subject_type == 'App\\Models\\Application'
                            "
                        >
                            Заявка #{{ item.subject_id }}
                            удален
                        </p>
                    </li>
                    <li>
                        <span>Время</span
                        >{{ new Date(item.created_at).toLocaleString() }}
                    </li>
                </ul>
            </div>
        </div>
        <pagination
            v-if="$page.props.logs.last_page > 1"
            :pagination="$page.props.logs"
        >
        </pagination>
    </app-layout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout'
import Pagination from '@/components/Pagination'

export default {
    components: {
        AppLayout,
        Pagination
    },
    data() {
        return {
            form: {
                bts_id: '',
                area: ''
            }
        }
    },
    mounted() {
        localStorage.removeItem('new_history')
        localStorage.setItem('new_history', false)
        console.log(this.$page.props.logs)
    }
}
</script>
