<template>
  <ul class="nav nav-tabs">
    <li class="nav-item">
      <router-link
        to="/search"
        class="nav-link"
        active-class="active"
        role="link"
        >{{ $t("navigation.search") }}
      </router-link>
      <!-- .nav-item -->
    </li>
    <li class="nav-item">
      <router-link
        to="/categories"
        class="nav-link"
        active-class="active"
        role="link"
        >{{ $t("navigation.categories") }}
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