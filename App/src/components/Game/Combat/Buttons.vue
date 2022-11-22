<template>
  <div class="combat-buttons flex-justify">
    <!-- start initiative comparison  -->
    <button 
    type="submit" class="button button--styled" @click="initiativeCalcul" v-show="initBtn">
      Calcul de l'initiative
    </button>
    <!-- start roll D100  -->
    <button type="submit" class="button button--styled" @click="d100Result" v-show="d100Btn">
      Roll du D100
    </button>
    <!-- start calcul of player damages  -->
    <button type="submit" class="button button--styled" @click="playerDamage" v-show="playerDamagesBtn">
      Calcul des dégâts de votre attaque
    </button>
    <!-- start calcul of foe damages  -->
    <button type="submit" class="button button--styled" @click="foeDamage" v-show="foeDamagesBtn">
      Calcul des dégâts ennemis
    </button>
    <!-- start calcul of critical damages  -->
    <button type="submit" class="button button--styled" @click="criticalDamage" v-show="critDamagesBtn">
      Calcul des dégâts critiques
    </button>
    <!-- start calcul of self-damages  -->
    <button type="submit" class="button button--styled" @click="selfDamage" v-show="selfDamagesBtn">
      Calcul des dégâts d'échec critique
    </button>
    <!-- return to exploration screen  -->
    <button type="submit" class="button button--styled" v-show="endBtn" @click="toExploration()">
      Fin du combat
    </button>
    <!-- return to character list  -->
    <button type="submit" class="button button--styled" v-show="faintedBtn" @click="toCharacter()">
      Retour à la liste de personnages
    </button>
  </div>
</template>

<script>
  import {Initiative} from '@/assets/js/combat/initiative.js';
  import {Character} from '@/assets/js/combat/character.js';
  import {Foe} from '@/assets/js/combat/foe.js';
  import {GameAudio} from '@/assets/js/combat/audio.js';
  import {useSignInStore} from '@/stores/account.js';
  import {useCharacterInfo} from '@/stores/character.js'; 

  export default {
    name: 'combat-buttons',
    data() {
      return {
        initiativeCheck: new Initiative(6),
        player: new Character(),
        foe: new Foe(),
        initBtn: true,
        d100Btn: false,
        foeDamagesBtn: false,
        critDamagesBtn: false,
        playerDamagesBtn: false,
        selfDamagesBtn: false,
        endBtn: false,
        faintedBtn: false,
        audio: new GameAudio(),
      }
    },
    props: {
      battleEnd: Boolean,
      battleLost: Boolean,
    },
    methods: {
      
      // method to compare initiative rolls and emit the result
      initiativeCalcul() {
        let table = [];
        table.push(this.initiativeCheck.playerInitiative());
        table.push(this.initiativeCheck.foeInitiative());
        this.$emit('table', table);
        this.initBtn = false;

        if(table[0] >= table[1]) {
          this.d100Btn = true;
        } else {
          this.foeDamagesBtn = true;
        }
      },

      // method to roll d100 and emit the result
      d100Result() {
        let d100Result = this.player.d100();
        this.$emit('d100Result', d100Result);

        switch(true) {
          case (d100Result <= 10): 
            this.critDamagesBtn = true;
            break;
          case (d100Result <= 70):
            this.playerDamagesBtn = true;
            break;
          case (d100Result <= 89):
            this.initBtn = true;
            this.d100Btn = false;
            this.audio.sfx("/src/assets/audio/GameLayout/miss.mp3");
            break;
          case (d100Result <= 100):
            this.selfDamagesBtn = true;
            break;
        }
        this.d100Btn = false;
      },

      // method to roll player damages and emit the result
      playerDamage() {
        this.audio.sfx('/src/assets/audio/GameLayout/hit.mp3');
        let playerDamages = this.player.dice(6);
        this.$emit('playerDamages', playerDamages);

        this.playerDamagesBtn = false;
        this.initBtn = true;
      },
      
      // method to roll player critical damages and emit the result
      criticalDamage() {
        this.audio.sfx('/src/assets/audio/GameLayout/critical.mp3');
        let criticalDamages = (this.player.dice(6)) * 2;
        this.$emit('criticalDamages', criticalDamages);

        this.critDamagesBtn = false;
        this.initBtn = true;
      },
      
      // method to roll self-damages and emit the result
      selfDamage() {
        this.audio.sfx('/src/assets/audio/GameLayout/receive-damage.mp3');
        let selfDamages = this.player.dice(3);
        this.$emit('selfDamages', selfDamages);

        this.selfDamagesBtn = false;
        this.initBtn = true;
      },
      
      // method to roll foe damages and emit the result
      foeDamage() {
        this.audio.sfx('/src/assets/audio/GameLayout/attack.mp3');
        let foeDamages = this.foe.dice(6);
        this.$emit('foeDamages', foeDamages);

        this.foeDamagesBtn = false;
        this.initBtn = true;
      },
      
      // method to return to exploration phase
      toExploration() {
        this.endBtn = false;
        this.$router.go({path:'/game-explo'})
        this.$emit('toExplo', 'explo');
      },
      
      // method to return to character list
      toCharacter() {
        const accountStore = useSignInStore();
        const accountId = accountStore.currentUserId;

        const characterStore = useCharacterInfo();
        const characterId = characterStore.currentCharacterId;

        characterStore.$patch({
          [characterId]: {
            currentHp: characterStore.$state[characterId].race.raceInitialHp,
            currentMaxHp: characterStore.$state[characterId].race.raceInitialHp,
            general: {
              percent: 100,
              characterArmor: {
                  'Casque': 0,
                  'Plastron': 0,
                  'Gants': 0,
                  'Bottes': 0,
              },
              weapon: 'Aucune',
              beforeBoss: 10,
            }
          }
        });
        this.$router.push({path:`/${accountStore.$state[accountId].login}/characterPage`});
      }
    },
    watch: {
      // trigger when a combat is won, display the button to return to exploration
      battleEnd: function() {
        this.initBtn = false;
        this.endBtn = true;
      },
      
      // trigger when a combat is lost, display the button to return to character list
      battleLost: function() {
        this.initBtn = false;
        this.faintedBtn = true;
      }
    }
  }
</script>