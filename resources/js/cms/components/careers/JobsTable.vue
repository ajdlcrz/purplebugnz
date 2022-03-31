<template>
  <div id="jobsTable" class="position-relative mt-5">
    <preloader />

    <div class="cms-table-header">
      <div class="table-title align-items-center mr-3">
        <h4 class="mb-0 font-weight-bold text-nowrap">Job Listings</h4>
      </div>

      <div class="table-buttons">
        <a
          type="button"
          class="text-nowrap d-flex align-items-center"
          data-toggle="modal"
          data-target="#job-modal"
        >
          <span class="icon-addaccount mr-2"></span>
          Add Job Listing
        </a>

        <a
          :href="`/cms/pages/jobs/export/${sortedColumn}/${order}`"
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
          placeholder="Search Job Listings"
          v-model="filter"
          @keydown.enter.prevent="fetchData"
        />
      </div>
    </div>

    <table class="table table-hover cms-table">
      <thead>
        <tr>
          <th>Job Title</th>
          <th>Department</th>
          <th>Years of Experience</th>
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
        <tr v-for="job in tableData" :key="job.id">
          <td v-text="job.title"></td>
          <td v-text="job.department"></td>
          <td v-text="job.experience"></td>
          <td>
            <span :class="`icon-circle ${!job.status ? 'icon-circle--red' : ''}`"></span>
            {{ job.status ? "Active" : "Inactive" }}
          </td>
          <td class="cms-action-items">
            <button
              title="edit"
              class="btn btn-link"
              data-toggle="modal"
              data-target="#job-modal"
              @click="editJob(job)"
            >
              <span class="icon-edit"></span>
            </button>

            <confirm-delete-modal :item="job" :url="`/cms/pages/jobs/${job.id}`" />
          </td>
        </tr>
      </tbody>
    </table>

    <div class="pagination-container">
      <pagination />
    </div>

    <job-form-modal :selectedJob="selectedJob" @removeselectedJob="selectedJob = {}" />
  </div>
</template>

<script>
import DataTable from "../../mixins/DataTables";
import Preloader from "../Preloader";
import Pagination from "../Pagination";
import JobFormModal from "./JobFormModal";
import ConfirmDeleteModal from "../ConfirmDeleteModal";

export default {
  mixins: [DataTable],
  components: { Preloader, Pagination, JobFormModal, ConfirmDeleteModal },

  data() {
    return {
      perPage: 5,
      sortables: {
        title: "Job Title",
        department: "Department",
        experience: "Years of Experience",
        status: "Status",
      },
      selectedJob: {},
    };
  },

  methods: {
    editJob(job) {
      this.selectedJob = job;
    },
  },
};
</script>

<style lang='scss' scoped>
/*  */
</style>