<template>
    <div class="product-card">
        <img :src="`/images/product-${product.id}.jpg`" class="product-image">
        <h3 class="product-name">{{ product.name }}</h3>
        <h4 class="product-price">{{ product.price }} TL</h4>
        <div class="quantity">
            <button type="button" v-on:click="decreaseQuantity">-</button>
            <span>{{ quantity }}</span>
            <button type="button" v-on:click="increaseQuantity">+</button>
        </div>
        <button type="button" class="add-to-cart-button" @click="addToCart">Sepete Ekle</button>
    </div>
</template>

<script>
    import { useCartStore } from '@/stores/cart'

    export default {
        name: 'ProductCard',

        props: {
            product: {
                type: Object,
                required: true
            }
        },

        data() {
            return {
                quantity: 1
            }
        },

        methods: {
            increaseQuantity() {
                this.quantity++;
            },

            decreaseQuantity() {
                if(this.quantity > 1){
                    this.quantity--;
                }
            },

            addToCart() {
                const cartStore = useCartStore();

                cartStore.addToCart(this.product, this.quantity);
            }
        }
    }
</script>

<style scoped>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    .product-card {
        display: flex;
        flex-direction: column;
        align-items: center;
        background-color: antiquewhite;
        width: 260px;
        height: 380px;
        outline: 1px solid rgba(0, 0, 0, 0.8);
        border-radius: 6px;
        font-family: 'Inter', sans-serif;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.8);
    }

    .product-card .product-image {
        width: inherit;
        height: 180px;
        border-radius: 6px 6px 0 0;
        border-bottom: 1px solid rgba(0, 0, 0, 0.8);
    }

    .product-card .product-name {
        display: flex;
        justify-content: center;
        align-items: center;
        font-weight: 300;
        text-align: center;
        width: 100%;
        height: 70px;
        padding: 0 10px;
        /* background-color: red; */
    }

    .product-card .product-price {
        font-weight: 400;
        font-size: 20px;
        padding: 6px;
        /* background-color: antiquewhite; */
    }

    .product-card .quantity {
        font-weight: 400;
        font-size: 18px;
        padding: 6px 6px 18px;
        display: flex;
        justify-content: center;
        align-items: center;
        column-gap: 10px;
        /* background-color: antiquewhite; */
    }

    .product-card .quantity button{
        background-color: white;
        border: none;
        outline: 1px solid rgba(0, 0, 0, 0.8);
        width: 30px;
        height: 20px;
        font-size: 22px;
        display: flex;
        justify-content: center;
        align-items: center;
        border-radius: 6px;
        cursor: pointer;
    }

    .product-card .quantity button:active{
        background-color: black;
        outline: 1px solid rgba(255, 255, 255, 0.8);
        color: white;
    }

    .product-card .add-to-cart-button {
        background-color: black;
        border: none;
        outline: 1px solid rgba(252, 251, 251, 0.8);
        width: 60%;
        height: 30px;
        font-size: 20px;
        font-weight: 300;
        display: flex;
        justify-content: center;
        align-items: center;
        border-radius: 6px;
        cursor: pointer;
        color: white;
        font-family: 'Inter', sans-serif;
        transition: all 0.3s ease;
    }

    .product-card .add-to-cart-button:hover {
        background-color: white;
        outline: 1px solid rgba(0, 0, 0, 0.8);
        color: black;
    }
</style>