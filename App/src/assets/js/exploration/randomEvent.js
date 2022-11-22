import {useCharacterInfo} from '@/stores/character.js';

export class randomEvent {
  // method that start foe encounter/heal/give more hp max or let user select an equipment
  event(
    value, 
    text,
    monster,
    elixir,
    food,
    fountain,
    player,
  ) {
    text['value'] = value;

    // change value and show event
    switch(value) {
      case 'monster':
        monster['counter']++;
        break;
      case 'elixir':
        player['playerHpInitial'] += 5;
        elixir['counter']++;
        break;
      case 'food':
        player['playerHp'] += 5;
        food['counter']++;
        break;
      case 'fountain' :
        player['playerHp'] += Math.floor(player['playerHpInitial'] / 2);
        fountain['counter']++;
        break;
      case 'treasure': 
        console.log("Select your equipment")
        break;
      default: 
        console.log("Value is incorrect")
    };

    // if current hp > current max hp
    if(player['playerHp'] > player['playerHpInitial']) {
      player['playerHp'] = player['playerHpInitial'];
    }
    // health bar update
    player['playerHpPercent'] = (player['playerHp'] / player['playerHpInitial']) * 100;
    text['counter']++;

    // saving new values in store
    const characterStore = useCharacterInfo();
    const id = characterStore.currentCharacterId;
    characterStore.$state[id].currentMaxHp = player['playerHpInitial'];
    characterStore.$state[id].currentHp = player['playerHp'];
    characterStore.$state[id].general.percent = player['playerHpPercent'];
  }
}