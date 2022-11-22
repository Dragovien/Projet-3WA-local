<script setup>
  import HeaderLogin from '@/components/Multiple-uses/Header.vue';
  import CreateAccountForm from '@/components/Login/CreateAccountForm.vue';
  import LoginForm from '@/components/Login/LoginForm.vue';
</script>

<template>
  <div class="flex-block flex-block--background">
    <HeaderLogin/>

    <main class="main main-login align-center">
      <section class="flex-block">
        <LoginForm/>
        <button 
          @click="showCreationForm" type="button" 
          class="button button--width-adjust"
        >
          Nouveau compte
        </button>
      </section>
      
      <section id="masked-column">
        <CreateAccountForm v-if="creationForm"/>
      </section>
    </main>
  </div>
</template>

<script>
  export default {
    name: 'LoginView',
    data() {
      return {
          creationForm: false,
          counter: 0,
      }
    },
    methods: {
      // show and hide account creation form on click
      showCreationForm() {
        let column = document.querySelector('#masked-column');

        if(this.counter === 0) {
          this.creationForm = true;
          this.counter = 1;
          column.classList.add('main-login__col');
            
        } else {
          this.creationForm = false;
          this.counter = 0;
          column.classList.remove('main-login__col');
        }
      }
    }
  }
</script>