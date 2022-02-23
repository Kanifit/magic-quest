require('./bootstrap');

window.Vue = require('vue');
window.simplebar = require('simplebar-vue');
require('lightbox2')
require('vue-slick');

import Test from './components/test/Test.vue';

const app = new Vue({
    el: '#appTest',
    data: {
        loading: false,
    },
    components: {
        Test
    },
    methods: {

    },
    mounted: function () {
    }
});
