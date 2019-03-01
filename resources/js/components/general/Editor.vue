<template>
    <div style="position: relative">
        <div class="h-400p" ref="editor" @keyup="setContent()">{{ value }}</div>
    </div>
</template>

<script type="text/ecmascript-6">
    export default {
        props: {
            value: {
                type: String,
                default: ''
            },
            postId: {
                type: String
            },
            placeholder: {
                type: String,
                default: 'Write a new post...'
            }
        },
        data (){
            return {
                editor: null,
                editorBody: this.body
            }
        },
        mounted () {
            this.editor = this.createEditor();
            this.setupListeners();
        },
        methods: {
            createEditor () {
                /* global Quill */
                let editor = new Quill(this.$refs.editor, {
                    modules: {
                        syntax: true,
                        toolbar: [
                            ['bold', 'italic', 'underline', 'strike'],
                            [{ header: [1, 2, 3, false] }],
                            [{'list': 'ordered'}, {'list': 'bullet'}, 'link'],
                            ['blockquote', 'code-block'], ['link', 'image']
                        ],
                        imageResize: {
                            displaySize: true
                        },
                    },
                    theme: 'snow',
                    scrollingContainer: 'html, body',
                    placeholder: this.placeholder,
                });

                editor.root.innerHTML = this.value;

                return editor;
            },
            setupListeners () {
                this.editor.on('editor-change', (eventName, ...args) => {
                    this.setContent();
                });
            },
            setContent () {
                this.editorBody = this.$refs.editor.children[0].innerHTML;
                this.$emit('input', this.editorBody);
            },
        }
    }
</script>