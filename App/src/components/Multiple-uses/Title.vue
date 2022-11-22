<template>
  <div class="header__title-wrapper gradient-border">
    <h1 class="header__title" id="title">{{title}}</h1>
  </div>
</template>

<script>
  import {useSignInStore} from '@/stores/account.js';

  export default {
    name: 'Title',
    data() {
      return {
        title: '',
      };
    },
    methods: {
      
      // change title text based on the pathname in the url
      selectTitle() {
        let page = window.location.pathname;
        const storeAccount = useSignInStore();
        const id = storeAccount.currentUserId;
        
        switch(page) {
          case '/':
            this.title = 'Dungeon Qrawler';
            break;
          case '/login':
            this.title = 'Création de compte / login';
            break;
          case '/rules':
            this.title = 'Règles du jeu';
            break;
          case `/${storeAccount.$state[id].login}/admin`:
          case `/${storeAccount.$state[id].login}/admin/list`:
          case `/${storeAccount.$state[id].login}/admin/create-account`:
            this.title = 
              `Admin: ${storeAccount.$state[id].firstName} ${storeAccount.$state[id].lastName}`;
            break;
          default:
            this.title = 
              `Player: ${storeAccount.$state[id].firstName} ${storeAccount.$state[id].lastName}`;
            break;
        }
      },

      // create an attribute 'data-text' with title text of the page as value
      dynamicDataText() {
        let title = document.querySelector('#title');
        title.setAttribute('data-text', this.title);
      }
    },
    mounted() {
      this.selectTitle();
      this.dynamicDataText();
    },
  }
</script>