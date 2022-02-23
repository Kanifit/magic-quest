<template>
    <div class="container">
        <div class="creator-header">Шаги квеста "{{ test.name }}"</div>
        <div class="panel-group creator-items" id="accordion" v-if="Object.keys(steps).length > 0">
            <div class="panel panel-default"  v-for="(step, index) in steps" :key="step.id" @click="isCollapse(index)">
                <div class="panel-heading item-tile">
                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" :href="'#collapse-' + step.id">
                        <span class="tile-name"> {{ step.title }}</span>
                        <i class="material-icons tile-icon">keyboard_arrow_down</i>
                    </a>
                </div>
                <div :id="'collapse-' + step.id" class="panel-collapse collapse in item-params">
                    <h4>Параметры</h4>
                    <div class="panel-body">
                        <div class="group">
                            <input type="text" v-model.trim="step.title" placeholder="Название">
                            <span class="highlight"></span>
                            <span class="bar"></span>
                            <label>Название</label>
                        </div>
                        <div class="group">
                            <input type="text" v-model.trim="step.code" placeholder="Символьный код">
                            <span class="highlight"></span>
                            <span class="bar"></span>
                            <label>Символьный код</label>
                        </div>
                        <div class="group">
                            <input type="number" v-model="step.sort" placeholder="Cортировка">
                            <span class="highlight"></span>
                            <span class="bar"></span>
                            <label>Cортировка</label>
                        </div>
                        <div class="clear"></div>
                        <h4>Описание</h4>
                        <step-description-creator @send-html="getDescriptionHtml" :description="step.description"></step-description-creator>
                        <h4 v-if="step.id" >Изображения</h4>
                        <file-loader v-if="step.id" :files="step.files.images"></file-loader>
                        <div class="clear"></div>
                        <h4>Вопрос</h4>
                        <div class="group">
                            <input type="text" v-model.trim="step.question.title" placeholder="Название">
                            <span class="highlight"></span>
                            <span class="bar"></span>
                            <label>Название</label>
                        </div>
                        <div class="clear"></div>
                        <h4>Ответы</h4>
                        <div v-if="Object.keys(steps).length > 0" v-for="answer in step.answers" :key="answer.id">
                            <div class="group">
                                <input type="text" v-model.trim="answer.title" placeholder="Название">
                                <span class="highlight"></span>
                                <span class="bar"></span>
                                <label>Название</label>
                            </div>
                            <div class="group">
                                <input type="number" v-model="answer.sort" placeholder="Cортировка">
                                <span class="highlight"></span>
                                <span class="bar"></span>
                                <label>Cортировка</label>
                            </div>
                            <div class="group">
                                <input type="number" v-model="answer.point" placeholder="Балл">
                                <span class="highlight"></span>
                                <span class="bar"></span>
                                <label>Балл</label>
                            </div>
                            <div class="group">
                                <select name="stepId" class="book-select" v-model="answer.next_step_id">
                                    <option value="0" selected disabled>Выберите шаг</option>
                                </select>
                                <span class="highlight"></span>
                                <span class="bar"></span>
                                <label>Выберите следующий шаг</label>
                            </div>
                            <div class="clear"></div>
                        </div>
                        <button class="item-btn" @click.prevent="addAnswer(step, index)"><i class="material-icons">add</i>Ответ</button>
                        <div class="clear"></div>

                        <div class="alert save-alert" :class="[ isSuccess ? 'alert-success' : 'alert-danger']" role="alert" v-if="alert">
                            <strong v-html="isSuccess ? 'Успешно!' : 'Ошибка!'"></strong>
                        </div>
                        <button class="item-btn" @click="saveStep(step, index)"><i class="material-icons">save</i> Сохранить</button>
                        <button class="item-btn" @click="deleteStep(index)"><i class="material-icons">delete</i> Удалить</button>

                    </div>
                </div>
            </div>
        </div>
        <div v-else>
            <p>Шагов пока нет :(</p>
        </div>
        <button class="item-btn" @click.prevent="add" v-if="canAdd"><i class="material-icons">add</i>Создать</button>
    </div>
</template>

<script>
    import StepDescriptionCreator from "./StepDescriptionCreator";
    import FileLoader from "./FileLoader";
    export default {
        props: {
            steps: Array,
            test: Object,
        },
        name: 'StepCreator',
        data () {
            return {
                currentStep: {},
                canAdd: true,
                alert: false,
                isSuccess: false,
            }
        },
        methods: {
            isCollapse: function (index) {
                this.currentStep = this.steps[index];
                if (this.currentStep && this.currentStep.hasOwnProperty('id'))
                    $('.collapse').not('#collapse-' + this.currentStep.id).removeClass('show');
            },
            add: function () {
                this.steps.push({id: 0, title: 'Новый шаг', description: { text: ''},files: { images: []}, code: '', sort: 1000, question: { title: 'Текст вопроса'}, answers: []});
                this.canAdd = false;
            },
            deleteStep: function (index) {
                if (!this.steps[index].id)
                {
                    this.steps.splice(index, 1);
                    this.canAdd = true;
                    this.currentStep = [];
                }
                else
                {
                    axios.delete('/bookadmin/steps/' + this.steps[index].id, {
                    }).then(response => {
                        if (response.data.isDeleted)
                        {
                            this.steps.splice(index, 1);
                            this.currentStep = [];
                        }
                    }).catch((error) => {
                        console.log(error);
                    })
                }
            },
            saveStep: function (step, index) {
                this.alert = false;
                this.isSuccess = false;

                axios({
                    method: !this.steps[index].id ? 'post' : 'put',
                    url: '/bookadmin/steps/' + (this.steps[index].id ? this.steps[index].id : ''),
                    data: {step: this.currentStep, testId: this.test.id}
                }).then(response => {
                    if (response.data.stepId)
                    {
                        step.id = response.data.stepId;
                        $('#collapse-' + step.id).addClass('show');
                        this.isSuccess = true;
                        this.canAdd = true;
                        this.alert = true;
                    }
                    else
                        this.alert = true;

                    setTimeout(() => {
                        $(".alert").fadeTo(500, 0).slideUp(500, function(){
                            $(this).hide();
                        });
                    }, 1500);
                }).catch((error) => {
                    this.alert = true;
                    setTimeout(() => {
                        $(".alert").fadeTo(500, 0).slideUp(500, function(){
                            $(this).remove();
                        });
                    }, 1500);
                })

            },
            addAnswer: function (step) {
                step.answers.push({id: 0, title: 'Новый ответ', sort: 1000, point: null, next_step_id: null});
                this.$forceUpdate();

            },
            getDescriptionHtml: function (val) {
                this.currentStep.description.text = val;
            }
        },
        components: {
            StepDescriptionCreator, FileLoader
        },
    }
</script>

<style>
.item-tile
{
    background: linear-gradient(to right, rgb(116, 235, 213), rgb(172, 182, 229))
}

</style>
