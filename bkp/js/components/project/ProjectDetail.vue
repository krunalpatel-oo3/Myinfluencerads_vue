<!--<template>
   <div class="proposal-rebranded">
    <Header />
    <div class="container">
      <h1 class="t-black t-36 w700" style="margin-top: 30px; margin-bottom: 10px">{{ title }}</h1>
      <div class="project-info">
        <div class="row">
          <div class="col-5">
            <h2 class="t-black w700 t-28" style="margin: 0">{{ projectData.name }}</h2>
            <router-link to="" class="t-color1 t-24 w600 category-link" style="margin-top: 5.5px">{{projectData.category.title}}</router-link>
            <p style="margin-top: 10px">{{ projectData.short_desc }}</p>
            <div class="row mx-0">
              <div v-if="projectData.type === 'hourly'" class="per-hour d-flex" style="margin-right: 25px">
                <HourlyIcon :width="'30'" :height="'30'" style="margin-right: 11px" />
                <p class="t-black w700 t-22 mb-0">${{ projectData.hourly_rate }}/hr</p>
              </div>
              <div v-if="projectData.type === 'hourly'" class="hours d-flex">
                <CalendarIcon :width="'30'" :height="'30'" style="margin-right: 11px" />
                <p class="t-black w700 t-22 mb-0">{{ projectData.weekly_limit }} hrs / week</p>
              </div>
              <div v-if="projectData.type === 'fixed'" class="hours d-flex">
                <FixedPrice style="margin-right: 11px" />
                <p class="t-black w700 t-22 mb-0">${{ projectData.estimated_budget }}</p>
              </div>
            </div>
          </div>
          <div class="col-7">
            <div class="row w-100 d-flex justify-content-end align-items-end h-100">
              <div class="user-info">
                <div class="row align-items-center">
                  <img :src="`${publicPath}user_info.png`" width="60px" height="60px" alt="">
                  <router-link to="" class="w600 t-24 t-black my-0" style="margin-left: 12px">James K</router-link>
                </div>
                <div class="row" style="margin-top: 8.3px">
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
                  <p class="t-24 w500 t-black" style="line-height: 24px; margin-left: 15.14px">4.7</p>
                </div>
                <div class="row">
                  <p class="w500 t-black t-16 mb-0">United States</p>
                  <p class="w500 t-black t-16 mb-0">10 projects posted, 6 hires</p>
                  <p class="w500 t-black t-16 mb-0">$1000 total spent</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="project-gallery" style="margin-top: 13px;">
        <div class="project-gallery-top">
          <swiper class="swiper" :options="swiperOptionTop" ref="swiperTop">

            <swiper-slide
              :key="index"
              v-for="(imgpath, index) in projectImage"
            ><img :src="imgpath.projectImagePropsArray.image_url"
            /></swiper-slide>
            <swiper-slide>
              <iframe width="100%" :src="projectData.link_youtube" frameborder="0"></iframe>
            </swiper-slide>
            <div class="swiper-btn-prev" slot="button-prev">
              <icon-base
                width="16.54"
                height="28"
                view-box="0 0 16.54 28"
                icon-name="angle-right-2"
              >
                <icon-angle-right-2 />
              </icon-base>
            </div>
            <div class="swiper-btn-next" slot="button-next">
              <icon-base
                width="16.54"
                height="28"
                view-box="0 0 16.54 28"
                icon-name="angle-right-2"
              >
                <icon-angle-right-2 />
              </icon-base>
            </div>
          </swiper>
        </div>
        <div class="project-gallery-thumbs">
          <swiper
            class="swiper gallery-thumbs"
            :options="swiperOptionThumbs"
            ref="swiperThumbs"
          >

            <swiper-slide
              :key="index"
             v-for="(imgpath, index) in projectImage"
            ><img :src="imgpath.projectImagePropsArray.image_url"
            /></swiper-slide>
             <swiper-slide>
              <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ2Jv2IZWtzbA6YC6m_mdZwr1NiLag34ebipQ&usqp=CAU" alt="">
            </swiper-slide>
          </swiper>
        </div>
      </div>
      <div class="row equipments">
        <h2 class="w700 t-24 t-black roboto">Equipments</h2>
        <table class="table table-align-middle">
          <thead>
          <tr>
            <th scope="col" class="text-center">#</th>
            <th scope="col" class="th-product-name">Product name</th>
            <th scope="col">Description</th>
            <th scope="col" class="text-center">Manufacturer</th>
            <th scope="col" class="text-center">Price</th>
            <th scope="col" class="text-center">Shop</th>
          </tr>
          </thead>
          <tbody>
          <tr v-for="(project,key) in projectProducts" :key="key">
            <td class="text-center">{{ key+1 }}</td>
            <td>
              <div class="d-flex align-items-center">
                <img
                  :src="`${publicPath}camera_360.png`"
                  alt=""
                  class="rounded-circle width-32 mr-2"
                />
                <div class="text-nowrap flex-grow-1">{{ project.product.name.substring(0, 20) }}</div>
              </div>
            </td>
            <td>
              {{ project.product.desc.substring(0, 50) }}
            </td>
            <td class="text-center">
              {{ project.product.manufacturer.substring(0, 50) }}
            </td>
            <td class="text-center">{{ project.product.price }}</td>
            <td class="text-center">
              <a target="_blank" v-bind:href="project.product.link" class="btn btn-xs btn-link">
                <icon-base
                  width="20"
                  height="17.58"
                  view-box="0 0 20 17.58"
                  icon-name="shopping-cart"
                >
                  <icon-shopping-cart />
                </icon-base>
              </a>
            </td>
          </tr>

          </tbody>
        </table>
      </div>
      <div class="row project-description">
        <h2 class="w700 t-24 t-black roboto" style="margin-bottom: 9.5px">Project Description</h2>
        <div class="paragraph">
          {{projectData.desc}}
        </div>

      </div>
      <div class="row docs">
        <div class="col-6">
          <h2 class="t-24 t-black w700 roboto mb-0">Documents</h2>
          <div class="row mx-0">
            <div class="doc" v-for="(pdf,key) in projectPdf" :key="key">
              <a target="_blank" v-bind:href="pdf.projectPdfPropsArray.image_url">
                <div class="doc-icon">
                  <img :src="`${publicPath}pdf_icon.png`" alt="">
                </div>
                <p class="t-12 doc-link" style="margin-top: 12px; color: rgba(0, 0, 0, 0.3)">{{ pdf.info }}</p>
              </a>
            </div>
          </div>
        </div>
        <div class="col-6">
          <h2 class="t-24 t-black w700 roboto mb-0">Website Link</h2>
          <a href="#" class="w400 t-16 website-link" style="color: rgba(0, 0, 0, 0.8)">{{projectData.link_url }}</a>
        </div>
      </div>
      <div class="row tags">
        <h2 class="t-24 w700 text-black roboto" style="margin-bottom: 8px">Tags</h2>
        <div class="col-12">
          <div class="row">
            <button class="tag" v-for="(tag,key) in projectTags" :key="key">
              {{ tag.tag.title }}
            </button>
          </div>
        </div>
      </div>
<section class="section-project">
      <div class="project-author-b">
            <div class="userpic">
              <router-link to="/projects/2">
                <img
                  class="rounded-circle"
                  :src="`${publicPath}userpic-60.jpg`"
                  alt=""
                />
              </router-link>
            </div>
            <div class="author-info">
              <div class="username">
                <router-link to="">
                  James K
                </router-link>
              </div>
              <div class="author-desc">
                Have you ever seen stars below the sky, on the earth? Yes, the
                spark of light emerging from the land. On a cold night, standing
                on a peak of the mountain, when you look down at the place.
              </div>
            </div>
          </div>
</section>-->

<!-- Comments -->
 <!--        <section class="project-comments">
          <h2 class="comments-h">Comments</h2>
