<script setup>
  import HeaderGame from '@/components/Multiple-uses/Header.vue';
  
  import UserInterface from '@/components/Game/General/UserInterface.vue';
  import GraphicInterfaceCombat from '@/components/Game/Combat/GraphicInterface.vue';
  import RandomEvent from '@/components/Game/Exploration/Slider.vue';
  
  import TextInterfaceCombat from '@/components/Game/Combat/TextInterfaceCombat.vue';
  import TextInterfaceExplo from '@/components/Game/Exploration/TextInterfaceExplo.vue';
  
  import CombatButtons from '@/components/Game/Combat/Buttons.vue';
  import ExploButtons from '@/components/Game/Exploration/Buttons.vue';

  import {GameAudio} from '@/assets/js/combat/audio.js';
  import { randomEvent } from '@/assets/js/exploration/randomEvent.js';
  import { Equipment } from '@/assets/js/exploration/equipment';
  import {Initiative} from '@/assets/js/combat/initiative.js';
  import {Foe} from '@/assets/js/combat/foe.js';
  import {Slime} from '@/assets/js/combat/slime.js';
  import {Golem} from '@/assets/js/combat/golem.js';
  import {Cyclop} from '@/assets/js/combat/cyclop.js';
  import {Boss} from '@/assets/js/combat/boss.js';
  import { Character } from '@/assets/js/combat/character.js';
</script>

<template>
  <HeaderGame/>
  <main class="main main--game-layout">
    <div class="main__game-col1">
      <div class="main__user-interface interface flex-block">
        <UserInterface
            :playerHpPercentProp="player.playerHpPercent"
        />
      </div>
    </div>

    <div class="main__game-col2">
      <div class="main__sub-col1">
        <div class="main__audio flex-justify mt-4">
          <audio 
            controls loop 
            src="/src/assets/audio/GameLayout/battle.mp3" 
            type="audio/mpeg" id="bgm"
          ></audio>
        </div>

        <div class="main__graphical-interface" id="screen"> 
          <div id="overlay"></div>
          <img :src=this.bg1 alt="background image" class="main--img-bg"/>
          <GraphicInterfaceCombat
          :initiativeProp="initiative"
          :d100Prop="d100"
          :foeHpPercentProp="foe.foeHpPercent"
          :damageDoneProp="foe"
          :damageTakenProp="foeDamage"
          :image="this.foe.image"
          v-if="combat"
          />
          <RandomEvent
          :randomEventProp="random.counter"
          @randomEvent="showEvent"
          :event1="eventImage1"
          :event2="eventImage2"
          :event3="eventImage3"
          :event4="eventImage4"
          :event5="eventImage5"
          v-if="event"
          />
        </div>
      </div>
      <div class="main__sub-col2">
            <div class="main__text-interface interface">
                <TextInterfaceCombat 
                :initiativeProp="initiative" 
                :d100Prop="d100"
                :damageDoneProp="foe"
                :playerHpLeft="player.playerHp"
                :damageTakenProp="foeDamage"
                :selfDamageProp="selfDamagePlayer"
                v-if="show"/>
                <TextInterfaceExplo
                :textRandomEventProp="textRandomEvent"
                @equipButton="getEquipment"
                v-if="showExploText"/>
            </div>
    
            <div class="main__button-interface" >
                <CombatButtons 
                    @table="initValues" 
                    @d100Result="d100Value"
                    @playerDamages="damageInflicted"
                    @criticalDamages="damageInflicted"
                    @selfDamages="selfDamageCalcul"
                    @foeDamages="damageTaken"
                    :battleEnd="end"
                    :battleLost="fainted"
                    @toExplo="showExploration"
                    v-if="combat"
                />
                <ExploButtons
                    @random="showRandom"
                    @combat="showCombat"
                    :explo="explo.counter"
                    :monsterProp="monsterEncounter"
                    :elixirProp="elixir"
                    :fountainProp="fountain"
                    :foodProp="food"
                    :treasureProp="choseEquipment"
                    @equipment="setEquipment"
                    :bossProp="toBoss"
                    @boss="showBoss"
                    v-if="explo"
                />
            </div>
        </div>
    </div>
  </main>
</template>

