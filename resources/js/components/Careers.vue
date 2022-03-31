<template>
  <div class="c-careers">
    <careers-filter />

    <ul class="careers-list">
      <li v-if="tableData.length === 0">No Jobs yet.</li>

      <li
        class="careers-item"
        v-for="(career, index) in tableData"
        :key="index"
        v-else
      >
        <h4 class="job-title" v-text="career.title"></h4>
        <div class="job-details">
          <div>
            <p>Department</p>
            <small v-text="career.department"></small>
          </div>

          <div>
            <p>Years of Experience</p>
            <small v-text="career.experience"></small>
          </div>

          <div>
            <p>Status</p>
            <small class="job-status">{{
              career.status ? "Active" : "Not Active"
            }}</small>
          </div>

          <div class="job-buttons">
            <a
              :href="`/career/${career.slug}`"
              class="btn btn-outline-purple"
              role="button"
              >View
            </a>

            <a
              :href="`/career/${career.slug}/apply`"
              class="btn btn-purple"
              role="button"
              >Apply
            </a>
          </div>
        </div>
      </li>
    </ul>

    <div class="careers-footer">
      <button
        class="btn btn-outline-purple"
        @click.prevent="loadMore()"
        v-show="tableData.length !== pagination.meta.total"
      >
        {{ loading ? "Loading ..." : "Load More" }}
      </button>
    </div>
  </div>
</template>

<script>
import CareersFilter from "./CareersFilter";

export default {
  components: { CareersFilter },

  data() {
    return {
      tableData: [],
      pagination: {
        meta: { to: 1, from: 1 },
      },
      perPage: 4,
      currentPage: 1,
      column: "title",
      order: "asc",
      filter: "",
      loading: false,
    };
  },

  watch: {
    column() {
      this.searchData();
    },

    order() {
      this.searchData();
    },
  },

  created() {
    this.fetchData();
  },

  methods: {
    async fetchData(moreData = false) {
      let dataFetchUrl = `/careers-list?page=${this.currentPage}&column=${this.column}&order=${this.order}&filter=${this.filter}&per_page=${this.perPage}`;

      this.loading = true;

      await axios
        .get(dataFetchUrl)
        .then(({ data }) => {
          this.loading = false;
          this.pagination = data;

          moreData
            ? (this.tableData = this.tableData.concat(data.data))
            : (this.tableData = data.data);
        })
        .catch((error) => (this.tableData = []));
    },

    searchData() {
      this.currentPage = 1;
      this.fetchData();
    },

    loadMore() {
      this.currentPage += 1;
      this.fetchData(true);
    },

    filterData(columName) {
      if (this.column == columName) {
        const orders = ["asc", "desc"];

        return this.order == orders[0]
          ? (this.order = orders[1])
          : (this.order = orders[0]);
      }

      return (this.column = columName);
    },
  },
};
</script>

<style scoped>
/*  */
</style>