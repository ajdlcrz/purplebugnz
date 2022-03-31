<template>
  <!-- Modal -->
  <div
    class="modal fade user-modal"
    id="user-modal"
    tabindex="-1"
    role="dialog"
    data-backdrop="static"
    data-keyboard="false"
  >
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-body">
          <div class="title">
            <h3 v-text="modalTitle"></h3>
          </div>
          <hr />

          <form method="post">
            <div class="form-row">
              <div class="form-group col-6">
                <label for="user-name">Name</label>

                <input
                  id="user-name"
                  type="text"
                  name="name"
                  :class="`form-control ${errors.name ? 'is-invalid' : ''}`"
                  v-model="form.name"
                />

                <div
                  class="invalid-feedback"
                  v-if="errors.name"
                  v-text="errors.name[0]"
                ></div>
              </div>

              <div class="form-group col-6">
                <label for="user-department">Department</label>

                <input
                  id="user-department"
                  type="text"
                  name="department"
                  :class="`form-control ${
                    errors.department ? 'is-invalid' : ''
                  }`"
                  v-model="form.department"
                />

                <div
                  class="invalid-feedback"
                  v-if="errors.department"
                  v-text="errors.department[0]"
                ></div>
              </div>
            </div>

            <div class="form-row">
              <div class="form-group col-6">
                <label for="user-email">Email Address</label>

                <input
                  id="user-email"
                  type="email"
                  name="email"
                  :class="`form-control ${errors.email ? 'is-invalid' : ''}`"
                  v-model="form.email"
                />

                <div
                  class="invalid-feedback"
                  v-if="errors.email"
                  v-text="errors.email[0]"
                ></div>
              </div>

              <div class="form-group col-6">
                <label for="user-role">Role</label>

                <select
                  id="user-role"
                  name="role"
                  :class="`form-control ${errors.role ? 'is-invalid' : ''}`"
                  v-model="form.role"
                  v-if="selectedUser.id !== 1"
                >
                  <option value disabled selected>Select Role</option>

                  <option
                    v-for="role in $parent.$parent.roles"
                    :key="role.id"
                    :value="role.id"
                    v-text="role.name"
                  ></option>
                </select>

                <select class="form-control" :value="form.role" disabled v-else>
                  <option
                    v-for="role in $parent.$parent.roles"
                    :key="role.id"
                    :value="role.id"
                    v-text="role.name"
                  ></option>
                </select>

                <div
                  class="invalid-feedback"
                  v-if="errors.role"
                  v-text="errors.role[0]"
                ></div>
              </div>
            </div>

            <div class="form-row">
              <div
                class="form-group col-6"
                v-if="Object.keys(selectedUser).length == 0"
              >
                <label for="user-password">Password</label>

                <div
                  :class="`d-flex border ${
                    errors.password ? 'is-invalid border-danger' : ''
                  }`"
                >
                  <input
                    id="user-password"
                    name="password"
                    class="form-control w-100 border-0"
                    :type="inputType"
                    v-model="form.password"
                  />
                  <button
                    type="button"
                    class="btn btn-link"
                    style="min-width: 0"
                    @click="changeInputType"
                  >
                    <span class="icon-eye"></span>
                  </button>
                </div>

                <div
                  class="invalid-feedback"
                  v-if="errors.password"
                  v-text="errors.password[0]"
                ></div>
              </div>

              <div class="form-group ml-auto">
                <div class="button-modal text-right">
                  <button
                    class="btn btn-link"
                    data-dismiss="modal"
                    @click="initialState"
                  >
                    Cancel
                  </button>

                  <button
                    class="btn btn-purple-round"
                    :disabled="disabled"
                    @click.prevent="submit"
                  >
                    Submit
                  </button>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <!-- Modal -->
</template>

<script>
export default {
  props: {
    selectedUser: { type: Object, required: false },
  },

  data() {
    return {
      inputType: "password",
      form: {
        name: "",
        department: "",
        email: "",
        role: "",
        password: "",
      },
      errors: {},
      disabled: false,
    };
  },

  watch: {
    selectedUser() {
      Object.keys(this.form).reduce((data, attribute) => {
        this.form[attribute] = this.selectedUser[attribute];

        return;
      }, {});

      this.form.role = this.selectedUser.role_id;
    },
  },

  computed: {
    modalTitle() {
      const title = Object.keys(this.selectedUser).length == 0 ? "Add" : "Edit";

      return `${title} User`;
    },
  },

  methods: {
    changeInputType() {
      this.inputType = this.inputType == "password" ? "text" : "password";
    },

    initialState() {
      Object.assign(this.$data, this.$options.data());
      this.$emit("removeSelectedUser");
    },

    submit() {
      this.disabled = true;

      const requestType =
        Object.keys(this.selectedUser).length == 0 ? "post" : "put";

      const path = `/cms/users${
        this.selectedUser.id ? "/" + this.selectedUser.id : ""
      }`;

      axios[requestType](path, this.form)
        .then(({ data }) => {
          flash(data.success);
          this.initialState();
          $("#user-modal").modal("hide");
          fetchData();
        })
        .catch(({ response }) => {
          this.errors = response.data.errors;
          this.disabled = false;
        });
    },
  },
};
</script>