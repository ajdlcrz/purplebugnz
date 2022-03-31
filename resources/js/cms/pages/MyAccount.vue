<template>
  <div class="cms-page-wrapper">
    <div class="cms-page">
      <div class="header-title mb-4">
        <h1>My Account</h1>
      </div>

      <form>
        <div class="form-row mb-3">
          <div class="col-md-3">
            <label>Name</label>
            <input
              type="text"
              class="form-control"
              disabled
              :value="$auth.name"
            />
          </div>

          <div class="col-md-3">
            <label>Department Name</label>
            <input
              type="text"
              class="form-control"
              disabled
              :value="$auth.department"
            />
          </div>
        </div>

        <div class="form-row mb-3">
          <div class="col-md-3">
            <label>Email Address</label>
            <input
              type="text"
              class="form-control"
              disabled
              :value="$auth.email"
            />
          </div>

          <div class="col-md-3">
            <label>Role</label>
            <select class="form-control" disabled :value="$auth.role_id">
              <option value disabled selected>Select Role</option>

              <option
                v-for="role in roles"
                :key="role.id"
                :value="role.id"
                v-text="role.name"
              ></option>
            </select>
          </div>
        </div>

        <div class="form-row">
          <div class="col-md-6">
            <label>Password</label>

            <div class="form-inline">
              <input type="text" class="form-control col-md-6" disabled />

              <button
                type="button"
                class="btn btn-link"
                style="color: #8a3d92"
                data-toggle="modal"
                data-target="#password-modal"
              >
                Change Password
              </button>
            </div>
          </div>
        </div>
      </form>
    </div>

    <!-- Modal -->
    <div
      class="modal fade password-modal"
      id="password-modal"
      tabindex="-1"
      role="dialog"
      data-backdrop="static"
      data-keyboard="false"
    >
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-body">
            <div class="title" style="color: #8a3d92">
              <h3>Change Password</h3>
            </div>
            <hr style="border-color: #8a3d92" />

            <form method="post">
              <div class="form-row">
                <div class="form-group col-6">
                  <label>Old Password</label>

                  <input
                    type="password"
                    :class="`form-control ${
                      errors.old_password ? 'is-invalid' : ''
                    }`"
                    v-model="form.old_password"
                  />

                  <div
                    class="invalid-feedback"
                    v-if="errors.old_password"
                    v-text="errors.old_password[0]"
                  ></div>
                </div>

                <div class="form-group col-6">
                  <label>New Password</label>

                  <input
                    type="password"
                    :class="`form-control ${
                      errors.new_password ? 'is-invalid' : ''
                    }`"
                    v-model="form.new_password"
                  />

                  <div
                    class="invalid-feedback"
                    v-if="errors.new_password"
                    v-text="errors.new_password[0]"
                  ></div>
                </div>
              </div>

              <div class="form-group ml-auto">
                <div class="button-modal text-right">
                  <button
                    class="btn btn-cancel"
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
            </form>
          </div>
        </div>
      </div>
    </div>
    <!-- Modal -->
  </div>
</template>

<script>
export default {
  props: {
    roles: { type: Array, required: true },
  },

  data() {
    return {
      form: {
        old_password: "",
        new_password: "",
      },
      errors: {},
      disabled: false,
    };
  },

  methods: {
    initialState() {
      Object.assign(this.$data, this.$options.data());
    },

    submit() {
      this.disabled = true;

      axios
        .put("/cms/my-account", this.form)
        .then(({ data }) => {
          this.disabled = false;
          flash(data.success);
          this.initialState();
          $("#password-modal").modal("hide");
        })
        .catch(({ response }) => {
          this.disabled = false;
          this.errors = response.data.errors;
        });
    },
  },
};
</script>

<style lang='scss' scoped>
/*  */
</style>