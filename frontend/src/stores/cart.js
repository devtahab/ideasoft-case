import { defineStore } from 'pinia';

export const useCartStore = defineStore('cart', {
    state: () => ({
        cartItems: []
    }),

    getters: {
        cartCount: (state) => {
            return state.cartItems.reduce((total, item) => {
                return total + item.quantity
            }, 0)
        }
    },

    actions: {
        addToCart(product, quantity) {
            let existingItem = this.cartItems.find((item) => {
                return item.product.id === product.id
            })

            if(existingItem) {
                existingItem.quantity += quantity
            }
            else {
                this.cartItems.push({
                    product: product,
                    quantity: quantity
                })
            }
        },

        removeFromCart(productId) {
            this.cartItems = this.cartItems.filter((item) => {
                return item.product.id !== productId
            })
        }
    }
})