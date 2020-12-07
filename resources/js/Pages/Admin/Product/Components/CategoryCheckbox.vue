<template>
  <div class="checkbox">
    <label>
      <input type="checkbox" name="category[]" form="insertForm" v-bind:value="category.category_id">
      <span class="text" v-html="category.name"></span>
    </label>
    <category-checkbox v-for="child_category in category.child_categories" v-bind:key="child_category.category_id" v-bind:category="child_category" />
  </div>
</template>

<script>
export default {
  name: 'category-checkbox',
  props: {
    category: Object
  },
  mounted() {
  }
}
</script>
