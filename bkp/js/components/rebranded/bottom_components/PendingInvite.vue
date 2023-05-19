<template>
  <div class="row" style="margin-top: 16px">
    <h2 class="w700 t-24 text-black roboto" style="margin-bottom: 3px">Message from buyer</h2>
    <div class="row">
      <div class="col-12" style="padding-right: 70px">
        <p class="t-16 t-color2" style="line-height: 23px;">Have you ever seen stars below the sky, on the earth? Yes, the spark of light emerging from the land. On a cold night, standing on a peak of the mountain, when you look down at the place, you feel darkness enlightened by the rays of light. The blow of the cold chilly wind will enlighten your spark and soul. The beauty of the night is among the stars above the sky to the stars below the sky. The streets with warm light and covered with trees and a water canal give the essence of fantasy.  </p>
      </div>
    </div>
    <div class="row d-flex w-100 justify-content-end" style="margin-top: 63px">
      <button @click="$modal.show('send-proposal-dialog')" class="accept-btn">Accept</button>
      <button @click="showArchiveDialog" class="decline-btn">Decline</button>
      <ArchiveInviteModal />
      <SendProposalModal />
    </div>
  </div>
</template>

<script>
import ArchiveInviteModal from "../modals/ArchiveInviteModal";
import SendProposalModal from "../modals/SendProposalModal";
export default {
  name: "PendingInvite",
  components: {
    ArchiveInviteModal,
    SendProposalModal
  },
  methods: {
    showArchiveDialog () {
      this.$modal.show("archive-invite-dialog")
    }
  }
};
</script>

<style lang="scss" scoped>
.accept-btn, .decline-btn {
  background: #F2A91C;
  border-radius: 4px;
  width: 204px;
  height: 62px;
  font-weight: 700;
  font-size: 18px;
  color: #202C54;
  border: none;
}
.accept-btn {
  margin-right: 45px;
}
</style>
