<template>
  <svg :width="width" :height="height" viewBox="0 0 38 38" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path d="M19.1453 32.4425C11.7353 32.3638 5.64083 26.2693 5.56215 18.8593C5.52474 15.2692 6.88686 11.9088 9.39812 9.39754C11.9094 6.88629 15.2697 5.52416 18.8592 5.56227C22.5649 5.60162 25.9407 7.14493 28.4002 9.60442C30.8597 12.0639 32.403 15.4397 32.4423 19.1454C32.521 26.5554 26.556 32.5204 19.1453 32.4425ZM30.3605 19.1233C30.294 12.8602 25.1444 7.71057 18.8812 7.64407C15.8484 7.61187 13.0084 8.76309 10.886 10.8854C8.76367 13.0078 7.61245 15.8478 7.64392 18.8814C7.71042 25.1445 12.8608 30.2934 19.1232 30.3607C25.3855 30.4264 30.427 25.385 30.3605 19.1233Z" :fill="fill"/>
    <path d="M12.4238 18.7803H25.4255" stroke="#202C54" stroke-width="3" stroke-linecap="round"/>
    <path d="M18.9248 25.2809V12.2793" stroke="#202C54" stroke-width="3" stroke-linecap="round"/>
  </svg>
</template>

<script>
export default {
  name: "PlusIcon",
  props: {
    width: {
      type: Number,
      default: 38
    },
    height: {
      type: Number,
      default: 38
    },
    fill: {
      type: String,
      default: '#202C54'
    }
  }
};
</script>

<style scoped>

</style>
