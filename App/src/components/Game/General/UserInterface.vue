<script setup>
  import {useCharacterInfo} from '@/stores/character.js';
  const characterStore = useCharacterInfo();
  const id = characterStore.currentCharacterId;
</script>


<template>
  <div class="character-info flex-wrap">
    <div class="character-info__basic flex-wrap w-100">
      <p class="character-info__category text-center w-100">
        <b class="character-info__category-name">Infos de base :</b>
      </p>
      <p class="character-info__category text-center w-100">
        <b>Nom</b> : {{characterStore.$state[id].name}}
      </p>
      <p class="character-info__category text-center w-100">
        <b>Race</b> : {{characterStore.$state[id].race.raceName}}
      </p>
      <p class="character-info__category text-center w-100">
        <b>Sexe</b> : {{characterStore.$state[id].sex}}
      </p>
      <div class="character-info__hp">
        <p class="character-info__category-text">
          <b>HP :</b> 
        </p>
        <div class="hp-bar hp-bar--character">
          <span class="hp-bar__current"></span>
          <p class="character-info__numbers">
            {{characterStore.$state[id].currentHp}} / {{characterStore.$state[id].race.raceInitialHp}}
          </p>
        </div>
      </div>
    </div>
    <div class="character-info__equipment character-info__adjust">
      <p>
        <b class="character-info__category-name">Equipement actuel :</b>
      </p>
      <div class="character-info__list">
        <p v-for="(armor, index) in characterStore.$state[id].general.characterArmor" class="character-info__armor">{{index}}: {{armor}}</p>
      </div>
      <p>Arme: {{characterStore.$state[id].general.weapon}}</p>
    </div>
    <div class="character-info__counter character-info__adjust">
      <p>
        Points à gagner pour faire apparaitre le boss: {{characterStore.$state[id].general.beforeBoss}}
      </p>
    </div>
  </div>
</template>

<script>
  export default {
    name: 'userInterface',
    props: {
      playerHpPercentProp: Number,
    },
    watch: {
      
      // trigger whent playerHpPercentProp changes, update width of hp bar
      playerHpPercentProp: function() {
          let playerHpBar= document.querySelector('.hp-bar__current');

          if(this.playerHpPercentProp <= 0) {
            playerHpBar.style.width= '0%';
          } else {
            playerHpBar.style.width= this.playerHpPercentProp+'%';
          }
      },
    },
  };
</script>