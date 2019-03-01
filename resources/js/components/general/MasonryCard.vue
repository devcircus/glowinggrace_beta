<template>
    <div class="tile">
        <img @click.prevent="showModal()" :src="image.imageUrl" :alt="image.full_size_url">
        <div class="content flex flex-col">
            <h4 class="font-normal text-xs text-grey-darker">from
                <router-link :to="{ name: 'show-post', params: { postId: image.post_id }}" class="no-underline">
                    <span class="italic">{{ image.post_title }}</span>
                </router-link>
            </h4>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['image'],
        name: 'masonry-card',
        methods: {
            showModal () {
                this.$modal.show('gallery-photo', {
                    galleryPhoto: this.image.full_size_url,
                });
            },
        }
    }
</script>

<style scoped>
    .tile {
        margin-bottom: 10px;
        cursor: pointer;
        perspective: 1000;
        -webkit-perspective: 1000;
        backface-visibility: hidden;
        -webkit-backface-visibility: hidden;
        transition: all 100ms ease-in-out;
    }
    .card:hover {
        transform: translateY(-0.5em);
    }
</style>
