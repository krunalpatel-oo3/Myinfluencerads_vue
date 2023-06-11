<template>
    <div class="root">
      <div class="time-left-container">
        <span class="time-left-label">{{ timeLeftString }}</span>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    methods: {
      padToTwo(num) {
        // e.g. 4 -> '04'
        return String(num).padStart(2, '0');
      },
    },
    computed: {
      // e.g. timeLeft of 100 -> '01:40'
      timeLeftString() {
        const timeLeft = this.timeLeft;
        const minutes = Math.floor(timeLeft / 60);
        console.log(minutes);
        const seconds = timeLeft % 60;
        return `${this.padToTwo(minutes)}:${this.padToTwo(seconds)}`;
      },
      timeLeft() {
        return this.limit - this.elapsed;
      },
    },
    // Register props to be set from App.vue
    props: {
      elapsed: {
        type: Number,
        required: true,
      },
      limit: {
        type: Number,
        required: true,
      },
    },
  };
  </script>
  <style>
    .time-left-container {
      /* Size should be the same as that of parent container */
      /* height: inherit; */
      /* width: inherit; */
    
      /* Place container on top of circle ring */
      /* position: absolute; */
      /* top: 0; */
    
      /* Center content (label) vertically and horizontally  */
      display: block;
      /* align-items: center; */
      /* justify-content: center; */
    }
    
    /* .time-left-label {
      font-size: 70px;
      font-family: 'Segoe UI';
      color: black;
    } */
    </style>