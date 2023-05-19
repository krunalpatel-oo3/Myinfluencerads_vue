<template>
  <svg width="10" height="38" viewBox="0 0 10 38" fill="none" xmlns="http://www.w3.org/2000/svg">
    <circle cx="5" cy="28.9268" r="2.5" transform="rotate(-90 5 28.9268)" fill="#202C54"/>
    <circle cx="5" cy="18.9268" r="2.5" transform="rotate(-90 5 18.9268)" fill="#202C54"/>
    <circle cx="5" cy="8.92676" r="2.5" transform="rotate(-90 5 8.92676)" fill="#202C54"/>
  </svg>
</template>

<script>
export default {
  name: "MenuDots"
};
</script>

<style lang="scss" scoped>
svg {
  transition: .2s;
  &:hover {
    circle {
      fill: #F2A91C;
    }
  }
}
</style>
