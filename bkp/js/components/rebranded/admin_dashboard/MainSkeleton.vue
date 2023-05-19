<template>
  <div>
    <div class="skeleton nav-skeleton"></div>
    <div v-for="i in 4" :key="i" class="skeleton card-skeleton"></div>
  </div>
</template>

<script>
export default {
  name: "MainSkeleton"
};
</script>

<style scoped>
.nav-skeleton {
  width: 100%;
  height: 75px;
  border-radius: 10px;
}
.card-skeleton {
  border-radius: 8px;
  width: 100%;
  height: 140px;
  margin-top: 15px;
}
</style>
