<template>
    <div class="loader" v-if="loading"></div>
</template>

<script>
    export default {
        data() {
            return {
                loading: true
            };
        },
        methods: {
        },
        mounted: function () {
            window.addEventListener("DOMContentLoaded", () => {
                this.loading = false;
                document.body.classList.remove('blockScroll');
            });
        }
    }
</script>