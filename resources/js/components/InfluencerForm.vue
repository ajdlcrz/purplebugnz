<template>
  <div>
    <button
      class="btn btn-purple mt-2 mx-auto"
      data-toggle="modal"
      data-target="#influencerForm-modal"
      @click="initialState"
    >Join Now!</button>

    <!-- InfluencerForm-Modal -->
    <div
      id="influencerForm-modal"
      class="modal fade"
      data-keyboard="false"
      tabindex="-1"
    >
      <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header justify-content-center border-0">
            <img
              src="/img/purplebug-icon.svg"
              alt="pb icon"
            >
          </div>

          <div class="modal-body">
            <form method="POST">
              <!-- || GET STARTED -->
              <div
                class="d-flex justify-content-center flex-wrap text-center pb-5"
                v-if="currentStep == 0"
              >
                <h4 class="modal-title c-font--purple font-weight-bolder">Influencer Circle</h4>

                <div class="mt-4">
                  <p>In accordance with the Data Privacy Act of 2012, all personal information shared will rest assured be treated with the utmost confidentiality and privacy, and the surveyor also wants to include the responses to these condition. </p>

                  <p>I confirm that the personal data provided herein is true and correct to the best of my knowledge, and I allow PurpleBug to use my details to create a Roster of Influencers who PurpleBug can contact for future projects. </p>
                </div>

                <div class="d-flex justify-content-center flex-wrap mt-4">
                  <div class="form-check">
                    <input
                      id="checkboxAccept"
                      class="form-check-input"
                      type="checkbox"
                      name="accept"
                      v-model="accepted"
                    >
                    <label
                      class="form-check-label"
                      for="checkboxAccept"
                    >
                      I Accept
                    </label>
                  </div>

                  <button
                    type="button"
                    class="btn btn-purple mx-auto mt-2 w-100"
                    :disabled="!accepted"
                    @click.prevent="getStarted"
                  >Let's Get Started</button>
                </div>
              </div>

              <!-- || STEP 1 -->
              <div
                class="c-influencer-form--step1"
                v-if="currentStep == 1"
              >
                <h4 class="step-title">Personal Information</h4>

                <div class="inquire-form mt-5">
                  <div class="row">
                    <div class="col-xs-12 col-sm-6">
                      <label class="mb-3"><small>Full Name <span>*</span></small></label>
                      <input
                        type="text"
                        placeholder="Enter your name"
                        :class="`form-control e-input ${ form[1].errors.name ? 'is-invalid' : '' }`"
                        v-model="form[1].name"
                      >
                      <div
                        class="invalid-feedback"
                        v-if="form[1].errors.name"
                        v-text="form[1].errors.name[0]"
                      ></div>
                    </div>

                    <div class="col-xs-6 col-sm-3">
                      <label class="mb-3"><small>Age <span>*</span></small></label>
                      <input
                        type="number"
                        placeholder="Enter your age"
                        :class="`form-control e-input ${ form[1].errors.age ? 'is-invalid' : '' }`"
                        v-model="form[1].age"
                      >
                      <div
                        class="invalid-feedback"
                        v-if="form[1].errors.age"
                        v-text="form[1].errors.age[0]"
                      ></div>
                    </div>

                    <div class="col-xs-6 col-sm-3">
                      <label class="mb-3"><small>Sex <span>*</span></small></label>

                      <select
                        :class="`form-control e-input e-input--select ${ form[1].errors.sex ? 'is-invalid' : '' }`"
                        v-model="form[1].sex"
                      >
                        <option
                          value=""
                          selected
                          disabled
                        >Choose below</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                      </select>

                      <div
                        class="invalid-feedback"
                        v-if="form[1].errors.sex"
                        v-text="form[1].errors.sex[0]"
                      ></div>
                    </div>
                  </div>

                  <div class="row mt-4">
                    <div class="col-xs-12 col-sm-6">
                      <label class="mb-3"><small>Email <span>*</span></small></label>
                      <input
                        type="email"
                        placeholder="Enter your email address"
                        :class="`form-control e-input ${ form[1].errors.email ? 'is-invalid' : '' }`"
                        v-model="form[1].email"
                      >
                      <div
                        class="invalid-feedback"
                        v-if="form[1].errors.email"
                        v-text="form[1].errors.email[0]"
                      ></div>
                    </div>

                    <div class="col-xs-12 col-sm-6">
                      <label class="mb-3"><small>Contact No. <span>*</span></small></label>

                      <input
                        type="tel"
                        name="phone"
                        placeholder="Enter your contact details"
                        :class="`form-control e-input ${ form[1].errors.contact_number ? 'is-invalid' : '' }`"
                        v-model="form[1].contact_number"
                      >

                      <div
                        class="invalid-feedback"
                        v-if="form[1].errors.contact_number"
                        v-text="form[1].errors.contact_number[0]"
                      ></div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- || STEP 2 -->
              <div
                class="c-influencer-form--step2"
                v-if="currentStep == 2"
              >
                <h4 class="step-title">Social Media Information</h4>

                <div class="inquire-form mt-5">
                  <div class="row">
                    <div class="col-12">
                      <label class="mb-3"><small>Category of Content <span>*</span></small></label>

                      <div class="step2__content-categories">
                        <div
                          class="flex-fill form-check form-check-inline"
                          v-for="(category, key) in content_categories"
                          :key="key"
                        >
                          <input
                            type="checkbox"
                            class="form-check-input"
                            :id="category"
                            :value="category"
                            v-model="form[2].content_category[category]"
                          >
                          <label
                            class="form-check-label text-capitalize"
                            :for="category"
                          >
                            <small v-text="category"></small>
                          </label>
                        </div>

                        <div class="flex-fill step2__content-categories--others">
                          <div>
                            <input
                              id="others"
                              type="checkbox"
                              style="margin-right: 5px;"
                              v-model="othersChecked"
                            >
                            <label
                              class="form-check-label"
                              for="others"
                            ><small>Others, please specify</small></label>
                          </div>

                          <input
                            type="text"
                            :class="`form-control e-input ${ othersChecked && form[2].content_category.others == '' ? 'is-invalid' : '' }`"
                            maxlength="50"
                            v-model="form[2].content_category['others']"
                          >
                          <div
                            class="invalid-feedback"
                            v-if="othersChecked && form[2].content_category.others == ''"
                          > This field is required </div>
                        </div>
                      </div>

                      <span
                        class="text-danger small"
                        v-if="form[2].errors.content_category"
                        v-text="form[2].errors.content_category[0]"
                      ></span>
                    </div>
                  </div>

                  <div class="row mt-4">
                    <div class="col-xs-12 col-sm-6">
                      <label class="mb-3"><small>Estimated total of followers and subscribers on all social media platforms <span>*</span></small></label>
                      <input
                        type="number"
                        placeholder="Enter your answer here"
                        :class="`form-control e-input ${ form[2].errors.total_followers ? 'is-invalid' : '' }`"
                        v-model="form[2].total_followers"
                      >
                      <div
                        class="invalid-feedback"
                        v-if="form[2].errors.total_followers"
                        v-text="form[2].errors.total_followers[0]"
                      ></div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- || STEP 3 -->
              <div
                class="c-influencer-form--step3"
                v-if="currentStep == 3"
              >
                <div class="inquire-form">
                  <div class="row">
                    <!-- facebook -->
                    <div class="col-xs-12 col-md-6 d-flex flex-column mt-3">
                      <h4 class="step-title">Facebook</h4>

                      <div class="row flex-fill mt-5">
                        <div
                          class="col-12"
                          :style="`${!form[3].errors.facebook_page_url ? 'margin-bottom: 20px;' : 'margin-bottom: 4px'}`"
                        >
                          <label class="mb-3"><small>Facebook Page URL (N/A if none)</small></label>
                          <input
                            type="url"
                            placeholder="Enter your answer here"
                            :class="`form-control e-input ${ form[3].errors.facebook_page_url ? 'is-invalid' : '' }`"
                            v-model="form[3].facebook_page_url"
                          >
                          <div
                            class="invalid-feedback mt-0"
                            v-if="form[3].errors.facebook_page_url"
                            v-text="form[3].errors.facebook_page_url[0]"
                          ></div>
                        </div>

                        <div
                          :class="['col-12 mt-auto', {
                              'pb-20px': form[3].errors.hasOwnProperty('instagram_post_rate') || form[3].errors.hasOwnProperty('instagram_video_post_rate'),
                              'pb-40px': (!form[3].errors.hasOwnProperty('facebook_post_rate')) && (form[3].errors.hasOwnProperty('instagram_post_rate') || form[3].errors.hasOwnProperty('instagram_video_post_rate')),
                              'mb-20px': true,
                              'mb-0': (form[3].errors.hasOwnProperty('facebook_post_rate')) && (!form[3].errors.hasOwnProperty('instagram_post_rate') && !form[3].errors.hasOwnProperty('instagram_video_post_rate'))
                          }]"
                          style="padding-top: 20px;"
                        >
                          <label class="mb-3"><small>Facebook static post rate <span>*</span></small></label>
                          <input
                            type="text"
                            placeholder="Enter your answer here"
                            :class="`form-control e-input ${ form[3].errors.facebook_post_rate ? 'is-invalid' : '' }`"
                            v-model="form[3].facebook_post_rate"
                          >
                          <div
                            class="invalid-feedback"
                            v-if="form[3].errors.facebook_post_rate"
                            v-text="form[3].errors.facebook_post_rate[0]"
                          ></div>
                        </div>
                      </div>
                    </div>
                    <!-- instagram -->
                    <div class="col-xs-12 col-md-6 d-flex flex-column mt-3">
                      <h4 class="step-title">Instagram</h4>

                      <div class="mt-5">
                        <div :style="`${!form[3].errors.instagram_page_url ? 'margin-bottom: 20px;' : 'margin-bottom: 4px;'}`">
                          <label class="mb-3"><small>Instagram Page URL (N/A if none)</small></label>
                          <input
                            type="url"
                            placeholder="Enter your answer here"
                            :class="`form-control e-input ${ form[3].errors.instagram_page_url ? 'is-invalid' : '' }`"
                            v-model="form[3].instagram_page_url"
                          >
                          <div
                            class="invalid-feedback  mt-0"
                            v-if="form[3].errors.instagram_page_url"
                            v-text="form[3].errors.instagram_page_url[0]"
                          ></div>
                        </div>

                        <div
                          class="row"
                          style="margin-bottom: 20px; padding-top: 20px;"
                        >
                          <div class="col-md-6">
                            <label class="mb-3"><small>Instagram static post cross posted to Facebook rate <span>*</span></small></label>
                            <input
                              type="text"
                              placeholder="Enter your answer here"
                              :class="`form-control e-input ${ form[3].errors.instagram_post_rate ? 'is-invalid' : '' }`"
                              v-model="form[3].instagram_post_rate"
                            >
                            <div
                              class="invalid-feedback"
                              v-if="form[3].errors.instagram_post_rate"
                              v-text="form[3].errors.instagram_post_rate[0]"
                            ></div>
                          </div>
                          <div class="col-md-6">
                            <label class="mb-3"><small>Instagram video post cross posted to Facebook rate <span>*</span></small></label>
                            <input
                              type="text"
                              placeholder="Enter your answer here"
                              :class="`form-control e-input ${ form[3].errors.instagram_video_post_rate ? 'is-invalid' : '' }`"
                              v-model="form[3].instagram_video_post_rate"
                            >
                            <div
                              class="invalid-feedback"
                              v-if="form[3].errors.instagram_video_post_rate"
                              v-text="form[3].errors.instagram_video_post_rate[0]"
                            ></div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- || STEP 4 -->
              <div
                class="c-influencer-form--step4"
                v-if="currentStep == 4"
              >
                <div class="inquire-form">
                  <div class="row">
                    <!-- youtube -->
                    <div class="col-xs-12 col-sm-6 d-flex flex-column mt-3">
                      <h4 class="step-title">YouTube</h4>

                      <div class="mt-5">
                        <div :style="`${!form[4].errors.youtube_page_url ? 'margin-bottom: 20px;' : 'margin-bottom: 4px'}`">
                          <label class="mb-3"><small>YouTube Page URL (N/A if none)</small></label>
                          <input
                            type="url"
                            placeholder="Enter your answer here"
                            :class="`form-control e-input ${ form[4].errors.youtube_page_url ? 'is-invalid' : '' }`"
                            v-model="form[4].youtube_page_url"
                          >
                          <div
                            class="invalid-feedback mt-0"
                            v-if="form[4].errors.youtube_page_url"
                            v-text="form[4].errors.youtube_page_url[0]"
                          ></div>
                        </div>

                        <div
                          class="mt-auto"
                          style="margin-bottom: 20px; padding-top: 20px;"
                        >
                          <label class="mb-3"><small>YouTube static post rate <span>*</span></small></label>
                          <input
                            type="text"
                            placeholder="Enter your answer here"
                            :class="`form-control e-input ${ form[4].errors.youtube_post_rate ? 'is-invalid' : '' }`"
                            v-model="form[4].youtube_post_rate"
                          >
                          <div
                            class="invalid-feedback"
                            v-if="form[4].errors.youtube_post_rate"
                            v-text="form[4].errors.youtube_post_rate[0]"
                          ></div>
                        </div>
                      </div>
                    </div>
                    <!-- tiktok -->
                    <div class="col-xs-12 col-sm-6 d-flex flex-column mt-3">
                      <h4 class="step-title">TikTok</h4>

                      <div class="mt-5">
                        <div :style="`${!form[4].errors.tiktok_page_url ? 'margin-bottom: 20px;' : 'margin-bottom: 4px;'}`">
                          <label class="mb-3"><small>TikTok Page URL (N/A if none)</small></label>
                          <input
                            type="url"
                            placeholder="Enter your answer here"
                            :class="`form-control e-input ${ form[4].errors.tiktok_page_url ? 'is-invalid' : '' }`"
                            v-model="form[4].tiktok_page_url"
                          >
                          <div
                            class="invalid-feedback  mt-0"
                            v-if="form[4].errors.tiktok_page_url"
                            v-text="form[4].errors.tiktok_page_url[0]"
                          ></div>
                        </div>

                        <div style="margin-bottom: 20px; padding-top: 20px;">
                          <label class="mb-3"><small>TikTok post rate <span>*</span></small></label>
                          <input
                            type="text"
                            placeholder="Enter your answer here"
                            :class="`form-control e-input ${ form[4].errors.tiktok_post_rate ? 'is-invalid' : '' }`"
                            v-model="form[4].tiktok_post_rate"
                          >
                          <div
                            class="invalid-feedback"
                            v-if="form[4].errors.tiktok_post_rate"
                            v-text="form[4].errors.tiktok_post_rate[0]"
                          ></div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- || DONE -->
              <div v-if="currentStep > totalSteps">
                <div class="text-center">
                  <h5 class="font-weight-normal">Thank you for your participation.</h5>
                  <h5 class="font-weight-normal">We will get back to you as soon as possible.</h5>
                </div>

                <div class="mt-4 text-center">
                  <small>Click here to visit our page for more information</small>

                  <div
                    class="d-flex justify-content-center align-items-end mt-2"
                    style="gap: 12px;"
                  >
                    <a
                      href="https://www.facebook.com/PBInfluencerCircle"
                      target="__blank"
                      rel="noopener noreferrer"
                    >
                      <img
                        src="/img/icon-fb.svg"
                        alt="fb icon"
                      >
                    </a>

                    <a
                      class="d-flex align-items-center text-decoration-none"
                      href="https://www.instagram.com/purplebuginfluencercircle/"
                      target="__blank"
                      rel="noopener noreferrer"
                    >
                      <img
                        src="/img/icon-ig.png"
                        alt="ig icon"
                        height="21"
                        width="21"
                      >

                      <span class="ml-1 c-font--purple font-weight-bold">Influencercircle</span>
                    </a>
                  </div>
                </div>

                <div class="d-flex justify-content-center py-5">
                  <button
                    class="btn btn-purple"
                    data-dismiss="modal"
                  >Back to Influencer Circle</button>
                </div>
              </div>
            </form>

            <!-- || Steppers -->
            <div
              class="mt-5 py-4 border-0"
              v-if="currentStep != 0 && currentStep <= totalSteps"
            >
              <!-- || stepper-nav -->
              <div class="c-stepper-nav">
                <button
                  class="btn btn--back"
                  v-if="currentStep > 1"
                  @click.prevent="prevStep"
                >Back</button>
                <button
                  :class="['btn btn--cancel', {'order-1': currentStep == 1}]"
                  data-dismiss="modal"
                  @click="initialState"
                >Cancel</button>
                <button
                  :class="['btn btn-purple btn--next', {'order-2': currentStep == 2}]"
                  :disabled="submitting || (othersChecked && form[2].content_category.others == '')"
                  v-text="currentStep == totalSteps ? 'Submit' : 'Next'"
                  @click.prevent="nextStep"
                ></button>
              </div>

              <!-- | stepper-icons -->
              <div class="c-steppers mt-4">
                <button
                  type="button"
                  :class="['stepper-wrap', {'stepper--done': step < currentStep, 'stepper--current' : step == currentStep}]"
                  v-for="step in totalSteps"
                  :key="step"
                >
                  <span class="stepper-circle"></span>
                  <span class="stepper-connect"></span>
                </button>

                <div class="stepper-wrap">
                  <span class="stepper-circle"></span>
                  <span class="stepper-connect"></span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      accepted: false,
      content_categories: [
        'lifestyle',
        'beauty',
        'mom',
        'food',
        'fitness'
      ],
      form: {
        1: {
          current_step: 1,
          name: "",
          age: "",
          sex: "",
          email: "",
          contact_number: "",
          errors: {},
        },
        2: {
          current_step: 2,
          content_category: {
            lifestyle: false,
            beauty: false,
            mom: false,
            food: false,
            fitness: false,
            others: ""
          },
          total_followers: "",
          errors: {},
        },
        3: {
          current_step: 3,
          facebook_page_url: "",
          facebook_post_rate: "",
          instagram_page_url: "",
          instagram_post_rate: "",
          instagram_video_post_rate: "",
          errors: {},
        },
        4: {
          current_step: 4,
          youtube_page_url: "",
          youtube_post_rate: "",
          tiktok_page_url: "",
          tiktok_post_rate: "",
          errors: {},
        }
      },
      othersChecked: false,
      disabled: false,
      totalSteps: 4,
      currentStep: 0,
      submitting: false
    }
  },

  computed: {
    othersField() {
      return this.form[2].content_category.others;
    }
  },

  watch: {
    othersField(val) {
      if (val !== '') return this.othersChecked = true;
    }
  },

  methods: {
    initialState() {
      $("#influencerForm-modal").modal("hide");
      Object.assign(this.$data, this.$options.data());
    },

    getStarted() {
      if (this.accepted) {
        this.currentStep = 1
      }
    },

    prevStep() {
      if (this.currentStep > 1) {
        this.currentStep--;
      }
    },

    nextStep() {
      let currentForm = {};

      if (this.currentStep < this.totalSteps) {
        currentForm = { ...this.form[this.currentStep] }

        this.submitting = true;
        return axios.post('/service/influencer-register', currentForm)
          .then(({ data }) => {
            this.form[this.currentStep].errors = {};
            return this.currentStep++
          })
          .catch(({ response }) => {
            this.form[this.currentStep].errors = response.data.errors
          })
          .finally(() => this.submitting = false)
      }

      currentForm = { ...this.form[1], ...this.form[2], ...this.form[3], ...this.form[4] }
      currentForm.current_step = 'all';

      this.submitting = true;

      return grecaptcha.ready(() => {
        grecaptcha.execute(this.$root.grecaptcha_sitekey, { action: 'register_influencer' })
          .then((token) => {
            currentForm.recaptcha = token;

            axios.post('/service/influencer-register', currentForm)
              .then(({ data }) => {
                return this.currentStep++
              })
              .catch(({ response }) => {
                Object.keys(response.data.errors).map(error => {
                  const formStep = Object.keys(this.form).filter(step => this.form[step].hasOwnProperty(error));
                  if (formStep.length > 0) {
                    this.form[formStep].errors[error] = response.data.errors[error]
                  }
                })

                Object.values(this.form).forEach(step => {
                  if (Object.keys(step.errors).length > 0 && step.current_step != this.totalSteps) {
                    return this.currentStep = step.current_step
                  }

                  Object.keys(this.form[step.current_step].errors).map(error => {
                    if (!Object.keys(response.data.errors).includes(error)) {
                      this.$delete(this.form[step.current_step].errors, error)
                    }
                  })
                })

                if (response.data.errors.recaptcha) {
                  console.error(response.data.errors.recaptcha[0])
                  flash(`${response.data.errors.recaptcha[0]} Please refresh your browser`, 'danger')
                }
              })
              .finally(() => this.submitting = false)
          });
      });

    }
  }
};
</script>

<style scoped>
.mb-20px {
  margin-bottom: 20px;
}

.pb-20px {
  padding-bottom: 20px;
}

.pb-40px {
  padding-bottom: 40px;
}

.order-1 {
  order: 1 !important;
}
.order-2 {
  order: 2 !important;
}
</style>
