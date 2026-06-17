<template>
    <div class="checkout">
        <h2>Sipariş Özeti</h2>

        <div class="products">
            <div class="product" v-for="item in cartStore.cartItems" :key="item.product.id">
                <div class="left-div">
                    <img :src="`/images/product-${item.product.id}.jpg`" class="product-image">
                    <div class="product-info">
                        <h3 class="product-name">{{ item.product.name }}</h3>
                        <div class="product-quantity">
                            <button @click="item.quantity--" :disabled="item.quantity <= 1">-</button>
                            <span>{{ item.quantity }}</span>
                            <button @click="item.quantity++">+</button>
                        </div>
                    </div>
                </div>

                <div class="right-div">
                    <h4 class="product-price-sum">{{ (Number(item.product.price) * item.quantity).toFixed(2) }} TL</h4>
                </div>

                <button class="delete-btn" @click="cartStore.removeFromCart(item.product.id)"><i class="bi bi-trash"></i></button>
            </div>
        </div>

        <div class="checkout-sum">
            <div class="sum">
                <h3>Ara Toplam:</h3>
                <h4 v-if="!isLoading">{{ subtotal.toFixed(2) }} TL</h4>
                <h4 v-else class="skeleton"></h4>
            </div>
        
            <div class="discounts">
                <div class="discount" v-for="(discount, index) in discounts" :key="index">
                    <h3 class="discount-disclaimer">{{ discount.reason }}:</h3>
                    <h4 class="discount-amount" v-if="!isLoading">-{{ discount.amount }} TL</h4>
                    <h4 v-else class="skeleton"></h4>
                </div>
            </div>

           <div class="total">
                <h3>Toplam:</h3>
                <h4 v-if="!isLoading">{{ total.toFixed(2) }} TL</h4>
                <h4 v-else class="skeleton"></h4>
           </div>
        </div>

        <div class="order-btn-div">
            <button class="order-btn" :disabled="isLoading" @click="createOrder">Sipariş Ver</button>
        </div>

    </div>
</template>

