<template>
  <div class="slider slider--hidden">
    <!--<div class="slider__slide" id="treasure">-->
  <!--    <img :src="event1" alt="treasure" class="slider__image"/>-->
    <!--</div>-->
    <!--<div class="slider__slide" id="food">-->
  <!--    <img :src="event2" alt="food" class="slider__image">-->
    <!--</div>-->
    <!--<div class="slider__slide" id="elixir">-->
  <!--    <img :src="event3" alt="elixir" class="slider__image">-->
    <!--</div>-->
    <!--<div class="slider__slide" id="fountain">-->
  <!--    <img :src="event4" alt="fountain" class="slider__image">-->
    <!--</div>-->
    <div class="slider__slide" id="monster">
      <img :src="event5" alt="monster" class="slider__image">
    </div>
  </div>
</template>


<script>
  export default {
    name: 'SliderComponent',
    data() {
      return {
        i: 0,
        interval: 50,
        min: 600,
        max: 900,
      };
    },
    computed: {

      images: {
        get() {
          return document.querySelectorAll(".slider__slide");
        }
      },

      evenement: {
        get() {
          return document.querySelector(".slider");
        }
      },

      randomInterval: {
        get() {
          return Math.floor(Math.random() * (this.max - this.min + 1) + this.min);
        }
      },

      randomEvent: {
        get() {
          return this.images[this.i - 1].getAttribute('id');
        }
      },
    },
    methods: { 
      // Hide all images at first, then show the slider and display image based of this.i value
      displayEvent() {
        this.images.forEach( (img) => {
          img.classList.add('hidden');
        });
        this.evenement.classList.remove('slider--hidden');
        if(this.i === this.images.length) {
          this.i = 0;
        }
        this.images[this.i].classList.remove('hidden');
        this.i++;
      },

      // Call displayEvent() at growing interval then emit the result when the slider stops
      automaticSlider () {
        this.displayEvent();
        this.interval *= 1.1;
        let slider = setTimeout(this.automaticSlider, this.interval);
        if (this.interval > this.randomInterval) {
          clearInterval(slider);
          this.$emit('randomEvent', this.randomEvent);
          this.evenement.classList.add("chosenEvent");
        }
      },

    },
    watch: {
      
      // start the slider when randomEventProp changes = the player clicked on the button to see random event
      randomEventProp: function() {
          this.automaticSlider ();
      }
    },
    props: {
      randomEventProp: {
        type: Number,
      },
      event1: {
        type: String,
      },
      event2: {
        type: String,
      },
      event3: {
        type: String,
      },
      event4: {
        type: String,
      },
      event5: {
        type: String,
      },
    },
  };
</script>




