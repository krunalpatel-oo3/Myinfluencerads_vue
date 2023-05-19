<template>
  <div>
    <div>
      <div class="accordion">
        <p>Completed Projects (4)</p>
      </div>
      <div>
        <div class="waiting-card">
          <router-link to="" class="w700 t-18">Project title goes here</router-link>
          <div class="row mx-0 details">
            <p class="t-18 w700">Project by: <router-link to="" class="w500">Smith Johnson</router-link></p>
            <p class="t-18 w700">Budget: <span class="w500">$20hr x 20hrs/week</span></p>
            <p class="t-18 w700">Ended: <span class="w500">Nov 2, 2021, 02:07pm</span></p>
          </div>
          <div class="row mx-0 details">
            <p class="t-18 w700" style="margin-right: 13px; line-height: 25px">Feedback:</p>
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
            <p class="w500 t-black t-18" style="margin-left: 6.5px; line-height: 25px">(4.7)</p>
          </div>
          <p class="card-paragraph">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer...</p>
        </div>
        <div class="waiting-card">
          <router-link to="" class="w700 t-18">Project title goes here</router-link>
          <div class="row mx-0 details">
            <p class="t-18 w700">Project by: <router-link to="" class="w500">Smith Johnson</router-link></p>
            <p class="t-18 w700">Budget: <span class="w500">$20hr x 20hrs/week</span></p>
            <p class="t-18 w700">Ended: <span class="w500">Nov 2, 2021, 02:07pm</span></p>
          </div>
          <div class="row mx-0 details">
            <p class="t-18 w700" style="margin-right: 13px; line-height: 25px">Feedback:</p>
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
            <p class="w500 t-black t-18" style="margin-left: 6.5px; line-height: 25px">(4.7)</p>
          </div>
          <p class="card-paragraph">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer...</p>
        </div>
        <div class="waiting-card">
          <router-link to="" class="w700 t-18">Project title goes here</router-link>
          <div class="row mx-0 details">
            <p class="t-18 w700">Project by: <router-link to="" class="w500">Smith Johnson</router-link></p>
            <p class="t-18 w700">Budget: <span class="w500">$20hr x 20hrs/week</span></p>
            <p class="t-18 w700">Ended: <span class="w500">Nov 2, 2021, 02:07pm</span></p>
          </div>
          <div class="row mx-0 details">
            <p class="t-18 w700" style="margin-right: 13px; line-height: 25px">Feedback:</p>
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
            <p class="w500 t-black t-18" style="margin-left: 6.5px; line-height: 25px">(4.7)</p>
          </div>
          <p class="card-paragraph">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer...</p>
        </div>
        <div class="waiting-card">
          <router-link to="" class="w700 t-18">Project title goes here</router-link>
          <div class="row mx-0 details">
            <p class="t-18 w700">Project by: <router-link to="" class="w500">Smith Johnson</router-link></p>
            <p class="t-18 w700">Budget: <span class="w500">$20hr x 20hrs/week</span></p>
            <p class="t-18 w700">Ended: <span class="w500">Nov 2, 2021, 02:07pm</span></p>
          </div>
          <div class="row mx-0 details">
            <p class="t-18 w700" style="margin-right: 13px; line-height: 25px">Feedback:</p>
          </div>
          <p class="card-paragraph" style="font-style: italic">No Feedback given</p>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import IconStars from "../../common/icons/IconStars.vue";
import IconBase from "../../common/IconBase.vue";
export default {
  name: "SellerCompleted",
  components: {
    IconStars,
    IconBase
  },
  data() {
    return {
      publicPath: local_image_path
    };
  }

};
</script>

<style lang="scss" scoped>
.waiting-card {
  border: 1.5px solid #D2D5DD;
  box-sizing: border-box;
  border-radius: 15px;
  background: #FFFFFF;
  padding-left: 34px;
  padding-top: 15.6px;
  margin-bottom: 7px;
  padding-bottom: 15.6px;
  h2 {
    line-height: 31.5px;
    margin-bottom: 8px;
  }
  .card-paragraph {
    padding-right: 34px;
    margin-top: 7px;
    font-size: 16px;
    font-weight: 500;
    color: #000000;
    margin-bottom: 0;
  }
  .details {
    margin-top: 5px;
    p {
      line-height: 22.5px;
      color: #202C54;
      margin-right: 25px;
      margin-bottom: 0px;
    }
  }
}
</style>

