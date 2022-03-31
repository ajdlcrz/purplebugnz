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
              Blog Image
              <small class="text-danger" v-if="errors.banner" v-text="errors.banner[0]"></small>
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

              <div class="invalid-feedback" v-if="errors.title" v-text="errors.title[0]"></div>
            </div>

            <div id="date" class="form-group">
              <label class="font-weight-bold">Date</label>

              <input
                type="date"
                :class="`form-control ${errors.date ? 'is-invalid' : ''}`"
                v-model="form.date"
              />

              <div class="invalid-feedback" v-if="errors.date" v-text="errors.date[0]"></div>
            </div>

            <div id="category" class="form-group">
              <label class="font-weight-bold">Category</label>

              <div class="dropdown w-100">
                <button
                  class="dropdown-toggle border btn btn-block btn-light d-flex align-items-center justify-content-between"
                  type="button"
                  data-toggle="dropdown"
                  v-text="categoryDropdownTitle"
                ></button>
                <div class="dropdown-menu w-100">
                  <a
                    href="javascript:void(0)"
                    class="dropdown-item"
                    v-text="category.title"
                    v-for="category in categories"
                    :key="category.id"
                    @click="form.category = category.id"
                  ></a>
                  <hr />
                  <a
                    href="#"
                    class="dropdown-item"
                    data-toggle="modal"
                    data-target="#editCategory"
                  >Edit Category</a>
                </div>
              </div>

              <small class="text-danger" v-if="errors.category" v-text="errors.category[0]"></small>
            </div>

            <div id="details" class="form-group">
              <label class="font-weight-bold">Body</label>

              <tinymce-editor
                api-key="q5eqi5jopju01p1l2xpwn411by2u4oxvo9men2va1eey6m4w"
                rows="10"
                :init="tinymceInit()"
                v-model="form.details"
              ></tinymce-editor>

              <small class="text-danger" v-if="errors.details" v-text="errors.details[0]"></small>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-6 no-gutters">
            <div id="banner" class="d-flex flex-column h-100">
              <label class="font-weight-bold">
                Thumbnail
                <small
                  class="text-danger"
                  v-if="errors.thumbnail"
                  v-text="errors.thumbnail[0]"
                ></small>
              </label>

              <preview-image-input
                class="blog-image blog-image--thumbnail"
                ref="previewImgThumbnail"
                max_size="5mb"
                max_dimension="1200x630"
                v-model="form.thumbnail"
              />
            </div>
          </div>

          <div class="col-md-6 no-gutters">
            <div class="col-md-12">
              <p class="d-flex align-items-center font-weight-bold">For Seo</p>

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

              <div id="alt_text" class="form-group">
                <label>Alt Text</label>

                <input
                  type="text"
                  :class="`form-control ${errors.alt_text ? 'is-invalid' : ''}`"
                  v-model="form.alt_text"
                />

                <div class="invalid-feedback" v-if="errors.alt_text" v-text="errors.alt_text[0]"></div>
              </div>

              <small>
                <span class="icon-info"></span>These fields are for SEO purposes only.
              </small>
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

    <categories-modal :categories="categories" @cancel="getCategories"></categories-modal>
  </div>
</template>

<script>
import PageLoader from "../../components/PageLoader";
import Editor from "@tinymce/tinymce-vue";
import Wysiwyg from "../../mixins/Wysiwyg";
import PreviewImageInput from "../../components/PreviewImageInput";
import CategoriesModal from "../../components/blogs/CategoriesModal";

export default {
  components: {
    "tinymce-editor": Editor,
    PageLoader,
    PreviewImageInput,
    CategoriesModal,
  },
  mixins: [Wysiwyg],

  data() {
    return {
      categories: [],
      form: {
        banner: "",
        thumbnail: "",
        title: "",
        category: "",
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
    await this.getCategories();

    const blogId = this.$route.params.id;

    if (blogId) {
      this.isEdit = true;

      this.getBlog(blogId);
    }
  },

  computed: {
    formTitle() {
      return this.isEdit ? "Edit Blog" : "Add Blog";
    },

    categoryDropdownTitle() {
      let title = "Select Category";

      if (this.form.category) {
        const selectedCategory = this.categories.find(
          (category) => category.id == this.form.category
        );

        title = selectedCategory?.title ?? title;
      }

      return title;
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
      this.$refs.previewImgThumbnail.imageData = this.form.thumbnail;
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

        if (!(this.form.thumbnail instanceof File)) {
          formData.delete("thumbnail");
        }
      }

      const url = this.isEdit ? `/${this.$route.params.id}` : "";

      await axios
        .post(`/cms/pages/blogs${url}`, data, {
          headers: { "Content-Type": "multipart/form-data" },
        })
        .then(({ data }) => {
          flash(data.success);
          this.errors = {};
          this.disabled = false;

          this.$router.push({
            name: "BlogsIndex",
            hash: "#blogsTable",
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

    async getBlog(blogId) {
      await axios
        .get(`/cms/pages/blogs/edit/${blogId}`)
        .then(({ data }) => {
          const blog = data.blog;

          for (let prop in blog) {
            if (this.form.hasOwnProperty(prop)) {
              this.form[prop] = blog[prop];
              this.originalData[prop] = blog[prop];
            }
          }
          this.form.date = blog.publishedAtPicker;

          const { meta_title, meta_description, meta_keywords } = blog.seo;
          this.form.meta_title = meta_title;
          this.form.meta_description = meta_description;
          this.form.meta_keywords = meta_keywords;

          this.form.category = blog.category_id;
          this.form.banner = blog.bannerPath;
          this.form.thumbnail = blog.thumbnailPath;

          this.originalData.meta_title = meta_title;
          this.originalData.meta_description = meta_description;
          this.originalData.meta_keywords = meta_keywords;
          this.originalData.category = blog.category_id;
          this.originalData.banner = blog.bannerPath;
          this.originalData.thumbnail = blog.thumbnailPath;
          this.originalData.date = blog.publishedAtPicker;
        })
        .catch(({ response }) => {
          flash(response.data.message);
        });
    },

    async getCategories() {
      await axios.get("/cms/pages/categories-list").then(({ data }) => {
        this.categories = data.categories;
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

  &--thumbnail {
    min-height: 315px;
  }
}

.icon-info {
  height: 1rem;
  width: 1rem;
}
</style>
