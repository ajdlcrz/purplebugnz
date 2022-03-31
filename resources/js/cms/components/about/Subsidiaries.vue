<template>
  <div class="partners-container">
    <div
      class="card mb-3"
      v-for="(subsidiary, index) in subsidiaries"
      :key="index"
    >
      <div class="card-body row">
        <div class="col-md-3 d-flex flex-column">
          <label>Image</label>

          <div class="partner-image mb-2">
            <img
              class="img-fluid"
              :src="`${subsidiaries[index].tempImage}`"
              v-if="fileInstance(subsidiaries[index].image)"
            />

            <img
              class=""
              :src="`${
                subsidiaries[index].image
                  ? `${subsidiaries[index].imagePath}`
                  : ''
              }`"
              v-else
            />
          </div>

          <!-- upload button -->
          <div
            class="d-flex border"
            v-if="fileInstance(subsidiaries[index].image)"
          >
            <input
              type="text"
              class="form-control w-100 border-0"
              readonly
              :ref="`subsidiaryImage_${index}`"
              :value="subsidiaries[index].image.name"
            />

            <button
              type="button"
              class="btn btn-link"
              style="min-width: 0"
              @click="removeSubsidiaryImg(index)"
            >
              <span>✖</span>
            </button>
          </div>

          <label v-else>
            <button
              class="btn btn-outline-purple-round w-100"
              @click.prevent="selectSubsidiaryImg(index)"
            >
              Upload
            </button>

            <input
              class="d-none"
              name="file"
              type="file"
              :ref="`subsidiaryImage_${index}`"
              @change="onSubsidiaryImgPick($event, index)"
            />
          </label>

          <small>Max of 2mb only</small>
          <small>170x170 px jpg or png</small>
          <small
            class="text-danger"
            v-if="
              subsidiaries[index].errors && subsidiaries[index].errors.image
            "
            v-text="subsidiaries[index].errors.image[0]"
          ></small>
        </div>

        <div class="col-md-9 row">
          <div class="col-md-5">
            <div class="form-group">
              <label>Title</label>

              <input
                type="text"
                :class="`form-control ${
                  subsidiaries[index].errors && subsidiaries[index].errors.title
                    ? 'is-invalid'
                    : ''
                }`"
                v-model="subsidiaries[index].title"
              />

              <div
                class="invalid-feedback"
                v-if="
                  subsidiaries[index].errors && subsidiaries[index].errors.title
                "
                v-text="subsidiaries[index].errors.title[0]"
              ></div>
            </div>

            <div class="form-group">
              <label>Link</label>

              <input
                type="text"
                :class="`form-control ${
                  subsidiaries[index].errors && subsidiaries[index].errors.link
                    ? 'is-invalid'
                    : ''
                }`"
                v-model="subsidiaries[index].link"
              />

              <div
                class="invalid-feedback"
                v-if="
                  subsidiaries[index].errors && subsidiaries[index].errors.link
                "
                v-text="subsidiaries[index].errors.link[0]"
              ></div>
            </div>

            <div class="form-group">
              <label>Alt Text</label>

              <input
                type="text"
                :class="`form-control ${
                  subsidiaries[index].errors &&
                  subsidiaries[index].errors.alt_text
                    ? 'is-invalid'
                    : ''
                }`"
                v-model="subsidiaries[index].alt_text"
              />

              <div
                class="invalid-feedback"
                v-if="
                  subsidiaries[index].errors &&
                  subsidiaries[index].errors.alt_text
                "
                v-text="subsidiaries[index].errors.alt_text[0]"
              ></div>
            </div>
          </div>

          <div class="col-md-7">
            <div class="form-group">
              <label>Body</label>

              <tinymce-editor
                api-key="q5eqi5jopju01p1l2xpwn411by2u4oxvo9men2va1eey6m4w"
                rows="5"
                :init="tinymceInit()"
                v-model="subsidiaries[index].body"
              ></tinymce-editor>

              <small
                class="text-danger"
                v-if="
                  subsidiaries[index].errors && subsidiaries[index].errors.body
                "
                v-text="subsidiaries[index].errors.body[0]"
              ></small>

              <div class="d-flex justify-content-end mt-3">
                <button
                  class="btn btn-remove"
                  @click.prevent="deleteSubsidiary(subsidiary)"
                >
                  <span class="icon-remove"></span>
                  Remove
                </button>

                <button
                  class="btn btn-cancel"
                  @click.prevent="initialData(subsidiary)"
                >
                  Cancel
                </button>
                <button
                  class="btn btn-purple-round ml-2"
                  @click.prevent="saveSubsidiary(subsidiary)"
                >
                  Save
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="card card-addMore mb-3">
      <button class="btn-addMore" @click="addSubsidiary">
        <span class="icon-addMore"></span>
        <h3 class="mt-2 mb-0">Add</h3>
      </button>
    </div>
  </div>
</template>

<script>
import Editor from "@tinymce/tinymce-vue";
import Wysiwyg from "../../mixins/Wysiwyg";

export default {
  components: {
    "tinymce-editor": Editor,
  },
  mixins: [Wysiwyg],

  data() {
    return {
      subsidiaries: [],
    };
  },

  created() {
    axios
      .get("/cms/pages/subsidiaries/records")
      .then(({ data }) => {
        const subsidiaries = Object.values(data.subsidiaries).map(
          (subsidiary, i) => {
            subsidiary.originalData = { ...subsidiary };

            return subsidiary;
          }
        );

        this.subsidiaries = subsidiaries;
      })
      .catch(({ response }) => {
        flash(response.data.message);
      });
  },

  methods: {
    addSubsidiary() {
      this.subsidiaries.push({
        image: "",
        title: "",
        link: "",
        alt_text: "",
        body: "",
      });
    },

    initialData(subsidiary) {
      const index = this.subsidiaries.indexOf(subsidiary);
      const originalData = this.subsidiaries[index].originalData;

      if (originalData) {
        if (this.subsidiaries[index].errors) {
          this.subsidiaries[index].errors = "";
        }

        return Object.keys(originalData).map((attribute) => {
          this.subsidiaries[index][attribute] = originalData[attribute];
        });
      }

      return Object.keys(this.subsidiaries[index]).map((attribute) => {
        this.subsidiaries[index][attribute] = "";
      });
    },

    saveSubsidiary(subsidiary, withFlash = true) {
      return subsidiary.id
        ? this.update(subsidiary, withFlash)
        : this.store(subsidiary, withFlash);
    },

    async store(subsidiary, withFlash) {
      const formData = new FormData();

      const data = Object.keys(subsidiary).reduce((data, attribute) => {
        let value = subsidiary[attribute];

        value
          ? formData.append(attribute, value)
          : formData.append(attribute, "");

        return formData;
      }, {});

      await axios
        .post(`/cms/pages/subsidiaries`, data, {
          headers: { "Content-Type": "multipart/form-data" },
        })
        .then(({ data }) => {
          const index = this.subsidiaries.indexOf(subsidiary);

          this.$delete(this.subsidiaries[index], "errors");

          Object.keys(data.subsidiary).map((key) => {
            this.subsidiaries[index][key] = data.subsidiary[key];
          });

          if (withFlash) {
            flash(data.success);
          }

          return this.$parent.responses.push("success");
        })
        .catch(({ response }) => {
          const index = this.subsidiaries.indexOf(subsidiary);

          this.$set(this.subsidiaries[index], "errors", response.data.errors);

          return this.$parent.responses.push("#subsidiaries");
        });
    },

    async update(subsidiary, withFlash) {
      const index = this.subsidiaries.indexOf(
        this.subsidiaries.find((v) => v.id == subsidiary.id)
      );
      const formData = new FormData();

      const data = Object.keys(subsidiary).reduce((data, attribute) => {
        let value = subsidiary[attribute];

        value
          ? formData.append(attribute, value)
          : formData.append(attribute, "");

        return formData;
      }, {});

      formData.append("_method", "PUT");
      if (!(this.subsidiaries[index].image instanceof File)) {
        formData.delete("image");
      }

      await axios
        .post(`/cms/pages/subsidiaries/${subsidiary.id}`, data, {
          headers: { "Content-Type": "multipart/form-data" },
        })
        .then(({ data }) => {
          this.$delete(this.subsidiaries[index], "errors");

          Object.keys(this.subsidiaries[index]).map((key) => {
            this.subsidiaries[index][key] = data.subsidiary[key];
          });

          if (withFlash) {
            flash(data.success);
          }

          return this.$parent.responses.push("success");
        })
        .catch(({ response }) => {
          const index = this.subsidiaries.indexOf(subsidiary);

          this.$set(this.subsidiaries[index], "errors", response.data.errors);

          return this.$parent.responses.push("#subsidiaries");
        });
    },

    deleteSubsidiary(subsidiary) {
      const index = this.subsidiaries.indexOf(subsidiary);

      if (subsidiary.id) {
        return axios
          .delete(`/cms/pages/subsidiaries/${subsidiary.id}`)
          .then(({ data }) => {
            const index = this.subsidiaries.indexOf(
              this.subsidiaries.find((v) => v.id == subsidiary.id)
            );

            this.$delete(this.subsidiaries, index);
            flash(data.success);
          })
          .catch(({ response }) => {
            flash(response.data.message);
          });
      }

      this.$delete(this.subsidiaries, index);
    },

    selectSubsidiaryImg(index) {
      this.$refs[`subsidiaryImage_${index}`][0].click();
    },

    onSubsidiaryImgPick(event, index) {
      const files = event.target.files;
      const fileReader = new FileReader();

      fileReader.readAsDataURL(files[0]);

      this.subsidiaries[index].image = files[0];

      fileReader.onload = (evt) => {
        this.$set(this.subsidiaries[index], "tempImage", evt.target.result);
      };
    },

    removeSubsidiaryImg(index) {
      if (this.subsidiaries[index].hasOwnProperty("originalData")) {
        this.subsidiaries[index].image = this.subsidiaries[
          index
        ].originalData.image;
      } else {
        this.subsidiaries[index].image = "";
      }

      this.$delete(this.subsidiaries[index], "tempImage");
    },

    fileInstance(file) {
      if (file instanceof File) {
        return true;
      }

      return false;
    },
  },
};
</script>

<style scoped>
/*  */
</style>