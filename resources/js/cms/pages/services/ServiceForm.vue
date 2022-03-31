<template>
  <div class="cms-page-wrapper">
    <page-loader v-if="submitting" />

    <div class="cms-page homepage">
      <div class="header-title mb-4">
        <h1 v-text="formTitle"></h1>
      </div>

      <form class="">
        <!-- banner -->
        <div id="banner" class="form-group mt-4">
          <label
            >Banner
            <small
              class="text-danger"
              v-if="errors.banner"
              v-text="errors.banner[0]"
            ></small>
          </label>

          <preview-image-input
            class="banner--image"
            ref="previewImg"
            max_size="5mb"
            max_dimension="1920x614"
            v-model="form.banner"
          />
        </div>

        <!-- title < > alt text -->
        <div class="form-row mt-4">
          <div id="title" class="col-md-6">
            <div class="form-group">
              <label>Service Name</label>

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
          </div>

          <div id="alt_text" class="col-md-6">
            <div class="form-group">
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

        <!-- description -->
        <div class="form-row mt-4">
          <div id="description" class="col-md-6">
            <div class="form-group">
              <label>Description</label>

              <tinymce-editor
                api-key="q5eqi5jopju01p1l2xpwn411by2u4oxvo9men2va1eey6m4w"
                :init="tinymceInit()"
                rows="13"
                v-model="form.description"
              ></tinymce-editor>

              <small
                class="text-danger"
                v-if="errors.description"
                v-text="errors.description[0]"
              ></small>
            </div>
          </div>

          <div id="thumbnail" class="col-md-6">
            <div class="form-group">
              <label>Thumbnail</label>

              <preview-image-input
                class="banner--image"
                style="height: 318px"
                ref="previewImg"
                max_size="5mb"
                max_dimension="1920x614"
                v-model="form.thumbnail"
              />

              <small
                class="text-danger"
                v-if="errors.thumbnail"
                v-text="errors.thumbnail[0]"
              ></small>
            </div>
          </div>
        </div>

        <!-- we offer -->
        <div id="offers" class="form-group mt-4">
          <label> We Offer <span class="icon-edit ml-2"></span></label>

          <div class="partners-section edit--section" style="max-height: 100vh">
            <div class="partners-container weOffer-container">
              <div
                class="card mb-3"
                v-for="(offer, index) in form.offers"
                :key="index"
              >
                <div class="card-body">
                  <form class="partner-details">
                    <div class="form-group">
                      <label>Heading</label>

                      <input
                        type="text"
                        :class="`form-control ${
                          form.offers[index].errors &&
                          form.offers[index].errors.heading
                            ? 'is-invalid'
                            : ''
                        }`"
                        v-model="form.offers[index].heading"
                      />

                      <div
                        class="invalid-feedback"
                        v-if="
                          form.offers[index].errors &&
                          form.offers[index].errors.heading
                        "
                        v-text="form.offers[index].errors.heading[0]"
                      ></div>
                    </div>

                    <div class="form-group">
                      <label>Body</label>

                      <tinymce-editor
                        api-key="q5eqi5jopju01p1l2xpwn411by2u4oxvo9men2va1eey6m4w"
                        :init="tinymceInit()"
                        v-model="form.offers[index].body"
                      ></tinymce-editor>

                      <small
                        class="text-danger"
                        v-if="
                          form.offers[index].errors &&
                          form.offers[index].errors.body
                        "
                        v-text="form.offers[index].errors.body[0]"
                      ></small>
                    </div>
                  </form>

                  <div class="partnerCard-footer row no-gutters">
                    <div
                      class="align-items-center align-items-end col d-flex justify-content-between mt-4"
                    >
                      <button
                        class="btn btn-sm btn-remove"
                        @click.prevent="removeOffer(offer, index)"
                      >
                        <span class="icon-remove"></span>
                        Remove
                      </button>

                      <div class="d-flex flex-wrap justify-content-end">
                        <button
                          class="btn btn-sm btn-cancel"
                          :disabled="!isEdit"
                          @click.prevent="cancelSaveOffer(offer, index)"
                        >
                          Cancel
                        </button>
                        <button
                          class="btn btn-sm btn-purple-round"
                          :disabled="!isEdit"
                          @click.prevent="saveOffer(offer, index)"
                        >
                          Save
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="card card-addMore mb-3">
                <button class="btn-addMore" @click.prevent="addOffer">
                  <span class="icon-addMore"></span>
                  <h3 class="mt-2 mb-0">Add</h3>
                </button>
              </div>
            </div>
          </div>
        </div>

        <!-- did you know -->
        <div id="facts" class="form-group mt-4">
          <label> Did you know <span class="icon-edit ml-2"></span></label>

          <div class="partners-section edit--section" style="max-height: unset">
            <div class="form-group">
              <label>Body</label>

              <tinymce-editor
                api-key="q5eqi5jopju01p1l2xpwn411by2u4oxvo9men2va1eey6m4w"
                :init="tinymceInit()"
                rows="15"
                v-model="form.facts"
              ></tinymce-editor>

              <small
                class="text-danger"
                v-if="errors.facts"
                v-text="errors.facts[0]"
              ></small>
            </div>

            <div class="d-flex justify-content-end mt-3">
              <button
                class="btn btn-cancel"
                :disabled="!isEdit"
                @click.prevent="cancelFactsUpdate"
              >
                Cancel
              </button>
              <button
                class="btn btn-purple-round"
                :disabled="!isEdit || submitting"
                @click.prevent="updateFacts"
              >
                Save
              </button>
            </div>
          </div>
        </div>

        <!-- testimonials -->
        <div id="testimonials" class="form-group mt-4">
          <label>
            Let's hear it from them <span class="icon-edit ml-2"></span
          ></label>

          <div class="partners-section edit--section" style="max-height: 90vh">
            <div class="partners-container">
              <div
                class="card mb-3"
                v-for="(testimonial, index) in testimonials"
                :key="index"
              >
                <div class="card-body row">
                  <div class="col-md-3 d-flex flex-column">
                    <label>Image</label>

                    <div class="partner-image mb-2">
                      <img
                        class="img-fluid"
                        :src="`${testimonials[index].tempImage}`"
                        v-if="fileInstance(testimonials[index].image)"
                      />

                      <img
                        class="img-fluid"
                        :src="`${
                          testimonials[index].image && testimonials[index].id
                            ? testimonials[index].imagePath
                            : ''
                        }`"
                        v-else
                      />
                    </div>

                    <!-- upload button -->
                    <div
                      class="d-flex border"
                      v-if="fileInstance(testimonials[index].image)"
                    >
                      <input
                        type="text"
                        class="form-control w-100 border-0"
                        readonly
                        :ref="`testimonialImage_${index}`"
                        :value="testimonials[index].image.name"
                      />

                      <button
                        type="button"
                        class="btn btn-link"
                        style="min-width: 0"
                        @click="removeTestimonialImg(index)"
                      >
                        <span>✖</span>
                      </button>
                    </div>

                    <label v-else>
                      <button
                        class="btn btn-outline-purple-round w-100"
                        @click.prevent="selectTestimonialImg(index)"
                      >
                        Upload
                      </button>

                      <input
                        class="d-none"
                        name="file"
                        type="file"
                        :ref="`testimonialImage_${index}`"
                        @change="onTestimonialImgPick($event, index)"
                      />
                    </label>

                    <small>Max of 2mb only</small>
                    <small>631x688 px jpg or png</small>
                    <small
                      class="text-danger"
                      v-if="
                        testimonials[index].errors &&
                        testimonials[index].errors.image
                      "
                      v-text="testimonials[index].errors.image[0]"
                    ></small>
                  </div>

                  <div class="col-md-9 row">
                    <div class="col-md-5">
                      <div class="form-group">
                        <label>Client Name</label>

                        <input
                          type="text"
                          :class="`form-control ${
                            testimonials[index].errors &&
                            testimonials[index].errors.name
                              ? 'is-invalid'
                              : ''
                          }`"
                          v-model="testimonials[index].name"
                        />

                        <div
                          class="invalid-feedback"
                          v-if="
                            testimonials[index].errors &&
                            testimonials[index].errors.name
                          "
                          v-text="testimonials[index].errors.name[0]"
                        ></div>
                      </div>

                      <div class="form-group">
                        <label>Client Position</label>

                        <input
                          type="text"
                          :class="`form-control ${
                            testimonials[index].errors &&
                            testimonials[index].errors.position
                              ? 'is-invalid'
                              : ''
                          }`"
                          v-model="testimonials[index].position"
                        />

                        <div
                          class="invalid-feedback"
                          v-if="
                            testimonials[index].errors &&
                            testimonials[index].errors.position
                          "
                          v-text="testimonials[index].errors.position[0]"
                        ></div>
                      </div>
                    </div>

                    <div class="col-md-7">
                      <div class="form-group">
                        <label>Body</label>

                        <tinymce-editor
                          api-key="q5eqi5jopju01p1l2xpwn411by2u4oxvo9men2va1eey6m4w"
                          :init="tinymceInit()"
                          v-model="testimonials[index].body"
                        ></tinymce-editor>

                        <small
                          class="text-danger"
                          v-if="
                            testimonials[index].errors &&
                            testimonials[index].errors.body
                          "
                          v-text="testimonials[index].errors.body[0]"
                        ></small>

                        <div class="d-flex justify-content-end mt-3">
                          <button
                            class="btn btn-remove"
                            @click.prevent="
                              removeTestimonial(testimonial, index)
                            "
                          >
                            <span class="icon-remove"></span> Remove
                          </button>

                          <button
                            class="btn btn-cancel"
                            :disabled="!isEdit"
                            @click.prevent="cancelSaveTestimonial(index)"
                          >
                            Cancel
                          </button>
                          <button
                            class="btn btn-purple-round ml-2"
                            :disabled="!isEdit"
                            @click.prevent="saveTestimonial(testimonial, index)"
                          >
                            Save
                          </button>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="card card-addMore mb-3">
                <button class="btn-addMore" @click.prevent="addTestimonial">
                  <span class="icon-addMore"></span>
                  <h3 class="mt-2 mb-0">Add</h3>
                </button>
              </div>
            </div>
          </div>
        </div>
      </form>
    </div>

    <div id="manageSeo" class="seo-container mt-5 mb-5">
      <div class="seo-wrap">
        <form class="row mr-0">
          <div class="col-md-3">
            <p>For Seo</p>
            <small>
              <span class="icon-info"></span>
              These fields are for SEO purposes only.
            </small>
          </div>

          <div class="col-md-4">
            <div id="meta_title" class="form-group">
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

            <div id="meta_keywords" class="form-group">
              <label>Meta Keyword</label>

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

          <div id="meta_description" class="col-md-4">
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
        </form>
      </div>

      <div class="seo-footer mt-4">
        <div>
          <button class="btn btn-cancel" @click.prevent="cancelForm">
            Cancel
          </button>
          <button
            class="btn btn-purple-round"
            v-text="submitting ? 'Saving ...' : 'Submit'"
            :disabled="submitting"
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
import PreviewImageInput from "../../components/PreviewImageInput";
import Wysiwyg from "../../mixins/Wysiwyg";

export default {
  components: {
    "tinymce-editor": Editor,
    PreviewImageInput,
    PageLoader,
  },

  mixins: [Wysiwyg],

  data() {
    return {
      form: {
        banner: "",
        thumbnail: "",
        title: "",
        alt_text: "",
        description: "",
        offers: [],
        facts: "",
        meta_title: "",
        meta_keywords: "",
        meta_description: "",
      },
      testimonials: [],
      errors: {},
      submitting: false,
      isEdit: false,
      originalData: {},
      serviceSlug: ",",
    };
  },

  created() {
    const serviceId = this.$route.params.id;

    if (serviceId) {
      this.isEdit = true;

      this.getService(serviceId);
    }
  },

  computed: {
    formTitle() {
      return this.isEdit ? "Edit Service" : "Add Service";
    },
  },

  methods: {
    // WE OFFER SECTION
    addOffer() {
      this.form.offers.push({
        id: Math.random().toString(36).substr(2, 9),
        heading: "",
        body: "",
      });
    },

    cancelSaveOffer(offer, index) {
      const offerExist = this.originalData.offers.find(
        (origOffer) => origOffer.id == offer.id
      );

      if (offerExist) {
        const origIndex = this.originalData.offers.findIndex(
          (v) => v.id == offer.id
        );

        Object.keys(offer).map((key) => {
          this.form.offers[index][key] = this.originalData.offers[origIndex][
            key
          ];
        });
      } else {
        Object.keys(offer).map((key) => {
          this.form.offers[index][key] = "";
        });

        this.form.offers[index].id = Math.random().toString(36).substr(2, 9);
      }
    },

    saveOffer(offer, index) {
      axios
        .put(`/cms/pages/service-offer/${this.$route.params.id}`, offer)
        .then(({ data }) => {
          this.$delete(this.form.offers[index], "errors");

          const offerExist = this.originalData.offers.find(
            (origOffer) => origOffer.id == offer.id
          );
          if (offerExist) {
            const origIndex = this.originalData.offers.findIndex(
              (v) => v.id == offer.id
            );

            Object.keys(offer).map((key) => {
              this.originalData.offers[origIndex][key] = offer[key];
            });
          } else {
            this.originalData.offers.push(JSON.parse(JSON.stringify(offer)));
          }

          flash(data.success);
        })
        .catch(({ response }) => {
          this.$set(this.form.offers[index], "errors", response.data.errors);
        });
    },

    removeOffer(offer, index) {
      if (this.isEdit) {
        const offerExist = this.originalData.offers.find(
          (origOffer) => origOffer.id == offer.id
        );

        if (offerExist) {
          return axios
            .delete(
              `/cms/pages/service-offer/${this.$route.params.id}/delete/${offer.id}`
            )
            .then(({ data }) => {
              const origIndex = this.originalData.offers.findIndex(
                (v) => v.id == offer.id
              );

              this.$delete(this.form.offers, index);
              this.$delete(this.originalData.offers, origIndex);
              flash(data.success);
            })
            .catch(({ response }) => {
              flash(response.data.message);
            });
        }
      }

      this.$delete(this.form.offers, index);
    },

    // TESTIMONIALS SECTION
    addTestimonial() {
      this.testimonials.push({
        image: "",
        name: "",
        position: "",
        body: "",
      });
    },

    cancelSaveTestimonial(index) {
      const originalData = this.testimonials[index].originalData;

      if (originalData) {
        if (this.testimonials[index].errors) {
          this.testimonials[index].errors = "";
        }

        return Object.keys(originalData).map((attribute) => {
          this.testimonials[index][attribute] = originalData[attribute];
        });
      }

      return Object.keys(this.testimonials[index]).map((attribute) => {
        this.testimonials[index][attribute] = "";
      });
    },

    saveTestimonial(testimonial, index) {
      const testimonialformData = new FormData();
      const testimonialForm = Object.keys(testimonial).reduce(
        (data, attribute) => {
          testimonialformData.append(attribute, testimonial[attribute]);
          return testimonialformData;
        },
        {}
      );

      if (testimonial.id) {
        testimonialformData.append("_method", "PUT");
        if (!(testimonial.image instanceof File)) {
          testimonialformData.delete("image");
        }
      }

      testimonialformData.append("withValidation", true);

      const testimonialUrl = testimonial.id ? `/${testimonial.id}` : "";

      axios
        .post(
          `/cms/pages/services/${this.$route.params.id}/testimonials${testimonialUrl}`,
          testimonialForm,
          {
            headers: { "Content-Type": "multipart/form-data" },
          }
        )
        .then(({ data }) => {
          this.$delete(this.testimonials[index], "errors");

          Object.keys(data.testimonial).map((key) => {
            this.testimonials[index][key] = data.testimonial[key];
          });

          flash(data.success);
        })
        .catch(({ response }) => {
          this.$set(this.testimonials[index], "errors", response.data.errors);
        });
    },

    removeTestimonial(testimonial, index) {
      if (testimonial.id) {
        return axios
          .delete(
            `/cms/pages/services/${this.$route.params.id}/testimonials/${testimonial.id}`
          )
          .then(({ data }) => {
            this.$delete(this.testimonials, index);
            flash(data.success);
          })
          .catch(({ response }) => {
            flash(response.data.message);
          });
      }

      this.$delete(this.testimonials, index);
    },

    selectTestimonialImg(index) {
      this.$refs[`testimonialImage_${index}`][0].click();
    },

    onTestimonialImgPick(event, index) {
      const files = event.target.files;
      const fileReader = new FileReader();

      fileReader.readAsDataURL(files[0]);

      if (files[0].size > 2048000) {
        return flash("Max of 2mb only!", "danger");
      }

      fileReader.onload = (evt) => {
        let img = new Image();
        img.src = evt.target.result;

        img.onload = (e) => {
          if (e.path[0].naturalWidth > 631 || e.path[0].naturalHeight > 688) {
            return flash("Max of 631x688 only!", "danger");
          }

          this.testimonials[index].image = files[0];
          this.$set(this.testimonials[index], "tempImage", evt.target.result);
        };
      };
    },

    removeTestimonialImg(index) {
      if (this.testimonials[index].hasOwnProperty("originalData")) {
        this.testimonials[index].image = this.testimonials[
          index
        ].originalData.image;
      } else {
        this.testimonials[index].image = "";
      }

      this.$delete(this.testimonials[index], "tempImage");
    },

    fileInstance(file) {
      if (file instanceof File) {
        return true;
      }

      return false;
    },

    // == == == == == ==
    cancelForm() {
      /* if (this.isEdit) {
        return this.getService(this.$route.params.id);
      } */

      this.$router.push({
        name: "ServicesIndex",
        hash: "#servicesTable",
      });
    },

    save() {
      // offers list validation
      const emptyOffers = this.form.offers.map((offer, index) => {
        let emptyProps = [];
        Object.keys(offer).map((key) => {
          if (offer[key] === "") {
            emptyProps.push(key);
          }
        });
        if (emptyProps.length > 0) return emptyProps;
      });
      const noEmptyOffers = emptyOffers.every((offer) => offer == undefined);
      if (!noEmptyOffers || this.form.offers.length < 1) {
        const element = document.querySelector("#offers");

        element.scrollIntoView({
          behavior: "smooth",
          block: "end",
          inline: "nearest",
        });
        return flash("Please fill out all on the Offers section!", "danger");
      }

      // testimonials list validation
      const emptyTestimonials = this.testimonials.map((testimonial, index) => {
        let emptyProps = [];
        Object.keys(testimonial).map((key) => {
          if (testimonial[key] === "") {
            emptyProps.push(key);
          }
        });
        if (emptyProps.length > 0) return emptyProps;
      });
      const noEmptyTestimonials = emptyTestimonials.every(
        (testimonial) => testimonial == undefined
      );
      if (!noEmptyTestimonials && this.testimonials.length >= 1) {
        const element = document.querySelector("#testimonials");

        element.scrollIntoView({
          behavior: "smooth",
          block: "end",
          inline: "nearest",
        });
        return flash(
          "Please fill out all on the Testimonials section!",
          "danger"
        );
      }

      this.submitting = true;

      const formData = new FormData();
      const form = Object.keys(this.form).reduce((data, attribute) => {
        formData.append(attribute, this.form[attribute]);
        if (Array.isArray(this.form[attribute])) {
          formData.append(attribute, JSON.stringify(this.form[attribute]));
        }
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
      axios
        .post(`/cms/pages/services${url}`, form, {
          headers: { "Content-Type": "multipart/form-data" },
        })
        .then(({ data }) => {
          flash(data.success);
          this.errors = {};

          this.testimonials.forEach((testimonial) => {
            const testimonialformData = new FormData();
            const testimonialForm = Object.keys(testimonial).reduce(
              (data, attribute) => {
                testimonialformData.append(attribute, testimonial[attribute]);
                return testimonialformData;
              },
              {}
            );

            if (testimonial.id) {
              testimonialformData.append("_method", "PUT");
              if (!(testimonial.image instanceof File)) {
                testimonialformData.delete("image");
              }
            }

            const testimonialUrl = testimonial.id ? `/${testimonial.id}` : "";
            const serviceId = this.isEdit
              ? this.$route.params.id
              : data.service.id;

            axios
              .post(
                `/cms/pages/services/${serviceId}/testimonials${testimonialUrl}`,
                testimonialForm,
                {
                  headers: { "Content-Type": "multipart/form-data" },
                }
              )
              .then(({ data }) => {
                //
              })
              .catch(({ response }) => {
                flash(response.data.message);
              });
          });

          this.submitting = false;

          this.$router.push({
            name: "ServicesIndex",
            hash: "#servicesTable",
          });
        })
        .catch(({ response }) => {
          this.errors = response.data.errors;
          this.submitting = false;

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

    async getService(serviceId) {
      await axios
        .get(`/cms/pages/services/edit/${serviceId}`)
        .then(({ data }) => {
          const service = data.service;

          for (let prop in service) {
            if (this.form.hasOwnProperty(prop)) {
              this.form[prop] = service[prop];
              this.originalData[prop] = service[prop];
            }
          }

          for (let prop in service.seo) {
            if (this.form.hasOwnProperty(prop)) {
              this.form[prop] = service.seo[prop];
              this.originalData[prop] = service.seo[prop];
            }
          }

          this.form.banner = service.bannerPath;
          this.originalData.banner = service.bannerPath;
          this.form.thumbnail = service.thumbnailPath;
          this.originalData.thumbnail = service.thumbnailPath;
          this.originalData.offers = JSON.parse(JSON.stringify(service.offers));
          this.serviceSlug = service.slug;

          const testimonials = Object.values(service.testimonials).map(
            (testimonial, i) => {
              testimonial.originalData = { ...testimonial };

              return testimonial;
            }
          );

          this.testimonials = testimonials;
        })
        .catch(({ response }) => {
          flash(response.data.message);
        });
    },

    // DID YOU KNOW SECTION
    cancelFactsUpdate() {
      this.form.facts = this.originalData.facts;
    },

    updateFacts() {
      this.submitting = true;

      const payload = {
        facts: this.form.facts,
      };

      axios
        .put(`/cms/pages/services-facts/${this.$route.params.id}`, payload)
        .then(({ data }) => {
          flash(data.success);
          this.submitting = false;
          this.originalData.facts = this.form.facts;
        })
        .catch(({ response }) => {
          this.errors = response.data.errors;
          this.submitting = false;
        });
    },
  },
};
</script>

<style lang="scss" scoped>
.weOffer-container {
  grid-template-columns: repeat(2, 1fr);
  grid-gap: 10px;
}

.card-addMore {
  height: unset;
  .btn-addMore {
    height: 100%;
  }
}
</style>