<template>
    <div>
        <div class="table-wrap" v-if="!loading">

            <div class="filters">
                <div>
                    <label for="overdue">Все</label>
                    <input type="radio" id="overdue" value="all" name="filter-value" checked v-model="filter">
                </div>
                <div>
                    <label for="overdue">Просроченные</label>
                    <input type="radio" id="overdue" value="overdue" name="filter-value" v-model="filter">
                </div>
                <div>
                    <label for="overdue">Текущие</label>
                    <input type="radio" id="overdue" value="current" name="filter-value" v-model="filter">
                </div>
                <div>
                    <label for="overdue">Новые</label>
                    <input type="radio" id="overdue" value="new" name="filter-value" v-model="filter">
                </div>
                <div>
                    <label for="overdue">Выполненные</label>
                    <input type="radio" id="overdue" value="done" name="filter-value" v-model="filter">
                </div>
            </div>

            <div class="orders-table__header">
                <div class="orders-table__row__col">ID</div>
                <div class="orders-table__row__col">Название партнера</div>
                <div class="orders-table__row__col">Стоимость заказа</div>
                <div class="orders-table__row__col">Наименование состав заказа</div>
                <div class="orders-table__row__col">Статус заказа</div>
            </div>
            <div class="orders-table__row" v-for="order in orders_list" :key="order.id">
                <div class="orders-table__row__col">
                    <router-link :to="{path: '/orders/edit/' + order.id}">{{ order.id }}</router-link>
                </div>
                <div class="orders-table__row__col">{{ order.partner.name }}</div>
                <div class="orders-table__row__col">{{ order.price }}</div>
                <div class="orders-table__row__col">
                    <div v-for="order_product in order.order_products" :key="order_product.id" class="orders-table__product-item">
                        <div>Название: {{ order_product.product.name }}</div>
                        <div>Кол-во: {{ order_product.quantity }}</div>
                        <div>Цена: {{ order_product.price }}</div>
                    </div>
                </div>
                <div class="orders-table__row__col">{{ get_status(order.status) }}</div>
            </div>
        </div>
        <div v-else class="table-wrap">
            Загрузка ...
        </div>
    </div>
</template>

<script>
export default {

    data() {
        return {
            orders: [],
            loading: true,
            filter: "all"
        }
    },

    methods: {

        get_status(status_id) {
            
            let status_list = {
                0: 'Новый',
                10: 'Подтвержден',
                20: 'Завершен'
            };

            return status_list[status_id];
        }

    },

    computed: {

        all() {
            return this.orders;
        },

        overdue() {
            
            var now = new Date();

            var orders = this.orders.filter(val => {
                let date = new Date(val.delivery_dt);
                return val.status == 10 && now >= date;
            });

            orders = orders.sort((a, b) => {
                return new Date(b.delivery_dt) - new Date(a.delivery_dt);
            });

            return orders;
        },

        current() {

            var now = new Date();
            var later = new Date();
            later.setHours(later.getHours() + 24);

            var orders = this.orders.filter(val => {
                let date = new Date(val.delivery_dt);
                return val.status == 10 && date <= later && date >= now;
            });

            orders = orders.sort((a, b) => {
                return new Date(a.delivery_dt) - new Date(b.delivery_dt);
            });

            return orders;
        },

        new() {
            
            var now = new Date();

            var orders = this.orders.filter(val => {
                let date = new Date(val.delivery_dt);
                return val.status == 0 && date >= now;
            });

            orders = orders.sort((a, b) => {
                return new Date(a.delivery_dt) - new Date(b.delivery_dt);
            });

            return orders;
        },

        done() {

            var now = new Date().setHours(0,0,0,0);

            var orders = this.orders.filter(val => {
                let date = new Date(val.delivery_dt).setHours(0,0,0,0);
                return val.status == 20 && date == now;
            });

            orders = orders.sort((a, b) => {
                return new Date(b.delivery_dt) - new Date(a.delivery_dt);
            });

            return orders;
        },

        orders_list() {
            
            return this[this.filter];

        }

    },

    mounted() {
        
        axios.get('/api/get_orders').then((response) => 
        {
            this.orders = response.data;
            this.loading = false;
        });
    }
}
</script>

<style>
.filters {
    display: flex;
    margin-bottom: 10px;
    padding-bottom: 10px;
    border-bottom: 1px solid rgb(224, 224, 224); 
}

.filters div {
    text-align: center;
    flex-grow: 1;
}

.table-wrap {
    border-radius: 5px;
    margin: 0 auto;
    width: 1400px;
    box-shadow: 0px 0px 5px rgb(0 0 0 / 58%);
    padding: 20px;
}
.orders-table__row {
    display: flex;
}
.orders-table__header {
    display: flex;
}
.orders-table__row__col {
    flex-grow: 1;
    flex-basis: 200px;
    padding: 10px 10px 10px 10px;
    border-bottom: 1px solid rgb(224, 224, 224);
}
.orders-table__product-item {
    background-color: rgb(109, 36, 81);
    color: white;
    padding: 10px;
    margin-bottom: 10px;
}
.orders-table__product-item:last-of-type {
    margin-bottom: 0px;
}
</style>