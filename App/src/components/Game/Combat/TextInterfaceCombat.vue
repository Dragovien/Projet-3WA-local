<template>
  <div v-if="showInit" class="text w-100">
    <p>
      <b class="text--color">Test d'initiative:</b>
    </p>
    <p>
      Le joueur a roll un <b class="text--color">{{initiativeProp.playerInit}}</b>.
    </p>
    <p>
      L'ennemi a roll un <b class="text--color">{{initiativeProp.foeInit}}</b>.
    </p>
    <p v-if="playerWinInitiative">
      <b class="text--color">Le joueur gagne !</b>
    </p>
    <p v-if="foeWinInitiative">
      <b class="text--color">L'ennemi gagne !</b>
    </p>
  </div>

  <div v-if="showD100" class="text w-100">
    <p class="text--color">Roll du D100:</p>
    <p>Le joueur a roll un <b>{{d100Prop.value}}</b>.</p>
    <div class="text--color">
      <p v-if="d100Prop.value <=10">C'est une réussite critique. Les dégâts infligés seront doublés.</p>
      <p v-else-if="d100Prop.value <=70">C'est une réussite normale.</p>
      <p v-else-if="d100Prop.value <=89">C'est un échec. Vous ratez votre attaque.</p>
      <p v-else="d100Prop.value <=100">C'est un échec critique. Vous vous infligez des dégâts.</p>
    </div>
  </div>

  <div v-if="showDamageText" class="text w-100">
    <p>Vous infligez <b>{{damageDoneProp.damageReceived}}</b> point(s) de dégât(s) !</p> 
    <p v-if="damageDoneProp.foeHp > 0">Il reste à l'ennemi <b>{{damageDoneProp.foeHp}}</b> Hp.</p>
    <div v-else>
      <div v-if="damageDoneProp.foeHpInitial < 40">
        <p>L'ennemi a perdu tous ses HP.</p>
        <p class="text--color">Vous avez gagné le combat !</p>
      </div>
      <div v-else>
        <p>Le boss est vaincu.</p>
        <p class="text--color">Félicitation, vous avez fini le jeu !</p>
      </div>
    </div>
      
  </div>

  <div v-if="showSelfDamageText">
    <p>Vous vous infligez <b>{{selfDamageProp.selfDamage}}</b> point(s) de dégât(s) !</p>
    <p v-if="playerHpLeft > 0">Il vous reste <b>{{playerHpLeft}}</b> Hp.</p>
    <div v-else>
      <p>Vous avez perdu tous vos HP.</p>
      <p>Votre personnage s'évanouit !</p>
    </div>
  </div>

  <div v-if="showFoeDamageText">
    <p>L'ennemi inflige <b>{{damageTakenProp.damage}}</b> point(s) de dégât(s) !</p>
    <p v-if="playerHpLeft > 0">Il vous reste <b>{{playerHpLeft}}</b> Hp.</p>
    <div v-else>
      <p>Vous avez perdu tous vos HP.</p>
      <p>Votre personnage s'évanouit !</p>
    </div>
  </div>
</template>

<script>
  export default {
    name: 'TextInterfaceCombat',
    data() {
      return {
        playerWinInitiative: false,
        foeWinInitiative: false,

        showInit: true,
        showD100: false,
        showDamageText: false,
        showFoeDamageText: false,
        showSelfDamageText: false,
      };
    },
    props: {
      initiativeProp: Object,
      d100Prop: Object,
      damageDoneProp: Object,
      damageTakenProp: Object,
      playerHpLeft: Number,
      selfDamageProp: Object,
    },
    methods: {
      
      // method used after initiative rolls bay the character and foe
      winInitiative() {
        if(this.initiativeProp.playerInit >= 
        this.initiativeProp.foeInit) {
          this.playerWinInitiative = true;
        } else {
          this.foeWinInitiative = true;
        }
      },
    },
    watch: {
      
      // activate in case the prop changed = initiative rolls has been made
      initiativeProp: {
          handler: function() {
              this.showInit = true;
              this.showD100= false,
              this.showDamageText = false;
              this.showFoeDamageText = false;
              this.showSelfDamageText = false;
              this.winInitiative();
          },
          deep: true
      },
  
      // activate in case the prop changed = d100 rolls has been made
      d100Prop: {
        handler: function() {
          this.showD100 = true;
          this.showInit = false;
          this.playerWinInitiative = false;
          this.foeWinInitiative = false;
        },
        deep: true
      },
  
      // activate in case the prop changed = character damage roll has been made
      damageDoneProp: {
        handler: function() {
          this.showD100 = false;
          this.showInit = false;
          this.showDamageText = true;
          this.playerWinInitiative = false;
          this.foeWinInitiative = false;
        },
        deep: true
      },
  
      // activate in case the prop changed = foe damage roll has been made
      damageTakenProp: {
        handler: function() {
          this.showInit = false;
          this.showFoeDamageText = true;
          this.playerWinInitiative = false;
          this.foeWinInitiative = false;
        },
        deep: true
      },
  
      // activate in case the prop changed = character self-damage roll has been made
      selfDamageProp: {
        handler: function() {
          this.showD100 = false;
          this.showSelfDamageText = true;
          this.playerWinInitiative = false;
          this.foeWinInitiative = false;
        },
        deep: true
      },
    },
    mounted() {
      this.winInitiative();
    }
  }
</script>
