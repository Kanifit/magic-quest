require('./bootstrap');

window.Vue = require('vue');
require('lightbox2')

import StepCreator from "./components/test/admin/StepCreator";

import Editor from 'v-markdown-editor';
Vue.use(Editor);

const app = new Vue({
    el: '#appStepCreator',
    data: {
    },
    components: {
        StepCreator
    },
    methods: {

    },
    mounted: function () {
    }
});
