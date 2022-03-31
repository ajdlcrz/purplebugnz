<template>
  <div class="cms-page-wrapper">
    <page-loader v-if="disabled" />

    <div class="cms-page homepage">
      <div class="header-title mb-4">
        <h1>Contact Us</h1>
      </div>

      <banner-form
        ref="bannerForm"
        url="/cms/pages/update-banner/contact"
        :data="bannerContents"
        v-if="pageContents.length > 0"
      />

      <div id="contactDetails" class="mt-4">
        <p class="font-weight-bold">Contact Details</p>

        <div
          class="partners-section edit--section"
          v-if="pageContents.length > 0"
        >
          <div class="partners-container">
            <div
              class="card mb-3"
              v-for="(contact, index) in contactDetails"
              :key="index"
            >
              <div class="card-body contact-wrapper">
                <form class="partner-details">
                  <div class="form-group">
                    <label>Heading</label>

                    <input
                      type="text"
                      :class="`form-control ${
                        contactDetails[index].errors &&
                        contactDetails[index].errors.heading
                          ? 'is-invalid'
                          : ''
                      }`"
                      v-model="contactDetails[index].heading"
                    />

                    <div
                      class="invalid-feedback"
                      v-if="
                        contactDetails[index].errors &&
                        contactDetails[index].errors.heading
                      "
                      v-text="contactDetails[index].errors.heading[0]"
                    ></div>
                  </div>

                  <div class="form-group">
                    <label>Details</label>

                    <div
                      class="d-flex mb-2"
                      v-for="(detail, key) in contact.details"
                      :key="key"
                    >
                      <input
                        type="text"
                        required
                        :class="`form-control`"
                        v-model="contactDetails[index].details[key]"
                      />

                      <button
                        type="button"
                        class="btn btn-sm btn-link"
                        @click="removeDetail({ index, key })"
                      >
                        <span class="icon-remove"></span>
                      </button>
                    </div>
                  </div>

                  <button
                    type="button"
                    class="btn btn-outline-purple btn-block"
                    @click.prevent="addMoreDetails(index)"
                  >
                    + Add
                  </button>
                </form>

                <div class="partnerCard-footer row no-gutters">
                  <div
                    class="align-items-center align-items-end col d-flex justify-content-between mt-4"
                  >
                    <button
                      class="btn btn-sm btn-remove"
                      @click.prevent="removeContact(contact)"
                    >
                      <span class="icon-remove"></span>
                      Remove
                    </button>

                    <div class="d-flex">
                      <button
                        class="btn btn-sm btn-cancel"
                        @click.prevent="initialData(contact)"
                      >
                        Cancel
                      </button>
                      <button
                        class="btn btn-sm btn-purple-round"
                        @click.prevent="save(contact)"
                      >
                        Save
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="card card-addMore mb-3">
              <button class="btn-addMore" @click="addContact">
                <span class="icon-addMore"></span>
                <h3 class="mt-2 mb-0">Add</h3>
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <seo-form
      ref="seoForm"
      url="/cms/pages/update-seo/contact"
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
import Contents from "../mixins/Contents";

export default {
  components: { PageLoader },
  mixins: [Contents],

  data() {
    return {
      contactDetails: [],
      contentsUrl: "/cms/pages/contact-contents",
      responses: [],
      disabled: false,
    };
  },

  watch: {
    pageContents: {
      handler(newContent, oldContent) {
        const details = this.pageContents.find(
          (content) => content.section == "contact_details"
        );

        const contents = JSON.parse(JSON.stringify(details.contents));

        const contacts = contents.map((contact, i) => {
          contact.originalData = JSON.parse(JSON.stringify(contact));

          return contact;
        });

        this.contactDetails = contacts;
      },
      deep: true,
    },
  },

  methods: {
    initialData(contact) {
      const index = this.contactDetails.indexOf(contact);
      const originalData = this.contactDetails[index].originalData;

      if (this.contactDetails[index].errors) {
        this.contactDetails[index].errors = "";
      }

      if (originalData) {
        return Object.keys(originalData).map((attribute) => {
          if (typeof originalData[attribute] === "object") {
            return (this.contactDetails[index][attribute] = JSON.parse(
              JSON.stringify(originalData[attribute])
            ));
          }

          this.contactDetails[index][attribute] = originalData[attribute];
        });
      }

      return Object.keys(this.contactDetails[index]).map((attribute) => {
        this.contactDetails[index].heading = "";
        this.contactDetails[index].details = [""];
      });
    },

    addMoreDetails(index) {
      this.contactDetails[index].details.push("");
    },

    removeDetail(contact) {
      this.$delete(this.contactDetails[contact.index].details, contact.key);
    },

    addContact() {
      this.contactDetails.push({
        heading: "",
        details: [""],
        id: Math.random().toString(36).substr(2, 9),
      });
    },

    removeContact(contact) {
      const index = this.contactDetails.indexOf(contact);

      if (contact.originalData) {
        return axios
          .delete(`/cms/pages/contact-delete/${contact.id}`)
          .then(({ data }) => {
            const index = this.contactDetails.indexOf(
              this.contactDetails.find((v) => v.id == contact.id)
            );

            this.$delete(this.contactDetails, index);
            flash(data.success);
          })
          .catch(({ response }) => {
            flash(response.data.message);
          });
      }

      this.$delete(this.contactDetails, index);
    },

    async save(contact, withFlash = true) {
      const index = this.contactDetails.indexOf(contact);

      if (
        this.contactDetails[index].details.includes("") ||
        this.contactDetails[index].details.length < 1
      ) {
        this.responses.push("#contactDetails");
        return flash("Please fill out all the contact details", "danger");
      }

      await axios
        .put("/cms/pages/contact-update", contact)
        .then(({ data }) => {
          this.$delete(this.contactDetails[index], "errors");

          Object.keys(data.contact).map((key) => {
            this.contactDetails[index][key] = data.contact[key];
          });

          if (withFlash) {
            flash(data.success);
          }

          return this.responses.push("success");
        })
        .catch(({ response }) => {
          this.$set(this.contactDetails[index], "errors", response.data.errors);

          return this.responses.push("#contactDetails");
        });
    },

    async saveAll() {
      this.responses = [];
      this.disabled = true;

      await Promise.all([
        await this.$refs.bannerForm.save(false),

        this.contactDetails.forEach(async (contact, index) => {
          await this.save(contact, false);
        }),

        this.$refs.seoForm.saveSeo(false),
      ]).then((res) => {
        this.disabled = false;

        if (this.responses.every((res) => res == "success")) {
          return flash("Contact Us Page has been updated!");
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

<style lang="scss" scoped>
.edit--section {
  max-height: unset;
}

.partners-container {
  grid-template-columns: repeat(3, 1fr);
  grid-gap: 10px;

  .btn-remove,
  .btn-cancel {
    min-width: unset;
  }

  .btn-purple-round {
    min-width: 100px;
  }

  .card-addMore {
    height: unset;
    .btn-addMore {
      height: 100%;
    }
  }

  .contact-wrapper {
    max-height: 360px;
    overflow: auto;
  }
}
</style>