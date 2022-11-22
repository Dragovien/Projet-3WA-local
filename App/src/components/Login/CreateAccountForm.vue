<template>
  <div class="wrapper">
    <h2 class="mb-5">Création de compte</h2>
    <span v-if="isCreated">
      <p class="valid-form">Votre compte a bien été créé</p>
    </span>
    <form class="form">
      <div class="row">
        <label for="inputFirstName" class="col-sm-4 col-form-label">Prénom</label>
        <div class="col-sm-8">
          <span class="form-error">{{formErrors.firstName}}</span>
          <input 
            type="text" class="form-control" id="inputFirstName" 
            name="formFirstName" v-model="formData.firstName"
          >
        </div>
      </div>
      
      <div class="row">
        <label for="inputLastName" class="col-sm-4 col-form-label">Nom</label>
        <div class="col-sm-8">
          <span class="form-error">{{formErrors.lastName}}</span>
          <input 
            type="text" class="form-control" id="inputLastName" 
            name="formLastName" v-model="formData.lastName"
          >
        </div>
      </div>
      
      <div class="row">
        <label for="inputLogin" class="col-sm-4 col-form-label">Pseudonyme</label>
        <div class="col-sm-8">
          <span class="form-error">{{formErrors.login}}</span>
          <input 
            type="text" class="form-control" id="inputLogin" 
            name="formLogin" v-model="formData.login"
          >
        </div>
      </div>

      <div class="row">
        <label for="inputPassword" class="col-sm-4 col-form-label">Mot de passe</label>
        <div class="col-sm-8">
          <span class="form-error">{{formErrors.password}}</span>
          <input 
            type="password" class="form-control" id="inputPassword" 
            name="formPassword" v-model="formData.password" autocomplete="off"
          >
        </div>
      </div>

      <div class="row" v-if="adminPage">
        <label for="checkboxAdmin" class="col-sm-4 col-form-label">Admin</label>
        <div class="col-sm-8 row__col">
          <input 
            type="checkbox" id="checkboxAdmin" class="row__checkbox"
            name="adminPrivileges" v-model="formData.adminPrivileges"
          >
        </div>
      </div>

      <button type="submit" name="accountSubmit" class="button" @click="createAccount">
        Créer votre compte
      </button>
    </form>
    </div>
</template>

<script>
  export default {
    data() {
      return {
        isCreated: false,
        formErrors: {},
        formData: {},
        adminPage: true,
      };
    },
    methods: {
      
      // method to create new account
      async createAccount(event) {
        event.preventDefault();

        let url = new URL('http://localhost:3000/Api/index.php');
        url.search = '?route=/createAccount';
        await fetch(url, {
          method: 'POST',
          credentials: 'include',
          header: {
            'Content-Type': 'application/json; charset=UTF-8'
          },
          body: JSON.stringify(this.formData),
        })
        .then((response) => response.json())
        .then((result) => {
          if (result['errors']) {
            this.formErrors = result['errors'];
          } else {
            this.formErrors = {};
            this.formData = {};
            this.isCreated = true;
          }
        });
      },
      
      // check page to show or not the admin checkbox option
      async showAdminCheckbox() {
        let page = window.location.pathname;
        if(page === '/login') {
          this.adminPage= false;
        }
      },
    },
    mounted() {
      this.showAdminCheckbox();
    }
  };
</script>