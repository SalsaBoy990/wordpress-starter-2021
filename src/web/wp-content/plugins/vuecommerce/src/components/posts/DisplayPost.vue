<template>
  <div class="col">
    <div class="card h-100" :style="{ display: 'relative' }">
      <img
        :src="post.vue_meta.featuredmedia_url"
        class="card-img-top"
        :alt="post.vue_meta.featuredmedia_alt"
      />
      <div class="card-body">
        <h4 class="card-title">
          <a :href="post.link">
            {{ post.title.rendered }}
          </a>
        </h4>

        <p class="card-text" v-html="post.excerpt.rendered" />
        <a :href="post.link" class="btn btn-primary">{{
          $t("post.readMore")
        }}</a>
      </div>
      <span
        class="badge rounded-pill bg-secondary"
        :style="{ position: 'absolute', top: '10px', right: '10px' }"
        >{{ postDate }}</span
      >
    </div>
  </div>
</template>

<script>
export default {
  props: {
    post: {
      type: Object,
      required: true,
      default: null,
    },
  },
  computed: {
    postDate() {
      return this.post.date_gmt.split("T")[0];
    },
  },
};
</script>

<style scoped>
</style>
