<template>
    <div v-if="post.id" class="bg-white p-8 shadow mb-8">
        <h1 class="text-3xl font-normal text-blue uppercase mb-4">Edit your post</h1>
        <form ref="form" method="POST" @submit.prevent="updatePost()" enctype="multipart/form-data">
            <div class="flex flex-col">
                <input class="shadow appearance-none border rounded w-full text-black leading-tight focus:outline-none focus:border-blue p-2 mb-4" id="title" type="text" placeholder="Give your post a title" v-model="post.title">
                <textarea placeholder="Provide a brief summary" rows="5" class="text-black p-2 mb-4 bg-white border rounded shadow w-full" v-model="post.summary"></textarea>
                <editor placeholder="Now write to the world..." v-model="post.body"></editor>
                <div v-if="existing_featured_image" class="flex flex-col mt-4">
                    <span class="text-base text-blue uppercase whitespace-no-wrap mb-2">Current Featured Image:</span>
                    <img class="mr-2 mb-2 border-2 border-black rounded shadow w-160p h-auto" :src="existing_featured_image.thumb_size_url"/>
                    <button @click.prevent="deleteCurrentFeaturedImage()"
                            class="block w-24 h-6 bg-transparent no-underline leading-normal hover:bg-red text-red font-normal text-sm hover:text-white px-2 mb-8 border border-red hover:border-transparent rounded danger_parent_reverse primary_parent_flip">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-4 h-4 mr-2 icon-close-circle inline-block align-middle"><circle cx="12" cy="12" r="10" class="danger"></circle><path class="danger" d="M13.41 12l2.83 2.83a1 1 0 0 1-1.41 1.41L12 13.41l-2.83 2.83a1 1 0 1 1-1.41-1.41L10.59 12 7.76 9.17a1 1 0 0 1 1.41-1.41L12 10.59l2.83-2.83a1 1 0 0 1 1.41 1.41L13.41 12z"></path></svg>
                        <span class="inline-block leading-none">Delete</span>
                    </button>
                </div>
                <featured-image file-label="Set Featured Image" v-model="post.featured_image"></featured-image>
                <div class="flex w-1/4 content-center items-center">
                    <label class="text-base text-blue uppercase whitespace-no-wrap mr-2" for="publishedAt">Publish date: </label>
                    <flat-pickr class="border rounded shadow p-2" v-model="post.published_at" placeholder="Choose a publish date" :config="dateConfig"></flat-pickr>
                </div>
            </div>
            <svg v-if="uploading" class="w-8 inline-block align-middle" xmlns:svg="http://www.w3.org/2000/svg" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.0" width="64px" height="64px" viewBox="0 0 128 128" xml:space="preserve"><path d="M0 128V83h17.25v27.75h93.5V83H128v45H0z" fill="#38c171" fill-opacity="1"/><g><path d="M80.92 210.95v-51.27h18.15L64 113.18l-35.07 46.5h18.15v51.27h33.84z" fill="#38c171" fill-opacity="1"/><animateTransform attributeName="transform" type="translate" from="0 0" to="0 -220" dur="1800ms" repeatCount="indefinite"/></g></svg>
            <button v-else type="submit" class="bg-blue hover:bg-white text-white font-semibold hover:text-blue py-2 px-4 border border-white hover:border-blue rounded mt-4">
                Update
            </button>
        </form>
    </div>
</template>

<script>
    import Post from 'Services/Post';
    import 'flatpickr/dist/flatpickr.css';
    import { isEmpty, findIndex } from 'lodash';
    import flatPickr from 'vue-flatpickr-component';
    import Editor from 'GeneralComponents/Editor.vue';
    import auth from 'Libraries/router/middleware/auth';
    import FeaturedImage from 'Components/form/FeaturedImage.vue';

    export default {
        middleware: [ auth ],
        props: ['post-id'],
        store: ['posts'],
        components: { FeaturedImage, Editor, flatPickr },
        data () {
            return {
                post: {
                    id: null,
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
                existing_featured_image: null,
                uploading: false,
            }
        },
        computed: {
            postsAvailable () {
                return ! isEmpty (this.posts);
            },
        },
        created () {
            if (! this.postsAvailable) {
                Post.all().then( () => {
                    this.setPost();
                });
            } else {
                this.setPost();
            }
        },
        beforeDestroy () {
            this.post.featured_image = this.existing_featured_image;
        },
        methods: {
            updatePost () {
                this.uploading = true;
                Post.update(this.post).then( () => {
                    this.uploading = false;
                    this.$dispatch('notification', 'Post updated!');
                    this.$router.push({ name: 'home' });
                }).catch( () => {
                    this.uploading = false;
                    this.$dispatch('error', 'Problem updating post. Please try again.');
                });
            },
            setPost () {
                const index = findIndex(this.posts, post =>  post.id == this.postId);
                this.post = this.posts[index];
                if (this.post.featured_image) {
                    this.existing_featured_image = this.post.featured_image;
                }
                this.post.featured_image = null;
            },
            deleteCurrentFeaturedImage () {
                Post.deleteFeaturedImage(this.post.id).then( () => {
                    this.existing_featured_image = null;
                    this.$dispatch('notification', 'Featured Image Deleted!');
                }).catch( () => {
                    this.$dispatch('error', 'Problem deleting the featured image.');
                });
            }
        }
    }
</script>

<style>
    #deleteButton {
        line-height: 1.4em;
    }
    .icon-close-circle {
        margin-top: -1px;
    }
</style>