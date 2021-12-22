import VueRouter from 'vue-router';
import ProductList from './components/ProductList';

export default new VueRouter({
   routes : [
       {
           path: '/',
           comment: ProductList
       }
   ]
   ,mode: 'history'
});
