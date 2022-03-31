<template>
  <div
    class="modal fade job-modal"
    id="job-modal"
    tabindex="-1"
    role="dialog"
    data-backdrop="static"
    data-keyboard="false"
  >
    <div class="modal-dialog modal-xl" role="document">
      <page-loader class="jobPreloader" v-if="disabled" />

      <div class="modal-content">
        <div class="modal-body">
          <div class="title">
            <h3 v-text="modalTitle"></h3>
          </div>
          <hr />

          <form>
            <!-- banner -->
            <div id="banner" class="form-group mt-4">
              <label>
                Banner
                <small class="text-danger" v-if="errors.banner" v-text="errors.banner[0]"></small>
              </label>

              <preview-image-input
                class="banner--image"
                ref="previewImg"
                max_size="5mb"
                max_dimension="1920x614"
                v-model="form.banner"
              />
            </div>

            <!-- title | department | experience | status -->
            <div class="form-row">
              <div class="form-group col-3">
                <label>Title</label>

                <input
                  type="text"
                  :class="`form-control ${errors.title ? 'is-invalid' : ''}`"
                  v-model="form.title"
                />

                <div class="invalid-feedback" v-if="errors.title" v-text="errors.title[0]"></div>
              </div>

              <div class="form-group col-3">
                <label>Department</label>

                <input
                  type="text"
                  list="departments"
                  :class="`form-control ${
                    errors.department ? 'is-invalid' : ''
                  }`"
                  v-model="form.department"
                />
                <datalist id="departments">
                  <option>Sales</option>
                  <option>Marketing</option>
                  <option>Creatives</option>
                  <option>Development</option>
                  <option>Brands</option>
                </datalist>

                <div
                  class="invalid-feedback"
                  v-if="errors.department"
                  v-text="errors.department[0]"
                ></div>
              </div>

              <div class="form-group col-2">
                <label>Years of Experience</label>

                <input
                  type="number"
                  pattern="[0-9]"
                  :class="`form-control ${
                    errors.experience ? 'is-invalid' : ''
                  }`"
                  v-model="form.experience"
                />

                <div
                  class="invalid-feedback"
                  v-if="errors.experience"
                  v-text="errors.experience[0]"
                ></div>
              </div>

              <div class="form-group col">
                <label>Status</label>

                <div class="d-flex align-items-center" style="gap: 10px">
                  Inactive
                  <label class="switch m-0">
                    <input type="checkbox" class="success" v-model="form.status" />
                    <span class="slider round"></span>
                  </label>
                  Active
                </div>

                <small class="text-danger" v-if="errors.status" v-text="errors.status[0]"></small>
              </div>
            </div>

            <!-- overview | requirements -->
            <div class="form-row">
              <div class="form-group col-6">
                <label>Overview</label>

                <tinymce-editor
                  api-key="q5eqi5jopju01p1l2xpwn411by2u4oxvo9men2va1eey6m4w"
                  rows="10"
                  :init="tinymceInit()"
                  v-model="form.overview"
                ></tinymce-editor>

                <small class="text-danger" v-if="errors.overview" v-text="errors.overview[0]"></small>
              </div>

              <div class="form-group col-6">
                <label>Requirements</label>

                <tinymce-editor
                  api-key="q5eqi5jopju01p1l2xpwn411by2u4oxvo9men2va1eey6m4w"
                  rows="10"
                  :init="tinymceInit()"
                  v-model="form.requirements"
                ></tinymce-editor>

                <small
                  class="text-danger"
                  v-if="errors.requirements"
                  v-text="errors.requirements[0]"
                ></small>
              </div>
            </div>

            <!-- SEO fields -->
            <div class="job-seo-form p-2">
              <div class="row mt-3">
                <div class="col">
                  <label class="font-weight-bold">For Seo</label>
                </div>
              </div>

              <div class="form-row">
                <div class="form-group col-4">
                  <label>Meta Title</label>

                  <input
                    type="text"
                    :class="`form-control ${
                      errors.meta_title ? 'is-invalid' : ''
                    }`"
                    v-model="form.meta_title"
                  />

                  <div
                    class="invalid-feedback"
                    v-if="errors.meta_title"
                    v-text="errors.meta_title[0]"
                  ></div>
                </div>

                <div class="form-group col-4">
                  <label>Meta Keywords</label>

                  <input
                    type="text"
                    :class="`form-control ${
                      errors.meta_keywords ? 'is-invalid' : ''
                    }`"
                    v-model="form.meta_keywords"
                  />

                  <div
                    class="invalid-feedback"
                    v-if="errors.meta_keywords"
                    v-text="errors.meta_keywords[0]"
                  ></div>
                </div>

                <div class="form-group col-4">
                  <label>Meta Description</label>

                  <input
                    type="text"
                    :class="`form-control ${
                      errors.meta_description ? 'is-invalid' : ''
                    }`"
                    v-model="form.meta_description"
                  />

                  <div
                    class="invalid-feedback"
                    v-if="errors.meta_description"
                    v-text="errors.meta_description[0]"
                  ></div>
                </div>
              </div>

              <small>
                <span class="icon-info"></span>
                These fields are for SEO purposes only.
              </small>
            </div>

            <div>
              <div class="button-modal text-right">
                <button class="btn btn-link" data-dismiss="modal" @click="initialState">Cancel</button>

                <button
                  class="btn btn-purple-round"
                  :disabled="disabled"
                  @click.prevent="submit"
                  v-text="disabled ? 'Submitting...' : 'Submit'"
                ></button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import PageLoader from "../../components/PageLoader";
import Editor from "@tinymce/tinymce-vue";
import Wysiwyg from "../../mixins/Wysiwyg";
import PreviewImageInput from "../../components/PreviewImageInput";

export default {
  props: {
    selectedJob: { type: Object, required: false },
  },
  components: {
    "tinymce-editor": Editor,
    PageLoader,
    PreviewImageInput,
  },
  mixins: [Wysiwyg],

  data() {
    return {
      form: {
        banner: "",
        title: "",
        department: "",
        experience: "",
        status: true,
        overview: "",
        requirements: "",
        meta_title: "",
        meta_description: "",
        meta_keywords: "",
      },
      errors: {},
      disabled: false,
    };
  },

  watch: {
    selectedJob(values) {
      if (Object.keys(values).length > 0) {
        Object.keys(this.form).reduce((data, attribute) => {
          this.form[attribute] = this.selectedJob[attribute];

          return;
        }, {});

        if (this.selectedJob.banner) {
          this.form.banner = this.selectedJob.bannerPath;
        }

        const { meta_title, meta_keywords, meta_description } =
          this.selectedJob.seo;

        this.form.meta_title = meta_title;
        this.form.meta_keywords = meta_keywords;
        this.form.meta_description = meta_description;
      }
    },
  },

  computed: {
    modalTitle() {
      const title = Object.keys(this.selectedJob).length == 0 ? "Add" : "Edit";

      return `${title} Job`;
    },
  },

  methods: {
    initialState() {
      Object.assign(this.$data, this.$options.data());
      this.$emit("removeselectedJob");

      const selectedToolbars = document.querySelectorAll(".tox-tbtn--enabled");

      if (selectedToolbars.length > 0) {
        selectedToolbars.forEach((elem, i) => {
          let opened = elem.getAttribute("aria-owns");

          elem.classList.remove("tox-tbtn--enabled");
          document.getElementById(opened).remove();
        });
      }

      this.$refs.previewImg.imageData = "";
    },

    submit() {
      this.disabled = true;

      const formData = new FormData();
      const form = Object.keys(this.form).reduce((data, attribute) => {
        formData.append(attribute, this.form[attribute]);
        return formData;
      }, {});

      let path = "/cms/pages/jobs";
      if (Object.keys(this.selectedJob).length > 0) {
        formData.append("_method", "PUT");
        if (!(this.form.banner instanceof File)) {
          formData.delete("banner");
        }

        path = `${path}/${this.selectedJob.id}`;
      }

      axios
        .post(path, form)
        .then(({ data }) => {
          flash(data.success);
          this.initialState();
          $("#job-modal").modal("hide");
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

<style lang='scss'>
.job-seo-form {
  background-color: #7070700d;
}

.jobPreloader {
  img {
    position: absolute !important;
  }
}

.banner--image {
  background: #8080802b;
}
</style>