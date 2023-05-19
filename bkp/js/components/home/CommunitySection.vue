<template>
  <section class="section-community">
    <div class="container">
      <h2 class="h1">Community</h2>

      <p class="desc" v-html="headerText"></p>
        <router-link
              :to="{
                name: 'communityadd'
              }"
              class="btn btn-primary"
            >
              Ask a Question
            </router-link>
      <ul class="nav nav-ctabs">
        <li
          class="nav-link"
          v-for="tab in communityTabs"
          :key="tab"
          :class="tab === communityTab ? 'active' : ''"
          @click="communityTab = tab"
        >
          {{ tab }}
        </li>
      </ul>

      <div v-if="isLoading" class="tabs-content">
        <div v-for="i in 3" :key="i" class="skeleton"></div>
      </div>
      <div v-else class="tabs-content">
        <div class="tab-content" v-if="communityTab === communityTabs[0]">
          <div class="cpost-list">
            <div class="cpost" v-for="com in newest"
                 :key="com.id">
              <div class="cpost-body">
                <div class="cpost-title">
                  <router-link @click="loadCommunityData()" style="cursor: pointer;"
                               :to="{
                      name: 'communitydetail',
                      params: { slug: com.slug }
                    }"
                  >{{ com.title.substring(0, 120) }}
                  </router-link>
                </div>
                <div class="cpost-text" v-html="com.desc ? com.desc.substring(0, 220) : ''"></div>
              </div>
              <div class="cpost-footer">
                <ul
                  class="tags"
                  v-if="com.community_tag_tagged.length"
                >
                  <li
                    v-for="nextCommunityTagTagged in com.community_tag_tagged"
                    :key="nextCommunityTagTagged.id"
                  ><a
                      @click.prevent="searchTags(nextCommunityTagTagged.tag.title,nextCommunityTagTagged.tag.id)"
                      :class="['tag-'+nextCommunityTagTagged.tag.color, 'tag']">{{ nextCommunityTagTagged.tag.title
                    }}</a></li>
                </ul>
                <div class="cpost-info">
                  <div class="cpost-info-item">
                    
                    <div
                      class="lbl"
                      @click.prevent="voteCommunity(com.id)"
                    >
                      <icon-base
                        width="20"
                        height="20"
                        view-box="0 0 20 18.67"
                        icon-name="like"
                      >
                        <icon-like />
                      </icon-base>
                      <div class="num">
                        {{
                          nFormatter(com.user_community_vote_count, 1)
                        }}
                      </div>
                      <span>Votes</span>
                    </div>
                  </div>
                  <div class="cpost-info-item">
                    
                    <div class="lbl">
                      <icon-base
                        width="20"
                        height="20"
                        view-box="0 0 19 18.96"
                        icon-name="answers"
                      >
                        <icon-answers />
                      </icon-base>
                      <div class="num">
                      {{ nFormatter(com.community_answer_count, 1) }}
                     </div>
                      <span>Answers</span>
                    </div>
                  </div>
                  <div class="cpost-info-item">
                    
                    <div class="lbl">
                      <icon-base
                        width="20"
                        height="20"
                        view-box="0 0 19.23 12.38"
                        icon-name="views"
                      >
                        <icon-views />
                      </icon-base>
                      <div class="num">
                      {{
                        nFormatter(com.user_community_viewed_count, 1)
                      }}
                    </div>
                      <span>Views</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="tab-content" v-if="communityTab === communityTabs[1]">
          <div class="cpost-list">
            <div class="cpost" v-for="com in popular"
                 :key="com.id">
              <div class="cpost-body">
                <div class="cpost-title">
                  <router-link @click="loadCommunityData()" style="cursor: pointer;"
                               :to="{
                      name: 'communitydetail',
                      params: { slug: com.slug }
                    }"
                  >{{ com.title.substring(0, 120) }}
                  </router-link>
                </div>
                <div class="cpost-text" v-html="com.desc ? com.desc.substring(0, 220) : ''"></div>
              </div>
              <div class="cpost-footer">
                <ul
                  class="tags"
                  v-if="com.community_tag_tagged.length"
                >
                  <li
                    v-for="nextCommunityTagTagged in com.community_tag_tagged"
                    :key="nextCommunityTagTagged.id"
                  ><a style="cursor: pointer;"
                      @click.prevent="searchTags(nextCommunityTagTagged.tag.title,nextCommunityTagTagged.tag.id)"
                      :class="['tag-'+nextCommunityTagTagged.tag.color, 'tag']">{{ nextCommunityTagTagged.tag.title
                    }}</a></li>
                </ul>
                <div class="cpost-info">
                  <div class="cpost-info-item">
                    <div class="num">
                      {{
                        nFormatter(com.user_community_vote_count, 1)
                      }}
                    </div>
                    <div
                      class="lbl"
                      @click.prevent="voteCommunity(com.id)"
                    >
                      <icon-base
                        width="14"
                        height="13.07"
                        view-box="0 0 20 18.67"
                        icon-name="like"
                      >
                        <icon-like />
                      </icon-base>
                      <span>Votes</span>
                    </div>
                  </div>
                  <div class="cpost-info-item">
                    <div class="num">
                      {{ nFormatter(com.community_answer_count, 1) }}
                    </div>
                    <div class="lbl">
                      <icon-base
                        width="14"
                        height="14"
                        view-box="0 0 19 18.96"
                        icon-name="answers"
                      >
                        <icon-answers />
                      </icon-base>
                      <span>Answers</span>
                    </div>
                  </div>
                  <div class="cpost-info-item">
                    <div class="num">
                      {{
                        nFormatter(com.user_community_viewed_count, 1)
                      }}
                    </div>
                    <div class="lbl">
                      <icon-base
                        width="14.57"
                        height="9.38"
                        view-box="0 0 19.23 12.38"
                        icon-name="views"
                      >
                        <icon-views />
                      </icon-base>
                      <span>Views</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="tab-content" v-if="communityTab === communityTabs[2]">
          <div class="cpost-list">
            <h2 class="text-center">No record found..</h2>
          </div>
        </div>
      </div>
      <div v-if="communityTab !== communityTabs[2]" class="view-all">
        <router-link :to="{ name: 'community' }">View All</router-link>
      </div>
    </div>
  </section>
