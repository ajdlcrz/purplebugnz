<template>
  <div>
    <insight-modal
        :itemTitle="insightTitle"
    />
  </div>
</template>

<script>
import InsightModal from "./InsightModal.vue";
export default {
    props: {
    insightTitle: {
      type: String,
      required: true,
    },
  },
    components: {
        InsightModal,
    },
    data() {
        return {
        }
    },
    methods: {
    },
}
</script>

<style lang="scss" scoped>
</style>
