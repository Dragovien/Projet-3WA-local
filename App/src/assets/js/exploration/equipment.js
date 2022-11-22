import {useCharacterInfo} from '@/stores/character.js';
import { Initiative } from '../combat/initiative';
const characterStore = useCharacterInfo();
const id = characterStore.currentCharacterId;

export class Equipment extends Initiative {
  
  constructor(diceValue) {
      super(diceValue);
  }

  // method that calculates damage reduction according to how many pieces of armor the player have
  currentArmor() {
    let damageReduction = 0;
    Object.values(characterStore.$state[id].general.characterArmor).forEach(val => {
        if(val === 1) {
          damageReduction++;
        }
    })
    return damageReduction;
  }

  // method that calculates damage ameioration according to the weapon currently equipped
  currentWeapon() {
    let additionalDamage = 0;
    const weapons = {
        'Aucune' : 0,
        'Couteau' : 1,
        'Épée' : 2,
        'Épée légendaire' : 3
    } 
    additionalDamage = weapons[characterStore.$state[id].general.weapon];
    return additionalDamage;
  }

  // method that return a table will the choices you can select for the treasure
  treasure() {
      let equipments = [
              'Casque',
              'Plastron',
              'Gants',
              'Bottes',
              'Arme',
          ];
      return equipments;
  }

  // method that randomly choose the obtained weapon or add the armor piece 
  addEquipment(piece) {
    if(piece === 'Arme') {
      let D100 = this.dice(100);
      if (D100 < 60) {
        characterStore.$state[id].general.weapon = 'Couteau';
      } else if (D100 < 90) {
        characterStore.$state[id].general.weapon = 'Épée';
      } else {
        characterStore.$state[id].general.weapon = 'Épée légendaire';
      }
    } else {
      characterStore.$state[id].general.characterArmor[piece] = 1;
    }
  }
}