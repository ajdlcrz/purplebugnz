<template>
  <div class="cms-page-wrapper">
    <div class="cms-page jobs-management pt-4 mb-5">
      <jobs-table fetch-url="/cms/pages/jobs/records" />
    </div>
  </div>
</template>

<script>
import JobsTable from "../../components/careers/JobsTable";

export default {
  components: { JobsTable },

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