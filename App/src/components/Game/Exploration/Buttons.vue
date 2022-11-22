<template>
  <div class="explo-buttons">
    <!-- start random event  -->
    <button 
      type="submit" class="button button--styled button--explo-adjust" 
      @click="randomEvent" v-show="randomBtn"
    >
      Lancer l'évènement
    </button>
    
    <!-- chose equipment  -->
    <button 
      type="submit" class="button button--styled button--explo-adjust" 
      @click="validateEquipment" v-show="equipBtn"
    >
      Valider l'équipement
    </button>
    
    <!-- start combat  -->
    <button 
      type="submit" class="button button--styled button--explo-adjust" 
      @click="toCombat" v-show="combatBtn"
    >
      Commencer le combat
    </button>
    
    <!-- avoid combat  -->
    <button 
      type="submit" class="button button--styled button--explo-adjust" 
      @click="flee" v-show="combatBtn"
    >
      Fuir le combat
    </button>
    
    <!-- back to exploration screen  -->
    <button 
      type="submit" class="button button--styled button--explo-adjust" 
      @click="toExplo" v-show="exploBtn"
    >
      Retour à l'exploration
    </button>
    
    <!-- directly fight the boss, only appear when boss counter = 0  -->
    <button 
      type="submit" class="button button--styled button--explo-adjust" 
      @click="toCombat" v-show="bossBtn"
    >
      Affronter directement le boss
    </button>
  </div>
</template>

<script>
  export default {
    name: 'Button-explo',
    data() {
      return {
        combatBtn: false,
        randomBtn: true,
        exploBtn: false,
        equipBtn: false,
        bossBtn: false,
      };
    },
    props: {
      monsterProp: Object,
      elixirProp: Object,
      fountainProp: Object,
      foodProp: Object,
      treasureProp: Object,
      bossProp: Boolean,
    },
    watch: { 
      // trigger when monsterProp changes, display corresponding button
      monsterProp: {
        handler: function() {
          this.combatBtn = true;
        },
        deep: true
      },
      
       // trigger when elixirProp changes, display corresponding button
      elixirProp: {
        handler: function() {
          this.exploBtn = true;
        },
        deep: true,
      },
      
       // trigger when fountainProp changes, display corresponding button
      fountainProp: {
        handler: function() {
          this.exploBtn = true;
        },
        deep: true
      },
      
       // trigger when foodProp changes, display corresponding button
      foodProp: {
        handler: function() {
          this.exploBtn = true;
        },
        deep: true
      },
      
       // trigger when treasureProp changes, display corresponding button
      treasureProp: {
        handler: function() {
          this.equipBtn = true;
        },
        deep: true
      },
      
       // trigger when bossProp changes, display corresponding button
      bossProp: function() {
        this.bossBtn = true;
        this.$emit('boss', true);
      },
    },
    methods: {
      
      // method emits start of random event to GameLayout and call the appropriate method
      randomEvent() {
        this.$emit('random', true);
        this.randomBtn = false;
        this.bossBtn = false;
      },
      
       // method emits start of equipment event to GameLayout and call the appropriate method
      validateEquipment() {
        this.$emit('equipment', true);
        this.equipBtn = false;
        this.$router.go(0);
      },
      
       // method emits start of combat event to GameLayout and call the appropriate method
      toCombat() {
        this.$emit('combat', true);
        this.combatBtn = false;
        this.bossBtn = false;
        this.randomBtn = false;
        this.$router.push({path:'/game-combat'});
      },
      
       // method emits to GameLayout to end current event
      toExplo() {
        this.exploBtn = false;
        this.$router.go(0);
        this.$emit('toExplo', 'explo');
      },
      
       // reload the page to avoid combat event
      flee() {
        this.$router.go(0);
      },

      
    },
  };
</script>