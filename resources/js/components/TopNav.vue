<template>
    <header role="banner" class="top-banner">
        <div class="top-banner-container container">
            <div class="mr-6">
                <div class="w-48">
                    <a href="/"><img src="/img/logo.png" alt="Glowing Grace Logo" class="large-logo"></a>
                    <a href="/"><img src="/img/logo_condensed.png" alt="Glowing Grace Logo" class="small-logo"></a>
                </div>
            </div>
            <div class="hamburger-menu-container">
                <button @click.prevent="toggleMenuDropdown()" class="hamburger-menu-button">
                    <svg class="fill-current h-3 w-3" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><title>Menu</title><path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z"/></svg>
                </button>
                <ul v-if="showMenuDropdown" class="dropdown-menu mobile-dropdown-menu">
                    <li class="menu-item mobile-menu-item">
                        <router-link :to="{ name: 'posts' }" @click.native="hideMenuDropdown()" class="mobile-menu-link active-none">
                            <span class="inline-block">Blog</span>
                        </router-link>
                    </li>
                    <!-- <li class="menu-item mobile-menu-item">
                        <router-link :to="{ name: 'store' }" @click.native="hideMenuDropdown()" class="mobile-menu-link active-none">
                            <span class="inline-block">Store</span>
                        </router-link>
                    </li> -->
                    <li class="menu-item mobile-menu-item">
                        <router-link :to="{ name: 'gallery' }" @click.native="hideMenuDropdown()" class="mobile-menu-link active-none">
                            <span class="inline-block">Gallery</span>
                        </router-link>
                    </li>
                    <li class="menu-item mobile-menu-item">
                        <router-link :to="{ name: 'about' }" @click.native="hideMenuDropdown()" class="mobile-menu-link active-none">
                            <span class="inline-block">About</span>
                        </router-link>
                    </li>
                    <!-- <li class="menu-item mobile-menu-item">
                        <router-link :to="{ name: 'cart' }" @click.native="hideMenuDropdown()" class="mobile-menu-link active-none">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="menu-link-icon mr-1"><path class="primary" d="M7 4h14a1 1 0 0 1 .9 1.45l-4 8a1 1 0 0 1-.9.55H7a1 1 0 0 1-1-1V5a1 1 0 0 1 1-1z"></path><path class="primary" d="M17.73 19a2 2 0 1 1-3.46 0H8.73a2 2 0 1 1-3.42-.08A3 3 0 0 1 5 13.17V4H3a1 1 0 1 1 0-2h3a1 1 0 0 1 1 1v10h11a1 1 0 0 1 0 2H6a1 1 0 0 0 0 2h12a1 1 0 0 1 0 2h-.27z"></path></svg>
                            <span class="inline-block">Cart</span>
                        </router-link>
                    </li> -->
                    <div v-if="auth.loggedIn">
                        <li class="menu-item mobile-menu-item">
                            <a id="sm-profile" href="#" @click.prevent="goToProfilePage($event)" class="mobile-menu-link">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="menu-link-icon mr-1"><path class="primary" d="M11 4h3a1 1 0 0 1 1 1v3a1 1 0 0 1-2 0V6h-2v12h2v-2a1 1 0 0 1 2 0v3a1 1 0 0 1-1 1h-3v1a1 1 0 0 1-1.27.96l-6.98-2A1 1 0 0 1 2 19V5a1 1 0 0 1 .75-.97l6.98-2A1 1 0 0 1 11 3v1z"></path><path class="primary" d="M18.59 11l-1.3-1.3c-.94-.94.47-2.35 1.42-1.4l3 3a1 1 0 0 1 0 1.4l-3 3c-.95.95-2.36-.46-1.42-1.4l1.3-1.3H14a1 1 0 0 1 0-2h4.59z"></path></svg>
                                <span class="inline-block">Profile</span>
                            </a>
                        </li>
                        <li class="menu-item mobile-menu-item">
                            <a id="sm-logout" href="#" @click.prevent="doLogout($event)" class="mobile-menu-link">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="menu-link-icon mr-1"><path class="primary" d="M11 4h3a1 1 0 0 1 1 1v3a1 1 0 0 1-2 0V6h-2v12h2v-2a1 1 0 0 1 2 0v3a1 1 0 0 1-1 1h-3v1a1 1 0 0 1-1.27.96l-6.98-2A1 1 0 0 1 2 19V5a1 1 0 0 1 .75-.97l6.98-2A1 1 0 0 1 11 3v1z"></path><path class="primary" d="M18.59 11l-1.3-1.3c-.94-.94.47-2.35 1.42-1.4l3 3a1 1 0 0 1 0 1.4l-3 3c-.95.95-2.36-.46-1.42-1.4l1.3-1.3H14a1 1 0 0 1 0-2h4.59z"></path></svg>
                                <span class="inline-block">Logout</span>
                            </a>
                        </li>
                    </div>
                    <li v-else class="menu-item mobile-menu-item">
                        <router-link :to="{ name: 'login' }" @click.native="hideMenuDropdown()" class="mobile-menu-link active-none">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="menu-link-icon mr-1"><path class="primary" d="M11 4h3a1 1 0 0 1 1 1v3a1 1 0 0 1-2 0V6h-2v12h2v-2a1 1 0 0 1 2 0v3a1 1 0 0 1-1 1h-3v1a1 1 0 0 1-1.27.96l-6.98-2A1 1 0 0 1 2 19V5a1 1 0 0 1 .75-.97l6.98-2A1 1 0 0 1 11 3v1z"></path><path class="primary" d="M18.59 11l-1.3-1.3c-.94-.94.47-2.35 1.42-1.4l3 3a1 1 0 0 1 0 1.4l-3 3c-.95.95-2.36-.46-1.42-1.4l1.3-1.3H14a1 1 0 0 1 0-2h4.59z"></path></svg>
                            <span class="inline-block">Login</span>
                        </router-link>
                    </li>
                </ul>
            </div>
            <nav class="nav-menu-container" role="navigation">
                <ul class="nav-menu">
                    <div class="flex justify-between">
                        <li class="flex-1 menu-item">
                            <router-link :to="{ name: 'posts' }" class="menu-link">Blog</router-link>
                        </li>
                        <!-- <li class="flex-1 menu-item">
                            <router-link :to="{ name: 'store' }" class="menu-link">Store</router-link>
                        </li> -->
                        <li class="flex-1 menu-item">
                            <router-link :to="{ name: 'gallery' }" class="menu-link">Gallery</router-link>
                        </li>
                        <li class="flex-1 menu-item">
                            <router-link :to="{ name: 'about' }" class="menu-link">
                                <span class="mr-1 inline-block">About</span>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="menu-link-icon"><path class="secondary" d="M12 2a10 10 0 1 1 0 20 10 10 0 0 1 0-20z"></path><path class="primary hover-white" d="M11 12a1 1 0 0 1 0-2h2a1 1 0 0 1 .96 1.27L12.33 17H13a1 1 0 0 1 0 2h-2a1 1 0 0 1-.96-1.27L11.67 12H11zm2-4a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3z"></path></svg>
                            </router-link>
                        </li>
                        <!-- <li class="flex-1 menu-item">
                            <router-link :to="{ name: 'cart' }" class="active-none menu-link">
                                <span class="mr-1 inline-block">Cart</span>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="menu-link-icon"><path class="secondary" d="M7 4h14a1 1 0 0 1 .9 1.45l-4 8a1 1 0 0 1-.9.55H7a1 1 0 0 1-1-1V5a1 1 0 0 1 1-1z"></path><path class="secondary" d="M17.73 19a2 2 0 1 1-3.46 0H8.73a2 2 0 1 1-3.42-.08A3 3 0 0 1 5 13.17V4H3a1 1 0 1 1 0-2h3a1 1 0 0 1 1 1v10h11a1 1 0 0 1 0 2H6a1 1 0 0 0 0 2h12a1 1 0 0 1 0 2h-.27z"></path></svg>
                            </router-link>
                        </li> -->
                    </div>
                    <div class="flex ml-auto">
                        <li v-if="auth.loggedIn" class="flex-2 relative menu-item">
                            <a href="#" class="menu-link" @click="toggleLoginDropdown()">
                                <span class="mr-1 inline-block">{{ auth.user.name }}</span>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="menu-link-icon"><path class="secondary" d="M12 12a5 5 0 1 1 0-10 5 5 0 0 1 0 10z"></path><path class="secondary" d="M21 20v-1a5 5 0 0 0-5-5H8a5 5 0 0 0-5 5v1c0 1.1.9 2 2 2h14a2 2 0 0 0 2-2z"></path></svg>
                            </a>
                            <ul v-if="showLoginDropdown" class="dropdown-menu login-dropdown-menu">
                                <li href="#" class="dropdown-menu-item">
                                    <a id="lg-logout" href="#" @click.prevent="doLogout($event)" class="dropdown-link">
                                        <span class="mr-1 inline-block">Logout</span>
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="menu-link-icon"><path class="primary" d="M11 4h3a1 1 0 0 1 1 1v3a1 1 0 0 1-2 0V6h-2v12h2v-2a1 1 0 0 1 2 0v3a1 1 0 0 1-1 1h-3v1a1 1 0 0 1-1.27.96l-6.98-2A1 1 0 0 1 2 19V5a1 1 0 0 1 .75-.97l6.98-2A1 1 0 0 1 11 3v1z"></path><path class="primary" d="M18.59 11l-1.3-1.3c-.94-.94.47-2.35 1.42-1.4l3 3a1 1 0 0 1 0 1.4l-3 3c-.95.95-2.36-.46-1.42-1.4l1.3-1.3H14a1 1 0 0 1 0-2h4.59z"></path></svg>
                                    </a>
                                </li>
                                <li href="#" class="dropdown-menu-item">
                                    <a id="lg-profile" href="#" @click.prevent="goToProfilePage($event)" class="dropdown-link">
                                        <span class="mr-1 inline-block">Profile</span>
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="menu-link-icon"><path class="primary" d="M12 12a5 5 0 1 1 0-10 5 5 0 0 1 0 10z"></path><path class="primary" d="M21 20v-1a5 5 0 0 0-5-5H8a5 5 0 0 0-5 5v1c0 1.1.9 2 2 2h14a2 2 0 0 0 2-2z"></path></svg>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li v-else class="flex-1 menu-item">
                            <router-link :to="{ name: 'login' }" class="sm:w-1/3 lg-w-full menu-link">
                                <span class="mr-1 inline-block">Login</span>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="menu-link-icon"><path class="secondary" d="M13 4V3a1 1 0 0 1 1.27-.96l6.98 2A1 1 0 0 1 22 5v14a1 1 0 0 1-.75.97l-6.98 2A1 1 0 0 1 13 21v-1h-3a1 1 0 0 1-1-1v-2a1 1 0 0 1 2 0v1h2V6h-2v1a1 1 0 0 1-2 0V5a1 1 0 0 1 1-1h3z"></path><path class="secondary" d="M7.59 11l-1.3-1.3c-.94-.94.47-2.35 1.42-1.4l3 3a1 1 0 0 1 0 1.4l-3 3c-.95.95-2.36-.46-1.42-1.4L7.6 13H3a1 1 0 0 1 0-2h4.59z"></path></svg>
                            </router-link>
                        </li>
                    </div>
                </ul>
            </nav>
        </div>
    </header>
