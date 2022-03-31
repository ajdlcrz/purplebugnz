<template>
  <div class="cms-page-wrapper">
    <page-loader v-if="disabled" />

    <div class="cms-page">
      <div class="header-title mb-4">
        <h1 v-text="formTitle"></h1>
      </div>

      <form>
        <div class="row">
          <div id="banner" class="col-md-6 d-flex flex-column">
            <label class="font-weight-bold">
              Insight Image
              <small
                class="text-danger"
                v-if="errors.banner"
                v-text="errors.banner[0]"
              ></small>
            </label>

            <preview-image-input
              class="blog-image"
              ref="previewImg"
              max_size="5mb"
              max_dimension="1920x614"
              v-model="form.banner"
            />
          </div>
          <div class="col-md-6">
            <div id="title" class="form-group">
              <label class="font-weight-bold">Title</label>

              <input
                type="text"
                :class="`form-control ${errors.title ? 'is-invalid' : ''}`"
                v-model="form.title"
              />

              <div
                class="invalid-feedback"
                v-if="errors.title"
                v-text="errors.title[0]"
              ></div>
            </div>

            <div id="date" class="form-group">
              <label class="font-weight-bold">Date</label>

              <input
                type="date"
                :class="`form-control ${errors.date ? 'is-invalid' : ''}`"
                v-model="form.date"
              />

              <div
                class="invalid-feedback"
                v-if="errors.date"
                v-text="errors.date[0]"
              ></div>
            </div>

            <div id="details" class="form-group">
              <label class="font-weight-bold">Body</label>

              <tinymce-editor
                api-key="q5eqi5jopju01p1l2xpwn411by2u4oxvo9men2va1eey6m4w"
                rows="10"
                :init="tinymceInit()"
                v-model="form.details"
              ></tinymce-editor>

              <small
                class="text-danger"
                v-if="errors.details"
                v-text="errors.details[0]"
              ></small>
            </div>
          </div>
        </div>

        <div class="row mt-3">
          <div class="col-md-6">
            <p class="font-weight-bold">For Seo</p>
          </div>
        </div>

        <div class="row">
          <div class="col-md-6">
            <div class="form-row">
              <div id="meta_title" class="form-group col-md-6">
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

              <div id="meta_keywords" class="form-group col-md-6">
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
            </div>

            <div id="meta_description" class="form-group">
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

            <small>
              <span class="icon-info"></span>
              These fields are for SEO purposes only.
            </small>
          </div>

          <div class="col-md-6">
            <div id="alt_text" class="form-group">
              <label>Alt Text</label>

              <input
                type="text"
                :class="`form-control ${errors.alt_text ? 'is-invalid' : ''}`"
                v-model="form.alt_text"
              />

              <div
                class="invalid-feedback"
                v-if="errors.alt_text"
                v-text="errors.alt_text[0]"
              ></div>
            </div>
          </div>
        </div>
      </form>

      <hr class="mt-5" style="border-color: purple" />

      <div class="d-flex justify-content-end">
        <div>
          <button class="btn btn-cancel" @click="initialData">Cancel</button>
          <button
            class="btn btn-purple-round"
            v-text="disabled ? 'Saving ...' : 'Save'"
            :disabled="disabled"
            @click.prevent="save"
          ></button>
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
        date: "",
        details: "",
        alt_text: "",
        meta_title: "",
        meta_keywords: "",
        meta_description: "",
      },
      errors: {},
      disabled: false,
      isEdit: false,
      originalData: {},
    };
  },

  async created() {
    const insightId = this.$route.params.id;

    if (insightId) {
      this.isEdit = true;
      this.getInsight(insightId);
    }
  },

  computed: {
    formTitle() {
      return this.isEdit ? "Edit Insight" : "Add Insight";
    },
  },

  methods: {
    initialData() {
      if (Object.keys(this.originalData).length > 0) {
        Object.assign(this.form, this.originalData);
        this.errors = {};
      } else {
        Object.assign(this.$data, this.$options.data());
      }

      this.$refs.previewImg.imageData = this.form.banner;
    },

    async save() {
      this.disabled = true;

      const formData = new FormData();
      const data = Object.keys(this.form).reduce((data, attribute) => {
        let value = this.form[attribute];

        value
          ? formData.append(attribute, value)
          : formData.append(attribute, "");

        return formData;
      }, {});

      if (this.isEdit) {
        formData.append("_method", "PUT");

        if (!(this.form.banner instanceof File)) {
          formData.delete("banner");
        }
      }

      const url = this.isEdit ? `/${this.$route.params.id}` : "";

      await axios
        .post(`/cms/pages/insights${url}`, data, {
          headers: { "Content-Type": "multipart/form-data" },
        })
        .then(({ data }) => {
          flash(data.success);
          this.errors = {};
          this.disabled = false;

          this.$router.push({
            name: "InsightsIndex",
            hash: "#insightsTable",
          });
        })
        .catch(({ response }) => {
          this.errors = response.data.errors;
          this.disabled = false;

          const element = document.querySelector(
            `#${Object.keys(this.errors)[0]}`
          );

          return element.scrollIntoView({
            behavior: "smooth",
            block: "end",
            inline: "nearest",
          });
        });
    },

    async getInsight(insightId) {
      await axios
        .get(`/cms/pages/insights/edit/${insightId}`)
        .then(({ data }) => {
          const insight = data.insight;
          for (let prop in insight) {
            if (this.form.hasOwnProperty(prop)) {
              this.form[prop] = insight[prop];
              this.originalData[prop] = insight[prop];
            }
          }
          const { meta_title, meta_description, meta_keywords } = insight.seo;
          this.form.date = insight.publishedAtPicker;
          this.form.meta_title = meta_title;
          this.form.meta_description = meta_description;
          this.form.meta_keywords = meta_keywords;
          this.form.banner = insight.bannerPath;

          this.originalData.date = insight.publishedAtPicker;
          this.originalData.meta_title = meta_title;
          this.originalData.meta_description = meta_description;
          this.originalData.meta_keywords = meta_keywords;
          this.originalData.banner = insight.bannerPath;
        })
        .catch(({ response }) => {
          flash(response.data.message);
        });
    },
  },
};
</script>

<style lang="scss">
.blog-image {
  flex-basis: 100%;
  max-height: 440px;
  border: 0 !important;
  background-color: #8080802b;

  .preview-image {
    object-fit: contain !important;
  }
}
</style>