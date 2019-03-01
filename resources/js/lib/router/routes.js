import LoginPage from 'App/Auth/LoginPage.vue';
import AboutPage from 'App/About/AboutPage.vue';
import PostNew from 'App/Posts/PostNew.vue';
import PostIndex from 'App/Posts/PostIndex.vue';
import PostShow from 'App/Posts/PostShow.vue';
import PostEdit from 'App/Posts/PostEdit.vue';
import UserNew from 'App/Users/UserNew.vue';
import UserIndex from 'App/Users/UserIndex.vue';
import UserShow from 'App/Users/UserShow.vue';
import UserEdit from 'App/Users/UserEdit.vue';
import StoreIndex from 'App/Store/StoreIndex.vue';
import GalleryIndex from 'App/Gallery/GalleryIndex.vue';

export const routes = [
    {
        path: '/',
        name: 'home',
        component: PostIndex,
        meta: {
            group: 'posts',
        },
    },
    {
        path: '/posts',
        name: 'posts',
        component: PostIndex,
        meta: {
            group: 'posts',
        },
    },
    {
        path: '/posts/new',
        name: 'new-post',
        component: PostNew,
        meta: {
            group: 'posts',
        },
    },
    {
        path: '/posts/:postId',
        name: 'show-post',
        component: PostShow,
        props: true,
        meta: {
            group: 'posts',
        },
    },
    {
        path: '/posts/edit/:postId',
        name: 'edit-post',
        component: PostEdit,
        props: true,
        meta: {
            group: 'posts',
        },
    },
    {
        path: '/users',
        name: 'users',
        component: UserIndex,
        meta: {
            group: 'users',
        },
    },
    {
        path: '/users/new',
        name: 'new-user',
        component: UserNew,
        meta: {
            group: 'users',
        },
    },
    {
        path: '/profile',
        name: 'profile',
        component: UserShow,
        meta: {
            group: 'users',
        },
    },
    {
        path: '/profile/edit',
        name: 'edit-user',
        component: UserEdit,
        meta: {
            group: 'users',
        },
    },
    {
        path: '/login',
        name: 'login',
        component: LoginPage,
        meta: {
            group: 'auth',
        },
    },
    {
        path: '/gallery',
        name: 'gallery',
        component: GalleryIndex,
        meta: {
            group: 'gallery',
        },
    },
    {
        path: '/about',
        name: 'about',
        component: AboutPage,
        meta: {
            group: 'about',
        },
    },
    {
        path: '/cart',
        name: 'cart',
        component: StoreIndex,
        meta: {
            group: 'cart',
        },
    },
    {
        path: '/store',
        name: 'store',
        component: StoreIndex,
        meta: {
            group: 'store',
        },
    },

    // otherwise redirect to home
    {
        path: '*',
        name: 'catchall',
        redirect: '/',
        meta: {
            group: null,
        },
    }
]