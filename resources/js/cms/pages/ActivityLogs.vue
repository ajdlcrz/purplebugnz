<template>
  <div class="activity-logs mt-4">
    <div class="row no-gutters">
      <div class="col-md-11">
        <div class="activity-logs-header d-flex align-items-end">
          <div class="title">
            <h1>Activity Log</h1>
          </div>

          <div class="right-side">
            <ul>
              <li>
                <a :href="`/cms/activities/export/${sortedColumn}/${order}`">
                  <span class="icon-export"></span>
                  Export
                </a>
              </li>

              <li>
                <div class="dropdown">
                  <a
                    type="button"
                    class="d-flex align-items-center"
                    data-toggle="dropdown"
                  >
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
              </li>

              <li class="px-0">
                <a href="#" @click.prevent="fetchData()">
                  <span class="icon-reload"></span>
                </a>
              </li>
            </ul>
          </div>
        </div>

        <div class="content mt-5">
          <div class="title mb-4">
            <h2><span class="icon-activities-alt"></span> Recent Activities</h2>
          </div>

          <preloader />

          <table class="table table-hover cms-table">
            <thead>
              <tr>
                <th>Logged In</th>
                <th>User ID</th>
                <th>Activity Date and Time</th>
                <th>Activity Description</th>
                <th>IP Address</th>
                <th>Action</th>
              </tr>
            </thead>

            <tbody v-if="tableData.length === 0">
              <tr>
                <td class="lead text-center" colspan="6">No data found.</td>
              </tr>
            </tbody>

            <tbody v-else>
              <tr v-for="activity in tableData" :key="activity.id">
                <td>
                  <p
                    v-if="
                      ['Logged In', 'Logged Out'].includes(activity.description)
                    "
                    v-text="activity.created_at"
                  ></p>
                  <p v-else>N/A</p>
                </td>
                <td>{{ activity.custom_id }}</td>
                <td>{{ activity.created_at }}</td>
                <td>
                  {{ activity.description }}
                  <span
                    class="text-capitalize font-weight-bold"
                    style="color: #8a3d92"
                  >
                    {{ activity.subject | activityDescription }}
                  </span>
                </td>
                <td>{{ activity.causer_ip }}</td>
                <td class="cms-action-items">
                  <button
                    title="view"
                    class="btn btn-link"
                    data-toggle="modal"
                    data-target="#activity-log"
                    @click="viewActivity(activity)"
                  >
                    <span class="icon-view"></span>
                  </button>
                </td>
              </tr>
            </tbody>
          </table>

          <div class="pagination-container">
            <pagination />
          </div>
        </div>
      </div>
    </div>

    <!-- Modal -->
    <div
      class="modal fade activity-log-modal"
      id="activity-log"
      tabindex="-1"
      role="dialog"
      aria-labelledby="activity-logLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-body">
            <div class="title">
              <h3>Activity Log</h3>
            </div>

            <hr />

            <div class="contents">
              <div class="row">
                <div class="col-4">
                  <div class="right">
                    <p>User ID</p>
                  </div>
                </div>
                <div class="col-8">
                  <div class="left">
                    <p v-text="selectedActivity.custom_id"></p>
                  </div>
                </div>

                <div class="col-4">
                  <div class="right">
                    <p>Name</p>
                  </div>
                </div>
                <div class="col-8">
                  <div class="left">
                    <p v-text="selectedActivity.causer_name"></p>
                  </div>
                </div>

                <div class="col-4">
                  <div class="right">
                    <p>IP Address</p>
                  </div>
                </div>
                <div class="col-8">
                  <div class="left">
                    <p v-text="selectedActivity.causer_ip"></p>
                  </div>
                </div>
              </div>

              <hr />

              <div class="row">
                <div class="col-4">
                  <div class="right">
                    <p>Logged In</p>
                  </div>
                </div>
                <div class="col-8">
                  <div class="left">
                    <p
                      v-if="selectedActivity.description === 'Logged In'"
                      v-text="selectedActivity.created_at"
                    ></p>
                    <p v-else>N/A</p>
                  </div>
                </div>

                <div class="col-4">
                  <div class="right">
                    <p>Logged Out</p>
                  </div>
                </div>
                <div class="col-8">
                  <div class="left">
                    <p
                      v-if="selectedActivity.description === 'Logged Out'"
                      v-text="selectedActivity.created_at"
                    ></p>
                    <p v-else>N/A</p>
                  </div>
                </div>

                <div class="col-4">
                  <div class="right">
                    <p>Activity Date and Time</p>
                  </div>
                </div>
                <div class="col-8">
                  <div class="left">
                    <p v-text="selectedActivity.created_at"></p>
                  </div>
                </div>

                <div class="col-4">
                  <div class="right">
                    <p>Activity Description</p>
                  </div>
                </div>
                <div class="col-8">
                  <div class="left">
                    <p v-text="selectedActivity.description"></p>
                  </div>
                </div>

                <div class="col-4">
                  <div class="right">
                    <p>Value Before</p>
                  </div>
                </div>
                <div class="col-8">
                  <div
                    class="left"
                    v-if="
                      selectedActivity.hasOwnProperty('properties') &&
                      selectedActivity.properties.hasOwnProperty('old')
                    "
                  >
                    <!-- <pre v-text="selectedActivity.properties.old"></pre> -->

                    <div
                      v-for="(value, attribute) in selectedActivity.properties
                        .old"
                      :key="attribute"
                    >
                      <div v-if="attribute == 'seo'">
                        <p v-for="(seo, tag) in value" :key="tag">
                          <span class="font-weight-bold"> {{ tag }}: </span>
                          {{ seo }}
                        </p>
                      </div>

                      <div v-else>
                        <span class="font-weight-bold"> {{ attribute }}: </span>
                        {{ value }}
                      </div>
                    </div>
                  </div>
                  <div class="left" v-else>
                    <p>N/A</p>
                  </div>
                </div>

                <div class="col-4">
                  <div class="right">
                    <p>Value After</p>
                  </div>
                </div>
                <div class="col-8">
                  <div
                    class="left"
                    v-if="
                      selectedActivity.hasOwnProperty('properties') &&
                      selectedActivity.properties.hasOwnProperty('attributes')
                    "
                  >
                    <!-- <pre v-text="selectedActivity.properties.attributes"></pre> -->

                    <div
                      v-for="(value, attribute) in selectedActivity.properties
                        .attributes"
                      :key="attribute"
                    >
                      <div v-if="attribute == 'seo'">
                        <p v-for="(seo, tag) in value" :key="tag">
                          <span class="font-weight-bold"> {{ tag }}: </span>
                          {{ seo }}
                        </p>
                      </div>

                      <div v-else>
                        <span class="font-weight-bold"> {{ attribute }}: </span>
                        {{ value }}
                      </div>
                    </div>
                  </div>

                  <div class="left" v-else>
                    <p>N/A</p>
                  </div>
                </div>
              </div>

              <hr />

              <div class="row justify-content-end no-gutters">
                <button
                  class="btn btn-outline-purple-round"
                  data-dismiss="modal"
                >
                  Close
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Modal -->
  </div>
</template>

<script>
import DataTable from "../mixins/DataTables";
import Preloader from "../components/Preloader";
import Pagination from "../components/Pagination";

export default {
  components: { Preloader, Pagination },
  mixins: [DataTable],

  data() {
    return {
      url: "/cms/activities/records",
      perPage: 5,
      sortables: {
        causer_id: "User ID",
        created_at: "Activity Date and Time",
        description: "Activity Description",
        causer_ip: "IP Address",
      },
      sortedColumn: "created_at",
      order: "desc",
      selectedActivity: {},
    };
  },

  filters: {
    activityDescription(subject) {
      if (!subject) return "";

      let value = "";

      if (subject.hasOwnProperty("title")) {
        value = subject.title;
      } else if (subject.hasOwnProperty("name")) {
        value = subject.name;
      } else if (subject.hasOwnProperty("page")) {
        value = `${subject.section.replace("_", " ")} from ${
          subject.page
        } page`;
      }

      return value;
    },
  },

  methods: {
    viewActivity(activity) {
      this.selectedActivity = activity;
    },
  },
};
</script>

<style scoped>
/*  */
</style>