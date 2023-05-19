<template>
  <svg :width="width" :height="height" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path d="M7.49961 15C6.93663 15 6.48047 14.5439 6.48047 13.9809V1.01914C6.48047 0.456159 6.93659 0 7.49961 0C8.06262 0 8.51874 0.456122 8.51874 1.01914V13.9809C8.51874 14.5437 8.06262 14.9999 7.49961 14.9999V15Z" :fill="fill"/>
    <path d="M13.9809 8.51899H1.01914C0.456159 8.51899 0 8.06287 0 7.49985C0 6.93684 0.456122 6.48071 1.01914 6.48071H13.9809C14.5438 6.48071 15 6.93684 15 7.49985C14.9999 8.06283 14.5437 8.51899 13.9807 8.51899H13.9809Z" :fill="fill"/>
  </svg>
</template>

<script>
export default {
  name: "AddIcon",
  props: {
    width: {
      type: Number,
      default: 15
    },
    height: {
      type: Number,
      default: 15
    },
    fill: {
      type: String,
      default: 'white'
    }
  }
};
</script>

<style scoped>

</style>
