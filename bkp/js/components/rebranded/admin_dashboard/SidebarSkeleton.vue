<template>
 <div>
   <div class="img-container">
     <div class="skeleton" style="border-radius: 50%; height: 80px; width: 80px"></div>
   </div>
   <div class="skeleton skeleton-card" v-for="i in 5" :key="i" style=""></div>
 </div>
</template>

<script>
export default {
  name: "SidebarSkeleton"
};
</script>

<style scoped>
.skeleton-card {
  width: 100%;
  height: 80px;
  border-radius: 10px;
  margin-bottom: 15px;
}
.img-container {
  margin-bottom: 100px;
}

</style>
