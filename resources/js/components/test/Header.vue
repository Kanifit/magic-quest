<template>
    <div>
        <ul class="test-header">
            <li>
                <i class="material-icons" :class="{ 'stars-active' : score}">stars</i>
                <span :class="{'stars-count-active' : score}">{{ score }}</span>
            </li>
            <li>
                <i class="material-icons" :class="{'music-active' : sounds && Object.keys(sounds).length > 0 }">music_note</i>
            </li>
        </ul>
    </div>
</template>

<script>
    export default {
        props: {
            sounds: Object,
            attemptId: Number
        },
        name: 'TestHeader',
        data () {
            return {
                score: 0,
            }
        },
        methods: {
            getAttemptScore: function () {
                axios.post('/api/test/getAttemptScore', {
                    attemptId: this.attemptId,
                }).then(response => {
                    this.score = response.data.score;
                }).catch((error) => {
                    console.log(error);
                });
            },
            addAttemptScore: function (point) {
                axios.post('/api/test/addAttemptScore', {
                    attemptId: this.attemptId,
                    point: point
                }).catch((error) => {
                    console.log(error);
                })
            },
        },
        mounted: function () {
            this.$root.$on('add-score', (point) => {
                this.score += point;
                this.addAttemptScore(point);
            });
            this.getAttemptScore();
        },
    }
</script>

<style scoped>

</style>
