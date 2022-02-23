<template>
    <div>
        <div class="row" v-for="(file, index) in files">
            <div class="col-sm-12">
                <div class="input-group">
                    <a v-if="file.path" :href="file.path" :data-lightbox="'image-' + file.id" class="file-image"><i class="material-icons">image</i></a>
                    <template v-if="!file.id">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="customFile" @change="fileInputChange(file)">
                            <label class="custom-file-label" for="customFile">Выберите файл</label>
                        </div>
                        <div class="clear"></div>
                        <div class="input-group-prepend">
                            <button type="button" class="item-btn btn-loader" @click="uploadFile(file)"><i class="material-icons">cloud_upload</i> Загузить</button>
                        </div>
                    </template>

                    <div class="input-group-prepend">
                        <button type="button" class="item-btn btn-loader" @click="deleteFile(index)"><i class="material-icons">delete</i> Удалить</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <button class="item-btn" @click.prevent="addFile"><i class="material-icons">add</i>Файл</button>
            </div>
        </div>
    </div>
</template>

<script>
    import lightbox from 'lightbox2'
    export default {
        name: "FileLoader",
        props: {
            files: Array
        },
        data () {
            return {

            };
        },
        methods: {
            addFile () {
                this.files.push({id: 0, path: ''});
                this.$forceUpdate();
            },
            deleteFile (index) {

                if (!this.files[index].id){
                    this.files.splice(index, 1);
                    return;
                }

                axios.delete('/api/test/download/' + this.files[index].id)
                    .then(response => {
                        if (response.data.result){
                            this.files.splice(index, 1);
                        }
                    });
            },
            fileInputChange (download) {
                download.file = event.target.files[0];
            },
            async uploadFile (download) {

                let form = new FormData();
                form.append('file', download.file);
                form.append('stepId', this.$parent.currentStep.id);

                await axios.post('/api/test/download', form, {
                })
                .then(response => {
                    download.id = response.data;
                })
                .catch(error => {
                    console.log(error);
                });
            }
        },
        mounted() {
            if (!this.files)
                this.files = [];
        }
    }

    lightbox.option({
        'showImageNumberLabel': false,
    })
</script>

<style>
    .file-image {
        position: relative;
        top: 20px;
    }
    .item-btn.btn-loader {
        margin: 0 10px 0 10px;
    }

</style>
