<script setup>
  import {useSignInStore} from '@/stores/account.js';
  const store = useSignInStore();
  const id = store.currentUserId;
</script>

<template>
  <div class="header__nav-container centered-block">
    <nav class="header__nav nav flex-justify">
      <ul class="nav__list nav__list--row">
        <li class="nav__item nav__item--home outset-border" v-if="homeNav">
          <router-link to="/" class="nav__link">Accueil</router-link>
        </li>
        <li class="nav__item nav__item--login outset-border" v-if="loginNav">
          <router-link to="/login" class="nav__link">Login</router-link>
        </li>
        <li class="nav__item nav__item--rules outset-border" v-if="ruleNav">
          <router-link to="/rules" class="nav__link">Règles du jeu</router-link>
        </li>
        <li class="nav__item nav__item--admin outset-border" v-if="adminNav">
          <router-link :to="`/${store.$state[id].login}/admin`" class="nav__link">
            Gestion
          </router-link>
        </li>
        <li class="nav__item nav__item--character outset-border" v-if="characterNav">
          <router-link :to="`/${store.$state[id].login}/characterPage`" class="nav__link">
            Personnages
          </router-link>
        </li>
        <li class="nav__item nav__item--logout outset-border" v-if="logoutNav">
          <router-link to="/login" class="nav__link" @click="logout">
            Déconnexion
          </router-link>
        </li>
      </ul>
    </nav>
  </div>
</template>


<script>
  export default {
    data() {
      return {
        homeNav: true,
        loginNav: true,
        ruleNav: true,
        characterNav: false,
        adminNav: false,
        logoutNav: false,
      };
    },
    methods: {
      
      // show links if user is logged
      logged() {
          const store = useSignInStore();
          const id = store.currentUserId;
          
          if(store.$state.hasOwnProperty([id]) && 
          store.$state[id].logged === true) {
            this.characterNav = true;
            this.logoutNav = true;
          } 
      },
      
      // change visible links according to the page
      adjustNav() {
        let page = window.location.pathname;
        const store = useSignInStore();
        const id = store.currentUserId;
        
        switch(page) {
          case '/':
            this.homeNav = false;
            this.logged();
            var nav = document.querySelector('.nav__list--row');
            nav.classList.remove('nav__list--row');
            break;
          case '/login':
            this.loginNav = false;
            this.logged();
            this.logoutNav = false;
            break;
          case '/rules':
            this.ruleNav = false;
            this.logged();
            break;
          case `/${store.$state[id].login}/characterPage`:
            this.logoutNav = true;
            
            if(store.$state[id].adminPrivileges === "yes") {
                this.adminNav = true;
                this.loginNav = false;
            } 
            break;
          case `/${store.$state[id].login}/admin/list`:
          case `/${store.$state[id].login}/admin/create-account`:
            this.adminNav = true;
            this.loginNav = false;
            this.logoutNav = true;
            break;
          default:
            this.loginNav = false;
            this.characterNav = true;
            this.logoutNav = true;
            break;
        }
      },
      
      // destroy php session and logout the user
      async logout() {
        this.$router.push({path:'/login'});
        this.logoutNav = false;
        let url = new URL('http://localhost:3000/Api/index.php');
        url.search = '?route=/signOut';
        
        await fetch(url, {
          credentials: 'include',
        });
        const store = useSignInStore();
        const id = store.currentUserId;
        
        store.$patch({
          [id]: {
              logged: false,
          },
        });
      },
    },
    async mounted() {
        this.adjustNav();
    }
  };
</script>