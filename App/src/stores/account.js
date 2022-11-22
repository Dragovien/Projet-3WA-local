import {defineStore} from 'pinia';

export const useSignInStore = defineStore('login', {
  state: () => ({
    currentUserId: '',
  }),
  persist: true,
  actions: {
    // login the user if the login and password are correct
    async signIn(formData) {
      let url = new URL('http://localhost:3000/Api/index.php'); 
      url.search = '?route=/signIn';
      return fetch(url, {
        method: 'POST',
        credentials: 'include',
        header: {
        'Content-Type': 'application/json; charset=UTF-8'
        },
        body: JSON.stringify(formData),
      })
      .then((response) => response.json());
    }    
  },
})
