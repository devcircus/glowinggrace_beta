<template>
    <div>
        <modal-component name="gallery-photo" width="80%" :maxWidth="1000" :adaptive="true" :delay="250" height="auto" class="text-center center" @before-open="beforeOpenGalleryPhoto($event)">
            <gallery-photo-modal :photo-url="galleryPhotoUrl"></gallery-photo-modal>
        </modal-component>
        <modal-component name="post-photo" width="80%" :maxWidth="1000" :adaptive="true" :delay="250" height="auto" class="text-center center" @before-open="beforeOpenPostPhoto($event)">
            <post-photo-modal :photo-url="postPhotoUrl"></post-photo-modal>
        </modal-component>
    </div>
</template>

<script>
    import GalleryPhotoModal from 'App/Gallery/GalleryPhotoModal.vue';
    import PostPhotoModal from 'App/Posts/PostPhotoModal.vue';

    export default {
        data () {
            return {
                galleryPhotoUrl: null,
                postPhotoUrl: null,
            }
        },
        components: { GalleryPhotoModal, PostPhotoModal },
        methods: {
            beforeOpenGalleryPhoto (event) {
                this.galleryPhotoUrl = event.params.galleryPhoto;
            },
            beforeOpenPostPhoto (event) {
                this.postPhotoUrl = event.params.postPhoto;
            }
        }
    }
</script>

<style>
    .v--modal-overlay[data-modal="gallery-photo"] .v--modal-box.v--modal {
        opacity: 1;
        overflow: visible;
        top: 178px !important;
    }
    .v--modal-overlay[data-modal="post-photo"] .v--modal-box.v--modal {
        opacity: 1;
        overflow: visible;
        top: 178px !important;
    }
</style>