<template>
  <div v-if="plan" :class="(page === 'settings' && isCurrent) ? 'current-card membership-card' : 'membership-card'">
    <div class="row mx-0 align-items-center">
      <div class="icon-wrapper">
        <img :src="`${publicPath}FreeBadge.png`" alt="">
      </div>
      <p class="t-24 w700 t-color11 ml-4 mb-0">{{ plan.name || "Free" }}</p>
    </div>
    <p class="t-color12 t-18 w500 lh-30 mt-3 mb-0">
      {{ plan.description || "Get started with our free plan and share your latest projects." }}</p>
    <div class="free-monthly-price">
      <span class="t-color11 t-54 w700">{{ getPrice(plan.price) }}</span>
      <span class="w600 t-color12 t-20" style="margin-left: 7px">/month</span>
    </div>
    <p class="w700 t-18 t-color11 mt-2 mb-4">What’s included</p>
    <div class="included-list-item" v-for="inc in plan.includes">
      <CheckIcon />
      <span class="t-color11 t-18" style="margin-left: 14px">{{ inc }}</span>
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

export default {
  name: "FreeMembershipCard",
  props: {
    plan: {
      type: Object
    },
    page: {
      type: String,
      default: "general"
    },
    currentId: 0
  },
  data() {
    return {
      included: [
        "3 projects per month",
        "10 products per month",
        "Approval required to publish"
      ],
      publicPath: local_image_path,
    };
  },
  methods: {
    getPrice(price) {
      if (!price) return "Free";
      return price + "$";
    }
  },
  components: {
    CheckIcon
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
  background: white;
}

.icon-wrapper {
  background: #FFEAC0;
}

.membership-btn {
  margin-top: 90px;
  color: #FFFFFF;
  background: #F2A91C;

  &:hover {
    filter: brightness(1.2);
  }
}

.current-card {
  border: 2px solid #F2A91C;
  box-shadow: 0px 15px 30px rgba(128, 128, 128, 0.25);
}

.disabled-btn {
  background: #C2C2C2;
  color: white;
  cursor: not-allowed;

  &:hover {
    filter: brightness(1);
  }
}
</style>
