<template>
    <div v-if="notificationStore.show" :class="notificationStore.type" class="notification">
        {{ notificationStore.message }}
    </div>
</template>

<script>
    import { useNotificationStore } from '@/stores/notification'

    export default {
        name: 'Notification',

        props: {

        },

        data() {
            return {

            }
        },

        methods: {

        },

        computed: {
            notificationStore() {
                return useNotificationStore()
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

    .notification {
        position: fixed;
        top: 60px;
        left: 50%;
        transform: translateX(-50%);
        z-index: 900;
        padding: 16px 60px;
        border-radius: 8px;
        font-weight: 600;
        font-family: 'Inter', sans-serif;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.8);
    }

    .notification.success{
        background-color: greenyellow;
        color: black;
        outline: 1px solid black;
        border-radius: 6px;
    }

    .notification.error{
        background-color: red;
        color: white;
        outline: 1px solid white;
        border-radius: 6px;
    }
</style>