=======
<!--<template>-->
<!--   <div class="proposal-rebranded">-->
<!--    <Header />-->
<!--    <div class="container">-->
<!--      <h1 class="t-black t-36 w700" style="margin-top: 30px; margin-bottom: 10px">{{ title }}</h1>-->
<!--      <div class="project-info">-->
<!--        <div class="row">-->
<!--          <div class="col-5">-->
<!--            <h2 class="t-black w700 t-28" style="margin: 0">{{ projectData.name }}</h2>-->
<!--            <router-link to="" class="t-color1 t-24 w600 category-link" style="margin-top: 5.5px">{{projectData.category.title}}</router-link>-->
<!--            <p style="margin-top: 10px">{{ projectData.short_desc }}</p>-->
<!--            <div class="row mx-0">-->
<!--              <div v-if="projectData.type === 'hourly'" class="per-hour d-flex" style="margin-right: 25px">-->
<!--                <HourlyIcon :width="'30'" :height="'30'" style="margin-right: 11px" />-->
<!--                <p class="t-black w700 t-22 mb-0">${{ projectData.hourly_rate }}/hr</p>-->
<!--              </div>-->
<!--              <div v-if="projectData.type === 'hourly'" class="hours d-flex">-->
<!--                <CalendarIcon :width="'30'" :height="'30'" style="margin-right: 11px" />-->
<!--                <p class="t-black w700 t-22 mb-0">{{ projectData.weekly_limit }} hrs / week</p>-->
<!--              </div>-->
<!--              <div v-if="projectData.type === 'fixed'" class="hours d-flex">-->
<!--                <FixedPrice style="margin-right: 11px" />-->
<!--                <p class="t-black w700 t-22 mb-0">${{ projectData.estimated_budget }}</p>-->
<!--              </div>-->
<!--            </div>-->
<!--          </div>-->
<!--          <div class="col-7">-->
<!--            <div class="row w-100 d-flex justify-content-end align-items-end h-100">-->
<!--              <div class="user-info">-->
<!--                <div class="row align-items-center">-->
<!--                  <img :src="`${publicPath}user_info.png`" width="60px" height="60px" alt="">-->
<!--                  <router-link to="" class="w600 t-24 t-black my-0" style="margin-left: 12px">James K</router-link>-->
<!--                </div>-->
<!--                <div class="row" style="margin-top: 8.3px">-->
<!--                  <div class="reviews-summary-rating">-->
<!--                    <div class="rating-val-w">-->
<!--                      <div class="rating rating-lg">-->
<!--                        <div class="rating-current" style="width: 95%;">-->
<!--                          <icon-base-->
<!--                            width="68.01"-->
<!--                            height="11"-->
<!--                            view-box="0 0 68.01 10.57"-->
<!--                            icon-name="stars"-->
<!--                          >-->
<!--                            <icon-stars />-->
<!--                          </icon-base>-->
<!--                        </div>-->
<!--                        <div class="rating-total">-->
<!--                          <icon-base-->
<!--                            width="127"-->
<!--                            height="20.5"-->
<!--                            view-box="0 0 68.01 10.57"-->
<!--                            icon-name="stars"-->
<!--                          >-->
<!--                            <icon-stars />-->
<!--                          </icon-base>-->
<!--                        </div>-->
<!--                      </div>-->
<!--                    </div>-->
<!--                  </div>-->
<!--                  <p class="t-24 w500 t-black" style="line-height: 24px; margin-left: 15.14px">4.7</p>-->
<!--                </div>-->
<!--                <div class="row">-->
<!--                  <p class="w500 t-black t-16 mb-0">United States</p>-->
<!--                  <p class="w500 t-black t-16 mb-0">10 projects posted, 6 hires</p>-->
<!--                  <p class="w500 t-black t-16 mb-0">$1000 total spent</p>-->
<!--                </div>-->
<!--              </div>-->
<!--            </div>-->
<!--          </div>-->
<!--        </div>-->
<!--      </div>-->
<!--      <div class="project-gallery" style="margin-top: 13px;">-->
<!--        <div class="project-gallery-top">-->
<!--          <swiper class="swiper" :options="swiperOptionTop" ref="swiperTop">-->

<!--            <swiper-slide-->
<!--              :key="index"-->
<!--              v-for="(imgpath, index) in projectImage"-->
<!--            ><img :src="imgpath.projectImagePropsArray.image_url"-->
<!--            /></swiper-slide>-->
<!--            <swiper-slide>-->
<!--              <iframe width="100%" :src="projectData.link_youtube" frameborder="0"></iframe>-->
<!--            </swiper-slide>-->
<!--            <div class="swiper-btn-prev" slot="button-prev">-->
<!--              <icon-base-->
<!--                width="16.54"-->
<!--                height="28"-->
<!--                view-box="0 0 16.54 28"-->
<!--                icon-name="angle-right-2"-->
<!--              >-->
<!--                <icon-angle-right-2 />-->
<!--              </icon-base>-->
<!--            </div>-->
<!--            <div class="swiper-btn-next" slot="button-next">-->
<!--              <icon-base-->
<!--                width="16.54"-->
<!--                height="28"-->
<!--                view-box="0 0 16.54 28"-->
<!--                icon-name="angle-right-2"-->
<!--              >-->
<!--                <icon-angle-right-2 />-->
<!--              </icon-base>-->
<!--            </div>-->
<!--          </swiper>-->
<!--        </div>-->
<!--        <div class="project-gallery-thumbs">-->
<!--          <swiper-->
<!--            class="swiper gallery-thumbs"-->
<!--            :options="swiperOptionThumbs"-->
<!--            ref="swiperThumbs"-->
<!--          >-->

<!--            <swiper-slide-->
<!--              :key="index"-->
<!--             v-for="(imgpath, index) in projectImage"-->
<!--            ><img :src="imgpath.projectImagePropsArray.image_url"-->
<!--            /></swiper-slide>-->
<!--             <swiper-slide>-->
<!--              <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ2Jv2IZWtzbA6YC6m_mdZwr1NiLag34ebipQ&usqp=CAU" alt="">-->
<!--            </swiper-slide>-->
<!--          </swiper>-->
<!--        </div>-->
<!--      </div>-->
<!--      <div class="row equipments">-->
<!--        <h2 class="w700 t-24 t-black roboto">Equipments</h2>-->
<!--        <table class="table table-align-middle">-->
<!--          <thead>-->
<!--          <tr>-->
<!--            <th scope="col" class="text-center">#</th>-->
<!--            <th scope="col" class="th-product-name">Product name</th>-->
<!--            <th scope="col">Description</th>-->
<!--            <th scope="col" class="text-center">Manufacturer</th>-->
<!--            <th scope="col" class="text-center">Price</th>-->
<!--            <th scope="col" class="text-center">Shop</th>-->
<!--          </tr>-->
<!--          </thead>-->
<!--          <tbody>-->
<!--          <tr v-for="(project,key) in projectProducts" :key="key">-->
<!--            <td class="text-center">{{ key+1 }}</td>-->
<!--            <td>-->
<!--              <div class="d-flex align-items-center">-->
<!--                <img-->
<!--                  :src="`${publicPath}camera_360.png`"-->
<!--                  alt=""-->
<!--                  class="rounded-circle width-32 mr-2"-->
<!--                />-->
<!--                <div class="text-nowrap flex-grow-1">{{ project.product.name.substring(0, 20) }}</div>-->
<!--              </div>-->
<!--            </td>-->
<!--            <td>-->
<!--              {{ project.product.desc.substring(0, 50) }}-->
<!--            </td>-->
<!--            <td class="text-center">-->
<!--              {{ project.product.manufacturer.substring(0, 50) }}-->
<!--            </td>-->
<!--            <td class="text-center">{{ project.product.price }}</td>-->
<!--            <td class="text-center">-->
<!--              <a target="_blank" v-bind:href="project.product.link" class="btn btn-xs btn-link">-->
<!--                <icon-base-->
<!--                  width="20"-->
<!--                  height="17.58"-->
<!--                  view-box="0 0 20 17.58"-->
<!--                  icon-name="shopping-cart"-->
<!--                >-->
<!--                  <icon-shopping-cart />-->
<!--                </icon-base>-->
<!--              </a>-->
<!--            </td>-->
<!--          </tr>-->

<!--          </tbody>-->
<!--        </table>-->
<!--      </div>-->
<!--      <div class="row project-description">-->
<!--        <h2 class="w700 t-24 t-black roboto" style="margin-bottom: 9.5px">Project Description</h2>-->
<!--        <div class="paragraph">-->
<!--          {{projectData.desc}}-->
<!--        </div>-->

<!--      </div>-->
<!--      <div class="row docs">-->
<!--        <div class="col-6">-->
<!--          <h2 class="t-24 t-black w700 roboto mb-0">Documents</h2>-->
<!--          <div class="row mx-0">-->
<!--            <div class="doc" v-for="(pdf,key) in projectPdf" :key="key">-->
<!--              <a target="_blank" v-bind:href="pdf.projectPdfPropsArray.image_url">-->
<!--                <div class="doc-icon">-->
<!--                  <img :src="`${publicPath}pdf_icon.png`" alt="">-->
<!--                </div>-->
<!--                <p class="t-12 doc-link" style="margin-top: 12px; color: rgba(0, 0, 0, 0.3)">{{ pdf.info }}</p>-->
<!--              </a>-->
<!--            </div>-->
<!--          </div>-->
<!--        </div>-->
<!--        <div class="col-6">-->
<!--          <h2 class="t-24 t-black w700 roboto mb-0">Website Link</h2>-->
<!--          <a href="#" class="w400 t-16 website-link" style="color: rgba(0, 0, 0, 0.8)">{{projectData.link_url }}</a>-->
<!--        </div>-->
<!--      </div>-->
<!--      <div class="row tags">-->
<!--        <h2 class="t-24 w700 text-black roboto" style="margin-bottom: 8px">Tags</h2>-->
<!--        <div class="col-12">-->
<!--          <div class="row">-->
<!--            <button class="tag" v-for="(tag,key) in projectTags" :key="key">-->
<!--              {{ tag.tag.title }}-->
<!--            </button>-->
<!--          </div>-->
<!--        </div>-->
<!--      </div>-->
<!--<section class="section-project">-->
<!--      <div class="project-author-b">-->
<!--            <div class="userpic">-->
<!--              <router-link to="/projects/2">-->
<!--                <img-->
<!--                  class="rounded-circle"-->
<!--                  :src="`${publicPath}userpic-60.jpg`"-->
<!--                  alt=""-->
<!--                />-->
<!--              </router-link>-->
<!--            </div>-->
<!--            <div class="author-info">-->
<!--              <div class="username">-->
<!--                <router-link to="">-->
<!--                  James K-->
<!--                </router-link>-->
<!--              </div>-->
<!--              <div class="author-desc">-->
<!--                Have you ever seen stars below the sky, on the earth? Yes, the-->
<!--                spark of light emerging from the land. On a cold night, standing-->
<!--                on a peak of the mountain, when you look down at the place.-->
<!--              </div>-->
<!--            </div>-->
<!--          </div>-->
<!--</section>-->

