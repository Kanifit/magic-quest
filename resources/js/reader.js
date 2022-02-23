/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
window.simplebar = require('simplebar-vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('loader', require('./components/book-ui/Loader.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

import ReaderHeader from './components/reader-ui/ReaderHeader.vue';
import Options from './components/reader-ui/Options.vue';

const app = new Vue({
    el: '#reader',
    data: {
        loading: true
    },
    components: {
            'reader-header': ReaderHeader,
            'options': Options,
    },
    methods: {
        goBack: function () {
            window.history.back();
        },
        tapSettings: function() {

            let options = document.getElementById('options');

            if (!options.classList.contains('open'))
                options.classList.add('open');
            else
                options.classList.remove('open');
        }
    },
    mounted: function () {
        window.addEventListener("DOMContentLoaded", () => {
            this.loading = false;
            document.body.classList.remove('blockScroll');
        });
    }
});