<template>
  <div>
    <div
      class="career-selection career-selection-form no-gutters"
      v-if="isEdit"
      style="margin-top: 15px"
    >
      <div class="col-6 custom-select-career">
        <select
          class="custom-select e-input bg-transparent"
          v-model="newCareer"
        >
          <option value="null" selected disabled>Choose...</option>

          <option
            :value="career.slug"
            v-for="(career, index) in $parent.careers"
            :key="index"
            v-text="career.title"
          ></option>
        </select>
      </div>

      <div class="ml-auto">
        <button
          type="button"
          class="btn btn-outline-secondary rounded-0"
          @click="cancelEdit()"
        >
          Cancel <span>&times;</span>
        </button>

        <button
          type="button"
          class="btn btn-outline-purple rounded-0"
          @click="updatePosition()"
        >
          Done <span>&check;</span>
        </button>
      </div>
    </div>

    <div class="career-selection mt-2" v-else>
      <h1 class="selected-job" v-text="career.title"></h1>

      <button
        type="button"
        class="btn btn-outline-purple ml-auto"
        @click.prevent="isEdit = true"
      >
        Change
      </button>
    </div>

    <input name="position" type="hidden" :value="newCareer" />
  </div>
</template>

<script>
export default {
  data() {
    return {
      isEdit: false,
      career: {
        title: this.$parent.position.title,
        slug: this.$parent.position.slug,
      },
      newCareer: this.$parent.position.slug,
    };
  },

  methods: {
    updatePosition() {
      const selected = this.$parent.careers.find((career) => {
        return career.slug == this.newCareer;
      });

      this.isEdit = false;
      this.career = { title: selected.title, slug: selected.slug };
    },

    cancelEdit() {
      this.isEdit = false;
      this.newCareer = this.career.slug;
    },
  },
};
</script>
