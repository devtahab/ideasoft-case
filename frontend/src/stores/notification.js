import { defineStore } from "pinia";

export const useNotificationStore = defineStore('notification', {
    state: () => ({
        show: false,
        message: '',
        type: 'success'
    }),

    actions: {
        showNotification(message, type = 'success') {
            this.message = message
            this.show = true
            this.type = type

            setTimeout(() => {
                this.show = false
            }, 6500)
        }
    }
})