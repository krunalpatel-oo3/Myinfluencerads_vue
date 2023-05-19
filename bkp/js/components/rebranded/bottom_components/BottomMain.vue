<template>
  <div class="row" style="margin-top: 16px">
    <h2 class="w700 t-24 text-black roboto" style="margin-bottom: 3px">Quote</h2>
    <div class="row">
      <div class="col-9">
        <p class="t-16 t-color2" style="line-height: 23px;">Have you ever seen stars below the sky, on the earth? Yes, the spark of light emerging from the land. On a cold night, standing on a peak of the mountain, when you look down at the place, you feel darkness enlightened by the rays of light. The blow of the cold chilly wind will enlighten your spark and soul. The beauty of the night is among the stars above the sky to the stars below the sky. The streets with warm light and covered with trees and a water canal give the essence of fantasy. </p>
      </div>
      <div class="col-3">
        <p v-if="payment === 'hourly'" class="t-28 w700 w-100 text-right" style="padding-right: 70px">$40/hr</p>
        <div v-else class="w-100" style="padding-right: 70px">
          <p class="w700 t-28 t-black text-right" style="margin-bottom: 16px">$ 1,500</p>
          <p class="w700 t-18 t-black text-right">By Nov 15, 2021</p>
        </div>
      </div>
    </div>
    <div class="row d-flex w-100 justify-content-end" style="padding-right: 60px; margin-top: 39px">
      <button @click="showArchiveDialog" class="archive-btn">Archive Proposal</button>
      <ArchiveProposalModal />
    </div>
  </div>
</template>

<script>
import ArchiveProposalModal from "../modals/ArchiveProposalModal.vue";

export default {
  name: "BottomMain",
  components: {
    ArchiveProposalModal
  },
  data () {
    return {
      payment: null
    }
  },
  methods: {
    showArchiveDialog () {
      this.$modal.show("archive-proposal-dialog")
    },
    hideArchiveDialog () {
      this.$modal.hide("archive-proposal-dialog")
    }
  },
  mounted () {
    if (this.$route.query.payment === 'fixed') {
      this.payment = 'fixed'
    } else {
      this.payment = 'hourly'
    }
  }
};
</script>

<style scoped>

</style>
