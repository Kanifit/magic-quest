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

Vue.component('search', require('./components/book-ui/Search.vue').default);
Vue.component('nav-bar', require('./components/book-ui/NavBar.vue').default);
Vue.component('loader', require('./components/book-ui/Loader.vue').default);

Vue.component('book-info', require('./components/book-ui/bookshelf/BookInfo.vue').default);

Vue.component('tab-bookshelf', require('./components/book-ui/bookshelf/Bookshelf.vue').default);
Vue.component('tab-discover', require('./components/book-ui/discover/Discover.vue').default);
Vue.component('tab-community', require('./components/book-ui/community/Community.vue').default);
Vue.component('tab-profile', require('./components/book-ui/profile/Profile.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    data: {
        currentTab: {'name' : 'Bookshelf', 'icon': 'book', 'title': 'Библиотека'},
        tabs: [
            {'name' : 'Bookshelf', 'icon': 'book', 'title': 'Библиотека'},
            {'name' : 'Discover', 'icon': 'explore', 'title': 'Обзор'},
            {'name' : 'Community', 'icon': 'bookmark', 'title': 'Закладки'},
            {'name' : 'Extension', 'icon': 'extension', 'title': 'Квест'},
            {'name' : 'Profile', 'icon': 'person', 'title': 'Профиль'}
        ],
        searchActive: false,
        loading: true,
        bookInfoState: false,
        openedBook: null,
        animationDone: false,
    },
    computed: {
        currentTabComponent: function () {
            return 'tab-' + this.currentTab.name.toLowerCase();
        }
    },
    methods: {
        changeTab: function (tab) {
            this.currentTab = tab;
        },
        openBookInfo: function (book) {
            this.$emit('opening-book-now', this.bookId);
        },
        openSearch: function () {
            this.searchActive = true;
            document.body.classList.add('blockScroll');
        },
        closeSearch: function () {
            this.searchActive = false;
            document.body.classList.remove('blockScroll');
        },
        closeBookInfoBlock: function () {
            this.bookInfoState = false;
            this.animationDone = false;
            document.body.classList.remove('blockScroll');
        },
        bookInfoOpenError: function ()
        {
            this.bookInfoState = false;
        },
        afterBookInfoEnter: function () {
            this.animationDone = true;
        }
    },
    mounted: function () {

        this.$on('click-on-book', function (book) {
            if (this.bookInfoState)
                return;

            this.openedBook = book;
            this.bookInfoState = true;
        });

        window.addEventListener("DOMContentLoaded", () => {
            this.loading = false;
            document.body.classList.remove('blockScroll');
        });
    }

});