</template>

<script>
    import User from 'Services/User';

    export default {
        data () {
            return {
                showLoginDropdown: false,
                showMenuDropdown: false,
            }
        },
        store: ['auth'],
        methods: {
            toggleLoginDropdown () {
                this.showLoginDropdown = ! this.showLoginDropdown;
            },
            toggleMenuDropdown () {
                this.showMenuDropdown = ! this.showMenuDropdown;
            },
            doLogout (e) {
                if (e.target.id == 'lg-logout') {
                    this.toggleLoginDropdown();
                } else {
                    this.toggleMenuDropdown();
                }

                User.logout().then( () => {
                    this.$dispatch('notification', 'Successfully logged out!');
                });
                this.$router.push({ name: 'home' });
            },
            goToProfilePage (e) {
                if (e.target.id == 'lg-profile') {
                    this.toggleLoginDropdown();
                } else {
                    this.toggleMenuDropdown();
                }
                this.toggleLoginDropdown();
                this.$router.push({ name: 'profile' });
            },
            hideMenuDropdown () {
                this.toggleMenuDropdown();
            }
        }
    }
</script>

<style scoped lang="scss">
    .top-banner {
        @apply .bg-blue .mb-32;
        height: 140px;
    }
    .top-banner-container {
        @apply .flex .justify-between .items-center .pt-22;
        @screen lg {
            @apply .pt-12;
        }
    }
    .nav-menu-container {
        @apply .hidden .pl-12 .-mt-22;
        @screen lg {
            @apply .flex .flex-1;
        }
    }
    .nav-menu {
        @apply .flex .list-reset .w-full;
        margin-top: 14px;
    }
    .large-logo {
        @apply .hidden .border-4 .border-white .shadow-md .rounded-lg;
        @screen lg {
            @apply .block;
        }
    }
    .small-logo {
        @apply .block .border-4 .border-white .shadow-md .rounded-lg;
        @screen lg {
            @apply .hidden;
        }
    }
    .hamburger-menu-container {
        @apply  .flex .flex-col .absolute;
        top: 1em;
        right: 1em;
        @screen lg {
            @apply .hidden;
        }
    }
    .hamburger-menu-button {
        @apply .flex .items-center .px-3 .py-2 .border-2 .rounded .text-green-lighter .border-green-light;
        &:hover {
            @apply .text-white .border-white;
        }
    }
    .dropdown-menu {
        @apply .block .absolute .list-reset .text-left .w-48 .border .border-grey .bg-grey-lightest .shadow-md .z-50;
    }
    .login-dropdown-menu {
        top: 48px;
        left: 10%;
    }
    .mobile-dropdown-menu {
        @apply .flex .flex-col;
        top: 32px;
        right: 60px;
    }
    .menu-item {
        @apply .text-center .h-8 .cursor-pointer;
    }
    .mobile-menu-item {
        @apply .text-left .h-16 .leading-loose .border-b .border-grey-light;
        &:hover {
            @apply .bg-green-light;
            .mobile-menu-link {
                @apply .text-white;
            }
            .mobile-menu-link .menu-link-icon path {
                fill: #F8FAFC;
            }
        }
    }
    .dropdown-menu-item {
        @apply .h-12 .p-2 .cursor-pointer .border-b .border-grey-light;
        line-height: 2em;
        &:hover {
            @apply .bg-green-light;
            .dropdown-link {
                @apply text-white;
            }
            .dropdown-link svg path {
                fill: #F8FAFC;
            }
        }
    }
    .menu-link {
        @apply .w-full .text-white .font-lato .font-semibold .uppercase .align-middle .block .no-underline .p-4 .whitespace-no-wrap .tracking-wide;
        &:hover {
            @apply .text-green-lighter;
            .menu-link-icon path {
                fill: #51d88a;
            }
            .menu-link-icon path.hover-white {
                fill: #F8FAFC;
            }
        }
    }
    .mobile-menu-link {
        @apply .w-full .text-green-light .font-lato .font-normal .uppercase .align-middle .block .no-underline .p-4;
    }
    .dropdown-link {
        @apply .text-green-light font-normal uppercase block;
    }
    .menu-link-icon {
        @apply .align-middle .inline-block -mt-1;
        height: 18px;
    }
    .dropdown-link-icon {
        @apply .align-middle .inline-block;
        height: 18px;
    }
    .router-link-active {
        border-bottom: 6px solid #a2f5bf;
    }
    .active-none {
        border-bottom: none !important;
    }
</style>