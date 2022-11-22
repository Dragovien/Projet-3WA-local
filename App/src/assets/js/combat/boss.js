import {Foe} from './foe.js';

export class Boss extends Foe {
  constructor(foeHpPercent, damageReceived, counter) {
    super(foeHpPercent, damageReceived, counter);
    this.foeHpInitial = 40;
    this.foeHp = 40;
  }
  
  // method which returns boss monster
  bossObject() {
    let boss = {
      foeHpInitial: this.foeHpInitial,
      foeHp: this.foeHp,
      foeHpPercent: this.foeHpPercent,
      damageReceived: this.damageReceived,
      counter: this.counter,
      image: '/src/assets/img/GameLayout/monsters/Dragonlord.webp',
    };
    return boss;
  }
}