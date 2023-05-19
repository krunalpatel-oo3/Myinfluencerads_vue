<template>
  <modal
    name="edit-skills-dialog"
    :width="824"
    height="auto"
    :scrollable="true"
    :adaptive="true"
    transition=""
    class="section-modal edit-skills-modal"
  >
    <div
      class="modal-close"
      @click="$modal.hide('edit-skills-dialog')"
    >
      <CloseIcon />
    </div>
    <div class="row">
      <h2 class="w700 poppins t-33" style="margin-bottom: 17px">Skills</h2>
      <div class="form-group">
        <h3 class="w700 t-28 poppins" style="margin-bottom: 10px">{{editcategory ? editcategory.title : ''}}</h3>
        <vue-tags-input
          class="tag-input"
          v-model="productFilterValue"
          :tags="editcategory.skills ? editcategory.skills : []"
          :autocomplete-items="filteredProductItems"
          :add-only-from-autocomplete="true"
          placeholder="Add..."
          @tags-changed="updateVueProductsInput"
        />
        <div class="btns">
          <button @click="updateskill" class="btn btn-primary roboto">Submit</button>
        </div>
      </div>
    </div>
  </modal>
</template>
<script>
import VueTagsInput from "@johmun/vue-tags-input";
import CloseIcon from "../icons/CloseIcon.vue";

export default {
  name: "EditSkillsModal",
  props: ['editcategory'],
  components: {
    CloseIcon,
    VueTagsInput
  },
   data () {
    return {
      selectedTags: [],
      productFilterValue: "",
      selectedProducts: [
        // { text: "OBS Setup" }, { text: "Tech Support" }, { text: "Twitch Channel Setup" },
        // { text: "NDI Configuration" }, { text: "OBS Setup" }, { text: "Tech Support" },
        // { text: "Twitch Channel Setup" }
      ],
      autocompleteTagItems: [
        {
          text: "MySQL Administration"
        },
        {
          text: "API Integration"
        },
        {
          text: "MongoDB"
        }
      ],
      autocompleteProductItems: [

      ]
    }
   },
    mounted() {
    this.loadSkillList();
  //  console.log('editcategory');
  //  console.log(this.editcategory);
  //  this.selectedProducts = this.editcategory.skills;

 },
   created() {
   // console.log(editcategory.skills);
   //this.selectedProducts= editcategory.skills;
 },
  methods: {
     async loadSkillList() {
      const result = await this.callApi(
        "post",
        window.api_path + "getSkillList",
        { mode: "selection" }
      );
      if (result.status != 200) {
        this.$toast.error(result.data.message);
        this.skills = [];
        return;
      }
      this.autocompleteProductItems = result.data.skills;
     // console.log(this.autocompleteProductItems);

    },
    updateVueTagsInput(newTags) {
      console.log("updateVueTagsInput newTags::");
      console.log(newTags);
      this.selectedTags = newTags;
    },
    updateVueProductsInput(newProducts) {
      console.log("updateVueProductsInput newProducts::");
      console.log(newProducts);
     this.editcategory.skills = newProducts;
    },
       async updateskill() {
      // if (!this.isAuthenticated || !localStorage.getItem("logged_user_id")) {
      //   this.$toast.error("You need to login add question !");
      //   return;
      // }
     console.log(this.editcategory.skills);
      if (!this.editcategory.skills) {
        this.$toast.warning(" skill is required! ");
        return;
      }



      const result = await this.callApi(
        "post",
        window.api_path + "profile/updateSkill",
        {
          skill: this.editcategory.skills,
          user_id: localStorage.logged_user_id,
          cateogry: this.editcategory.category_id
        }
      );

      if (result.status != 200) {
        this.$toast.error(result.data.message);
        return;
      }
      this.newCommunityText = "";
      this.$toast.success("Profile skills updated successfully");
      this.$modal.hide('edit-skills-dialog');

      this.$emit('update-skill', result);
      //this.$router.push(this.redirecturl + result.data.slug);
    }
  },
  computed: {

    filteredProductItems() {
      console.log("SDfsdf");
      return this.autocompleteProductItems.filter(i => {
        return (
          i.text
            .toLowerCase()
            .indexOf(this.productFilterValue.toLowerCase()) !== -1
        );
      });
    },

    filteredTagItems() {
      return this.autocompleteTagItems.filter(i => {
        return (
          i.text.toLowerCase().indexOf(this.tagFilterValue.toLowerCase()) !== -1
        );
      });
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
</style>
