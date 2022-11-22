import {defineStore} from 'pinia';

export const useCharacterInfo = defineStore('currentCharacter', {
  state: () => {
    return {
      currentCharacterId: '',
    }
  },
  persist: true,
})