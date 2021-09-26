<template>
<div>
 <select class="form-select" v-model="orderBy" aria-label="Default select example">
  <option selected>Select sorting option</option>
  <option value="date">Newest First</option>
  <option value="total_sales">Most Popular</option>
  <option value="price">Cheapest First</option>
  <option value="slug">In Alphabetical Order</option>
</select>
</div>

</template>

<script>
export default {
  data() {
    return {
      orderBy: 'date',
    };
  },

  watch: {
    // notify the parent component when an option selected
    orderBy(o) {
      this.$emit("onSelectOrderBy", o);
    },
  },
};
</script>

<style scoped>
</style>
