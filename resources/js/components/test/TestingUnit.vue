<template>
    <div class="test-unit">
        <p class="slick-block" v-html="question.title"></p>
        <div class="test-radio slick-block" v-for="answer in answers">
            <input class="test-radio-input" :id="'testRadio-' + answer.id"  type="radio" v-model="choice" :value="answer.id"/>
            <label class="test-radio-elem" :for="'testRadio-' + answer.id"></label>
            <label class="test-radio-label" :for="'testRadio-' + answer.id" v-html="answer.title"></label>
        </div>

    </div>
</template>

<script>
    export default {
        props: {
            question: Object,
            answers: Object
        },
        name: "TestingUnit",
        data () {
            return {
                choice: 0
            }
        },
        watch: {
            choice: function () {
                this.$root.$emit('answer-selected', this.answers[this.choice].point, this.answers[this.choice].next_step_id);
            }
        },
    }
</script>

<style scoped>

</style>
