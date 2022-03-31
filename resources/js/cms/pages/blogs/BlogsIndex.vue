<template>
  <div class="cms-page-wrapper">
    <page-loader v-if="disabled" />

    <div class="cms-page">
      <div class="header-title mb-4">
        <h1>Blogs</h1>
      </div>

      <banner-form
        ref="bannerForm"
        url="/cms/pages/update-banner/blogs"
        :data="bannerContents"
        v-if="pageContents.length > 0"
      />

      <blogs-table fetch-url="/cms/pages/blogs/records"></blogs-table>
    </div>

    <seo-form
      ref="seoForm"
      url="/cms/pages/update-seo/blogs"
      :data="seoContents"
      v-if="pageContents.length > 0"
    />

    <div class="d-flex justify-content-end pb-4 mb-4" style="margin-right: 15%">
      <div>
        <button class="btn btn-cancel" @click="cancelAll">Cancel</button>
        <button
          class="btn btn-purple-round"
          :disabled="disabled"
          v-text="disabled ? 'Saving ...' : 'Save'"
          @click="saveAll"
        ></button>
      </div>
    </div>
  </div>
</template>

<script>
import PageLoader from "../../components/PageLoader";
import Contents from "../../mixins/Contents";
import BlogsTable from "../../components/blogs/BlogsTable";

export default {
  components: {
    BlogsTable,
    PageLoader,
  },
  mixins: [Contents],

  data() {
    return {
      contentsUrl: "/cms/pages/blogs-contents",
      responses: [],
      disabled: false,
    };
  },

  methods: {
    async saveAll() {
      this.responses = [];
      this.disabled = true;

      await Promise.all([
        this.$refs.bannerForm.save(false),
        this.$refs.seoForm.saveSeo(false),
      ]).then((res) => {
        this.disabled = false;

        if (this.responses.every((res) => res == "success")) {
          return flash("Blogs Page has been updated!");
        }

        const errors = this.responses.filter((res) => res !== "success");
        const element = document.querySelector(errors[0]);

        return window.scrollTo({ top: element.offsetTop, behavior: "smooth" });
      });
    },

    cancelAll() {
      return location.reload();
    },
  },
};
</script>