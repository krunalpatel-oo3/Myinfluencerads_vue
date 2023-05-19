<template>
  <div class="navigation">
    <router-link class="nav" :to="{ name: 'Dashboard Buyer', query: { type: '' }}" exact-active-class="link-active">Dashboard</router-link>
    <router-link class="nav" :to="{ name: 'Dashboard Buyer', query: { type: 'pending' }}" exact-active-class="link-active">Pending Projects</router-link>
    <router-link class="nav" :to="{ name: 'Dashboard Buyer', query: { type: 'waiting' }}" exact-active-class="link-active">Waiting to accept</router-link>
    <router-link class="nav" :to="{ name: 'Dashboard Buyer', query: { type: 'progress' }}" exact-active-class="link-active">In Progress</router-link>
    <router-link class="nav" :to="{ name: 'Dashboard Buyer', query: { type: 'completed' }}" exact-active-class="link-active">Completed Projects</router-link>
    <router-link class="nav" :to="{ name: 'Dashboard Buyer', query: { type: 'archived' }}" exact-active-class="link-active">Archived Projects</router-link>
    <router-link class="nav" :to="{ name: 'Dashboard Buyer', query: { type: 'dispute' }}" exact-active-class="link-active">Projects in dispute</router-link>
  </div>
</template>

<script>
export default {
  name: "BuyerNavigation"
};
</script>

<style scoped>
.nav {
  font-size: 14px;
  font-weight: 500;
}
</style>
