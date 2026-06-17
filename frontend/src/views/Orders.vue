<template>
    <div class="orders-page">
        <h1>Siparişler</h1>

        <div class="orders">
            <div class="order" v-for="order in orders" :key="order.id">
                <div class="images">
                    <img :src="`/images/product-${image.product_id}.jpg`" v-for="image in order.items" :key="image.id">
                </div>

                <div class="order-info">
                    <p class="products">
                        <span class="product" v-for="item in order.items" :key="item.id">{{ item.product.name }}(x{{ item.quantity }})</span>
                    </p>
                    <div class="subtotal">
                        <h3>Aratoplam:</h3>
                        <h4>{{ order.subtotal }} TL</h4>
                    </div>
                    <div class="discounts">
                        <div class="discount" v-for="discount in order.discounts">
                            <h3>{{ discount.reason }}:</h3>
                            <h4>-{{ discount.amount }} TL</h4>
                        </div>
                    </div>
                    <div class="total">
                        <h3>Toplam:</h3>
                        <h4>{{ order.total }} TL</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios';
    import { useCustomerStore } from '@/stores/customer';
    import { useNotificationStore } from '@/stores/notification';

    export default {
        name: 'Orders',

        props: [

        ],

        data() {
            return {
                orders: []
            }
        },

        methods: {
            getCustomerOrders() {
                axios.get(`http://localhost:80/api/customers/${this.customerStore.selectedCustomerId}/orders`)
                .then((response) => {
                    this.orders = response.data.orders
                })
                .catch((error) => console.error(error))
            }
        },

        computed: {
            customerStore() {
                return useCustomerStore()
            },

            notificationStore() {
                return useNotificationStore()
            }
        },

        mounted() {
            if(this.customerStore.selectedCustomerId === ''){
                this.notificationStore.showNotification('Bir müşteri seçmelisiniz', 'error')
                return this.$router.push('/')
            }

            this.getCustomerOrders()
        },

        watch: {
            'customerStore.selectedCustomerId': function (){
                if(this.customerStore.selectedCustomerId !== ''){
                    this.getCustomerOrders()
                }
            }
        }
    }
</script>

<style scoped>
    *{
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    .orders-page {
        font-family: 'Inter', sans-serif;
    }

    .orders-page {
        padding: 60px 200px;
    }

    .orders-page h1{
        font-weight: 500;
        /* background-color: red; */
    }

    .orders-page .orders {
        padding: 20px 0;
        display: flex;
        flex-direction: column;
        align-items: center;
        row-gap: 30px;
    }

    .orders-page .orders .order{
        width: 1000px;
        /* height: 200px; */
        padding: 10px;
        display: flex;
        align-items: center;
        background-color: #f8f9fa;
        outline: 1px solid rgba(0, 0, 0, 0.8);
        border-radius: 6px;
    }

    .orders-page .orders .order .images {
        width: 300px;
        height: 100%;
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    .orders-page .orders .order .images img {
        height: 80px;
        width: 80px;
        border: 1px solid rgba(0, 0, 0, 0.8);
    }

    .orders-page .orders .order .order-info {
        width: 700px;
        height: 100%;
        display: flex;
        flex-direction: column;
        row-gap: 10px;
        /* background-color: blue; */
    }

    .orders-page .orders .order .order-info p{
        font-weight: 300;
        font-size: 12px;
        display: flex;
        flex-wrap: wrap;
        column-gap: 10px;
    }

    .orders-page .orders .order .order-info div{
        display: flex;
        justify-content: space-between;
    }
    
    .orders-page .orders .order .order-info .discounts{
        display: flex;
        flex-direction: column;
        row-gap: 10px;
    }

    .orders-page .orders .order .order-info .discounts div{
        display: flex;
        justify-content: space-between;
    }

    .orders-page .orders .order .order-info h3 {
        font-weight: 300;
        font-size: 16px;
        /* background-color: red; */
    }

    .orders-page .orders .order .order-info h4 {
        font-weight: 300;
        font-size: 16px;
        /* background-color: green; */
    }

    .orders-page .orders .order .order-info .discounts h3 {
        width: 80%;
    }

    .orders-page .orders .order .order-info .total h3 {
        font-weight: 500;
        font-size: 16px;
    }

    .orders-page .orders .order .order-info .total h4 {
        font-weight: 500;
        font-size: 16px;
    }
</style>