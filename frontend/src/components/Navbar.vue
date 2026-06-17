<template>
    <div class="navbar">
        <div class="nav-item logo" @click="$router.push('/')">
            ideasoft-case
        </div>

        <div class="nav-item">
            <h3>Müşteri Seç:</h3>
            <select id="dropdown-menu-btn" v-model="customerStore.selectedCustomerId">
                <option disabled value="">
                    Müşteri Seçiniz
                </option>

                <option
                    v-for="customer in customers"
                    :key="customer.id"
                    :value="customer.id"
                    class="dropdown-menu-item"
                >
                    {{ customer.name }}
                </option>
            </select>
        </div>

        <div class="nav-item">
            <button class="cart-button" v-on:click="isCartOpen = !isCartOpen"><span class="cart-btn-text">Sepet</span> <span class="cart-icon"><i class="bi bi-cart4"></i></span> <span class="cart-number">({{ cartStore.cartCount }})</span></button>

            <div v-if="isCartOpen" class="cart-dropdown">
                <div class="cart-item" v-for="item in cartStore.cartItems" :key="item.product.id">
                    <img :src="`/images/product-${item.product.id}.jpg`" class="cart-item-image">
                    <div class="cart-item-info">
                        <h4 class="cart-item-name">{{ item.product.name }}</h4>
                        <h5 class="cart-item-price">{{ item.product.price }} x({{ item.quantity }})</h5>
                    </div>
                    <button class="delete-btn" @click="cartStore.removeFromCart(item.product.id)"><i class="bi bi-trash"></i></button>
                </div>

                <button v-if="cartStore.cartCount > 0" class="complete-btn" @click="completeOrder">Siparişi Tamamla</button>

                <h3 v-else>Sepet Boş</h3>
            </div>
        </div>
    </div>
</template>

<script>
    import { useCartStore } from '@/stores/cart'
    import { useCustomerStore } from '@/stores/customer'
    import axios from 'axios';

    export default {
        name: 'Navbar',

        props: {

        },

        data() {
            return {
                isCartOpen: false,
                customers: []
            }
        },

        methods: {
            completeOrder() {
                this.isCartOpen = false
                this.$router.push('/checkout')
            }
        },

        computed: {
            cartStore() {
                return useCartStore()
            },

            customerStore() {
                return useCustomerStore()
            }
        },

        mounted() {
            axios.get('http://localhost:80/api/customers').then((response) => {
                this.customers = response.data
                console.log(this.customers)
            })
        }
    }
</script>

<style scoped>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    .navbar {
        position: sticky;
        top: 0;
        left: 0;
        z-index: 100;
        width: 100%;
        height: 66px;
        background: linear-gradient(to top right, #b2ff9e, #affc41);
        padding: 0 60px;
        margin: 0;
        display: flex;
    }

    .navbar .nav-item {
        flex: 1;
        display: flex;
        align-items: center;
        /* background-color: violet; */
    }

    .navbar .nav-item.logo {
        color: #1f2937;
        font-size: 26px;
        font-family: 'Inter', sans-serif;
        cursor: pointer;
    }

    .navbar .nav-item:nth-of-type(2) {
        justify-content: center;
        column-gap: 10px;
        /* background-color: antiquewhite; */
        font-size: 14px;
        font-family: 'Inter', sans-serif;
    }

    .navbar .nav-item:nth-of-type(2) h3 {
        font-weight: 600;
    }

    .navbar .nav-item:nth-of-type(2) #dropdown-menu-btn {
        font-size: 16px;
        padding: 0 10px;
        height: 30px;
        width: 200px;
        background-color: white;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        border: 1px solid rgba(0, 0, 0, 0.8);
    }

    .navbar .nav-item:nth-of-type(2) #dropdown-menu-btn .dropdown-menu-item {
        /* overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap; */
        color: black;
    }

    .navbar .nav-item:nth-of-type(3) {
        align-items: center;
        justify-content: end;
        position: relative;
    }

    .navbar .nav-item:nth-of-type(3) .cart-button {
        width: 120px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        font-family: 'Inter', sans-serif;
        padding: 5px 0;
        font-weight: 300;
        background-color: white;
        border: 1px solid rgba(0, 0, 0, 0.8);
        border-radius: 6px;
        cursor: pointer;
        transition: all 0.2s ease-in-out;
    }

    .navbar .nav-item:nth-of-type(3) .cart-button:active {
        background-color: rgba(0, 0, 0, 0.8);
        border: 1px solid white;
        color: white;
    }

    .navbar .nav-item:nth-of-type(3) .cart-button .cart-icon {
        margin-left: 6px;
    }

    .navbar .nav-item:nth-of-type(3) .cart-dropdown {
        /* font-family: ''Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif'; */
        font-family: 'Inter', sans-serif;
        display: flex;
        flex-direction: column;
        background-color: white;
        font-weight: 400;
        width: 300px;
        height: 400px;
        row-gap: 12px;
        position: absolute;
        padding: 6px;
        top: 54px;
        right: 0;
        outline: 1px solid rgba(0, 0, 0, 0.8);
        border-radius: 6px;
        overflow-y: scroll;
    }

    .navbar .nav-item:nth-of-type(3) .cart-dropdown h3{
        width: 100%;
        height: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
        font-family: 'Inter', sans-serif;
        font-weight: 500;
    }
    
    .navbar .nav-item:nth-of-type(3) .cart-dropdown .cart-item{
        font-family: 'Inter', sans-serif;
        display: flex;
        font-weight: 900;
        column-gap: 4px;
        background-color: white;
        font-size: 14px;
        flex-shrink: 0;
        width: 100%;
        height: 80px;
        outline: 1px solid lightgrey;
        position: relative;
    }

    .navbar .nav-item:nth-of-type(3) .cart-dropdown .cart-item .cart-item-image {
        width: 80px;
        height: 80px;
    }

    .navbar .nav-item:nth-of-type(3) .cart-dropdown .cart-item .cart-item-info {
        display: flex;
        flex-direction: column;
        justify-content: center;
        row-gap: 10px;
    }

    .navbar .nav-item:nth-of-type(3) .cart-dropdown .cart-item .cart-item-info h4 {
        font-weight: 300;
    }

    .navbar .nav-item:nth-of-type(3) .cart-dropdown .cart-item .cart-item-info h5 {
        font-size: 14px;
        font-weight: 300;
    }

    .navbar .nav-item:nth-of-type(3) .cart-dropdown .cart-item .delete-btn {
        width: 20px;
        height: 20px;
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

    .navbar .nav-item:nth-of-type(3) .cart-dropdown .cart-item .delete-btn:hover {
        background-color: white;
        border: none;
        outline: 1px solid red;
        color: red;
    }

    .navbar .nav-item:nth-of-type(3) .cart-dropdown .complete-btn {
        width: 100%;
        height: 30px;
        border: 1px solid rgba(0, 0, 0, 0.8);
        background-color: antiquewhite;
        flex-shrink: 0;
        cursor: pointer;
        color: black;
        transition: all 0.2s;
        font-weight: 500;
    }

    .navbar .nav-item:nth-of-type(3) .cart-dropdown .complete-btn:hover {
        border: 1px solid antiquewhite;
        background-color: rgba(0, 0, 0, 0.8);
        color: white;
    }
</style>