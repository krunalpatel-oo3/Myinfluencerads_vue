<template>
  <div class="navigation">
    <router-link class="nav" :to="{ name: 'Dashboard Seller', query: { type: '' }}" exact-active-class="link-active">Dashboard</router-link>
    <router-link class="nav" :to="{ name: 'Dashboard Seller', query: { type: 'pending' }}" exact-active-class="link-active">Pending Projects</router-link>
    <router-link class="nav" :to="{ name: 'Dashboard Seller', query: { type: 'waiting-accept' }}" exact-active-class="link-active">Waiting to accept </router-link>
    <router-link class="nav" :to="{ name: 'Dashboard Seller', query: { type: 'in-progress' }}" exact-active-class="link-active">In Progress</router-link>
    <router-link class="nav" :to="{ name: 'Dashboard Seller', query: { type: 'completed' }}" exact-active-class="link-active">Completed Projects</router-link>
    <router-link class="nav" :to="{ name: 'Dashboard Seller', query: { type: 'archived' }}" exact-active-class="link-active">Archived Projects</router-link>
    <router-link class="nav" :to="{ name: 'Dashboard Seller', query: { type: 'in-dispute' }}" exact-active-class="link-active">Projects in dispute</router-link>
  </div>
</template>

<script>
export default {
  name: "SellerNavigation"
};
</script>

<style scoped>
.nav {
  font-size: 14px;
  font-weight: 500;
}
</style>
