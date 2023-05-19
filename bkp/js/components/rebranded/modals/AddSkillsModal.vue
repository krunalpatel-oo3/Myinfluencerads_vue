<template>
  <modal
    name="add-skills-dialog"
    :width="824"
    height="auto"
    :scrollable="true"
    :adaptive="true"
    transition=""
    class="section-modal add-skills-modal overflow-none"
  >
    <div
      class="modal-close"
      @click="$modal.hide('add-skills-dialog')"
    >
      <CloseIcon />
    </div>
    <div class="row">
      <h2 class="w700 poppins t-33" style="margin-bottom: 0px">Add Skills</h2>
      <div class="form-group">
        <h3 class="w700 t-22" style="margin-bottom: 10px">Add a category</h3>
        <v-select
          v-model="selection_category_id"
          code="id"
          item-text="text"
          label="text"
          :options="categorySelectionItems"
          :clearable="true"
          :searchable="true"
          class="form-control v-select-light select-category"
          placeholder="Select option"
          style="height: 51px; padding-top: 3px;"
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
        <h3 class="w700 t-22" style="margin-top: 20px">Add skill tags</h3>
        <vue-tags-input
          class="tag-input search-tags custom-search"
          v-model="productFilterValue"
          :tags="selectedProducts"
          :autocomplete-items="filteredProductItems"
          :add-only-from-autocomplete="true"
          placeholder="Add..."
          @tags-changed="updateVueProductsInput"
        />
        <div class="btns">
          <button @click="addcategory" class="btn btn-primary roboto" :disabled="submitting">
            <div v-if="submitting" class="spinner-border" role="status">
              <span class="sr-only">Loading...</span>
            </div>
            Submit
          </button>
        </div>
      </div>
    </div>
  </modal>
</template>

<script>
import VueTagsInput from "@johmun/vue-tags-input";
import CloseIcon from "../icons/CloseIcon.vue";
import IconBase from "../../common/IconBase";
import IconAngleDown from "../../common/icons/IconAngleDown.vue";

import Vue from "vue";
import vSelect from "vue-select";

Vue.component("v-select", vSelect);
import "vue-select/dist/vue-select.css";

export default {
  name: "EditSkillsModal",
  components: {
    CloseIcon,
    VueTagsInput,
    IconBase,
    IconAngleDown
  },
  data() {
    return {
      selectedTags: [],
      productFilterValue: "",
      selectedProducts: [],
      categorySelectionItems: [],
      selection_category_id: null,
      skillSelectionItems: [],
      submitting: false,
      //filteredProductItems:null,
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
        {
          text: "MySQL Administration"
        },
        {
          text: "API Integration"
        },
        {
          text: "MongoDB"
        }
      ]
    };
  },
  mounted() {
    this.loadCategoriesList();
    this.loadSkillList();
  },
  methods: {
    async loadSkillList() {
      const result = await this.callApi(
        "post",
        window.api_path + "getSkillList",
        { mode: "selection" }
      );
      if (result.status !== 200) {
        this.$toast.error(result.data.message);
        this.skills = [];
        return;
      }
      this.autocompleteProductItems = result.data.skills;
      console.log(this.autocompleteProductItems);
      this.autocompleteskillItems = result.data.skills;
    },
    async loadCategoriesList() {
      // console.log(' loadCategoriesList:')
      const result = await this.callApi(
        "post",
        window.api_path + "getCategoriesList",
        { mode: "selection" }
      );
      if (result.status !== 200) {
        this.$toast.error(result.data.message);
        this.categories = [];
        return;
      }
      // console.log('result.data::')
      // console.log(result.data)
      this.categorySelectionItems = result.data.categories;
    },
    updateVueTagsInput(newTags) {
      this.selectedTags = newTags;
    },
    updateVueProductsInput(newProducts) {
      this.selectedProducts = newProducts;
    },
    async addcategory() {
      if (!this.selectedTags) {
        this.$toast.warning(" skill is required! ");
        return;
      }
      if (!this.selection_category_id) {
        this.$toast.warning(" Category is required! ");
        return;
      }
      this.submitting = true;
      const result = await this.callApi(
        "post",
        window.api_path + "profile/addskill",
        {
          skill: this.selectedProducts,
          user_id: localStorage.logged_user_id,
          cateogry: this.selection_category_id
        }
      );
      this.submitting = false;
      if (result.data.code === 0) {
        this.$toast.error(result.data.data);
        return;
      }
      this.newCommunityText = "";
      this.selection_category_id = null;
      this.productFilterValue = "";
      this.selectedProducts = [];
      this.$modal.hide("add-skills-dialog");
      this.$toast.success("Profile skills Added successfully");
      this.$emit("update-skill");
    }

  },
  computed: {
    filteredProductItems() {
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

  input {
    border-radius: 5px;
    height: 60px;
    background: #E5E5E5;
    border: none;
    width: 100%;
    margin-bottom: 20px;
    font-size: 22px;
    padding-left: 20px;
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

