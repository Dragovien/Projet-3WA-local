<script setup>
  import { Equipment } from '@/assets/js/exploration/equipment.js';
</script>

<template>
  <div v-if="randomEvent">
    <div v-if="treasureEvent">
      <p>Vous trouvez un coffre ! Veuillez choisir votre pièce d'équipement</p>
      <select v-model="selected" @change="saveEquipment" class="select--treasure">
        <option disabled value="">Choisissez la pièce d'équipement à prendre</option>
        <option v-for="equipment in this.equipmentFound.treasure()">
        {{equipment}}
        </option>
      </select>
      <p>Vous avez choisi: {{this.selected}}</p>
    </div>

    <p v-if="foodEvent">Vous trouvez de la nourriture! Vous vous soignez de 5 points de vie.</p>
    <p v-if="elixirEvent">Vous trouvez un elixir ! Vous gagnez 5 points de vie max.</p>
    <p v-if="fountainEvent">Vous trouvez une fontaine de soin ! Vous récupérez 50% de votre vie</p>
    <p v-if="monsterEvent">Un montre surgit devant vous !</p>
  </div>
</template>


<script>
  export default {
    name: 'TextInterfaceExplo',
    data() {
      return {
        randomEvent: false,
        treasureEvent: false,
        foodEvent: false,
        elixirEvent: false,
        fountainEvent: false,
        equipmentEvent: false,
        monsterEvent: false,
        equipmentFound: new Equipment(),
        selected: '',
      }
    },
    methods: {
      // emit selected equipment
      saveEquipment() {
        this.$emit('equipButton', {
          value: this.selected,
          selected: true,
        });
      },
    },
    props: {
      textRandomEventProp: Object,
    },
    watch: {
      // trigger when textRandomEventProp changes, and display text according to value 
      textRandomEventProp: {
        handler: function() {
          this.randomEvent = true;
          let value = this.textRandomEventProp['value'];
          switch(value) {
            case 'treasure': 
              this.treasureEvent = true;
              break;
            case 'food': 
              this.foodEvent = true;
              break;
            case 'elixir': 
              this.elixirEvent = true;
              break;
            case 'fountain': 
              this.fountainEvent = true;
              break;
            case 'equipment': 
              this.equipmentEvent = true;
              break;
            case 'monster': 
              this.monsterEvent = true;
              break;
            default:
              console.log('Prop is incorrect')
          }
        },
        immediate: true,
      },
    },
  };
</script>