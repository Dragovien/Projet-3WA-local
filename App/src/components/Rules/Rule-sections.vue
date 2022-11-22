<template>
  <section class="rules-section introduction" alt="scroll background image">
    <div class="rules-section__title-wrapper flex-column">
      <h2 class="rules-section__h2">
          Introduction
      </h2>
      <h3 class="rules-section__h3">
          Cliquez
      </h3>
    </div>
    
    <div class="rules-section__dropdown hidden" id="intro">
      <p class="rules-section__text">
        Votre but dans ce petit jeu est de battre le Demon Lord (<dfn>boss final</dfn>).
      </p>
      <p class="rules-section__text">
        Pour se faire, vous allez devoir enchainer des combats jusqu'à ce qu'il apparaisse.
      </p>
      <img 
        src="@/assets/img/Rules-sections/gif-clash.gif" 
        alt="drawing fight gif" class="rules-section__combat-gif"
      >
    </div>
  </section>

  <section class="rules-section combat">
    <div class="rules-section__title-wrapper flex-column">
      <h2 class="rules-section__h2">
          Déroulement des combats
      </h2>
      <h3 class="rules-section__h3">
          Cliquez
      </h3>
    </div>
    
    <div class="rules-section__dropdown hidden" id="combat">
      <div class="rules-section__row pb-5">
          <p class="rules-section__col rules-section__text">
            Chaque tour, vous devrez lancer <strong>1</strong> <abbr title="Dé à 6 faces">D6</abbr> 
            afin de déterminer qui de vous ou de l'ennemi aura l'initiative (<dfn>attaquera en premier</dfn>). 
            En cas d'égalité vous attaquerez en premier.
          </p>

          <img 
            src="@/assets/img/Rules-sections/gif-dice-throw.gif" 
            alt="dice throwing gif" class=" rules-section__dice-gif"
          >
      </div>
        <div class="rules-section__row pb-5">
          <p class="rules__text">
            Suite à cela, vous devrez lancer <strong>1</strong> 
            <abbr title="Dé à 100 faces">D100</abbr> afin de déterminer si vous réussissez 
            votre attaque.
          </p>

          <p class="rules__text">
            Votre personnage devra faire un score de <strong>70 ou 
            moins</strong> afin de réussir une attaque qui sera égale à <strong>1</strong> 
            <abbr title="Dé à 6 faces">D6</abbr> de dégâts.
          </p>
        </div>
        <ul>
          <li>
            <p class="rules-section__text">
              Dans le cas où vous faites entre <strong>0 et 10</strong>, 
              c'est une <u>réussite critique</u>: vous infligerez <strong>2</strong>
              <abbr title="Dé à 6 faces">D6</abbr> de dégâts.
            </p>
          </li>
          <li>
            <p class="rules-section__text">
              Dans le cas où vous faites entre <strong>11 et 70</strong>, 
              c'est une <u>réussite normale</u>: vous infligerez <strong>1</strong> 
              <abbr title="Dé à 6 faces">D6</abbr> de dégâts.
            </p>
          </li>
          <li>
            <p class="rules-section__text">
              Dans le cas où vous faites entre <strong>71 et 89</strong>,
              c'est un <u>échec</u>: vous ratez votre attaque.
            </p>
          </li>
          <li>
            <p class="rules-section__text">
                Dans le cas où vous faites entre <strong>90 et 100</strong>, 
                c'est un <u>échec critique</u>: vous ratez votre attaque et 
                vous prenez <strong>1</strong> <abbr title="Dé à 3 faces">D3</abbr> de dégâts.
            </p>
          </li>
        </ul>
    </div>
  </section>

  <section class="rules-section exploration">
    <div class="rules-section__title-wrapper flex-column">
      <h2 class="rules-section__h2">
          Exploration
      </h2>
      <h3 class="rules-section__h3">
          Cliquez
      </h3>
    </div>

    <div class="rules-section__dropdown hidden" id="explo">
      <p class="rules-section__text">Certaines salles ne contiendront pas d'ennemis et contiendront:</p>
      <ul>
        <li>
          <p class="rules-section__text">
            Un coffre au trésor contenant une pièce d'armure qui sera équipée à l'acquisition.
          </p>
          <div class="rules-section__row"> 
              <img 
                src="@/assets/img/Rules-sections/gif-chest-opening.gif" 
                alt="chest opening gif" class="rules-section__explo-gif"
              >
              <p class="rules-section__text rules-section__col">
                Chaque pièce d'armure rajoute <em><strong>+1 point</strong></em> de défense
                et l'arme rajoutera un nombre de point d'attaque dépendant de l'arme.
              </p>
          </div>
        </li>
        <li>
          <p class="rules-section__text">
            Une fontaine de vie. Cette dernière vous permettra de
            récupérer <em><strong>50%</strong></em> de votre vie maximum.
          </p>
        </li>
        <li>
          <p class="rules-section__text">
            De la nourriture qui redonnera <em><strong>5</strong></em> points de vie.
          </p>
        </li>
        <li>
          <p class="rules-section__text">
            Des élixirs qui augmenteront votre nombre de points de vie maximum de 
            <em><strong>5</strong></em> points.
          </p>
        </li>
      </ul>
    </div>
  </section>
</template>

<script>
  export default {
    methods: {
      
      // method to dropdown the section when clicked
      showSection(section, dropdown) {
        let count = 0;

        section.addEventListener('click', () => {
          dropdown.classList.remove('hidden');
          count++;

          if (count > 1) {
            dropdown.classList.add('hidden');
            count = 0;
          }
        })
      },
      
      // dropdown intro section
      intro() {
        let showIntro = document.querySelector('.introduction');
        let subLevel = document.querySelector('#intro');
        this.showSection(showIntro, subLevel);
      },
      
      // dropdown combat section
      combat() {
        let showCombat = document.querySelector('.combat');
        let subLevel = document.querySelector('#combat');
        this.showSection(showCombat, subLevel);
      },

      // dropdown exploration section
      explo() {
        let showExplo = document.querySelector('.exploration');
        let subLevel = document.querySelector('#explo');
        this.showSection(showExplo, subLevel);
      }
    },
    mounted() {
      this.intro();
      this.combat();
      this.explo();
    }
  }
</script>