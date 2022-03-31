<template>
  <div class="user-management mt-4">
    <div class="row no-gutters">
      <div class="col-md-11">
        <div class="user-management-header d-flex">
          <div class="title">
            <h1>User Management</h1>
          </div>

          <div class="right-side">
            <ul>
              <li>
                <a
                  class="d-flex align-items-center"
                  href="#"
                  data-toggle="modal"
                  data-target="#user-modal"
                >
                  <span class="icon-addaccount mr-2"></span>
                  Add Accounts
                </a>
              </li>
            </ul>
          </div>
        </div>

        <!-- {{-- Start Table --}} -->
        <users-table fetch-url="/cms/users/records"></users-table>
        <!-- {{-- End Table --}} -->
      </div>
    </div>
  </div>
</template>

<script>
import UsersTable from "../components/users/UsersTable.vue";

export default {
  props: {
    roles: { type: Array, required: true },
  },
  components: { UsersTable },

  data() {
    return {
      //
    };
  },
};
</script>

<style scoped>
/*  */
</style>