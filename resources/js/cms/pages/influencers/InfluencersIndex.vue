<template>
  <div class="cms-page-wrapper">
    <div class="cms-page">
      <!-- datatable -->
      <div class="position-relative mt-5">
        <preloader />

        <div class="cms-table-header">
          <div class="table-title">
            <h6 class="mb-0 font-weight-bold">List of Influencers</h6>
          </div>

          <div class="table-buttons">
            <a
              :href="`/cms/pages/influencers/export/${sortedColumn}/${order}`"
              class="text-nowrap d-flex align-items-center"
            >
              <span class="icon-export mr-2"></span>
              Export
            </a>

            <div class="dropdown text-nowrap">
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
                  :class="`dropdown-item d-flex justify-content-between ${sortedColumn === key ? 'text-purple' : ''}`"
                  v-for="(column, key) in sortables"
                  :key="key"
                  @click.prevent="sortByColumn(key)"
                >
                  {{ column | columnHead }}
                  <span
                    class="ml-2"
                    v-if="sortedColumn === key"
                  >
                    <span v-if="order === 'asc'">&#x2934;</span>
                    <span v-else>&#x2935;</span>
                  </span>
                </button>
              </div>
            </div>

            <input
              type="text"
              class="form-control"
              placeholder="Search Influencers"
              v-model="filter"
              @keydown.enter="fetchData()"
              style="min-width: 200px;"
            />
          </div>
        </div>

        <table class="table table-hover cms-table">
          <thead>
            <tr>
              <th
                :class="`align-middle text-nowrap ${sortedColumn === key ? 'text-purple' : ''}`"
                v-for="(column, key) in sortables"
                :key="key"
                v-text="$options.filters.columnHead(column)"
              >
              </th>
              <th class="align-middle">Content Types</th>
              <th class="align-middle">Action</th>
            </tr>
          </thead>

          <tbody v-if="tableData.length === 0">
            <tr>
              <td
                class="lead text-center"
                colspan="8"
              >No data found.</td>
            </tr>
          </tbody>

          <tbody v-else>
            <tr
              v-for="(influencer) in tableData"
              :key="influencer.id"
            >
              <td v-html="highlightKeyword(moment(influencer.created_at).format('YYYY-MM-DD'))"></td>
              <td v-html="highlightKeyword(influencer.name)"></td>
              <td v-html="highlightKeyword(influencer.email)"></td>
              <td v-html="highlightKeyword(influencer.age)"></td>
              <td
                class="text-capitalize text-nowrap"
                v-html="highlightKeyword(influencer.sex)"
              ></td>
              <td v-html="highlightKeyword(influencer.contact_number)"></td>
              <td v-html="highlightKeyword(influencer.total_followers)"></td>
              <td>
                <span
                  v-for="(status, category) in influencer.content_category"
                  :key="category"
                >
                  <small
                    v-if="status && category !== 'others'"
                    v-text="` | ${category}`"
                  ></small>
                  <small
                    v-else-if="category == 'others' && influencer.content_category['others']"
                    v-text="` | ${status}`"
                  ></small>
                </span>
              </td>

              <td class="cms-action-items">
                <button
                  title="view"
                  class="btn btn-link"
                  data-toggle="modal"
                  data-target="#influencer-modal"
                  @click="viewSocMeds(influencer)"
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
      <!-- datatable -->
    </div>

    <!-- Influencer Modal -->
    <div
      id="influencer-modal"
      class="modal fade applicant-modal"
      tabindex="-1"
    >
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header border-0">
            <h4
              class="modal-title font-weight-bold"
              v-text="selectedInfluencer.name"
            ></h4>
          </div>

          <div class="modal-body">
            <div
              class="row"
              v-if="Object.keys(selectedInfluencer).length > 0"
            >
              <div class="col-12 pb-3 border-bottom">
                <h5>Facebook</h5>

                <div class="d-flex mt-3">
                  <small class="c-font--purple">
                    <strong>Page URL:</strong>
                  </small>

                  <div class="ml-2 small">
                    <span
                      v-if="selectedInfluencer.facebook.page_url == 'n/a' || selectedInfluencer.facebook.page_url == 'N/A'"
                      v-text="selectedInfluencer.facebook.page_url"
                    ></span>
                    <a
                      href="selectedInfluencer.facebook.page_url"
                      target="__blank"
                      rel="noopener noreferrer"
                      v-text="selectedInfluencer.facebook.page_url"
                      v-else
                    ></a>

                  </div>
                </div>

                <div class="d-flex">
                  <small class="c-font--purple"><strong>Post rate:</strong></small>
                  <div
                    class="ml-2 small"
                    v-text="selectedInfluencer.facebook.post_rate"
                  ></div>
                </div>
              </div>

              <div class="col-12 mt-3 pb-3 border-bottom">
                <h5>Instagram</h5>

                <div class="d-flex mt-3">
                  <small class="c-font--purple"><strong>Page URL:</strong></small>

                  <div class="ml-2 small">
                    <span
                      v-text="selectedInfluencer.instagram.page_url"
                      v-if="selectedInfluencer.instagram.page_url == 'n/a' || selectedInfluencer.instagram.page_url == 'N/A'"
                    ></span>
                    <a
                      href="selectedInfluencer.instagram.page_url"
                      target="__blank"
                      rel="noopener noreferrer"
                      v-text="selectedInfluencer.instagram.page_url"
                      v-else
                    ></a>
                  </div>
                </div>

                <div class="d-flex">
                  <small class="c-font--purple"><strong>Post rate:</strong></small>
                  <div
                    class="ml-2 small"
                    v-text="selectedInfluencer.instagram.post_rate"
                  ></div>
                </div>

                <div class="d-flex">
                  <small class="c-font--purple"><strong>Video Post rate:</strong></small>
                  <div
                    class="ml-2 small"
                    v-text="selectedInfluencer.instagram.video_post_rate"
                  ></div>
                </div>
              </div>

              <div class="col-12 mt-3 pb-3 border-bottom">
                <h5>Youtube</h5>

                <div class="d-flex mt-3">
                  <small class="c-font--purple"><strong>Page URL:</strong></small>

                  <div class="ml-2 small">
                    <span
                      v-if="selectedInfluencer.youtube.page_url == 'n/a' || selectedInfluencer.youtube.page_url == 'N/A'"
                      v-text="selectedInfluencer.youtube.page_url"
                    ></span>
                    <a
                      href="selectedInfluencer.youtube.page_url"
                      target="__blank"
                      rel="noopener noreferrer"
                      v-text="selectedInfluencer.youtube.page_url"
                      v-else
                    ></a>

                  </div>
                </div>

                <div class="d-flex">
                  <small class="c-font--purple"><strong>Post rate:</strong></small>
                  <div
                    class="ml-2 small"
                    v-text="selectedInfluencer.youtube.post_rate"
                  ></div>
                </div>
              </div>

              <div class="col-12 mt-3">
                <h5>Tiktok</h5>

                <div class="d-flex mt-3">
                  <small class="c-font--purple"><strong>Page URL:</strong></small>

                  <div class="ml-2 small">
                    <span
                      v-text="selectedInfluencer.tiktok.page_url"
                      v-if="selectedInfluencer.tiktok.page_url == 'n/a' || selectedInfluencer.tiktok.page_url == 'N/A'"
                    ></span>
                    <a
                      href="selectedInfluencer.tiktok.page_url"
                      target="__blank"
                      rel="noopener noreferrer"
                      v-else
                      v-text="selectedInfluencer.tiktok.page_url"
                    ></a>
                  </div>
                </div>

                <div class="d-flex">
                  <small class="c-font--purple"><strong>Post rate:</strong></small>
                  <div
                    class="ml-2 small"
                    v-text="selectedInfluencer.tiktok.post_rate"
                  ></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Influencer Modal -->
  </div>
</template>

<script>
import DataTable from "../../mixins/DataTables";
import Preloader from "../../components/Preloader";
import Pagination from "../../components/Pagination";

export default {
  mixins: [DataTable],
  components: { Preloader, Pagination },

  data() {
    return {
      url: "/cms/pages/influencers/records",
      perPage: 10,
      sortables: {
        created_at: "Date Registered",
        name: "Name",
        email: "Email",
        age: "Age",
        sex: "Sex",
        contact_number: "Contact No.",
        total_followers: "Total Followers (est.)",
      },
      sortedColumn: "created_at",
      order: "desc",
      selectedInfluencer: {}
    };
  },

  methods: {
    highlightKeyword(value) {
      if (this.filter) {
        const regex = new RegExp(this.filter, "gi");
        return value.replace(regex, function (str) {
          return `<strong class="text-dark">${str}</strong>`;
        });
      }

      return value;
    },

    viewSocMeds(influencer) {
      this.selectedInfluencer = influencer;
    },
  }
};
</script>
