//require('./bootstrap');

import Vue from "vue";
import VueRouter from "vue-router";
//import axios from "axios";
window.axios = require('axios');

Vue.use(VueRouter);



import App from "./components/App";
import ProductList from "./components/ProductList";
import ExportProducts from "./components/ExportProducts";
import ProductEdit from "./components/product/Edit";

//Vue.component('app', require('./components/App').default);

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'product-list',
            component: ProductList
        }
        ,{
            path: '/export',
            name: 'export-product',
            component: ExportProducts
        }
        ,{
            path: '/product/:productId',
            name: 'product-edit',
            component: ProductEdit,
            props: true
        }
    ]
});

const app = new Vue({
    el: '#app',
    components: {App},
    router
});

//*/
