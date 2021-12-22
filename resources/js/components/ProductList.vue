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

    </div>
</template>
<script>
    export default {
		data(){
			return {
				productList: [],
                errored: false
			}
		},
    	mounted() {
			this.initList();
    		console.log('Component ProductList Mounted');
		},
		methods: {
			initList: function initList() {
				this.errored = false;
				this.productList = [];
				axios.get('/api/v1/products')
					.then(response => {
						if(!!response.data.products){
							this.productList = response.data.products;
                        }
					}).catch(error => {
					    console.log(['Error', error]);
					    this.errored = true;
				    });
			}

		}
	}
</script>
