<template>

  <div id="vue-search-app">

    <AppNavigation>
      <!-- Load the App Navigation Component-->
    </AppNavigation>
    <keep-alive>
      <router-view>
        <!-- Load the router-view component provided by the vue-router plugin -->
      </router-view>
    </keep-alive>

  </div><!-- #vue-search-app -->

</template>

<script>
import AppNavigation from './components/AppNavigation';
export default {
	components: {
		AppNavigation
	}
};
</script>

<style>
</style>