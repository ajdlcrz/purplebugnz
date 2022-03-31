<template>
  <div>
    <preview-team-photo
      v-model="photo"
      @uploadSuccess="uploaded"
      @deletedPhoto="destroy"
    />
  </div>
</template>

<script>
import PreviewTeamPhoto from "./PreviewTeamPhoto";

export default {
  props: ["image"],
  components: {
    PreviewTeamPhoto,
  },

  data() {
    return {
      photo: this.image["data"],
    };
  },

  methods: {
    uploaded() {
      this.$parent.teamPhotos[this.image["index"]] = this.photo;
      this.$parent.teamPhotos.push("");
    },

    destroy() {
      //   const index = this.$parent.teamPhotos.findIndex(value => value.id == this.photo.id)
      const index = this.$parent.teamPhotos.indexOf(this.photo);
      this.$parent.$delete(this.$parent.teamPhotos, index);
    },
  },
};
</script>

<style scoped>
/*  */
</style>