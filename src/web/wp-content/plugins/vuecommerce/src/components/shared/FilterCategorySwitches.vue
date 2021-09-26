<template>
  <div class="input-filters mb-2">
    <div
      v-for="(cat, index) in categories"
      :key="`${cat.slug}_${index}`"
      class="form-check form-switch"
    >
      <input
        class="form-check-input mb-2"
        type="checkbox"
        :id="`${cat.slug}_${index}`"
        :value="cat.term_id"
        v-model="category"
      />
      <label class="form-check-label" :for="`${cat.slug}_${index}`">
        {{ cat.name }}
      </label>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      category: [],
    };
  },

  watch: {
    // notify the parent component when an a radio option picked
    category(id) {
      this.$emit("onSelectCategory", id);
    },
  },

  props: {
    categories: {
      type: Array,
      required: true,
      default: null,
    },
  },
};
</script>

<style scoped>
</style>