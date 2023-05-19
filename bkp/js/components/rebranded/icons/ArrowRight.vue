<template>
  <svg :width="width" :height="height" viewBox="0 0 23 12" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path d="M0.898438 6.8871H19.9254L16.7735 9.98413C16.4219 10.3297 16.4205 10.8914 16.7705 11.2387C17.1206 11.586 17.6895 11.5872 18.0412 11.2417L22.7357 6.62877C22.736 6.62851 22.7362 6.6282 22.7365 6.62793C23.0873 6.28232 23.0884 5.71883 22.7366 5.37207C22.7362 5.3718 22.736 5.37149 22.7358 5.37123L18.0412 0.75832C17.6896 0.412796 17.1207 0.413993 16.7706 0.761336C16.4206 1.10859 16.4219 1.67026 16.7736 2.01587L19.9254 5.1129H0.898438C0.402231 5.1129 0 5.51006 0 6C0 6.48994 0.402231 6.8871 0.898438 6.8871Z" :fill="fill"/>
  </svg>
</template>

<script>
export default {
  name: "ArrowRight",
  props: {
    width: {
      type: Number,
      default: 23
    },
    height: {
      type: Number,
      default: 12
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
