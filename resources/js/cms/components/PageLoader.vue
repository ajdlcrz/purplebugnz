<template>
  <div class="pageLoader">
    <img class="pageLoader__img" src="/img/preloader-2.svg" />
  </div>
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
.pageLoader {
  position: absolute;
  height: 100%;
  width: 100%;
  z-index: 10;
  background-color: #eeeeee96;

  img {
    position: fixed;
    top: 50%;
    left: 50%;
    margin: -120px;
    height: 250px;
    width: 250px;
  }
}
</style>