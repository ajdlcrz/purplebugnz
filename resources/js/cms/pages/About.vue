<template>
  <div class="cms-page-wrapper">
    <page-loader v-if="disabled" />

    <div class="cms-page homepage">
      <div class="header-title mb-4">
        <h1>About Us</h1>
      </div>

      <banner-form
        ref="bannerForm"
        url="/cms/pages/update-banner/about"
        :data="bannerContents"
        v-if="pageContents.length > 0"
      />

      <div id="ourApproach" class="mt-4">
        <p class="font-weight-bold">Our Approach</p>

        <div class="card mt-3">
          <div class="card-body">
            <div class="form-group">
              <label class="font-weight-bold">Body</label>

              <tinymce-editor
                api-key="q5eqi5jopju01p1l2xpwn411by2u4oxvo9men2va1eey6m4w"
                rows="10"
                :init="tinymceInit()"
                v-model="approach.body"
              ></tinymce-editor>

              <small
                class="text-danger"
                v-if="approach.errors && approach.errors.body"
                v-text="approach.errors.body[0]"
              ></small>
            </div>

            <div class="d-flex justify-content-end">
              <div>
                <button class="btn btn-cancel" @click="cancelApproach">
                  Cancel
                </button>
                <button class="btn btn-purple-round" @click="saveApproach">
                  Save
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div id="whyPurple" class="mt-4">
        <p class="font-weight-bold">
          Why PurpleBug
          <small class="icon-edit ml-2"></small>
        </p>

        <div class="card mt-3">
          <div class="card-body">
            <div class="form-group">
              <label class="font-weight-bold">Body</label>

              <tinymce-editor
                api-key="q5eqi5jopju01p1l2xpwn411by2u4oxvo9men2va1eey6m4w"
                rows="10"
                :init="tinymceInit()"
                v-model="why_pb.body"
              ></tinymce-editor>

              <small
                class="text-danger"
                v-if="why_pb.errors && why_pb.errors.body"
                v-text="why_pb.errors.body[0]"
              ></small>
            </div>

            <div class="d-flex justify-content-end">
              <div>
                <button class="btn btn-cancel" @click="cancelWhyPB">
                  Cancel
                </button>
                <button class="btn btn-purple-round" @click="saveWhyPB">
                  Save
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div id="subsidiaries" class="mt-4">
        <p class="font-weight-bold">PurpleBug Subsidiaries</p>

        <div class="partners-section edit--section">
          <about-subsidiaries ref="refSubsidiaries" />
        </div>
      </div>
    </div>

    <seo-form
      ref="seoForm"
      url="/cms/pages/update-seo/about"
      :data="seoContents"
      v-if="pageContents.length > 0"
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
import Subsidiaries from "../components/about/Subsidiaries";
import Contents from "../mixins/Contents";

export default {
  components: {
    PageLoader,
    "tinymce-editor": Editor,
    PreviewImageInput,
    "about-subsidiaries": Subsidiaries,
  },
  mixins: [Contents, Wysiwyg],

  data() {
    return {
      approach: {},
      why_pb: {},
      contentsUrl: "/cms/pages/about-contents",
      responses: [],
      disabled: false,
    };
  },

  watch: {
    pageContents: {
      handler(newContent, oldContent) {
        const why_pb = newContent.find(
          (content) => content.section == "why_purplebug"
        );
        this.why_pb = { ...why_pb };

        const approach = newContent.find(
          (content) => content.section == "our_approach"
        );
        this.approach = { ...approach };
      },
      deep: true,
    },
  },

  methods: {
    // OUR APPROACH SECTION
    cancelApproach() {
      if (this.approach.errors) {
        this.approach.errors = "";
      }

      this.pageContents.map((section) => {
        if (section.section == "our_approach") {
          this.approach.body = section.body ?? "";
        }
      });
    },

    async saveApproach(withFlash = true) {
      await axios
        .put("/cms/pages/about-us/our_approach", this.approach)
        .then(({ data }) => {
          this.pageContents.map((section) => {
            if (section.section == "our_approach") {
              section.body = this.approach.body;
            }
          });

          this.$delete(this.approach, "errors");

          if (withFlash) {
            flash(data.success);
          }

          return this.responses.push("success");
        })
        .catch(({ response }) => {
          this.$set(this.approach, "errors", response.data.errors);

          return this.responses.push("#ourApproach");
        });
    },

    // WHY PURPLEBUG SECTION
    cancelWhyPB() {
      if (this.why_pb.errors) {
        this.why_pb.errors = "";
      }

      this.pageContents.map((section) => {
        if (section.section == "why_purplebug") {
          this.why_pb.body = section.body ?? "";
        }
      });
    },

    async saveWhyPB(withFlash = true) {
      await axios
        .put("/cms/pages/about-us/why_purplebug", this.why_pb)
        .then(({ data }) => {
          this.pageContents.map((section) => {
            if (section.section == "why_purplebug") {
              section.body = this.why_pb.body;
            }
          });

          this.$delete(this.why_pb, "errors");

          if (withFlash) {
            flash(data.success);
          }

          return this.responses.push("success");
        })
        .catch(({ response }) => {
          this.$set(this.why_pb, "errors", response.data.errors);

          return this.responses.push("#whyPurple");
        });
    },

    async saveAll() {
      this.responses = [];
      this.disabled = true;

      await Promise.all([
        this.$refs.bannerForm.save(false),

        this.saveApproach(false),
        this.saveWhyPB(false),

        this.$refs.refSubsidiaries.subsidiaries.forEach(async (subsidiary) => {
          await this.$refs.refSubsidiaries.saveSubsidiary(subsidiary, false);
        }),

        this.$refs.seoForm.saveSeo(false),
      ]).then((response) => {
        this.disabled = false;

        if (this.responses.every((res) => res == "success")) {
          return flash("About Page has been updated!");
        }

        const errors = this.responses.filter((res) => res !== "success");
        const element = document.querySelector(errors[0]);

        return window.scrollTo({ top: element.offsetTop, behavior: "smooth" });
      });
    },

    cancelAll() {
      return location.reload();
    },
  },
};
</script>