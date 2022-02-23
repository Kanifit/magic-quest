<template>
    <div class="test-images-block">
        <slick ref="slick" :options="slickOptions">
            <div class="test-image" v-if="sliderImages" v-for="image in sliderImages" :key="image.id">
                <a :href="image.path" :data-lightbox="'image-' + image.id"><img :data-lazy="image.path" alt=""></a>
            </div>
        </slick>
    </div>
</template>

<script>
    import lightbox from 'lightbox2'
    import Slick from 'vue-slick';
    export default {
        props: ['images'],
        name: "TestImages",
        data () {
            return {
                slickOptions: {
                    slidesToShow: this.images.length > 3 ? 3 : this.images.length,
                    infinite: true,
                    slidesToScroll: 3,
                    focusOnSelect: true,
                    centerMode: true,
                    lazyLoad: 'progressive',
                    responsive: [
                        {
                            breakpoint: 480,
                            settings: {
                                arrows: false,
                                slidesToShow: 1
                            }
                        }
                    ]
                },
                sliderImages: []
            }
        },
        methods: {
            next() {
                this.$refs.slick.next();
            },

            prev() {
                this.$refs.slick.prev();
            },

            reInit() {
                this.$nextTick(() => {
                    this.$refs.slick.reSlick();
                });
            },

        },
        beforeUpdate() {
            if (this.$refs.slick) {
                this.$refs.slick.destroy();
            }
        },
        updated() {
            this.$nextTick(function () {
                if (this.$refs.slick) {
                    this.$refs.slick.create(this.slickOptions);
                }
            });
        },
        mounted: function () {
            setTimeout(() => this.sliderImages = this.images, 1500)
        },
        components: {
            Slick
        },
    }


    lightbox.option({
        'showImageNumberLabel': false,
    })


</script>

<style scoped>

</style>
