<template>
  <div>
    <div class="d-flex justify-content-center">
      <button
        title="Read Full Report"
        class="btn btn-outline-secondary"
        data-toggle="modal"
        data-target="#insight-modal"
      >
        READ FULL REPORT
      </button>
    </div>

    <div
      class="modal fade confirm-delete-modal"
      id="insight-modal"
      tabindex="-1"
      role="dialog"
      data-backdrop="static"
      data-keyboard="false"
    >
      <div
        class="modal-dialog"
        role="document"
      >
        <div class="modal-content">
          <div class="modal-header justify-content-center">
            <h3 class="text-center">GET THE FULL REPORT</h3>
          </div>
          <div class="modal-body">
            <form
              id="full-report"
              autocomplete="off"
            >
              <div class="form-group mt-2">
                <label>Full Name</label>
                <input
                  :class="`form-control e-input ${ errors.name ? 'is-invalid' : '' }`"
                  type="text"
                  placeholder="Enter your name"
                  v-model="inquiry.name"
                >
                <div
                  class="invalid-feedback"
                  v-if="errors.name"
                  v-text="errors.name[0]"
                ></div>
              </div>
              <div class="form-group mt-2">
                <label>Email</label>
                <input
                  :class="`form-control e-input ${ errors.email ? 'is-invalid' : '' }`"
                  type="email"
                  placeholder="Enter your email address"
                  v-model="inquiry.email"
                >
                <div
                  class="invalid-feedback"
                  v-if="errors.email"
                  v-text="errors.email[0]"
                ></div>
              </div>
              <div class="form-group mt-2">
                <label>Company</label>
                <input
                  :class="`form-control e-input ${ errors.company ? 'is-invalid' : '' }`"
                  type="text"
                  placeholder="Enter your contact details"
                  v-model="inquiry.company"
                >
                <div
                  class="invalid-feedback"
                  v-if="errors.company"
                  v-text="errors.company[0]"
                ></div>
              </div>
              <div class="form-group mt-2">
                <label>Can our Account Managers contact you to discuss your digital requirements?</label>

                <div class="form-check">

                  <input
                    class="form-check-input"
                    type="radio"
                    name="flexRadioDefault"
                    v-model="inquiry.contact_manager"
                    value="Yes"
                    :class="`${ errors.contact_manager ? 'is-invalid' : '' }`"
                  >
                  <label>
                    Yes
                  </label>
                </div>
                <div class="form-check">
                  <input
                    class="form-check-input"
                    type="radio"
                    name="flexRadioDefault"
                    v-model="inquiry.contact_manager"
                    value="No"
                    :class="`${ errors.contact_manager ? 'is-invalid' : '' }`"
                  >
                  <label>
                    No
                  </label>
                  <div
                    class="invalid-feedback"
                    v-if="errors.contact_manager"
                    v-text="errors.contact_manager[0]"
                  ></div>
                </div>
              </div>
              <div class="form-group mt-2">
                <input
                  :class="`form-control e-input ${ errors.contact ? 'is-invalid' : '' }`"
                  type="hidden"
                  v-model="inquiry.title"
                >
                <div
                  class="invalid-feedback"
                  v-if="errors.contact"
                  v-text="errors.contact[0]"
                ></div>
              </div>
              <div class="form-group">
                <div class="text-center">
                  <button
                    type="submit"
                    class="btn btn-block btn-purple mb-1"
                    :disabled="disabled"
                    @click.prevent="requestInsightInquiry"
                  >
                    Submit
                  </button>
                  <button
                    class="btn btn-link"
                    data-dismiss="modal"
                    @click.prevent="resetData"
                  >
                    Cancel
                  </button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ["itemTitle"],
  data() {
    return {
      errors: {},
      disabled: false,
      inquiry: {
        name: null,
        email: null,
        company: null,
        contact_manager: null,
        title: this.itemTitle,
      },
      url: 'insight-inquire',
    };
  },
  methods: {
    initialState() {
      Object.assign(this.$data, this.$options.data());
      this.inquiry.title = this.itemTitle;
      this.disabled = false;
    },
    resetData() {
      this.errors = {};
      this.inquiry = {};
      this.disabled = false;
    },
    requestInsightInquiry() {
      let data = this.inquiry;
      this.disabled = true;

      grecaptcha.ready(() => {
        grecaptcha.execute(this.$root.grecaptcha_sitekey, { action: 'contact_us' })
          .then((token) => {
            data.recaptcha = token

            axios
              .post(this.url, data)
              .then(({ data }) => {
                this.initialState();
                this.disabled = false;
                flash(data.message);
                $("#insight-modal").modal("hide");
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
