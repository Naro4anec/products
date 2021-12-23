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
        <div class="mb-3">
            <label for="name" class="form-label">Название товара</label>
            <input type="text" class="form-control" id="name" v-model="name">
        </div>
    </div>
</template>

<script>
	export default {
		props: [
			'productId'
        ],
        data() {
            return {
            	name: '',
				errored: false,
				loaded: false,
            }
        },
        mounted() {
            this.initProduct();
            console.log(['Mounted Edit Prod', this.productId]);
		},
		methods: {
			initProduct(){
				axios.get('/api/v1/product/item/' + this.productId)
					.then(response => {
						if(!!response.data.data){
							this.shopList = response.data.data;
							for (let i = 0; i < this.shopList.length; i++){
								this.shopProductLinks[this.shopList[i].id] = [];
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
