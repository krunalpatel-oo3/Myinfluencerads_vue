<template>
  <div class="container c-tab">
    <div class="c-title">
      <p class="t-24 lh-36 w500 mb-0">Location</p>
    </div>
    <div class="d-flex flex-wrap mx-0 setting-item" style="margin-top: 23px;">
      <div>
        <p class="t-24 lh-36 w500 mb-0">Time Zone
          <button @click="$modal.show('edit-timezone-dialog')" class="edit-icon"
                  style="position: relative; margin-left: 10px">
            <EditIcon />
          </button>
        </p>
        <p class="t-18 lh-23 t-color2 mb-0" style="margin-top: 15px">{{userProfile.timezone}}</p>
      </div>
    </div>
    <div class="d-flex flex-wrap mx-0 setting-item" style="margin-top: 23px;">
      <div>
        <p class="t-24 lh-36 w500 mb-0">Address
          <button @click="$modal.show('edit-address-dialog')" class="edit-icon"
                  style="position: relative; margin-left: 10px">
            <EditIcon />
          </button>
        </p>
        <p class="t-16 lh-23 t-color2 mb-0" style="margin-top: 15px; max-width: 456px">{{userProfile.address}} {{userProfile.location}}</p>
      </div>
    </div>
    <div class="d-flex flex-wrap mx-0 setting-item" style="margin-top: 23px;">
      <div>
        <p class="t-24 lh-36 w500 mb-0">Phone
          <button @click="$modal.show('edit-phone-dialog')" class="edit-icon"
                  style="position: relative; margin-left: 10px">
            <EditIcon />
          </button>
        </p>
        <p class="t-16 lh-23 t-color2 mb-0" style="margin-top: 15px">{{userProfile.phone}}</p>
      </div>
    </div>
  </div>
</template>

<script>
import EditIcon from "../icons/EditIcon";

export default {
  name: "LocationTab",
  props: {
    userProfile: {
      type: Object,
      required: true,
    }
  },
  components: {
    EditIcon
  }
};
</script>

<style scoped>

</style>
