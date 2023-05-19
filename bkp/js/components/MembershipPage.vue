<template>
  <div style="position: relative">
    <Header />
    <img id="members-bg" :src="`${publicPath}members-bg.png`" alt="">
    <div class="membership-plans">
      <section class="membership-texts">
        <h4 class="t-50 t-color11 w700 text-center mb-0">Membership Plans</h4>
        <p class="t-18 t-color12 lh-30 mx-auto text-center" style="margin-bottom: 60px">Join our community of video production and streaming
          professionals at any level that makes sense for your business</p>
      </section>
    </div>

    <div v-if="plans" class="membership-cards container px-0" style="margin-bottom: 150px">
      <div class="row mx-0">
        <div class="col-4 px-3">
          <FreeMembershipCard
            :plan="plans[0]"
          />
        </div>
        <div class="col-4 px-3">
          <ProMembershipCard
            :plan="plans[1]"
          />
        </div>
        <div class="col-4 px-3">
          <BrandOwnerMembershipCard
            :plan="plans[2]"
          />
        </div>
      </div>
    </div>
    <Footer />
  </div>
</template>

<script>
import Header from "./common/Header";
import Footer from "./common/Footer";
import FreeMembershipCard from "./membership/FreeMembershipCard";
import ProMembershipCard from "./membership/ProMembershipCard";
import BrandOwnerMembershipCard from "./membership/BrandOwnerMembershipCard";

export default {
  name: "MembershipPage",
  data () {
    return {
      publicPath: local_image_path,
      plans: null
    }
  },
  components: {
    Header,
    FreeMembershipCard,
    ProMembershipCard,
    BrandOwnerMembershipCard,
    Footer,
  },
  methods: {
    async getMembershipPlans () {
      const result = await this.callApi(
        "post",
        window.api_path + "plan/list",
      );
      if (result.status === 200) {
        this.plans = result.data.data.plans
      }
    }
  },
  mounted () {
    this.getMembershipPlans()
  }
};
</script>

<style lang="scss" scoped>
.membership-texts {
  margin-top: 90px;
  width: 100%;
  p {
    max-width: 600px;
    text-align: center;
    margin-top: 25px;
  }
}
#members-bg {
  position: absolute;
  width: 100%;
  object-fit: cover;
  top: 120px;
  z-index: -999;
}
</style>
