<template>
  <div>
    <Header />

    <main class="main">
      <!-- Buyer Page -->
      <section class="section-buyer">
        <div class="container">
          <div class="buyer-row">
            <div class="buyer-col-l">
              <!-- Buyer Info -->
              <section class="section-buyer-info">
                <div class="btn btn-sm btn-status btn-status-active">
                  Active Status
                </div>
                <div class="userpic">
                  <img
                    :src="`${publicPath}userpic-100.jpg`"
                    class="rounded-circle"
                    alt=""
                  />
                </div>
                <div class="username">Buyer Name Here</div>
                <div class="subtitle">Lorem ispam</div>
                <div class="buyer-info">
                  <div class="buyer-info-h">
                    <div class="label">About:</div>
                    <div class="buyer-rating">5.0 (Review)</div>
                  </div>
                  <div class="text">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                    Maecenas tellus senectus sit interdum tellus. Fermentum
                    arcu, proin morbi neque aenean sed malesuada.
                  </div>
                  <div class="more">
                    <router-link :to="{}">Learn more...</router-link>
                  </div>
                </div>
              </section>
              <!-- End of Buyer Card -->

              <!-- Buyer Conversation -->
              <section class="section-buyer-conversation">
                <div class="buyer-conversation-h">
                  <h2>Recent conversation</h2>
                </div>
                <div class="conversation-list">
                  <div class="citem">
                    <div class="userpic">
                      <img
                        :src="`${publicPath}userpic-56.jpg`"
                        class="rounded-circle"
                        alt=""
                      />
                      <div class="status status-on"></div>
                    </div>
                    <div class="citem-c">
                      <div class="username">Moin Haikal</div>
                      <div class="text-w is-comment">
                        <span class="text">Good Morning Orenba,</span>
                        <span class="comments"
                          ><span class="num">1</span>
                          <icon-base
                            width="17"
                            height="16"
                            view-box="0 0 16.87 15.53"
                            icon-name="comment"
                          >
                            <icon-comment /> </icon-base
                        ></span>
                      </div>
                    </div>
                    <div class="citem-r">
                      <icon-base
                        width="9"
                        height="9"
                        view-box="0 0 9 9"
                        icon-name="clock"
                      >
                        <icon-clock />
                      </icon-base>
                      <div class="ago">2 m</div>
                      <icon-base
                        width="14"
                        height="13.42"
                        view-box="0 0 11 10.54"
                        icon-name="star"
                      >
                        <icon-star />
                      </icon-base>
                    </div>
                  </div>
                  <div class="citem">
                    <div class="userpic">
                      <img
                        :src="`${publicPath}userpic-56.jpg`"
                        class="rounded-circle"
                        alt=""
                      />
                      <div class="status status-on"></div>
                    </div>
                    <div class="citem-c">
                      <div class="username">Moin Haikal</div>
                      <div class="text-w">
                        <span class="text"
                          >Lorem ipsum dolor, sit amet consectetur adipisicing
                          elit.</span
                        >
                      </div>
                    </div>
                    <div class="citem-r">
                      <icon-base
                        width="9"
                        height="9"
                        view-box="0 0 9 9"
                        icon-name="clock"
                      >
                        <icon-clock />
                      </icon-base>
                      <div class="ago">2 m</div>
                      <icon-base
                        width="14"
                        height="13.42"
                        view-box="0 0 11 10.54"
                        icon-name="star"
                      >
                        <icon-star />
                      </icon-base>
                    </div>
                  </div>
                  <div class="citem">
                    <div class="userpic">
                      <img
                        :src="`${publicPath}userpic-56.jpg`"
                        class="rounded-circle"
                        alt=""
                      />
                      <div class="status status-off"></div>
                    </div>
                    <div class="citem-c">
                      <div class="username">John Doe</div>
                      <div class="text-w is-comment">
                        <span class="text"
                          >Lorem ipsum dolor, sit amet consectetur adipisicing
                          elit.</span
                        >
                        <span class="comments"
                          ><span class="num">1</span>
                          <icon-base
                            width="17"
                            height="16"
                            view-box="0 0 16.87 15.53"
                            icon-name="comment"
                          >
                            <icon-comment /> </icon-base
                        ></span>
                      </div>
                    </div>
                    <div class="citem-r">
                      <div class="ago">1 Week</div>
                    </div>
                  </div>
                </div>
              </section>
              <!-- End of Buyer Conversation -->
            </div>
            <div class="buyer-col-r">
              <!-- Buyer Orders -->
              <section class="section-buyer-orders">
                <div class="buyer-orders-top">
                  <ul class="nav nav-otabs">
                    <li
                      class="nav-link"
                      :class="orderTab == 1 ? 'active' : ''"
                      @click="orderTab = 1"
                    >
                      All
                    </li>
                    <li
                      class="nav-link"
                      :class="orderTab == 2 ? 'active' : ''"
                      @click="orderTab = 2"
                    >
                      Active Order
                    </li>
                    <li
                      class="nav-link"
                      :class="orderTab == 3 ? 'active' : ''"
                      @click="orderTab = 3"
                    >
                      Pending Orders
                    </li>
                    <li
                      class="nav-link"
                      :class="orderTab == 4 ? 'active' : ''"
                      @click="orderTab = 4"
                    >
                      Complete Orders
                    </li>
                    <li
                      class="nav-link"
                      :class="orderTab == 5 ? 'active' : ''"
                      @click="orderTab = 5"
                    >
                      Cancelled order
                    </li>
                  </ul>
                  <v-select
                    v-model="orderBy"
                    label="label"
                    code="code"
                    item-text="label"
                    :options="orderByList"
                    :clearable="false"
                    :searchable="false"
                    placeholder="All Order"
                    class=""
                    ><template #open-indicator="{ attributes }">
                      <span v-bind="attributes">
                        <icon-base
                          width="14.42"
                          height="10.5"
                          view-box="0 0 14.42 10.5"
                          icon-name="triangle-3"
                        >
                          <icon-triangle-3 />
                        </icon-base>
                      </span> </template
                  ></v-select>
                </div>

                <div class="tabs-content">
                  <!-- Tab 1 -->
                  <div class="tab-content" v-if="orderTab == 1">
                    <div class="order-card-list">
                      <div class="ocard">
                        <div class="ocard-content">
                          <div class="ocard-img">
                            <img
                              :src="`${publicPath}order-152.jpg`"
                              class="rounded"
                              alt=""
                            />
                          </div>
                          <div class="ocard-userpic">
                            <img
                              :src="`${publicPath}userpic-66.jpg`"
                              class="rounded-circle"
                              alt=""
                            />
                            <div class="status status-on"></div>
                          </div>
                          <div class="ocard-info ocard-info-1">
                            <div class="ocard-info-t">John Doe</div>
                            <div class="ocard-info-b">View Order</div>
                          </div>
                          <div class="ocard-info ocard-info-2">
                            <div class="ocard-info-t">Price</div>
                            <div class="ocard-info-b">$342</div>
                          </div>
                          <div class="ocard-info ocard-info-3">
                            <div class="ocard-info-t">Delivery Time</div>
                            <div class="ocard-info-b">
                              <icon-base
                                width="9"
                                height="9"
                                view-box="0 0 9 9"
                                icon-name="clock"
                              >
                                <icon-clock />
                              </icon-base>
                              <span>2 days Late</span>
                            </div>
                          </div>
                        </div>
                        <div class="ocard-b">
                          <div class="ocard-b-l">
                            <a href="">Cancel</a>
                            <p class="text-muted m-0 ">
                              You re Running late. Deliver Now to avoid negetive
                              rating.
                            </p>
                          </div>
                          <div class="ocard-b-r">
                            <router-link to="{}" class="btn btn-secondary"
                              >View Order</router-link
                            >
                          </div>
                        </div>
                      </div>
                      <div class="ocard">
                        <div class="ocard-content">
                          <div class="ocard-img">
                            <img
                              :src="`${publicPath}order-152.jpg`"
                              class="rounded"
                              alt=""
                            />
                          </div>
                          <div class="ocard-userpic">
                            <img
                              :src="`${publicPath}userpic-66.jpg`"
                              class="rounded-circle"
                              alt=""
                            />
                            <div class="status status-on"></div>
                          </div>
                          <div class="ocard-info ocard-info-1">
                            <div class="ocard-info-t">John Doe</div>
                            <div class="ocard-info-b">View Order</div>
                          </div>
                          <div class="ocard-info ocard-info-2">
                            <div class="ocard-info-t">Price</div>
                            <div class="ocard-info-b">$342</div>
                          </div>
                          <div class="ocard-info ocard-info-3">
                            <div class="ocard-info-t">Delivery Time</div>
                            <div class="ocard-info-b">
                              <icon-base
                                width="9"
                                height="9"
                                view-box="0 0 9 9"
                                icon-name="clock"
                              >
                                <icon-clock />
                              </icon-base>
                              <span>2 days Late</span>
                            </div>
                          </div>
                        </div>
                        <div class="ocard-b">
                          <div class="ocard-b-l">
                            <a href="">Cancel</a>
                            <p class="text-muted m-0">
                              You re Running late. Deliver Now to avoid negetive
                              rating.
                            </p>
                          </div>
                          <div class="ocard-b-r">
                            <router-link to="{}" class="btn btn-secondary"
                              >View Order</router-link
                            >
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- End of Tab 1 -->
                  <!-- Tab 2 -->
                  <div class="tab-content" v-if="orderTab == 2">Tab 2</div>
                  <!-- End of Tab 2 -->
                  <!-- Tab 3 -->
                  <div class="tab-content" v-if="orderTab == 3">Tab 3</div>
                  <!-- End of Tab 3 -->
                  <!-- Tab 4 -->
                  <div class="tab-content" v-if="orderTab == 4">Tab 4</div>
                  <!-- End of Tab 4 -->
                  <!-- Tab 5 -->
                  <div class="tab-content" v-if="orderTab == 5">Tab 5</div>
                  <!-- End of Tab 5 -->
                </div>
              </section>
              <!-- End of Orders -->
            </div>
          </div>
        </div>
      </section>
      <!-- End of Buyer Page -->
    </main>

    <Footer />
  </div>
