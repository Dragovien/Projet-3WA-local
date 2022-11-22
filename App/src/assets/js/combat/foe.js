import {Initiative} from './initiative.js';
import {useCharacterInfo} from '@/stores/character.js'; 
import {Equipment} from '../exploration/equipment.js';


export class Foe extends Initiative {
  constructor(diceValue) {
    super(diceValue);
    this.foeHpPercent = 100;
    this.damageReceived = 0;
    this.counter = 0;
  }
  
  // damage roll calcul
  foeDamageCalcul () {
    foeDamages = Dice(6);
  }
  
  //  method which update player hp
  damage(data, value, player) {
    let armor = new Equipment();
    value -= armor.currentArmor();
    if(value < 0) {value = 0}

    data['damage'] = value;
    data['counter']++;
    player['playerHp'] -= value;
    if(player['playerHp'] < 0) {
      player['playerHp'] = 0;
    }
    player['playerHpPercent'] = (player['playerHp'] / player['playerHpInitial']) * 100;

    const characterStore = useCharacterInfo();
    const id = characterStore.currentCharacterId;
    characterStore.$patch({
      [id]: 
      {
        currentHp: player['playerHp'],
        general: {
          percent: player['playerHpPercent'],
        }
      },
            
    });
    document.getElementById('screen').classList.add("shakeDiv");
  }
}