<!--&lt;!&ndash; Comments &ndash;&gt;-->
<!--        <section class="project-comments">-->
<!--          <h2 class="comments-h">Comments</h2>-->
>>>>>>> d30bfe5610f50aa47d93c0298998293040cf86ea

<!--          <div class="comments-list"></div>-->

<<<<<<< HEAD
          <div class="comments-form">
            <div class="form-group">
              <label>Leave a comment</label>
              <textarea
                name=""
                rows="5"
                class="form-control"
                placeholder="Post your comment here"
              ></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Post</button>
          </div>
        </section>-->
        <!-- End of Comments -->

      <!--  <div class="project-quote">
          <!-- Send Quote Modal -->
        <!--  <button class="btn btn-secondary" @click="showQuoteDialog">
            Send a Quote
          </button>

          <modal
            name="quote-modal-dialog"
            :width="1160"
            height="auto"
            :scrollable="true"
            :adaptive="true"
            transition=""
            class="section-modal section-modal-quote"
          >
            <div class="modal-close" @click="hideQuoteDialog">
              <icon-base
                width="21"
                height="21"
                viewBox="0 0 7 7"
                icon-name="cancel"
                ><icon-cancel
              /></icon-base>
            </div>
            <h2 class="h1">Send a Quote</h2>
            <div class="form-group">
              <textarea
                rows="14"
                class="form-control"
                placeholder="Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua."
              ></textarea>
            </div>
            <div
              class="form-row align-items-center justify-content-end budget-row"
            >
              <div class="col-auto">
                <label>Budget:</label>
              </div>
              <div class="col-auto">
                <input type="text" class="form-control form-control" />
              </div>
            </div>
            <div class="btns">
              <button class="btn btn-primary ml-auto">Send</button>
            </div>
          </modal>
          <!-- End of Send Quote Modal -->
      <!--  </div>-->

        <!-- Other Projects
        <section class="section-similar">
          <h2 class="h1">Related Projects</h2>
=======
<!--          <div class="comments-form">-->
<!--            <div class="form-group">-->
<!--              <label>Leave a comment</label>-->
<!--              <textarea-->
<!--                name=""-->
<!--                rows="5"-->
<!--                class="form-control"-->
<!--                placeholder="Post your comment here"-->
<!--              ></textarea>-->
<!--            </div>-->
<!--            <button type="submit" class="btn btn-primary">Post</button>-->
<!--          </div>-->
<!--        </section>-->
<!--        &lt;!&ndash; End of Comments &ndash;&gt;-->

<!--        <div class="project-quote">-->
<!--          &lt;!&ndash; Send Quote Modal &ndash;&gt;-->
<!--          <button class="btn btn-secondary" @click="showQuoteDialog">-->
<!--            Send a Quote-->
<!--          </button>-->

<!--          <modal-->
<!--            name="quote-modal-dialog"-->
<!--            :width="1160"-->
<!--            height="auto"-->
<!--            :scrollable="true"-->
<!--            :adaptive="true"-->
<!--            transition=""-->
<!--            class="section-modal section-modal-quote"-->
<!--          >-->
<!--            <div class="modal-close" @click="hideQuoteDialog">-->
<!--              <icon-base-->
<!--                width="21"-->
<!--                height="21"-->
<!--                viewBox="0 0 7 7"-->
<!--                icon-name="cancel"-->
<!--                ><icon-cancel-->
<!--              /></icon-base>-->
<!--            </div>-->
<!--            <h2 class="h1">Send a Quote</h2>-->
<!--            <div class="form-group">-->
<!--              <textarea-->
<!--                rows="14"-->
<!--                class="form-control"-->
<!--                placeholder="Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua."-->
<!--              ></textarea>-->
<!--            </div>-->
<!--            <div-->
<!--              class="form-row align-items-center justify-content-end budget-row"-->
<!--            >-->
<!--              <div class="col-auto">-->
<!--                <label>Budget:</label>-->
<!--              </div>-->
<!--              <div class="col-auto">-->
<!--                <input type="text" class="form-control form-control" />-->
<!--              </div>-->
<!--            </div>-->
<!--            <div class="btns">-->
<!--              <button class="btn btn-primary ml-auto">Send</button>-->
<!--            </div>-->
<!--          </modal>-->
<!--          &lt;!&ndash; End of Send Quote Modal &ndash;&gt;-->
<!--        </div>-->

<!--        &lt;!&ndash; Other Projects &ndash;&gt;-->
<!--        <section class="section-similar">-->
<!--          <h2 class="h1">Related Projects</h2>-->
>>>>>>> d30bfe5610f50aa47d93c0298998293040cf86ea

<!--          <div class="row">-->
<!--            <div  v-for="project_related in projectRelated"-->
<!--              :key="project_related.id" class="col-lg-3 col-sm-6 col-xs-12">-->
<!--              <div class="card card-project">-->
<!--                <div class="card-img-top">-->
<!--                  <router-link :to="{-->
<!--                      name: 'projectDetail',-->
<!--                      params: { slug: project_related.slug }-->
<!--                    }">-->
<!--                    <img :src="`${publicPath}no-image.jpg`" alt="" />-->
<!--                    <span-->
<!--                      class="is-featured"-->
<!--                      :style="{-->
<!--                        backgroundImage: `url(${publicPath}featured-bg.png)`-->
<!--                      }"-->
<!--                      >Featured</span-->
<!--                    >-->
<!--                  </router-link>-->
<!--                </div>-->
<!--                <div class="card-body">-->
<!--                  <div class="card-title-vote">-->
<!--                    <div class="card-title">-->
<!--                      <router-link :to="{-->
<!--                      name: 'projectDetail',-->
<!--                      params: { slug: project_related.slug }-->
<!--                    }">-->
<!--                        {{project_related.name}}-->
<!--                      </router-link>-->
<!--                    </div>-->
<!--                    <button class="btn btn-link btn-icon btn-vote">-->
<!--                      <icon-base-->
<!--                        width="18"-->
<!--                        height="17.25"-->
<!--                        view-box="0 0 18 17.25"-->
<!--                        icon-name="like-4"-->
<!--                      >-->
<!--                        <icon-like-4 />-->
<!--                      </icon-base>-->
<!--                    </button>-->
<!--                  </div>-->
<!--                  <div class="card-category">-->
<!--                    <div class="label">-->
<!--                      <router-link to="/">   {{project_related.category.title}}</router-link>-->
<!--                    </div>-->
<!--                  </div>-->

<!--                  <p class="card-text">-->
<!--                   {{project_related.desc.substring(0, 120)}}-->
<!--                  </p>-->

<!--                  <div class="card-price-more">-->
<!--                    <div class="more">-->
<!--                      <router-link :to="{-->
<!--                      name: 'projectDetail',-->
<!--                      params: { slug: project_related.slug }-->
<!--                    }" class="btn btn-link btn-icon">-->
<!--                        <span>Learn More</span>-->
<!--                        <icon-base-->
<!--                          width="18"-->
<!--                          height="8.72"-->
<!--                          view-box="0 0 18 8.72"-->
<!--                          icon-name="arrow-right"-->
<!--                        >-->
<!--                          <icon-arrow-right />-->
<!--                        </icon-base>-->
<!--                      </router-link>-->
<!--                    </div>-->
<!--                    <div class="projectby">-->
<!--                      <span>Project by</span>-->
<!--                      <router-link to="/projects/2">-->
<!--                        <img-->
<!--                          :src="`${publicPath}user-avatar-sm.jpg`"-->
<!--                          alt=""-->
<!--                          class="rounded-circle"-->
<!--                        />-->
<!--                      </router-link>-->
<!--                    </div>-->
<!--                  </div>-->
<!--                </div>-->
<!--              </div>-->
<!--            </div>-->

<!--          </div>-->
<!--        </section>-->
<!--        &lt;!&ndash; End of Other Projects &ndash;&gt;-->


