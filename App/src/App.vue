<script setup>
  import { RouterView } from "vue-router";
  import FooterApp from '@/components/Multiple-uses/Footer.vue';
</script>

<template>
  <RouterView />
  <footer>
      <FooterApp/>
  </footer>
</template>

<script>
  export default {
      name: 'App',
  }
</script>