<template>
  <div class="wrapper mt-5">
    <h2 class="mb-5">Création du personnage</h2>
    <form class="form">
        <div class="row mb-3">
          <label for="inputName" class="col-sm-4">Nom:</label>
          <div class="col-sm-8 row__col2">
            <span class="form-error">{{formErrors.name}}</span>
            <input 
              type="text" class="form-control" 
              id="inputName" name="inputName" 
              v-model="formData.name"
            >
          </div>
        </div>
  
        <div class="row mb-3">
          <label for="inputSex" class="col-sm-8">Votre sexe:</label>
          <div class="col-sm-4 row__col2">
            <span class="form-error">{{formErrors.sex}}</span>
            <div class="row__aligned-inputs">
              <label>
                <input 
                  type="radio" id="inputSex" 
                  name="sexe" value="Man" 
                  v-model="formData.sex"
                /> 
                  Homme
              </label>
              <label>
                <input 
                  type="radio" name="sexe" 
                  value="Woman" v-model="formData.sex"
                /> 
                Femme
              </label>
            </div>
          </div>
        </div>
  
        <div class="row mb-3">
          <label for="inputRace" class="col-sm-8">Votre race:</label>
          <div class="col-sm-4 row__col2">
            <span class="form-error">{{formErrors.race_id}}</span>
            <div class="row__aligned-inputs">
              <select 
                class="select" id="inputRace" 
                v-model="formData.raceId" @change="switchImages"
              >
                <option value="" disabled>Choisissez</option>
                <option value='1'>Nain</option>
                <option value='2'>Elfe</option>
                <option value='3'>Humain</option>
                <option value='4'>Oni</option>
              </select>
            </div>
          </div>
        </div>
  
        <div class="wrapper__image-wrapper" id="display">
          <div class="wrapper__show-image">
            <img 
              :src="blank" alt="race according to select" 
              class="wrapper__image" id="image"
            >
          </div>
        </div>
  
        <button 
          type="submit" name="accountSubmit" 
          class="button" @click="createCharacter"
        >
          Créer votre personnage
        </button>
    </form>
  </div>
</template>

<script>
  export default {
    name: "characterForm",
    data() {
      return {
      formErrors: {},
      formData: {},
      };
    },
    computed: {
      select: {
        get() {
            return document.getElementById("race");
        }
      },
      image: {
        get() {
            return document.getElementById("image");
        }
      },
      showImage: {
        get() {
            return document.getElementById("display");
        }
      },
    },
    methods: {
      // show image according to selection
      switchImages() {
        let valeur = this.formData.raceId;
        
        switch (valeur) {
          case '1':
              image.src=this.dwarf;
              this.showImage.classList.add('wrapper__image-wrapper--block');
              break;
          case '2':
              image.src=this.elf;
              this.showImage.classList.add('wrapper__image-wrapper--block');
              break;
          case '3':
              image.src=this.warrior;
              this.showImage.classList.add('wrapper__image-wrapper--block');
              break;
          case '4':
              image.src=this.oni;
              this.showImage.classList.add('wrapper__image-wrapper--block');
              break
          default:
              image.src=this.blank;
              break
        };
            
    },
        
        //  creation of a new character
        async createCharacter(event) {
          event.preventDefault();

          let url = new URL('http://localhost:3000/Api/index.php');
          url.search = '?route=/character';
          await fetch(url, {
            method: 'POST',
            credentials: 'include',
            header: {
            'Content-Type': 'application/json; charset=UTF-8'
            },
            body: JSON.stringify(this.formData),
          })
          .then((response) => response.json())
          .then((result) => {
            if (result['errors']) {
              this.formErrors = result['errors'];
            } else {
              this.formErrors = {};
              this.formData = {};
              this.$router.go(0);
            }
          });
        },
    },
    props: {
      blank: String,
      warrior: String,
      elf: String,
      dwarf: String,
      oni: String,
    },
  }
</script>
