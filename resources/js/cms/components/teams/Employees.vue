<template>
  <div class="partners-container">
    <draggable :list="employees" ghost-class="ghost" @change="changeOrder">
      <div class="card mb-3" v-for="(employee, index) in employees" :key="index">
        <div class="card-body row">
          <div class="col-md-3 d-flex flex-column">
            <label>Image</label>

            <div class="partner-image">
              <img
                class="img-fluid"
                :src="employees[index].tempImage"
                v-if="fileInstance(employees[index].image)"
              />

              <img class="img-fluid" :src="employees[index].imagePath" v-else />
            </div>
          </div>

          <div class="col-md-9">
            <form class="partner-details row">
              <div class="form-group col">
                <label>Name</label>

                <input
                  type="text"
                  :class="`form-control ${
                  employees[index].errors && employees[index].errors.name
                    ? 'is-invalid'
                    : ''
                }`"
                  v-model="employees[index].name"
                />

                <div
                  class="invalid-feedback"
                  v-if="employees[index].errors && employees[index].errors.name"
                  v-text="employees[index].errors.name[0]"
                ></div>
              </div>

              <div class="form-group col">
                <label>Position</label>

                <input
                  type="text"
                  :class="`form-control ${
                  employees[index].errors && employees[index].errors.position
                    ? 'is-invalid'
                    : ''
                }`"
                  v-model="employees[index].position"
                />

                <div
                  class="invalid-feedback"
                  v-if="
                  employees[index].errors && employees[index].errors.position
                "
                  v-text="employees[index].errors.position[0]"
                ></div>
              </div>
            </form>

            <div class="partnerCard-footer row no-gutters">
              <div class="partnerUpload col d-flex flex-column">
                <label>
                  <button
                    class="btn btn-outline-purple-round align-self-start"
                    @click.prevent="selectEmployeeImg(index)"
                  >Upload</button>

                  <input
                    name="file"
                    type="file"
                    :ref="`employeeImage_${index}`"
                    class="d-none"
                    @change="onEmployeeImgPick($event, index)"
                  />
                </label>

                <small>Max of 2mb only</small>
                <small>640x413 px jpg or png</small>
                <small
                  class="text-danger"
                  v-if="employees[index].errors && employees[index].errors.image"
                  v-text="employees[index].errors.image[0]"
                ></small>
              </div>

              <div class="col d-flex justify-content-between align-items-end">
                <button class="btn btn-remove" @click.prevent="destroy(employee)">
                  <span class="icon-remove"></span>
                  Remove
                </button>

                <div class="d-flex">
                  <button class="btn btn-cancel" @click.prevent="initialData(employee)">Cancel</button>
                  <button class="btn btn-purple-round" @click.prevent="saveEmployee(employee)">Save</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </draggable>

    <div class="card card-addMore mb-3" style="max-height: 210px;">
      <button class="btn-addMore" @click="addEmployee">
        <span class="icon-addMore"></span>
        <h3 class="mt-2 mb-0">Add</h3>
      </button>
    </div>
  </div>
</template>

<script>
import draggable from "vuedraggable";

export default {
  order: 0,
  components: {
    draggable,
  },

  data() {
    return {
      employees: [],
    };
  },

  created() {
    this.fetchEmployees();
  },

  methods: {
    fetchEmployees() {
      axios
        .get("/cms/pages/our-teams/employees")
        .then(({ data }) => {
          const employees = Object.values(data.employees).map((employee, i) => {
            employee.originalData = { ...employee };

            return employee;
          });

          this.employees = employees;
        })
        .catch(({ response }) => {
          flash(response.data.message);
        });
    },

    changeOrder(e) {
      this.employees.map((employee, index) => {
        employee.order = index + 1;
      });

      /* axios
        .patch("/cms/pages/our-teams/updateAllEmployees", {
          employees: this.employees,
        })
        .then(({ data }) => {
          flash(data.success);
        })
        .catch(({ response }) => {
          flash(response.data.statusText, "error");
        }); */
    },

    addEmployee() {
      this.employees.push({
        image: "",
        name: "",
        position: "",
      });
    },

    initialData(employee) {
      const index = this.employees.indexOf(employee);
      const originalData = this.employees[index].originalData;

      if (originalData) {
        if (this.employees[index].errors) {
          this.employees[index].errors = "";
        }

        return Object.keys(originalData).map((attribute) => {
          this.employees[index][attribute] = originalData[attribute];
        });
      }

      return Object.keys(this.employees[index]).map((attribute) => {
        this.employees[index][attribute] = "";
      });
    },

    saveEmployee(employee, withFlash = true) {
      return employee.id
        ? this.update(employee, withFlash)
        : this.store(employee, withFlash);
    },

    async store(employee, withFlash) {
      const formData = new FormData();

      const data = Object.keys(employee).reduce((data, attribute) => {
        let value = employee[attribute];

        value
          ? formData.append(attribute, value)
          : formData.append(attribute, "");

        return formData;
      }, {});

      await axios
        .post(`/cms/pages/employees`, data)
        .then(({ data }) => {
          const index = this.employees.indexOf(employee);

          this.$delete(this.employees[index], "errors");

          Object.keys(data.employee).map((key) => {
            this.employees[index][key] = data.employee[key];
          });

          if (withFlash) {
            flash(data.success);
          }

          return this.$parent.responses.push("success");
        })
        .catch(({ response }) => {
          const index = this.employees.indexOf(employee);

          this.$set(this.employees[index], "errors", response.data.errors);

          return this.$parent.responses.push("#employeesList");
        });
    },

    async update(employee, withFlash) {
      const index = this.employees.indexOf(
        this.employees.find((v) => v.id == employee.id)
      );
      const formData = new FormData();

      const data = Object.keys(employee).reduce((data, attribute) => {
        let value = employee[attribute];

        value
          ? formData.append(attribute, value)
          : formData.append(attribute, "");

        return formData;
      }, {});

      formData.append("_method", "PUT");
      if (!(this.employees[index].image instanceof File)) {
        formData.delete("image");
      }

      await axios
        .post(`/cms/pages/employees/${employee.id}`, data)
        .then(({ data }) => {
          this.$delete(this.employees[index], "errors");

          Object.keys(this.employees[index]).map((key) => {
            this.employees[index][key] = data.employee[key];
          });

          if (withFlash) {
            flash(data.success);
          }

          return this.$parent.responses.push("success");
        })
        .catch(({ response }) => {
          const index = this.employees.indexOf(employee);

          this.$set(this.employees[index], "errors", response.data.errors);

          return this.$parent.responses.push("#employeesList");
        });
    },

    destroy(employee) {
      const index = this.employees.indexOf(employee);

      if (employee.id) {
        return axios
          .delete(`/cms/pages/employees/${employee.id}`)
          .then(({ data }) => {
            const index = this.employees.indexOf(
              this.employees.find((v) => v.id == employee.id)
            );

            this.$delete(this.employees, index);
            flash(data.success);
          })
          .catch(({ response }) => {
            flash(response.data.message);
          });
      }

      this.$delete(this.employees, index);
    },

    selectEmployeeImg(index) {
      this.$refs[`employeeImage_${index}`][0].click();
    },

    onEmployeeImgPick(event, index) {
      const files = event.target.files;
      const fileReader = new FileReader();

      fileReader.readAsDataURL(files[0]);

      this.employees[index].image = files[0];

      fileReader.onload = (evt) => {
        this.$set(this.employees[index], "tempImage", evt.target.result);
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
.ghost {
  opacity: 0.5;
  background: #dcc2dc;
}

.partners-container {
  grid-auto-rows: unset !important;
  cursor: grab;
}
</style>