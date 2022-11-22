<template>
  <div class="combat-interface">
    <img :src=image alt="foe image" class="combat-interface__image mx-auto" id="foe"/>
    <div class="hp-bar hp-bar--adjust mt-2 mx-auto" id="foe-bar">
      <span class="hp-bar__current" id="foe-hp"></span>
    </div>
  </div>
</template>


<script>
  export default {
    name: 'graphicInterface-combat',
    props: {
      initiativeProp: Object,
      foeHpPercentProp: Number,
      damageDoneProp: Object,
      d100Prop: Object,
      image: String,
    },
    watch: {

      initiativeProp: {
        handler: function() {
          document.getElementById('foe').classList.remove("miss");
          document.getElementById('foe').classList.remove("rotate");
          document.getElementById('screen').classList.remove("shakeDiv");
          document.getElementById('screen').classList.remove("crit-fail");
        },
        deep: true
      },

      foeHpPercentProp: function() {
        let foeHpBar= document.querySelector('#foe-hp');

        if(this.foeHpPercentProp <= 0) {
          foeHpBar.style.width= '0%';
          document.getElementById('foe').classList.add("death");
          document.querySelector('#foe-bar').style.display="none";
        } else {
          foeHpBar.style.width= this.foeHpPercentProp+'%';
        }
      },

      damageDoneProp: {
        handler: function() {
          if(this.foeHpPercentProp > 0) {
            document.getElementById('foe').classList.add("rotate");
          }
        },
        deep: true
      },

      d100Prop: {
        handler: function() {
          let result = this.d100Prop.value;
          if(result >= 71 && result <=89) {
            document.getElementById('foe').classList.add("miss");
          }
        },
        deep: true
      },
    },
  }
</script>