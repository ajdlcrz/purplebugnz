<template>
  <div class="cms-page-wrapper">
    <div class="cms-page jobs-management pt-4 mb-5">
      <insight-inquiry-table fetch-url="/cms/pages/insights-report/fetch" />
    </div>
  </div>
</template>

<script>
import InsightInquiryTable from "../../components/insights/InsightInquiryTable.vue";

export default {
  components: { InsightInquiryTable },

  data() {
    return {
      //
    };
  },
};
</script>

<style lang='scss' scoped>
/*  */
</style>
