import Vue from "vue";
import Router from "vue-router";
import SearchPostsPage from "./pages/SearchPostsPage";
import PostCategoriesPage from "./pages/PostCategoriesPage";

/*global wpData:true*/
/*eslint no-undef: "error"*/
const appPath = `/${wpData.app_path}`;

Vue.use(Router);

/**
 * Each route should map to a component.
 * The "component" can either be an actual component or just a component options object.
 */
export default new Router({
  base: appPath, // path of the SPA relative to the domain.
  mode: "hash", // or "history"
  routes: [
    {
      path: "/search",
      name: "SearchPostsPage",
      component: SearchPostsPage,
    },
    {
      path: "/categories",
      name: "PostCategoriesPage",
      component: PostCategoriesPage,
    },
    {
      path: "*",
      redirect: { name: "SearchPostsPage" },
    },
  ],
});
