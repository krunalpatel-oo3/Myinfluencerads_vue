<template>
  <div>
    <div class="accordion">
      <p>Projects waiting to accept (10)</p>
    </div>
    <div>
      <div class="waiting-card">
        <router-link to="" class="w700 t-18">Project title goes here</router-link>
        <div class="row mx-0 details">
          <p class="t-18 w700">Project for: <router-link to="" class="w500">Smith Johnson</router-link></p>
          <p class="t-18 w700">Budget: <span class="w500">$20hr x 20hrs/week</span></p>
          <p class="t-18 w700">Created: <span class="w500">Nov 2, 2021, 02:07pm</span></p>
        </div>
        <div class="row mx-0">
          <p class="card-paragraph">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer...</p>
        </div>
      </div>
      <div class="waiting-card">
        <router-link to="" class="w700 t-18">Project title goes here</router-link>
        <div class="row mx-0 details">
          <p class="t-18 w700">Project for: <router-link to="" class="w500">Smith Johnson</router-link></p>
          <p class="t-18 w700">Budget: <span class="w500">$20hr x 20hrs/week</span></p>
          <p class="t-18 w700">Created: <span class="w500">Nov 2, 2021, 02:07pm</span></p>
        </div>
        <div class="row mx-0">
          <p class="card-paragraph">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer...</p>
        </div>
      </div>
      <div class="waiting-card">
        <router-link to="" class="w700 t-18">Project title goes here</router-link>
        <div class="row mx-0 details">
          <p class="t-18 w700">Project for: <router-link to="" class="w500">Smith Johnson</router-link></p>
          <p class="t-18 w700">Budget: <span class="w500">$20hr x 20hrs/week</span></p>
          <p class="t-18 w700">Created: <span class="w500">Nov 2, 2021, 02:07pm</span></p>
        </div>
        <div class="row mx-0">
          <p class="card-paragraph">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer...</p>
        </div>
      </div>
      <div class="waiting-card">
        <router-link to="" class="w700 t-18">Project title goes here</router-link>
        <div class="row mx-0 details">
          <p class="t-18 w700">Project for: <router-link to="" class="w500">Smith Johnson</router-link></p>
          <p class="t-18 w700">Budget: <span class="w500">$20hr x 20hrs/week</span></p>
          <p class="t-18 w700">Created: <span class="w500">Nov 2, 2021, 02:07pm</span></p>
        </div>
        <div class="row mx-0">
          <p class="card-paragraph">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer...</p>
        </div>
      </div>
      <div class="waiting-card">
        <router-link to="" class="w700 t-18">Project title goes here</router-link>
        <div class="row mx-0 details">
          <p class="t-18 w700">Project for: <router-link to="" class="w500">Smith Johnson</router-link></p>
          <p class="t-18 w700">Budget: <span class="w500">$20hr x 20hrs/week</span></p>
          <p class="t-18 w700">Created: <span class="w500">Nov 2, 2021, 02:07pm</span></p>
        </div>
        <div class="row mx-0">
          <p class="card-paragraph">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer...</p>
        </div>
      </div>
      <div class="waiting-card">
        <router-link to="" class="w700 t-18">Project title goes here</router-link>
        <div class="row mx-0 details">
          <p class="t-18 w700">Project for: <router-link to="" class="w500">Smith Johnson</router-link></p>
          <p class="t-18 w700">Budget: <span class="w500">$20hr x 20hrs/week</span></p>
          <p class="t-18 w700">Created: <span class="w500">Nov 2, 2021, 02:07pm</span></p>
        </div>
        <div class="row mx-0">
          <p class="card-paragraph">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer...</p>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "BuyerWaitingAccept",
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
  margin-bottom: 7px;
  padding: 15.6px 30px 15.6px 34px;

  .btn {
    margin-left: auto;
    height: 45px;
    width: 95px;
    background: #F2A91C;
    font-weight: 500;
    border-radius: 4px;
    transition: .2s;
    margin-top: -20px;
    &:hover {
      background: #ffc107;
    }
  }
  h2 {
    line-height: 31.5px;
    margin-bottom: 8px;
  }
  .card-paragraph {
    padding-right: 32px;
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

