<template>
  <div class="col">
    <div class="card h-100 d-flex text-center" :style="{ display: 'relative' }">
      <img
        :src="product.images[0].src"
        class="card-img-top"
        :alt="product.name"
      />
      <div class="card-body d-flex flex-column">
        <h4 class="card-title">
          <a :href="product.permalink">
            {{ product.name }}
          </a>
        </h4>
        <span v-if="product.on_sale === true" class="badge bg-danger sale"
          >%</span
        >
        <p class="card-text" v-html="product.short_description" />
        <p class="price mb-3" v-html="product.price_html" />

        <div class="add-to-cart-container mt-auto">
          <a
            v-if="product.external_url"
            :href="product.external_url"
            class="btn btn-primary"
            >{{ product.button_text }}</a
          >
          <a
            v-else-if="
              product.stock_quantity > 0 ||
              ((product.stock_quantity === null ||
                product.backorders_allowed) &&
                product.purchasable &&
                product.variations.length === 0)
            "
            :href="'?add-to-cart=' + product.id"
            :aria-label="'Add ' + product.name"
            data-quantity="1"
            :data-product_id="product.id"
            :data-product_sku="product.sku"
            rel="nofollow"
            class="
              wp-block-button__link
              add_to_cart_button
              btn btn-primary
              ajax_add_to_cart
              single_add_to_cart_button
            "
            data-bs-toggle="offcanvas"
            data-bs-target="#offcanvas-cart"
            >{{ "Add to cart" }}</a
          >
          <a v-else :href="product.permalink" class="btn btn-primary">{{
            "Select options"
          }}</a>
        </div>
      </div>
      <span
        class="badge rounded-pill bg-secondary"
        :style="{ position: 'absolute', top: '10px', right: '10px' }"
        >{{ productDate }}</span
      >
    </div>
  </div>
</template>

<script>
export default {
  props: {
    product: {
      type: Object,
      required: true,
      default: null,
    },
  },
  computed: {
    productDate() {
      return this.product.date_created.split("T")[0];
    },
  },
};
</script>

<style scoped>
</style>
