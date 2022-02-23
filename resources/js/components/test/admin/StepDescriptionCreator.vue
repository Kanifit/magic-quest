<template>
    <div class="editor">
        <markdown-editor :options="options" v-model="htmlText" toolbar="bold italic heading link numlist bullist preview"></markdown-editor>
    </div>
</template>

<script>
    import Marked from 'marked'
    export default {
        props: {
            description: Object
        },
        name: 'StepDescriptionCreator',
        data() {
            return {
                options: {
                    styleActiveLine: false,
                    styleSelectedText: true,
                    lineWrapping: true,
                    indentWithTabs: true,
                    tabSize: 2,
                    indentUnit: 2,
                    placeholder: 'Введите текст...'
                },
                htmlText: '',
            }
        },
        methods: {
        },
        watch: {
          htmlText: function () {
              this.$emit('send-html', Marked(this.htmlText));
          }
        },
        mounted() {
            if (this.description && this.description.text)
            {
                let div = document.createElement('div');
                div.innerHTML = this.description.text;
                this.htmlText = $(div).text();
            }
        },
        components: {
            Marked
        },
    }
</script>

<style>


</style>
