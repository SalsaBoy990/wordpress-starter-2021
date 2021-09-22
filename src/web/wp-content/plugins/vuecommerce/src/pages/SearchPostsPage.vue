<template>
  <div id="search-page">
    <div class="row mt-4">
      <div class="col-3 col-lg-3 col-xxl-2">
        <!-- Filter Posts by Categories -->
        <h2 class="h5">{{ $t("searchPage.filterByCategories") }}</h2>

        <FilterSwitches
          :appFilters="wpCategories"
          @onFilterToggle="categoryIdsFilter = $event"
        />
        <!-- End Filter Posts by Categories -->

        <!-- Sort Posts by Date -->
        <h2 class="h5 mt-4">{{ $t("searchPage.sortByDateOrder") }}</h2>

        <SortResults @onOrderToggle="order = $event" />
        <!-- End Sort Posts by Date -->
      </div>
      <div class="col-9 col-lg-9 col-xxl-10">
        <!-- Search for Posts -->

        <SearchPosts @onChangeSearchTerm="searchTerm = $event" />
        <!-- End Search for Posts -->

        <!-- Get Post List -->
        <GetPosts
          :searchTerm="searchTerm"
          :appFilters="categoryIdsFilter"
          :order="order"
        />
        <!-- End Get Post List -->
      </div>
    </div>
  </div>
</template>

<script>
import GetPosts from "../components/posts/GetPosts.vue";
import FilterSwitches from "../components/posts/FilterSwitches.vue";
import SortResults from "../components/posts/SortResults.vue";
import SearchPosts from "../components/posts/SearchPosts.vue";

export default {
  name: "SearchPostsPage",
  components: {
    GetPosts,
    FilterSwitches,
    SortResults,
    SearchPosts,
  },
  data() {
    return {
      searchTerm: "",
      categoryIdsFilter: [],
      order: "desc",
      /* eslint-disable no-undef */
      wpCategories: wpData.post_categories,
    };
  },
  methods: {
    clearSearchTerm() {
      this.searchTerm = "";
    },
  },
};
</script>

<style scoped>
</style>
