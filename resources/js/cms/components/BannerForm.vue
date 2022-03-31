<template>
  <div id="bannerForm">
    <p class="font-weight-bold">
      Banner
      <small
        class="text-danger"
        v-if="errors.image"
        v-text="errors.image[0]"
      ></small>
    </p>

    <preview-image-input
      class="banner--image"
      ref="previewImg"
      max_size="5mb"
      max_dimension="1920x614"
      path="/storage/banners"
      :validation="`${errors.image ? errors.image[0] : ''}`"
      v-model="form.image"
    />

    <div class="card mt-3">
      <div class="card-body">
        <div class="form-row">
          <div class="form-group col-md-6">
            <label class="font-weight-bold">
              Heading
              <small
                class="text-danger"
                v-if="errors.heading"
                v-text="errors.heading[0]"
              ></small>
            </label>

            <input
              type="email"
              :class="`form-control ${errors.heading ? 'is-invalid' : ''}`"
              v-model="form.heading"
            />
          </div>

          <div class="form-group col-md-6">
            <label class="font-weight-bold">
              Body
              <small
                class="text-danger"
                v-if="errors.body"
                v-text="errors.body[0]"
              ></small>
            </label>

            <tinymce-editor
              api-key="q5eqi5jopju01p1l2xpwn411by2u4oxvo9men2va1eey6m4w"
              rows="6"
              :init="tinymceInit()"
              v-model="form.body"
            ></tinymce-editor>
          </div>
        </div>

        <div class="d-flex justify-content-end">
          <div>
            <button class="btn btn-cancel" @click="cancel">Cancel</button>
            <button
              class="btn btn-purple-round"
              :disabled="disabled"
              @click="save()"
            >
              Save
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Editor from "@tinymce/tinymce-vue";
import Wysiwyg from "../mixins/Wysiwyg";
import PreviewImageInput from "../components/PreviewImageInput";

export default {
  props: ["url", "data"],
  components: {
    "tinymce-editor": Editor,
    PreviewImageInput,
  },
  mixins: [Wysiwyg],

  data() {
    return {
      originalData: this.data,
      form: {
        image: this.data.image,
        heading: this.data.heading,
        body: this.data.body,
      },
      disabled: false,
      errors: {},
    };
  },

  watch: {
    data: {
      handler(val, oldVal) {
        this.form = { ...this.data };
      },
      deep: true,
      immediate: true,
    },
  },

  methods: {
    cancel() {
      this.form = { ...this.originalData };
      this.errors = {};

      const image = this.data.image
        ? `/storage/banners/${this.data.image}`
        : this.data.image;

      this.$refs.previewImg.imageData = image;
    },

    async save(withFlash = true) {
      const formData = new FormData();
      const data = Object.keys(this.form).reduce((data, attribute) => {
        let value = this.form[attribute];

        // to prevent formData to format null into "null"(string)
        if (value) {
          formData.append(attribute, value);
        } else {
          formData.append(attribute, "");
        }

        return formData;
      }, {});

      formData.append("_method", "PUT");
      // remove to pass the 'nullable' validation when no new image inserted.
      if (!(this.form.image instanceof File)) {
        formData.delete("image");
      }

      this.disabled = true;
      await axios
        .post(this.url, data)
        .then(({ data }) => {
          this.disabled = false;
          this.errors = {};

          Object.keys(this.originalData).map((attribute) => {
            this.originalData[attribute] = data.banner[attribute];
          });

          if (withFlash) {
            flash(data.success);
          }

          return this.$parent.responses.push("success");
        })
        .catch(({ response }) => {
          this.errors = response.data.errors;
          this.disabled = false;

          return this.$parent.responses.push("#bannerForm");
        });
    },
  },
};
</script>

<style lang="scss">
.banner--image {
  height: 300px;
  border: 0 !important;
  background-color: #80008033;
  overflow: hidden;
  // justify-content: flex-start !important;

  label {
    margin-bottom: 0;
  }

  .preview-container {
    width: auto;

    .preview-image {
      width: auto;
    }
  }
}
</style>