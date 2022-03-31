<template>
  <form
    id="career-apply"
    method="POST"
    enctype="multipart/form-data"
  >
    <div class="career-job mb-4">
      <span class="select-label">Applying for</span>

      <career-select
        ref="jobSelect"
        :position="position"
        :careers="careers"
      ></career-select>
    </div>

    <div class="career-form">
      <div :class="`form-group row no-gutters career-inline-form ${
          errors.name ? 'is-invalid' : ''
        }`">
        <label class="col-sm-2 col-form-label">Full Name</label>

        <div class="col-sm-10">
          <input
            name="name"
            type="text"
            class="form-control-plaintext"
            placeholder="Juan Dela Cruz"
            v-model="form.name"
          />
        </div>
      </div>
      <p
        class="text-danger small font-weight-bold position-relative m-0"
        style="top: -1rem"
        v-if="errors.name"
        v-text="errors.name[0]"
      ></p>

      <div :class="`form-group row no-gutters career-inline-form ${
          errors.contact ? 'is-invalid' : ''
        }`">
        <label class="col-sm-2 col-form-label">Contact No.</label>

        <div class="col-sm-10">
          <input
            name="contact"
            type="tel"
            class="form-control-plaintext"
            placeholder="09124567890"
            v-model="form.contact"
          />
        </div>
      </div>
      <p
        class="text-danger small font-weight-bold position-relative m-0"
        style="top: -1rem"
        v-if="errors.contact"
        v-text="errors.contact[0]"
      ></p>

      <div :class="`form-group row no-gutters career-inline-form ${
          errors.address ? 'is-invalid' : ''
        }`">
        <label class="col-sm-2 col-form-label">Current Address</label>

        <div class="col-sm-10">
          <input
            name="address"
            type="text"
            class="form-control-plaintext"
            placeholder="Blk 1 Lot 2 Cruz St. Pasay City"
            v-model="form.address"
          />
        </div>
      </div>
      <p
        class="text-danger small font-weight-bold position-relative m-0"
        style="top: -1rem"
        v-if="errors.address"
        v-text="errors.address[0]"
      ></p>

      <div :class="`form-group row no-gutters career-inline-form ${
          errors.email ? 'is-invalid' : ''
        }`">
        <label class="col-sm-2 col-form-label">Email Address</label>

        <div class="col-sm-10">
          <input
            name="email"
            type="email"
            class="form-control-plaintext"
            placeholder="juandelacruz@email.com"
            v-model="form.email"
          />
        </div>
      </div>
      <p
        class="text-danger small font-weight-bold position-relative m-0"
        style="top: -1rem"
        v-if="errors.email"
        v-text="errors.email[0]"
      ></p>

      <div class="form-group career-upload">
        <label class="col-form-label">
          Upload CV Here
          <span
            class="text-danger font-weight-bold position-relative m-0"
            v-if="errors.file"
            v-text="errors.file[0]"
          ></span>
        </label>

        <upload-button ref="resumeInput"></upload-button>

        <span>Microsoft Word or PDF Only (3mb)</span>
      </div>
    </div>

    <div class="mt-4 career-form-footer">
      <button
        type="button"
        class="btn btn-outline-purple"
        @click="initialState"
      >Cancel</button>

      <button
        type="submit"
        class="btn btn-purple"
        @click.prevent="submitApplication"
        :disabled="disabled"
      >Apply</button>
    </div>
  </form>
</template>

<script>
import CareerSelect from "./CareerSelect";
import UploadButton from "./UploadButton";

export default {
  props: ["position", "careers"],
  components: { CareerSelect, UploadButton },

  data() {
    return {
      form: {
        name: "",
        contact: "",
        address: "",
        email: "",
      },
      errors: {},
      disabled: false,
    };
  },

  methods: {
    initialState() {
      Object.assign(this.$data, this.$options.data());

      this.$refs.resumeInput.$refs.fileInput.value = null;
      this.$refs.resumeInput.file = null;
      this.$refs.jobSelect.career = {
        title: this.position.title,
        slug: this.position.slug,
      };
      this.$refs.jobSelect.newCareer = this.position.slug;

      this.disabled = false;
    },

    submitApplication() {
      let data = new FormData(document.querySelector("#career-apply"));

      this.disabled = true;

      grecaptcha.ready(() => {
        grecaptcha.execute(this.$root.grecaptcha_sitekey, { action: 'contact_us' })
          .then((token) => {
            data.set('recaptcha', token);

            axios
              .post("/apply", data)
              .then(({ data }) => {
                this.initialState();
                flash(data.success);
              })
              .catch(({ response }) => {
                this.errors = response.data.errors;
                this.disabled = false;

                if (this.errors.recaptcha) {
                  console.error(this.errors.recaptcha[0])
                  alert(this.errors.recaptcha[0])
                }
              });
          });
      });
    },
  },
};
</script>

<style scoped>
/*  */
</style>
