<template>
    <div class="container">
        <div class="creator-header">Квесты</div>
        <div class="panel-group creator-items" id="accordion" v-if="Object.keys(tests).length > 0">
            <div class="panel panel-default" v-for="(test, index) in tests" :key="test.id" @click="isCollapse(index)">
                <div class="panel-heading item-tile">
                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" :href="'#collapse-' + test.id">
                        <span class="tile-name"> {{ test.name }}</span>
                        <i class="material-icons tile-icon">keyboard_arrow_down</i>
                    </a>
                </div>
                <div :id="'collapse-' + test.id" class="panel-collapse collapse in item-params">
                    <h4>Параметры</h4>
                    <div class="panel-body">
                        <div class="group">
                            <input type="text" v-model.trim="test.name" placeholder="Название">
                            <span class="highlight"></span>
                            <span class="bar"></span>
                            <label>Название</label>
                        </div>
                        <div class="group">
                            <input type="text" v-model.trim="test.code" placeholder="Символьный код">
                            <span class="highlight"></span>
                            <span class="bar"></span>
                            <label>Символьный код</label>
                        </div>
                        <div class="group">
                            <select name="bookId" class="book-select" v-model="test.book_id">
                                <option value="0" selected disabled>Выберите книгу</option>
                                <option v-if="test.book_id && test.book" :value="test.book_id" selected>{{ test.book.book_title}}</option>
                                <option v-for="book in availableBooks" :value="book.id">{{ book.book_title }}</option>
                            </select>
                        </div>
                        <div class="clear"></div>
                    </div>
                    <div class="alert save-alert" :class="[ isSuccess ? 'alert-success' : 'alert-danger']" role="alert" v-if="alert">
                        <strong v-html="isSuccess ? 'Успешно!' : 'Ошибка!'"></strong>
                    </div>
                    <button class="item-btn" @click="saveTest(test, index)"><i class="material-icons">save</i> Сохранить</button>
                    <a class="item-btn settings" :href="'/bookadmin/tests/' + test.id + '/edit'" v-if="test.id > 0"><i class="material-icons">settings</i> Настроить</a>
                    <button class="item-btn" @click="deleteTest(index)"><i class="material-icons">delete</i> Удалить</button>
                </div>
            </div>
        </div>
        <div v-else>
            <p>Тестов нет :(</p>
        </div>
        <button class="item-btn" @click.prevent="add" v-if="canAdd"><i class="material-icons">add</i>Создать</button>
    </div>
</template>

<script>
    export default {
        props: {
            tests: Array,
        },
        name: 'TestCreator',
        data () {
            return {
                currentTest: {},
                canAdd: true,
                availableBooks: [],
                alert: false,
                isSuccess: false,
            }
        },
        watch: {

        },
        methods: {
            isCollapse: function (index) {
                this.currentTest = this.tests[index];
                if (this.currentTest && this.currentTest.hasOwnProperty('id'))
                    $('.collapse').not('#collapse-' + this.currentTest.id).removeClass('show');
            },
            add: function () {
                this.tests.push({id: 0, name: 'Новый квест', book_id: 0});
                this.canAdd = false;
            },
            deleteTest: function (index) {
                if (!this.tests[index].id)
                {
                    this.tests.splice(index, 1);
                    this.canAdd = true;
                    this.currentTest = [];
                }
                else
                {
                    axios.delete('/bookadmin/tests/' + this.tests[index].id, {
                    }).then(response => {
                        if (response.data.isDeleted)
                        {
                            this.tests.splice(index, 1);
                            this.currentTest = [];
                            this.getAvailableBooks();
                        }
                    }).catch((error) => {
                        console.log(error);
                    })
                }
            },
            saveTest: function (test, index) {
                this.alert = false;
                this.isSuccess = false;

                axios({
                    method: !this.tests[index].id ? 'post' : 'put',
                    url: '/bookadmin/tests/' + (this.tests[index].id ? this.tests[index].id : ''),
                    data: this.currentTest
                }).then(response => {
                    if (response.data.testId)
                    {
                        test.id = response.data.testId;
                        this.getBook(test).then(() => {
                            this.getAvailableBooks();
                            $('#collapse-' + test.id).addClass('show');
                            this.isSuccess = true;
                            this.canAdd = true;
                            this.alert = true;
                        });
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
            getAvailableBooks: function () {
                axios.post('/bookadmin/getAvailableBooks/', {
                }).then(response => {
                    this.availableBooks = response.data;
                }).catch((error) => {
                    console.log(error);
                })
            },
            getBook: async function (test) {
                await axios.post('/bookadmin/getBook/', {
                    testId: test.id,
                    bookId: test.book_id
                }).then(response => {
                    test.book = response.data.book;
                }).catch((error) => {
                    console.log(error);
                })

            }

        },
        mounted() {
            this.getAvailableBooks()
        },
        components: {
        },
    }
</script>

<style scoped>

</style>