<<<<<<< HEAD
     <!-- <BottomMain />
      <PendingInvite />
      <ProjectInProgress />
      <BuyerWaiting v-if="type === 'waiting-for-accept'"/>
      <BuyerInProgress v-if="type === 'in-progress'"/>
      <BuyerCompleted v-if="type === 'completed'"/>
      <HireBottom v-if="type === 'hire'"/>
    </div>
    <Footer style="margin-top: 138px"/>
  </div>
</template> -->

<script>
// import Vue from "vue";
// // import {
// //   Swiper as SwiperClass,
// //   Pagination,
// //   Navigation,
// //   Mousewheel,
// //   Autoplay
// // } from "swiper/swiper.esm";
// import getAwesomeSwiper from "vue-awesome-swiper/dist/exporter";
// //import { Swiper, SwiperSlide, directive } from "vue-awesome-swiper";
// import "vue-loading-overlay/dist/vue-loading.css";

// import Header from "../common/Header.vue";
// import Footer from "../common/Footer.vue";
// import IconStars from "../common/icons/IconStars.vue";

// import IconBase from "../common/IconBase.vue";
// import IconLike2 from "../common/icons/IconLike2.vue";
// import IconLink from "../common/icons/IconLink.vue";
// import IconShoppingCart from "../common/icons/IconShoppingCart.vue";
// import IconPdf from "../common/icons/IconPdf.vue";
// import IconArrowRight from "../common/icons/IconArrowRight.vue";
// import IconAngleRight2 from "../common/icons/IconAngleRight2.vue";
// import IconCancel from "../common/icons/IconCancel.vue";
// import IconLike4 from "../common/icons/IconLike4.vue";
// import IconLike5 from "../common/icons/IconLike5.vue";

// import BottomMain from "../rebranded/bottom_components/BottomMain.vue";
// import PendingInvite from "../rebranded/bottom_components/PendingInvite.vue";
// import ProjectInProgress from "../rebranded/bottom_components/ProjectInProgress.vue";

// import ArrowDown from "../rebranded/icons/ArrowDown";
// import LinkRight from "../rebranded/icons/LinkRight";
// import SearchIcon from "../rebranded/icons/SearchIcon";
// import IconAngleDown from "./../common/icons/IconAngleDown.vue";
// import VueTagsInput from "@johmun/vue-tags-input";
// import vSelect from "vue-select";
// import SendInviteModal from "../rebranded/modals/SendInviteModal";
// import HourlyIcon from "../rebranded/icons/HourlyPrice.vue";
// import CalendarIcon from "../rebranded/icons/CalendarIcon.vue";
// import FixedPrice from "../rebranded/icons/FixedPrice.vue";

// //SwiperClass.use([Pagination, Mousewheel, Navigation, Autoplay]);
// //Vue.use(getAwesomeSwiper(SwiperClass));
// //const { Swiper, SwiperSlide } = getAwesomeSwiper(SwiperClass);
// // import "swiper/swiper-bundle.min.css";
// // import "swiper/css/swiper.css";

// export default {
//   name: "ProjectDetail",
//   components: {
//     BottomMain,
//     PendingInvite,
//     ProjectInProgress,
//     IconStars,
//     FixedPrice,
//     HourlyIcon,
//     CalendarIcon,
//     Header,
//     Footer,
//     IconBase,
//     IconLike2,
//     IconLike4,
//     IconLike5,
//     IconLink,
//     IconShoppingCart,
//     IconPdf,
//     IconCancel,
//     IconArrowRight,
//     IconAngleRight2,
//     Swiper,
//     ArrowDown,
//     LinkRight,
//     SearchIcon,
//     IconAngleDown,
//     SendInviteModal,
//     SwiperSlide
//   },
//   data() {
//     return {
//       payment: null,
//       publicPath: local_image_path,
//       title: null,
//       type: null,
//       titles: {
//         "": "Proposal details",
//         "archived": "Archived Project",
//         "waiting": "Offer details",
//         "in-progress": "Name of the Project",
//         "completed": "Project Completed"
//       },
//       tab: "Proposals",
//       category: null,
//       categories: [
//         'Category'
//       ],
//       tabs: [
//         "Proposals",
//         "Search and invite",
//         "Pending Invites"
//       ],
//       selectedTag: [],
//       tags: [
//         'OBS Setup',
//         'Tech Support'
//       ],


//       isAuthenticated: window.isAuthenticated,
//       publicPath: local_image_path,
//       totalPages: 0,
//       is_already_voted: false,
//       logged_user_id : null,
//       isLoading: false,
//       projectData :'',
//       projectTags:[],
//       projectProducts:[],
//       projectImage:[],
//       projectPdf:[],
//       swiperOptionTop: {
//         slidesPerView: 1,
//         spaceBetween: 30,
//         // loop: true,
//         // loopedSlides: 3, // looped slides should be the same
//         navigation: {
//           nextEl: ".swiper-btn-next",
//           prevEl: ".swiper-btn-prev"
//         }
//       },
//       swiperOptionThumbs: {
//         // loop: true,
//         // loopedSlides: 3, // looped slides should be the same
//         spaceBetween: 20,
//         centeredSlides: true,
//         slidesPerView: "auto",
//         project_slug:null,

//         touchRatio: 0.2,
//         slideToClickedSlide: true,
//         breakpoints: {
//           320: {
//             spaceBetween: 10
//           },
//           576: {
//             spaceBetween: 20
//           }
//         }
//       },
//       swiperGallery: [
//         "/project-1-wide.jpg",
//         "/project-2-wide.jpg",
//         "/project-1-wide.jpg"
//       ],
//       bgimage: local_image_path + "single-job.jpg",
//       category_id:0,
//       projectRelated:[]
//     };
//   },
//   created() {
//     document.title = this.$route.meta.title;
//     this.project_slug = this.$route.params.slug;


//   },
//    mounted() {
//     this.$nextTick(() => {
//       const swiperTop = this.$refs.swiperTop.$swiper;
//       const swiperThumbs = this.$refs.swiperThumbs.$swiper;
//       console.log("nextTick");
//       console.log(swiperTop, swiperThumbs);
//       swiperTop.controller.control = swiperThumbs;
//       swiperThumbs.controller.control = swiperTop;
//     });
//     this.logged_user_id = localStorage.getItem("logged_user_id");
//     this.loadProjectData();
//   },
//   methods: {
//     // Contact modal form
//     showQuoteDialog() {
//       this.$modal.show("quote-modal-dialog");
//     },
//     hideQuoteDialog() {
//       this.$modal.hide("quote-modal-dialog");
//     },

//     async loadProjectData() {
//        this.isLoading= true
//       const result = await this.callApi(
//         'get',
//         window.api_path + 'project/' + this.project_slug + '/details/' + this.logged_user_id,
//         {}
//       );
//       if (result.status != 200) {
//          this.isLoading= false;
//         this.$toast.error(result.data.message);
//         this.projectData = null;
//         return;
//       }
//       this.isLoading= false;
//       this.projectData  = result.data.project;
//       this.category_id =  this.projectData.category_id;
//       this.projectImage = result.data.project_image;
//       this.projectPdf   = result.data.project_pdf;
//        console.log(this.projectImage);
// //       this.projectImage .forEach(function(images) {
// //         this.swiperGallery.push(projectImage.projectImagePropsArray.image_url);
// //     console.log(this.swiperGallery);
// // });

//      if (this.projectData) {
//        this.loadProjectTags(this.projectData.id);
//        this.loadProjectProduct(this.projectData.id);
//         this.loadRelatedProject(this.category_id);
//         console.log(this.projectTags);
//       }
//     },
//     async loadProjectTags(project_id) {
//       const result = await this.callApi(
//         'get',
//         window.api_path + 'project/' + project_id + '/getTags',
//         {}
//       );
//       if (result.status != 200) {
//         this.$toast.error(result.data.message);
//         this.projectTags = [];
//         return;
//       }

//       this.projectTags = result.data.projectTags;
//     },
//      async loadProjectProduct(project_id) {
//       const result = await this.callApi(
//         'get',
//         window.api_path + 'project/' + project_id + '/getProducts',
//         {}
//       );
//       if (result.status != 200) {
//         this.$toast.error(result.data.message);
//         this.projectProducts = [];
//         return;
//       }

//       console.log(result.data.projectProducts);

//       this.projectProducts = result.data.projectProducts;
//     },
//     async loadRelatedProject(category_id) {
//       const result = await this.callApi(
//         'post',
//         window.api_path + 'project/related',
//         {
//           category:category_id
//         }
//       );
//       if (result.status != 200) {
//         this.$toast.error(result.data.message);
//         this.projectRelated = [];
//         return;
//       }


//       this.projectRelated = result.data.projects;
//     },
//   },
//   directives: {
//     swiper: directive
//   },

// };
</script>
=======
<!--      <BottomMain />-->
<!--      <PendingInvite />-->
<!--      <ProjectInProgress />-->
<!--      <BuyerWaiting v-if="type === 'waiting-for-accept'"/>-->
<!--      <BuyerInProgress v-if="type === 'in-progress'"/>-->
<!--      <BuyerCompleted v-if="type === 'completed'"/>-->
<!--      <HireBottom v-if="type === 'hire'"/>-->
<!--    </div>-->
<!--    <Footer style="margin-top: 138px"/>-->
<!--  </div>-->
<!--</template>-->

