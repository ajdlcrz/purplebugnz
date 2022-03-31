<template>
  <nav
    class="row no-gutters"
    aria-label="..."
    v-if="$parent.pagination && $parent.tableData.length > 0"
  >
    <ul class="pagination">
      <!-- first & prev -->
      <li class="page-item" :class="{ disabled: $parent.currentPage === 1 }">
        <a class="page-link prev" href="#" @click.prevent="$parent.changePage(1)">
          <span>&#171;</span>
        </a>
      </li>
      <li class="page-item" :class="{ disabled: $parent.currentPage === 1 }">
        <a
          class="page-link prev"
          href="#"
          @click.prevent="$parent.changePage($parent.currentPage - 1)"
        >
          <span class="icon-prev"></span>
        </a>
      </li>

      <!-- pages -->
      <li
        v-for="(page, key) in $parent.pagesNumber"
        class="page-item"
        :class="{
          active: page == $parent.pagination.meta.current_page,
        }"
        :key="key"
      >
        <a
          href="javascript:void(0)"
          @click.prevent="$parent.changePage(page)"
          class="page-link"
        >{{ page }}</a>
      </li>

      <!-- next & last -->
      <li
        class="page-item"
        :class="{
          disabled: $parent.currentPage === $parent.pagination.meta.last_page,
        }"
      >
        <a
          class="page-link next"
          href="#"
          @click.prevent="$parent.changePage($parent.currentPage + 1)"
        >
          <span class="icon-next"></span>
        </a>
      </li>
      <li
        class="page-item"
        :class="{
          disabled: $parent.currentPage === $parent.pagination.meta.last_page,
        }"
      >
        <a
          class="page-link next"
          href="#"
          @click.prevent="$parent.changePage($parent.pagination.meta.last_page)"
        >
          <span>&#187;</span>
        </a>
      </li>
    </ul>
  </nav>
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

<style scoped>
/*  */
</style>