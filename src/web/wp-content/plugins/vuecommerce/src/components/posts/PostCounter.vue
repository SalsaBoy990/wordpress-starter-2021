<template>
  <div>
    <small class="text-muted" v-if="filteredResultsLength === wpPostsLength"
      >{{ wpPostsLength }} {{ $t("getPosts.posts") }}</small
    >
    <small class="text-muted" v-else>{{
      $t("getPosts.foundOf", {
        numberOfResults: filteredResultsLength,
        numberOfAllPosts: wpPostsLength,
      })
    }}</small>
  </div>
</template>

<script>
export default {
  props: {
    filteredResultsLength: {
      type: Number,
      required: true,
    },
    wpPostsLength: {
      type: Number,
      required: true,
    },
  },
};
</script>

<style scoped>
</style>
