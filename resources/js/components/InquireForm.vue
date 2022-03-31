<script>
export default {
  props: {
    url: String,
    service: {
      type: Object,
      required: false,
    },
  },

  data() {
    return {
      form: {
        name: "",
        email: "",
        contact: "",
        subject: "",
        message: "",
      },
      errors: {},
      disabled: false,
    };
  },

  created() {
    if (this.service) {
      this.form.subject = this.service.slug;
    }
  },

  methods: {
    initialState() {
      Object.assign(this.$data, this.$options.data());

      this.disabled = false;
    },

    validateCaptcha() {
      return new Promise((res, rej) => {
        grecaptcha.ready(() => {
          grecaptcha.execute(this.$root.grecaptcha_sitekey, { action: 'contact-us' })
            .then((token) => {
              return res(token);
            })
        })
      })
    },

    async submitInquiry() {
      let data = new FormData(document.querySelector("#get-in-touch"));
      this.disabled = true;

      grecaptcha.ready(() => {
        grecaptcha.execute(this.$root.grecaptcha_sitekey, { action: 'contact_us' })
          .then((token) => {
            data.set('recaptcha', token);

            axios
              .post(this.url, data)
              .then(({ data }) => {
                this.initialState();
                flash(data.message);
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
