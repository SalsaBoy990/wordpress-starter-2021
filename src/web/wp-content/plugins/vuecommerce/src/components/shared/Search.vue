<template>
  <div class="search-field-container">
    <div class="input-group mb-1">
      <input
        v-model.lazy="searchTerm"
        type="text"
        class="form-control"
        :placeholder="$t('shared.placeholder')"
        :aria-label="$t('shared.placeholder')"
        aria-describedby="button-search"
      />
      <button class="btn btn-secondary" type="button" id="button-search">
        <font-awesome-icon :icon="['fas', 'search']" :size="'lg'">
        </font-awesome-icon>
        {{ $t("shared.search") }}
      </button>
    </div>

    <div class="clear-icon-container">
      <font-awesome-icon
        v-if="searchTerm"
        v-on:click="clearSearchTerm"
        :icon="['fas', 'times']"
        :size="'lg'"
        class="text-danger"
      >
      </font-awesome-icon>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      searchTerm: "",
    };
  },

  watch: {
    // notify the parent component when an input switch is toggled
    searchTerm(term) {
      this.$emit("onChangeSearchTerm", term);
    },
  },

  methods: {
    clearSearchTerm() {
      this.searchTerm = "";
    },
  },
};
</script>

<style scoped>
.search-field-container .clear-icon-container {
  position: absolute;
  right: 105px;
  top: 0px;
  z-index: 1000;
  padding: 8px;
  cursor: pointer;
}
.search-field-container {
  position: relative;
}
</style>
