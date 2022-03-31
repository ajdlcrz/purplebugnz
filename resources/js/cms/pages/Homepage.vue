<template>
  <div class="cms-page-wrapper">
    <page-loader v-if="disabled" />

    <div class="cms-page homepage pt-4 mb-5">
      <div class="header-title mb-4">
        <h1>Homepage</h1>
      </div>

      <div id="homepageBanners">
        <h6>Banner</h6>

        <div class="banners-section edit--section">
          <div class="banners-container">
            <banner
              ref="refHomeBanner"
              v-for="(banner, index) in banners"
              :key="banner.id"
              :banner="banner"
              @saved="savedBanner($event, index)"
              @remove="removeBanner(index, banner.id)"
            />

            <div class="card card-addMore mb-3">
              <button class="btn-addMore" @click="addBanner">
                <span class="icon-addMore"></span>
                <h3 class="mt-2 mb-0">Add</h3>
              </button>
            </div>
          </div>
        </div>
      </div>

      <div id="homepagePartners" class="mt-4">
        <h6>Our Partners <small class="icon-edit ml-2"></small></h6>

        <div class="partners-section edit--section">
          <div class="form-group edit-partnersBody">
            <label>
              Body
              <small
                class="text-danger"
                v-if="partners.errors.body"
                v-text="partners.errors.body[0]"
              ></small>
            </label>

            <tinymce-editor
              api-key="q5eqi5jopju01p1l2xpwn411by2u4oxvo9men2va1eey6m4w"
              rows="5"
              :init="tinymceInit()"
              v-model="partners.body"
            ></tinymce-editor>

            <div class="d-flex justify-content-end mt-3">
              <button
                class="btn btn-purple-round ml-2"
                @click="savePartnerSection"
              >
                Save
              </button>
            </div>
          </div>

          <p>Logo</p>

          <homepage-partners ref="refPartners" />
        </div>
      </div>

      <div id="whyPB" class="mt-4">
        <h6>Why PurpleBug <small class="icon-edit ml-2"></small></h6>

        <div class="why-section edit--section">
          <div class="card col-md-11 mb-3">
            <div class="card-body row">
              <div class="col-md-6 d-flex flex-column">
                <label> Background Image </label>

                <preview-image-input
                  id="whyImg"
                  class="why-background"
                  ref="footerBackground"
                  max_size="5mb"
                  max_dimension="1920x614"
                  path="/storage/homepage/footer"
                  v-model="whyPB.image"
                />

                <small
                  class="text-danger"
                  v-if="whyPB.errors.image"
                  v-text="whyPB.errors.image[0]"
                ></small>
              </div>

              <div class="col-md-6">
                <div class="form-group mb-0">
                  <label>Body</label>

                  <tinymce-editor
                    api-key="q5eqi5jopju01p1l2xpwn411by2u4oxvo9men2va1eey6m4w"
                    rows="10"
                    :init="tinymceInit()"
                    v-model="whyPB.body"
                  ></tinymce-editor>

                  <small
                    class="text-danger"
                    v-if="whyPB.errors.body"
                    v-text="whyPB.errors.body[0]"
                  ></small>
                </div>
              </div>
            </div>

            <div class="card-footer">
              <div class="form-group col-md-6">
                <label>Link</label>

                <input
                  type="text"
                  :class="`form-control ${
                    whyPB.errors.link ? 'is-invalid' : ''
                  }`"
                  v-model="whyPB.link"
                />

                <div
                  class="invalid-feedback"
                  v-if="whyPB.errors.link"
                  v-text="whyPB.errors.link[0]"
                ></div>
              </div>

              <div>
                <button class="btn btn-cancel" @click="cancelSaveFooter">
                  Cancel
                </button>
                <button
                  class="btn btn-purple-round"
                  @click.prevent="saveFooterBanner()"
                >
                  Save
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <seo-form
      ref="seoForm"
      url="/cms/pages/update-seo/homepage"
      :data="sections[3].contents"
    />

    <div class="d-flex justify-content-end pb-4 mb-4" style="margin-right: 15%">
      <div>
        <button class="btn btn-cancel" @click="cancelAll">Cancel</button>
        <button
          class="btn btn-purple-round"
          :disabled="disabled"
          v-text="disabled ? 'Saving ...' : 'Save'"
          @click="saveAll"
        ></button>
      </div>
    </div>
  </div>
</template>

<script>
import PageLoader from "../components/PageLoader";
import Editor from "@tinymce/tinymce-vue";
import Wysiwyg from "../mixins/Wysiwyg";
import PreviewImageInput from "../components/PreviewImageInput";
import Banner from "../components/homepage/Banner";
import Partners from "../components/homepage/Partners";
import SeoForm from "../components/SeoForm";

export default {
  props: ["sections"],
  components: {
    PageLoader,
    "tinymce-editor": Editor,
    PreviewImageInput,
    Banner,
    "homepage-partners": Partners,
    SeoForm,
  },
  mixins: [Wysiwyg],

  data() {
    return {
      banners: JSON.parse(JSON.stringify(this.sections[0].contents)),
      partners: {
        body: this.sections[1].body,
        errors: {},
      },
      whyPB: {
        ...this.sections[2].contents,
        originalData: this.sections[2].contents,
        errors: {},
      },
      responses: [],
      disabled: false,
    };
  },

  methods: {
    addBanner() {
      this.banners.push({
        image: "",
        heading: "",
        body: "",
        btn_label: "",
        btn_link: "",
        id: Math.random().toString(36).substr(2, 9),
      });
    },

    savedBanner(payload, index) {
      Object.keys(this.banners[index]).reduce((data, attribute) => {
        this.banners[index][attribute] = payload[attribute];
      }, {});
    },

    removeBanner(index, id) {
      axios
        .put("/cms/pages/homepage/delete-banner", { id })
        .then(({ data }) => {
          if (data.success) {
            flash(data.success);
          }
          this.banners.splice(index, 1);
        })
        .catch(({ response }) => {
          flash(response.data.message, "danger");
        });
    },

    async savePartnerSection(withFlash = true) {
      return await axios
        .put("/cms/pages/homepage/partners", this.partners)
        .then(({ data }) => {
          this.partners.errors = {};

          if (withFlash) {
            flash(data.success);
          }

          return this.responses.push("success");
        })
        .catch(({ response }) => {
          this.partners.errors = response.data.errors;

          return this.responses.push("#homepagePartners");
        });
    },

    cancelSaveFooter() {
      this.whyPB.errors = {};

      Object.keys(this.whyPB.originalData).map((attribute) => {
        this.whyPB[attribute] = this.whyPB.originalData[attribute];
      });

      const image = this.whyPB.image
        ? `/storage/homepage/footer/${this.whyPB.image}`
        : this.whyPB.image;

      this.$refs.footerBackground.imageData = image;
    },

    async saveFooterBanner(withFlash = true) {
      const formData = new FormData();
      const data = Object.keys(this.whyPB).reduce((data, attribute) => {
        let value = this.whyPB[attribute];

        value
          ? formData.append(attribute, value)
          : formData.append(attribute, "");

        return formData;
      }, {});

      formData.append("_method", "PUT");
      formData.delete("errors");
      formData.delete("originalData");
      if (!(this.whyPB.image instanceof File)) {
        formData.delete("image");
      }

      return await axios
        .post("/cms/pages/homepage/footer_banner", data)
        .then(({ data }) => {
          this.whyPB.errors = {};

          Object.keys(this.whyPB.originalData).map((attribute) => {
            this.whyPB.originalData[attribute] = data.footer[attribute];
          });

          if (withFlash) {
            flash(data.success);
          }

          return this.responses.push("success");
        })
        .catch(({ response }) => {
          this.whyPB.errors = response.data.errors;

          return this.responses.push("#whyPB");
        });
    },

    async saveAll() {
      this.responses = [];
      this.disabled = true;

      await Promise.all([
        this.$refs.refHomeBanner.forEach(async (banner) => {
          await banner.save(false);
        }),

        await this.savePartnerSection(false),

        this.$refs.refPartners.partners.forEach(async (partner) => {
          await this.$refs.refPartners.savePartner(partner, false);
        }),

        await this.saveFooterBanner(false),
        await this.$refs.seoForm.saveSeo(false),
      ]).then((response) => {
        this.disabled = false;

        if (this.responses.every((res) => res == "success")) {
          return flash("Homepage has been updated!");
        }

        const errors = this.responses.filter((res) => res !== "success");
        const element = document.querySelector(errors[0]);

        // return this.$refs[ref].$el.scrollIntoView(); // <-- alternative scroll
        return window.scrollTo({ top: element.offsetTop, behavior: "smooth" });
      });
    },

    cancelAll() {
      return location.reload();
    },
  },
};
</script>

<style scoped>
/*  */
</style>