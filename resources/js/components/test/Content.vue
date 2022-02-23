<template>
    <simple-bar data-simplebar-auto-hide="false" class="test-content">
        <p class="text slick-block" v-html="description.text"></p>
    </simple-bar>
</template>

<script>
    import SimpleBar from 'simplebar-vue';
    export default {
        props: {
            description: Object
        },
        name: "TestContent",
        components: {
            SimpleBar
        },
    }
</script>

<style scoped>

</style>
