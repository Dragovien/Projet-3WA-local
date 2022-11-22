<script setup>
  import Navbar from '@/components/Multiple-uses/Navbar.vue';
  import AccessibilityBtn from '@/components/Multiple-uses/Accessibility.vue';
  import TitleHome from '@/components/Multiple-uses/Title.vue';
</script>

<template>
  <header class="header">
    <TitleHome/>
  </header>

  <main class="main main-home main-home--row">
    <aside class="main-home__aside flex-column">
      <Navbar/>
      <audio 
        controls loop src="/src/assets/audio/HomeView/homePage.mp3" 
        type="audio/mpeg" class="main-home__audio"
      ></audio>
      <AccessibilityBtn/>
    </aside>

    <section class="main-home__text centered-block outset-border">
      <h2>Préambule</h2>
      <p>
        À vous qui entrez ici, abandonnez tout espoir. 
        Ici réside le Demon Lord, terrible protecteur du trésor de ces lieux.
      </p> 
      <p>
        Si vous souhaitez cependant braver les dangers dans l'espoir d'une gloire futile, 
        faites bien attention à vous...
      </p>
      
      <img 
        src="@/assets/img/HomeView/gif-accueil.gif" 
        class="main-home__gif my-5" 
        alt="dungeon corridor with traps gif"
      />

      <p>Pour commencer le jeu, veuillez cliquer sur "Commencer à jouer".</p>
      <p>Pour regarder les règles, veuillez cliquer sur "Règles du jeu".</p>
      <p>Si vous désirez revenir à l'accueil du jeu, veuillez cliquer sur "Accueil".</p>
    </section>
  </main>
</template>

<script>
  export default {
    name: 'HomeView',
  }
</script>