<!--<script>-->
<!--import Vue from "vue";-->
<!--// import {-->
<!--//   Swiper as SwiperClass,-->
<!--//   Pagination,-->
<!--//   Navigation,-->
<!--//   Mousewheel,-->
<!--//   Autoplay-->
<!--// } from "swiper/swiper.esm";-->
<!--import getAwesomeSwiper from "vue-awesome-swiper/dist/exporter";-->
<!--import { Swiper, SwiperSlide, directive } from "vue-awesome-swiper";-->
<!--import "vue-loading-overlay/dist/vue-loading.css";-->

<!--import Header from "../common/Header.vue";-->
<!--import Footer from "../common/Footer.vue";-->
<!--import IconStars from "../common/icons/IconStars.vue";-->

<!--import IconBase from "../common/IconBase.vue";-->
<!--import IconLike2 from "../common/icons/IconLike2.vue";-->
<!--import IconLink from "../common/icons/IconLink.vue";-->
<!--import IconShoppingCart from "../common/icons/IconShoppingCart.vue";-->
<!--import IconPdf from "../common/icons/IconPdf.vue";-->
<!--import IconArrowRight from "../common/icons/IconArrowRight.vue";-->
<!--import IconAngleRight2 from "../common/icons/IconAngleRight2.vue";-->
<!--import IconCancel from "../common/icons/IconCancel.vue";-->
<!--import IconLike4 from "../common/icons/IconLike4.vue";-->
<!--import IconLike5 from "../common/icons/IconLike5.vue";-->

<!--import BottomMain from "../rebranded/bottom_components/BottomMain.vue";-->
<!--import PendingInvite from "../rebranded/bottom_components/PendingInvite.vue";-->
<!--import ProjectInProgress from "../rebranded/bottom_components/ProjectInProgress.vue";-->

<!--import ArrowDown from "../rebranded/icons/ArrowDown";-->
<!--import LinkRight from "../rebranded/icons/LinkRight";-->
<!--import SearchIcon from "../rebranded/icons/SearchIcon";-->
<!--import IconAngleDown from "./../common/icons/IconAngleDown.vue";-->
<!--import VueTagsInput from "@johmun/vue-tags-input";-->
<!--import vSelect from "vue-select";-->
<!--import SendInviteModal from "../rebranded/modals/SendInviteModal";-->
<!--import HourlyIcon from "../rebranded/icons/HourlyPrice.vue";-->
<!--import CalendarIcon from "../rebranded/icons/CalendarIcon.vue";-->
<!--import FixedPrice from "../rebranded/icons/FixedPrice.vue";-->

<!--SwiperClass.use([Pagination, Mousewheel, Navigation, Autoplay]);-->
<!--Vue.use(getAwesomeSwiper(SwiperClass));-->
<!--//const { Swiper, SwiperSlide } = getAwesomeSwiper(SwiperClass);-->
<!--// import "swiper/swiper-bundle.min.css";-->
<!--// import "swiper/css/swiper.css";-->

