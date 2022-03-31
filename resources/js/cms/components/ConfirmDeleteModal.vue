<template>
  <div>
    <button
      title="delete"
      class="btn btn-link"
      data-toggle="modal"
      :data-target="`#confirm-delete-modal-${item.id}`"
    >
      <span class="icon-delete"></span>
    </button>

    <div
      class="modal fade confirm-delete-modal"
      :id="`confirm-delete-modal-${item.id}`"
      tabindex="-1"
      role="dialog"
      data-backdrop="static"
      data-keyboard="false"
    >
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title font-weight-bold">Delete {{ itemName }}</h5>
          </div>

          <div class="modal-body">
            <p>Are you sure you wanted to delete this item?</p>

            <form method="post" @keydown.enter.prevent="deleteItem">
              <div class="form-group" v-if="withPassword">
                <label>Please type your password</label>

                <div
                  :class="`d-flex border ${
                    errors.password ? 'is-invalid border-danger' : ''
                  }`"
                >
                  <input
                    :type="inputType"
                    class="form-control w-100 border-0"
                    v-model="password"
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

              <div class="form-group">
                <div class="text-center">
                  <button
                    class="btn btn-link"
                    data-dismiss="modal"
                    @click.prevent="resetData"
                  >
                    Cancel
                  </button>

                  <button
                    class="btn btn-purple-round"
                    :disabled="disabled"
                    @click.prevent="deleteItem"
                  >
                    Proceed
                  </button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ["item", "url", "confirmPassword"],

  data() {
    return {
      withPassword: this.confirmPassword ?? false,
      inputType: "password",
      password: "",
      errors: {},
      disabled: false,
    };
  },

  computed: {
    itemName() {
      return this.item.name ?? this.item.title;
    },
  },

  methods: {
    changeInputType() {
      this.inputType = this.inputType == "password" ? "text" : "password";
    },

    resetData() {
      this.password = "";
      this.errors = {};
      this.disabled = false;
    },

    deleteItem() {
      const data = {
        password: this.password,
      };

      axios
        .delete(this.url, { data })
        .then(({ data }) => {
          flash(data.success);
          this.resetData();
          $(`#confirm-delete-modal-${this.item.id}`).modal("hide");
          fetchData();
        })
        .catch(({ response }) => {
          this.errors = response.data.errors;
        });
    },
  },
};
</script>

<style scoped>
/*  */
</style>