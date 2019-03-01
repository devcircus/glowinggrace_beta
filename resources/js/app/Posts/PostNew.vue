<template>
    <div class="bg-white shadow-md rounded-lg mb-8">
        <div class="p-4 border-b border-grey-light bg-blue">
            <h1 class="text-2xl font-normal text-white uppercase">Write a new post</h1>
        </div>
        <div class="p-4 relative">
            <form ref="form" method="POST" @submit.prevent="createPost()" enctype="multipart/form-data">
                <div class="flex flex-col">
                    <input class="shadow appearance-none border rounded w-full h-12 text-black leading-tight focus:outline-none focus:border-blue-light p-2 mb-8" id="title" type="text" placeholder="Give your post a title" v-model="post.title">
                    <textarea placeholder="Provide a brief summary" rows="5" class="text-black p-2 mb-8 bg-white border rounded shadow focus:border-blue-light w-full" v-model="post.summary"></textarea>
                    <editor class="mb-8" placeholder="Now write to the world..." v-model="post.body"></editor>
                    <!-- <span class="text-base text-blue uppercase whitespace-no-wrap mr-2 mb-1">Categories: </span> -->
                    <!-- <multiselect v-model="chosen_categories"
                                 :options="categories"
                                 :multiple="true"
                                 :close-on-select="false"
                                 :clear-on-select="false"
                                 :preserve-search="true"
                                 placeholder="Choose..."
                                 label="name"
                                 track-by="name"
                                 class="mb-8"
                                 :preselect-first="false"></multiselect> -->
                    <featured-image file-label="Featured Image" v-model="post.featured_image"></featured-image>
                    <div class="flex flex-col w-1/4 mb-8">
                        <label class="text-base text-blue uppercase whitespace-no-wrap mr-2 mb-1" for="publishedAt">Publish date: </label>
                        <flat-pickr class="border rounded shadow p-2 h-12 focus:border-blue-light" v-model="post.published_at" placeholder="Choose a publish date" :config="dateConfig"></flat-pickr>
                    </div>
                </div>
                <svg v-if="uploading" class="w-8 inline-block align-middle" xmlns:svg="http://www.w3.org/2000/svg" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.0" width="64px" height="64px" viewBox="0 0 128 128" xml:space="preserve"><path d="M0 128V83h17.25v27.75h93.5V83H128v45H0z" fill="#38c171" fill-opacity="1"/><g><path d="M80.92 210.95v-51.27h18.15L64 113.18l-35.07 46.5h18.15v51.27h33.84z" fill="#38c171" fill-opacity="1"/><animateTransform attributeName="transform" type="translate" from="0 0" to="0 -220" dur="1800ms" repeatCount="indefinite"/></g></svg>
                <button v-else type="submit" class="bg-blue hover:bg-white text-white font-semibold hover:text-blue py-2 px-4 border border-white hover:border-blue rounded mt-4">Create Post</button>
            </form>
        </div>
    </div>
</template>

<script>
    import Post from 'Services/Post';
    import 'flatpickr/dist/flatpickr.css';
    import Multiselect from 'vue-multiselect';
    import Categories from 'Mixins/Categories';
    import flatPickr from 'vue-flatpickr-component';
    import Editor from 'GeneralComponents/Editor.vue';
    import auth from 'Libraries/router/middleware/auth';
    import FeaturedImage from 'Components/form/FeaturedImage.vue';

    export default {
        middleware: [ auth ],
        components: { FeaturedImage, Editor, flatPickr, Multiselect },
        mixins: [ Categories ],
        data () {
            return {
                post: {
                    title: null,
                    summary: null,
                    body: '',
                    featured_image: null,
                    published_at: null,
                },
                dateConfig: {
                    dateFormat: 'Y-m-d',
                    altInput: true,
                    altFormat: 'm/d/Y',
                },
                chosen_categories: [],
                uploading: false,
            }
        },
        created () {
            if (this.categoriesNotAvailable) {
                this.getCategories();
            }
        },
        methods: {
            createPost () {
                this.uploading = true;
                Post.create(this.post).then( () => {
                    this.uploading = false;
                    this.$dispatch('notification', 'Post created!');
                    this.$router.push({ name: 'home' });
                }).catch( () => {
                    this.uploading = false;
                    this.$dispatch('error', 'Problem creating post. Please try again.');
                });
            },
            resetForm () {
                this.$refs.form.reset();
                this.title = null;
            }
        }
    }
</script>

<style scoped lang="scss">
    button {
        bottom: 10px;
        right: 10px;
    }
</style>