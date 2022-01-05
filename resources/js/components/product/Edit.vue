<template>
    <div class="container">
        <div class="alert alert-danger" role="alert" v-if="errored">
            Ошибка запроса к товару.
            <p v-if="!!errorMessage">{{errorMessage}}</p>
        </div>
        <div class="text-center">
            <div class="spinner-border" role="status" v-if="loaded">
                <span class="visually-hidden"></span>
            </div>
        </div>
        <div v-if="!loaded">
            <div class="text-center">
                <div class="spinner-border" role="status" v-if="loaded">
                    <span class="visually-hidden"></span>
                </div>
            </div>
            <div class="mb-3">
                <label for="name" class="form-label">Название</label>
                <input type="text" class="form-control" id="name" v-model="name">
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Цена</label>
                <input type="number" class="form-control" id="price" v-model="price">
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Описание</label>
                <textarea class="form-control" id="description" rows="3" v-model="description"></textarea>
            </div>
            <div class="btn-group" role="group" aria-label="action-buttons">
                <button type="button" class="btn btn-success" v-on:click="save()">Сохранить</button>
                <button type="button" class="btn btn-outline-primary" v-on:click="cancel()">Отмена</button>
            </div>
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
				description: '',
				price: 0,
				errored: false,
				loaded: false,
                errorMessage: ''
            }
        },
        mounted() {
            this.initProduct();
		},
		methods: {
			initProduct(){
				this.loaded = true;
				this.errorMessage = '';
				axios.get('/api/v1/product/' + this.productId)
					.then(response => {
						if(!!response.data.data){
							this.name = response.data.data.name;
							this.description = response.data.data.description;
							this.price = parseFloat(response.data.data.price);
						}
					}).catch(error => {
                        this.errored = true;
                    })
					.finally(() =>{
						this.loaded = false;
					});
            },
            save(){
				this.loaded = true;
				this.errorMessage = '';
				axios.post('/api/v1/product/' + this.productId, {
					_method: 'PUT',
                    name: this.name,
					description: this.description,
					price: this.price
                })
					.then(response => {
						this.$router.push({name: 'product-list'});
					})
                    .catch(error => {
                        this.errored = true;
						this.errorMessage = '';
						if(!!error.response.data.errors){
							for(let errorKey in error.response.data.errors){
								this.errorMessage += error.response.data.errors[errorKey].join(' ') + ' ';
                            }
                        }
                    })
					.finally(() =>{
						this.loaded = false;
					});

            },
            cancel(){
				this.$router.push({name: 'product-list'});
			}
        }
	}
</script>
