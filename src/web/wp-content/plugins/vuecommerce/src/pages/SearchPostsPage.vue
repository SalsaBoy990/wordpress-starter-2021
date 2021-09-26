<template>
  <div id="search-page">
    <div class="row mt-4">
      <div class="col-3 col-lg-3 col-xxl-2">
        <!-- Filter Posts by Categories -->
        <h2 class="h5">{{ $t("postsPage.filterByCategories") }}</h2>

        <FilterCategorySwitches
          :categories="wpCategories"
          @onSelectCategory="categoryIdsFilter = $event"
        />
        <!-- End Filter Posts by Categories -->

        <!-- Sort Posts by Date -->
        <h2 class="h5 mt-4">{{ $t("postsPage.sortByDateOrder") }}</h2>

        <Order @onOrderToggle="order = $event" />
        <!-- End Sort Posts by Date -->
      </div>
      <div class="col-9 col-lg-9 col-xxl-10">
        <!-- Search for Posts -->
        <Search @onChangeSearchTerm="searchTerm = $event" />
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
import GetPosts from "../services/posts/GetPosts.vue";
import FilterCategorySwitches from "../components/shared/FilterCategorySwitches.vue";
import Order from "../components/posts/Order.vue";
import Search from "../components/shared/Search.vue";

export default {
  name: "SearchPostsPage",
  components: {
    GetPosts,
    FilterCategorySwitches,
    Order,
    Search,
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
