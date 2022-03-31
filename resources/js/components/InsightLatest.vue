<template>
  <div>
    <insight-modal :itemTitle="latestTitle" />
  </div>
</template>

<script>
import InsightModal from "./InsightModal.vue";
export default {
  props: {
    latestTitle: {
      type: String,
      required: true,
    },
  },
  components: {
    InsightModal,
  },
  data() {
    return {};
  },
  methods: {},
};
</script>

<style lang="scss" scoped>
</style>
