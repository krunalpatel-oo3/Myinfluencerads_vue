require('./bootstrap');
import Vue from 'vue';
import VueFormulate from '@braid/vue-formulate'
import Toast from "vue-toastification";
import store from './vuex'

import "vue-toastification/dist/index.css";

import VueRouter from "vue-router";
import {routes} from './routes';
import common from "./common";
// import './axios/interceptors'

import mainapp from './components/MainApp.vue';

Vue.use(Toast, {
    transition: "Vue-Toastification__fade",
    maxToasts: 20,
    newestOnTop: true
});
Vue.use(VueRouter);
Vue.mixin(common);
Vue.use(VueFormulate);


import VModal from 'vue-js-modal' // https://github.com/euvl/vue-js-modal
Vue.use(VModal, { dialog: true })

import FullpageModal from 'vue-fullpage-modal'

Vue.use(FullpageModal)

const NODE_ENV = "dev";

// const origin = window.location.origin;

const origin = 'https://eros.narola.online:551/pma3/hde/data/streamgeeks';
export const bus = new Vue();

window.home_url = origin;
window.base_url = origin + "/public/";
window.image_path = origin + "/public/uploads/";
window.local_image_path = origin + "/public/frontassets/images/";
window.api_path = origin + "/api/";

window.isAuthenticated = localStorage.getItem("sgtoken") != null;

if (localStorage.getItem("sgtoken") != null) {
    store.state.isAuthenticated = true
    store.state.token = localStorage.getItem("sgtoken")
}

window.linkedin_callback = origin + "/linkedin_callback";
const router = new VueRouter({
    base: 'pma3/hde/data/streamgeeks/',
    routes,
    mode : 'history'
})

router.beforeEach((to, from, next) => {
    if (to.meta.requiresAuth && !localStorage.getItem("sgtoken")) {
        Vue.$toast.error("To access this page, you have to login first");
        setTimeout(() => {
            router.push({ name: 'Home' });
        }, 2000);
    } else {
        next()
    }
})


const app = new Vue({
    el: "#app_wrapper",
    router,
    mixins: [common],
    store: store,
    components: {
        mainapp
    },
});
