<script setup>
  import HeaderRules from '@/components/Multiple-uses/Header.vue';
  import Rules from '@/components/Rules/Rule-sections.vue';
</script>

<template>
  <HeaderRules/>
  
  <div class="flex-block justify-center">
    <main class="main main--wrap-evenly">
        <Rules/>
    </main>
  </div>
</template>

<script>
  export default {
    name: 'RulesView',
  }
</script>
