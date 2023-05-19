<template>
  <div class="rebranded-dashboard">
    <Header />
    <div style="background: #F5F5F5">
      <div class="container">
        <div class="row">
          <div class="col-sidebar sidebar">
            <Sidebar />
          </div>
          <div class="col-main">
            <Navigation />
            <BuyerPending v-if="type === 'pending'"/>
            <BuyerWaiting v-if="type === 'waiting'"/>
            <BuyerInProgress v-if="type === 'progress'"/>
            <BuyerCompleted v-if="type === 'completed'"/>
            <BuyerDispute v-if="type === 'dispute'"/>
            <BuyerGraph v-if="type === ''"/>
          </div>
        </div>
      </div>
    </div>
    <Footer />
  </div>
</template>

<script>
import Navigation from "./dashboard/BuyerNavigation.vue";
import Header from "../common/Header.vue";
import Sidebar from "./dashboard/BuyerSidebar.vue";
import Footer from "../common/Footer";
import BuyerPending from "./dashboard/BuyerPending";
import BuyerWaiting from "./dashboard/BuyerWaiting";
import BuyerInProgress from "./dashboard/BuyerInProgress";
import BuyerCompleted from "./dashboard/BuyerCompleted";
import BuyerDispute from "./dashboard/BuyerDispute";
import BuyerGraph from "./dashboard/BuyerGraph";
export default {
  name: "BuyerDashboardProposals",
  data () {
    return {
      publicPath: local_image_path,
      type: ''
    }
  },
  components: {
    Header,
    Sidebar,
    Footer,
    BuyerPending,
    Navigation,
    BuyerWaiting,
    BuyerInProgress,
    BuyerCompleted,
    BuyerDispute,
    BuyerGraph
  },
  mounted () {
    if (this.$route.query.type) {
      this.type = this.$route.query.type
    } else {
      this.type = ''
    }
  },
  watch: {
    '$route.query.type' () {
      this.type = this.$route.query.type
    }
  }
};
</script>

<style scoped>

</style>
