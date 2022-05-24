require('./bootstrap');

import Vue from 'vue';

import { App as InertiaApp, plugin as InertiaPlugin } from '@inertiajs/inertia-vue';
import { InertiaForm } from './libs/jetstream';
import PortalVue from 'portal-vue';
import VueI18n from 'vue-i18n';
import languageBundle
from '@kirschbaum-development/laravel-translations-loader/php!@kirschbaum-development/laravel-translations-loader';

import Notifications from 'vue-notification'
import VModal from 'vue-js-modal'

Vue.mixin({ methods: { route } });
Vue.use(InertiaPlugin);
Vue.use(InertiaForm);
Vue.use(PortalVue);
Vue.use(VueI18n)
Vue.use(VModal)
Vue.use(Notifications)
const i18n = new VueI18n({
    locale: document.documentElement.lang,
    messages: languageBundle,
    // Key - language to use the rule for, `'ru'`, in this case
    // Value - function to choose right plural form
    pluralizationRules: {
        /**
         * @param choice {number} a choice index given by the input to $tc: `$tc('path.to.rule', choiceIndex)`
         * @param choicesLength {number} an overall amount of available choices
         * @returns a final choice index to select plural word by
         */
        'ru': function(choice, choicesLength) {
            // this === VueI18n instance, so the locale property also exists here

            if (choice === 0) {
                return 0;
            }

            const teen = choice > 10 && choice < 20;
            const endsWithOne = choice % 10 === 1;

            if (choicesLength < 4) {
                return (!teen && endsWithOne) ? 1 : 2;
            }
            if (!teen && endsWithOne) {
                return 1;
            }
            if (!teen && choice % 10 >= 2 && choice % 10 <= 4) {
                return 2;
            }

            return (choicesLength < 4) ? 2 : 3;
        }
    }
})
const app = document.getElementById('app');

new Vue({
    render: (h) =>
        h(InertiaApp, {
            props: {
                initialPage: JSON.parse(app.dataset.page),
                resolveComponent: (name) => require(`./Pages/${name}`).default,
            },
        }),
    i18n
}).$mount(app);