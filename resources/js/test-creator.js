require('./bootstrap');

window.Vue = require('vue');

import TestCreator from './components/test/admin/TestCreator';

const app = new Vue({
    el: '#appTestCreator',
    data: {
    },
    components: {
        TestCreator
    },
    methods: {

    },
    mounted: function () {
    }
});
