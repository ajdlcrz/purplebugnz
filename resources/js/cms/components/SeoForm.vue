<template>
  <div id="manageSeo" class="seo-container mt-5 mb-5">
    <div class="seo-wrap">
      <div class="row mr-0">
        <div class="col-md-3">
          <p>For Seo</p>
          <small>
            <span class="icon-info"></span>
            These fields are for SEO purposes only.
          </small>
        </div>

        <div class="col-md-4">
          <div class="form-group">
            <label>Meta Title</label>

            <input
              type="text"
              :class="`form-control ${errors.meta_title ? 'is-invalid' : ''}`"
              v-model="form.meta_title"
            />

            <div
              class="invalid-feedback"
              v-if="errors.meta_title"
              v-text="errors.meta_title[0]"
            ></div>
          </div>

          <div class="form-group">
            <label>Meta Keyword</label>

            <input
              type="text"
              :class="`form-control ${errors.meta_keyword ? 'is-invalid' : ''}`"
              v-model="form.meta_keyword"
            />

            <div
              class="invalid-feedback"
              v-if="errors.meta_keyword"
              v-text="errors.meta_keyword[0]"
            ></div>
          </div>
        </div>

        <div class="col-md-4">
          <div class="form-group">
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
      </div>
    </div>

    <!-- <div class="seo-footer mt-4">
      <div>
        <button class="btn btn-cancel" @click="cancel">Cancel</button>
        <button class="btn btn-purple-round" @click="saveSeo">Save</button>
      </div>
    </div> -->
  </div>
</template>

<script>
export default {
  props: ["url", "data"],

  data() {
    return {
      originalData: this.data,
      form: {
        meta_title: this.data.meta_title,
        meta_description: this.data.meta_description,
        meta_keyword: this.data.meta_keyword,
      },
      errors: {},
    };
  },

  methods: {
    cancel() {
      this.form = { ...this.originalData };
      this.errors = {};
    },

    async saveSeo(withFlash = true) {
      await axios
        .put(this.url, this.form)
        .then(({ data }) => {
          Object.keys(this.originalData).map((attribute) => {
            this.originalData[attribute] = this.form[attribute];
          });

          this.errors = {};

          if (withFlash) {
            flash(data.success);
          }

          return this.$parent.responses.push("success");
        })
        .catch(({ response }) => {
          this.errors = response.data.errors;

          return this.$parent.responses.push("#manageSeo");
        });
    },
  },
};
</script>

<style scoped>
/*  */
</style>