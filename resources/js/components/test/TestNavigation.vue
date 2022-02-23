<template>
    <div class="continue" v-if="(haveDescription && !haveQuestion) || canContinue" @click.prevent="sendResponse">
        <span class="text">Продолжить</span>
        <i class="material-icons next-step">keyboard_arrow_right</i>
    </div>
</template>

<script>
    export default {
        props: ['haveDescription', 'haveQuestion'],
        name: "TestNavigation",
        data () {
            return {
                nextStep: 0,
                canContinue: false,
                point: 0,
            }
        },
        watch: {
        },
        methods: {
            sendResponse: function () {
                this.setAnswerAttemptJournal();
                this.$parent.stepId = this.nextStep;
                this.$parent.getStep();
                this.canContinue = false;
                this.nextStep = 0;
                this.$root.$emit('add-score', this.point);
                this.point = 0;
                this.$parent.attemptJournalId = 0;
            },
            setAnswerAttemptJournal: function () {
                axios.put('/api/test/journal/' + this.$parent.attemptJournalId, {
                    point: this.point
                }).catch((error) => {
                    console.log(error);
                })

            },
        },
        mounted: function () {
            this.$root.$on('answer-selected', (point, nextStep) => {
                this.point = point;
                this.nextStep = nextStep;
                this.canContinue = true;
            });

        },
    }
</script>

<style scoped>

</style>
