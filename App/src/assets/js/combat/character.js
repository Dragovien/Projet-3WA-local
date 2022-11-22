import {Initiative} from './initiative.js';
import {useCharacterInfo} from '@/stores/character.js'; 
import {Equipment} from '../exploration/equipment.js';
const characterStore = useCharacterInfo();
const characterId = characterStore.currentCharacterId;

export class Character extends Initiative{
  constructor(diceValue) {
      super(diceValue);
  }
  
  // d100 roll calcul
  d100() {
    let d100Result = this.dice(100);
    // if character race is oni, +10 to d100 roll
    if(characterStore.$state[characterId].race.raceName === 'Oni') {
        d100Result += 10;
        if(d100Result > 100) {
            d100Result = 100;
        }
    }
    return d100Result;
  }
  
  //  damage roll calcul and player hp update
  damage(data,value) {
    let weapon = new Equipment();
    value += weapon.currentWeapon();
    
    if(characterStore.$state[characterId].race.raceName === 'Oni') {
         value+=1;
    }
    data['damageReceived'] = value;
    data['foeHp'] -= value;
    data['counter']++;
    data['foeHpPercent'] = (data['foeHp'] / data['foeHpInitial']) * 100;
  }
  
  //  self-damage roll calcul and player hp update
  selfDamage(data, value, player) {
    data['selfDamage'] = value;
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
    document.getElementById('overlay').classList.add("crit-fail");
  }
}

