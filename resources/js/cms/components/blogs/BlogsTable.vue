<template>
  <div id="blogsTable" class="position-relative mt-5">
    <preloader />

    <div class="cms-table-header">
      <div class="table-title">
        <h6 class="mb-0 font-weight-bold">List of Blogs</h6>
      </div>

      <div class="table-buttons">
        <router-link class="d-flex align-items-center" title="create" :to="{ name: 'BlogCreate' }">
          <span class="icon-add mr-2"></span>
          Add Blog
        </router-link>
      </div>
    </div>

    <table class="table table-hover cms-table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Title</th>
          <th>Category</th>
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
        <tr v-for="(blog, index) in tableData" :key="blog.id">
          <td>{{ ((currentPage - 1) * perPage) + (index + 1) }}</td>
          <td>{{ blog.title }}</td>
          <td>{{ blog.category.title }}</td>
          <td>{{ blog.published_at }}</td>
          <td class="cms-action-items">
            <a class="btn btn-link" title="view" :href="`/blog/${blog.slug}`" target="__blank">
              <span class="icon-view"></span>
            </a>

            <router-link
              class="btn btn-link"
              title="edit"
              :to="{ name: 'BlogEdit', params: { id: blog.id } }"
            >
              <span class="icon-edit"></span>
            </router-link>

            <confirm-delete-modal :item="blog" :url="`/cms/pages/blogs/${blog.id}`" />
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
