<script setup>
import Navbar from './components/Navbar.vue';
import Notification from './components/Notification.vue';
</script>

<template>
  <Notification/>
  <Navbar/>
  <RouterView/>
</template>

<style scoped>
</style>