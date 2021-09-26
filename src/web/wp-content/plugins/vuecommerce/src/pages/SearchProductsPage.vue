<template>
  <div id="search-page">
    <div class="row mt-4">
      <div v-if="screenWidth >= 768" class="col-3 col-md-3 col-lg-3 col-xxl-2">
        <!-- Filter Products by some Props -->
        <h3 class="h5">{{ $t("productsPage.filterByCategory") }}</h3>
        <FilterCategorySwitches
          @onSelectCategory="categoryIdsFilter = $event"
          :categories="productCategories"
        />

        <h3 class="h5 mt-4">{{ $t("productsPage.filterByPrice") }}</h3>
        <FilterPrice
          @onMaxPriceSelect="maxPrice = parseInt($event, 10)"
          @onMinPriceSelect="minPrice = parseInt($event, 10)"
          :highestPrice="highestPrice"
          :lowestPrice="lowestPrice"
        />

        <h3 class="h5 mt-4">{{ $t("productsPage.filterByOnSale") }}</h3>
        <FilterOnSale @onSaleToggle="onSale = $event" />

        <!-- End Filter Products by some Props -->

        <!-- Sort Products by Date -->
        <h3 class="h5 mt-4">{{ $t("productsPage.sortByProps") }}</h3>
        <SortProducts @onSelectOrderBy="orderBy = $event" />

        <!-- End Sort Products -->
      </div>
      <div class="col-12 col-sm-12 col-md-9 col-lg-9 col-xxl-10">
        <!-- Search for Products -->
        <Search @onChangeSearchTerm="searchTerm = $event" />

        <!-- End Search for Products -->
        <div v-if="screenWidth <= 767" class="mt-3 mb-3">
          <p>
            <button
              v-on:click="dropdownState"
              class="btn btn-sm btn-outline-secondary"
              type="button"
              data-bs-toggle="collapse"
              data-bs-target="#collapseDetailedSearch"
              aria-expanded="false"
              aria-controls="collapseDetailedSearch"
            >
              Részletes keresés/szűrés
               <font-awesome-icon :icon="['fas', dropdown === 'closed' ? 'chevron-down' : 'chevron-up']" :size="'1x'">
        </font-awesome-icon>
            </button>
          </p>

          <div class="collapse" id="collapseDetailedSearch">
            <!-- Filter Products by some Props -->
            <h3 class="h5">{{ $t("productsPage.filterByCategory") }}</h3>
            <FilterCategorySwitches
              @onSelectCategory="categoryIdsFilter = $event"
              :categories="productCategories"
            />

            <h3 class="h5 mt-4">{{ $t("productsPage.filterByPrice") }}</h3>
            <FilterPrice
              @onMaxPriceSelect="maxPrice = parseInt($event, 10)"
              @onMinPriceSelect="minPrice = parseInt($event, 10)"
              :highestPrice="highestPrice"
              :lowestPrice="lowestPrice"
            />

            <h3 class="h5 mt-4">{{ $t("productsPage.filterByOnSale") }}</h3>
            <FilterOnSale @onSaleToggle="onSale = $event" />

            <!-- End Filter Products by some Props -->

            <!-- Sort Products by Date -->
            <h3 class="h5 mt-4">{{ $t("productsPage.sortByProps") }}</h3>
            <SortProducts @onSelectOrderBy="orderBy = $event" />

            <!-- End Sort Products -->
          </div>
        </div>

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

  mounted() {
    this.screenWidth = window.innerWidth;
    window.addEventListener("resize", this.getScreenWidth);
  },
  deactivated() {
    this.dropdown = this.dropdown === 'closed' ? 'closed' : 'opened';
  },
  beforeDestroy() {
    window.removeEventListener("resize", this.getScreenWidth);
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
      orderBy: "date",
      /* eslint-disable no-undef */
      productCategories: wpData.product_categories,
      /* for responsive layout */
      screenWidth: null,
      // dropdown switch on/off
      dropdown: 'closed'
    };
  },
  methods: {
    clearSearchTerm() {
      this.searchTerm = "";
    },
    getScreenWidth() {
      this.screenWidth = window.innerWidth;
    },
    dropdownState() {
      this.dropdown = this.dropdown === 'closed' ? 'opened' : 'closed';
    }
  },
};
</script>

<style scoped>
</style>
