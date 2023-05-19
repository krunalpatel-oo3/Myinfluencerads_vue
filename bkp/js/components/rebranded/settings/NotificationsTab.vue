<template>
  <div class="container c-tab notifications-tab">
    <div class="c-title">
      <p class="t-24 lh-36 w500 mb-0">Desktop</p>
    </div>
    <div class="row">
      <div class="col-6">
        <div class="form-select">
          <label>Show notifications for:</label>
          <v-select
            v-model="show_notifications"
            code="code"
            label="label"
            :options="show_notifications_options"
            :clearable="false"
            class="form-control v-select-light"
            placeholder="Select option"
          >
            <template #open-indicator="{ attributes }">
                            <span v-bind="attributes">
                              <icon-base
                                width="12"
                                height="6.84"
                                view-box="0 0 12 6.84"
                                icon-name="angle-down"
                              >
                                <icon-angle-down />
                              </icon-base>
                            </span></template
            >
          </v-select>
        </div>
        <div class="form-select">
          <label>Increment message counter for:</label>
          <v-select
            v-model="increment_message"
            code="code"
            label="label"
            :options="show_notifications_options"
            :clearable="false"
            class="form-control v-select-light"
            placeholder="Select option"
          >
            <template #open-indicator="{ attributes }">
                            <span v-bind="attributes">
                              <icon-base
                                width="12"
                                height="6.84"
                                view-box="0 0 12 6.84"
                                icon-name="angle-down"
                              >
                                <icon-angle-down />
                              </icon-base>
                            </span></template
            >
          </v-select>
        </div>
      </div>
    </div>
    <div class="d-flex flex-wrap">
      <div class="c-title w-100" style="margin-top: 49px; margin-bottom: 21px">
        <p class="t-24 lh-36 w500 mb-0">Email</p>
      </div>
      <p class="t-18 lh-23 t-color2 w-100" style="margin-bottom: 21px;">(Sending to e*********@gmail.com)</p>
      <label>Send and email with unread activity for: </label>
      <div class="d-flex flex-wrap w-100">
        <div class="email-select" style="padding-right: 35px">
          <v-select
            v-model="email_option"
            code="code"
            label="label"
            :options="email_options"
            :clearable="false"
            class="form-control v-select-light"
            placeholder="Select option"
          >
            <template #open-indicator="{ attributes }">
                            <span v-bind="attributes">
                              <icon-base
                                width="12"
                                height="6.84"
                                view-box="0 0 12 6.84"
                                icon-name="angle-down"
                              >
                                <icon-angle-down />
                              </icon-base>
                            </span></template
            >
          </v-select>
        </div>
        <div class="email-select" style="padding-left: 35px">
          <v-select
            v-model="email_option"
            code="code"
            label="label"
            :options="email_options"
            :clearable="false"
            class="form-control v-select-light"
            placeholder="Select option"
          >
            <template #open-indicator="{ attributes }">
                            <span v-bind="attributes">
                              <icon-base
                                width="12"
                                height="6.84"
                                view-box="0 0 12 6.84"
                                icon-name="angle-down"
                              >
                                <icon-angle-down />
                              </icon-base>
                            </span></template
            >
          </v-select>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import IconBase from "../../common/IconBase";
import IconAngleDown from '../../common/icons/IconAngleDown';

export default {
  name: "Notifications",
  components: {
    IconBase,
    IconAngleDown
  },
  data() {
    return {
      show_notifications: "All activity",
      show_notifications_options: ["All activity", "None"],
      email_options: ["Every 15 minutes", "Every 30 minutes", "Every 1 hour",
        "Every Day", "None"],
      email_option: null
    };
  }
};
</script>

<style scoped>

</style>
