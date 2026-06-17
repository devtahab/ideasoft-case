import { defineStore } from 'pinia'

export const useCustomerStore = defineStore('customer', {
    state: () => ({
        selectedCustomerId: ''
    }),

    actions: {
        setSelectedCustomer(customerId){
            this.selectedCustomerId = customerId;
        }
    }
})