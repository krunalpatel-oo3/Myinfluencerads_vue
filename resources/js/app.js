/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import './bootstrap';
import { createApp } from 'vue';
import { createRouter, createWebHistory } from 'vue-router';
import Toast from "vue-toastification";



const app = createApp(App);
app.use(Toast, {
    transition: "Vue-Toastification__fade",
    maxToasts: 20,
    newestOnTop: true
});
// Import components
import App from './App.vue';
// import header from './components/includes/header.vue';
import home from './components/home.vue';
import Login from './components/authentication/login.vue';
import Register from './components/authentication/Register.vue';
import ForgotPassword from './components/authentication/ForgotPassword.vue';
import Dashboard from './components/Dashboard.vue';
import Manage_Profile from './components/dashboard/manage_profile.vue';

const origin = 'http://127.0.0.1:8000/';

window.home_url = origin;
window.base_url = origin + "public/";
window.image_path = origin + "/public/uploads/";
window.local_image_path = origin + "/public/frontassets/images/";
window.api_path = origin + "/api/";

// import VueSweetalert2 from 'vue-sweetalert2';
// import 'sweetalert2/dist/sweetalert2.min.css';
// Vue.component('myHeader', header);

const router = createRouter({
    history: createWebHistory(),
    routes: [
        { path: '/', component: home },
        { path: '/login', component: Login, meta:{  hideNavbar: true,requireAuth: false} },
        { path: '/register', component: Register,meta:{  hideNavbar: true} },
        { path: '/forgot_password', component: ForgotPassword,meta:{  hideNavbar: true,requireAuth: false} },
        { path: '/dashboard', component: Dashboard,meta:{ hideNavbar: false,requireAuth: true}},
        { path: '/manage-profile', component: Manage_Profile,meta:{ hideNavbar: false,requireAuth: true}},
        // { path: '/products/:id/edit', component: ProductForm },
    ]
});
router.beforeEach((to, from)=>{
    if(to.meta.requireAuth && !localStorage.getItem('token')){
        return {name: 'login'}
    }
    if(to.meta.requireAuth == false && localStorage.getItem('token')){
        return {name: 'dashboard'}
    }

});
app.use(router);

// app.use(VueSweetalert2);

app.mount('#app');
