import Vue from "vue";
import router from "./app-routes";
import VueI18n from "vue-i18n";
import { library } from "@fortawesome/fontawesome-svg-core";
import { faTimes, faSearch } from "@fortawesome/free-solid-svg-icons";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";

import App from "./App.vue";

require("animate.css");


library.add(faTimes, faSearch);
Vue.component("font-awesome-icon", FontAwesomeIcon);

Vue.config.productionTip = false;

Vue.use(VueI18n);

// Ready translated locale messages
const messages = {
  en: {
    navigation: {
      search: "Search",
      categories: "Categories",
    },
    post: {
      readMore: "Read more",
    },
    searchPage: {
      search: "Search",
      filterByCategories: "Filter by Categories",
      sortByDateOrder: "Sort by Date",
      placeholder: "Search in titles and excerpts for...",
    },
    categoriesPage: {
      allPosts: "All Posts",
      postsInCategory: "posts in category",
    },
    getPosts: {
      posts: "Posts",
      foundOf: "Found {numberOfResults} of {numberOfAllPosts}",
    },
  },
  hu: {
    navigation: {
      search: "Keresés",
      categories: "Kategóriák",
    },
    post: {
      readMore: "Tovább olvasom",
    },
    searchPage: {
      search: "Keresés",
      filterByCategories: "Szűrés kategórák szerint",
      sortByDateOrder: "Rendezés dátum szerint",
      placeholder: "Keresés a címekben és a kivonatokban...",
    },
    categoriesPage: {
      allPosts: "Összes bejegyzés",
      postsInCategory: "bejegyzés a kategóriában",
    },
    getPosts: {
      posts: "bejegyzés",
      foundOf: "{numberOfResults} találat {numberOfAllPosts} bejegyzésből",
    },
  },
};

const i18n = new VueI18n({
  locale: "hu", // set locale
  messages: messages, // set locale ui texts
});


new Vue({
  render: (h) => h(App),
  router,
  i18n
}).$mount("#vuecommerce-filter-products");
