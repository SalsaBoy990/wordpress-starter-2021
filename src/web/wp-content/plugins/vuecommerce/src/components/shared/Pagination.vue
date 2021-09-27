<template>
  <nav :aria-label="paginationName">
    <ul class="pagination pagination-sm justify-content-center">
      <li :class="pageNumberProp === 1 ? 'page-item disabled' : 'page-item'">
        <span v-if="pageNumberProp === 1" class="page-link">Previous</span>
        <a v-else @click="decreasePageNumberByOne" class="page-link" href="#"
          >Previous</a
        >
      </li>
      <li
        v-for="n in maxPageNumber"
        :key="'page-' + n"
        ref="n"
        :class="n === pageNumberProp ? 'page-item active' : 'page-item'"
        :aria-current="n === pageNumberProp ? 'page' : null"
      >
        <a @click="setPageNumber($event, n)" class="page-link" href="">{{
          n
        }}</a>
      </li>
      <li
        :class="
          pageNumberProp === maxPageNumber ? 'page-item disabled' : 'page-item'"
      >
        <span v-if="pageNumberProp === maxPageNumber" class="page-link"
          >Next</span
        >
        <a v-else @click="increasePageNumberByOne" class="page-link" href="#"
          >Next</a
        >
      </li>
    </ul>
  </nav>
</template>

<script>
export default {
  data() {
    return {
      pageNumberProp: null,
    };
  },
  mounted() {
    this.pageNumberProp = this.pageNumber;
  },

  props: {
    paginationName: {
      type: String,
      required: true
    },
    pageNumber: {
      type: Number,
      required: true,
    },
    maxPageNumber: {
      validator: (p) => {
        return typeof p === "number" || p === null;
      },
      required: true,
    },
  },

  methods: {
    pageNumberPropEvent() {
      this.$emit("onChangePageNumber", parseInt(this.pageNumberProp, 10));
    },

    // change page in pagination
    setPageNumber($event, n) {
      $event.preventDefault();
      // array indexing is from 0, not 1 (in for range loop)
      const index = parseInt(n, 10) - 1;
      // get innerText from the selected ref
      this.pageNumberProp = parseInt(this.$refs.n[index].innerText);

      this.pageNumberPropEvent();
    },

    // prev button
    decreasePageNumberByOne() {
      this.pageNumberProp -= 1;

      this.pageNumberPropEvent();
    },

    // next button
    increasePageNumberByOne() {
      this.pageNumberProp += 1;

      this.pageNumberPropEvent();
    },
  },
};
</script>

<style scoped>
</style>
