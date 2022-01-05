<template>
    <div class="container">

        <section class="jumbotron text-center">
            <div class="container ">
                <h1 class="jumbotron-heading">Выгрузка товаров в XML</h1>
                <p class="lead text-muted">Приложение по выгрузке товаров.</p>
                <p>
                    <router-link class="btn btn-primary my-2" :to="{name: 'product-list'}">Список</router-link>
                    <router-link class="btn btn-primary my-2" :to="{name: 'export-product'}">Выгрузка</router-link>
                </p>
            </div>
        </section>
        <div>
            <router-view></router-view>
        </div>
    </div>
</template>

<script>
    export default {
    	data(){
    		return {
    			desks: []
            }
        },
    	mounted() {
		}

	}
</script>
