<script setup>
  import HeaderAdmin from '@/components/Multiple-uses/Header.vue';
  import CreateAccountForm from '@/components/Login/CreateAccountForm.vue';
</script>

<template>
  <HeaderAdmin/>
  <main>
      <CreateAccountForm/>
  </main>
</template>

<script>
  export default {
    name: 'adminAccountFormView',
  }
</script>