import {Foe} from './foe.js';

export class Golem extends Foe {
  constructor(foeHpPercent, damageReceived, counter) {
    super(foeHpPercent, damageReceived, counter);
    this.foeHpInitial = 10;
    this.foeHp = 10;
  }
  
  // method which returbs cyclop monster
  golemObject() {
    let golem = {
      foeHpInitial: this.foeHpInitial,
      foeHp: this.foeHp,
      foeHpPercent: this.foeHpPercent,
      damageReceived: this.damageReceived,
      counter: this.counter,
      image: '/src/assets/img/GameLayout/monsters/Golem.png',
      reduce: 10,
    };
    return golem;
  }
}