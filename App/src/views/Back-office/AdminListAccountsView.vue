<script setup>
  import HeaderAdmin from '@/components/Multiple-uses/Header.vue';
  import AdminListAccounts from '@/components/AdminPage/AdminListAccounts.vue';
</script>

<template>
  <HeaderAdmin/>
  <main class="main">
    <AdminListAccounts/>
  </main>
</template>

<script>
  export default {
    name: 'adminListAccountsView',
  }
</script>