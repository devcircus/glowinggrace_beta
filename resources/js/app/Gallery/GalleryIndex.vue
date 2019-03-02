<template>
    <div class="flex flex-col w-full -ml-2 mb-4">
        <h1 class="post-title text-4xl mb-2 font-normal text-grey-darkest uppercase">Gallery</h1>
        <h2 class="post-title text-xl mb-2 font-normal text-grey-darker uppercase mb-8">Photos from my blog posts</h2>
        <div v-masonry transition-duration="0.3s" item-selector=".item" :gutter="10" :column-width="200">
            <div v-masonry-tile class="item" v-for="image in images" :key="image.id">
                <masonry-card :image="image"></masonry-card>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios';
    import { map } from 'lodash';
    import MasonryCard from 'GeneralComponents/MasonryCard.vue';

    export default {
        components: { MasonryCard },
        data () {
            return {
                cloudinary: null,
                images: [],
            }
        },
        computed: {
            noItems () {
                return ! this.images.length > 0;
            },
        },
        created () {
            /* global cloudinary */
            this.cloudinary = cloudinary.Cloudinary.new({
                cloud_name: 'phpstage'
            });
            this.getImages();
        },
        methods: {
            getImages () {
                axios.get('api/images').then( response => {
                    this.images = map(response.data.images, image => {
                        const imageUrl = this.cloudinary.url(image.name, { width: 200, crop: "fit", quality: 'auto' });

                        return Object.assign(image, { imageUrl });
                    });
                }).catch( error => {
                    console.log(error.response);
                });
            }
        },
    }
</script>