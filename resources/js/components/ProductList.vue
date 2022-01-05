<template>
    <div class="container">
        <div class="alert alert-danger" role="alert" v-if="errored">
            Ошибка получения списка товаров.
        </div>
        <div class="text-center">
            <div class="spinner-border" role="status" v-if="loaded">
                <span class="visually-hidden"></span>
            </div>
        </div>
        <div v-for="(shop, shopKey) in shopList">
            <h1 class="bd-title" >{{shop.name}}</h1>
            <p>Время работы с {{shop.working_time_open}} по {{shop.working_time_close}}. <a :href="'//'+shop.url" target="_blank">{{shop.url}}</a></p>
            <table class="table">
                <thead>
                <tr>
                    <th width="5%" scope="col">#</th>
                    <th width="20%" scope="col">Название</th>
                    <th width="20%" scope="col">Цена</th>
                    <th width="60%" scope="col">Описание</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(productKey, key) in shopProductLinks[shop.id]">
                    <td><router-link :to="{name: 'product-edit', params: {productId: productList[productKey].id}}"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                        <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                        <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                    </svg></router-link></td>
                    <td>{{productList[productKey].name}}</td>
                    <td>{{productList[productKey].price}}</td>
                    <td><div v-html="productList[productKey].description"></div></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
<script>
    export default {
		data(){
			return {
				productList: [],
				shopList: [],
				shopProductLinks: {},
                errored: false,
				loaded: false,
			}
		},
    	mounted() {
			this.initProductList();
		},
		methods: {
			initProductList() {
				this.errored = false;
				this.loaded = true;
				this.productList = [];
				this.shopList = [];
				this.shopProductLinks = {};
				axios.get('/api/v1/shop')
					.then(response => {
						if(!!response.data.data){
							this.shopList = response.data.data;
							for (let i = 0; i < this.shopList.length; i++){
								this.shopProductLinks[this.shopList[i].id] = [];
                            }
						}
						return axios.get('/api/v1/product');
					})
					.then(response => {
						if(!!response.data.data){
							this.productList = response.data.data;
							for (let i = 0; i < this.productList.length; i++){
								this.shopProductLinks[this.productList[i].shop_id].push(i);
							}
                        }
					}).catch(error => {
					    this.errored = true;
				    })
                    .finally(() =>{
                        this.loaded = false;
                    });
			}

		}
	}
</script>
