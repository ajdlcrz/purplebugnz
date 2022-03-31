<template>
  <div class="mt-4">
    <preloader />

    <table class="table table-hover cms-table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Name</th>
          <th>User Role</th>
          <th>Department</th>
          <th>Action</th>
        </tr>
      </thead>

      <tbody v-if="tableData.length === 0">
        <tr>
          <td class="lead text-center" colspan="5">No data found.</td>
        </tr>
      </tbody>

      <tbody v-else>
        <tr v-for="user in tableData" :key="user.id">
          <td>{{ user.customId }}</td>
          <td>{{ user.name }}</td>
          <td>{{ user.role.name }}</td>
          <td>{{ user.department }}</td>
          <td class="cms-action-items">
            <button
              title="edit"
              class="btn btn-link"
              data-toggle="modal"
              data-target="#user-modal"
              @click="editUser(user)"
            >
              <span class="icon-edit"></span>
            </button>

            <confirm-delete-modal
              :item="user"
              :url="`/cms/users/${user.id}`"
              :confirmPassword="true"
            />
          </td>
        </tr>
      </tbody>
    </table>

    <div class="pagination-container">
      <pagination />
    </div>

    <user-form-modal
      :selectedUser="selectedUser"
      @removeSelectedUser="selectedUser = {}"
    />
  </div>
</template>

<script>
import DataTable from "../../mixins/DataTables";
import Preloader from "../Preloader";
import Pagination from "../Pagination";
import UserFormModal from "./UserFormModal.vue";
import ConfirmDeleteModal from "../ConfirmDeleteModal";

export default {
  mixins: [DataTable],
  components: { Preloader, Pagination, UserFormModal, ConfirmDeleteModal },

  data() {
    return {
      perPage: 5,
      selectedUser: {},
    };
  },

  methods: {
    editUser(user) {
      this.selectedUser = user;
    },
  },
};
</script>

<style scoped>
/*  */
</style>