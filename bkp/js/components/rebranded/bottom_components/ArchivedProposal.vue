<template>
  <div class="row" style="margin-top: 16px">
    <h2 class="w700 t-24 roboto" style="margin-bottom: 3px">Quote</h2>
    <div class="row">
      <div style="width: 85%">
        <p class="t-16 t-color2" style="line-height: 23px;">Have you ever seen stars below the sky, on the earth? Yes, the spark of light emerging from the land. On a cold night, standing on a peak of the mountain, when you look down at the place, you feel darkness enlightened by the rays of light. The blow of the cold chilly wind will enlighten your spark and soul. The beauty of the night is among the stars above the sky to the stars below the sky. The streets with warm light and covered with trees and a water canal give the essence of fantasy. </p>
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
          <div class="attachment">
            <a href="" class="link-hover">
              <AttachmentIcon style="margin-right: 8px;" />
              <span>File Name.ppt</span>
            </a>
          </div>
        </div>
      </div>
      <div style="width: 15%">
        <p v-if="payment === 'hourly'" class="t-28 w700 w-100 text-right" style="padding-right: 40px">$40/hr</p>
        <div v-else class="w-100" style="padding-right: 40px">
          <p class="w700 t-28 t-black text-right" style="margin-bottom: 16px">$ 1,500</p>
          <p class="w700 t-18 t-black text-right">By Nov 15, 2021</p>
        </div>
      </div>
    </div>
    <h2 class="w700 t-24 roboto" style="margin-top: 14px; margin-bottom: 11px">Reason: <span class="t-16 w400" style="font-style: italic">archived by seller</span></h2>
      <p class="t-16 t-color2" style="line-height: 23px; padding-right: 70px">Have you ever seen stars below the sky, on the earth? Yes, the spark of light emerging from the land. On a cold night, standing on a peak of the mountain, when you look down at the place, you feel darkness enlightened by the rays of light. The blow of the cold chilly wind will enlighten your spark and soul. The beauty of the night is among the stars above the sky to the stars below the sky. The streets with warm light and covered with trees and a water canal give the essence of fantasy.  </p>
  </div>
</template>

<script>
import AttachmentIcon from "../icons/AttachmentIcon";

export default {
  name: "ArchivedProposal",
  components: {
    AttachmentIcon
  },
  data () {
    return {
      payment: null
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