</template>

<script>
import Header from "./common/Header.vue";
import Footer from "./common/Footer.vue";
import IconBase from "./common/IconBase.vue";
import IconComment from "./common/icons/IconComment.vue";
import IconClock from "./common/icons/IconClock.vue";
import IconStar from "./common/icons/IconStar.vue";
import IconTriangle3 from "./common/icons/IconTriangle3.vue";

export default {
  name: "Buyer",
  components: {
    Header,
    Footer,
    IconBase,
    IconComment,
    IconClock,
    IconStar,
    IconTriangle3
  },
  data() {
    return {
      isAuthenticated: window.isAuthenticated,
      publicPath: local_image_path,
      orderTab: 1,
      logged_user_id: null,
      buyer_id: null,
      buyerUser: null,
      buyerUserPhotoImageProps: null,
      conversations: [],
      orderBy: "",
      orderByList: [
        {
          label: "All Order"
        },
        {
          label: "Featured"
        },
        {
          label: "Recent"
        }
      ]
    };
  },
  created() {
    document.title = this.$route.meta.title;
    console.log("this.$route.params::");
    console.log(this.$route.params);

    this.buyer_id = this.$route.params.buyer_id;
  },

  mounted() {
    // if (!this.isAuthenticated || !localStorage.getItem("logged_user_id")) {
    //   this.$toast.error("To open buyer you need to login firstly !");
    //   this.$router.push({name: "home"});
    // }
    this.logged_user_id = localStorage.getItem("logged_user_id");
    this.loadBuyerData();
    this.loadBuyerConversations(1);
  }, // mounted() {

  methods: {
    async loadBuyerData() {
      console.log("this.buyer_id::");
      console.log(this.buyer_id);

      const result = await this.callApi(
        "get",
        window.api_path + "public_profile/" + this.buyer_id,
        {}
      );
      if (result.status != 200) {
        this.$toast.error(result.data.message);
        this.buyerUser = null;
        return;
      }
      this.buyerUser = result.data.user;
      this.buyerUserPhotoImageProps = result.data.userPhotoImageProps;
    }, // async loadBuyerData() {

    async loadBuyerConversations() {
      console.log("loadBuyerConversations ::");
      const result = await this.callApi(
        "post",
        window.api_path +
          "public_profile/" +
          this.logged_user_id +
          "/getFilteredConversations",
        {}
      );
      if (result.status != 200) {
        this.$toast.error(result.data.message);
        this.conversations = [];
        return;
      }

      this.conversations = result.data.conversations;
      console.log("this.conversations::");
      console.log(this.conversations);
    } // async loadBuyerConversations() {
  } // methods: {
};
</script>
