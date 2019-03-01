<template>
    <div v-if="post" class="bg-grey-lightest p-4 rounded-lg shadow-md">
        <div class="flex w-full mb-4">
            <div class="flex flex-col w-full">
                <h1 class="post-title text-4xl mb-2 font-normal text-grey-darkest uppercase">{{ post.title }}</h1>
                <span class="text-sm text-grey-dark">published {{ formattedAgoDate(post.published_at) }} by <span class="text-grey-darkest italic">{{ post.user.name }}</span></span>
            </div>
            <router-link :to="{ name: 'edit-post', params: { postId: post.id } }" v-if="auth.loggedIn"
                         class="block w-24 h-6 bg-transparent no-underline leading-normal hover:bg-green text-green font-normal text-sm hover:text-white px-2 ml-auto border border-green hover:border-transparent rounded primary_parent primary_parent_flip active-none">
                <svg xmlns="http://www.w3.org/2000/svg" pointer-events="all" viewBox="0 0 24 24" class="w-4 h-4 mr-2 icon-edit inline-block align-middle"><path d="M4 14a1 1 0 0 1 .3-.7l11-11a1 1 0 0 1 1.4 0l3 3a1 1 0 0 1 0 1.4l-11 11a1 1 0 0 1-.7.3H5a1 1 0 0 1-1-1v-3z"></path><rect width="20" height="2" x="2" y="20" rx="1"></rect></svg>
                <span class="inline-block leading-none">Edit</span>
            </router-link>
        </div>
        <div class="flex flex-col w-full">
            <div ref="postBody" class="post-body mt-4" v-html="post.body"></div>
            <div class="w-full styled"></div>
            <div class="flex flex-col self-center text-center items-center">
                <img v-if="post.featured_image" :src="post.featured_image.full_size_url" class="my-2 rounded-lg shadow-md border-2 border-black"/>
            </div>
        </div>
    </div>
</template>

<script>
    import Posts from 'Mixins/Posts';
    import { findIndex } from 'lodash';

    export default {
        store: ['posts', 'auth'],
        props: ['post-id'],
        mixins: [ Posts ],
        data () {
            return {
                post: null,
                cloud: null,
            }
        },
        created () {
            /* global cloudinary */
            this.cloud = cloudinary.Cloudinary.new({
                cloud_name: 'phpstage',
            });
        },
        mounted () {
            if (this.postsNotAvailable) {
                this.getPosts().then( () => {
                    this.setActivePost();
                    this.$nextTick( () => {
                        this.addPostImageClickListeners();
                    });
                });
            } else {
                this.setActivePost();
                this.$nextTick( () => {
                    this.addPostImageClickListeners();
                });
            }
        },
        methods: {
            setActivePost () {
                const index = findIndex(this.posts, post =>  post.id == this.postId);
                this.post = this.posts[index];
            },
            addPostImageClickListeners () {
                [].map.call(this.$refs.postBody.querySelectorAll('img'), element => {
                    element.style.cursor = 'pointer';
                    const filename = /[^/]*$/.exec(element.src)[0];

                    const url = this.cloud.url(`posts/${filename}`, {transformation: [
                        { width: 'auto', crop: "fill" },
                    ]});
                    element.addEventListener('click', event => {
                        this.$modal.show('post-photo', {
                            postPhoto: url,
                        });
                    });
                });
            }
        }
    }
</script>

<style>
div.styled {
    margin-top: 40px;
    margin-bottom: 20px;
    height: 2px;
    background: #400CE8;
    background: -webkit-linear-gradient(left, rgba(64,12,232,0) 0%,rgba(77,61,188,1) 10%,rgba(131,255,13,1) 50%,rgba(77,61,188,1) 90%,rgba(64,12,232,0) 100%);
}
</style>