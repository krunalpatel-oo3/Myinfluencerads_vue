<template>
  <div class="container px-0 c-tab">
    <loading
      :active.sync="isLoading"
      :can-cancel="false"
      :is-full-page="true"
      background-color="#000"
      color="#202c54"
    />
    <div class="row" v-if="!(plans.length && currentPlan)">
      <div class=" col-sm-6 px-3 mb-md-0 mb-4">
        <div class="skeleton"></div>
      </div>
      <div class=" col-sm-6 px-3 mb-md-0 mb-4">
        <div class="skeleton"></div>
      </div>
      <div class=" col-sm-6 px-3 mb-md-0 mb-4">
        <div class="skeleton"></div>
      </div>
    </div>
    <div class="row" v-else>
      <div class="col-md-4 col-sm-6 px-3 mb-md-0 mb-4">
        <FreeMembershipCard
          :currentId="currentPlan.id"
          :page="'settings'"
          :plan="plans[0]"
          @plan-submit="planSubmit"
        />
      </div>
      <div class="col-md-4 col-sm-6 px-3 mb-md-0 mb-4">
        <ProMembershipCard
          :currentId="currentPlan.id"
          :page="'settings'"
          :plan="plans[1]"
          @plan-submit="planSubmit"
        />
      </div>
      <div class="col-md-4 col-sm-6 px-3 mb-md-0 mb-4">
        <BrandOwnerMembershipCard
          :currentId="currentPlan.id"
          :page="'settings'"
          :plan="plans[2]"
          @plan-submit="planSubmit"
        />
      </div>
    </div>
    <PaymentModal
      @choosePaypal="createPaypalOrder"
      @payWithCC="createCCOrder"
    />
    <UnsubscribeModal
      v-if="currentPlan"
      :chosen-plan="chosenPlanName"
      :current-plan="currentPlan.name"
      @unsub-submit="unsubscribeFromPlan"
    />
  </div>
</template>

<script>
import FreeMembershipCard from "../../membership/FreeMembershipCard";
import ProMembershipCard from "../../membership/ProMembershipCard";
import BrandOwnerMembershipCard from "../../membership/BrandOwnerMembershipCard";
import PaymentModal from "./PaymentModal";
import UnsubscribeModal from "./UnsubscribeModal";
import Loading from "vue-loading-overlay";

export default {
  name: "PlanTab",
  components: {
    FreeMembershipCard,
    ProMembershipCard,
    BrandOwnerMembershipCard,
    PaymentModal,
    UnsubscribeModal,
    Loading,
  },
  data () {
    return {
      currentPlan: null,
      plans: [],
      chosenPlan: null,
      chosenPlanName: '',
      isLoading: false,
    }
  },
  mounted() {
    this.getMembershipPlans();
    this.getCurrentPLan();
  },
  methods: {
    reset () {
      this.plans = []
      this.chosenPlanName = ''
      this.currentPlan = null
      this.chosenPlan = null
      this.isLoading = false
      this.getMembershipPlans();
      this.getCurrentPLan();
    },
    planSubmit (plan_id) {
      this.chosenPlan = plan_id;
      if (this.currentPlan.id < plan_id) {
        this.$modal.show('payment-dialog');
      } else if (this.currentPlan.id > plan_id) {
        this.chosenPlanName = this.plans.filter(plan => plan.id === plan_id)[0].name
        this.$modal.show('unsubscribe-dialog')
      }
    },
    async unsubscribeFromPlan () {
      this.isLoading = true
      await this.$nextTick()
      const formData = new FormData();
      formData.append('downgrade_plan_id', this.chosenPlan)
      const res = await this.callApi(
        "post",
        window.api_path + "plan/downgrade",
        formData
      )
      if (res.data.code === 1) {
        this.$toast.success(res.data.message)
      } else {
        this.$toast.error(res.data.message)
      }
      this.$modal.hide('unsubscribe-dialog')
      this.reset()
    },
    async createPaypalOrder () {
      this.isLoading = true
      const formData = new FormData()
      formData.append('plan_id', this.chosenPlan)
      formData.append('payment_method', 'paypal')
      const res = await this.callApi(
        "post",
        window.api_path + "order/create",
        formData
      )
      if (res.data?.data?.payment_url) window.location.href = res.data.data.payment_url
      this.isLoading = false
    },
    async createCCOrder (cardNumber, cardExpiry, cardCvc) {
      this.isLoading = true
      const splitExp = cardExpiry.split(' / ')
      if (splitExp.length !== 2) {
        this.$toast.error('Invalid card details')
        return
      }
      const formData = new FormData()
      formData.append('plan_id', this.chosenPlan)
      formData.append('payment_method', 'cc')
      formData.append('card_number', cardNumber.split(' ').join(''))
      formData.append('exp_month', parseInt(splitExp[0]).toString())
      formData.append('exp_year', parseInt(splitExp[1]).toString())
      formData.append('cvc', cardCvc)
      const res = await this.callApi(
        "post",
        window.api_path + "order/create",
        formData
      )
      if (res.data?.code === 1) {
        this.$toast.success(res.data?.message)
      } else {
        this.$toast.error(res.data?.message)
      }
      this.$modal.hide('payment-dialog')
      this.reset()
    },
    async getMembershipPlans () {
      const result = await this.callApi(
        "post",
        window.api_path + "plan/list",
      );
      if (result.status === 200) {
        this.plans = result.data.data.plans
      }
    },
    async getCurrentPLan () {
      const res = await this.callApi(
        "post",
        window.api_path + "plan/current"
      );
      if (res.status === 200) this.currentPlan = res.data.data
    },
  }
};
</script>

<style scoped>
.skeleton {
  width: 100%;
  height: 660px;
  border-radius: 24px;
}
</style>
