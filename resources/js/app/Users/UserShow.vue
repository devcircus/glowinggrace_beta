<template>
    <div>
        <div v-if="user" class="user-container">
            <div class="user-header">
                <div class="user-avatar">
                    <div class="relative cursor-pointer">
                        <img style='display: none' onload="this.style.display = 'block'"  :src="transformedAvatar" class="rounded-full mt-8 w-160p h-160p"/>
                        <div class="overlay w-160p h-160p rounded-full bg-black opacity-75 text-xl">
                            <input @change="changeProfileAvatar($event)" type="file" ref="avatar" style="width:0; height:0; position:fixed; top:-100em">
                            <div class="btn-1 bg-green mt-2 px-4 cursor-pointer inline-block relative h-8 rounded-lg">
                                <span @click.prevent="$refs.avatar.click()" class="text-sm font-semibold text-green-lightest">change</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="user-details w-full h-auto">
                <div class="flex flex-col px-4 rounded-b-lg">
                    <div class="flex w-full h-full pb-4 pt-20 lg:pt-4 border-b border-grey-light">
                        <div class="flex flex-col">
                            <h1 class="text-2xl text-grey-darkest leading-none">{{ user.name }}</h1>
                            <span class="text-sm text-grey-dar mb-8">{{ user.email }}</span>
                            <div class="mb-4">
                                <div class="flex">
                                    <input class="w-64 h-8 px-2 border border-grey-light shadow rounded-lg mb-4 mr-2" type="text" v-model="user.email" placeholder="New Email"/>
                                    <button @click.prevent="changeEmail()" type="button" class="text-sm border border-blue bg-white text-blue rounded hover:bg-blue hover:border-transparent hover:text-white align-middle h-8 px-4">Change Email</button>
                                </div>
                                <div class="flex">
                                    <input class="w-64 h-8 px-2 border border-grey-light shadow rounded-lg mr-2" type="password" v-model="user.password" placeholder="New Password"/>
                                    <button @click.prevent="changePassword()" type="button" class="text-sm border border-blue bg-white text-blue rounded hover:bg-blue hover:border-transparent hover:text-white align-middle h-8 px-4">Change Password</button>
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-col ml-auto">
                            <span class="text-lg font-semibold text-grey-darkest"># of posts: <span class="italic font-normal">{{ user.posts_count }}</span></span>
                        </div>
                    </div>
                    <div class="flex flex-col w-full h-full py-4">
                        <div v-for="post in user.posts" :key="post.id" class="border-b broder-grey-light py-4">
                            <h1 class="text-base text-grey-darkest uppercase mb-2">{{ post.title }}</h1>
                            <p class="text-sm text-grey-darker">{{ post.summary }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div v-else>
            <h2 class="text-lg text-blue font-normal uppercase">No Authenticated User Found</h2>
        </div>
    </div>
</template>

<script>
    import User from 'Services/User';
    import auth from 'Libraries/router/middleware/auth';

    export default {
        middleware: [ auth ],
        store: {
            user: 'auth.user',
            loggedIn: 'auth.loggedIn'
        },
        data () {
            return {
                cloud: null,
                changedAvatar: null,
            }
        },
        created () {
            /* global cloudinary */
            this.cloud = cloudinary.Cloudinary.new({
                cloud_name: 'phpstage'
            });
        },
        computed: {
            transformedAvatar () {
                const filename = /[^/]*$/.exec(this.user.avatar)[0];
                if (filename === 'user.png') {
                    return this.user.avatar;
                }

                return this.cloud.url(`profiles/${filename}`, {transformation: [
                    {width: 400, height: 400, gravity: "face", radius: "max", crop: "fill"},
                    {width: 160, height: 160, crop: "scale"}
                ]});
            }
        },
        methods: {
            goToEditUserPage () {
                this.$router.push({ name: 'edit-user' });
            },
            changeProfileAvatar (e) {
                const avatar = e.target.files[0];
                if (avatar) {
                    User.changeProfileAvatar(avatar).then( response => {
                        this.user.avatar = response;
                        this.$dispatch('notification', 'Avatar updated!');
                    });
                } else {
                    console.log('No image chosen');
                }
            },
            changeEmail () {
                console.log('changing email');
            },
            changePassword () {
                console.log('changing password');
            }
        }
    }
</script>

<style scoped lang="scss">
    .user-container {
        @apply .flex .flex-col .w-full .shadow-md .bg-white .rounded-lg .mb-4 .overflow-hidden;
        height: auto;
        transition: all ease 0.3s;
    }
    .user-header {
        @apply .flex .justify-center .bg-blue .rounded-t-lg .h-32 .p-4 .w-full;
    }
    .user-avatar {
        @apply .z-10;
        &:hover {
            .overlay {
                display: block;
            }
        }
    }
    .overlay {
        position: absolute;
        top: 0;
        right: 0;
        display: none;
        padding-top: 3rem;
        text-align: center;
        vertical-align: middle;
    }
    .btn-1 {
        line-height: 1.35em;
        &:hover {
            background-color: darken(#38C172, 10%);
            top: 2px;
        }
    }
    .user-details-inner {

    }
    div.styled {
        margin-top: 40px;
        margin-bottom: 20px;
        height: 2px;
        background: #400CE8;
        background: -webkit-linear-gradient(left, rgba(64,12,232,0) 0%,rgba(77,61,188,1) 10%,rgba(131,255,13,1) 50%,rgba(77,61,188,1) 90%,rgba(64,12,232,0) 100%);
    }
</style>