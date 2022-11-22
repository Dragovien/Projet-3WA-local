<template>
  <div class="wrapper wrapper--width" id="loginForm">
    <h2 class="mb-5">Login</h2>
    <form class="form">
      <div class="row">
        <label for="loginPseudo" class="col-sm-5 col-form-label">
          Pseudonyme
        </label>
        <div class="col-sm-7 row__col2">
          <span class="form-error">{{formErrors.login}}</span>
          <input 
            type="text" class="form-control" id="loginPseudo" 
            name="loginSignInForm" v-model="formData.login"
          >
        </div>
      </div>

      <div class="row">
        <label for="loginPassword" class="col-sm-5 col-form-label">
            Mot de passe
        </label>
        
        <div class="col-sm-7 row__col2">
          <span class="form-error">{{formErrors.password}}</span>
          <input 
            type="password" class="form-control" id="loginPassword" 
            name="passwordSignInForm" v-model="formData.password" autocomplete="off"
          >
        </div>
      </div>
        
      <button 
        type="submit" name="accountSubmit" 
        class="button" @click="logIn">Se connecter
      </button>
    </form>
  </div>
</template>

<script>
  import {useSignInStore} from '@/stores/account.js';

  export default {
    data() {
      return {
        formErrors: {},
        formData: {},
      };
    },
    methods: {
      
      // method to let the user login
      async logIn(event) {
        event.preventDefault();

        const store = useSignInStore();

        // may want to encrypt with crypto js later
        store.signIn(this.formData)
        .then((result) => {
          if (result['errors']) {
            this.formErrors = result['errors'];
          } else {
            result.data.logged = true;
            delete result.data.password;
            if(result.data.adminPrivileges === 'no') {
              this.$router.push({ path: `/${this.formData.login}/characterPage` });
            } else if (result.data.adminPrivileges === 'yes') {
              this.$router.push({ path: `/${this.formData.login}/admin` });
            };
            store.$patch({
                [result.data.id]: result.data,
                currentUserId: result.data.id,
            });
          }
        });
      },
    }
  };
</script>