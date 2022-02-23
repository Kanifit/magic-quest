<template>
    <div class="reader-header" v-bind:class="{ hidden: isHidden }">
        <div class="back" @click="goBack">
            <i class="material-icons">keyboard_arrow_left</i>
        </div>
        <div class="title">{{ title }}</div>
        <div class="more" @click="openSettings">
            <i class="material-icons">more_horiz</i>
        </div>
    </div>
</template>

<script>

    export default {
        props: {
            title: String,
        },
        data () {
            return {
                lastScrollValue: 0,
                isHidden: false
            }
        },
        watch: {

        },
        methods: {
            openSettings: function () {
                this.$emit('click-open-settings');
            },
            goBack: function () {
                this.$emit('click-back-button');
            },
            onScroll: function (scroll) {
                if (Math.abs(scroll - this.lastScrollValue) > 50)
                {
                    if (scroll > this.lastScrollValue && this.lastScrollValue != 0)
                    {
                        this.isHidden = true;
                    }
                    else
                    {
                        this.isHidden = false;
                    }

                    this.lastScrollValue = scroll;
                }
                else if (scroll == 0)
                {
                    this.isHidden = false;
                }
          }
        },
        mounted: function () {

            window.addEventListener("scroll", () => {
                this.onScroll(pageYOffset);
            });
        }
    }

</script>