<template>
    <div class="container">
        <i class="material-icons test-back" onclick="window.history.back()">keyboard_arrow_left</i>
        <div class="test" >
            <div class="loader" v-if="isLocked && !isEmptyTest"></div>
            <div v-if="!isCompleted && !isLocked">
                <test-header v-if="attemptId" :sounds="step.files.sounds" :attemptId="attemptId"></test-header>
                <test-content v-if="Object.keys(step.description).length > 0" :description="step.description"></test-content>
                <test-images v-if="Object.keys(step.files).length > 0 && Object.keys(step.files.images).length > 0" :images="step.files.images"></test-images>
                <testing-unit v-if="Object.keys(step.question).length > 0 && Object.keys(step.answers).length > 0" :question="step.question" :answers="step.answers"></testing-unit>
                <test-navigation :haveDescription="Object.keys(step.description).length > 0" :haveQuestion="Object.keys(step.question).length > 0"></test-navigation>
            </div>
            <div v-if="isCompleted">
                <completed-test></completed-test>
            </div>
            <empty-test v-if="isEmptyTest"></empty-test>
        </div>
    </div>
</template>

<script>
    import TestHeader from './Header';
    import TestContent from './Content';
    import TestImages from './TestImages';
    import TestingUnit from './TestingUnit';
    import TestNavigation from './TestNavigation';
    import CompletedTest from "./CompletedTest";
    import EmptyTest from "./EmptyTest";
    export default {
        name: 'Test',
        props: {
            id: Number,
        },
        data () {
            return {
                stepId: 0,
                step: {
                    description: {},
                    files: {
                        images: {},
                        sounds: {}
                    },
                    question: {},
                    answers: {}
                },
                stepSort: 0,
                isCompleted: false,
                attemptId: 0,
                attemptJournalId: 0,
                isEmptyTest: false
            }
        },
        computed: {
            isLocked () {
                return !this.attemptJournalId && !this.isCompleted
            }
        },
        methods: {
            getTest: function () {
                axios.post('/api/test/getTest', {
                    testId: this.id
                }).then(response => {
                    if (response.data.stepId)
                    {
                        this.getActiveAttemptId().then(() => {
                            if (this.attemptId)
                                this.getLastStep();
                            else
                            {
                                this.stepId = response.data.stepId;
                                this.stepSort = response.data.sort;
                                this.createAttempt();
                                this.getStep();
                            }
                        });
                    }
                    else
                        this.isEmptyTest = true;

                }).catch((error) => {
                    console.log(error);
                });
            },
            getStep: function () {
                axios.post('/api/test/getStep', {
                    mode: this.stepId ? 'step' : 'sort',
                    stepId: this.stepId,
                    currentSort: this.stepSort,
                    testId: this.id,
                }).then(response => {
                    if (response.data.noMoreSteps)
                    {
                        this.isCompleted = true;
                        this.completeAttempt();
                    }
                    else
                    {
                        this.stepId = response.data.step.id;
                        this.step = response.data.step;
                        this.stepSort = response.data.step.sort;
                        this.getStepAttempt().then(() =>{
                            if (!this.attemptJournalId)
                                this.setAttemptJournal();
                        });

                    }
                }).catch((error) => {
                    console.log(error);
                });
            },
            getActiveAttemptId: async function() {
                await axios.post('/api/test/getActiveAttemptId', {
                    testId: this.id,
                }).then(response => {
                    this.attemptId = response.data.attemptId;
                }).catch((error) => {
                    console.log(error);
                });
            },
            getLastStep: function () {
                axios.post('/api/test/getLastStep', {
                    attemptId: this.attemptId,
                }).then(response => {
                    this.stepId = response.data.stepId;
                    if (response.data.sort)
                        this.stepSort = response.data.sort;
                    this.getStep();
                }).catch((error) => {
                    console.log(error);
                });
            },
            createAttempt: async function () {
                await axios.post('/api/test/attempt', {
                    testId: this.id,
                }).then(response => {
                    this.attemptId = response.data.attemptId;
                }).catch((error) => {
                    console.log(error);
                })
            },
            completeAttempt: function () {
                axios.put('/api/test/attempt/' + this.attemptId, {
                }).catch((error) => {
                    console.log(error);
                })
            },
            setAttemptJournal: function () {
                axios.post('/api/test/journal/', {
                    attemptId: this.attemptId,
                    stepId: this.stepId
                }).then(response => {
                    this.attemptJournalId = response.data.attemptJournalId;
                }).catch((error) => {
                    console.log(error);
                })
            },
            getStepAttempt: async function () {
                await axios.post('/api/test/getStepAttempt', {
                    attemptId: this.attemptId,
                    stepId: this.stepId
                }).then(response => {
                    this.attemptJournalId = response.data.attemptJournalId;
                }).catch((error) => {
                    console.log(error);
                })
            }
        },
        mounted: function () {
            this.getTest();
        },
        components: {
            TestHeader, TestContent, TestImages, TestingUnit, TestNavigation, CompletedTest, EmptyTest
        },
    }
</script>

