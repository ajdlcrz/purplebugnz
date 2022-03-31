<template>
  <div id="servicesTable" class="position-relative mt-5">
    <preloader />

    <div class="cms-table-header">
      <div class="table-title">
        <h6 class="mb-0 font-weight-bold">List of Services</h6>
      </div>

      <div class="table-buttons">
        <router-link
          class="d-flex align-items-center"
          title="create"
          :to="{ name: 'ServiceCreate' }"
        >
          <span class="icon-add mr-2"></span>
          Add Service
        </router-link>
      </div>
    </div>

    <table class="table table-hover cms-table">
      <thead class="thead-light">
        <tr>
          <th class="table-head">ID</th>
          <th class="table-head">Service Name</th>
          <th class="table-head">Description</th>
          <th class="table-head">Action</th>
        </tr>
      </thead>

      <tbody v-if="tableData.length === 0">
        <tr>
          <td class="lead text-center" colspan="5">No data found.</td>
        </tr>
      </tbody>

      <tbody v-for="service in tableData" :key="service.id" v-else>
        <tr>
          <td>{{ service.id }}</td>
          <td class="title">{{ service.title }}</td>
          <td class="description">{{ service.strippedDescription }}</td>
          <td class="cms-action-items">
            <router-link
              class="btn btn-link"
              title="edit"
              :to="{ name: 'ServiceEdit', params: { id: service.id } }"
            >
              <span class="icon-edit"></span>
            </router-link>

            <confirm-delete-modal
              :item="service"
              :url="`/cms/pages/services/${service.id}`"
            />
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
      //
    };
  },

  methods: {
    //
  },
};
</script>

<style>
</style>