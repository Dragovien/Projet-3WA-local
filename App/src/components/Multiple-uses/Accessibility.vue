<template>
  <div class="header__icons accessibility-icons mb-3">
    <i class="bi bi-brightness-alt-low-fill" @click="darkMode()"></i>
    <i class="bi bi-file-font-fill" @click="changeFont()"></i>
  </div>
</template>

<script>
  export default {
    name: 'HomeView',
    methods: {
      
      // method to add/remove attribute with font and color new values
      selectAccessibility(attribute) {
        const app = document.querySelector('#app');
        if(app.hasAttribute(attribute)) {
          app.removeAttribute(attribute);
          return;
        }
        app.setAttribute(attribute, "on");
      },
      
      // apply dark mode
      darkMode() {
        this.selectAccessibility("dark-mode");
      },
      
      // apply font for dyslexic people 
      changeFont() {
        this.selectAccessibility("dyslexic");
      },
      
      // apply new color to icons on login page, needed because of background image
      changeIconColor() {
        let page = window.location.pathname;
        let icons = document.querySelectorAll('.bi');
        if(page === '/login') {
          icons.forEach( (icon) => {
              icon.classList.add('bi--color');
          });
        }
      }
    },
    mounted() {
      this.changeIconColor();
    }
  }
</script>