<!--export default {-->
<!--  name: "ProjectDetail",-->
<!--  components: {-->
<!--    BottomMain,-->
<!--    PendingInvite,-->
<!--    ProjectInProgress,-->
<!--    IconStars,-->
<!--    FixedPrice,-->
<!--    HourlyIcon,-->
<!--    CalendarIcon,-->
<!--    Header,-->
<!--    Footer,-->
<!--    IconBase,-->
<!--    IconLike2,-->
<!--    IconLike4,-->
<!--    IconLike5,-->
<!--    IconLink,-->
<!--    IconShoppingCart,-->
<!--    IconPdf,-->
<!--    IconCancel,-->
<!--    IconArrowRight,-->
<!--    IconAngleRight2,-->
<!--    Swiper,-->
<!--    ArrowDown,-->
<!--    LinkRight,-->
<!--    SearchIcon,-->
<!--    IconAngleDown,-->
<!--    SendInviteModal,-->
<!--    SwiperSlide-->
<!--  },-->
<!--  data() {-->
<!--    return {-->
<!--      payment: null,-->
<!--      publicPath: local_image_path,-->
<!--      title: null,-->
<!--      type: null,-->
<!--      titles: {-->
<!--        "": "Proposal details",-->
<!--        "archived": "Archived Project",-->
<!--        "waiting": "Offer details",-->
<!--        "in-progress": "Name of the Project",-->
<!--        "completed": "Project Completed"-->
<!--      },-->
<!--      tab: "Proposals",-->
<!--      category: null,-->
<!--      categories: [-->
<!--        'Category'-->
<!--      ],-->
<!--      tabs: [-->
<!--        "Proposals",-->
<!--        "Search and invite",-->
<!--        "Pending Invites"-->
<!--      ],-->
<!--      selectedTag: [],-->
<!--      tags: [-->
<!--        'OBS Setup',-->
<!--        'Tech Support'-->
<!--      ],-->


<!--      isAuthenticated: window.isAuthenticated,-->
<!--      publicPath: local_image_path,-->
<!--      totalPages: 0,-->
<!--      is_already_voted: false,-->
<!--      logged_user_id : null,-->
<!--      isLoading: false,-->
<!--      projectData :'',-->
<!--      projectTags:[],-->
<!--      projectProducts:[],-->
<!--      projectImage:[],-->
<!--      projectPdf:[],-->
<!--      swiperOptionTop: {-->
<!--        slidesPerView: 1,-->
<!--        spaceBetween: 30,-->
<!--        // loop: true,-->
<!--        // loopedSlides: 3, // looped slides should be the same-->
<!--        navigation: {-->
<!--          nextEl: ".swiper-btn-next",-->
<!--          prevEl: ".swiper-btn-prev"-->
<!--        }-->
<!--      },-->
<!--      swiperOptionThumbs: {-->
<!--        // loop: true,-->
<!--        // loopedSlides: 3, // looped slides should be the same-->
<!--        spaceBetween: 20,-->
<!--        centeredSlides: true,-->
<!--        slidesPerView: "auto",-->
<!--        project_slug:null,-->

<!--        touchRatio: 0.2,-->
<!--        slideToClickedSlide: true,-->
<!--        breakpoints: {-->
<!--          320: {-->
<!--            spaceBetween: 10-->
<!--          },-->
<!--          576: {-->
<!--            spaceBetween: 20-->
<!--          }-->
<!--        }-->
<!--      },-->
<!--      swiperGallery: [-->
<!--        "/project-1-wide.jpg",-->
<!--        "/project-2-wide.jpg",-->
<!--        "/project-1-wide.jpg"-->
<!--      ],-->
<!--      bgimage: local_image_path + "single-job.jpg",-->
<!--      category_id:0,-->
<!--      projectRelated:[]-->
<!--    };-->
<!--  },-->
<!--  created() {-->
<!--    document.title = this.$route.meta.title;-->
<!--    this.project_slug = this.$route.params.slug;-->


=======
<!--<template>-->
<!--   <div class="proposal-rebranded">-->
<!--    <Header />-->
<!--    <div class="container">-->
<!--      <h1 class="t-black t-36 w700" style="margin-top: 30px; margin-bottom: 10px">{{ title }}</h1>-->
<!--      <div class="project-info">-->
<!--        <div class="row">-->
<!--          <div class="col-5">-->
<!--            <h2 class="t-black w700 t-28" style="margin: 0">{{ projectData.name }}</h2>-->
<!--            <router-link to="" class="t-color1 t-24 w600 category-link" style="margin-top: 5.5px">{{projectData.category.title}}</router-link>-->
<!--            <p style="margin-top: 10px">{{ projectData.short_desc }}</p>-->
<!--            <div class="row mx-0">-->
<!--              <div v-if="projectData.type === 'hourly'" class="per-hour d-flex" style="margin-right: 25px">-->
<!--                <HourlyIcon :width="'30'" :height="'30'" style="margin-right: 11px" />-->
<!--                <p class="t-black w700 t-22 mb-0">${{ projectData.hourly_rate }}/hr</p>-->
<!--              </div>-->
<!--              <div v-if="projectData.type === 'hourly'" class="hours d-flex">-->
<!--                <CalendarIcon :width="'30'" :height="'30'" style="margin-right: 11px" />-->
<!--                <p class="t-black w700 t-22 mb-0">{{ projectData.weekly_limit }} hrs / week</p>-->
<!--              </div>-->
<!--              <div v-if="projectData.type === 'fixed'" class="hours d-flex">-->
<!--                <FixedPrice style="margin-right: 11px" />-->
<!--                <p class="t-black w700 t-22 mb-0">${{ projectData.estimated_budget }}</p>-->
<!--              </div>-->
<!--            </div>-->
<!--          </div>-->
<!--          <div class="col-7">-->
<!--            <div class="row w-100 d-flex justify-content-end align-items-end h-100">-->
<!--              <div class="user-info">-->
<!--                <div class="row align-items-center">-->
<!--                  <img :src="`${publicPath}user_info.png`" width="60px" height="60px" alt="">-->
<!--                  <router-link to="" class="w600 t-24 t-black my-0" style="margin-left: 12px">James K</router-link>-->
<!--                </div>-->
<!--                <div class="row" style="margin-top: 8.3px">-->
<!--                  <div class="reviews-summary-rating">-->
<!--                    <div class="rating-val-w">-->
<!--                      <div class="rating rating-lg">-->
<!--                        <div class="rating-current" style="width: 95%;">-->
<!--                          <icon-base-->
<!--                            width="68.01"-->
<!--                            height="11"-->
<!--                            view-box="0 0 68.01 10.57"-->
<!--                            icon-name="stars"-->
<!--                          >-->
<!--                            <icon-stars />-->
<!--                          </icon-base>-->
<!--                        </div>-->
<!--                        <div class="rating-total">-->
<!--                          <icon-base-->
<!--                            width="127"-->
<!--                            height="20.5"-->
<!--                            view-box="0 0 68.01 10.57"-->
<!--                            icon-name="stars"-->
<!--                          >-->
<!--                            <icon-stars />-->
<!--                          </icon-base>-->
<!--                        </div>-->
<!--                      </div>-->
<!--                    </div>-->
<!--                  </div>-->
<!--                  <p class="t-24 w500 t-black" style="line-height: 24px; margin-left: 15.14px">4.7</p>-->
<!--                </div>-->
<!--                <div class="row">-->
<!--                  <p class="w500 t-black t-16 mb-0">United States</p>-->
<!--                  <p class="w500 t-black t-16 mb-0">10 projects posted, 6 hires</p>-->
<!--                  <p class="w500 t-black t-16 mb-0">$1000 total spent</p>-->
<!--                </div>-->
<!--              </div>-->
<!--            </div>-->
<!--          </div>-->
<!--        </div>-->
<!--      </div>-->
<!--      <div class="project-gallery" style="margin-top: 13px;">-->
<!--        <div class="project-gallery-top">-->
<!--          <swiper class="swiper" :options="swiperOptionTop" ref="swiperTop">-->

<!--            <swiper-slide-->
<!--              :key="index"-->
<!--              v-for="(imgpath, index) in projectImage"-->
<!--            ><img :src="imgpath.projectImagePropsArray.image_url"-->
<!--            /></swiper-slide>-->
<!--            <swiper-slide>-->
<!--              <iframe width="100%" :src="projectData.link_youtube" frameborder="0"></iframe>-->
<!--            </swiper-slide>-->
<!--            <div class="swiper-btn-prev" slot="button-prev">-->
<!--              <icon-base-->
<!--                width="16.54"-->
<!--                height="28"-->
<!--                view-box="0 0 16.54 28"-->
<!--                icon-name="angle-right-2"-->
<!--              >-->
<!--                <icon-angle-right-2 />-->
<!--              </icon-base>-->
<!--            </div>-->
<!--            <div class="swiper-btn-next" slot="button-next">-->
<!--              <icon-base-->
<!--                width="16.54"-->
<!--                height="28"-->
<!--                view-box="0 0 16.54 28"-->
<!--                icon-name="angle-right-2"-->
<!--              >-->
<!--                <icon-angle-right-2 />-->
<!--              </icon-base>-->
<!--            </div>-->
<!--          </swiper>-->
<!--        </div>-->
<!--        <div class="project-gallery-thumbs">-->
<!--          <swiper-->
<!--            class="swiper gallery-thumbs"-->
<!--            :options="swiperOptionThumbs"-->
<!--            ref="swiperThumbs"-->
<!--          >-->

<!--            <swiper-slide-->
<!--              :key="index"-->
<!--             v-for="(imgpath, index) in projectImage"-->
<!--            ><img :src="imgpath.projectImagePropsArray.image_url"-->
<!--            /></swiper-slide>-->
<!--             <swiper-slide>-->
<!--              <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ2Jv2IZWtzbA6YC6m_mdZwr1NiLag34ebipQ&usqp=CAU" alt="">-->
<!--            </swiper-slide>-->
<!--          </swiper>-->
<!--        </div>-->
<!--      </div>-->
<!--      <div class="row equipments">-->
<!--        <h2 class="w700 t-24 t-black roboto">Equipments</h2>-->
<!--        <table class="table table-align-middle">-->
<!--          <thead>-->
<!--          <tr>-->
<!--            <th scope="col" class="text-center">#</th>-->
<!--            <th scope="col" class="th-product-name">Product name</th>-->
<!--            <th scope="col">Description</th>-->
<!--            <th scope="col" class="text-center">Manufacturer</th>-->
<!--            <th scope="col" class="text-center">Price</th>-->
<!--            <th scope="col" class="text-center">Shop</th>-->
<!--          </tr>-->
<!--          </thead>-->
<!--          <tbody>-->
<!--          <tr v-for="(project,key) in projectProducts" :key="key">-->
<!--            <td class="text-center">{{ key+1 }}</td>-->
<!--            <td>-->
<!--              <div class="d-flex align-items-center">-->
<!--                <img-->
<!--                  :src="`${publicPath}camera_360.png`"-->
<!--                  alt=""-->
<!--                  class="rounded-circle width-32 mr-2"-->
<!--                />-->
<!--                <div class="text-nowrap flex-grow-1">{{ project.product.name.substring(0, 20) }}</div>-->
<!--              </div>-->
<!--            </td>-->
<!--            <td>-->
<!--              {{ project.product.desc.substring(0, 50) }}-->
<!--            </td>-->
<!--            <td class="text-center">-->
<!--              {{ project.product.manufacturer.substring(0, 50) }}-->
<!--            </td>-->
<!--            <td class="text-center">{{ project.product.price }}</td>-->
<!--            <td class="text-center">-->
<!--              <a target="_blank" v-bind:href="project.product.link" class="btn btn-xs btn-link">-->
<!--                <icon-base-->
<!--                  width="20"-->
<!--                  height="17.58"-->
<!--                  view-box="0 0 20 17.58"-->
<!--                  icon-name="shopping-cart"-->
<!--                >-->
<!--                  <icon-shopping-cart />-->
<!--                </icon-base>-->
<!--              </a>-->
<!--            </td>-->
<!--          </tr>-->

<!--          </tbody>-->
<!--        </table>-->
<!--      </div>-->
<!--      <div class="row project-description">-->
<!--        <h2 class="w700 t-24 t-black roboto" style="margin-bottom: 9.5px">Project Description</h2>-->
<!--        <div class="paragraph">-->
<!--          {{projectData.desc}}-->
<!--        </div>-->

<!--      </div>-->
<!--      <div class="row docs">-->
<!--        <div class="col-6">-->
<!--          <h2 class="t-24 t-black w700 roboto mb-0">Documents</h2>-->
<!--          <div class="row mx-0">-->
<!--            <div class="doc" v-for="(pdf,key) in projectPdf" :key="key">-->
<!--              <a target="_blank" v-bind:href="pdf.projectPdfPropsArray.image_url">-->
<!--                <div class="doc-icon">-->
<!--                  <img :src="`${publicPath}pdf_icon.png`" alt="">-->
<!--                </div>-->
<!--                <p class="t-12 doc-link" style="margin-top: 12px; color: rgba(0, 0, 0, 0.3)">{{ pdf.info }}</p>-->
<!--              </a>-->
<!--            </div>-->
<!--          </div>-->
<!--        </div>-->
<!--        <div class="col-6">-->
<!--          <h2 class="t-24 t-black w700 roboto mb-0">Website Link</h2>-->
<!--          <a href="#" class="w400 t-16 website-link" style="color: rgba(0, 0, 0, 0.8)">{{projectData.link_url }}</a>-->
<!--        </div>-->
<!--      </div>-->
<!--      <div class="row tags">-->
<!--        <h2 class="t-24 w700 text-black roboto" style="margin-bottom: 8px">Tags</h2>-->
<!--        <div class="col-12">-->
<!--          <div class="row">-->
<!--            <button class="tag" v-for="(tag,key) in projectTags" :key="key">-->
<!--              {{ tag.tag.title }}-->
<!--            </button>-->
<!--          </div>-->
<!--        </div>-->
<!--      </div>-->
<!--<section class="section-project">-->
<!--      <div class="project-author-b">-->
<!--            <div class="userpic">-->
<!--              <router-link to="/projects/2">-->
<!--                <img-->
<!--                  class="rounded-circle"-->
<!--                  :src="`${publicPath}userpic-60.jpg`"-->
<!--                  alt=""-->
<!--                />-->
<!--              </router-link>-->
<!--            </div>-->
<!--            <div class="author-info">-->
<!--              <div class="username">-->
<!--                <router-link to="">-->
<!--                  James K-->
<!--                </router-link>-->
<!--              </div>-->
<!--              <div class="author-desc">-->
<!--                Have you ever seen stars below the sky, on the earth? Yes, the-->
<!--                spark of light emerging from the land. On a cold night, standing-->
<!--                on a peak of the mountain, when you look down at the place.-->
<!--              </div>-->
<!--            </div>-->
<!--          </div>-->
<!--</section>-->

<!--&lt;!&ndash; Comments &ndash;&gt;-->
<!--        <section class="project-comments">-->
<!--          <h2 class="comments-h">Comments</h2>-->

<!--          <div class="comments-list"></div>-->

<!--          <div class="comments-form">-->
<!--            <div class="form-group">-->
<!--              <label>Leave a comment</label>-->
<!--              <textarea-->
<!--                name=""-->
<!--                rows="5"-->
<!--                class="form-control"-->
<!--                placeholder="Post your comment here"-->
<!--              ></textarea>-->
<!--            </div>-->
<!--            <button type="submit" class="btn btn-primary">Post</button>-->
<!--          </div>-->
<!--        </section>-->
<!--        &lt;!&ndash; End of Comments &ndash;&gt;-->

<!--        <div class="project-quote">-->
<!--          &lt;!&ndash; Send Quote Modal &ndash;&gt;-->
<!--          <button class="btn btn-secondary" @click="showQuoteDialog">-->
<!--            Send a Quote-->
<!--          </button>-->

<!--          <modal-->
<!--            name="quote-modal-dialog"-->
<!--            :width="1160"-->
<!--            height="auto"-->
<!--            :scrollable="true"-->
<!--            :adaptive="true"-->
<!--            transition=""-->
<!--            class="section-modal section-modal-quote"-->
<!--          >-->
<!--            <div class="modal-close" @click="hideQuoteDialog">-->
<!--              <icon-base-->
<!--                width="21"-->
<!--                height="21"-->
<!--                viewBox="0 0 7 7"-->
<!--                icon-name="cancel"-->
<!--                ><icon-cancel-->
<!--              /></icon-base>-->
<!--            </div>-->
<!--            <h2 class="h1">Send a Quote</h2>-->
<!--            <div class="form-group">-->
<!--              <textarea-->
<!--                rows="14"-->
<!--                class="form-control"-->
<!--                placeholder="Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua."-->
<!--              ></textarea>-->
<!--            </div>-->
<!--            <div-->
<!--              class="form-row align-items-center justify-content-end budget-row"-->
<!--            >-->
<!--              <div class="col-auto">-->
<!--                <label>Budget:</label>-->
<!--              </div>-->
<!--              <div class="col-auto">-->
<!--                <input type="text" class="form-control form-control" />-->
<!--              </div>-->
<!--            </div>-->
<!--            <div class="btns">-->
<!--              <button class="btn btn-primary ml-auto">Send</button>-->
<!--            </div>-->
<!--          </modal>-->
<!--          &lt;!&ndash; End of Send Quote Modal &ndash;&gt;-->
<!--        </div>-->

<!--        &lt;!&ndash; Other Projects &ndash;&gt;-->
<!--        <section class="section-similar">-->
<!--          <h2 class="h1">Related Projects</h2>-->

<!--          <div class="row">-->
<!--            <div  v-for="project_related in projectRelated"-->
<!--              :key="project_related.id" class="col-lg-3 col-sm-6 col-xs-12">-->
<!--              <div class="card card-project">-->
<!--                <div class="card-img-top">-->
<!--                  <router-link :to="{-->
<!--                      name: 'projectDetail',-->
<!--                      params: { slug: project_related.slug }-->
<!--                    }">-->
<!--                    <img :src="`${publicPath}no-image.jpg`" alt="" />-->
<!--                    <span-->
<!--                      class="is-featured"-->
<!--                      :style="{-->
<!--                        backgroundImage: `url(${publicPath}featured-bg.png)`-->
<!--                      }"-->
<!--                      >Featured</span-->
<!--                    >-->
<!--                  </router-link>-->
<!--                </div>-->
<!--                <div class="card-body">-->
<!--                  <div class="card-title-vote">-->
<!--                    <div class="card-title">-->
<!--                      <router-link :to="{-->
<!--                      name: 'projectDetail',-->
<!--                      params: { slug: project_related.slug }-->
<!--                    }">-->
<!--                        {{project_related.name}}-->
<!--                      </router-link>-->
<!--                    </div>-->
<!--                    <button class="btn btn-link btn-icon btn-vote">-->
<!--                      <icon-base-->
<!--                        width="18"-->
<!--                        height="17.25"-->
<!--                        view-box="0 0 18 17.25"-->
<!--                        icon-name="like-4"-->
<!--                      >-->
<!--                        <icon-like-4 />-->
<!--                      </icon-base>-->
<!--                    </button>-->
<!--                  </div>-->
<!--                  <div class="card-category">-->
<!--                    <div class="label">-->
<!--                      <router-link to="/">   {{project_related.category.title}}</router-link>-->
<!--                    </div>-->
<!--                  </div>-->

