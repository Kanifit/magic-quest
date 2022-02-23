<template>
    <div class="search" v-bind:class="{ collapse: isCollapsed, hide: isHiding}">
        <div class="bg">
            <div class="search-string">
                <form>
                    <label for="search">
                        <input id="search" placeholder="Искать автора или книгу..." v-model="search_string">
                    </label>
                </form>
                <span v-on:click="closeSearch">Отмена</span>
            </div>
                <div class="results">
                    <div class="title">
                        <span>Результаты поиска</span>
                        <div class="button" v-on:click="explandResults">
                            <i v-if="expland_results" class="material-icons">expand_less</i>
                            <i v-else="expland_results" class="material-icons">expand_more</i>
                        </div>
                    </div>
                    <simplebar data-simplebar-auto-hide="true" crollbar-min-size="1">
                        <div class="suggestions">
                            <book v-for="book in book_list" 
                            v-bind:key="book.bookId"
                            v-bind:book-id="book.id"
                            v-bind:image="book.image"
                            ></book>
                        </div>
                    </simplebar>
                    <div class="title">
                        <span>История поиска</span>
                        <div class="button" v-on:click="clearSearchHistory">
                            <i class="material-icons-outlined">delete</i>
                        </div>
                    </div>
                    <div class="serch-results">
                        <s-item v-for="(item, index) in search_history" 
                        v-bind:value="item"
                        v-bind:index="index"
                        v-bind:key="item.id"
                        v-on:search-history-click="useHistory"
                        ></s-item>
                    </div>
                </div>
        </div>
    </div>
</template>

<script>
import Book from './bookshelf/Book.vue';
import SearchItem from './search/SearchItem.vue';
import simplebar from 'simplebar-vue';

export default {
    data: function () {
        return {
            isCollapsed: false,
            isHiding: false,
            book_list: [
                    {"id": 0, "image": null}, 
                    {"id": 0, "image": null}, 
                    {"id": 0, "image": null}, 
                    {"id": 0, "image": null}, 
                    {"id": 0, "image": null}, 
                    {"id": 0, "image": null}
                ],
            search_string: "",
            search_history: ["Кашпировский", "Анекдоты из 2007", "Рофлы 2020", "Коронавирус", "Боже", "На", "Что", "Я", "Трачу", "Свою", "Жизнь", "Крым наш", "Глобальное потепление слишком близко, чтобы его не замечать"],
            visible_results: false,
            expland_results: false,
        }
    },
    components: {
        'book': Book,
        's-item': SearchItem,
        simplebar
    },
    methods: {
        openSearch: function () {
            if (this.isCollapsed == false) this.isCollapsed = !this.isCollapsed;
            if (this.isHiding == true) this.isHiding = !this.isHiding;
        },

        useHistory: function (param) {
            this.search_string = param;
            document.getElementById("search").focus();
        },

        explandResults: function () {
            if (this.expland_results)
                this.expland_results = false;
            else
                this.expland_results = true;
        },

        clearSearchHistory: function () {
            this.search_history = [];
        },

        closeSearch: function () {
            this.$emit('closing-search');
        }
    }
    
}
</script>