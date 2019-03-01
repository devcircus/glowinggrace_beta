import Vue from 'vue';
import Router from 'vue-router';
import beforeEach from './beforeEach';
import { routes } from 'Libraries/router/routes';

Vue.use(Router);

const router = new Router({
    mode: 'history',
    routes,
    scrollBehavior (to, from, savedPosition) {
        if (savedPosition) {
            return savedPosition
        } else {
            return { x: 0, y: 0 }
        }
    }
});

export default router;

router.beforeEach(beforeEach);