<template>
  <div v-if="isDataAvailable">
    <!-- Show post / result count -->
    <Counter
      :filteredResultsLength="filteredNumberOfPosts"
      :wpPostsLength="totalNumberOfPosts"
    />
    <!-- End Show post / result count -->

    <!-- Display post items in grid -->
    <div
      class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xxl-4 g-4 my-4"
    >
      <DisplayPost
        v-for="post in wpPosts"
        :key="post.id"
        :post="post"
        role="article"
      />
    </div>
    <!-- End Display post items in grid -->
  </div>

  <!-- Display message and spinner when requesting data -->
  <LoadIndicator v-else :apiResponse="apiResponse" />
  <!-- End Display message and spinner when requesting data -->
</template>

<script>
import axios from "axios";
import DisplayPost from "../../components/posts/DisplayPost.vue";
import Counter from "../../components/shared/Counter.vue";
import LoadIndicator from "../../components/shared/LoadIndicator.vue";

export default {
  data() {
    return {
      apiResponse: "", // initial loading or error messages.
      wpPosts: [], // REST API response data goes here.
      filteredNumberOfPosts: null,
      totalNumberOfPosts: null,
      /* eslint-disable no-undef */
      wpData, // global data made available via wp_localize_script.
      isDataAvailable: false,
      maxPageNumber: null,
    };
  },

  props: {
    searchTerm: {
      type: String,
      default: "",
    },
    appFilters: {
      type: Array,
      default: null,
    },
    route: {
      type: String,
      default: "posts",
    },
    fetchNow: {
      type: Number,
      default: 1,
    },
    order: {
      type: String,
      default: "desc",
    },
    pageNumber: {
      type: Number,
      default: 1,
    },
  },

  components: {
    DisplayPost,
    Counter,
    LoadIndicator,
  },

  mounted() {
    // get posts from the WordPress REST API on component creation.
    this.fetchData();
  },

  watch: {
    // watch the prop fetchNow which changes when submit is clicked, and call the method this.fetchData()
    fetchNow: "fetchData",
    order: "fetchData",
    pageNumber: "fetchData",
    searchTerm: "fetchData",
    appFilters: "fetchData",

    maxPageNumber() {
      this.$emit("onMaxPageChange", parseInt(this.maxPageNumber, 10));
    },
  },

  methods: {
    // fetch posts only if fetchNow is greater than 0.
    fetchData() {
      if (0 < this.fetchNow) {
        this.isDataAvailable = false;
        this.getPosts(this.route, "wp/v2", this.order, this.pageNumber);
        this.apiResponse = " Loading... ";
      }
    },

    /* eslint-disable */
    async getPosts(
      route = "posts",
      namespace = "wp/v2",
      order = "desc",
      pageNumber = 1
    ) {
      try {
        /* Note: the per_page argument is capped at 100 records by the REST API.
         * https://developer.wordpress.org/rest-api/using-the-rest-api/pagination/
         */
        const restURL =
          process.env.NODE_ENV === "development"
            ? process.env.VUE_APP_REST_API_PATH
            : this.wpData.rest_url;
        const postsPerPage = process.env.VUE_APP_POSTS_PER_PAGE;
        const fields = "id,title,date_gmt,link,excerpt,vue_meta"; // retrieve data for specific fields only.

        // prepare the format to query posts by cat ids
        let categoryIdsSeparatedByComma = "";
        if (this.appFilters.length > 0) {
          this.appFilters.forEach((id, index) => {
            categoryIdsSeparatedByComma +=
              index < this.appFilters.length - 1 ? id + "," : id;
          });
        }

        // construct query
        let query = restURL + "/" + namespace + "/" + route + "?per_page=" + postsPerPage + "&page=" + pageNumber + "&_fields=" + fields + "&order=" + order;

        if (categoryIdsSeparatedByComma !== '') {
          query += ("&categories=" + categoryIdsSeparatedByComma);
        }
        if(this.searchTerm !== '') {
          query += ("&search=" + this.searchTerm)
        }

        // send request and await the response to get the posts.
        const response = await axios(query);

        // save data, make it available.
        this.wpPosts = response.data;
        this.isDataAvailable = true;

        // save the filtered number of posts
        this.filteredNumberOfPosts = parseInt(
          response.headers["x-wp-total"],
          10
        );

        // for the initial query, save the total number of all posts ever!
        if (!this.totalNumberOfPosts) {
          this.totalNumberOfPosts = parseInt(
            response.headers["x-wp-total"],
            10
          );
        }

        // how many pages needed for pagination
        this.maxPageNumber = parseInt(response.headers["x-wp-totalpages"], 10);

      } catch (error) {
        this.apiResponse = ` The request could not be processed! <br> <strong>${error}</strong> `;
      }
    },
  },
};
</script>

<style scoped>
</style>
