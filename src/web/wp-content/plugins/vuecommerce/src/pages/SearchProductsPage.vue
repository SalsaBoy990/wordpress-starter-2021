<template>
  <div id="search-page">
    <div class="row mt-4">
      <div class="col-3 col-lg-3 col-xxl-2">
        <!-- Filter Products by some Props -->
        <h3 class="h5">{{ $t('productsPage.filterByCategory')}}</h3>
        <FilterCategorySwitches
          @onSelectCategory="categoryIdsFilter = $event;"
          :categories="productCategories"
        />

        <h3 class="h5 mt-4">{{ $t('productsPage.filterByPrice')}}</h3>
        <FilterPrice
          @onMaxPriceSelect="maxPrice = parseInt($event, 10);"
          @onMinPriceSelect="minPrice = parseInt($event, 10);"
          :highestPrice="highestPrice"
          :lowestPrice="lowestPrice"
        />

        <h3 class="h5 mt-4">{{ $t('productsPage.filterByOnSale') }}</h3>
        <FilterOnSale @onSaleToggle="onSale = $event;" />

        <!-- End Filter Products by some Props -->

        <!-- Sort Products by Date -->
        <h3 class="h5 mt-4">{{ $t("productsPage.sortByProps") }}</h3>
        <SortProducts @onSelectOrderBy="orderBy = $event;" />

        <!-- End Sort Products by Date -->
      </div>
      <div class="col-9 col-lg-9 col-xxl-10">
        <!-- Search for Products -->
        <Search @onChangeSearchTerm="searchTerm = $event;" />

        <!-- End Search for Products -->

        <!-- Get Product List -->
        <GetProducts
          :searchTerm="searchTerm"
          :categoryFilters="categoryIdsFilter"
          :onSale="onSale"
          :maxPrice="maxPrice"
          :minPrice="minPrice"
          :orderBy="orderBy"
          @onGettingHighestPrice="highestPrice = parseInt($event)"
          @onGettingLowestPrice="lowestPrice = parseInt($event)"
        />
        <!-- End Get Product List -->
      </div>
    </div>
  </div>
</template>

<script>
import FilterCategorySwitches from "../components/shared/FilterCategorySwitches.vue";
import FilterOnSale from "../components/products/FilterOnSale.vue";
import FilterPrice from "../components/products/FilterPrice.vue";
import SortProducts from "../components/products/SortProducts.vue";
import Search from "../components/shared/Search.vue";
import GetProducts from "../services/products/GetProducts.vue";

export default {
  name: "SearchProductsPage",
  components: {
    FilterCategorySwitches,
    FilterOnSale,
    FilterPrice,
    SortProducts,
    Search,
    GetProducts,
  },
  data() {
    return {
      searchTerm: "",
      categoryIdsFilter: [],
      onSale: false,
      maxPrice: null,
      minPrice: null,
      highestPrice: null,
      lowestPrice: null,
      order: "desc",
      orderBy: 'date',
      /* eslint-disable no-undef */
      productCategories: wpData.product_categories,
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
