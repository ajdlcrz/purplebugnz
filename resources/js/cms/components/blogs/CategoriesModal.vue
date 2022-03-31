<template>
  <div>
    <!-- Modal -->
    <div
      class="modal fade editCategory"
      id="editCategory"
      tabindex="-1"
      role="dialog"
      data-backdrop="static"
      @keyup.esc="cancel"
    >
      <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
          <div class="modal-body">
            <div class="title" style="color: #8a3d92">
              <h3 class="font-weight-bold">Category</h3>
            </div>
            <hr style="border-color: #8a3d92" />

            <div>
              <small>Manage categories here</small>
            </div>

            <div
              class="mb-2"
              v-for="(category, index) in categoryLists"
              :key="index"
            >
              <div
                :class="`d-flex border ${
                  categoryLists[index].errors &&
                  categoryLists[index].errors.title
                    ? 'is-invalid border-danger'
                    : ''
                }`"
              >
                <input
                  class="form-control w-100 border-0"
                  v-model="categoryLists[index].title"
                  @keydown.enter.prevent="saveCategory(category, index)"
                />

                <div class="d-flex">
                  <button
                    type="button"
                    class="btn btn-link"
                    style="min-width: 0"
                    v-if="category.id"
                    @click.prevent="saveCategory(category, index)"
                  >
                    <span class="icon-edit icon-edit--sm"></span>
                  </button>
                  <button
                    type="button"
                    class="btn btn-sm btn-link"
                    style="min-width: 0"
                    @click.prevent="deleteCategory(category, index)"
                  >
                    <span class="icon-delete icon-delete--sm"></span>
                  </button>
                </div>
              </div>

              <div
                class="invalid-feedback"
                v-if="
                  categoryLists[index].errors &&
                  categoryLists[index].errors.title
                "
                v-text="categoryLists[index].errors.title[0]"
              ></div>
            </div>

            <a
              href="#"
              class="d-flex justify-content-center align-items-center border p-1"
              @click="addCategory"
            >
              <span class="icon-addMore"></span>
            </a>
          </div>

          <div class="modal-footer">
            <button class="btn btn-cancel" data-dismiss="modal" @click="cancel">
              Cancel
            </button>

            <button class="btn btn-purple-round" @click="saveAll">Ok</button>
          </div>
        </div>
      </div>
    </div>
    <!-- Modal -->
  </div>
</template>

<script>
export default {
  props: ["categories"],

  data() {
    return {
      categoryLists: [],
      responses: [],
    };
  },

  watch: {
    categories(values) {
      this.categoryLists = JSON.parse(JSON.stringify(values));
      this.categoryLists.push({ name: "" });
    },
  },

  methods: {
    addCategory() {
      this.categoryLists.push({ name: "" });
    },

    async saveCategory(category, index, withFlash = true) {
      const url = category.hasOwnProperty("id") ? `/${category.id}` : "";
      const method = category.hasOwnProperty("id") ? "put" : "post";

      return await axios[method](`/cms/pages/categories${url}`, category)
        .then(({ data }) => {
          this.$delete(this.categoryLists[index], "errors");

          if (method == "post") {
            this.categoryLists[index] = data.category;

            this.categoryLists.push({ name: "" });
          }

          if (withFlash) {
            flash(data.success);
          }

          return this.responses.push("success");
        })
        .catch(({ response }) => {
          this.$set(this.categoryLists[index], "errors", response.data.errors);

          return this.responses.push("error");
        });
    },

    deleteCategory(category, index) {
      if (category.hasOwnProperty("id")) {
        return axios
          .delete(`/cms/pages/categories/${category.id}`)
          .then(({ data }) => {
            flash(data.success);
            this.$delete(this.categoryLists, index);
          });
      }

      this.$delete(this.categoryLists, index);
    },

    saveAll() {
      this.responses = [];

      Promise.all(
        this.categoryLists.map(async (category, index) => {
          await this.saveCategory(category, index, false);
        })
      ).then((response) => {
        if (!this.responses.some((res) => res == "error")) {
          flash("Updates Success");
          this.$parent.getCategories();
          $("#editCategory").modal("hide");
        }
      });
    },

    cancel() {
      this.$emit("cancel");
    },
  },
};
</script>

<style lang='scss' scoped>
input:read-only {
  background-color: transparent;
}

.icon-addMore {
  height: 2rem;
  width: 2rem;
}
</style>