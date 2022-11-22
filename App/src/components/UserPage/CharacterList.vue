<template>
  <div class="wrapper wrapper--table">
    <h2>Personnages crées</h2>
    <div class="table-responsive">
      <table class="table my-5">
        <thead class="table__thead">
          <th v-for="category in categories" class="table__th">
              {{category}}
          </th>
        </thead>
        <tbody class="table__tbody">
          <tr v-for="character in characters">
              <td class="table__td">{{character.name}}</td>
              <td class="table__td">{{character.sex}}</td>
              <td class="table__td">{{character.race.raceName}}</td>
              <td class="table__td w-25">
                <button 
                  @click="toGame(character.id)" class="button button--styled
                  button--list-adjust"
                >
                  Jouer
                </button>
              </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script>
  import {useCharacterInfo} from '@/stores/character.js'; 
  export default {
    name: 'characterList',
    data() {
      return {
          categories: 
          [
            'Nom',
            'Sexe',
            'Race',
          ],
          characters: [],
      }
    },
    methods: {
      // show list of characters belonging to the user
      async listCharacters() {
        let url = new URL('http://localhost:3000/Api/index.php');
        url.search = '?route=/listCharacters';
        
        await fetch(url, {
          credentials: 'include',
        })
        .then((response) => response.json())
        .then((result) => {
          this.characters = result.data;
        });
      },
      
      // start the game with selected character
      async toGame(id) {
          let url = new URL('http://localhost:3000/Api/index.php');
          url.search = `?route=/game&id=${id}`;
          
          await fetch(url, {
            credentials: 'include',
          })
          .then((response) => response.json())
          .then((result) => {
            const characterStore = useCharacterInfo();

            if(characterStore.$state.hasOwnProperty([id]) === false)
            {
              result.data.general = {
                  percent: 100,
                  characterArmor: {
                    'Casque': 0,
                    'Plastron': 0,
                    'Gants': 0,
                    'Bottes': 0,
                  },
                  weapon: 'Aucune',
                  beforeBoss: 10,
              };
                
              characterStore.$patch({
                currentCharacterId: [id],
                [id]: result['data'],
              });
            } else {
              characterStore.$patch({
                currentCharacterId: [id],
              });
            }
            this.$router.push({path:'/game-explo'});
          });
      },
    },
    mounted() {
      this.listCharacters();
    },
  };
</script>

