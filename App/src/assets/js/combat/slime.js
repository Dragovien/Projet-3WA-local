import {Foe} from './foe.js';

export class Slime extends Foe {
  constructor(foeHpPercent, damageReceived, counter) {
    super(foeHpPercent, damageReceived, counter);
    this.foeHpInitial = 5;
    this.foeHp = 5;
  }
  
  // method which returbs slime monster
  slimeObject() {
    let slime = {
      foeHpInitial: this.foeHpInitial,
      foeHp: this.foeHp,
      foeHpPercent: this.foeHpPercent,
      damageReceived: this.damageReceived,
      counter: this.counter,
      image: '/src/assets/img/GameLayout/monsters/Metal_Slime_Artwork.webp',
      reduce: 5,
    };
    return slime;
  }
}
