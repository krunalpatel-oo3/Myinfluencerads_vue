<template>
  <modal
    name="unsubscribe-dialog"
    :width="750"
    height="auto"
    :scrollable="true"
    :adaptive="true"
    transition=""
    class="section-modal"
  >
    <div
      class="modal-close"
      @click="$modal.hide('unsubscribe-dialog')"
    >
      <CloseIcon />
    </div>
    <div class="row justify-content-center py-3">
      <h4 class="t-33 w700 mb-3">Unsubscribe</h4>
      <p class="t-25 lh-50 text-center mb-4" style="color: #6D6D6D; width: 80%">Do you want to unsubscribe from your current ({{ currentPlan }})
        and downgrade to ({{ chosenPlan }}) plan?</p>
      <button class="unsub-btn" @click="$emit('unsub-submit')">Unsubscribe</button>
    </div>
  </modal>
</template>

<script>
import CloseIcon from "../icons/CloseIcon";

export default {
  name: "UnsubscribeModal",
  components: {
    CloseIcon
  },
  props: {
    currentPlan: {
      type: String,
      required: true
    },
    chosenPlan: {
      type: String,
      required: true
    }
  }
};
</script>

<style lang="scss" scoped>
.unsub-btn {
  background: #F2A91C;
  border-radius: 15px;
  height: 80px;
  width: 280px;
  font-weight: 500;
  font-size: 24px;
  border: none;
  &:hover {
    filter: brightness(1.2);
  }
}
</style>
