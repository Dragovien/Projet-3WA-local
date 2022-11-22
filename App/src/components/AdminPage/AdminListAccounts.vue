<template>
  <div class="wrapper wrapper--table">
    <h2>Liste des utilisateurs</h2>
    <div class="table-responsive">
      <table class="my-5 table">
        <thead class="table__thead">
          <th v-for="column in columns" class="table__th">
              {{column}}
          </th>
        </thead>
        <tbody class="table__tbody">
          <tr v-for="user in users" class="table-tr">
            <td class="table__td">{{user.login}}</td>
            <td class="table__td">{{user.firstName}}</td>
            <td class="table__td">{{user.lastName}}</td>
            <td class="table__td">{{user.adminPrivileges}}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
  
  <div class="admin-list-wrapper justify-center select-wrapper">
    <select v-model="id" @change="showButtons" class="select-wrapper__select">
      <option disabled value="">Choisissez le compte à supprimer/editer</option>
      <option 
        v-for="user in users" 
        :value="user.id"
        :disabled="user.adminPrivileges === 'yes'">{{user.login}}
      </option>
    </select>
  </div>
  
  <div class="admin-list-wrapper justify-evenly button-wrapper">
    <button 
      type="button" @click="deleteAccount" 
      v-if="showBtn" class="button button--styled button--list-adjust"
    >
      Supprimer
    </button>
    <button 
      type="button" @click="showForm" 
      v-if="showBtn" class="button button--styled button--list-adjust"
    >
      Mettre à jour
    </button>
  </div>
  
  <div class="wrapper" v-if="show">
    
    <h2 class="mb-5">Modification du compte</h2>
    
    <form class="form">
      <div class="row">
        <label for="inputFirstName" class="col-sm-4 col-form-label">
          Prénom
        </label>
        <div class="col-sm-8">
          <span class="form-error">{{formErrors.firstName}}</span>
          <input 
            type="text" class="form-control" 
            id="inputFirstName" name="formFirstName" 
            v-model="formData.firstName"
          >
        </div>
      </div>
      
      <div class="row">
        <label for="inputLastName" class="col-sm-4 col-form-label">
          Nom
        </label>
        <div class="col-sm-8">
          <span class="form-error">{{formErrors.lastName}}</span>
          <input 
            type="text" class="form-control" 
            id="inputLastName" name="formLastName" 
            v-model="formData.lastName"
          >
        </div>
      </div>
      
      <div class="row">
        <label for="inputLogin" class="col-sm-4 col-form-label">
          Pseudonyme
        </label>
        <div class="col-sm-8">
          <span class="form-error">{{formErrors.login}}</span>
          <input 
            type="text" class="form-control" 
            id="inputLogin" name="formLogin" 
            v-model="formData.login"
          >
        </div>
      </div>

      <div class="row">
        <label for="inputPassword" class="col-sm-4 col-form-label">
          Mot de passe
        </label>
        <div class="col-sm-8">
          <span class="form-error">{{formErrors.password}}</span>
          <input 
            type="password" class="form-control" id="inputPassword" 
            name="formPassword" v-model="formData.password" autocomplete="off"
          >
        </div>
      </div>

      <div class="row">
        <label for="checkboxAdmin" class="col-sm-4 col-form-label">
          Admin
        </label>
        <div class="col-sm-8
        row__col">
          <input 
            type="checkbox" id="checkboxAdmin"
            class="row__checkbox" name="adminPrivileges" 
            v-model="formData.adminPrivileges"
          >
        </div>
      </div>

      <button 
        type="submit" name="accountSubmit" 
        class="button" @click="updateAccount"
      >
        Mettre à jour le compte
      </button>
    </form>
  </div>

</template>

<script>

export default {
  name: 'AdminListAccounts',
  data() {
    return {
      columns: [
          'Pseudonyme',
          'Prénom',
          'Nom',
          'Est Admin',
      ],
      users: [],
      id: "",
      show: false,
      showBtn: false,
      formErrors: {},
      formData: {},
      counter: 0,
      counterBtn: 0,
    };
  },
  methods: {
    // display/hide form
    showForm() {
      if(this.counter === 0) {
        this.counter = 1;
        return this.show = true;
      } else if(this.counter === 1) {
        this.counter = 0;
        return this.show = false;
      }
    },
    
    // display/hide buttons
    showButtons() {
      return this.showBtn = true;
    },
    
    // change value of checkbox to 'yes'/'no'
    adminPrivileges() {
      if(this.formData.adminPrivileges) {
        this.formData.adminPrivileges = "yes";
      } else {
        this.formData.adminPrivileges = "no";
      }
    },
    
    // show list of all accounts 
    async listAccounts() {
      let url = new URL('http://localhost:3000/Api/index.php');
      url.search = '?route=/adminListAccounts';
      
      await fetch(url, {
          credentials: 'include',
      })
      .then((response) => response.json())
      .then((result) => {
          this.users = result.data;
      });
    },
    
    // delete selected account
    async deleteAccount(event) {
      event.preventDefault();

      let url = new URL('http://localhost:3000/Api/index.php');
      url.search = `?route=/adminControls&id=${this.id}`;
      
      await fetch(url, {
          method: 'DELETE',
          credentials: 'include',
      });
      this.$router.go(0);
    },
    
    // modify selected account
    async updateAccount(event) {
      event.preventDefault();

      this.adminPrivileges();
      let url = new URL('http://localhost:3000/Api/index.php');
      url.search = `?route=/adminControls&id=${this.id}`;

      await fetch(url, {
          method: 'PUT',
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
            this.$router.go(0);
          }
      });
    },
  },
  mounted() {
    this.listAccounts();
  },
};
</script>


