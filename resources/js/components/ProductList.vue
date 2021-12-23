<template>
    <div class="container">
        <div class="alert alert-danger" role="alert" v-if="errored">
            Ошибка получения списка товаров.
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Название</th>
                    <th scope="col">Количество</th>
                    <th scope="col">Цена</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(value, key) in productList">
                    <td>{{value.name}}</td>
                    <td>{{value.qnty}}</td>
                    <td>{{value.price}}</td>
                </tr>
            </tbody>
        </table>
        <div class="text-center">
            <div class="spinner-border" role="status" v-if="loaded">
                <span class="visually-hidden"></span>
            </div>
        </div>

    </div>
</template>
<script>
    export default {
		data(){
			return {
				productList: [],
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
				axios.get('/api/v1/shop/list')
					.then(response => {
						return axios.get('/api/v1/product/list');
					})
					.then(response => {
						if(!!response.data.data){
							this.productList = response.data.data;
                        }
					}).catch(error => {
					    console.log(['Error', error]);
					    this.errored = true;
				    })
                    .finally(() =>{
                        this.loaded = false;
                    });
			}

		}
	}
</script>
