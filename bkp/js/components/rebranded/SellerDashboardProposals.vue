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
          <SellerNavigation />
          <SellerProposals v-if="type === 'pending'"/>
          <SellerWaitingAccept v-if="type === 'waiting-accept'"/>
          <SellerInProgress v-if="type === 'in-progress'"/>
          <SellerCompleted v-if="type === 'completed'"/>
          <SellerInDispute v-if="type === 'in-dispute'"/>
          <SellerGraph v-if="type === ''"/>
        </div>
      </div>
    </div>
  </div>
  <Footer />
</div>
</template>

<script>
import Header from "../common/Header.vue";
import Sidebar from "./dashboard/SellerSidebar.vue";
import SellerProposals from "./dashboard/SellerProposals";
import SellerWaitingAccept from "./dashboard/SellerWaitingAccept";
import SellerInProgress from "./dashboard/SellerInProgress";
import SellerCompleted from "./dashboard/SellerCompleted";
import SellerInDispute from "./dashboard/SellerInDispute";
import SellerGraph from "./dashboard/SellerGraph";
import Footer from "../common/Footer";
import SellerNavigation from "./dashboard/SellerNavigation";
export default {
  name: "TestProposals",
  data () {
    return {
      publicPath: local_image_path,
      type: ''
    }
  },
  components: {
    Sidebar,
    Header,
    Footer,
    SellerProposals,
    SellerWaitingAccept,
    SellerInProgress,
    SellerCompleted,
    SellerInDispute,
    SellerGraph,
    SellerNavigation
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

<style lang="scss" scoped>

</style>
