<template>
    <div class="min-h-screen flex flex-col">
        <vue-snotify class="w-full"></vue-snotify>
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

    export default {
        components: { TopNav, MainContent, AppModal },
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