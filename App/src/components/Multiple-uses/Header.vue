<script setup>
  import Navbar from './Navbar.vue';
  import AccessibilityBtn from './Accessibility.vue';
  import TitleHeader from './Title.vue';
</script>

<template>
  <header class="header">
    <div class="header__nav-wrapper">
      <Navbar/>
      <AccessibilityBtn class="header__accessibility"/>
    </div>
    <TitleHeader/>
  </header>
</template>

<script>
  export default {
    name: 'Header',
  };
</script>