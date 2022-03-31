<template>
  <div class="c-blog-recent">
    <h4>Recent</h4>

    <div class="c-blogsRecent--wrap">
      <div class="c-blog" v-for="(blog, index) in tableData" :key="index">
        <div class="c-blog--img">
          <img :src="blog.thumbnail" :alt="blog.altText" />
        </div>

        <div class="c-blog--body">
          <div>
            <small class="c-blog--tag" v-text="blog.category"></small>

            <h6 class="c-blog--title" v-text="blog.title"></h6>
            <div class="c-blog--details text-sm" v-html="blog.details"></div>
          </div>

          <div class="c-blog--body-bottom mt-5">
            <span class="c-blog--date" v-text="blog.published"></span>

            <a class="btn btn-outline-secondary" :href="blog.url">Learn More</a>
          </div>
        </div>
      </div>
    </div>

    <div class="d-flex justify-content-center mt-4">
      <button
        class="btn btn-outline-purple"
        @click.prevent="loadMore()"
        v-show="tableData.length !== pagination.meta.total"
      >{{ loading ? "Loading ..." : "Load More" }}</button>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    pageName: {
      type: String,
      required: true,
    },
    blogSlug: {
      type: String,
      required: false,
    },
  },

  data() {
    return {
      loading: false,
      tableData: [],
      pagination: {
        meta: { to: 1, from: 1 },
      },
      currentPage: 1,
    };
  },

  created() {
    this.fetchData();
  },

  methods: {
    async fetchData(moreData = false) {
      let dataFetchUrl = `/blogs-list?pageName=${this.pageName}&blogSlug=${this.blogSlug}&page=${this.currentPage}`;

      this.loading = true;

      await axios
        .get(dataFetchUrl)
        .then(({ data }) => {
          this.pagination = data;

          moreData
            ? (this.tableData = this.tableData.concat(data.data))
            : (this.tableData = data.data);
        })
        .catch((error) => (this.tableData = []))
        .finally(() => (this.loading = false));
    },

    searchData() {
      this.currentPage = 1;
      this.fetchData();
    },

    loadMore() {
      this.currentPage += 1;
      this.fetchData(true);
    },
  },
};
</script>

<style lang="scss" scoped>
@media (min-width: 1200px) {
  .c-blog {
    max-height: 350px;
  }
}
</style>
