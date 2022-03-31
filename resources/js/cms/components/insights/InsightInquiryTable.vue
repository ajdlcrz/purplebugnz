<template>
  <div id="jobsTable" class="position-relative mt-5">
    <preloader />

    <div class="cms-table-header">
      <div class="table-title align-items-center mr-3">
        <h4 class="mb-0 font-weight-bold text-nowrap">Insights Inquiry</h4>
      </div>

      <div class="table-buttons">
        <a
          :href="`/cms/pages/insights-report/export/${sortedColumn}/${order}`"
          class="text-nowrap d-flex align-items-center"
        >
          <span class="icon-export mr-2"></span>
          Export
        </a>

        <div class="text-nowrap dropdown">
          <a type="button" class="d-flex align-items-center" data-toggle="dropdown">
            <span class="icon-sort mr-2"></span>
            Sort By
          </a>

          <div class="dropdown-menu dropdown-menu-right">
            <button
              class="dropdown-item d-flex justify-content-between"
              v-for="(column, key) in sortables"
              :key="key"
              @click.prevent="sortByColumn(key)"
            >
              {{ column | columnHead }}
              <span v-if="sortedColumn === key">
                <span v-if="order === 'asc'">👆</span>
                <span v-else>👇</span>
              </span>
            </button>
          </div>
        </div>

        <input
          type="text"
          class="form-control"
          placeholder="Search Insight Listings"
          v-model="filter"
          @keydown.enter.prevent="fetchData"
        />
      </div>
    </div>

    <table class="table table-hover cms-table">
      <thead>
        <tr>
          <th>Title</th>
          <th>Name</th>
          <th>Email</th>
          <th>Company</th>
          <th>Contact Manager</th>
          <th>Date</th>
        </tr>
      </thead>
      <tbody v-if="tableData.length === 0">
        <tr>
          <td class="lead text-center" colspan="5">No data found.</td>
        </tr>
      </tbody>
      <tbody v-else>
        <tr v-for="insight_inquiry in tableData" :key="insight_inquiry.id">
          <td v-text="insight_inquiry.title"></td>
          <td v-text="insight_inquiry.name"></td>
          <td v-text="insight_inquiry.email"></td>
          <td v-text="insight_inquiry.company"></td>
          <td v-text="insight_inquiry.contact_manager"></td>
          <td>{{ moment(insight_inquiry.created_at).format('MMM DD, YYYY') }}</td>
        </tr>
      </tbody>
    </table>

    <div class="pagination-container">
      <pagination />
    </div>
  </div>
</template>

<script>
import DataTable from "../../mixins/DataTables";
import Preloader from "../Preloader";
import Pagination from "../Pagination";

export default {
  mixins: [DataTable],
  components: { Preloader, Pagination },

  data() {
    return {
      perPage: 10,
      sortables: {
        title: "Title",
        name: "Name",
        email: "Email",
        company: "Company",
        created_at: "Date",
      },
      selectedJob: {},
    };
  },
  filters: {
    filterDate: function(value) {
        return
    },
  },
  methods: {
  },
};
</script>

<style lang='scss' scoped>
/*  */
</style>
