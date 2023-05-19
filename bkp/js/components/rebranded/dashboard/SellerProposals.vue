<template>
  <div>
    <div @click="togglePending" :class="activePending ? 'active-acc accordion' : 'accordion'">
      <p>Pending Proposals (10)</p>
      <img :src="`${publicPath}/icons/arrow_up.svg`" style="margin-left: auto">
    </div>
    <div v-if="activePending">
      <div class="project-card">
        <p class="num">01</p>
        <router-link to="" class="project">Project title goes here</router-link>
        <p class="date">Nov 2, 2021, 02:07pm</p>
      </div>
      <div class="project-card">
        <p class="num">01</p>
        <router-link to="" class="project">Project title goes here</router-link>
        <p class="date">Nov 2, 2021, 02:07pm</p>
      </div>
    </div>
    <div @click="toggleDiscussion" :class="activeDiscussion ? 'active-acc accordion' : 'accordion'">
      <p>Projects in discussion (10)</p>
      <img :src="`${publicPath}/icons/arrow_up.svg`" style="margin-left: auto">
    </div>
    <div v-if="activeDiscussion">
      <div class="project-card">
        <p class="num">01</p>
        <router-link to="" class="project">Project title goes here</router-link>
        <p class="date">Nov 2, 2021, 02:07pm</p>
      </div>
      <div class="project-card">
        <p class="num">01</p>
        <router-link to="" class="project">Project title goes here</router-link>
        <p class="date">Nov 2, 2021, 02:07pm</p>
      </div>
    </div>
    <div @click="toggleInvites" :class="activeInvites ? 'active-acc accordion' : 'accordion'">
      <p>Pending Invites (10)</p>
      <img :src="`${publicPath}/icons/arrow_up.svg`" style="margin-left: auto">
    </div>
    <div v-if="activeInvites">
      <div class="project-card">
        <p class="num">01</p>
        <router-link to="" class="project">Project title goes here</router-link>
        <p class="date">Nov 2, 2021, 02:07pm</p>
      </div>
      <div class="project-card">
        <p class="num">01</p>
        <router-link to="" class="project">Project title goes here</router-link>
        <p class="date">Nov 2, 2021, 02:07pm</p>
      </div>
    </div>
    <div @click="toggleProposals" :class="activeProposals ? 'active-acc accordion' : 'accordion'">
      <p>Archived Proposals (2)</p>
      <img :src="`${publicPath}/icons/arrow_up.svg`" style="margin-left: auto">
    </div>
    <div v-if="activeProposals">
      <div class="project-card">
        <p class="num">01</p>
        <router-link to="" class="project">Project title goes here</router-link>
        <p class="date">Nov 2, 2021, 02:07pm</p>
      </div>
      <div class="project-card">
        <p class="num">01</p>
        <router-link to="" class="project">Project title goes here</router-link>
        <p class="date">Nov 2, 2021, 02:07pm</p>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "SellerProposals",
  data () {
    return {
      publicPath: local_image_path,
      activePending: true,
      activeDiscussion: true,
      activeInvites: true,
      activeProposals: true
    }
  },
  methods: {
    togglePending () {
      this.activePending = !this.activePending
    },
    toggleDiscussion () {
      this.activeDiscussion = !this.activeDiscussion
    },
    toggleInvites () {
      this.activeInvites = !this.activeInvites
    },
    toggleProposals () {
      this.activeProposals = !this.activeProposals
    }
  }

};
</script>

<style lang="scss" scoped>
.accordion {
  img {
    transition: .2s;
    transform: rotate(180deg);
  }
}
.active-acc {
  img {
    transform: rotate(0deg);
  }
}
</style>
