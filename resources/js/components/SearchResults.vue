<template>
  <div class="c-careers c-about--content">
    <form action="/search" method="GET" style="min-height: 40px">
      <div class="career-filters justify-content-center h-100">
        <input
          class="job-search"
          type="text"
          name="keyword"
          placeholder="Search PurpleBug"
          v-model="searchField"
        />
      </div>
    </form>

    <p class="h3 text-center" v-if="results.length == 0">No Results Found.</p>

    <div class="c-cards--wrapper" v-show="results.length > 0">
      <a
        v-for="(result, key) in results"
        :key="key"
        :href="result.url"
        target="__blank"
        rel="noopener noreferrer"
      >
        <div class="c-card mb-3 bg-white">
          <div class="c-cardImg--wrapper" style="min-height: 170px; min-width: 170px;">
            <!-- Image - 170 x 170 -->
            <img
              v-if="result.type == 'blogs' || result.type == 'services' || result.type == 'insights'"
              class="c-card--img"
              height="170"
              width="170"
              :src="`${result.searchable.thumbnailPath ? result.searchable.thumbnailPath : '/img/placeholders/no-img.jpg'}`"
            />

            <img
              v-else-if="result.type == 'subsidiaries'"
              class="c-card--img"
              height="170"
              width="170"
              :src="`${result.searchable.imagePath ? result.searchable.imagePath : '/img/placeholders/no-img.jpg'}`"
            />

            <img
              v-else-if="result.type == 'contents' && result.searchable.section == 'banner'"
              class="c-card--img"
              height="170"
              width="170"
              :src="`/storage/banners/${result.searchable.contents.image}`"
            />

            <img
              v-else-if="result.type == 'contents' && result.searchable.section == 'footer_banner'"
              class="c-card--img"
              height="170"
              width="170"
              :src="`/storage/homepage/footer/${result.searchable.contents.image}`"
            />

            <img
              v-else-if="result.type == 'careers' && result.searchable.banner != null"
              class="c-card--img"
              height="170"
              width="170"
              :src="result.searchable.bannerPath"
            />

            <img
              v-else
              class="c-card--img"
              height="170"
              width="170"
              src="/img/placeholders/no-img.jpg"
            />
          </div>

          <div class="c-card--content">
            <h5 v-text="result.title"></h5>
            <div
              v-if="result.type == 'blogs'"
              v-html="$options.filters.stripDetails(result.searchable.seo.meta_description)"
            ></div>
            <div
              v-if="result.type == 'insights'"
              v-html="$options.filters.stripDetails(result.searchable.seo.meta_description)"
            ></div>
            <div
              v-if="result.type == 'careers'"
              v-html="$options.filters.stripDetails(result.searchable.overview)"
            ></div>
            <div v-if="result.type == 'services'" v-html="result.searchable.strippedDescription"></div>
            <div
              v-if="result.type == 'subsidiaries'"
              v-html="$options.filters.stripDetails(result.searchable.body)"
            ></div>
            <div
              v-if="result.type == 'contents' && result.searchable.body != null"
              v-html="$options.filters.stripDetails(result.searchable.body)"
            ></div>
            <div
              v-else-if="result.type == 'contents' && result.searchable.body == null"
              v-html="!Array.isArray(result.searchable.contents) ? $options.filters.stripDetails(result.searchable.contents.body) : ''"
            ></div>
          </div>
        </div>
      </a>
    </div>

    <div class="careers-footer" v-show="results.length > 0 && results.length < resultsCount">
      <button
        class="btn btn-outline-purple"
        @click.prevent="fetchResults()"
      >{{ loading ? "Loading ..." : "Load More" }}</button>
    </div>
  </div>
</template>

<script>
export default {
  props: ["keyword"],

  data() {
    return {
      loading: false,
      searchField: this.keyword,
      results: [],
      resultsCount: 0,
      limit: 0,
    };
  },

  created() {
    if (this.keyword != "") {
      this.fetchResults();
    }
  },

  filters: {
    stripDetails(value) {
      return `${value.substring(0, 150)}...`;
    },
  },

  methods: {
    fetchResults() {
      this.loading = true;
      this.searchField = "fetching ...";

      axios
        .get("searchList", {
          params: {
            keyword: this.keyword,
            limit: (this.limit += 5),
          },
        })
        .then(({ data }) => {
          this.results = data.results;
          this.resultsCount = data.count;
        })
        .finally(() => {
          this.loading = false;
          this.searchField = this.keyword;
        });
    },
  },
};
</script>

<style scoped>
/*  */
</style>