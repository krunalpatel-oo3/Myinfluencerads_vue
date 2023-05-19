<template>
  <div class="row" style="margin-top: 16px">
    <h2 class="w700 t-24 roboto" style="margin-bottom: 3px">Message from the buyer</h2>
    <div class="row">
      <div class="col-12">
        <p class="t-16 t-color2" style="line-height: 23px; padding-right: 70px;">Have you ever seen stars below the sky, on the earth? Yes, the spark of light emerging from the land. On a cold night, standing on a peak of the mountain, when you look down at the place, you feel darkness enlightened by the rays of light. The blow of the cold chilly wind will enlighten your spark and soul. The beauty of the night is among the stars above the sky to the stars below the sky. The streets with warm light and covered with trees and a water canal give the essence of fantasy. </p>
      </div>
    </div>
    <h2 class="w700 t-24 roboto" style="margin-top: 14px; margin-bottom: 11px">Reason: <span class="w400" style="font-style: italic">archived by seller</span></h2>
    <p class="t-16 t-color2" style="line-height: 23px; padding-right: 70px">Have you ever seen stars below the sky, on the earth? Yes, the spark of light emerging from the land. On a cold night, standing on a peak of the mountain, when you look down at the place, you feel darkness enlightened by the rays of light. The blow of the cold chilly wind will enlighten your spark and soul. The beauty of the night is among the stars above the sky to the stars below the sky. The streets with warm light and covered with trees and a water canal give the essence of fantasy.  </p>
  </div>
</template>

<script>

export default {
  name: "ArchivedInvite",
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
