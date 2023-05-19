<template>
  <modal
    name="edit-education-dialog"
    :width="824"
    height="auto"
    :scrollable="true"
    :adaptive="true"
    transition=""
    class="section-modal edit-education-modal"
  >
    <div
      class="modal-close"
      @click="$modal.hide('edit-education-dialog')"
    >
      <CloseIcon />
    </div>
    <div class="row">
      <h2 class="w700 poppins t-33" style="margin-bottom: 17px">Education</h2>
      <div class="col-12">
        <label>School</label>
        <input v-model="school" type="text" placeholder="Name of the school">
        <label>Degree</label>
        <input v-model="degree" type="text" placeholder="Degree">
        <label>Area of Study</label>
        <input v-model="area_study" type="text" placeholder="Area of study (Optional)">
        <label>Dates Attended</label>
        <div class="row mx-0">
          <div class="col-6 px-0">
            <input type="date" v-model="school_start_date" placeholder="From">
          </div>
          <div class="col-6 pl-3">
            <input type="date" v-model="school_end_date" placeholder="To (or expected year)">
          </div>
        </div>
      </div>
      <div class="btns">
        <button @click="updateEducation" class="btn btn-primary roboto" :disabled="submitting">
          <div v-if="submitting" class="spinner-border" role="status">
            <span class="sr-only">Loading...</span>
          </div>
          <span v-else>Submit</span>
        </button>
      </div>
    </div>
  </modal>
</template>

<script>
import CloseIcon from "../icons/CloseIcon.vue";

export default {
  name: "EditSkillsModal",
  props: ["userProfile"],
  components: {
    CloseIcon
  }, data() {
    return {
      school: "",
      degree: "",
      area_study: "",
      school_start_date: "",
      school_end_date: "",
      logged_user_id: null,
      submitting: false,
    };
  }, mounted() {
    this.logged_user_id = localStorage.getItem("logged_user_id");
    this.school = this.userProfile.school;
    this.degree = this.userProfile.degree;
    this.area_study = this.userProfile.area_study;
    this.school_start_date = this.userProfile.school_start_date;
    this.school_end_date = this.userProfile.school_end_date;
  },
  methods: {
    async updateEducation() {
      const currentDate = new Date();
      if (!this.school) {
        this.$toast.warning(" School is required! ");
        return;
      }
      if (!this.degree) {
        this.$toast.warning(" Degree is required! ");
        return;
      }
      if(Date.parse(this.school_end_date) <= Date.parse(this.school_start_date)){
        this.$toast.warning(" End date must be greater then start date! ");
        return;
      }
      if(Date.parse(this.school_end_date) > Date.parse(currentDate)){
        this.$toast.warning(" End date should not be greater than the current date! ");
        return;
      }

      this.submitting = true;
      const result = await this.callApi(
        "post",
        window.api_path + "profile/updateeducation",
        {
          school: this.school,
          user_id: localStorage.logged_user_id,
          degree: this.degree,
          area_study: this.area_study,
          school_end_date: this.school_end_date,
          school_start_date: this.school_start_date
        }
      );

      if (result.status !== 200) {
        this.$toast.error(result.data.message);
        return;
      }
      this.newCommunityText = "";
      this.$toast.success("Profile updated successfully");
      this.$modal.hide("edit-education-dialog");
      this.submitting = false;
      this.$emit("update-education");
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

input {
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

