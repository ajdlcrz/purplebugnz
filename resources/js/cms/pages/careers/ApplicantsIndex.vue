<template>
  <div class="cms-page-wrapper cms-applicants">
    <div class="cms-page pt-4 mb-5">
      <div id="applicantsTable" class="position-relative mt-5">
        <preloader />

        <!-- DATATABLE HEADER -->
        <div class="cms-table-header mb-0">
          <div class="table-title align-items-center mr-3">
            <h4 class="mb-0 font-weight-bold">Applicants</h4>
          </div>

          <div class="table-buttons">
            <button
              class="btn headerBtn d-flex align-items-center text-no-wrap"
              data-toggle="modal"
              data-target="#export-modal"
              @click="viewExportModal"
            >
              <span class="icon-export mr-2"></span>
              Export
            </button>

            <div class="dropdown text-nowrap">
              <a type="button" class="d-flex align-items-center" data-toggle="dropdown">
                <span class="icon-sort mr-2"></span>
                Sort By
              </a>

              <div class="dropdown-menu dropdown-menu-right">
                <button
                  :class="`dropdown-item d-flex justify-content-between ${sortedColumn === key ? 'text-purple' : ''}`"
                  v-for="(column, key) in sortables"
                  :key="key"
                  @click.prevent="sortByColumn(key)"
                >
                  {{ column | columnHead }}
                  <span class="ml-2" v-if="sortedColumn === key">
                    <span v-if="order === 'asc'">&#x2934;</span>
                    <span v-else>&#x2935;</span>
                  </span>
                </button>
              </div>
            </div>

            <input
              type="text"
              class="form-control"
              placeholder="Search Applicants"
              v-model="filter"
              @keydown.enter="fetchData()"
              style="min-width: 200px;"
            />
          </div>
        </div>

        <!-- APPLICANT FILTERS -->
        <div class="applicant-filters">
          <div
            :class="`applicant-status ${selectedStatus == 'all' ? 'active' : ''}`"
            @click.prevent="filterBy('all')"
          >
            <span class="px-1">All</span>
          </div>
          <div
            :class="`applicant-status ${selectedStatus == status ? 'active' : ''}`"
            v-for="(status, index) in statuses"
            :key="index"
            @click.prevent="filterBy(status)"
          >
            <span class="px-1" v-text="status"></span>
          </div>
        </div>

        <!-- DATATABLE -->
        <div class="table-responsive">
          <table class="table table-hover cms-table">
            <thead>
              <tr>
                <th
                  :class="`align-middle text-nowrap ${sortedColumn === key ? 'text-purple' : ''}`"
                  v-for="(column, key) in sortables"
                  :key="key"
                  @click.prevent="sortByColumn(key)"
                  style="cursor: pointer;"
                >
                  {{ column | columnHead }}
                  <span class="ml-1" v-if="sortedColumn === key">
                    <span v-if="order === 'asc'">&#x2934;</span>
                    <span v-else>&#x2935;</span>
                  </span>
                </th>
                <th class="align-middle">Action</th>
              </tr>
            </thead>

            <tbody v-if="tableData.length === 0">
              <tr>
                <td
                  class="lead text-center"
                  :colspan="Object.keys(sortables).length + 1"
                >No data found.</td>
              </tr>
            </tbody>

            <tbody v-else>
              <tr v-for="applicant in tableData" :key="applicant.id">
                <td v-html="highlightKeyword(applicant.career.title)"></td>
                <td v-html="highlightKeyword(applicant.name)"></td>
                <td v-html="highlightKeyword(applicant.contact)"></td>
                <td v-html="highlightKeyword(applicant.email)"></td>
                <td v-html="highlightKeyword(applicant.address)"></td>
                <td v-html="highlightKeyword(applicant.applied_at)"></td>
                <td
                  class="text-nowrap"
                  v-html="highlightKeyword($options.filters.columnHead(applicant.status))"
                ></td>
                <td class="cms-action-items">
                  <button
                    title="view"
                    class="btn btn-link"
                    data-toggle="modal"
                    data-target="#applicant-modal"
                    @click="viewApplicant(applicant)"
                  >
                    <span class="icon-view"></span>
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <!-- DATATABLE PAGINATION -->
        <div class="pagination-container">
          <pagination />
        </div>
      </div>
    </div>

    <!-- Applicant Modal -->
    <div id="applicant-modal" class="modal fade applicant-modal" tabindex="-1" role="dialog">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header border-0">
            <h4 class="modal-title font-weight-bold">Applicant</h4>
          </div>

          <div class="modal-body">
            <div class="row no-gutters mb-3">
              <div class="col-md-6">Applying For</div>
              <div
                class="col-md-6 right-side"
                v-text="
                  selectedApplicant.career ? selectedApplicant.career.title : ''
                "
              ></div>
            </div>

            <div class="row no-gutters mb-3 pb-3 border-bottom border-purple">
              <div class="col-md-6 d-flex align-items-center">Status</div>
              <div class="col-md-6 right-side">
                <form class="row no-gutters align-items-center" method="POST" v-if="isEdit">
                  <select :class="`col-md-8 form-control mr-2`" v-model="form.status">
                    <option value disabled selected>Select Status</option>

                    <option
                      v-for="(status, index) in statuses"
                      :key="index"
                      :value="status"
                      v-text="$options.filters.columnHead(status)"
                    ></option>
                  </select>

                  <button
                    class="btn btn-danger btn-sm mr-1 form-btn"
                    :disabled="submitting"
                    @click.prevent="cancel"
                  >✖</button>
                  <button
                    class="btn btn-success btn-sm form-btn"
                    :disabled="submitting"
                    @click.prevent="update"
                  >&#x2714;</button>
                </form>

                <div class="row no-gutters align-items-center text-capitalize" v-else>
                  <span v-text="form.status"></span>
                  <button
                    class="btn btn-sm btn-link font-weight-bold py-0"
                    @click="isEdit = true"
                  >Edit</button>
                </div>
              </div>
            </div>

            <div class="row no-gutters">
              <div class="col-md-6">
                <p>Date Applied</p>
                <p>Name</p>
                <p>Contact No.</p>
                <p>Email Address</p>
                <p>Address</p>
              </div>
              <div class="col-md-6 right-side">
                <p v-text="selectedApplicant.applied_at"></p>
                <p v-text="selectedApplicant.name"></p>
                <p v-text="selectedApplicant.contact"></p>
                <p v-text="selectedApplicant.email"></p>
                <p v-text="selectedApplicant.address"></p>
              </div>
            </div>

            <div class="row no-gutters">
              <div class="col-md-6">
                <p>Upload File</p>
              </div>
              <div class="col-md-6 right-side">
                <div class="applicant-resume">
                  <span v-text="selectedApplicant.file"></span>

                  <a
                    class="btn btn-sm btn-outline-purple-round btn-download"
                    :href="`/cms/pages/download-resume/${selectedApplicant.id}`"
                    target="__blank"
                  >
                    Download File
                    <span class="icon-download"></span>
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Applicant Modal -->

    <!-- Export Modal -->
    <div id="export-modal" class="modal fade applicant-modal" tabindex="-1" role="dialog">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header border-0">
            <h4 class="modal-title font-weight-bold">Export Applicants</h4>
          </div>

          <div class="modal-body">
            <form>
              <div class="form-row">
                <!-- From date -->
                <div class="form-group col-6">
                  <label>From</label>

                  <input
                    type="date"
                    class="form-control"
                    v-model="startDate"
                    @change="validateStartDate"
                  />

                  <small class="text-danger" v-if="errors.startDate" v-text="errors.startDate"></small>
                </div>

                <!-- To date -->
                <div class="form-group col-6">
                  <label>To</label>

                  <input
                    type="date"
                    class="form-control"
                    v-model="endDate"
                    @change="validateEndDate"
                    :disabled="startDate == ''"
                  />

                  <small class="text-danger" v-if="errors.endDate" v-text="errors.endDate"></small>
                </div>
              </div>

              <div class="d-flex justify-content-end text-right">
                <button class="btn btn-link" data-dismiss="modal">Close</button>

                <button
                  class="btn btn-purple-round"
                  @click.prevent="exportApplicants"
                  :disabled="Object.keys(errors).length > 0 || submitting || (startDate != '' && endDate == '')"
                  v-text="submitting ? 'Exporting...' : 'Export'"
                ></button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <!-- Export Modal -->
  </div>
