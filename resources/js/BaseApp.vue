<template>
    <div class="min-h-screen flex flex-col">
        <vue-snotify class="w-full"></vue-snotify>
        <social-float-bar></social-float-bar>
        <div class="flex flex-col w-full">
            <top-nav></top-nav>
        </div>
        <div class="flex flex-col md:flex-row w-full">
            <main-content></main-content>
        </div>
        <app-modal></app-modal>
    </div>
</template>

<script>
    import TopNav from 'Components/TopNav.vue';
    import MainContent from 'Components/MainContent.vue';
    import AppModal from 'GeneralComponents/AppModal.vue';
    import SocialFloatBar from 'GeneralComponents/SocialFloatBar.vue';

    export default {
        components: { TopNav, MainContent, SocialFloatBar, AppModal },
        created () {
            this.setupListeners();
        },
        methods: {
            setupListeners () {
                this.setupNotificationListeners();
            },
            setupNotificationListeners () {
                this.$listen('notification', message => {
                    this.$snotify.success(message, 'Success!');
                });
                this.$listen('error', message => {
                    this.$snotify.error(message, 'Oops!');
                });
            }
        }
    }
</script>