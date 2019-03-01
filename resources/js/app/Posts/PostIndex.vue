<template>
    <div>
        <div class="relative">
            <span v-if="auth.loggedIn" class="floating-button" @click.prevent="goToNewPostPage()">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-8 icon-add"><path class="secondary" fill-rule="evenodd" d="M17 11a1 1 0 0 1 0 2h-4v4a1 1 0 0 1-2 0v-4H7a1 1 0 0 1 0-2h4V7a1 1 0 0 1 2 0v4h4z"></path></svg>
            </span>
        </div>
        <div>
            <posts-list></posts-list>
        </div>
    </div>
</template>

<script>
    import PostsList from 'App/Posts/partials/PostsList.vue';

    export default {
        components: { PostsList },
        store: ['auth'],
        methods: {
            goToNewPostPage () {
                this.$router.push({ name: 'new-post' });
            },
        }
    }
</script>

<style lang="scss">
    .floating-button {
        background-color: #38C172;
        position: absolute;
        cursor: pointer;
        color: #F8FAFC;
        border-radius: 50%;
        text-align: center;
        z-index: 10;
        padding-top: 0.25em;
        height: 40px;
        width: 40px;
        top: -48px;
        left: calc(100% - 40px);
        box-shadow: 2px 2px 3px #999;
        transition: all ease 0.2s;
        &:hover {
            -moz-box-shadow: none;
            -webkit-box-shadow: none;
            box-shadow: none;
            top: -45px;
        }
    }

    @media (min-width: 768px) {
        .floating-button {
            left: 100%;
        }
    }

</style>