<script>
    import { useCartStore } from '@/stores/cart'
    import { useCustomerStore } from '@/stores/customer'
    import { useNotificationStore } from '@/stores/notification';
    import debounce from 'lodash.debounce'
    import axios from 'axios';

    export default {
        name: 'Checkout',

        props: {

        },

        data() {
            return {
                isLoading: false,
                subtotal: 0,
                discountTotal: 0,
                total: 0,
                discounts: []
            }
        },

        methods: {
            createOrder() {
                axios.post("http://localhost:80/api/orders", {
                    customer_id: this.customerStore.selectedCustomerId,
                    items: this.cartStore.cartItems.map((item) => {
                        return {
                            product_id: item.product.id,
                            quantity: item.quantity
                        }
                    })
                }).then((response) => {
                    this.cartStore.cartItems = [];
                    this.notificationStore.showNotification('Sipariş başarıyla oluşturuldu!', 'success')
                    return this.$router.push('/');
                }).catch((error) => {
                    const message = error.response?.data?.message || 'Sipariş oluşturulamadı'
                    this.notificationStore.showNotification(message, 'error')
                })
            },

            previewOrder() {
                axios.post("http://localhost:80/api/orders/preview", {
                    'customer_id': this.customerStore.selectedCustomerId,
                    'items': this.cartStore.cartItems.map((item) => {
                        return {
                            'product_id': item.product.id,
                            'quantity': item.quantity
                        }
                    })
                }).then((response) => {
                    this.subtotal = response.data.data.subtotal
                    this.discounts = response.data.data.discounts
                    this.discountTotal = response.data.data.discount_total
                    this.total = response.data.data.total
                    this.isLoading = false
                })
                .catch((error) => {
                    const message = error.response?.data?.message || 'Bir hata oluştu'
                    this.notificationStore.showNotification(message, 'error')
                    this.isLoading = false
                })
            }
        },

        computed: {
            cartStore() {
                return useCartStore()
            },

            customerStore() {
                return useCustomerStore()
            },

            notificationStore() {
                return useNotificationStore()
            }
        },

        created() {
            this.debouncedPreviewOrder = debounce(() => {
                this.previewOrder()
            }, 2000)
        },

        mounted() {
            this.previewOrder();
        },

        watch: {
            'cartStore.cartItems': {
                deep: true,
                handler() {
                    if (this.cartStore.cartCount === 0) {
                        this.isLoading = false
                        return
                    }

                    this.isLoading = true
                    this.debouncedPreviewOrder()
                }
            },

            'cartStore.cartCount'(newCount) {
                if(newCount === 0){
                    this.$router.push('/')
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

    .checkout {
       padding: 50px 300px; 
       font-family: 'Inter', sans-serif;
    }

    .checkout h2 {
       font-family: 'Inter', sans-serif;
       font-size: 28px;
       font-weight: 400;
       text-align: center;
       margin-bottom: 30px;
    }

    .checkout .products {
        display: flex;
        flex-direction: column;
        align-items: center;
        row-gap: 20px;
        padding: 6px 0 30px;
        /* background-color: red; */
    }

    .checkout .products .product {
        width: 600px;
        display: flex;
        justify-content: space-between;
        outline: 1px solid lightgray;
        background-color: antiquewhite;
        position: relative;
    }

    .checkout .products .product .delete-btn {
        width: 30px;
        height: 30px;
        background-color: red;
        border: none;
        outline: 1px solid white;
        color: white;
        top: 0;
        right: 0;
        position: absolute;
        cursor: pointer;
        transition: all 0.3s;
    }

    .checkout .products .product .delete-btn:hover {
        background-color: white;
        border: none;
        outline: 1px solid red;
        color: red;
    }

    .checkout .products .product .left-div {
        display: flex;
        width: 460px;
    }

    .checkout .products .product .left-div .product-image {
        width: 100px;
        height: 100px;
    }

    .checkout .products .product .left-div .product-info {
        display: flex;
        flex-direction: column;
        justify-content: center;
        row-gap: 10px;
        padding: 0 10px 0 20px;
    }

    .checkout .products .product .left-div .product-info .product-name {
        font-size: 18px;
        font-weight: 400;
    }

    .checkout .products .product .left-div .product-info .product-quantity {
        display: flex;
        align-items: center;
        column-gap: 8px;
        font-size: 18px;
    }

    .checkout .products .product .left-div .product-info .product-quantity button {
        background-color: white;
        border: none;
        color: rgba(0, 0, 0, 0.8);
        outline: 1px solid rgba(0, 0, 0, 0.8);
        width: 22px;
        height: 22px;
        font-size: 22px;
        border-radius: 8px;
        cursor: pointer;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .checkout .products .product .left-div .product-info .product-quantity button:active {
        background-color: rgba(0, 0, 0, 0.8);
        color: white;
        outline: 1px solid white;
    }

    .checkout .products .product .right-div{
        display: flex;
        align-items: center;
        justify-content: center;
        width: 140px;
    }

    .checkout .products .product .right-div .product-price-sum{
        font-weight: 400;
    }

    .checkout .checkout-sum {
        /* background-color: antiquewhite; */
        border-top: 1px solid lightgray;
        display: flex;
        flex-direction: column;
        row-gap: 20px;
        padding: 16px 0 0;
        align-items: center;
    }

    .checkout .checkout-sum .sum {
        width: 600px;
        /* background-color: red; */
        display: flex;
        justify-content: space-between;
    }

    .checkout .checkout-sum .sum h3 {
        font-weight: 400;
    }

    .checkout .checkout-sum .sum h4 {
        font-weight: 400;
    }

    .checkout .checkout-sum .total {
        width: 600px;
        /* background-color: red; */
        display: flex;
        justify-content: space-between;
    }

    .checkout .checkout-sum .total h3 {
        font-weight: 500;
    }

    .checkout .checkout-sum .total h4 {
        font-weight: 500;
    }

    .checkout .checkout-sum .discounts {
        display: flex;
        flex-direction: column;
        row-gap: 20px;
        /* background-color: red; */
    }

    .checkout .checkout-sum .discounts .discount {
        width: 600px;
        /* background-color: blue; */
        display: flex;
        align-items: center;
    }

    .checkout .checkout-sum .discounts .discount h3 {
        font-weight: 400;
        width: 460px;
        /* background-color: antiquewhite; */
    }

    .checkout .checkout-sum .discounts .discount h4 {
        font-weight: 400;
        width: 140px;
        text-align: end;
        /* background-color: brown; */
    }

    .order-btn-div {
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 20px 0 0;
        /* background-color: antiquewhite; */
    }

    .order-btn {
        width: 240px;
        height: 40px;
        font-weight: 500;
        font-size: 20px;
        border: none;
        outline: 1px solid rgba(0, 0, 0, 0.8);
        color: rgba(0, 0, 0, 0.8);
        background-color: antiquewhite;
        border-radius: 8px;
        font-family: 'Inter', sans-serif;
        cursor: pointer;
        transition: all 0.3s;
    }

    .order-btn:disabled {
        outline: 1px solid lightgray;
        color: lightgray;
        background-color: white;
        cursor: not-allowed;
    }

    .order-btn:hover {
        outline: 1px solid antiquewhite;
        color: antiquewhite;
        background-color: rgba(0, 0, 0, 0.8);
    }

    .skeleton {
    width: 80px;
    height: 20px;
    background: linear-gradient(90deg, #e0e0e0 25%, #f0f0f0 50%, #e0e0e0 75%);
    background-size: 200% 100%;
    animation: shimmer 1.2s infinite;
    border-radius: 4px;
    }

    @keyframes shimmer {
        0% { background-position: 200% 0; }
        100% { background-position: -200% 0; }
    }

</style>