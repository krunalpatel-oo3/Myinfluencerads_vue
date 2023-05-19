<template>
  <svg :width="width" :height="height" viewBox="0 0 15 13" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path d="M13.0581 0.402762L5.37938 9.68089L1.94217 5.52774C1.49773 4.99073 0.777674 4.99073 0.333332 5.52774C-0.111111 6.06476 -0.111111 6.93479 0.333332 7.47169L4.57484 12.5967C4.79616 12.8641 5.08863 13 5.37925 13C5.66988 13 5.96051 12.8663 6.18365 12.5967L14.6667 2.34671C15.1111 1.80969 15.1111 0.939657 14.6667 0.402762C14.2223 -0.134254 13.5026 -0.134254 13.0581 0.402762Z" :fill="fill"/>
  </svg>
</template>

<script>
export default {
  name: "DoneIcon",
  props: {
    height: {
      default: 13,
      type: Number
    },
    width: {
      default: 15,
      type: Number
    },
    fill: {
      default: 'white',
      type: String
    }
  }
};
</script>

<style scoped>

</style>
