<template>
  <div class="cms-page-wrapper">
    <div class="cms-page jobs-management pt-4 mb-5">
      <footer-links-table fetch-url="/cms/pages/footer-links/records" />
    </div>
  </div>
</template>

<script>
import FooterLinksTable from "../components/footers/FooterLinksTable";

export default {
  components: { FooterLinksTable },

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