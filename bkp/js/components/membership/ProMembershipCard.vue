<template>
  <div v-if="plan" :class="(page === 'settings' && isCurrent) ? 'current-card membership-card' : 'membership-card'">
    <div class="popular-tag">Popular</div>
    <div class="row mx-0 align-items-center">
      <div class="icon-wrapper">
        <img :src="`${publicPath}ProBadge.png`" alt="">
      </div>
      <p class="t-24 w700 t-white ml-4 mb-0">{{ plan.name || 'Pro' }}</p>
    </div>
    <p class="t-white t-18 w500 lh-30 mt-3 mb-0">{{ plan.description || 'The plan for technology professionals.' }}</p>
    <div class="my-0 free-monthly-price">
      <span class="t-white t-54 w700">{{ getPrice(plan.price) }}</span>
      <span class="w600 t-white t-20" style="margin-left: 7px">/month</span>
    </div>
    <p class="w700 t-18 t-white mt-2 mb-4">What’s included</p>
    <div class="included-list-item" v-for="inc in plan.includes">
      <CheckIcon :stroke-color="'#4A3AFF'" :fill-color="'white'" />
      <span class="t-white t-18" style="margin-left: 14px">{{ inc }}</span>
    </div>
    <button
      @click="$emit('plan-submit', plan.id)"
      :class="(page === 'settings' && isCurrent) ? 'disabled-btn membership-btn' : 'membership-btn'"
      :disabled="page === 'settings' && isCurrent"
    >
      {{ buttonText }}
    </button>
  </div>
</template>

<script>
import CheckIcon from "./CheckIcon";
import ProIcon from "./ProIcon";

export default {
  name: "ProMembershipCard",
  props: {
    plan: {
      type: Object
    },
    page: {
      type: String,
      default: 'general'
    },
    currentId: 0
  },
  data () {
    return {
      included: [
        'Publish unlimited projects',
        'Publish up to 10 products',
        'Instant approval publishing a project',
        'Make your projects featured',
      ],
      publicPath: local_image_path,
    }
  },
  methods: {
    getPrice (price) {
      if (!price) return "Free"
      return price + "$"
    }
  },
  components: {
    CheckIcon,
    ProIcon,
  },
  computed: {
    isCurrent() {
      return this.currentId === this.plan.id
    },
    buttonText() {
      if (this.page === 'settings') {
        if (this.isCurrent) {
          return 'Current plan'
        }
        if (this.currentId > this.plan.id) {
          return 'Downgrade'
        }
        if (this.currentId < this.plan.id) {
          return 'Upgrade'
        }
        return 'Get Started'
      }
    }
  }
};
</script>

<style lang="scss" scoped>
.membership-card {
  background: #202C54;
}
.icon-wrapper {
  background: white;
}
.membership-btn {
  margin-top: 18px;
  color: #F2A91C;
  background: white;
  &:hover {
    background: #F2A91C;
    color: white;
  }
}
.popular-tag {
  position: absolute;
  right: 25px;
  top: 25px;
  background: #FFFFFF;
  border-radius: 10px;
  display: flex;
  justify-content: center;
  align-items: center;
  font-size: 14px;
  color: #202C54;
  font-weight: 700;
  width: 98px;
  height: 40px;
}
.disabled-btn {
  background: #C2C2C2;
  color: white;
  cursor: not-allowed;

  &:hover {
    background: #C2C2C2;
    filter: brightness(1);
  }
}
.current-card {
  border: 2px solid #F2A91C;
  box-shadow: 0px 15px 30px rgba(128, 128, 128, 0.25);
}
</style>
