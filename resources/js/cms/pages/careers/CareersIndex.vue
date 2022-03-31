<template v-cloak>
  <div class="cms-page-wrapper">
    <page-loader v-if="disabled" />

    <div class="cms-page pt-4 mb-5">
      <div class="header-title mb-4">
        <h1>Careers</h1>
      </div>

      <banner-form
        ref="bannerForm"
        url="/cms/pages/update-banner/careers"
        :data="bannerContents"
        v-if="pageContents.length > 0"
      />

      <!-- PAGES -->
      <div class="mt-4" v-if="subPages.length > 0">
        <p class="font-weight-bold">Pages</p>

        <div class="pages-container careers-pages">
          <router-link class="card" :to="{ name: 'JobsIndex' }" v-show="subPages.includes('jobs')">
            <div class="card-body">
              <div class="page-logo">
                <img src="/cms-assets/jobIcon-applicants.png" alt />
              </div>

              <div class="page-name">
                <h2>Job Listings</h2>
              </div>
            </div>
          </router-link>

          <router-link
            class="card"
            :to="{ name: 'ApplicantsIndex' }"
            v-show="subPages.includes('applicants')"
          >
            <div class="card-body">
              <div class="page-logo">
                <img src="/cms-assets/jobIcon-careers.png" alt />
              </div>

              <div class="page-name">
                <h2>Applicants</h2>
              </div>
            </div>
          </router-link>
        </div>
      </div>
    </div>

    <seo-form
      ref="seoForm"
      url="/cms/pages/update-seo/careers"
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

export default {
  components: { PageLoader },
  mixins: [Contents],

  data() {
    return {
      subPages: [],
      contentsUrl: "/cms/pages/careers-contents",
      responses: [],
      disabled: false,
    };
  },

  created() {
    const page = this.$auth.role.modules.find((page) => page.name == "careers");

    this.subPages = page.sub_pages;
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

<style lang="scss" scoped>
.careers-pages {
  grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
}
</style>