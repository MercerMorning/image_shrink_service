/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
window.Cropper = require('cropperjs');
window.Vue = require('vue').default;

import VueRouter from 'vue-router';
import Vuex from 'vuex'

window.Vue.use(VueRouter);
window.Vue.use(Vuex);

const store = new Vuex.Store({
    state: {
        auth: false,
        token: null
    },
    mutations: {
        login (state) {
            state.auth = true
        }
    },
    getters: {
        isLoggedIn: function (state) {
            return state.auth;
        }
    }
    // mutations: {
    //     increment (state) {
    //         state.count++
    //     }
    // }
})

import ImageForm from './components/Image/FormComponent.vue';
import LoginForm from './components/LoginFormComponent.vue';
import RegisterForm from './components/RegisterFormComponent.vue';
import Main from './components/MainComponent.vue';
import NotFound from './components/NotFound.vue';

import guest from './middleware/guest'
import auth from './middleware/auth'
import middlewarePipeline from './middlewarePipeline'

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

const routes = [
    {
        path: '/registration',
        component: RegisterForm,
        name: 'registerForm',
        meta: {
            middleware: [
                guest
            ]
        }
    },
    {
        path: '/login',
        component: LoginForm,
        name: 'loginForm',
        meta: {
            middleware: [
                guest
            ]
        }
    },
    {
        path: '/optimize',
        component: ImageForm,
        name: 'optimize',
        meta: {
            middleware: [
                auth
            ]
        },
    },
   {
        path: '*',
        component: NotFound,
    }

]

Vue.component('main-component', Main);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const router = new VueRouter({  mode: 'history', routes })

router.beforeEach((to, from, next) => {
    if (!to.meta.middleware) {
        return next()
    }
    const middleware = to.meta.middleware
    const context = {
        to,
        from,
        next,
        store
    }
    return middleware[0]({
        ...context,
        next: middlewarePipeline(context, middleware, 1)
    })
})

const app = new Vue({
    el: '#app',
    router: router,
    store: store,
});
// const app = new Vue({ router }).$mount('#app')
