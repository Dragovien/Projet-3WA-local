export class GameAudio {
  constructor(audioSource) {
    this.audioSource = audioSource;
  }
  
  // method that plays the audio source
  sfx(source) {
    let sfx = new Audio(source);
    sfx.volume = 0.01;
    sfx.play();
  }
  
  // method that plays the audio source in case of victory
  win() {
    document.querySelector('#bgm').pause();
    setTimeout(this.sfx("/src/assets/audio/GameLayout/victory.mp3"), 1000);
  }
  
  // method that plays the audio source in case of death
  lose() {
    document.querySelector('#bgm').pause();
    setTimeout(this.sfx("/src/assets/audio/GameLayout/death.mp3"), 1000);
  }
}