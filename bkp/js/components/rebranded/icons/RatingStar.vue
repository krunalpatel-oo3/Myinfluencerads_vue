<template>
  <svg :width="width" :height="height" viewBox="0 0 33 29" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path d="M16.5 23.3068L26.697 29L23.991 18.27L33 11.0505L21.1365 10.1042L16.5 0L11.8635 10.1042L0 11.0505L8.9925 18.27L6.303 29L16.5 23.3068Z" :fill="fill"/>
  </svg>
</template>

<script>
export default {
  name: "RatingStar",
  props: {
    width: {
      type: Number,
      default: 33
    },
    height: {
      type: Number,
      default: 29
    },
    fill: {
      type: String,
      default: '#BEBEBE'
    }
  }
};
</script>

<style scoped>

</style>