<!--                  <p class="card-text">-->
<!--                   {{project_related.desc.substring(0, 120)}}-->
<!--                  </p>-->

<!--                  <div class="card-price-more">-->
<!--                    <div class="more">-->
<!--                      <router-link :to="{-->
<!--                      name: 'projectDetail',-->
<!--                      params: { slug: project_related.slug }-->
<!--                    }" class="btn btn-link btn-icon">-->
<!--                        <span>Learn More</span>-->
<!--                        <icon-base-->
<!--                          width="18"-->
<!--                          height="8.72"-->
<!--                          view-box="0 0 18 8.72"-->
<!--                          icon-name="arrow-right"-->
<!--                        >-->
<!--                          <icon-arrow-right />-->
<!--                        </icon-base>-->
<!--                      </router-link>-->
<!--                    </div>-->
<!--                    <div class="projectby">-->
<!--                      <span>Project by</span>-->
<!--                      <router-link to="/projects/2">-->
<!--                        <img-->
<!--                          :src="`${publicPath}user-avatar-sm.jpg`"-->
<!--                          alt=""-->
<!--                          class="rounded-circle"-->
<!--                        />-->
<!--                      </router-link>-->
<!--                    </div>-->
<!--                  </div>-->
<!--                </div>-->
<!--              </div>-->
<!--            </div>-->

<!--          </div>-->
<!--        </section>-->
<!--        &lt;!&ndash; End of Other Projects &ndash;&gt;-->


<!--      <BottomMain />-->
<!--      <PendingInvite />-->
<!--      <ProjectInProgress />-->
<!--      <BuyerWaiting v-if="type === 'waiting-for-accept'"/>-->
<!--      <BuyerInProgress v-if="type === 'in-progress'"/>-->
<!--      <BuyerCompleted v-if="type === 'completed'"/>-->
<!--      <HireBottom v-if="type === 'hire'"/>-->
<!--    </div>-->
<!--    <Footer style="margin-top: 138px"/>-->
<!--  </div>-->
<!--</template>-->

<!--<script>-->
<!--import Vue from "vue";-->
<!--// import {-->
<!--//   Swiper as SwiperClass,-->
<!--//   Pagination,-->
<!--//   Navigation,-->
<!--//   Mousewheel,-->
<!--//   Autoplay-->
<!--// } from "swiper/swiper.esm";-->
<!--import getAwesomeSwiper from "vue-awesome-swiper/dist/exporter";-->
<!--import { Swiper, SwiperSlide, directive } from "vue-awesome-swiper";-->
<!--import "vue-loading-overlay/dist/vue-loading.css";-->

<!--import Header from "../common/Header.vue";-->
<!--import Footer from "../common/Footer.vue";-->
<!--import IconStars from "../common/icons/IconStars.vue";-->

<!--import IconBase from "../common/IconBase.vue";-->
<!--import IconLike2 from "../common/icons/IconLike2.vue";-->
<!--import IconLink from "../common/icons/IconLink.vue";-->
<!--import IconShoppingCart from "../common/icons/IconShoppingCart.vue";-->
<!--import IconPdf from "../common/icons/IconPdf.vue";-->
<!--import IconArrowRight from "../common/icons/IconArrowRight.vue";-->
<!--import IconAngleRight2 from "../common/icons/IconAngleRight2.vue";-->
<!--import IconCancel from "../common/icons/IconCancel.vue";-->
<!--import IconLike4 from "../common/icons/IconLike4.vue";-->
<!--import IconLike5 from "../common/icons/IconLike5.vue";-->

<!--import BottomMain from "../rebranded/bottom_components/BottomMain.vue";-->
<!--import PendingInvite from "../rebranded/bottom_components/PendingInvite.vue";-->
<!--import ProjectInProgress from "../rebranded/bottom_components/ProjectInProgress.vue";-->

