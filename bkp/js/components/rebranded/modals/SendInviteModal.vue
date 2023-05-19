<template>
  <modal
    name="send-invite-dialog"
    :width="824"
    height="auto"
    :scrollable="true"
    :adaptive="true"
    transition=""
    class="section-modal section-modal-archive"
  >
    <div
      class="modal-close"
      @click="$modal.hide('send-invite-dialog')"
    >
      <CloseIcon />
    </div>
    <div class="row">
      <h2 class="w700 t-33">Send System Invite</h2>
      <v-select
        v-model="project"
        label="name"
        code="id"
        item-text="name"
        :options="projects"
        :clearable="true"
        :searchable="true"
        class="form-control v-select-light project-select"
        placeholder="Select project"
      ><template #open-indicator="{ attributes }">
                          <span v-bind="attributes">
                            <icon-base
                              width="12"
                              height="6.84"
                              view-box="0 0 12 6.84"
                              icon-name="angle-down"
                            >
                              <icon-angle-down />
                            </icon-base>
                          </span> </template
      ></v-select>

      <div class="form-group">
                <textarea
                  class="form-control roboto"
                  placeholder="Send an invite message"
                  v-model="inviteMsg"
                ></textarea>
        <div class="btns">
          <button @click="sendInvite" class="btn btn-primary roboto">Submit</button>
        </div>
      </div>
    </div>
  </modal>
</template>

<script>
import CloseIcon from "../icons/CloseIcon.vue";
import Vue from "vue";
import vSelect from "vue-select";
import IconBase from "../../common/IconBase.vue";
import IconAngleDown from "../../common/icons/IconAngleDown.vue";

Vue.component("v-select", vSelect);

export default {
  name: "SendInviteModal",
  props: ['userprofile'],
  components: {
    CloseIcon,
    IconBase,
    IconAngleDown
  },
  data () {
    return {
      project: null,
      projects: [],
      inviteMsg:'',
      user_email:''
    }
  },
  mounted(){
    // if (!this.isAuthenticated || !localStorage.getItem("logged_user_id")) {
    //   this.$toast.error("You need to login firstly!");
    //   this.$router.push({ name: "home" });
    // }
    this.logged_user_id = localStorage.getItem("logged_user_id");
    this.loadProjects();
  },
  methods:{
    settingInviteEmail(){
      this.user_email = this.userprofile.email;
      console.log('this.user_email========',this.user_email);
    },
    async loadProjects(){
      const result = await this.callApi(
        "post",
        window.api_path + "project/getUserProjectsList",
        {
          mode: "selection",
          user_id:this.logged_user_id
        }
        );
      if (result.status != 200) {
        this.$toast.error(result.data.message);
        this.userProjects = [];
        return;
      }
      this.projects = result.data.userProjects;
    },
    async sendInvite(){

      if (!this.project) {
        this.$toast.warning("Please select a project! ");
        return;
      }
      if (!(this.inviteMsg)) {
        this.$toast.warning("Please write a message! ");
        return;
      }

      const result = await this.callApi(
        "post",
        window.api_path + "profile/userInvite",
        {
          user_id: this.logged_user_id,
          inviteMsg: this.inviteMsg,
          project: this.project,
          invite_to_email:this.userprofile.email
        }
      );
      if (result.status != 200) {
        this.$toast.error(result.data.message);
        this.Userprojects = [];
        return;
      }
      this.$modal.hide('send-invite-dialog');
      // this.$emit('user-info', result);
      this.$toast.success("Invitation sent successfully");
    }
  }
};
</script>

<style lang="scss" scoped>
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
    margin-top: 30px;
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
  .form-group {
    width: 100%;
    textarea {
      background: #E6E6E6;
      border-radius: 5px;
      height: 194px;
      font-size: 24px;
      line-height: 28px;
      &::placeholder {
        color: #333333;
      }
    }
  }
}
.project-select {
  height: 55px;
  border: 2px solid #C3C5CC;
  border-radius: 8px;
  font-size: 17px;
  color: rgba(0, 0, 0, 0.5);
  padding-top: 2px;
  margin-bottom: 21px;
}
</style>

