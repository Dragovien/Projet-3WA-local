import {useCharacterInfo} from '@/stores/character.js';
const characterStore = useCharacterInfo();
const characterId = characterStore.currentCharacterId;

export class Initiative {
    
  constructor(diceValue) {
    this.diceValue = diceValue;
  }

  // Random integer between 1 et dice max value
  dice(diceValue) {
    let result = Math.floor(Math.random() * diceValue) + 1;
    return result;
  }

  // player initiative calcul
  playerInitiative() {
    let playerInit = this.dice(this.diceValue);
    // if character race is elf, +1 to initiative
    if(characterStore.$state[characterId].race.raceName === 'Elf') {
      playerInit += 1;
      if(playerInit === 7) {
          playerInit = 6;
      }
    // if character race is dwarf, -1 to initiative
    } else if (characterStore.$state[characterId].race.raceName === 'Dwarf') {
      playerInit -= 1;
      if(playerInit === 0) {
        playerInit = 1;
      }
    }
    return playerInit;
  }
  
  // foe initiative calcul
  foeInitiative() {
    let foeInit = this.dice(this.diceValue);
    return foeInit;
  }

  // creation of ini object sent to GameLayout
  calculInit(tableIni) {
    let ini = {
      playerInit: 0,
      foeInit: 0,
    };
    ini['playerInit'] = tableIni[0];
    ini['foeInit'] = tableIni[1];
    document.getElementById('bgm').volume = 0.05;
    document.getElementById('bgm').play();
    return ini;
  }
}