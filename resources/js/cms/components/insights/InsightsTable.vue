<template>
  <div id="InsightsTable" class="position-relative mt-5">
    <preloader />

    <div class="cms-table-header">
      <div class="table-title">
        <h6 class="mb-0 font-weight-bold">List of Insights</h6>
      </div>
      <div class="table-buttons">
        <router-link
          class="d-flex align-items-center"
          title="create"
          :to="{ name: 'InsightInquiry' }"
        >
          <span class="icon-logbit mr-2"></span>
          View Insight Inquiry
        </router-link>
        <router-link
          class="d-flex align-items-center"
          title="create"
          :to="{ name: 'InsightCreate' }"
        >
          <span class="icon-add mr-2"></span>
          Add Insight
        </router-link>
      </div>
    </div>

    <table class="table table-hover cms-table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Title</th>
          <th>Date</th>
          <th>Action</th>
        </tr>
      </thead>

      <tbody v-if="tableData.length === 0">
        <tr>
          <td class="lead text-center" colspan="5">No data found.</td>
        </tr>
      </tbody>

      <tbody v-else>
        <tr v-for="(insight, index) in tableData" :key="insight.id">
          <td>{{ ((currentPage - 1) * perPage) + (index + 1) }}</td>
          <td>{{ insight.title }}</td>
          <td>{{ insight.published_at }}</td>
          <td class="cms-action-items">
            <router-link
              class="btn btn-link"
              title="edit"
              :to="{ name: 'InsightEdit', params: { id: insight.id } }"
            >
              <span class="icon-edit"></span>
            </router-link>

            <confirm-delete-modal :item="insight" :url="`/cms/pages/insights/${insight.id}`" />
          </td>
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
import ConfirmDeleteModal from "../ConfirmDeleteModal";

export default {
  mixins: [DataTable],
  components: { Preloader, Pagination, ConfirmDeleteModal },

  data() {
    return {
      perPage: 5,
    };
  },

  methods: {
    //
  },
};
</script>

<style scoped>
/*  */
</style>
