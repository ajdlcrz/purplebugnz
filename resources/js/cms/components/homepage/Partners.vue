<template>
  <div class="partners-container">
    <div
      class="card col-md-11 mb-3"
      v-for="(partner, index) in partners"
      :key="index"
    >
      <div class="card-body row">
        <div class="col-md-3 d-flex flex-column">
          <label>Image</label>

          <div class="partner-image">
            <img
              class="img-fluid"
              :src="partners[index].tempImage"
              v-if="fileInstance(partners[index].image)"
            />

            <img class="img-fluid" :src="partners[index].imagePath" v-else />
          </div>
        </div>

        <div class="col-md-9">
          <form class="partner-details row">
            <div class="form-group col">
              <label>Alt Text</label>

              <input
                type="text"
                :class="`form-control ${
                  partners[index].errors && partners[index].errors.alt_text
                    ? 'is-invalid'
                    : ''
                }`"
                v-model="partners[index].alt_text"
              />

              <div
                class="invalid-feedback"
                v-if="partners[index].errors && partners[index].errors.alt_text"
                v-text="partners[index].errors.alt_text[0]"
              ></div>
            </div>

            <div class="form-group col">
              <label>Link</label>

              <input
                type="url"
                :class="`form-control ${
                  partners[index].errors && partners[index].errors.link
                    ? 'is-invalid'
                    : ''
                }`"
                v-model="partners[index].link"
              />

              <div
                class="invalid-feedback"
                v-if="partners[index].errors && partners[index].errors.link"
                v-text="partners[index].errors.link[0]"
              ></div>
            </div>
          </form>

          <div class="partnerCard-footer row no-gutters">
            <div class="partnerUpload col d-flex flex-column">
              <label>
                <button
                  class="btn btn-outline-purple-round align-self-start"
                  @click.prevent="selectPartnerImg(index)"
                >
                  Upload
                </button>

                <input
                  name="file"
                  type="file"
                  :ref="`partnerImage_${index}`"
                  class="d-none"
                  @change="onPartnerImgPick($event, index)"
                />
              </label>

              <small>Max of 2mb only</small>
              <small>197x123 px jpg or png</small>
              <small
                class="text-danger"
                v-if="partners[index].errors && partners[index].errors.image"
                v-text="partners[index].errors.image[0]"
              ></small>
            </div>

            <div class="col d-flex justify-content-between align-items-end">
              <button class="btn btn-remove" @click.prevent="destroy(partner)">
                <span class="icon-remove"></span>
                Remove
              </button>

              <div class="d-flex">
                <button
                  class="btn btn-cancel"
                  @click.prevent="initialData(partner)"
                >
                  Cancel
                </button>
                <button
                  class="btn btn-purple-round"
                  @click.prevent="savePartner(partner)"
                >
                  Save
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="card col-md-11 card-addMore mb-3">
      <button class="btn-addMore" @click="addPartner">
        <span class="icon-addMore"></span>
        <h3 class="mt-2 mb-0">Add</h3>
      </button>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      partners: [],
    };
  },

  created() {
    axios
      .get("/cms/pages/partners/records")
      .then(({ data }) => {
        const partners = Object.values(data.partners).map((partner, i) => {
          partner.originalData = { ...partner };

          return partner;
        });

        this.partners = partners;
      })
      .catch(({ response }) => {
        flash(response.data.message);
      });
  },

  methods: {
    addPartner() {
      this.partners.push({
        image: "",
        alt_text: "",
        link: "",
      });
    },

    initialData(partner) {
      const index = this.partners.indexOf(partner);
      const originalData = this.partners[index].originalData;

      if (originalData) {
        if (this.partners[index].errors) {
          this.partners[index].errors = "";
        }

        return Object.keys(originalData).map((attribute) => {
          this.partners[index][attribute] = originalData[attribute];
        });
      }

      return Object.keys(this.partners[index]).map((attribute) => {
        this.partners[index][attribute] = "";
      });
    },

    savePartner(partner, withFlash = true) {
      return partner.id
        ? this.update(partner, withFlash)
        : this.store(partner, withFlash);
    },

    async store(partner, withFlash) {
      const formData = new FormData();

      const data = Object.keys(partner).reduce((data, attribute) => {
        let value = partner[attribute];

        value
          ? formData.append(attribute, value)
          : formData.append(attribute, "");

        return formData;
      }, {});

      await axios
        .post(`/cms/pages/partners`, data)
        .then(({ data }) => {
          const index = this.partners.indexOf(partner);

          this.$delete(this.partners[index], "errors");

          Object.keys(data.partner).map((key) => {
            this.partners[index][key] = data.partner[key];
          });

          if (withFlash) {
            flash(data.success);
          }

          return this.$parent.responses.push("success");
        })
        .catch(({ response }) => {
          const index = this.partners.indexOf(partner);

          //https://vuejs.org/v2/guide/reactivity.html#Change-Detection-Caveats
          this.$set(this.partners[index], "errors", response.data.errors);

          return this.$parent.responses.push("#homepagePartners");
        });
    },

    async update(partner, withFlash) {
      const index = this.partners.indexOf(
        this.partners.find((v) => v.id == partner.id)
      );
      const formData = new FormData();

      const data = Object.keys(partner).reduce((data, attribute) => {
        let value = partner[attribute];

        value
          ? formData.append(attribute, value)
          : formData.append(attribute, "");

        return formData;
      }, {});

      formData.append("_method", "PUT");
      if (!(this.partners[index].image instanceof File)) {
        formData.delete("image");
      }

      await axios
        .post(`/cms/pages/partners/${partner.id}`, data)
        .then(({ data }) => {
          this.$delete(this.partners[index], "errors");

          Object.keys(this.partners[index]).map((key) => {
            this.partners[index][key] = data.partner[key];
          });

          if (withFlash) {
            flash(data.success);
          }

          return this.$parent.responses.push("success");
        })
        .catch(({ response }) => {
          const index = this.partners.indexOf(partner);

          this.$set(this.partners[index], "errors", response.data.errors);

          return this.$parent.responses.push("#homepagePartners");
        });
    },

    destroy(partner) {
      const index = this.partners.indexOf(partner);

      if (partner.id) {
        return axios
          .delete(`/cms/pages/partners/${partner.id}`)
          .then(({ data }) => {
            const index = this.partners.indexOf(
              this.partners.find((v) => v.id == partner.id)
            );

            this.$delete(this.partners, index);
            flash(data.success);
          })
          .catch(({ response }) => {
            flash(response.data.message);
          });
      }

      this.$delete(this.partners, index);
    },

    selectPartnerImg(index) {
      this.$refs[`partnerImage_${index}`][0].click();
    },

    onPartnerImgPick(event, index) {
      const files = event.target.files;
      const fileReader = new FileReader();

      fileReader.readAsDataURL(files[0]);

      this.partners[index].image = files[0];

      fileReader.onload = (evt) => {
        this.$set(this.partners[index], "tempImage", evt.target.result);
      };
    },

    fileInstance(file) {
      if (file instanceof File) {
        return true;
      }

      return false;
    },
  },
};
</script>

<style scoped>
/*  */
</style>