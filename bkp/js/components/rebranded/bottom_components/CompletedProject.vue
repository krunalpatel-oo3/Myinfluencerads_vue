<template>
  <div class="row w-100" style="margin-top: 41px">
    <h2 class="t-24 w700 roboto w-100 mb-0">Feedback</h2>
    <div class="row mx-0 align-items-center w-100">
      <p class="d-text">Buyer: Kathryn Murphy</p>
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
    <div class="row mx-0 mt-2">
      <p class="t-16 w400" style="color: rgba(0, 0, 0, 0.8)">Have you ever seen stars below the sky, on the earth? Yes,
        the spark of light emerging from the land. On a cold night, standing on a peak of the mountain, when you look
        down at the place, you feel darkness enlightened by the rays of light. The blow of the cold chilly wind will
        enlighten your spark and soul. The beauty of the night is among the stars above the sky to the stars below the
        sky. The streets with warm light and covered with trees and a water canal give the essence of fantasy. </p>
    </div>
    <div class="w-100 d-flex align-items-center">
      <h2 class="w700 t-24 roboto mb-0 d-text" style="margin-right: 18px;">Your Feedback</h2>
      <div class="reviews-summary-rating">
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
      <p class="t-24 w500 t-black my-0" style="line-height: 24px; margin-left: 15.14px">4.7</p>
    </div>
    <p class="t-16 w400 t-color2" style="line-height: 23px; margin-bottom: 16px">Have you ever seen stars below the sky, on the earth? Yes, the spark of light emerging from the land. On a cold night, standing on a peak of the mountain, when you look down at the place, you feel darkness enlightened by the rays of light. The blow of the cold chilly wind will enlighten your spark and soul. The beauty of the night is among the stars above the sky to the stars below the sky. The streets with warm light and covered with trees and a water canal give the essence of fantasy. </p>
    <h2 class="w700 roboto t-24">Total Earnings: <span style="margin-left: 12px; color: #202C54">$ 3,500</span></h2>
    <div v-if="payment === 'hourly'" class="progress-hourly w-100">
      <h2 class="t-22 w500 roboto my-0">Transaction History:</h2>
      <div class="row mx-0">
        <table class="table">
          <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Description</th>
            <th scope="col">Date</th>
            <th scope="col">Amount</th>
          </tr>
          </thead>
          <tbody>
          <tr>
            <th scope="row">1</th>
            <td>Payment for 2021/10/25 - 2021/10/31 - 20hrs x $30/hr</td>
            <td>Nov 1, 2021</td>
            <td>$600</td>
          </tr>
          <tr>
            <th scope="row">2</th>
            <td>Bonus</td>
            <td>Nov 1, 2021</td>
            <td>$400</td>
          </tr>
          </tbody>
        </table>
      </div>
      <div class="row mx-0 w-100" style="margin-top: 38px">
        <h2 class="t-22 w500 roboto my-0" style="margin-right: 30px">Work Diary:</h2>
        <select class="select">
          <option selected>Nov 1, 2021 - Nov 7, 2021</option>
        </select>
      </div>
      <div class="row mx-0" style="margin-top: 7px">
        <table class="table">
          <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Memo</th>
            <th scope="col">Duration</th>
            <th scope="col">Time</th>
            <th scope="col">Date</th>
            <th scope="col">Amount</th>
          </tr>
          </thead>
          <tbody>
          <tr>
            <th scope="row">1</th>
            <td>Streamgeeks Rebranded Front End</td>
            <td>4:29</td>
            <td>7:51 am - 12:20 pm</td>
            <td>Nov 1, 2021</td>
            <td>$134</td>
          </tr>
          <tr>
            <th scope="row">2</th>
            <td>Streamgeeks Rebranded Front End</td>
            <td>4:29</td>
            <td>7:51 am - 12:20 pm</td>
            <td>Nov 1, 2021</td>
            <td>$134</td>
          </tr>
          </tbody>
        </table>
      </div>
    </div>
    <div v-if="payment === 'fixed'" class="accept-fixed w-100" style="margin-bottom: 53px">
      <h2 class="t-22 w500 roboto my-0">Transaction History:</h2>
      <div class="row mx-0">
        <table class="table">
          <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Name</th>
            <th scope="col">Description</th>
            <th scope="col">Date</th>
            <th scope="col">Amount</th>
          </tr>
          </thead>
          <tbody>
          <tr>
            <th scope="row">1</th>
            <td>Stream to youtube</td>
            <td>Lorem Ipsum dolor sit amet agna finibus risus</td>
            <td>Nov 1, 2021</td>
            <td>$700</td>
          </tr>
          <tr>
            <th scope="row">2</th>
            <td>Stream to facebook</td>
            <td>Lorem Ipsum dolor sit amet agna finibus risus</td>
            <td>Nov 1, 2021</td>
            <td>$800</td>
          </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

<script>
import IconStars from "../../common/icons/IconStars.vue";
import IconBase from "../../common/IconBase.vue";
export default {
  name: "CompletedProject",
  data() {
    return {
      payment: null
    };
  },
  components: {
    IconStars,
    IconBase
  },
  mounted() {
    if (this.$route.query.payment === "fixed") {
      this.payment = "fixed";
    } else {
      this.payment = "hourly";
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

.btn {
  background: #F2A91C;
  border-radius: 4px;
  font-size: 18px;
  font-weight: 700;
  color: #202C54;
}

.end-contract {
  height: 54px;
  width: 226px;
  margin-left: auto;
}

.select {
  width: 266px;
  height: 43px;
  border: 1px solid #DDE0E6;
  border-radius: 4px;
  background: white;
  box-sizing: border-box;
  padding-left: 12px;
  margin-top: 5px;
}

.add-time {
  height: 54px;
  width: 226px;
  margin-left: auto;
}
.timer-start {
  height: 62px;
  width: 204px;

}

.digit {
  background: #FFFFFF;
  box-shadow: 0px 4px 26px rgba(0, 0, 0, 0.08);
  border-radius: 4px;
  font-size: 34px;
  font-weight: 500;
  padding: 15px;
  margin-right: 10px;
}

.colon {
  font-size: 34px;
  font-weight: 500;
  padding: 15px;
  margin-right: 10px;
}
.submit-btn {
  width: 138px;
  height: 33px;
  font-size: 16px;
  padding: 0px !important;
  paddint-top: 15px;
}
.d-text {
  font-weight: 500;
  line-height: 45px;
  font-size: 22px;
  margin-bottom: 0;
  color: black;
}
</style>
