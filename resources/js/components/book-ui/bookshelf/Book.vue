<template >
    <div class="book" v-bind:class="{skeleton: isSkeleton}">
        <div class="image" 
        @click="openBookInfo"
        v-if="image !== undefined && image !== 'null' && image !== null"
        v-bind:style="{ 'background-image': 'url(' + image + ')' }"
        ></div>
        <div class="image" v-else></div>
    </div>
</template>

<script>
    export default {
        props: {
            image: String,
            bookId: Number,
        },
        data: function () {
            return {
                isSkeleton: true,
            }
        },
        watch: {
            image: function (value) {
                if (value != null) this.isSkeleton = false;
            }
        },
        methods: {
            openBookInfo: function ()
            {   
                if (this.isSkeleton)
                    return;

                this.$root.$emit('click-on-book', {
                                                'book_id': this.bookId, 
                                                'position': this.calcBookPos(),
                                                'image': this.image
                                            });
                           
                this.$el.classList.add("hide");
            },
            calcBookPos() {
                return this.$el.getBoundingClientRect();
            }
        },
        mounted: function () {
            if (this.image != null) this.isSkeleton = false;
        }
    }
</script>