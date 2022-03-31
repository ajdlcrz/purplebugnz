<template>
  <h1 class="loading" v-if="$parent.loading">
    <img src="/img/preloader.svg" />
    <!-- <img src="/img/preloader-2.svg" /> -->
  </h1>
</template>

<script>
export default {
  data() {
    return {
      //
    };
  },
};
</script>

<style lang="scss" scoped>
.loading {
  position: absolute;
  top: 50%;
  left: 50%;
  margin: -50px 0px 0px -50px;

  img {
    height: fit-content;
  }
}
</style>