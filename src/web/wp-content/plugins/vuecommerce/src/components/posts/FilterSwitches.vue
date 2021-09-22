<template>
  <div class="input-filters mb-2">
    <div
      v-for="(filter, index) in appFilters"
      :key="`${filterType}_${filter.slug}_${index}`"
      class="form-check form-switch"
    >
      <input
        :id="`${filterType}_${filter.slug}_${index}`"
        :name="filter.slug"
        :value="filter.term_id"
        :type="filterType"
        v-model="inputFilter"
        class="form-check-input mb-2"
      />
      <label
        :for="`${filterType}_${filter.slug}_${index}`"
        class="form-check-label"
        >{{ filter.name }}</label
      >
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      inputFilter: [],
    };
  },

  watch: {
    // notify the parent component when an input switch is toggled
    inputFilter(filter) {
      this.$emit("onFilterToggle", filter);
    },
  },

  props: {
    appFilters: {
      type: Array,
      required: true,
      default: null,
    },
    filterType: {
      type: String,
      default: "checkbox",
    },
  },
};
</script>

<style scoped>
</style>
