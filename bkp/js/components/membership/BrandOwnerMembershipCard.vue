<template>
  <div v-if="plan" :class="(page === 'settings' && isCurrent) ? 'current-card membership-card' : 'membership-card'">
    <div class="row mx-0 align-items-center">
      <div class="icon-wrapper">
        <img :src="`${publicPath}BrandOwnerBadge.png`" alt="">
      </div>
      <p class="t-24 w700 t-color11 ml-4 mb-0">{{ plan.name || '' }}</p>
    </div>
    <p class="t-color12 t-18 w500 lh-30 mt-3 mb-0">{{ plan.description || '' }}</p>
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
import BrandOwnerIcon from "./BrandOwnerIcon";

export default {
  name: "BrandOwnerMembershipCard",
  props: {
    plan: {
      type: Object,
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
        'Everything in Pro plan +',
        'Create and customize your brand page',
        'Publish unlimited products',
        'Manage authorized resellers',
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
    BrandOwnerIcon,
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
  margin-top: 18px;
  color: #FFFFFF;
  background: #F2A91C;
  &:hover {
    filter: brightness(1.2);
  }
}
.disabled-btn {
  background: #C2C2C2;
  color: white;
  cursor: not-allowed;

  &:hover {
    filter: brightness(1);
  }
}
.current-card {
  border: 2px solid #F2A91C;
  box-shadow: 0px 15px 30px rgba(128, 128, 128, 0.25);
}
</style>