</template>

<script>
import appMixin from "../../appMixin";
import IconViews from "../common/icons/IconViews.vue";
import IconBase from "../common/IconBase.vue";
import IconLike from "../common/icons/IconLike.vue";
import IconAnswers from "../common/icons/IconAnswers.vue";

export default {
  name: "CommunityCard",
  props: ["headerText"],
  components: {
    IconAnswers,
    IconLike,
    IconViews,
    IconBase,
  },
  data () {
    return {
      communityTab: 'Newest',
      communityTabs: ['Newest', 'Popular', 'Featured'],
      isLoading: true,
      popular: [],
      newest: []
    }
  },
  mixins: [appMixin],
  methods: {
    async loadCommunities () {
      const res = await Promise.all([
        this.callApi("get", window.api_path + "community/getPopularQuestions", {}),
        this.callApi("get", window.api_path + "community/getNewQuestions", {})
      ])
      this.popular = res[0].data.communityPopularQuestions
      this.newest = res[1].data.communityNewQuestions
      this.isLoading = false;
    }
  },
  mounted () {
    this.loadCommunities();
  },
};
</script>

<style scoped>
.skeleton {
  border-radius: 8px;
  width: 100%;
  height: 163px;
  margin-bottom: 12px;
}
.cpost .cpost-footer{
  -ms-flex-wrap:wrap;
  flex-wrap:wrap;
}
.cpost-footer .tags{
  width:100%;
  margin-right:0;
}
.cpost-footer .cpost-info{
  width:100%;
  -webkit-box-pack:end;
  -ms-flex-pack:end;
  justify-content:flex-end;
}
.cpost-footer .cpost-info{
  padding-top:13px;
  margin-top:13px;
  border-top: 2px solid #D2D5DD;
}
.cpost-info .cpost-info-item {
  display: -webkit-box;
  display: -ms-flexbox;
  display: flex;
  -webkit-box-align: center;
  -ms-flex-align: center;
  align-items: center;
  -webkit-box-pack: start;
  -ms-flex-pack: start;
  justify-content: flex-start;
  -ms-flex-wrap: wrap;
  flex-wrap: wrap;
}
.cpost-info .cpost-info-item .lbl .icon-w{
  margin-right:8px;
}
.cpost-info .cpost-info-item .num{
  margin-right: 3px;
  font-weight: 500;
  font-size: 12px;
  line-height: 54px;
}
.cpost-info .cpost-info-item .num + span{
  font-weight: 500;
  font-size: 12px;
  line-height: 54px;
}
</style>
