import Vue from 'vue';
import store from 'JS/store';
import router from 'Libraries/router';

// Use Global Mixins
import Dispatchable from '../mixins/Dispatchable';
import Dates from '../mixins/Dates';

Vue.mixin(Dispatchable);
Vue.mixin(Dates);

// import global components
import BaseApp from 'JS/BaseApp.vue';

// Use Vue-Stash for state management
import VueStash from 'vue-stash';
Vue.use(VueStash);

// Use Vue Masonry plugin
import { VueMasonryPlugin } from 'vue-masonry';
Vue.use(VueMasonryPlugin);

// Use Vue-Modal
import VModal from 'vue-js-modal';
Vue.use(VModal, { componentName: "modal-component" });

// Use Snotify for notifications
import Snotify, { SnotifyPosition } from 'vue-snotify';
const options = {
    toast: {
        position: SnotifyPosition.rightTop,
        timeout: 3000,
        showProgressBar: true,
        closeOnClick: false,
        pauseOnHover: true
    }
}
Vue.use(Snotify, options)

// Filters
Vue.filter('ucase', function (value) {
    return value ? value.toUpperCase() : '';
});

new Vue({
    el: '#base-app',
    router,
    data: { store },
    components: { BaseApp },
});