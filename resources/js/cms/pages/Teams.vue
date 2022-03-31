<template>
  <div class="cms-page-wrapper">
    <page-loader v-if="disabled" />

    <div class="cms-page homepage">
      <div class="header-title mb-4">
        <h1>Our Team</h1>
      </div>

      <banner-form
        ref="bannerForm"
        url="/cms/pages/update-banner/teams"
        :data="bannerContents"
        v-if="pageContents.length > 0"
      />

      <div id="teamPhotos" class="mt-4">
        <p class="font-weight-bold">Team Photos</p>

        <div class="card mt-3" style="height: 60vh; overflow: auto">
          <div class="card-body photos-list">
            <team-photo
              v-for="(photo, index) in teamPhotos"
              :key="photo.image ? photo.image : index"
              :image="{ data: teamPhotos[index], index }"
            />
          </div>
        </div>
      </div>

      <div class="row no-gutters">
        <div id="whoWheAre" class="col-md-6 mt-4">
          <p class="font-weight-bold">
            Who We Are
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
                  v-model="whoWeAre.body"
                ></tinymce-editor>

                <small
                  class="text-danger"
                  v-if="whoWeAre.errors && whoWeAre.errors.body"
                  v-text="whoWeAre.errors.body[0]"
                ></small>
              </div>

              <div class="d-flex justify-content-end">
                <div>
                  <button class="btn btn-cancel" @click="cancelWhoWe">Cancel</button>
                  <button class="btn btn-purple-round" @click="savewhoWe">Save</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div id="executives" class="mt-4">
        <p class="font-weight-bold">Executives</p>

        <div class="card" v-if="pageContents.length > 0">
          <div class="card-body">
            <div class="card mb-3" v-for="(executive, index) in executivesList" :key="index">
              <form action>
                <div class="card-body row">
                  <div class="col-md-3 d-flex flex-column">
                    <label>Image</label>

                    <div class="partner-image mb-2">
                      <img
                        class="img-fluid"
                        :src="`${executivesList[index].tempImage}`"
                        v-if="fileInstance(executivesList[index].image)"
                      />

                      <img
                        class="img-fluid"
                        :src="`${
                          executivesList[index].image
                            ? `/storage/teams/executives/${executivesList[index].image}`
                            : ''
                        }`"
                        v-else
                      />
                    </div>

                    <!-- upload button -->
                    <div class="d-flex border" v-if="fileInstance(executivesList[index].image)">
                      <input
                        type="text"
                        class="form-control w-100 border-0"
                        readonly
                        :ref="`executiveImage_${index}`"
                        :value="executivesList[index].image.name"
                      />

                      <button
                        type="button"
                        class="btn btn-link"
                        style="min-width: 0"
                        @click="removeExecutiveImg(index)"
                      >
                        <span>✖</span>
                      </button>
                    </div>

                    <label v-else>
                      <button
                        class="btn btn-outline-purple-round w-100"
                        @click.prevent="selectExecutiveImg(index)"
                      >Upload</button>

                      <input
                        class="d-none"
                        name="file"
                        type="file"
                        :ref="`executiveImage_${index}`"
                        @change="onExecutiveImgPick($event, index)"
                      />
                    </label>

                    <small>Max of 2mb only</small>
                    <small>631x688 px jpg or png</small>
                    <small
                      class="text-danger"
                      v-if="
                        executivesList[index].errors &&
                        executivesList[index].errors.image
                      "
                      v-text="executivesList[index].errors.image[0]"
                    ></small>
                  </div>

                  <div class="col-md-9 row">
                    <div class="col-md-5">
                      <div class="form-group">
                        <label>Name</label>

                        <input
                          type="text"
                          :class="`form-control ${
                            executivesList[index].errors &&
                            executivesList[index].errors.name
                              ? 'is-invalid'
                              : ''
                          }`"
                          v-model="executivesList[index].name"
                        />

                        <div
                          class="invalid-feedback"
                          v-if="
                            executivesList[index].errors &&
                            executivesList[index].errors.name
                          "
                          v-text="executivesList[index].errors.name[0]"
                        ></div>
                      </div>

                      <div class="form-group">
                        <label>Position</label>

                        <input
                          type="text"
                          :class="`form-control ${
                            executivesList[index].errors &&
                            executivesList[index].errors.position
                              ? 'is-invalid'
                              : ''
                          }`"
                          v-model="executivesList[index].position"
                        />

                        <div
                          class="invalid-feedback"
                          v-if="
                            executivesList[index].errors &&
                            executivesList[index].errors.position
                          "
                          v-text="executivesList[index].errors.position[0]"
                        ></div>
                      </div>
                    </div>

                    <div class="col-md-7">
                      <div class="form-group">
                        <label>Body</label>

                        <tinymce-editor
                          api-key="q5eqi5jopju01p1l2xpwn411by2u4oxvo9men2va1eey6m4w"
                          rows="5"
                          :init="tinymceInit()"
                          v-model="executivesList[index].body"
                        ></tinymce-editor>

                        <small
                          class="text-danger"
                          v-if="
                            executivesList[index].errors &&
                            executivesList[index].errors.body
                          "
                          v-text="executivesList[index].errors.body[0]"
                        ></small>

                        <div class="d-flex justify-content-end mt-3">
                          <button
                            class="btn btn-cancel"
                            @click.prevent="cancelExecutive(index)"
                          >Cancel</button>
                          <button
                            class="btn btn-purple-round ml-2"
                            @click.prevent="saveExecutive(index)"
                          >Save</button>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>

      <div id="employeesList" class="mt-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <h6 class="m-0">Employees</h6>

          <div class="d-flex justify-content-end">
            <button
              class="btn btn-cancel"
              @click.prevent="$refs.refEmployees.fetchEmployees()"
            >Cancel</button>
            <button class="btn btn-purple-round ml-2" @click.prevent="saveEmployees">Save</button>
          </div>
        </div>

        <div class="partners-section edit--section">
          <team-employees ref="refEmployees" />
        </div>
      </div>

      <div id="joinOurTeam" class="mt-4">
        <p class="font-weight-bold">
          Join Our Team
          <small class="icon-edit ml-2"></small>
        </p>

        <div class="card">
          <div class="card-body">
            <div class="row mb-3">
              <div class="col-md-6 d-flex flex-column">
                <label>Body</label>

                <tinymce-editor
                  api-key="q5eqi5jopju01p1l2xpwn411by2u4oxvo9men2va1eey6m4w"
                  rows="10"
                  :init="tinymceInit()"
                  v-model="joinOurTeam.body"
                ></tinymce-editor>

                <small
                  class="text-danger"
                  v-if="joinOurTeam.errors && joinOurTeam.errors.body"
                  v-text="joinOurTeam.errors.body[0]"
                ></small>
              </div>

              <div class="col-md-6">
                <div class="form-group mb-0">
                  <label>Link</label>
                  <input
                    type="text"
                    :class="`form-control ${
                      joinOurTeam.errors && joinOurTeam.errors.link
                        ? 'is-invalid'
                        : ''
                    }`"
                    v-model="joinOurTeam.link"
                  />

                  <div
                    class="invalid-feedback"
                    v-if="joinOurTeam.errors && joinOurTeam.errors.link"
                    v-text="joinOurTeam.errors.link[0]"
                  ></div>
                </div>
              </div>
            </div>

            <div class="d-flex justify-content-end">
              <div>
                <button class="btn btn-cancel" @click="cancelJoinTeam">Cancel</button>
                <button class="btn btn-purple-round" @click="saveJoinTeam">Save</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <seo-form
      ref="seoForm"
      url="/cms/pages/update-seo/teams"
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
import Contents from "../mixins/Contents";
import Employees from "../components/teams/Employees";
import TeamPhoto from "../components/teams/TeamPhoto";

export default {
  mixins: [Contents, Wysiwyg],
  components: {
    "tinymce-editor": Editor,
    "team-employees": Employees,
    PageLoader,
    TeamPhoto,
  },

  data() {
    return {
      whoWeAre: {},
      executivesList: {},
      joinOurTeam: {},
      teamPhotos: [],
      contentsUrl: "/cms/pages/teams-contents",
      responses: [],
      disabled: false,
    };
  },

  created() {
    this.fetchTeamPhotos();
  },

  watch: {
    pageContents: {
      handler(newContent, oldContent) {
        const whoWeAre = newContent.find(
          (content) => content.section == "who_we_are"
        );
        this.whoWeAre = { ...whoWeAre };

        const executives = this.pageContents.find(
          (content) => content.section == "executives"
        );
        this.executivesList = JSON.parse(JSON.stringify(executives.contents));

        const joinOurTeam = newContent.find(
          (content) => content.section == "join_our_team"
        );
        this.joinOurTeam = JSON.parse(JSON.stringify(joinOurTeam.contents));
      },
      deep: true,
    },
  },

  methods: {
    // TEAM PHOTOS SECTION
    fetchTeamPhotos() {
      axios.get("/cms/pages/our-teams/photos").then(({ data }) => {
        this.teamPhotos = data.photos;
        this.teamPhotos.push("");
      });
    },

    // WHO WE ARE SECTION
    cancelWhoWe() {
      if (this.whoWeAre.errors) {
        this.whoWeAre.errors = "";
      }

      this.pageContents.map((section) => {
        if (section.section == "who_we_are") {
          this.whoWeAre.body = section.body;
        }
      });
    },

    async savewhoWe(withFlash = true) {
      await axios
        .put("/cms/pages/our-teams/who_we_are", this.whoWeAre)
        .then(({ data }) => {
          this.pageContents.map((section) => {
            if (section.section == "who_we_are") {
              section.body = this.whoWeAre.body;
            }
          });

          this.$delete(this.whoWeAre, "errors");

          if (withFlash) {
            flash(data.success);
          }

          return this.responses.push("success");
        })
        .catch(({ response }) => {
          this.$set(this.whoWeAre, "errors", response.data.errors);

          return this.responses.push("#whoWheAre");
        });
    },

    // EXECUTIVES SECTION
    cancelExecutive(index) {
      const executive = this.executivesList[index];
      const originalData = this.pageContents.find(
        (content) => content.section == "executives"
      ).contents[index];

      if (executive.errors) {
        executive.errors = "";
      }

      Object.keys(originalData).map((attribute) => {
        this.executivesList[index][attribute] = originalData[attribute];
      });
    },

    async saveExecutive(index, withFlash = true) {
      const executive = this.executivesList[index];

      const formData = new FormData();
      const data = Object.keys(executive).reduce((data, attribute) => {
        let value = executive[attribute];

        value
          ? formData.append(attribute, value)
          : formData.append(attribute, "");

        return formData;
      }, {});

      formData.append("_method", "PUT");
      formData.append("index", index);
      formData.delete("errors");
      if (!(executive.image instanceof File)) {
        formData.delete("image");
      }

      await axios
        .post(`/cms/pages/our-teams/executives`, data)
        .then(({ data }) => {
          this.$delete(executive, "errors");

          const originalData = this.pageContents.find(
            (content) => content.section == "executives"
          ).contents[index];

          Object.keys(originalData).map((key) => {
            originalData[key] = data.executive[key];
            this.executivesList[index][key] = data.executive[key];
          });

          if (withFlash) {
            flash(data.success);
          }

          return this.responses.push("success");
        })
        .catch(({ response }) => {
          this.$set(executive, "errors", response.data.errors);

          return this.responses.push("#executives");
        });
    },

    selectExecutiveImg(index) {
      this.$refs[`executiveImage_${index}`][0].click();
    },

    onExecutiveImgPick(event, index) {
      const files = event.target.files;
      const fileReader = new FileReader();

      fileReader.readAsDataURL(files[0]);

      this.executivesList[index].image = files[0];

      fileReader.onload = (evt) => {
        this.$set(this.executivesList[index], "tempImage", evt.target.result);
      };
    },

    removeExecutiveImg(index) {
      const originalData = this.pageContents.find(
        (content) => content.section == "executives"
      ).contents[index];

      this.executivesList[index].image = originalData.image;

      this.$delete(this.executivesList[index], "tempImage");
    },

    fileInstance(file) {
      if (file instanceof File) {
        return true;
      }

      return false;
    },

    // JOIN OUR TEAM SECTION
    cancelJoinTeam() {
      if (this.joinOurTeam.errors) {
        this.joinOurTeam.errors = "";
      }

      this.pageContents.map((section) => {
        if (section.section == "join_our_team") {
          console.log(section);
          this.joinOurTeam.body = section.contents.body;
          this.joinOurTeam.link = section.contents.link;
        }
      });
    },

    async saveJoinTeam(withFlash = true) {
      await axios
        .put("/cms/pages/our-teams/join_our_team", this.joinOurTeam)
        .then(({ data }) => {
          this.pageContents.map((section) => {
            if (section.section == "join_our_team") {
              section.contents.body = this.joinOurTeam.body;
              section.contents.link = this.joinOurTeam.link;
            }
          });

          this.$delete(this.joinOurTeam, "errors");

          if (withFlash) {
            flash(data.success);
          }

          return this.responses.push("success");
        })
        .catch(({ response }) => {
          this.$set(this.joinOurTeam, "errors", response.data.errors);

          return this.responses.push("#joinOurTeam");
        });
    },

    // EMPLOYEES SECTION
    async saveEmployees() {
      this.responses = [];
      this.disabled = true;

      await Promise.all(
        this.$refs.refEmployees.employees.map(async (employee) => {
          await this.$refs.refEmployees.saveEmployee(employee, false);
        })
      ).then((res) => {
        this.disabled = false;

        if (this.responses.every((res) => res == "success")) {
          return flash("Employees has been updated!");
        }

        const errors = this.responses.filter((res) => res !== "success");
        const element = document.querySelector(errors[0]);

        return window.scrollTo({ top: element.offsetTop, behavior: "smooth" });
      });
    },

    async saveAll() {
      this.responses = [];
      this.disabled = true;

      await Promise.all([
        this.$refs.bannerForm.save(false),

        this.savewhoWe(false),

        this.executivesList.forEach(async (executive, index) => {
          await this.saveExecutive(index, false);
        }),

        await this.saveJoinTeam(false),

        await this.$refs.seoForm.saveSeo(false),

        await Promise.all(
          this.$refs.refEmployees.employees.map(async (employee) => {
            await this.$refs.refEmployees.saveEmployee(employee, false);
          })
        ),
      ]).then((res) => {
        this.disabled = false;

        if (this.responses.every((res) => res == "success")) {
          return flash("Our Team Page has been updated!");
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

<style scoped>
.photos-list {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
  grid-gap: 5px;
}

.partner-image {
  height: 100%;
  background-color: #7070700d;
  display: flex;
  justify-content: center;
  align-items: center;
}

.partners-section {
  max-height: 90vh;
}
</style>