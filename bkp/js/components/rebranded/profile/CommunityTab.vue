<template>
  <div class="community-section">
    <div
      class="community-card"
      v-for="(community, index) in userProfile.communities"
      :key="index"
    >
      <div style="border-bottom: 2px solid #d2d5dd">
        <div class="row mx-0">
          <h4 class="t-18 w500 mb-0">
            <router-link style="cursor: pointer;"
                         :to="{
                      name: 'communitydetail',
                      params: { slug: community.slug }
                    }"
            >{{ community.title }}
            </router-link>
          </h4>
          <!-- <button class="edit-icon"
                  style="position: relative; margin-top: -10px; margin-left: auto;">
            <EditIcon />
          </button> -->
        </div>

        <p class="t-16 t-color2 com-desc" style="width: 70%; margin-top: 10px" v-html="community.desc">
        </p>
        <div class="row mx-0" style="margin-bottom: 12px">
          <!-- <button class="tag" style="background: rgba(40, 180, 70, 0.2); border: 0.5px solid #28B446;">{{ nextCommunityTagTagged.tag.title }}
          </button> -->

          <ul class="tags" v-if="community.community_tag_tagged.length > 0">
            <li
              v-for="nextCommunityTagTagged in community.community_tag_tagged"
              :key="nextCommunityTagTagged.id"
            >
              <a
                style="cursor: pointer"
                @click.prevent="
                      searchTags(
                        nextCommunityTagTagged.tag.title,
                        nextCommunityTagTagged.tag.id
                      )
                    "
                :class="['tag-' + nextCommunityTagTagged.tag.color, 'tag']"
              >{{ nextCommunityTagTagged.tag.title }}</a
              >
            </li>
          </ul>
        </div>
      </div>
      <div class="row mx-0 justify-content-end com-icons" style="margin-top: 24px">
        <div
          class="d-flex align-items-center"
          style="margin-right: 15px; cursor: pointer"
        >
          <VotesIcon style="margin-right: 7px" />
          <span> {{ community.user_community_vote_count }} Votes</span>
        </div>
        <div
          class="d-flex align-items-center"
          style="margin-right: 15px; cursor: pointer"
        >
          <AnswersIcon style="margin-right: 7px" />
          <span>{{ community.community_answer_count }} Answers</span>
        </div>
        <div class="d-flex align-items-center" style="cursor: pointer">
          <ViewsIcon style="margin-right: 7px" />
          <span> {{ community.user_community_viewed_count }} Views</span>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import AnswersIcon from "../icons/AnswersIcon";
import VotesIcon from "../icons/VotesIcon";
import ViewsIcon from "../icons/ViewsIcon";

export default {
  name: "Community",
  props: {
    userProfile: {
      type: Object,
      required: true
    }
  },
  components: {
    AnswersIcon,
    VotesIcon,
    ViewsIcon
  }
};
</script>

<style scoped>
  @media all and (max-width:575px){
    .com-icons {
      justify-content: space-between !important;
      margin-top: 10px !important;
  }
  .com-icons > div{
      margin-right:10px !important;
  }
  
  .com-icons > div > svg {
      width: 15px;
  }
  
  .com-icons > div > span {
      font-size: 14px;
  }
  .profile-rebranded .community-section .community-card{
    margin: 10px 0;
    padding: 20px 10px;
  }
  .com-desc{
    margin-bottom:0;
  }
  }
</style>
