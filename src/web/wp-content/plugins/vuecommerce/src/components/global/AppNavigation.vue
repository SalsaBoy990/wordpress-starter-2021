<template>
  <ul class="nav nav-tabs">
    <li class="nav-item">
      <router-link
        to="/search-posts"
        class="nav-link"
        active-class="active"
        role="link"
        >{{ $t("navigation.searchPosts") }}
      </router-link>
      <!-- .nav-item -->
    </li>
    <li class="nav-item">
      <router-link
        to="/post-categories"
        class="nav-link"
        active-class="active"
        role="link"
        >{{ $t("navigation.postCategories") }}
      </router-link>
      <!-- .nav-item -->
    </li>
    <li class="nav-item">
      <router-link
        to="/search-products"
        class="nav-link"
        active-class="active"
        role="link"
        >{{ $t("navigation.searchProducts") }}
      </router-link>
      <!-- .nav-item -->
    </li>
    <li class="nav-item">
      <router-link
        to="/product-categories"
        class="nav-link"
        active-class="active"
        role="link"
        >{{ $t("navigation.productCategories") }}
      </router-link>
      <!-- .nav-item -->
    </li>
  </ul>
</template>

<script>
export default {};
</script>

<style scoped>
</style>