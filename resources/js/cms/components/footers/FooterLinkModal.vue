<template>
  <!-- Modal -->
  <div
    class="modal fade footer-modal"
    id="footer-modal"
    tabindex="-1"
    role="dialog"
    data-backdrop="static"
    data-keyboard="false"
  >
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-body">
          <div class="title" style="color: #8a3d92">
            <h3 v-text="modalTitle"></h3>
          </div>
          <hr style="border-color: #8a3d92" />

          <form method="post">
            <div class="form-group row">
              <label class="col-sm-3 col-form-label">Title</label>

              <div class="col-sm-9">
                <div class="row justify-content-end mr-0">
                  <input
                    type="text"
                    :class="`col-md-10 form-control ${
                      errors.title ? 'is-invalid' : ''
                    }`"
                    v-model="form.title"
                  />
                </div>

                <div
                  class="d-flex justify-content-end invalid-feedback"
                  v-if="errors.title"
                  v-text="errors.title[0]"
                ></div>
              </div>
            </div>

            <div class="form-group row">
              <label class="col-sm-3 col-form-label">Url</label>

              <div class="col-sm-9">
                <div class="row align-items-center mr-0">
                  <div class="col-md-2">
                    <input
                      type="radio"
                      value="select"
                      v-model="selectedOption"
                    />
                  </div>

                  <select
                    :class="`col-md-10 form-control ${
                      errors.url ? 'is-invalid' : ''
                    }`"
                    v-if="selectedOption == 'select'"
                    v-model="form.url"
                  >
                    <option value disabled selected>
                      Select Page Destination
                    </option>

                    <option
                      v-for="(page, index) in pages"
                      :key="index"
                      :value="page.url"
                      v-text="page.name"
                    ></option>
                  </select>

                  <select
                    class="col-md-10 form-control"
                    value="null"
                    disabled
                    v-else
                  >
                    <option value="null" selected>
                      Select Page Destination
                    </option>
                  </select>
                </div>

                <div class="row align-items-center mt-2 mr-0">
                  <div class="col-md-2">
                    <input
                      type="radio"
                      value="input"
                      v-model="selectedOption"
                    />
                  </div>

                  <input
                    type="text"
                    :class="`col-md-10 form-control ${
                      errors.url ? 'is-invalid' : ''
                    }`"
                    v-if="selectedOption == 'input'"
                    v-model="form.url"
                  />

                  <input
                    type="text"
                    class="col-md-10 form-control"
                    disabled
                    v-else
                  />
                </div>

                <small
                  class="d-flex justify-content-end text-danger"
                  v-if="errors.url"
                  v-text="errors.url[0]"
                ></small>
              </div>
            </div>

            <div
              class="form-row mt-4 pt-4"
              style="border-top: 1px solid #8a3d92"
            >
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
    selectedFooter: { type: Object, required: false },
  },

  data() {
    return {
      form: {
        title: "",
        url: "",
      },
      pages: [
        {
          name: "About Us",
          url: `${location.origin}/about-us`,
        },
        {
          name: "Services",
          url: `${location.origin}/services`,
        },
        {
          name: "Blogs",
          url: `${location.origin}/blogs`,
        },
        {
          name: "Contact Us",
          url: `${location.origin}/contact-us`,
        },
        {
          name: "Careers",
          url: `${location.origin}/careers`,
        },
      ],
      errors: {},
      disabled: false,
      selectedOption: "input",
    };
  },

  watch: {
    selectedFooter(values) {
      if (Object.keys(values).length > 0) {
        Object.keys(this.form).reduce((data, attribute) => {
          this.form[attribute] = this.selectedFooter[attribute];

          return;
        }, {});

        this.pages.map((page) => {
          if (page.url == this.form.url) {
            return (this.selectedOption = "select");
          }
        });
      }
    },
  },

  computed: {
    modalTitle() {
      const title =
        Object.keys(this.selectedFooter).length == 0 ? "Add" : "Edit";

      return `${title} Link`;
    },
  },

  methods: {
    initialState() {
      Object.assign(this.$data, this.$options.data());
      this.$emit("removeSelectedFooter");
    },

    submit() {
      this.disabled = true;

      const requestType =
        Object.keys(this.selectedFooter).length == 0 ? "post" : "put";

      const path = `/cms/pages/footer-links${
        this.selectedFooter.id ? "/" + this.selectedFooter.id : ""
      }`;

      axios[requestType](path, this.form)
        .then(({ data }) => {
          flash(data.success);
          this.initialState();
          $("#footer-modal").modal("hide");
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

<style scoped>
input[type="radio"] {
  border: 1px solid #8a3d92;
  border-radius: 5px;
  padding: 0.5em;
  -webkit-appearance: none;
}

input[type="radio"]:checked {
  background-color: #8a3d92;
}

input[type="radio"]:focus {
  outline-color: transparent;
}
</style>