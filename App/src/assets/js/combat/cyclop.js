import {Foe} from './foe.js';

export class Cyclop extends Foe {
  constructor(foeHpPercent, damageReceived, counter) {
    super(foeHpPercent, damageReceived, counter);
    this.foeHpInitial = 15;
    this.foeHp = 15;
  }
  
  // method which returbs cyclop monster
  cyclopObject() {
    let cyclop = {
      foeHpInitial: this.foeHpInitial,
      foeHp: this.foeHp,
      foeHpPercent: this.foeHpPercent,
      damageReceived: this.damageReceived,
      counter: this.counter,
      image: '/src/assets/img/GameLayout/monsters/Cyclop.png',
      reduce: 15,
    };
    return cyclop;
  }
}

