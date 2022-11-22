<script setup>
  import HeaderCharacterPage from '@/components/Multiple-uses/Header.vue';
  import CharacterForm from '@/components/UserPage/CharacterForm.vue';
  import CharacterList from '@/components/UserPage/CharacterList.vue';
</script>

<template>
  <HeaderCharacterPage/>
  
  <main class="main-container">
    <CharacterForm
      blank=""
      warrior="/src/assets/img/CharacterpageView/warrior_male.png"
      elf="/src/assets/img/CharacterpageView/elf_male.png"
      dwarf="/src/assets/img/CharacterpageView/dwarf_male.jpg"
      oni="/src/assets/img/CharacterpageView/oni_male.jpg"
    />
    <CharacterList/>
  </main>
</template>

<script>
  export default {
    name: 'characterpageView',
  }
</script>