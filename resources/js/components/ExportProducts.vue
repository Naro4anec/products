<template>
    <div class="container">
        <div class="alert alert-danger" role="alert" v-if="errored">
            <p>Ошибка.<p> <p>{{errorMessage}}</p>
        </div>
        <p>
            Будут выгруженны товары из магазинов, которые открыты в текущий момент времени.
            Описания к товарам не будут содержать HTML теги.
            Формат файла XML.
        </p>
        <div class="alert alert-success" role="alert" v-if="!!fileUrl">
            Экспорт завершен: <a :href="fileUrl" target="_blank" download>Скачать</a>.
        </div>
        <div class="row">
            <div class="d-grid gap-2 mx-auto" v-if="!loaded">
                <button type="button" class="btn btn-success" v-on:click="startExport()">Экспортировать</button>
            </div>
            <div class="text-center">
                <div class="spinner-border" role="status" v-if="loaded">
                    <span class="visually-hidden"></span>
                </div>
            </div>

        </div>
    </div>
</template>

<script>
	export default {
		mounted() {
		},
		data() {
			return {
				errored: false,
				loaded: false,
				errorMessage: '',
                fileUrl: '',
			}
		},
		methods: {
			startExport(){
				this.loaded = true;
				this.errorMessage = '';
				this.fileUrl = '';
				this.errored = false;
				axios.get('/api/v1/shop/export')
					.then(response => {
						if(response.data.status == 'success'){
							this.fileUrl = response.data.url;
                        }else{
							this.errored = true;
							this.errorMessage = response.data.message;
                        }
						console.log(['ex', response]);
					})
                    .catch(error => {
                        this.errored = true;
                    })
					.finally(() =>{
						this.loaded = false;
					});
				console.log('export');
            }
        }
	}
</script>
