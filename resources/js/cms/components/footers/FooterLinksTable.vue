<template>
  <div id="footerTable" class="position-relative mt-5">
    <preloader />

    <div class="cms-table-header">
      <div class="table-title">
        <h4 class="mb-0 font-weight-bold">Footer Links</h4>
      </div>

      <div class="table-buttons">
        <a
          type="button"
          class="d-flex align-items-center"
          data-toggle="modal"
          data-target="#footer-modal"
        >
          <span class="icon-link mr-2"></span>
          Add a Link
        </a>
      </div>
    </div>

    <table class="table table-hover cms-table">
      <thead>
        <tr>
          <th>Title</th>
          <th>URL</th>
          <th>Status</th>
          <th>Action</th>
        </tr>
      </thead>

      <tbody v-if="tableData.length === 0">
        <tr>
          <td class="lead text-center" colspan="5">No data found.</td>
        </tr>
      </tbody>

      <tbody v-else>
        <tr v-for="footer in tableData" :key="footer.id">
          <td v-text="footer.title"></td>
          <td v-text="footer.url"></td>
          <td :class="footer.status ? 'text-success' : 'text-danger'">
            {{ footer.status ? "PUBLISHED" : "UNPUBLISHED" }}
          </td>
          <td class="cms-action-items">
            <button
              title="edit"
              class="btn btn-link"
              data-toggle="modal"
              data-target="#footer-modal"
              @click="editFooter(footer)"
            >
              <span class="icon-edit"></span>
            </button>

            <confirm-delete-modal
              :item="footer"
              :url="`/cms/pages/footer-links/${footer.id}`"
            />
          </td>
        </tr>
      </tbody>
    </table>

    <div class="pagination-container">
      <pagination />
    </div>

    <footer-link-modal
      :selectedFooter="selectedFooter"
      @removeSelectedFooter="selectedFooter = {}"
    />
  </div>
</template>

<script>
import DataTable from "../../mixins/DataTables";
import Preloader from "../Preloader";
import Pagination from "../Pagination";
import FooterLinkModal from "./FooterLinkModal";
import ConfirmDeleteModal from "../ConfirmDeleteModal";

export default {
  mixins: [DataTable],
  components: { Preloader, Pagination, FooterLinkModal, ConfirmDeleteModal },

  data() {
    return {
      perPage: 10,
      selectedFooter: {},
    };
  },

  methods: {
    editFooter(footer) {
      this.selectedFooter = footer;
    },
  },
};
</script>

<style lang='scss' scoped>
/*  */
</style>