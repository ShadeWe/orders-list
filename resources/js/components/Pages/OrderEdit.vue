<template>
    <div>
        <div class="edit-form-wrap" v-if="!loading">
            <a @click="$router.go(-1)" class='get-back-btn'>Назад</a>
            <div class="edit-form">
                <form @submit="onSubmit">
                    <div class="input-block">
                        <input type="email" placeholder="email" v-model="order_form_data.email">
                        <input type="text" placeholder="partner" v-model="order_form_data.partner">
                        <select name="status" v-model="order_form_data.status">
                            <option value="0">Новый</option>
                            <option value="10">Подтвержден</option>
                            <option value="20">Завершен</option>
                        </select>
                    </div>

                    <div class="products-block-header">Продукты: </div>

                    <div class="products-block">
                        <div v-for="product in order.order_products" :key="product.id" class="product">
                            <div>Название: {{ product.product.name }}</div>
                            <div>Кол-во: {{ product.quantity }}</div>
                            <div>Цена: {{ product.price }}</div>
                        </div>
                    </div>

                    <div class="order-price">
                        Стоимость заказа: {{ order_price }}
                    </div>

                    <div v-if="error_message != ''" class="error-msg">
                        {{ error_message }}
                    </div>

                    <div class="btn-cnt">
                        <button class="submit-btn">
                            {{ button_text }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            
            order_id: this.$route.params.order_id,
            order: {},
            loading: true,
            updating: false,
            updated: false,
            error_message: "",

            order_form_data: {
                email: '',
                partner: '',
                status: null
            }
        }   
    },

    computed: {

        order_price() {
            return this.order.order_products.reduce((accum, item) => accum + item.price, 0);
        },

        button_text() {

            if (this.updating) {
                return 'Загрузка';
            } else if (this.updated) {
                return 'Сохранено';
            } else {
                return 'Применить'
            }
        }

    },

    methods: {

        onSubmit(event) {
            
            event.preventDefault();

            this.error_message = "";
            this.updating = true;

            axios.post("/api/update_order/" + this.order_id, this.order_form_data).then((response) => {
                
                let status = response.data.status;

                if (status) {
                    
                    this.updating = false;
                    this.updated = true;
                    
                    setTimeout(() => {
                        this.updated = false;
                    }, 1500);

                }

            }).catch(error => {

                this.updating = false;
                this.error_message = error.response.data.message;

            });

        }

    },

    mounted() {

        axios.get("/api/get_order/" + this.order_id).then((response) => { 
            this.order_form_data.email = response.data.partner.email;
            this.order_form_data.partner = response.data.partner.name;
            this.order_form_data.status = response.data.status;
            this.order = response.data;
            this.loading = false;
        });

    }
}
</script>

<style>

.error-msg {
    margin-top: 5px;
    color: red;
}

.get-back-btn {
    cursor: pointer;
    box-shadow: 0px 0px 8px rgba(0,0,0,0.3);
    padding: 5px;
    border-radius: 5px;
    margin-bottom: 10px;
    display: block;
    width: 70px;
    text-align: center;
}

.btn-cnt {
    text-align: right;
}

.submit-btn {
    cursor: pointer;
    background-color: rgb(76, 139, 76);
    padding: 10px;
    color: white;
    border: 0;
    border-radius: 4px;
}

.products-block-header {
    margin-bottom: 5px;
}

.products-block .product {
    background-color: rgb(109, 36, 81);
    color: white;
    margin-bottom: 10px;
    padding: 10px;
}

.input-block {
    flex-direction: column;
    display: flex;
}

.input-block input, .input-block select {
    display: block;
    padding: 10px;
    flex-grow: 1;
    margin-bottom: 10px;
}

.edit-form-wrap {
    width: 500px;
    margin: 0 auto;
}

.edit-form {
    padding: 30px;
    box-shadow: 0px 0px 8px rgba(0,0,0,0.3);
}

</style>