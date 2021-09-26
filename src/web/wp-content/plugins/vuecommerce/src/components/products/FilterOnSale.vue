<template>
  <div class="form-check form-switch">
    <input
      class="form-check-input"
      type="checkbox"
      id="on-sale"
      :value="1"
      v-model="onSale"
    />
    <label class="form-check-label" for="on-sale">
      {{ $t("productsPage.discounted") }}</label
    >
  </div>
</template>

<script>
export default {
  data() {
    return {
      onSale: false,
    };
  },

  watch: {
    // notify the parent component when an a radio option picked
    onSale(sale) {
      this.$emit("onSaleToggle", sale);
    },
  },
};
</script>

<style scoped>
</style>
