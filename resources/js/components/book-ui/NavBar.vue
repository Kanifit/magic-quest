<template>
    <ul class="book-navbar">
        <li
            v-for="tab in tabs"
            v-bind:key="tab.name"
            v-bind:class="[{ active: currentTabLocal.name === tab.name }]"

        >
            <i v-if="tab.name === 'Extension'" class="material-icons"><a href="/bookadmin/tests/">{{ tab.icon }}</a></i>
            <i v-else class="material-icons" v-on:click="currentTabLocal = tab">{{ tab.icon }}</i>
        </li>
    </ul>
</template>

<script>

    export default {
        props: {
            tabs: Array,
            currentTab: Object
        },
        data () {
            return {
                currentTabLocal: this.currentTab
            }
        },
        watch: {
            currentTabLocal: function ()
            {
                this.$emit('changing-tab', this.currentTabLocal);
            }
        }
    }

</script>
