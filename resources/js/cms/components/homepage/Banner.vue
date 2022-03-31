<template>
  <div :id="`banner-${banner.id}`" class="card mb-3">
    <div class="banner-content">
      <preview-image-input
        class="banner-img"
        ref="previewImg"
        max_size="5mb"
        max_dimension="1920x873"
        :validation="`${errors.image ? errors.image[0] : ''}`"
        path="/storage/homepage/banners"
        v-model="form.image"
      />

      <div class="card-body p-0">
        <div class="form-group">
          <label>Heading</label>

          <textarea
            :class="`form-control ${errors.heading ? 'is-invalid' : ''}`"
            rows="4"
            v-model="form.heading"
          ></textarea>

          <div
            class="invalid-feedback"
            v-if="errors.heading"
            v-text="errors.heading[0]"
          ></div>
        </div>

        <div class="form-group">
          <label>Body</label>

          <tinymce-editor
            api-key="q5eqi5jopju01p1l2xpwn411by2u4oxvo9men2va1eey6m4w"
            rows="4"
            :init="tinymceInit()"
            v-model="form.body"
          ></tinymce-editor>

          <small
            class="text-danger"
            v-if="errors.body"
            v-text="errors.body[0]"
          ></small>
        </div>

        <div class="form-row">
          <div class="col-md-4">
            <label>Button Label</label>

            <input
              type="text"
              :class="`form-control ${errors.btn_label ? 'is-invalid' : ''}`"
              v-model="form.btn_label"
            />

            <div
              class="invalid-feedback"
              v-if="errors.btn_label"
              v-text="errors.btn_label[0]"
            ></div>
          </div>

          <div class="col-md-8">
            <label>Button Link</label>

            <input
              type="text"
              :class="`form-control ${errors.btn_link ? 'is-invalid' : ''}`"
              v-model="form.btn_link"
            />

            <div
              class="invalid-feedback"
              v-if="errors.btn_link"
              v-text="errors.btn_link[0]"
            ></div>
          </div>
        </div>
      </div>
    </div>

    <div class="card-footer pl-0">
      <button class="btn btn-remove" @click="remove">
        <span class="icon-remove"></span>
        Remove
      </button>

      <div>
        <button class="btn btn-cancel" @click="cancel">Cancel</button>
        <button class="btn btn-purple-round" @click="save()">Save</button>
      </div>
    </div>
  </div>
</template>

<script>
import Editor from "@tinymce/tinymce-vue";
import Wysiwyg from "../../mixins/Wysiwyg";
import PreviewImageInput from "../PreviewImageInput";

export default {
  props: ["banner"],
  components: {
    PreviewImageInput,
    "tinymce-editor": Editor,
  },
  mixins: [Wysiwyg],

  data() {
    return {
      form: { ...this.banner },
      errors: {},
    };
  },

  watch: {
    banner: {
      handler(val, oldVal) {
        this.form = { ...this.banner };
      },
      deep: true,
      immediate: true,
    },
  },

  methods: {
    cancel() {
      this.form = { ...this.banner };
      this.errors = {};

      const image = this.banner.image
        ? `/storage/homepage/banners/${this.banner.image}`
        : this.banner.image;

      this.$refs.previewImg.imageData = image;
    },

    async save(withFlash = true) {
      const formData = new FormData();
      const data = Object.keys(this.form).reduce((data, attribute) => {
        let value = this.form[attribute];

        value
          ? formData.append(attribute, value)
          : formData.append(attribute, "");

        return formData;
      }, {});

      formData.append("_method", "PUT");
      if (!(this.form.image instanceof File)) {
        formData.delete("image");
      }

      await axios
        .post("/cms/pages/homepage/banners", data, {
          headers: { "Content-Type": "multipart/form-data" },
        })
        .then(({ data }) => {
          this.errors = {};

          this.$emit("saved", data.banner);

          if (withFlash) {
            flash(data.success);
          }

          return this.$parent.responses.push("success");
        })
        .catch(({ response }) => {
          this.errors = response.data.errors;

          // return this.$parent.responses.push(`#banner-${this.banner.id}`);
          return this.$parent.responses.push("#homepageBanners");
        });
    },

    remove() {
      this.$emit("remove");
    },
  },
};
</script>