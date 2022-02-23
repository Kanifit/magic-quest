<template>
    <div class="search-item" v-on:click="itemClick">
        {{ title }}
    </div>
</template>

<script>
export default {
    props: {
        value: String
    },
    data: function () {
        return {
            title: ""
        }
    },
    methods: {
        itemClick: function () {
            this.$emit('search-history-click', this.value);
        }
    },
    
    mounted: function () {

        if (this.value.length > 30)
            this.title = this.value.slice(0, 27) + "...";
        else
            this.title = this.value;

    }
}
</script>