<script>
  import {useCharacterInfo} from '@/stores/character.js';
    
  export default {
    name: 'GameLayout',
    data() {
      return{
        random: {counter: 0,},
        monsterEncounter: {count: 0,},
        equipment: {count: 0,},
        elixir: {counter: 0,},
        fountain: {counter: 0,},
        food: {count: 0,},
        choseEquipment: {counter: 0,},
        textRandomEvent: {
            value: '',
            counter: 0,
        },
        initiative: {},
        d100: {counter: 0,},
        foe: {counter: 0,},
        foeDamage: {counter: 0,},
        player: {counter: 0,},
        selfDamagePlayer: {counter: 0,},
        beforeBoss: 0,
        
        show: false,
        explo: {
            explo: true,
            counter: 0,
        },
        event: true,
        showExploText: false,
        combat: false,
        end: false,
        fainted: false,
        toBoss: false,
        
        bg1: '/src/assets/img/GameLayout/room1.jpg',
        eventImage1: '/src/assets/img/GameLayout/events/treasureChest.png',
        eventImage2: '/src/assets/img/GameLayout/events/food.jpg',
        eventImage3: '/src/assets/img/GameLayout/events/elixir.png',
        eventImage4: '/src/assets/img/GameLayout/events/fountain.jpg',
        eventImage5: '/src/assets/img/GameLayout/events/monster.jpg',

        audio: new GameAudio(),
        init: new Initiative(),
        character: new Character(),
        chosenEvent: new randomEvent(),
        wearEquipment: new Equipment(),
        monster: new Foe(),
        slime: new Slime(),
        golem: new Golem(),
        cyclop: new Cyclop(),
        boss: new Boss(),
      };
    },
    methods: {
      
      /**********************************************************************************************************************************************************
                                                                          COMBAT METHODS
      **********************************************************************************************************************************************************/
      
      // increment counter and trigger the watch of randomEventProp by RandomEvent component
      showRandom() {
        this.random['counter']++;
      },

      // trigger 'event()' method from JS class 'randomEvent'
      showEvent(value) {
        this.chosenEvent.event(
          value,
          this.textRandomEvent, 
          this.monsterEncounter,
          this.elixir,
          this.food,
          this.fountain, 
          this.player,
        );
        this.showExploText = true;
      },

      // increment counter get value of the equipment chosen by the user
      getEquipment({value, selected}) {
        this.choseEquipment['equipment'] = value;
        this.choseEquipment['selected'] = selected;
        this.choseEquipment['counter']++;
      },

      // trigger 'addEquipment' method from JS class 'Equipment'
      setEquipment() {
        this.wearEquipment.addEquipment(this.choseEquipment['equipment']);
      },

      // display 'GraphicInterfaceCombat' component
      showCombat() {
        this.combat = true;
        this.explo['explo'] = false;
        this.showExploText = false;
        this.event = false;
      },

      // display 'RandomEvent' comonent
      showExploration() {
        this.combat = false;
        this.explo['counter']++;
        this.show = false;
      },
      
      // select the monster that will appear in case of combat event
      randomMonster() {
        let nbTypeMonsters = 1;
        if (this.beforeBoss <= 90 && this.beforeBoss >= 66) {
          nbTypeMonsters = 2;
        } else if (this.beforeBoss <= 65) {
            nbTypeMonsters = 3;
        }

        let monsterType = Math.floor(Math.random() * nbTypeMonsters) + 1;

        if(this.beforeBoss <= 0) {
          this.toBoss = true;
        }

        const monster = {
          1: this.slime.slimeObject(),
          2: this.golem.golemObject(),
          3: this.cyclop.cyclopObject(),
        };

        this.foe = monster[monsterType];
      },

      // set the monster that will appear as the boss
      showBoss() {
        this.foe = this.boss.bossObject();
      },
      
      /**********************************************************************************************************************************************************
                                                                          COMBAT METHODS
      **********************************************************************************************************************************************************/

      // trigger the 'calculInit()' method from JS class 'Initiative'
      initValues(table) {
        this.initiative = this.init.calculInit(table);
        this.show = true;
      },

      // update values of 'd100' data and increment its counter
      d100Value(value) {
        this.d100['value'] = value;
        this.d100['counter']++;
      },

      // trigger the 'damage()' method from JS class 'Character'
      damageInflicted(value) {
        this.character.damage(this.foe, value);
        if(this.foe['foeHp'] <= 0) {
          this.playerWin();

          if(this.foe['foeHpInitial'] === 40) {
              this.returnToList();
          }
        }
      },

      // trigger the 'selfDamage()' method from JS class 'Character'
      selfDamageCalcul(value) {
        this.character.selfDamage(
          this.selfDamagePlayer, 
          value, 
          this.player
        );
        if(this.player['playerHp'] <= 0) {
          this.playerLose();
        }
      },
      
      // trigger the 'damage()' method from JS class 'Foe'
      damageTaken(value) {
        this.monster.damage(this.foeDamage, value, this.player);
        if(this.player['playerHp'] <= 0) {
          this.playerLose();
        }
      },

      // play win music + update 'beforeBoss' counter of the character
      playerWin() {
        this.audio.win();
        this.end = true;

        const characterStore = useCharacterInfo();
        const id = characterStore.currentCharacterId;
        let newCount = this.beforeBoss - this.foe['reduce'];
        
        if(newCount < 0) {
          newCount = 0;
        }

        characterStore.$patch({
          [id]: {
            general: {
                beforeBoss: newCount,
            }
          } 
        });
      },

      // play lose music + display a button to return to the character list
      playerLose() {
        this.audio.lose();
        this.fainted = true;
      },

      // display a button to return to the character list
      returnToList() {
        this.end = false;
        this.fainted = true;
      },
    },
    mounted() {
      const characterStore = useCharacterInfo();
      const id = characterStore.currentCharacterId;
      
      // update 'player' data with character values in store
      this.player = 
        {
          playerHpInitial: characterStore.$state[id].currentMaxHp,
          playerHp: characterStore.$state[id].currentHp,
          playerHpPercent: characterStore.$state[id].general.percent,
        };
      
      // update 'beforeBoss' data with its value in store
      this.beforeBoss = characterStore.$state[id].general.beforeBoss;
      
      // select random monster
      this.randomMonster();
    },
  };
</script>