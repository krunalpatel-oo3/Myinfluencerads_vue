<template>
  <div class="row w-100" style="margin-top: 25px;">
    <h2 class="t-24 w700 roboto w-100 mb-0">Contract Details</h2>
    <div class="row mx-0 align-items-center w-100">
      <p class="d-text">Seller: <img :src="`${publicPath}seller-avatar.png`"
                                     style="margin-left: 10px; margin-right: 5px;" alt="">Kathryn Murphy</p>
      <div class="reviews-summary-rating" style="margin-left: 18px; margin-right: 10px;">
        <div class="rating-val-w">
          <div class="rating rating-lg">
            <div class="rating-current" style="width: 95%;">
              <icon-base
                width="68.01"
                height="11"
                view-box="0 0 68.01 10.57"
                icon-name="stars"
              >
                <icon-stars />
              </icon-base>
            </div>
            <div class="rating-total">
              <icon-base
                width="127"
                height="20.5"
                view-box="0 0 68.01 10.57"
                icon-name="stars"
              >
                <icon-stars />
              </icon-base>
            </div>
          </div>
        </div>
      </div>
      <span class="t-22 w500">4.9</span>
    </div>
    <h2 class="t-24 w700 roboto w-100 mb-0">Quote</h2>
    <div class="row mx-0 w-100">
      <p class="t-16 t-color2 lh-23" style="width: 940px">Have you ever seen stars below the sky, on the earth? Yes, the
        spark of light emerging from the land. On a cold night, standing on a peak of the mountain, when you look down
        at the place, you feel darkness enlightened by the rays of light. The blow of the cold chilly wind will
        enlighten your spark and soul. The beauty of the night is among the stars above the sky to the stars below the
        sky. The streets with warm light and covered with trees and a water canal give the essence of fantasy. </p>
      <p class="w700 t-28 ml-auto">$40/hr</p>
    </div>
    <div class="row mx-0 justify-content-start w-100">
      <div class="attachment" style="margin-right: 28px;">
        <a href="" class="link-hover">
          <AttachmentIcon style="margin-right: 8px;" />
          <span>File Name.ppt</span>
        </a>
      </div>
      <div class="attachment">
        <a href="" class="link-hover">
          <AttachmentIcon style="margin-right: 8px;" />
          <span>File Name.ppt</span>
        </a>
      </div>
    </div>
    <div class="row mx-0 w-100" style="margin-top: 40px">
      <button @click="$modal.show('send-message-dialog')" class="send-btn btn-hover ml-auto" style="margin-right: 18px">Send Message</button>
      <button @click="$modal.show('archive-proposal-dialog')" class="archive-btn btn-hover">Archive Proposal</button>
    </div>
    <ArchiveProposal />
    <SendMessageModal />
  </div>
</template>

<script>
import IconStars from "../../common/icons/IconStars.vue";
import RevokeModal from "../modals/RevokeModal";
import IconBase from "../../common/IconBase.vue";
import IconAngleDown from "../../common/icons/IconAngleDown.vue";
import AttachmentIcon from "../icons/AttachmentIcon";
import ArchiveProposal from "../modals/ArchiveProposalModal";
import SendMessageModal from "../modals/SendMessageModal";

export default {
  name: "BuyerInProgress",
  components: {
    IconStars,
    IconBase,
    RevokeModal,
    IconAngleDown,
    AttachmentIcon,
    ArchiveProposal,
    SendMessageModal
  },
  mounted() {
    if (this.$route.query.payment === "fixed") {
      this.payment = "fixed";
    } else {
      this.payment = "hourly";
    }
  },
  data() {
    return {
      payment: null,
      publicPath: local_image_path,
      dates: ["Nov 1, 2021 - Nov 7, 2021", "Nov 7, 2021 - Nov 14, 2021"],
      date: "Nov 1, 2021 - Nov 7, 2021"
    };
  }
};
</script>

<style scoped>
.dropdown-item {
  padding: 10px 20px;
  cursor: pointer;
}

.send-btn, .archive-btn {
  background: #F2A91C;
  border-radius: 4px;
  width: 204px;
  height: 62px;
  border: none;
  font-weight: 700;
  font-size: 18px;
}

.v-select-light {
  width: 266px;
  height: 43px;
}


.d-text {
  font-weight: 500;
  line-height: 45px;
  font-size: 22px;
  margin-bottom: 0;
}
</style>

