<template>
  <div>
    <div class="form-check">
      <input
        class="form-check-input"
        type="radio"
        id="desc-order"
        value="desc"
        v-model="order"
        checked
      />
      <label class="form-check-label" for="desc-order">
        {{ $t("postsPage.newestFirst") }}
      </label>
    </div>
    <div class="form-check">
      <input
        class="form-check-input"
        type="radio"
        id="asc-order"
        value="asc"
        v-model="order"
      />
      <label class="form-check-label" for="asc-order">
        {{ $t("postsPage.oldestFirst") }}
      </label>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      order: "desc",
    };
  },

  watch: {
    // notify the parent component when an a radio option picked
    order(order) {
      this.$emit("onOrderToggle", order);
    },
  },
};
</script>

<style scoped>
</style>
