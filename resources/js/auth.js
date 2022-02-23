require('./bootstrap');

window.Vue = require('vue');
window.simplebar = require('simplebar-vue');

Vue.component('loader', require('./components/book-ui/Loader.vue').default);
Vue.component('register', require('./components/auth-ui/Register.vue').default);
Vue.component('login', require('./components/auth-ui/Login.vue').default);

const app = new Vue({
    el: '#auth',
    data: {
        loading: true,
        register: false,
        regEnter: false,
        login: false,
    },
    components: {

    },
    methods: {
        openLogin: function () {
            this.login = true;
        },
        logClose: function () {
            this.login = false;
        },
        regAfterEnter: function() {
            this.regEnter = true;
        },
        regBeforeLeave: function() {
            this.regEnter = false;
        },
        regClose: function ()
        {
            this.regEnter = false;

            setTimeout(() => {
                this.register = false;
            }, 201);
        }
    },
    mounted: function () {
        window.addEventListener("DOMContentLoaded", () => {
            this.loading = false;
            document.body.classList.remove('blockScroll');
        });
    }
});