<!--import ArrowDown from "../rebranded/icons/ArrowDown";-->
<!--import LinkRight from "../rebranded/icons/LinkRight";-->
<!--import SearchIcon from "../rebranded/icons/SearchIcon";-->
<!--import IconAngleDown from "./../common/icons/IconAngleDown.vue";-->
<!--import VueTagsInput from "@johmun/vue-tags-input";-->
<!--import vSelect from "vue-select";-->
<!--import SendInviteModal from "../rebranded/modals/SendInviteModal";-->
<!--import HourlyIcon from "../rebranded/icons/HourlyPrice.vue";-->
<!--import CalendarIcon from "../rebranded/icons/CalendarIcon.vue";-->
<!--import FixedPrice from "../rebranded/icons/FixedPrice.vue";-->

<!--SwiperClass.use([Pagination, Mousewheel, Navigation, Autoplay]);-->
<!--Vue.use(getAwesomeSwiper(SwiperClass));-->
<!--//const { Swiper, SwiperSlide } = getAwesomeSwiper(SwiperClass);-->
<!--// import "swiper/swiper-bundle.min.css";-->
<!--// import "swiper/css/swiper.css";-->

<!--export default {-->
<!--  name: "ProjectDetail",-->
<!--  components: {-->
<!--    BottomMain,-->
<!--    PendingInvite,-->
<!--    ProjectInProgress,-->
<!--    IconStars,-->
<!--    FixedPrice,-->
<!--    HourlyIcon,-->
<!--    CalendarIcon,-->
<!--    Header,-->
<!--    Footer,-->
<!--    IconBase,-->
<!--    IconLike2,-->
<!--    IconLike4,-->
<!--    IconLike5,-->
<!--    IconLink,-->
<!--    IconShoppingCart,-->
<!--    IconPdf,-->
<!--    IconCancel,-->
<!--    IconArrowRight,-->
<!--    IconAngleRight2,-->
<!--    Swiper,-->
<!--    ArrowDown,-->
<!--    LinkRight,-->
<!--    SearchIcon,-->
<!--    IconAngleDown,-->
<!--    SendInviteModal,-->
<!--    SwiperSlide-->
<!--  },-->
<!--  data() {-->
<!--    return {-->
<!--      payment: null,-->
<!--      publicPath: local_image_path,-->
<!--      title: null,-->
<!--      type: null,-->
<!--      titles: {-->
<!--        "": "Proposal details",-->
<!--        "archived": "Archived Project",-->
<!--        "waiting": "Offer details",-->
<!--        "in-progress": "Name of the Project",-->
<!--        "completed": "Project Completed"-->
<!--      },-->
<!--      tab: "Proposals",-->
<!--      category: null,-->
<!--      categories: [-->
<!--        'Category'-->
<!--      ],-->
<!--      tabs: [-->
<!--        "Proposals",-->
<!--        "Search and invite",-->
<!--        "Pending Invites"-->
<!--      ],-->
<!--      selectedTag: [],-->
<!--      tags: [-->
<!--        'OBS Setup',-->
<!--        'Tech Support'-->
<!--      ],-->


<!--      isAuthenticated: window.isAuthenticated,-->
<!--      publicPath: local_image_path,-->
<!--      totalPages: 0,-->
<!--      is_already_voted: false,-->
<!--      logged_user_id : null,-->
<!--      isLoading: false,-->
<!--      projectData :'',-->
<!--      projectTags:[],-->
<!--      projectProducts:[],-->
<!--      projectImage:[],-->
<!--      projectPdf:[],-->
<!--      swiperOptionTop: {-->
<!--        slidesPerView: 1,-->
<!--        spaceBetween: 30,-->
<!--        // loop: true,-->
<!--        // loopedSlides: 3, // looped slides should be the same-->
<!--        navigation: {-->
<!--          nextEl: ".swiper-btn-next",-->
<!--          prevEl: ".swiper-btn-prev"-->
<!--        }-->
<!--      },-->
<!--      swiperOptionThumbs: {-->
<!--        // loop: true,-->
<!--        // loopedSlides: 3, // looped slides should be the same-->
<!--        spaceBetween: 20,-->
<!--        centeredSlides: true,-->
<!--        slidesPerView: "auto",-->
<!--        project_slug:null,-->

<!--        touchRatio: 0.2,-->
<!--        slideToClickedSlide: true,-->
<!--        breakpoints: {-->
<!--          320: {-->
<!--            spaceBetween: 10-->
<!--          },-->
<!--          576: {-->
<!--            spaceBetween: 20-->
<!--          }-->
<!--        }-->
<!--      },-->
<!--      swiperGallery: [-->
<!--        "/project-1-wide.jpg",-->
<!--        "/project-2-wide.jpg",-->
<!--        "/project-1-wide.jpg"-->
<!--      ],-->
<!--      bgimage: local_image_path + "single-job.jpg",-->
<!--      category_id:0,-->
<!--      projectRelated:[]-->
<!--    };-->
<!--  },-->
<!--  created() {-->
<!--    document.title = this.$route.meta.title;-->
<!--    this.project_slug = this.$route.params.slug;-->


>>>>>>> feature/new_frontend_changes
<!--  },-->
<!--   mounted() {-->
<!--    this.$nextTick(() => {-->
<!--      const swiperTop = this.$refs.swiperTop.$swiper;-->
<!--      const swiperThumbs = this.$refs.swiperThumbs.$swiper;-->
<!--      console.log("nextTick");-->
<!--      console.log(swiperTop, swiperThumbs);-->
<!--      swiperTop.controller.control = swiperThumbs;-->
<!--      swiperThumbs.controller.control = swiperTop;-->
<!--    });-->
<!--    this.logged_user_id = localStorage.getItem("logged_user_id");-->
<!--    this.loadProjectData();-->
<!--  },-->
<!--  methods: {-->
<!--    // Contact modal form-->
<!--    showQuoteDialog() {-->
<!--      this.$modal.show("quote-modal-dialog");-->
<!--    },-->
<!--    hideQuoteDialog() {-->
<!--      this.$modal.hide("quote-modal-dialog");-->
<!--    },-->

<!--    async loadProjectData() {-->
<!--       this.isLoading= true-->
<!--      const result = await this.callApi(-->
<!--        'get',-->
<!--        window.api_path + 'project/' + this.project_slug + '/details/' + this.logged_user_id,-->
<!--        {}-->
<!--      );-->
<!--      if (result.status != 200) {-->
<!--         this.isLoading= false;-->
<!--        this.$toast.error(result.data.message);-->
<!--        this.projectData = null;-->
<!--        return;-->
<!--      }-->
<!--      this.isLoading= false;-->
<!--      this.projectData  = result.data.project;-->
<!--      this.category_id =  this.projectData.category_id;-->
<!--      this.projectImage = result.data.project_image;-->
<!--      this.projectPdf   = result.data.project_pdf;-->
<!--       console.log(this.projectImage);-->
<!--//       this.projectImage .forEach(function(images) {-->
<!--//         this.swiperGallery.push(projectImage.projectImagePropsArray.image_url);-->
<!--//     console.log(this.swiperGallery);-->
<!--// });-->

<!--     if (this.projectData) {-->
<!--       this.loadProjectTags(this.projectData.id);-->
<!--       this.loadProjectProduct(this.projectData.id);-->
<!--        this.loadRelatedProject(this.category_id);-->
<!--        console.log(this.projectTags);-->
<!--      }-->
<!--    },-->
<!--    async loadProjectTags(project_id) {-->
<!--      const result = await this.callApi(-->
<!--        'get',-->
<!--        window.api_path + 'project/' + project_id + '/getTags',-->
<!--        {}-->
<!--      );-->
<!--      if (result.status != 200) {-->
<!--        this.$toast.error(result.data.message);-->
<!--        this.projectTags = [];-->
<!--        return;-->
<!--      }-->

<!--      this.projectTags = result.data.projectTags;-->
<!--    },-->
<!--     async loadProjectProduct(project_id) {-->
<!--      const result = await this.callApi(-->
<!--        'get',-->
<!--        window.api_path + 'project/' + project_id + '/getProducts',-->
<!--        {}-->
<!--      );-->
<!--      if (result.status != 200) {-->
<!--        this.$toast.error(result.data.message);-->
<!--        this.projectProducts = [];-->
<!--        return;-->
<!--      }-->

<!--      console.log(result.data.projectProducts);-->

<!--      this.projectProducts = result.data.projectProducts;-->
<!--    },-->
<!--    async loadRelatedProject(category_id) {-->
<!--      const result = await this.callApi(-->
<!--        'post',-->
<!--        window.api_path + 'project/related',-->
<!--        {-->
<!--          category:category_id-->
<!--        }-->
<!--      );-->
<!--      if (result.status != 200) {-->
<!--        this.$toast.error(result.data.message);-->
<!--        this.projectRelated = [];-->
<!--        return;-->
<!--      }-->


<!--      this.projectRelated = result.data.projects;-->
<!--    },-->
<!--  },-->
<!--  directives: {-->
<!--    swiper: directive-->
<!--  },-->

<!--};-->
<!--</script>-->
<<<<<<< HEAD
>>>>>>> d30bfe5610f50aa47d93c0298998293040cf86ea
=======
>>>>>>> feature/new_frontend_changes
