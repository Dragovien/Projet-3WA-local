<script setup>
  import HeaderAdmin from '@/components/Multiple-uses/Header.vue';
  import {useSignInStore} from '@/stores/account.js';
  const store = useSignInStore();
  const id = store.currentUserId;
</script>

<template>
  <HeaderAdmin/>
  <main class="main">
    <div class="admin-wrapper">
      <router-link 
        :to="`/${store.$state[id].login}/admin/list`" 
        class="admin-wrapper__link admin-wrapper__link--list mt-3"
      >
        Liste des comptes
      </router-link>
      <router-link 
        :to="`/${store.$state[id].login}/admin/create-account`" 
        class="admin-wrapper__link admin-wrapper__link--create-account mt-3" 
        id="create-account"
      >
        Créer un compte
      </router-link>
      <router-link 
        :to="`/${store.$state[id].login}/characterPage`" 
        class="admin-wrapper__link admin-wrapper__link--play mt-3"
      >
        Jouer
      </router-link>
    </div>
  </main>
</template>

<script>
  export default {
    name: 'adminView',
  }
</script>

