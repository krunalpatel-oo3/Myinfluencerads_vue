<template>
  <modal
    name="edit-about-dialog"
    :width="824"
    height="auto"
    :scrollable="true"
    :adaptive="true"
    transition=""
    class="section-modal edit-about-modal"
  >
    <div
      class="modal-close"
      @click="$modal.hide('edit-about-dialog')"
    >
      <CloseIcon />
    </div>
    <div class="row">
      <h2 class="w700 poppins t-33" style="margin-bottom: 17px">About</h2>
      <div class="col-12">
        <label>Title</label>
        <input v-model="title" type="text" maxlength="50" placeholder="Title of the profile">
        <label>Description</label>
        <textarea type="text" v-model="description" placeholder="Description" />
        <label>Hourly Rate</label>
        <div class="row mx-0" style="position: relative">
          <span style="position: absolute; z-index: 5; font-size: 22px; top: 22px; right: 20px">$</span>
          <input v-model="hourly_rate" maxlength="10" class="hourly-rate">
        </div>

      </div>
      <div class="btns">
        <button @click="addAbout" class="btn btn-primary roboto" :disabled="submitting">
          <div v-if="submitting" class="spinner-border" role="status">
            <span class="sr-only">Loading...</span>
          </div>
          <span>Submit</span>
        </button>
      </div>
    </div>
  </modal>
</template>

<script>
import CloseIcon from "../icons/CloseIcon.vue";

export default {
  name: "EditAboutModal",
  props: ["userProfile"],
  components: {
    CloseIcon
  },
  data() {
    return {
      title: "",
      description: "",
      hourly_rate: 1,
      logged_user_id: null,
      submitting: false,
    };
  },
  mounted() {
    this.title = this.userProfile.User.title;
    this.description = this.userProfile.User.description;
    this.hourly_rate = this.userProfile.User.hourly_rate;
  },
  methods: {
    async addAbout() {
      console.log("h_rate: ",this.hourly_rate);
      if (!this.title) {
        this.$toast.warning(" title is required! ");
        return;
      }
      if (!this.hourly_rate) {
        this.$toast.warning(" hourly rate is required! ");
        return;
      }else if(Math.sign(this.hourly_rate) == -1){
        this.$toast.error("Please enter positive value in hourly rate");
        return false;
      }
      if (!this.description || this.description.length <= 5) {
        this.$toast.warning("Description text too short! ");
        return;
      }

      this.submitting = true

      const result = await this.callApi(
        "post",
        window.api_path + "profile/updateabout",
        {
          title: this.title,
          user_id: localStorage.logged_user_id,
          description: this.description,
          hourly_rate: this.hourly_rate
        }
      );

      if (result.status !== 200) {
        this.$toast.error(result.data.message);
        return;
      }
      this.submitting = false;
      this.newCommunityText = "";
      this.$toast.success("Profile updated successfully");
      this.$modal.hide("edit-about-dialog");
      this.$emit("updateAbout");
    }
  }
};
</script>

<style lang="scss" scoped>
label {
  font-size: 26px;
  line-height: 30px;
  color: #000000;
  font-weight: 700;
}

input, textarea {
  margin-bottom: 20px;
  width: 100%;
  height: 73px;
  background: #E5E5E5;
  border-radius: 5px;
  font-size: 22px;
  padding: 0 17px;
  color: #333333;

  &::placeholder {
    font-size: 22px;
    font-weight: 500;
    color: #333333;
  }

  border: none;
}

textarea {
  padding: 20px;
  height: 150px;
}

.modal-close {
  padding: 0 !important;
  top: 31px !important;
  right: 31px !important;
}

.row {
  margin: 10px 20px 0px 20px;
  display: flex;
  justify-content: center;
  flex-wrap: wrap;

  .btns {
    width: 100%;
    display: flex;
    justify-content: center;
    margin-top: 10px;
    margin-bottom: 20px;

    .btn {
      margin: 0 !important;
      height: 83.34px;
      width: 284.25px;
      background: #F2A91C;
      border-radius: 15px;
      font-size: 24px;
      border: none;
      color: #000000;
      font-weight: 500;
    }
  }

  h2 {
    width: 100%;
    text-align: center;
    line-height: 54px;
  }
}
</style>