</template>

<script>
import DataTable from "../../mixins/DataTables";
import Preloader from "../../components/Preloader";
import Pagination from "../../components/Pagination";

export default {
  components: { Preloader, Pagination },
  mixins: [DataTable],

  data() {
    return {
      url: "/cms/pages/applicants/records",
      perPage: 10,
      sortables: {
        career: "Applying For",
        name: "Full Name",
        contact: "Contact No.",
        email: "Email Address",
        address: "Address",
        created_at: "Date Applied",
        status: "Status",
      },
      sortedColumn: "created_at",
      order: "desc",
      selectedApplicant: {},
      statuses: [
        "pending",
        "processed",
        "interviewed",
        "hired",
        "rejected",
        "for reference",
      ],
      selectedStatus: "all",
      extraParams: "",
      form: {
        status: "",
      },
      isEdit: false,
      submitting: false,
      startDate: "",
      endDate: "",
      errors: {},
    };
  },

  computed: {
    exportUrl() {
      return `/cms/pages/applicants/export?column=${this.sortedColumn}&order=${this.order}&status=${this.selectedStatus}&startDate=${this.startDate}&endDate=${this.endDate}`;
    },
  },

  methods: {
    viewApplicant(applicant) {
      this.selectedApplicant = applicant;
      this.form.status = applicant.status;
      this.isEdit = false;
    },

    highlightKeyword(value) {
      if (this.filter) {
        const regex = new RegExp(this.filter, "gi");
        return value.replace(regex, function (str) {
          return `<strong class="text-dark">${str}</strong>`;
        });
      }

      return value;
    },

    filterBy(status) {
      this.selectedStatus = status;
      this.extraParams = `${
        status !== "all" ? `filterStatus=${this.selectedStatus}` : ""
      }`;
      this.fetchData();
    },

    cancel() {
      this.isEdit = false;
      this.form.status = this.selectedApplicant.status;
    },

    update() {
      if (this.form.status == this.selectedApplicant.status) {
        this.isEdit = false;
        return;
      }

      this.submitting = true;

      axios
        .put(`/cms/pages/applicants/${this.selectedApplicant.id}`, this.form)
        .then(({ data }) => {
          flash(data.success);
          this.submitting = false;
          this.isEdit = false;
          this.selectedApplicant.status = this.form.status;
          this.fetchData();
        })
        .catch(({ response }) => {
          flash(response.data.message);
        });
    },

    validateStartDate(event) {
      const selectedDate = this.moment(event.target.value).format("YYYY-MM-DD");
      const endDate = this.moment(this.endDate).format("YYYY-MM-DD");
      const dateNow = this.moment().format("YYYY-MM-DD");

      if (selectedDate > dateNow) {
        return this.$set(
          this.errors,
          "startDate",
          "The 'From' date must not be greater than today"
        );
      }

      if (selectedDate < endDate && selectedDate !== endDate) {
        this.$delete(this.errors, "endDate");
      }

      return this.$delete(this.errors, "startDate");
    },

    validateEndDate(event) {
      const selectedDate = this.moment(event.target.value).format("YYYY-MM-DD");
      const startDate = this.moment(this.startDate).format("YYYY-MM-DD");
      const dateNow = this.moment().format("YYYY-MM-DD");

      if (selectedDate > dateNow) {
        return this.$set(
          this.errors,
          "endDate",
          "The 'To' date must not be greater than today"
        );
      }

      if (selectedDate < startDate && selectedDate !== startDate) {
        return this.$set(
          this.errors,
          "endDate",
          "The 'To' date must not be less than 'From' date"
        );
      }

      return this.$delete(this.errors, "endDate");
    },

    viewExportModal() {
      this.startDate = "";
      this.endDate = "";
      this.errors = {};
    },

    exportApplicants() {
      this.submitting = true;

      setTimeout(() => {
        axios
          .get(this.exportUrl)
          .then(({ data }) => {
            window.location = this.exportUrl;
            $("#export-modal").modal("hide");
            flash("Export Success!");
          })
          .finally(() => {
            this.submitting = false;
          });
      }, 2000);
    },
  },
};
</script>

<style lang='scss' scoped>
.form-btn {
  border-radius: 100%;
  width: 2rem;
  height: 2rem;
}

.text-purple {
  color: #8a3d92;
}
</style>