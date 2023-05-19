<template>
  <svg :width="width" :height="height" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
    <rect x="0.5" y="0.5" width="9" height="9" rx="4.5" :fill="fill" :stroke="stroke"/>
  </svg>
</template>

<script>
export default {
  name: "DotIcon",
  props: {
    height: {
      type: Number,
      default: 10
    },
    width: {
      type: Number,
      default: 10
    },
    fill: {
      type: String,
      default: '#F2A91C'
    },
    stroke: {
      type: String,
      default: '#F2A91C'
    }
  }
};
</script>

<style scoped>

</style>
