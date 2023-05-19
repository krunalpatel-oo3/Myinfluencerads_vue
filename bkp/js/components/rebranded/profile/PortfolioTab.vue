<template>
  <div class="portfolio-section">
    <div class="row">
      <div :class=" 'col-6 d-flex ' +  (index % 2 === 0  ? 'justify-content-start'   : 'justify-content-end')
            "v-for="(proj, index) in userprofile.portfolio" >
        <div class="portfolio-card">
          <div style="position: relative">
            <img  v-for="(gallery_image,image_index) in proj.gallery_images"
                  :src="gallery_image.image_url" v-if="image_index==0"
                  @click="openModal(proj)"
                  alt=""
            />
          </div>
          <div class="row mx-0">
            <router-link
              to=""
              class="t-28 lh-54 w700 mb-0"
              style="margin-top: 11px"
            >{{ proj.title }}</router-link
            >
            <div class="ml-auto mt-2">
              <button
                @click="edit_portfolio(proj)"
                class="edit-icon-portfolio"
                style="margin-right: 5px"
              >
                <EditIcon />
              </button>
              <button
                @click="delete_portfolio(proj.id)"
                class="edit-icon-portfolio"
              >
                <DeleteIcon />
              </button>
            </div>

          </div>
          <p class="t-16 lh-23 t-color2">{{ proj.description }}</p>
        </div>
      </div>
    </div>

    <button @click="$modal.show('edit-description-dialog')" class="add-btn">
      <PlusIcon style="margin-right: 5px" />
      Add Public System Portfolio
    </button>
  </div>
</template>

<script>
export default {
  name: "PortfolioTab"
};
</script>

<style scoped>

</style>
