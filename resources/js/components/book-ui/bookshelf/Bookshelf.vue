<template>
    <div>
        <div class="bookshelf fluid-container">
            <book v-for="book in book_list" 
            v-bind:key="book.bookId"
            v-bind:book-id="book.id"
            v-bind:image="book.image"
            ></book>
        </div>
    </div>
</template>

<script>
    import Book from './Book.vue';
    import MovingBookCover from './MovingBookCover.vue';

    export default {
        data() {
            return {
                openedBookId: null,
                animationDone: false,
                book_list: [
                    {"id": 0, "image": null}, 
                    {"id": 0, "image": null}, 
                    {"id": 0, "image": null}, 
                    {"id": 0, "image": null}, 
                    {"id": 0, "image": null}, 
                    {"id": 0, "image": null}, 
                    {"id": 0, "image": null}, 
                    {"id": 0, "image": null}, 
                    {"id": 0, "image": null}, 
                    {"id": 0, "image": null}, 
                    {"id": 0, "image": null}, 
                    {"id": 0, "image": null}
                ],
                movingBook: null,
                shifts: {
                    y: 0,
                    x: 0,
                    size_x: 0,
                    size_y: 0,
                    radius: 5
                }
            };
        },
        components: {
                'book': Book,
                simplebar
        },
        methods: {
            grabUserBooks: function () 
            {
                axios
                    .post('/api/books')
                    .then(response => (this.book_list = response.data, this.bookinfoState = true));
            },
        },
        mounted: function () {

            this.grabUserBooks();

        }
    }

</script>